<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class FightersTable extends Table {
    
    /* Fonctions pour la validation des données */

    public function beforeSave($event, $entity) {
        if ($entity->isNew()) {
            $entity->coordinate_x = 5;
            $entity->coordinate_y = 5;
            $entity->skill_sight = 2;
            $entity->skill_strength = 1;
            $entity->skill_health = 3;
            $entity->current_health = 3;
            $entity->level = 1;
            $entity->xp = 0;
            $entity->next_action_time = date('Y-m-d H:i:s');
            $entity->guild_id = NULL;
        }
    }

    /* Fonctions pour trouver des combattants */

    public function getFighters() {
        $yo = $this->find('all')->toArray();
        return $yo;
    }

    public function getBestFighter() {
        return $this->find('all')->order('level')->first();
    }

    public function getFightersByPlayer($playerId) {
        $fighters = $this
                ->find()
                ->where(['player_id' => $playerId]);

        return $fighters;
    }

    public function getFighterById($id) {
        $yo = $this->find()->where(['id' => $id])->first();
        return $yo;
    }

    public function getFighterByCo($x, $y) {
        $yo = $this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->first();
        return $yo;
    }

    /* Fonctions pour gérer les combattants */

    public function kill($fighterid) {

        $entity = $this->get($fighterid);

        //Création d'un évènement
        $eventsTables = TableRegistry::get('Events');
        $eventsTables->createEvent($entity->name . ' est mort.', $entity->coordinate_x, $entity->coordinate_y);

        //On supprime le combattant
        $result = $this->delete($entity);
    }

    public function winXp($fighterid, $amount) {
        $entity = $this->get($fighterid);
        $entity->xp += $amount;
        $this->save($entity);
    }

    /* Fonctions pour vérifier les coordonnées */

    public function checkAdjacentCoordinates($coord1X, $coord1Y, $coord2X, $coord2Y) {
        if (abs($coord1X - $coord2X) + abs($coord1Y - $coord2Y) < 2) {
            return true;
        } else {
            return false;
        }
    }

    public function checkInViewCoordinates($fighter, $coordX, $coordY) {

        //On vérifie si les coordonnées sont à portée de vue du combattant
        $toolsTable = TableRegistry::get('Tools');
        $distance = $fighter->skill_sight + $toolsTable->getBonus($fighter->id, 'V');

        if (abs($coordX - ($fighter->coordinate_x)) + abs($coordY - ($fighter->coordinate_y)) <= $distance) {
            return true;
        } else {
            return false;
        }
    }

    /* Fonction d'actions */

    public function move($dir, $fighterid) {

        //On charge les modèles
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundings');
        $eventsTables = TableRegistry::get('Events');

        //On cherche le combattant à déplacer
        $fighter = $this->getFighterById($fighterid);

        //On calcule la case sur laquelle va atterrir le combattant
        $dirToCo = $this->dirToCo($dir);
        $nextPos = array('x' => $fighter->coordinate_x += $dirToCo["x"], 'y' => $fighter->coordinate_y += $dirToCo["y"]);

        //On vérifie si le déplacement est possible
        if ($this->moveIsPossible($nextPos)) {
            $this->doMove($fighterid, $nextPos);

            //On vérifie s'il y a un objet à prendre
            if ($this->toolIsThere($nextPos)) {
                $toolsTable->takeTool($nextPos["x"], $nextPos["y"], $fighterid);
            }

            //On vérifie s'il y a un décor
            else if ($this->surroundingIsThere($nextPos)) {

                switch ($surroundingsTable->getSurroundingByCo($nextPos["x"], $nextPos["y"])) {
                   
                    //Monstre
                    case "W":

                        //Création d'un évènement
                        $eventsTables->createEvent('Un monstre a dévoré ' . $fighter->name, $nextPos["x"], $nextPos["y"]);
                        
                        //Le joueur est mort
                        $this->kill($fighterid);
                        break;
                    
                    //Trou
                    case "T":
                        //Création d'un évènement
                        $eventsTables->createEvent('Un trou a aspiré ' . $fighter->name, $nextPos["x"], $nextPos["y"]);
                        
                        //Le joueur est mort
                        $this->kill($fighterid);
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function moveIsPossible($nextPos) {

        $surroundingsTable = TableRegistry::get('Surroundings');
        
        //Si le joueur est dans l'arène
        if ($nextPos["x"] >= 0 && $nextPos["x"] <= 14 && $nextPos["y"] >= 0 && $nextPos["y"] <= 9) {

            //Si la case ne contient pas un autre combattant ou une colonne
            if (!$this->exist($nextPos["x"], $nextPos["y"]) && !($surroundingsTable->getSurroundingByCo($nextPos["x"], $nextPos["y"]))=='P') {
                return true;
            }
        }
        return false;
    }

    public function toolIsThere($nextPos) {
        
        $toolsTable = TableRegistry::get('Tools');
        
        //Si un objet est présent aux coordonnées données
        if ($toolsTable->exist($nextPos["x"], $nextPos["y"])) {
            return true;
        }
        return false;
    }

    public function surroundingIsThere($nextPos) {
        
        $surroundingsTable = TableRegistry::get('Surroundings');
        
        //Si un décor est présent aux coordonnées données
        if ($surroundingsTable->exist($nextPos["x"], $nextPos["y"])) {
            return true;
        }
        return false;
    }

    public function doMove($fighterid, $nextPos) {
        /* $fightersTable = TableRegistry::get('Fighters');
          $fighter = $fightersTable->get($fighterid);//ici on utilise fighterid en tant que clé */
        $fighter = $this->get($fighterid);
        $fighter->coordinate_x = $nextPos["x"];
        $fighter->coordinate_y = $nextPos["y"];
        $this->save($fighter);

        //Création d'un évènement
        $eventsTables = TableRegistry::get('Events');
        $eventsTables->createEvent($fighter->name . ' avance.', $nextPos["x"], $nextPos["y"]);
    }

    public function attack($dir, $fighterid) {
        $toolsTable = TableRegistry::get('Tools');
        $eventsTables = TableRegistry::get('Events');
        $currentfighter = $this->getFighterById($fighterid);
        $dirToCo = $this->dirToCo($dir);
        $attackSpot = array('x' => $currentfighter->coordinate_x += $dirToCo["x"], 'y' => $currentfighter->coordinate_y += $dirToCo["y"]);
        if ($this->exist($attackSpot['x'], $attackSpot['x'])) {
            $oponent = $this->getFighterByCo($attackSpot['x'], $attackSpot['x']);
            $mystrength = $currentfighter->skill_strength + $toolsTable->getBonus($fighterid, 'D');
            if (rand(1, 20) > (10 + $oponent->level - $currentfighter->level)) { //test de la réuissite de l'attaque
                $this->touchedByAttack($oponent->id, $fighterid, $mystrength);
                //Création d'un évènement
                $eventsTables->createEvent($currentfighter->name . ' attaque et touche ' . $oponent->name, $attackSpot['x'], $attackSpot['y']);
            } else {
                //Création d'un évènement
                $eventsTables->createEvent($currentfighter->name . ' attaque et rate ' . $oponent->name, $attackSpot['x'], $attackSpot['y']);
            }
        } else {
            $eventsTables->createEvent($currentfighter->name . ' se bat contre le vent et espère gagner... ', $attackSpot['x'], $attackSpot['y']);
        }
    }

    public function touchedByAttack($defenderid, $attackerid, $strength) {
        $defender = $this->getFighterById($defenderid);
        if ($defender->current_health > $strength) {
            $defender->current_health -= $strength;
            $this->save($defender);
            $this->winXp($attackerid, 1);
        } else {
            $this->winXp($attackerid, $defender->level);
            $this->kill($defenderid);
        }
    }

    /* Fonctions utilitaires */

    public function dirToCo($dir) {
        $dirToCo = array();
        switch ($dir) {
            case 'up':
                $dirToCo = array("x" => 0, "y" => -1);
                break;
            case 'down':
                $dirToCo = array("x" => 0, "y" => 1);
                break;
            case 'left':
                $dirToCo = array("x" => -1, "y" => 0);
                break;
            case 'right':
                $dirToCo = array("x" => 1, "y" => 0);
                break;
        }
        return $dirToCo;
    }

    public function exist($x, $y) {
        if (empty($this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->toArray())) {
            $exist = false;
        } else {
            $exist = true;
        }
        return $exist;
    }

    public function getEventByFighter($playerId, $events) {

        //Déclaration des variables
        $found_events = array();
        $i = 0;

        //On récupère tous les personnages du joueur
        $fighters = $this->getFightersByPlayer($playerId);

        foreach ($events as $event):
            foreach ($fighters as $fighter):
                if ($this->checkInViewCoordinates($fighter, $event->coordinate_x, $event->coordinate_y)) {
                    if (!in_array($event, $found_events)) {
                        $found_events[$i] = $event;
                        $i++;
                    }
                }
            endforeach;
        endforeach;

        return $found_events;
    }

    public function createViewTab() {

        //On cherche les différents modèles
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundings');

        //On créée les listes à partir de ces modèles
        $fighterlist = $this->getFighters();
        $toollist = $toolsTable->getTools();
        $surroundinglist = $surroundingsTable->getSurroundings();

        //Autres variables
        $idFighter = 3; // à remplacer par : 1)une var de cession 2)un paramètre de la fonction----------------------
        $viewtab = array(array());
        $currentfighter = $this->getFighterById($idFighter);
        $distance = $currentfighter->skill_sight + $toolsTable->getBonus($idFighter, 'V'); // definition de la distance de vue du fighter.
        //On vérifie les cases à portée de vue du joueur
        for ($y = 0; $y < 10; $y++) {
            for ($x = 0; $x < 15; $x++) {
                if (abs($x - ($currentfighter->coordinate_x)) + abs($y - ($currentfighter->coordinate_y)) <= $distance) {
                    $unused = true;
                    if ($unused) {
                        foreach ($fighterlist as $fighter) {
                            if ($fighter->coordinate_x == $x && $fighter->coordinate_y == $y) {
                                $viewtab[$x][$y] = "rogue"; // ici on devrait mettre le nom du skin du fighter en question------------------------------
                                $unused = false;
                            }
                        }
                    }
                    if ($unused) {
                        foreach ($toollist as $tool) {
                            if ($tool->coordinate_x == $x && $tool->coordinate_y == $y) {
                                $viewtab[$x][$y] = "jumelle"; //ici on devrait mettre le nom du skin du tool en question------------------------------
                                $unused = false;
                            }
                        }
                    }
                    if ($unused) {
                        foreach ($surroundinglist as $surrounding) {
                            if ($surrounding->coordinate_x == $x && $surrounding->coordinate_y == $y) {
                                $viewtab[$x][$y] = "colonne"; //ici on devrait mettre le nom du skin du surrounding en question------------------------------
                                $unused = false;
                            }
                        }
                    }
                    if ($unused) {
                        $viewtab[$x][$y] = 'herbe';
                    }
                }
            }
        }
        return $viewtab;
    }
    
    public function getSelectedFighter(){
        return 3;
    }
}
