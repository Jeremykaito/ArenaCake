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

        $this->save($tool);
    }
    
    public function dropTool($fighterid){
        $fightersTable = TableRegistry::get('Fighters');
        $fighter = $fightersTable->getFighterById($fighterid);
        $tool = $this->find()->where(['fighter_id' => $fighterid])->first();
        $tool->coordinate_x = $fighter->coordinate_x;
        $tool->coordinate_y = $fighter->coordinate_y;
        $tool->fighter_id = null;
        
        $this->save($tool);
        
        //Création d'un évènement
        $eventsTables = TableRegistry::get('Events');
        $eventsTables->createEvent($fighter->name.' a laché un équipement.',$fighter->coordinate_x,$fighter->coordinate_y);
    }
    
    public function takeTool($j, $i, $fighterid) {
        /*
         * on part du principe qu'un fighter ne peut avoir qu'un seul tool 
         */
        $this->dropTool($fighterid);
        $tool = $this->find()->where(['coordinate_x' => $j, 'coordinate_y' => $i])->first();
        $tool->fighter_id = $fighterid;
        $tool->coordinate_x = NULL;
        $tool->coordinate_y = NULL;
        $this->save($tool);
        
        //Création d'un évènement
        $eventsTables = TableRegistry::get('Fighters');
        $eventsTables = TableRegistry::get('Events');
        $currentfighter = $this->getFighterById($fighterid);
        $eventsTables->createEvent($fighter->name.' a ramassé un équipement.',$j,$i);
    }

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

    public function generateTools() {
        $this->flushTools();

        $fightersTable = TableRegistry::get('Fighters');
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundings');

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
