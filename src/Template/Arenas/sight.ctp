<?php echo $this->Html->css('sight.css') ?>

<section>
    <table id="damier">
        <?php
        for ($i = 0; $i < 10; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 15; $j++) {
                echo "<td>";
                if (is_string($gametab[$j][$i])) {
                    echo $this->Html->image('sprites/strval' . ($gametab[$j][$i]) . '.png', ['alt' => strval($gametab[$j][$i])]);
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
    <fieldset>
        <?= $this->Form->hidden('up', ["up" => 'up']) ?>
        <?= $this->Form->button(__('up'), ["value" => 'up']); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('down') ?>
        <?= $this->Form->button(__('down')); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('left') ?>
        <?= $this->Form->button(__('left')); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('right') ?>
        <?= $this->Form->button(__('right')); ?>
    </fieldset>
    <?= $this->Form->end() ?>

</section>
