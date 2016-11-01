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
        $fighterslist = $this->Fighters->getFightersByPlayer($playerId)->find('list');

        //Gère la recupération des infos depuis la vue
        if ($this->request->is('post')) {
            if ($this->request->data['type'] == 'choose') {
                //On récupère l'avatar et le fighter utilisés
                $varFighterNumber = $this->request->data['name'];
                $varFighterSkin = $this->request->data['avatar'];

                //On écrit dans la session l'id et l'avatar du combattant choisi
                $session = $this->request->session();
                $session->write('PlayerFighterId', $varFighterNumber);
                $session->write('PlayerFighterSkin', $varFighterSkin);
            }
            if ($this->request->data['type'] == 'upgrade') {

                $fightertoUp = $this->Fighters->getFighterById($this->request->session()->read('PlayerFighterId'));
                $skilltoUpgrade=($this->request->data['skills']);
                if(!empty($fightertoUp)){
                    switch ($skilltoUpgrade){
                        case 'skill_health': $this->Fighters->updateSkillHealth($fightertoUp,3); break;
                        case 'skill_strength': $this->Fighters->updateSkillStrength($fightertoUp,1) ; break;
                        case 'skill_sight': $this->Fighters->updateSkillSight($fightertoUp,1); break;
                    }
                $this->Flash->success(__('Amélioration effectué!'));
                }else{
                    $this->Flash->error(__('Veuillez choisir un combattant'));
                }
            }
            
        }

        //On envoie les combattants à la vue
        $this->set('playerfighters', $fighters);
        $this->set('fighterslist', $fighterslist);
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
            $this->loadModel('Events');

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
                
                //Ramasser objets
                if ($this->request->data['action'] == 'pickup') {
                    $this->Tools->takeTool($currentFighter->coordinate_x, $currentFighter->coordinate_y, $currentFighter);
                }
            }

            /* Envoi des données à la vue si le joueur n'est pas mort */
            if ($this->Fighters->getFighterById($PlayerFighterId)) {
                
                //On envoie le terrain de jeu
                $viewtab = $this->Fighters->createViewTab($currentFighter,$PlayerFighterSkin);
                $this->set("viewtab", $viewtab);

                //On envoie l'avatar du combattant
                $this->set("PlayerFighterSkin", $PlayerFighterSkin);

                //On envoie le combattant
                $fighter = $this->Fighters->getFighterById($PlayerFighterId);
                $this->set(compact('fighter', $fighter));

                //On envoie les objets du combattant
                $tools = $this->Tools->getToolsByFighter($PlayerFighterId);
                $this->set(compact('tools', $tools));
                
                //On envoie les derniers évènements
                $events=$this->Events->getMostRecentEvents();
                $this->set(compact('events', $events));
            }
            else{
                $this->Flash->error(__('Vous êtes mort ! Veuillez choisir un combattant.'));
                return $this->redirect(['action' => 'fighter']);
            }
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
        $events = $this->Fighters->getEventsInView($playerId, $allevents);

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

        //On charge le modèle fighter
        $this->loadModel('Fighters');

        //On crée un nouveau combattant
        $fighter = $this->Fighters->newEntity();

        //Si le formulaire est rempli
        if ($this->request->is('post')) {

            //On renseigne l'id avec celle du joueur connecté
            $fighter->player_id = $this->request->session()->read('PlayerLoggedIn')['id'];

            //On entre les données entrées dans le formulaire
            $fighter = $this->Fighters->patchEntity($fighter, $this->request->data);

            //On sauvegarde le combattant
            if ($this->Fighters->save($fighter)) {
                $this->Flash->success(__('Votre personnage a bien été créé.'));

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
