<?php


namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class FightersTable extends Table {

    public function getBestFighter() {
        return $this->find('all')->order('level')->first();
    }

    public function getFighters() {
        return $this->find('all')->toArray();
    }

    public function move($dir, $playerid, $fighterid) {
        $dirToCo = array();
        switch ($dir){
            case 'up':
                $dirToCo = array("x"=>0, "y"=>-1);
                break;
            case 'down':
                $dirToCo = array("x"=>0, "y"=>1);
                break;
            case 'left':
                $dirToCo = array("x"=>-1, "y"=>0);
                break;
            case 'right':
                $dirToCo = array("x"=>1, "y"=>0);
                break;
        }
        
        $fightersTable = TableRegistry::get('Fighters');
        $fighter = $fightersTable->get($fighterid);//ici on utilise fighterid en tant que clé

        $nextPos = array('x'=>$fighter->coordinate_x += $dirToCo["x"], 'y'=>$fighter->coordinate_y += $dirToCo["y"]);
        
        $fighter->coordinate_x = $nextPos["x"];
        $fighter->coordinate_y = $nextPos["y"];
        $fightersTable->save($fighter);
        }
    

}
