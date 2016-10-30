<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class FightersTable extends Table {

    public function exist($x, $y) {
        if (empty($this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->toArray())) {
            $exist = false;
        } else {
            $exist = true;
        }
        return $exist;
    }

    public function getBestFighter() {
        return $this->find('all')->order('level')->first();
    }

    public function getFighters() {
        $yo = $this->find('all')->toArray();
        return $yo;
    }

    public function getFighterById($id) {
        $yo = $this->find()->where(['id' => $id])->first();
        return $yo;
    }

    public function getFighterByCo($x, $y) {
        $yo = $this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->first();
        return $yo;
    }

    public function kill($fighterid) {
        $entity = $this->get($fighterid);
        pr($entity->name . "c'est bien battu mais ça n'a pas suffit...");
        $result = $this->delete($entity);
    }

    public function winXp($fighterid, $amount) {
        $entity = $this->get($fighterid);
        $entity->xp += $amount;
        $this->save($entity);
    }

    public function cerateViewTab() {
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundings');
        $fighterlist = $this->getFighters();
        $toollist = $toolsTable->getTools();
        $surroundinglist = $surroundingsTable->getSurroundings();



        $idFighter = 1; // à remplacer par : 1)une var de cession 2)un paramètre de la fonction----------------------
        $viewtab = array(array());
        $currentfighter = $this->getFighterById($idFighter);

        $distance = $currentfighter->skill_sight + $toolsTable->getBonus($idFighter, 'V'); // definition de la distance de vue du fighter.


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

    public function move($dir, $fighterid) {
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundings');

        $fighter = $this->getFighterById($fighterid);

        $dirToCo = $this->dirToCo($dir);


        $nextPos = array('x' => $fighter->coordinate_x += $dirToCo["x"], 'y' => $fighter->coordinate_y += $dirToCo["y"]);

        if ($nextPos["x"] >= 0 && $nextPos["x"] <= 14 && $nextPos["y"] >= 0 && $nextPos["y"] <= 9) {
            if (!$this->exist($nextPos["x"], $nextPos["y"]) && !$toolsTable->exist($nextPos["x"], $nextPos["y"]) && !$surroundingsTable->exist($nextPos["x"], $nextPos["y"])) {
                $this->doMove($fighterid, $nextPos);
            } else if (!$this->exist($nextPos["x"], $nextPos["y"]) && !$surroundingsTable->exist($nextPos["x"], $nextPos["y"])) {
                $toolsTable->takeTool($nextPos["x"], $nextPos["y"], $fighterid);
                $this->doMove($fighterid, $nextPos);
            } else if (!$this->exist($nextPos["x"], $nextPos["y"]) && !$toolsTable->exist($nextPos["x"], $nextPos["y"])) {
                switch ($surroundingsTable->getSurrounding($nextPos["x"], $nextPos["y"])["type"]) {
                    case "W"://monstre
                        $this->kill($fighterid);
                        pr("vous avez été mangé par un monstre");
                        break;
                    case "T"://trou
                        $this->kill($fighterid);
                        pr("vous êtes tombé dans un trou");
                        break;
                    default:
                        break;
                }
            } else {
                pr("mouvement impossible");
            }
        } else {
            pr("mouvement impossible hors cadre");
        }
    }

    public function doMove($fighterid, $nextPos) {
        /* $fightersTable = TableRegistry::get('Fighters');
          $fighter = $fightersTable->get($fighterid);//ici on utilise fighterid en tant que clé */

        $fighter = $this->get($fighterid);

        $fighter->coordinate_x = $nextPos["x"];
        $fighter->coordinate_y = $nextPos["y"];
        $this->save($fighter);
    }

    public function attack($dir, $fighterid) {
        $toolsTable = TableRegistry::get('Tools');
        $currentfighter = $this->getFighterById($fighterid);


        $dirToCo = $this->dirToCo($dir);
        $attackSpot = array('x' => $currentfighter->coordinate_x += $dirToCo["x"], 'y' => $currentfighter->coordinate_y += $dirToCo["y"]);

        if ($this->exist($attackSpot['x'], $attackSpot['x'])) {
            $oponent = $this->getFighterByCo($attackSpot['x'], $attackSpot['x']);

            $mystrength = $currentfighter->skill_strength + $toolsTable->getBonus($fighterid, 'D');

            if (rand(1, 20) > (10 + $oponent->level - $currentfighter->level)) { //test de la réuissite de l'attaque
                pr("l'attaque a atteind sa cible !"); //ajouter une phrase du type "joueur 1 a touché joueur 2"
                $this->touchedByAttack($oponent->id, $fighterid, $mystrength);
            } else {
                pr("l'attaque a échouée");
            }
        } else {
            pr($currentfighter->name . ' se bat contre le vent, et il espère gagner...');
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

}
