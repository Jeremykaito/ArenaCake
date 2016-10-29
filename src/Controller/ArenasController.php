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
        $gametab = array(array());


        if ($this->request->is('post')) {
            pr($this->request->data);
            //$this->Fighters->move("up", "545f827c-576c-4dc5-ab6d-27c33186dc3e", 1);
        }

        $gametab = $this->createGameTab($gametab); //à mettre dans le controleur qui appel vision
        // ajouter une fonction createMapView qui cree la map vue par le fighter courent avec gestion de la vue.
    }

    public function diary() {
        
    }

    //Utilitaires
    public function createGameTab($gametab) {
        /*
         * devrait surment être du couté model, mais dans quel table ?? je touche à plusieurs tables
         * 
         * attention, il faut gérer la vue du joueur, avec 
         */
        $this->loadModel('Fighters');
        $fighterlist = $this->Fighters->getFighters();
        $this->loadModel('Tools');
        $toollist = $this->Tools->getTools();
        $this->loadModel('Surroundings');
        $surroundinglist = $this->Surroundings->getSurroundings();


        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 15; $j++) {
                $unused = true;
                if ($unused) {
                    foreach ($fighterlist as $fighter) {
                        if ($fighter->coordinate_x - 1 == $j && $fighter->coordinate_y - 1 == $i) {
                            $gametab[$j][$i] = $fighter;
                            $unused = false;
                        }
                    }
                } else if ($unused) {
                    foreach ($toollist as $tool) {
                        if ($tool->coordinate_x - 1 == $j && $tool->coordinate_y - 1 == $i) {
                            $gametab[$j][$i] = $tool; //gametab etant 
                            $unused = false;
                        }
                    }
                } else if ($unused) {
                    foreach ($surroundinglist as $surrounding) {
                        if ($surrounding->coordinate_x - 1 == $j && $surrounding->coordinate_y - 1 == $i) {
                            $gametab[$j][$i] = $surrounding;
                            $unused = false;
                        }
                    }
                } else {
                    
                }

                /*
                  if ($drapeau) {
                  $r = rand(0, 90);
                  //$gametab[$j][$i] = "$r";

                  switch ($r) {
                  case 3:
                  $gametab[$j][$i] = 'V'; //vue
                  break;
                  case 6:
                  $gametab[$j][$i] = 'D'; //force
                  break;
                  case 9:
                  $gametab[$j][$i] = 'L'; //vie
                  break;
                  case 12:
                  $this->Surroundings->addSurrounding($j, $i, 'P'); //colonne
                  break;
                  case 15:
                  $this->Surroundings->addSurrounding($j, $i, 'W'); //monstre
                  break;
                  case 18:
                  $this->Surroundings->addSurrounding($j, $i, 'T'); //trous
                  break;
                  } */
            }
        }
        return $gametab;
    }

}
