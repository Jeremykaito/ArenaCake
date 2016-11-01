<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class SurroundingsTable extends Table {

    /*Fonctions pour trouver des décors*/

    public function getSurroundings() {
        $yo = $this->find('all')->toArray();
        return $yo;
    }

    public function getSurroundingByCo($x, $y) {
        $yo = $this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->first();
        return $yo;
    }

    /*Fonctions pour gérer les décors*/

    public function addSurrounding($x, $y, $type) {

        $Surrounding = $this->newEntity();

        $Surrounding->coordinate_x = $x;
        $Surrounding->coordinate_y = $y;
        $Surrounding->type = $type;

        $this->save($Surrounding);
    }

    public function removeSurrounding($co){
        //Création d'un évènement
        $eventsTables = TableRegistry::get('Events');
        $eventsTables->createEvent('Un monstre est mort.', $co['x'], $co['y']);

        $this->delete($this->getSurroundingByCo($co['x'], $co['y']));
    }

    public function flushSurroundings() {
        $this->deleteAll(['type' => 'W']);
        $this->deleteAll(['type' => 'T']);
        $this->deleteAll(['type' => 'P']);
    }

    public function exist($x, $y) {
        if (empty($this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->toArray())) {
            $exist = false;
        } else {
            $exist = true;
        }
        return $exist;
    }

    /*Fonctions utilitaires*/

    public function generateSurroundings() {

        //On détruit tous les décors
        $this->flushSurroundings();

        //On charge les modèles
        $fightersTable = TableRegistry::get('Fighters');
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundings');

        //On remplit la carte de décors
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 15; $j++) {
                if (!$fightersTable->exist($j, $i) && !$toolsTable->exist($j, $i) && !$surroundingsTable->exist($j, $i)) {
                    $r = rand(0, 90);
                    switch ($r) {
                        case 12:
                            $this->addSurrounding($j, $i, 'P'); //Colonne
                            break;
                        case 15:
                            $this->addSurrounding($j, $i, 'W'); //monstre
                            break;
                        case 18:
                            $this->addSurrounding($j, $i, 'T'); //trous
                            break;
                    }
                }
            }
        }
    }

}
