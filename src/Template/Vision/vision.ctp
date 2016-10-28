<?php echo $this->Html->css('vision.css') ?>

<section>
    <table id="damier">
        <?php
        for ($i = 0; $i < 10; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 15; $j++) {
                echo "<td>";
                if (is_string($gametab[$j][$i])) {
                    echo $this->Html->image('sprites/strval'.($gametab[$j][$i]).'.png', ['alt' => strval($gametab[$j][$i])]);
                } else {
                    echo $this->Html->image("sprites/rogue.png", ['alt' => 'fighter']);
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</section>





<section>
    
    <?= $this->Form->create() ?>
        <legend>Déplacements</legend>
    <fieldset>
        <?= $this->Form->input('direction') ?>
        <?= $this->Form->button(__('submit')); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    
</section>
