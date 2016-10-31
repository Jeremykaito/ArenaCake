<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class ToolsTable extends Table {

    public function exist($x, $y) {
        if (empty($this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->toArray())) {
            $exist = false;
        } else {
            $exist = true;
        }
        return $exist;
    }

    public function getTools() {
        $yo = $this->find('all')->toArray();
        return $yo;
    }

    public function addTool($x, $y, $type, $bonus) {
        /* $toolsTable = TableRegistry::get('Tools');
          $tool = $toolsTable->newEntity(); */

        $tool = $this->newEntity();

        $tool->coordinate_x = $x;
        $tool->coordinate_y = $y;
        $tool->type = $type;
        $tool->bonus = $bonus;

        $this->save();
    }

    public function takeTool($j, $i, $fighterid) {
        /*
         * attention il reste à gérer le nb max de tool par fighter, l'écrasement des tools en trop...etc
         */
        $tool = $this->find()->where(['coordinate_x' => $j, 'coordinate_y' => $i])->first();
        $tool->fighter_id = $fighterid;
        $tool->coordinate_x = null;
        $tool->coordinate_y = null;
        $tool->save();
    }

    public function getBonus($id, $type) {
        /*
         * attention, en fonction du nb de tool autorisé par fighter etc. à modifier
         * ici, fonction si il n'y a qu'un seul tool par fighter
         */
        $tool = $this->find()->where(['fighter_id' => $id, 'type' => $type])->toArray();
        if (empty($tool)) {
            $bonus = 0;
        } else {
            $bonus = $tool['bonus'];
        }
        return $bonus;
    }

    public function generateTools($gametab) {
        /* $this->loadModel('Fighters');
          $this->loadModel('Tools');
          $this->loadModel('Surroundings'); */
        $fightersTable = TableRegistry::get('Fighters');
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundins');
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 15; $j++) {
                if (!$fightersTable->exsit($j, $i) && !$toolsTable->exsit($j, $i) && !$surroundingsTable->exsit($j, $i)) {
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