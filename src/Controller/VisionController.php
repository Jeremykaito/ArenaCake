<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
* Personal Controller
* User personal interface
*
*/
class VisionController  extends AppController
{

public function vision()
{
    $this->loadModel('Fighters');
    $this->loadModel('Tools');
    $fighterlist=$this->Fighters->getFighters();
    
    $this->set('fighterlist', $fighterlist);
    $this->set('gametab');
    // $this->set('avatar', *****.png );  je doit trouver l'avatar choisis par le joueur
}

}
