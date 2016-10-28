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
        
        public function getFightersByPlayer($playerId){
           $fighters = $this
           ->find()
           ->where(['player_id' => '545f827c-576c-4dc5-ab6d-27c33186dc3e']);
		   
           return $fighters;
        }   
}