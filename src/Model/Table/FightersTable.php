<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class FightersTable extends Table {

    public function exist($x, $y) {
        if (empty($this->find()->where(['coordinate_x' => $x, 'coordinate_y' => $y])->toArray())) {
            $empty = true;
        } else {
            $empty = false;
        }
        return $empty;
    }

    public function getBestFighter() {
        return $this->find('all')->order('level')->first();
    }

    public function getFighters() {
        $yo = $this->find('all')->toArray();
        return $yo;
    }

    public function move($dir, $playerid, $fighterid) {
        $toolsTable = TableRegistry::get('Tools');
        $surroundingsTable = TableRegistry::get('Surroundins');

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
        $nextPos = array('x' => $fighter->coordinate_x += $dirToCo["x"], 'y' => $fighter->coordinate_y += $dirToCo["y"]);

        if ($nextPos["x"] >= 0 && $nextPos["x"] <= 15 && $nextPos["y"] >= 0 && $nextPos["y"] <= 15) {
            if (!$this->exsit($nextPos["x"], $nextPos["y"]) && !$toolsTable->exsit($nextPos["x"], $nextPos["y"]) && !$surroundingsTable->exsit($nextPos["x"], $nextPos["y"])) {
                $this->doMove($fighterid, $nextPos);
            } else if (!$this->exsit($nextPos["x"], $nextPos["y"]) && !$surroundingsTable->exsit($nextPos["x"], $nextPos["y"])) {
                $toolsTable->takeTool($nextPos["x"], $nextPos["y"], $fighterid);
                $this->doMove($fighterid, $nextPos);
            } else if (!$this->exsit($nextPos["x"], $nextPos["y"]) && !$toolsTable->exsit($nextPos["x"], $nextPos["y"])) {
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
        }
    }

    public function doMove($fighterid, $nextPos) {
        /* $fightersTable = TableRegistry::get('Fighters');
          $fighter = $fightersTable->get($fighterid);//ici on utilise fighterid en tant que clé */

        $fighter = $this->get($fighterid);

        $fighter->coordinate_x = $nextPos["x"];
        $fighter->coordinate_y = $nextPos["y"];
        $fighter->save();
    }

}
