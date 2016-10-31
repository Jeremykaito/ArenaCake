<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;

class PublicController extends AppController {

    public function index() {
        
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'add', 'logout', 'resetPassword', 'hall']);
    }

    public function add() {

        //Si le joueur est déjà connecté, il est redirigé vers l'accueil
        if (!$this->request->session()->read('PlayerLoggedIn')) {

            //Si le formulaire est rempli
            if ($this->request->is('post')) {

                //On créée un nouveau joueur
                $this->loadModel('Players');
                $player = $this->Players->newEntity();

                //On met dans ce joueur les données du formulaires
                $player = $this->Players->patchEntity($player, $this->request->data);

                //On sauvegarde le joueur
                if ($this->Players->save($player)) {
                    return $this->redirect(['controller' => 'Arenas', 'action' => 'index']);
                }
                $this->Flash->error(__("Impossible d'ajouter le joueur."));
            }

            //On envoie le joueur à la vue
            $this->set('player', $player);
        } else {
            return $this->redirect(['controller' => 'Arenas', 'action' => 'index']);
        }
    }

    public function login() {

        //Si le joueur est déjà connecté, il est redirigé vers l'accueil
        if (!$this->request->session()->read('PlayerLoggedIn')) {

            //Si le formulaire est rempli
            if ($this->request->is('post')) {

                //On identifie le joueur
                $player = $this->Auth->identify();

                //Si l'identification a réussi, on stocke le joueur
                if ($player) {
                    $this->Auth->setUser($player);
                    $this->request->session()->write('PlayerLoggedIn', $this->Auth->user());
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error(__('E-mail ou mot de passe invalide.'));
                }
            }
        } else {
            return $this->redirect(['controller' => 'Arenas', 'action' => 'index']);
        }
    }

    public function logout() {
        $this->request->session()->write('PlayerLoggedIn', null);
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }

    public function resetPassword() {

        //Si le joueur est déjà connecté, il est redirigé vers l'accueil
        if (!$this->request->session()->read('PlayerLoggedIn')) {

            //Si le formulaire est rempli
            if ($this->request->is('post')) {

                //On recherche le joueur par son e-mail
                $email = $this->request->data['email'];
                $this->loadModel('Players');
                $player = $this->Players->findPlayerByEmail($email);

                //Si le joueur n'a pas été trouvé, on sort de la fonction
                if (empty($player)) {
                    $this->Flash->error(__('E-mail invalide.'));
                }

                //Si le joueur a été trouvé, on change son mot de passe
                else {
                    $newPassword = $this->Players->generatePassword();
                    $player = $this->Players->patchEntity($player, ['password' => $newPassword]);

                    //On sauvegarde le joueur et on lui envoie un mail
                    if ($this->Players->save($player) && $this->sendPasswordEmail($email, $newPassword)) {
                        $this->Flash->success('Un nouveau mot de passe vous a été envoyé par e-mail.');
                        return $this->redirect(['controller' => 'Arenas', 'action' => 'index']);
                    }
                }
            }
        } else {
            return $this->redirect(['controller' => 'Arenas', 'action' => 'index']);
        }
    }

    function hall() {

        //On charge les modèles
        $this->loadModel('Fighters');
        $this->loadModel('Players');
        $this->loadModel('Events');

        //On récupère tous les combattants et tous les joueurs
        $fighterlist = $this->Fighters->getFighters();
        $playerlist = $this->Players->getPlayers();

        //On envoie les données à la vue
        $this->set('fighterlist', $fighterlist);
        $this->set('playerlist', $playerlist);
    }

    function sendPasswordEmail($email, $newPassword) {
        
        //Si l'adresse e-mail n'est pas vide
        if (!empty($email)) {
            $newMail = new Email('default');
            $newMail->from(['annelyse.nugue@gmail.com' => 'WebArena'])
                    ->to($email)
                    ->subject('Mot de passe réinitialisé')
                    ->send('WebArena vous informe que votre mot de passe a été réinitialisé. Votre nouveau mot de passe est : ' . $newPassword . '. Amusez-vous bien dans les plaines de WebArena !');
            return true;
        }
        return false;
    }

}
