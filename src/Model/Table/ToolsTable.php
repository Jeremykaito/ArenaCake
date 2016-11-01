<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class ToolsTable extends Table {
    /* Fonctions pour trouver des objets */

    public function getTools() {
        $yo = $this->find('all')->toArray();
        return $yo;
    }

    public function getToolsByFighter($fighterId) {
        $tools = $this
                ->find()
                ->where(['fighter_id' => $fighterId]);

        return $tools;
    }

    /* Fonctions pour gérer les objets */

    public function addTool($x, $y, $type, $bonus) {

        $tool = $this->newEntity();

        $tool->coordinate_x = $x;
        $tool->coordinate_y = $y;
        $tool->type = $type;
        $tool->bonus = $bonus;

        $this->save($tool);
    }

    public function dropTool($fighterid) {

        //On récupère le combattant concerné
        $fightersTable = TableRegistry::get('Fighters');
        $fighter = $fightersTable->getFighterById($fighterid);

        //On récupère l'objet que le combattant détient
        $tool = $this->find()->where(['fighter_id' => $fighterid])->first();
        if (!empty($tool)) {//si le fighter a un équipement
            //On "dépose" l'objet à la place du combattant
            $tool->coordinate_x = $fighter->coordinate_x;
            $tool->coordinate_y = $fighter->coordinate_y;
            $tool->fighter_id = null;

            //On sauvegarde l'objet
            $this->save($tool);

            //Création d'un évènement
            $eventsTables = TableRegistry::get('Events');
            $eventsTables->createEvent($fighter->name . ' a laché un équipement.', $fighter->coordinate_x, $fighter->coordinate_y);
        }
    }

    public function takeTool($j, $i, $fighterid) {

        /* On part du principe qu'un combattant ne peut avoir qu'un seul objet */

        //On récupère l'objet qui se trouve à la place du joueur
        $tool = $this->find()->where(['coordinate_x' => $j, 'coordinate_y' => $i])->first();

        //Le combattant lâche son objet
        $this->dropTool($fighterid);

        //On lui ajoute l'id du combattant
        $tool->fighter_id = $fighter->id;
        $tool->coordinate_x = NULL;
        $tool->coordinate_y = NULL;
        $this->save($tool);

        //Création d'un évènement

        $eventsTables = TableRegistry::get('Events');
        $eventsTables->createEvent($fighter->name . ' a ramassé un équipement.', $j, $i);
    }

    /* Fonctions utilitaires */

    public function getBonus($id, $type) {
        $tool = $this->find()->where(['fighter_id' => $id, 'type' => $type])->first();
        if (empty($tool)) {
            $bonus = 0;
        } else {
            $bonus = $tool->bonus;
        }
        return $bonus;
    }

    public function flushTools() {
        $this->deleteAll(['fighter_id IS' => NULL]);
    }

    public function exist($x, $y) {
        if (empty($this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->toArray())) {
            $exist = false;
        } else {
            $exist = true;
        }
        return $exist;
    }

    public function generateTools() {

        //On détruit tous les objets
        $this->flushTools();

        //On charge les modèles
        $fightersTable = TableRegistry::get('Fighters');
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundings');

        //On remplit la carte d'objets
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 15; $j++) {
                if (!$fightersTable->exist($j, $i) && !$toolsTable->exist($j, $i) && !$surroundingsTable->exist($j, $i)) {
                    $r = rand(0, 90);
                    switch ($r) {
                        case 12:
                            $this->addTool($j, $i, 'V', 1); //vue  lunettes
                            break;
                        case 15:
                            $this->addTool($j, $i, 'D', 1); //force  epee
                            break;
                        case 18:
                            $this->addTool($j, $i, 'L', 1); //vie   armure
                            break;
                    }
                }
            }
        }
    }

}
