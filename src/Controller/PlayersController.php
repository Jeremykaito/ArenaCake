<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;

class PlayersController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login','add', 'logout', 'resetPassword']);
    }
	
    public function index()
    {

	}

    public function add()
    {
		if (!$this->request->session()->read('PlayerLoggedIn')){
			$player = $this->Players->newEntity();
			if ($this->request->is('post')) {
				$player = $this->Players->patchEntity($player, $this->request->data);
				if ($this->Players->save($player)) {
					return $this->redirect($this->Auth->redirectUrl());
				}
				$this->Flash->error(__("Impossible d'ajouter le joueur."));
			}
			$this->set('player', $player);
		}
		else{
			return $this->redirect($this->Auth->redirectUrl());
		}
    }

    public function login()
    {
		if (!$this->request->session()->read('PlayerLoggedIn')){
			if ($this->request->is('post')) {
				$player = $this->Auth->identify();
					if ($player) {
						$this->Auth->setUser($player);
						$this->request->session()->write('PlayerLoggedIn', $this->Auth->user());
						return $this->redirect($this->Auth->redirectUrl());
					}
				else{
					$this->Flash->error(__('E-mail ou mot de passe invalide.'));
				}
			}
		}
		else {
			return $this->redirect($this->Auth->redirectUrl());
		}
    }

    public function logout()
    {
		$this->request->session()->write('PlayerLoggedIn', null);
		return $this->redirect($this->Auth->logout());
    }
	
	public function resetPassword()
    {
		if (!$this->request->session()->read('PlayerLoggedIn')){
		
		    if ($this->request->is('post')) {
				$email = $this->request->data['email'];
				$this->loadModel('Players');
				$player = $this->Players->findPlayerByEmail($email);
				if (empty($player)){
					$this->Flash->error(__('E-mail invalide.'));
				}
				else{
					$newPassword = $this->generatePassword();
					$player = $this->Players->patchEntity($player, ['password' => $newPassword]);
					if ($this->Players->save($player) && $this->sendPasswordEmail($email,$newPassword)) {
						$this->Flash->success('Un nouveau mot de passe vous a été envoyé par e-mail.');
						return $this->redirect($this->Auth->redirectUrl());
					}
				}	
			}
		}
		else{
			return $this->redirect($this->Auth->redirectUrl());
		}
    }
	
	function generatePassword() {
        $alphabet = "azertyuiopqsdfghjklmwxcvbn7418529630AZERTYUIOPQSDFGHJKLMWXCVBN";
		$pwd = array();
		$alpha_length= strlen($alphabet)-1;
		for($i=0;$i<10;$i++){
			$n=rand(0,$alpha_length);
			$pwd[]=$alphabet[$n];
		}
		return (implode($pwd));
    }
	
	function sendPasswordEmail($email,$newPassword) {
		if (!empty($email)) {
			$newMail = new Email('default');
			$newMail->from(['annelyse.nugue@gmail.com' => 'WebArena'])
			->to($email)
			->subject('Mot de passe réinitialisé')
			->send('WebArena vous informe que votre mot de passe a été réinitialisé. Votre nouveau mot de passe est : '.$newPassword. '. Amusez-vous bien dans les plaines de WebArena !');
            return true;
        }
        return false;
    }
}