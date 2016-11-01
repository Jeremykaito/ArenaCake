<!-- Style et script js -->
<?php echo $this->Html->css('Arenas/sight.css') ?>

<?= $this->Html->css('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('jquery.min.js');?>
<?= $this->Html->script('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('Datatables.shCore'); ?>

<!-- Titre -->
<?=$this->assign('title', 'WebArena - Jouer');?>

<!-- Script datatable -->
<script>
$(document).ready(function () {
  $('#tab_stat').DataTable({
    "paging":   false,
    "info":     false,
    "filter":   false
  });
});
</script>

<script>
$(document).ready(function () {
  $('#tab_obj').DataTable({
    "paging":   false,
    "info":     false,
    "filter":   false,
    "language": {
      emptyTable:     "Pas d'objet, pas de bonus. Dommage...",
    }
  });
});
</script>

<script>
$(document).ready(function () {
  $('#tab_events').DataTable({
    "order": [[1, "desc"]],
    "language": {
      emptyTable: "Aucun événement récent, allez on se bouge!",
    }
  });
});
</script>

<?php
$bonusVue=0;
$bonusVie=0;
$bonusForce=0;

foreach ($tools as $tool):
  if($tool->type=='L'){
    $bonusVie= $bonusVie + $tool->bonus;
  }
  else if ($tool->type=='D'){
    $bonusForce= $bonusForce + $tool->bonus;
  }
  else if ($tool->type=='V'){
    $bonusVue= $bonusVue + $tool->bonus;
  }
endforeach;
?>

<!-- Interface fighter -->
<div id="interface_gauche">
  <section class="cadre_gris" id="interface_fighter">

    <h3><?= $fighter->name ?></h3>
    <ul>
      <li>Niveau : <?= $fighter->level ?></li>
      <li>Expérience : <?= $fighter->xp ?></li>
    </ul>

    <!-- Tableau des compétences -->
    <table id="tab_stat" class="display">
      <thead>
        <tr>
          <th>Skill</th>
          <th>Valeur</th>
        </tr>
      </thead>
      <tr>
        <td>Vie</td>

        <td><meter value= <?= $fighter->current_health + $bonusVie ?> min="0" max=<?= $fighter->skill_health + $bonusVie ?>></meter></td>
      </tr>
      <tr>
        <td>Force</td>
        <td><?= $fighter->skill_strength + $bonusForce ?></td>
      </tr>
      <tr>
        <td>Vue</td>
        <td><?= $fighter->skill_sight + $bonusVue ?></td>
      </tr>
    </table>

    <!-- Tableau des objets -->
    <table id="tab_obj" class="display">
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

  <!-- Matrice de jeu -->
  <table id="damier">
    <?php
    for ($y = 0; $y < 10; $y++) {
      echo "<tr>";
      for ($x = 0; $x < 15; $x++) {
        if(!empty($viewtab[$x][$y])){ ?>
          <td title= "<?php echo $viewtab[$x][$y] ; ?>">
            <?php }
            else{
              echo "<td>";
            }

            if (!empty($viewtab[$x][$y])) {
              echo $this->Html->image('sprites/' . $viewtab[$x][$y] . '.png', ['alt' => $viewtab[$x][$y]]);
            }
            echo "</td>";
          }
          echo "</tr>";
        }
        ?>
      </table>
      <div class="cadre_gris" id="events">
        <table id="tab_events" class="display">
          <thead>
            <tr>
              <th>Evénements</th>
            </tr>
          </thead>
          <?php foreach ($events as $event): ?>
            <tr>
              <td><?= $event->name ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
    <!-- Interface de jeu -->
    <section id='interface_action' class="cadre_gris">
      <h3>Actions</h3>

      <!-- Actions de déplacement -->
      <table class="tab_action">
        <tr>
          <td>
          </td>
          <td>
            <?= $this->Form->create('Move_Up',array('class' => 'game_form')) ?>
            <?= $this->Form->hidden('action', ['value' => 'move']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'up']) ?>
            <?= $this->Form->button(__('Haut'),array('class' => 'button_gold button_action')); ?>
            <?= $this->Form->end() ?>
          </td>
          <td>
          </td>
        </tr>
        <tr>
          <td>
            <?= $this->Form->create('Move_Left',array('class' => 'game_form')) ?>
            <?= $this->Form->hidden('action', ['value' => 'move']) ?>
            <?= $this->Form->hidden('dir', ['value' => 'left']) ?>
            <?= $this->Form->button(__('Gauche'),array('class' => 'button_gold button_action')); ?>
            <?= $this->Form->end() ?>
          </td>
          <td>
            <?php if($toolhere){ ?>
              <?= $this->Form->create('pickup',array('class' => 'game_form')) ?>
              <?= $this->Form->hidden('action', ['value' => 'pickup']) ?>
              <?= $this->Form->button(__('Prendre'),array('class' => 'button_gold button_action')); ?>
              <?= $this->Form->end() ?>
              <?php  } else echo 'Bouger'; ?>
            </td>
            <td>
              <?= $this->Form->create('Move_Right',array('class' => 'game_form')) ?>
              <?= $this->Form->hidden('action', ['value' => 'move']) ?>
              <?= $this->Form->hidden('dir', ['value' => 'right']) ?>
              <?= $this->Form->button(__('Droite'),array('class' => 'button_gold button_action')); ?>
              <?= $this->Form->end() ?>
            </td>
          </tr>
          <tr>
            <td>
            </td>
            <td>
              <?= $this->Form->create('Move_Down',array('class' => 'game_form')) ?>
              <?= $this->Form->hidden('action', ['value' => 'move']) ?>
              <?= $this->Form->hidden('dir', ['value' => 'down']) ?>
              <?= $this->Form->button(__('Bas'),array('class' => 'button_gold button_action')); ?>
              <?= $this->Form->end() ?>
            </td>
            <td>
            </td>
          </tr>
        </table>

        <!-- Actions d'attaque -->
        <table class="tab_action">
          <tr>
            <td>
            </td>
            <td>
              <?= $this->Form->create('Attack_Up',array('class' => 'game_form')) ?>
              <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
              <?= $this->Form->hidden('dir', ['value' => 'up']) ?>
              <?= $this->Form->button(__('Haut'),array('class' => 'button_red button_action')); ?>
              <?= $this->Form->end() ?>
            </td>
            <td>
            </td>
          </tr>
          <tr>
            <td>
              <?= $this->Form->create('Attack_Left',array('class' => 'game_form')) ?>
              <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
              <?= $this->Form->hidden('dir', ['value' => 'left']) ?>
              <?= $this->Form->button(__('Gauche'),array('class' => 'button_red button_action')); ?>
              <?= $this->Form->end() ?>
            </td>
            <td>Attaque</td>
            <td>
              <?= $this->Form->create('Attack_Right',array('class' => 'game_form')) ?>
              <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
              <?= $this->Form->hidden('dir', ['value' => 'right']) ?>
              <?= $this->Form->button(__('Droite'),array('class' => 'button_red button_action')); ?>
              <?= $this->Form->end() ?>
            </td>
          </tr>
          <tr>
            <td>
            </td>
            <td>
              <?= $this->Form->create('Attack_Down',array('class' => 'game_form')) ?>
              <?= $this->Form->hidden('action', ['value' => 'attack']) ?>
              <?= $this->Form->hidden('dir', ['value' => 'down']) ?>
              <?= $this->Form->button(__('Bas'),array('class' => 'button_red button_action')); ?>
              <?= $this->Form->end() ?>
            </td>
            <td>
            </td>
          </tr>
        </table>

        <!-- Actions d'ajout d'objets -->
        <h5>Génération<h5>
          <table class="tab_action">
            <tr><td>
              <?= $this->Form->create('Generate_Tools',array('class' => 'game_form')) ?>
              <?= $this->Form->hidden('action', ['value' => 'generateTools']) ?>
              <?= $this->Form->button(__('Objets'),array('class' => 'button_gold button_action')); ?>
              <?= $this->Form->end() ?>
            </td><td>
              <?= $this->Form->create('Generate_Surroundings',array('class' => 'game_form')) ?>
              <?= $this->Form->hidden('action', ['value' => 'generateSurroundings']) ?>
              <?= $this->Form->button(__('Décors'),array('class' => 'button_red button_action')); ?>
              <?= $this->Form->end() ?>
            </td>
          </tr>
        </table>

      </section>
