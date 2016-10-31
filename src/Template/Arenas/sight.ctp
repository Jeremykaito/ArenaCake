<?php echo $this->Html->css('Arenas/sight.css') ?>
<section class="cadre_gris" id="interface_fighter">
  <h3>Fighter</h3>
</section>
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
        <td>Bouger</td>
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
        <td>Attaquer</td>
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
