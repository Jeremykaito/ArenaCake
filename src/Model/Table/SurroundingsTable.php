<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class SurroundingsTable extends Table {

    public function exist($x, $y) {
        if (empty($this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->toArray())) {
            $exist = false;
        } else {
            $exist = true;
        }
        return $exist;
    }

    public function getSurroundings() {
        $yo = $this->find('all')->toArray();
        return $yo;
    }

    public function getSurroundingByCo($x, $y) {
        $yo = $this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->toArray();
        return $yo;
    }

    public function addSurrounding($x, $y, $type) {

        $Surrounding = $this->newEntity();

        $Surrounding->coordinate_x = $x;
        $Surrounding->coordinate_y = $y;
        $Surrounding->type = $type;

        $this->save($Surrounding);
    }

    public function flushSurroundings() {
        $this->deleteAll(['type' => 'W']);
        $this->deleteAll(['type' => 'T']);
        $this->deleteAll(['type' => 'P']);
    }

    public function generateSurroundings() {
        $this->flushSurroundings();

        $fightersTable = TableRegistry::get('Fighters');
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundings');

        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 15; $j++) {
                if (!$fightersTable->exist($j, $i) && !$toolsTable->exist($j, $i) && !$surroundingsTable->exist($j, $i)) {
                    $r = rand(0, 90);
                    switch ($r) {
                        case 12:
                            $this->addSurrounding($j, $i, 'P'); //colonne
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
