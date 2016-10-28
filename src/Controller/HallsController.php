<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

class HallsController  extends AppController
{

public function index()
{
    $this->loadModel('Fighters');
    $this->loadModel('Players');
    $this->loadModel('Events');
    
    $fighterlist=    $this->Fighters->getFighters();
    $playerlist =    $this->Players->getPlayers();
    //$eventPlayer =   $this->Events->getAllEvents();
    
    $this->set('fighterlist',$fighterlist);
    $this->set('playerlist',$playerlist);
    //$this->set('eventlist',$eventPlayer);
    
}


}

