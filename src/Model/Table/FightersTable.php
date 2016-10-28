<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class FightersTable extends Table
{
        public function getBestFighter(){
            return $this->find('all')->order('level')->first();
        }
        
        public function getFighters(){
            return $this->find('all')->toArray();
        }
}