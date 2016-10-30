
<?php 
	echo $this->Html->script('jquery.min.js');
	echo $this->Html->script('BxSlider.jquery.bxslider.min');
	echo $this->Html->css('BxSlider.jquery.bxslider');
	echo $this->Html->css('Arenas/index.css');
        echo $this->Html->css('champions/fighters.css');
        
	$this->assign('title', 'WebArena - Accueil');	
	$this->assign('header_title', 'Champions');?>
	
	<!--Script pour afficher le slider-->
	<script>
		$(document).ready(function(){
		$('.bxslider').bxSlider({
		mode: 'vertical',
		pause: 1000,
		speed: 2000,
		auto: true,
		});
		});
	</script>





<div id="main-content">
    

  <!-- 
    <div id="sliderPerso">
        <ul class="bxslider">
                <li><?php  echo $this->Html->image("champions/rogue.png", ["alt" => "rogue"]);?></li>
                <li><?php  echo $this->Html->image("champions/xena.png", ["alt" => "xena"]);?></li>
                <li><?php  echo $this->Html->image("champions/sorcier.png", ["alt" => "sorcier"]);?></li>
                <li><?php  echo $this->Html->image("champions/elf.png", ["alt" => "elf"]);?></li>
        </ul>
    </div> -->
    
    
    <div class="fighters index large-9 medium-8 columns content">
    <h3><?= __('Combattants') ?></h3>
    
    <p>
        Vous pouvez gérer tous les paramètres de vos combattants sur cette page.
        Vous pouvez customizer vos combattants, choisir le niveau souhaité.
    </p>
    
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
          
                <th scope="col"><?= $this->Paginator->sort('level') ?></th>
                <th scope="col"><?= $this->Paginator->sort('xp') ?></th>
                
                <th scope="col"><?= $this->Paginator->sort('current_health') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fighters as $fighter): ?>
            <tr>
                <td><?= h($fighter->name) ?></td>
               
                <td><?= $this->Number->format($fighter->level) ?></td>
                <td><?= $this->Number->format($fighter->xp) ?></td>

                <td><?= $this->Number->format($fighter->current_health) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('afficher'), ['action' => 'edit', $fighter->id]) ?>
                    <?= $this->Form->postLink(__('supprimer'), ['action' => 'delete', $fighter->id], ['confirm' => __('Voulez vous vraiment supprimer le combattant: {0}?', $fighter->name)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
          <!--  <section>             
                <?= $this->Form->create($fighter) ?>
                <fieldset>
                    <legend><?= __('Edit Fighter') ?></legend>
                    <?php
                        echo $this->Form->input('name');
                        echo $this->Form->input('level');
                        echo $this->Form->input('xp');
                      //  echo $this->Form->input('skill_sight');
                      //  echo $this->Form->input('skill_strength');
                      //  echo $this->Form->input('skill_health');
                      //  echo $this->Form->input('current_health');
                      //  echo $this->Form->input('next_action_time', ['empty' => true]);
                      //  echo $this->Form->input('guild_id', ['options' => $guilds, 'empty' => true]);
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>

                
            </section>-->
    
    
</div>
