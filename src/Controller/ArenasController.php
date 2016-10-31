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

        /* set default value of skin */
        $session = $this->request->session();
        $session->write('PlayerFighterSkin', "rogue");
    }

    public function sight() {
        $this->loadModel('Fighters');
        $this->loadModel('Tools');
        $this->loadModel('Surroundings');
        $viewtab = $this->Fighters->cerateViewTab();
        $this->set("viewtab", $viewtab);


        //déplacements:
        if ($this->request->is('post')) {
            if ($this->request->data['action'] == 'move') {
                $this->Fighters->move($this->request->data['dir'], 1); // le deuxième paramètre est le fighter id
            }
            if ($this->request->data['action'] == 'attack') {
                $this->Fighters->attack($this->request->data['dir'], 1); // le deuxième paramètre est le fighter id
            }
            if ($this->request->data['action'] == 'generateTools') {
                $this->Tools->generateTools();
            }
            if ($this->request->data['action'] == 'generateSurroundings') {
                $this->Surroundings->generateSurroundings();
            }
        }
    }

    public function diary() {

        //On récupère l'id du joueur connecté
        $playerId = $this->Auth->user('id');

        //On récupère les personnages de ce joueur
        $this->loadModel('Fighters');
        $fighters = $this->Fighters->getFightersByPlayer('545f827c-576c-4dc5-ab6d-27c33186dc3e');

        //On récupère tous les évènements de moins de 24h
        $this->loadModel('Events');
        $allevents = $this->Events->getEvents24h();

        //On récupère les évènements à proximité des personnages du joueur
        $events = $this->Fighters->getEventByFighter($fighters, $allevents);

        //On envoie les évènements à la vue
        $this->set(compact('events'));
    }

    public function fighterEdit($id = null) {

        $this->loadModel('Fighters');
        $fighter = $this->Fighters->get($id);

        if ($this->request->is('post')) {
            pr($this->request->data);
            $this->Fighters->patchEntity($fighter, $this->request->data);
            if ($this->Fighters->save($fighter)) {
                $this->Flash->success(__('Vos modifications ont bien été enregistrées'));
                return $this->redirect(['action' => 'fighter']);
            } else {
                $this->Flash->error(__('Un problème est survenu, veuillez reéssayer.'));
            }
        }

        $this->set(compact('fighter'));
    }

    public function fighterDelete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $this->loadModel('Fighters');
        $fighter = $this->Fighters->get($id);
        if ($this->Fighters->delete($fighter)) {
            $this->Flash->success(__('Le combattant a bien été supprimé.'));
        } else {
            $this->Flash->error(__('Impossssible de supprimé le personnage, veuillez réessayeer.'));
        }

        return $this->redirect(['action' => 'fighter']);
    }

}
