
<?php 
	echo $this->Html->script('jquery.min.js');
	echo $this->Html->script('BxSlider.jquery.bxslider.min');
	echo $this->Html->css('BxSlider.jquery.bxslider');
	echo $this->Html->css('Arenas/index.css');
        echo $this->Html->css('champions/fighters.css');
        
	$this->assign('title', 'WebArena - Modifier un combattant');	
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
                        echo $this->Form->input('name',['label' => 'Nom']);
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Modifier')) ?>
                <?= $this->Form->end() ?>

                
            </section>
    
    
</div>

   
</section>