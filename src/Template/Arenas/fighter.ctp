
<?php 
	echo $this->Html->script('jquery.min.js');
	echo $this->Html->script('BxSlider.jquery.bxslider.min');
	echo $this->Html->css('BxSlider.jquery.bxslider');
	echo $this->Html->css('Arenas/index.css');
	$this->assign('title', 'WebArena - Accueil');	
	$this->assign('header_title', 'Accueil');?>
	
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
    <table>
        <?php foreach ($fighters as $fighter): ?>
        <tr>
            <td><?= $fighter->name ?></td>
        </tr>
    <?php endforeach; ?>
    </table>

    
                <div id="sliderPerso">
		<!-- Le slider des personnages-->
		<ul class="bxslider">
			<li><?php  echo $this->Html->image("champions/rogue.png", ["alt" => "rogue"]);?></li>
			<li><?php  echo $this->Html->image("champions/xena.png", ["alt" => "xena"]);?></li>
			<li><?php  echo $this->Html->image("champions/sorcier.png", ["alt" => "sorcier"]);?></li>
			<li><?php  echo $this->Html->image("champions/elf.png", ["alt" => "elf"]);?></li>
		</ul>
            </div>  
    
    
    
    
            <section>             
                <?= $this->Form->create($fighter) ?>
                <fieldset>
                    <legend><?= __('Edit Fighter') ?></legend>
                    <?php
                        echo $this->Form->input('name', ['options' => $fighter->name]);
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

                
            </section>
    
    
</div>
