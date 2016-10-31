<?php echo $this->Html->css('Arenas/sight.css') ?>
<?= $this->Html->css('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('jquery.min.js');?>
<?= $this->Html->script('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('Datatables.shCore'); ?>
<?=$this->assign('title', 'WebArena - Jouer');?>	

<script>
    $(document).ready(function () {
        $('#tab_stat').DataTable({
            "order": [[3, "desc"]]
        });
    });
</script>


<script>
    $(document).ready(function () {
        $('#tab_obj').DataTable({
            "order": [[3, "desc"]]
        });
    });
</script>

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
    
    <!-- Feuille de personnage -->
    <section>
        <h3><?= $fighter->name ?><h3>
        <p>Niveau : <?= $fighter->level ?></p>
        <p>Expérience : <?= $fighter->xp ?></p>
        
        <!-- Tableau des compétences -->
        <table id="tab_stat">
            <thead>
              <tr>
                <th>Compétences</th>
                <th>Valeur</th>
              </tr>
            </thead>
              <tr>
                <td>Vie</td>
                <td><?= $fighter->current_health ."/".$fighter->skill_health ?></td>
              </tr>
              <tr>
                <td>Force</td>
                <td><?= $fighter->skill_strength ?></td>
              </tr>
              <tr>
                <td>Vue</td>
                <td><?= $fighter->skill_sight ?></td>
              </tr>
        </table>
        
        <!-- Tableau des objets -->
        <table id="tab_obj">
            <thead>
              <tr>
                <th>Type d'objet</th>
                <th>Bonus</th>
              </tr>
            </thead>
            <?php foreach ($tools as $tool): ?>
                <tr>
                    <td><?= $tool->type ?></td>
                    <td><?= $tool->bonus ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</div>