<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Personal Controller
 * User personal interface
 *
 */
class ArenasController extends AppController {

    public function index() {
        
    }

    public function fighter() {
        
    }

    public function sight() {
        $this->loadModel('Fighters');
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
        }
    }

    public function diary() {
        
    }

}
