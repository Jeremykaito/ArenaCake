<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;

class PublicController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'add', 'logout', 'resetPassword', 'hall']);
    }

    public function index() {
        
    }

    public function add() {
        if (!$this->request->session()->read('PlayerLoggedIn')) {
            $this->loadModel('Players');
            $player = $this->Players->newEntity();
            if ($this->request->is('post')) {
                $player = $this->Players->patchEntity($player, $this->request->data);
                if ($this->Players->save($player)) {
                    return $this->redirect(['controller' => 'Arenas', 'action' => 'index']);
                }
                $this->Flash->error(__("Impossible d'ajouter le joueur."));
            }
            $this->set('player', $player);
        } else {
            return $this->redirect(['controller' => 'Arenas', 'action' => 'index']);
        }
    }

    public function login() {
        if (!$this->request->session()->read('PlayerLoggedIn')) {
            if ($this->request->is('post')) {
                $player = $this->Auth->identify();
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
        if (!$this->request->session()->read('PlayerLoggedIn')) {

            if ($this->request->is('post')) {
                $email = $this->request->data['email'];
                $this->loadModel('Players');
                $player = $this->Players->findPlayerByEmail($email);
                if (empty($player)) {
                    $this->Flash->error(__('E-mail invalide.'));
                } else {
                    $newPassword = $this->Players->generatePassword();
                    $player = $this->Players->patchEntity($player, ['password' => $newPassword]);
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
        
    $this->loadModel('Fighters');
    $this->loadModel('Players');
    $this->loadModel('Events');
    
    $fighterlist=    $this->Fighters->getFighters();
    $playerlist =    $this->Players->getPlayers();
    
    $this->set('fighterlist',$fighterlist);
    $this->set('playerlist',$playerlist);
    }

    function sendPasswordEmail($email, $newPassword) {
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
