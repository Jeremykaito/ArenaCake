<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class EventsTable extends Table {

    public function getEvents24h() {
       
        $events = $this
           ->find('all', array('conditions' => array('Events.date BETWEEN NOW() -INTERVAL 1 DAY AND NOW()')));
        return $events;
    }
    
    public function getEvents() {
        $events = $this->find('all')->toArray();
        return $events;
    }
    
    public function createEvent($name, $coordinate_x, $coordinate_y) {
        $event=$this->newEntity(['name'=>$name,'date'=>date('Y-m-d H:i:s'),'coordinate_x'=>$coordinate_x,'coordinate_y'=>$coordinate_y]);
        $this->save($event);
        
    }
}
