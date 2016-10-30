<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FightersTable extends Table {

    public function getBestFighter() {
        return $this->find('all')->order('level')->first();
    }

    public function getFighters() {
        return $this->find('all')->toArray();
    }
    
    public function getFighterByID($id){
        $fighter = $this
                ->find()
                ->where(['id' => $id]);
        return $fighter;
    }
    
    public function getFightersByPlayer($playerId) {
        $fighters = $this
                ->find()
                ->where(['player_id' => $playerId]);

        return $fighters;
    }
    
    public function checkCoordinates($coord1X,$coord1Y,$coord2X,$coord2Y){
        if(abs($coord1X-$coord2X) + abs($coord1Y-$coord2Y) <2 ){
          return true;  
        }
        else{
            return false;
        }
    }
    
    public function getEventByFighter($fighters,$events){
        
       $found_events=array();
       $i=0;

       foreach ($events as $event):
           foreach ($fighters as $fighter):
                if ($this->checkCoordinates($fighter->coordinate_x, $fighter->coordinate_y,$event->coordinate_x,$event->coordinate_y)){
                   if (!in_array($event, $found_events)){
                       $found_events[$i]=$event;
                       $i++;
                   }
                }
           endforeach;
       endforeach; 
       
       return $found_events;
    }
    
}
