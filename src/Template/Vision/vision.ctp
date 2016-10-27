<?php echo $this->Html->css('vision.css') ?>

<section>
    <table id="damier">
        <?php
        for ($i = 0; $i < 10; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 15; $j++) {
                echo "<td>";
                $drapeau = true;
                foreach ($fighterlist as $fighter) {
                    if ($fighter->coordinate_x == $j && $fighter->coordinate_y == $i) {
                        echo $this->Html->image(/* $avatar */ 'sprites/rogue.png', ['alt' => 'perso']);
                        $gametab[$j][$i] = $fighter;
                        $drapeau = false;
                    }
                }
                if ($drapeau) {
                    $r = rand(0, 90);
                    switch ($r) {
                        case 3:
                            echo $this->Html->image('sprites/jumelles.png', ['alt' => 'jumelles']);
                            break;
                        case 6:
                            echo $this->Html->image('sprites/epe.png', ['alt' => 'epe']);
                            break;
                        case 9:
                            echo $this->Html->image('sprites/armure.png', ['alt' => 'armure']);
                            break;
                        case 12:
                            echo $this->Html->image('sprites/colonne.png', ['alt' => 'colonne']);
                            break;
                        default:
                            echo $this->Html->image('sprites/herbe.png', ['alt' => 'herbe']);
                    }
                }


                echo "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</section>


