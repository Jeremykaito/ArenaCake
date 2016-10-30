<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class EventsTable extends Table {

    public function getEvents24h() {
        $events = $this
           ->find('all', array('conditions' => array('Events.date BETWEEN NOW() -INTERVAL 1 DAY AND NOW()')));
        return $events;
    }
}
