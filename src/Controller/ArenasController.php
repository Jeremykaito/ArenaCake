<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
* Personal Controller
* User personal interface
*
*/
class ArenasController  extends AppController
{

public function index()
{
}

public function fighter()
{
}

public function sight()
{
}

public function diary()
{
    $playerId = $this->Auth->user('id');
    $this->loadModel('Fighters');
    $fighters = $this->Fighters->getFightersByPlayer($playerId);
    $this->set(compact('fighters'));
}
}
