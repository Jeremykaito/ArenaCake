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

        //On récupère l'id du joueur connecté
        $playerId = $this->Auth->user('id');

        //On récupère tous les combattants du joueur
        $this->loadModel('Fighters');
        $fighters = $this->Fighters->getFightersByPlayer($playerId)->toArray();

        //On récupère l'id du combattant actuel
        $PlayerId = $this->request->session()->read('PlayerLoggedIn')['id'];

        //On écrit en session le combattant sélectionné
        $varFighterNumber = $this->Fighters->getSelectedFighter();
        $this->request->session()->write("PlayerFighterId", $varFighterNumber);

        //On écrit dans la session l'avatar choisi
        $session = $this->request->session();
        $session->write('PlayerFighterSkin', "rogue");

        //On envoie les combattants à la vue
        $this->set(compact('fighters'));
    }

    public function sight() {
        
        //S'il n'a pas choisi de combattant, on le redirige sur la page champions
        if (!$this->request->session()->read('PlayerFighterId')) {
            $this->Flash->error(__('Veuillez choisir un combattant.'));
            return $this->redirect(['action' => 'fighter']);
        } 
        
        //S'il a choisi un combattant, il peut jouer
        else {
            // On récupère le combattant et son avatar depuis la session
            $PlayerFighterId = $this->request->session()->read('PlayerFighterId');
            $PlayerFighterSkin = $this->request->session()->read('PlayerFighterSkin');

            //On charge les modèles
            $this->loadModel('Fighters');
            $this->loadModel('Tools');
            $this->loadModel('Surroundings');

            //On récupère le combattant actuel
            $currentFighter = $this->Fighters->getFighterById($PlayerFighterId);

            //Gestion des actions du joueur :
            if ($this->request->is('post')) {

                //Déplacement
                if ($this->request->data['action'] == 'move') {
                    $this->Fighters->move($this->request->data['dir'], $currentFighter);
                }

                //Attaque
                if ($this->request->data['action'] == 'attack') {
                    $this->Fighters->attack($this->request->data['dir'], $currentFighter);
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

            /* Envoi des données à la vue */
            //On envoie le terrain de jeu
            $viewtab = $this->Fighters->createViewTab($currentFighter);
            $this->set("viewtab", $viewtab);

            //On envoie l'avatar du combattant
            $this->set("PlayerFighterSkin", $PlayerFighterSkin);

            //On envoie le combattant
            $fighter = $this->Fighters->getFighterById($PlayerFighterId);
            $this->set(compact('fighter', $fighter));

            //On envoie les objets du combattant
            $tools = $this->Tools->getToolsByFighter($PlayerFighterId);
            $this->set(compact('tools', $tools));
        }
    }

    public function diary() {

        //On récupère l'id du joueur connecté
        $playerId = $this->Auth->user('id');

        //On récupère tous les évènements de moins de 24h
        $this->loadModel('Events');
        $allevents = $this->Events->getEvents24h();

        //On récupère les évènements à portée de vue des personnages du joueur
        $this->loadModel('Fighters');
        $events = $this->Fighters->getEventByFighter($playerId, $allevents);

        //On envoie les évènements à la vue
        $this->set(compact('events'));
    }

    public function fighterEdit($id) {

        //On récupère le combattant à modifier
        $this->loadModel('Fighters');
        $fighter = $this->Fighters->get($id);

        //Si le formulaire n'est pas vide
        if ($this->request->is(['patch', 'post', 'put'])) {

            //On modifie l'entité
            $this->Fighters->patchEntity($fighter, $this->request->data(), ['validate' => false]);

            //On sauvegarde la modification
            if ($this->Fighters->save($fighter)) {
                $this->Flash->success(__('Vos modifications ont bien été enregistrées'));
                return $this->redirect(['action' => 'fighter']);
            } else {
                $this->Flash->error(__('Un problème est survenu, veuillez réessayer.'));
            }
        }

        //On envoie le combattant à la vue
        $this->set('fighter', $fighter);
    }

    public function fighterDelete($id) {

        $this->request->allowMethod(['post', 'delete']);

        //On récupère le combattant à supprimer
        $this->loadModel('Fighters');
        $fighter = $this->Fighters->get($id);

        //On supprime le combattant
        if ($this->Fighters->delete($fighter)) {
            $this->Flash->success(__('Le combattant a bien été supprimé.'));
        } else {
            $this->Flash->error(__('Impossssible de supprimer le personnage, veuillez réessayer.'));
        }

        //On redirige vers la page champions
        return $this->redirect(['action' => 'fighter']);
    }

    public function fighterNew() {

        //Si le formulaire est rempli
        if ($this->request->is('post')) {

            //On charge le modèle fighter
            $this->loadModel('Fighters');

            //On crée un nouveau combattant
            $fighter = $this->Fighters->newEntity();

            //On renseigne l'id avec celle du joueur connecté
            $fighter->player_id = $this->request->session()->read('PlayerLoggedIn')['id'];

            //On entre les données entrées dans le formulaire
            $fighter = $this->Fighters->patchEntity($fighter, $this->request->data);

            //On sauvegarde le combattant
            if ($this->Fighters->save($fighter)) {
                $this->Flash->success(__('Votre personnage a bien été crée.'));

                //On redirige vers la page combattants
                return $this->redirect(['action' => 'fighter']);
            } else {
                $this->Flash->error(__('Impossssible de créer le personnage, veuillez réessayer.'));
            }
        }

        //On envoie le combattant à la vue
        $this->set('fighter', $fighter);
    }

}
