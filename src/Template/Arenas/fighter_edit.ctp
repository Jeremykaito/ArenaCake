
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
        
        
<section >
<div id="main-content">

 
            <section>             
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

                
            </section>
    
    
</div>

   
</section>