<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

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
        $fighters = $this->Fighters->getFightersByPlayer($playerId)->toArray();
       
        $PlayerFighterId = $this->request->session()->read('PlayerLoggedIn')['id'];
        $this->set("PlayerFighterId", $PlayerFighterId);
        
        /* set default value of skin */
        $session = $this->request->session();
        $session->write('PlayerFighterSkin', "rogue");
        
        $this->set(compact('fighters'));
    }

    public function sight() {
        
        // On récupère le combattant et son avatar depuis la session
        $PlayerFighterId    = 3; //A modifier
        $PlayerFighterSkin  = $this->request->session()->read('PlayerFighterSkin');

        //On charge les modèles
        $this->loadModel('Fighters');
        $this->loadModel('Tools');
        $this->loadModel('Surroundings');
        
        //Gestion des actions du joueur :
        if ($this->request->is('post')) {
            
            //Déplacement
            if ($this->request->data['action'] == 'move') {
                $this->Fighters->move($this->request->data['dir'], $PlayerFighterId);
            }
            
            //Attaque
            if ($this->request->data['action'] == 'attack') {
                $this->Fighters->attack($this->request->data['dir'], $PlayerFighterId);
            }
            
            //Génération d'objets
            if ($this->request->data['action'] == 'generateTools') {
                $this->Tools->generateTools();
            }
            
            //Génération de décors
            if ($this->request->data['action'] == 'generateSurroundings') {
                $this->Surroundings->generateSurroundings();
            }
        }
        
        /*Envoi des données à la vue*/
        
        //On envoie le terrain de jeu
        $viewtab = $this->Fighters->createViewTab();
        $this->set("viewtab", $viewtab);
        
        //On envoie l'avatar du combattant
        $this->set("PlayerFighterSkin", $PlayerFighterSkin);
        
        //On envoie le combattant
        $fighter=$this->Fighters->getFighterById($PlayerFighterId);
        $this->set(compact('fighter',$fighter));
        
        //On envoie les objets du combattant
        $tools=$this->Tools->getToolsByFighter($PlayerFighterId);
        $this->set(compact('tools',$tools));
    }

    public function diary() {

        //On récupère l'id du joueur connecté
        $playerId = $this->Auth->user('id');
        
        //On récupère tous les évènements de moins de 24h
        $this->loadModel('Events');
        $allevents=$this->Events->getEvents24h();
        
        //On récupère les évènements à portée de vue des personnages du joueur
        $this->loadModel('Fighters');
        $events =$this->Fighters->getEventByFighter($playerId,$allevents);

        //On envoie les évènements à la vue
        $this->set(compact('events'));
    }

    public function fighterEdit($id) {

        $this->loadModel('Fighters');
        $fighter = $this->Fighters->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->Fighters->patchEntity($fighter, $this->request->data(), ['validate'=>false]);
            if ($this->Fighters->save($fighter)) {
                $this->Flash->success(__('Vos modifications ont bien été enregistrées'));
                return $this->redirect(['action' => 'fighter']);
            } else {
                $this->Flash->error(__('Un problème est survenu, veuillez réessayer.'));
            }
        }

        $this->set('fighter',$fighter);
    }

    public function fighterDelete($id) {
        $this->request->allowMethod(['post', 'delete']);
        $this->loadModel('Fighters');
        $fighter = $this->Fighters->get($id);
        if ($this->Fighters->delete($fighter)) {
            $this->Flash->success(__('Le combattant a bien été supprimé.'));
        } else {
            $this->Flash->error(__('Impossssible de supprimer le personnage, veuillez réessayer.'));
        }

        return $this->redirect(['action' => 'fighter']);
    }
    
    public function fighterNew(){
        
        $this->loadModel('Fighters');
        $fighter = $this->Fighters->newEntity();
        
        $fighter->player_id = $this->request->session()->read('PlayerLoggedIn')['id'];
        $fighter->coordinate_x =5;
        $fighter->coordinate_y =5;
        $fighter->skill_sight = 2 ;
        $fighter->skill_strength= 1;
        $fighter->skill_health=3;
        $fighter->current_health=3;
        $fighter->next_action_time=Time::now();
        $fighter->guild_id=NULL;
        
        
        if ($this->request->is('post')) {
            $fighter = $this->Fighters->patchEntity($fighter, $this->request->data);
            if ($this->Fighters->save($fighter)) {
                $this->Flash->success(__('Votre personnage a bien été crée.'));
                return $this->redirect(['action' => 'fighter']);
            } else {
                $this->Flash->error(__('Impossssible de créer le personnage, veuillez réessayer.'));
            }
        }
        
        $this->set('fighter',$fighter);
    }

}
