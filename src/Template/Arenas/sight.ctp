<?php echo $this->Html->css('Arenas/sight.css') ?>

<!-- Matrice de jeu -->
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

<!-- Interface de jeu -->
<div id='interface'>

    <!-- Actions de déplacement -->
    <section class="cadre_gris">
        <h3>Mouvements<h3>
            <?= $this->Form->create('Move_Up',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'move']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'up']) ?>
            <?= $this->Form->button(__('Haut'),array('class' => 'button_red')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

        <?= $this->Form->create('Move_Down',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'move']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'down']) ?>
            <?= $this->Form->button(__('Bas'),array('class' => 'button_red')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

        <?= $this->Form->create('Move_Left',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'move']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'left']) ?>
            <?= $this->Form->button(__('Gauche'),array('class' => 'button_red')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

        <?= $this->Form->create('Move_Right',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'move']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'right']) ?>
            <?= $this->Form->button(__('Droite'),array('class' => 'button_red')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

    </section>

    <!-- Actions d'attaque -->
    <section class="cadre_gris">
         <h3>Attaque<h3>

            <?= $this->Form->create('Attack_Up',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'up']) ?>
            <?= $this->Form->button(__('Haut'),array('class' => 'button_red')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

        <?= $this->Form->create('Attack_Down',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'down']) ?>
            <?= $this->Form->button(__('Bas'),array('class' => 'button_red')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

        <?= $this->Form->create('Attack_Left',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'left']) ?>
            <?= $this->Form->button(__('Gauche'),array('class' => 'button_red')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

        <?= $this->Form->create('Attack_Right',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'right']) ?>
            <?= $this->Form->button(__('Droite'),array('class' => 'button_red')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

    </section>
    
    <!-- Actions d'ajout d'objets -->
    <section class="cadre_gris section_generate">
        <h3>Générer la carte<h3>
        <?= $this->Form->create('Generate_Tools',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'generateTools']) ?>
            <?= $this->Form->button(__('Générer des objets'),array('class' => 'button_red button_generate')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

        <?= $this->Form->create('Generate_Surroundings',array('class' => 'game_form')) ?>
        <fieldset>
            <?= $this->Form->hidden('action', ['value' => 'generateSurroundings']) ?>
            <?= $this->Form->button(__('Générer des décors'),array('class' => 'button_red button_generate')); ?>
        </fieldset>
        <?= $this->Form->end() ?>

    </section>

</div>