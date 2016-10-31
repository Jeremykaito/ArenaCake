<?php echo $this->Html->css('sight.css') ?>

<section>
    <table id="damier">
        <?php
        for ($y = 0; $y < 10; $y++) {
            echo "<tr>";
            for ($x = 0; $x < 15; $x++) {
                echo "<td>";
                if (!empty($viewtab[$x][$y])) {
                    echo $this->Html->image('sprites/' . $viewtab[$x][$y] . '.png', ['alt' => $viewtab[$x][$y]]);
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
        <?= $this->Form->hidden('action', ['value' => 'generateTools']) ?>
        <?= $this->Form->button(__('Generate Tools')); ?>
    </fieldset>
    <?= $this->Form->end() ?>
</section>
<section>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('action', ['value' => 'generateSurroundings']) ?>
        <?= $this->Form->button(__('Generate Surroundings')); ?>
    </fieldset>
    <?= $this->Form->end() ?>
</section>



<section>
    <p>mouvements<p>
        <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('action', ['value' => 'move']) ?>
        <?= $this->Form->hidden('dir', ['value' => 'up']) ?>
        <?= $this->Form->button(__('up'), ["value" => 'up']); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('action', ['value' => 'move']) ?>
        <?= $this->Form->hidden('dir', ['value' => 'down']) ?>
        <?= $this->Form->button(__('down')); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('action', ['value' => 'move']) ?>
        <?= $this->Form->hidden('dir', ['value' => 'left']) ?>
        <?= $this->Form->button(__('left')); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('action', ['value' => 'move']) ?>
        <?= $this->Form->hidden('dir', ['value' => 'right']) ?>
        <?= $this->Form->button(__('right')); ?>
    </fieldset>
    <?= $this->Form->end() ?>

</section>

<section>
    <p>attaques<p>
        <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
        <?= $this->Form->hidden('dir', ['value' => 'up']) ?>
        <?= $this->Form->button(__('up'), ["value" => 'up']); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
        <?= $this->Form->hidden('dir', ['value' => 'down']) ?>
        <?= $this->Form->button(__('down')); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
        <?= $this->Form->hidden('dir', ['value' => 'left']) ?>
        <?= $this->Form->button(__('left')); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
        <?= $this->Form->hidden('dir', ['value' => 'right']) ?>
        <?= $this->Form->button(__('right')); ?>
    </fieldset>
    <?= $this->Form->end() ?>

</section>
