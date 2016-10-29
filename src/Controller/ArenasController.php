<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class ArenasController extends AppController {

    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index']);
    }
    
    public function index() {
        
    }

    public function fighter() {
        $playerId = $this->Auth->user('id');
        $this->loadModel('Fighters');
        $fighters = $this->Fighters->getFightersByPlayer($playerId);
        $this->set(compact('fighters'));
    }

    public function sight() {
        
    }

    public function diary() {
        
        //On récupère l'id du joueur connecté
        $playerId = $this->Auth->user('id');
        
        //On récupère les personnages de ce joueur
        $this->loadModel('Fighters');
        $fighters = $this->Fighters->getFightersByPlayer('545f827c-576c-4dc5-ab6d-27c33186dc3e');
        
        //On récupère tous les évènements de moins de 24h
        $this->loadModel('Events');
        $allevents=$this->Events->getEvents24h();
        
        //On récupère les évènements à proximité des personnages du joueur
        $events =$this->Fighters->getEventByFighter($fighters,$allevents);
        
        //On envoie les évènements à la vue
        $this->set(compact('events'));
    }
}
