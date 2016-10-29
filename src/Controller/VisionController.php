<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Personal Controller
 * User personal interface
 *
 */
class VisionController extends AppController {

    //PAGES
    public function vision() {
        $this->loadModel('Fighters');
        $this->loadModel('Tools');
        $fighterlist = $this->Fighters->getFighters();
        
        if ($this->request->is('post')) {
           $this->Fighters->move($this->request->data('direction'), "545f827c-576c-4dc5-ab6d-27c33186dc3e", 1);
        }
        
        $gametab = $this->generationMap($fighterlist);//à mettre dans le controleur qui appel vision
        $this->set('gametab', $gametab);
        
    }

    
    
    //UTILITAIRES
    public function generationMap($fighterlist) {
        $gametab = array(array());
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 15; $j++) {
                $drapeau = true;
                foreach ($fighterlist as $fighter) {
                    if ($fighter->coordinate_x - 1 == $j && $fighter->coordinate_y - 1 == $i) {
                        $gametab[$j][$i] = $fighter; //mettre directement le nom de la bonne image si possible
                        $drapeau = false;
                    }
                }
                if ($drapeau) {
                    $r = rand(0, 90);
                    //$gametab[$j][$i] = "$r";

                    switch ($r) {
                        case 3:
                            $gametab[$j][$i] = 'jumelles';
                            break;
                        case 6:
                            $gametab[$j][$i] = 'epee';
                            break;
                        case 9:
                            $gametab[$j][$i] = 'armure';
                            break;
                        case 12:
                            $gametab[$j][$i] = 'colonne';
                            break;
                        default:
                            $gametab[$j][$i] = 'herbe';
                    }
                }
            }
        }
        return $gametab;
    }
    
    

}
