
<?php 
	echo $this->Html->script('jquery.min.js');
	echo $this->Html->script('BxSlider.jquery.bxslider.min');
	echo $this->Html->css('BxSlider.jquery.bxslider');
        
	echo $this->Html->css('Arenas/index.css');
        echo $this->Html->css('champions/fighters.css');
        
	$this->assign('title', 'WebArena - Champions');	
	$this->assign('header_title', 'Champions');?>
	


<div id="main-content">
    <!-- access session variables-->
    <?php pr( $PlayerFighterId ) ?>
    <?php pr( $this->request->session()->read('PlayerFighterSkin'))?>

    <h3>Selectionnez votre personnage</h3>
    
    <div id="fighterslider">
        <ul class="test">
                <li><?php  echo $this->Html->image("miniatures/rogue.png", ["alt" => "rogue"]);?></li>
                <li><?php  echo $this->Html->image("miniatures/xena.png", ["alt" => "xena"]);?></li>
                <li><?php  echo $this->Html->image("miniatures/sorcier.png", ["alt" => "sorcier"]);?></li>
                <li><?php  echo $this->Html->image("miniatures/elf.png", ["alt" => "elf"]);?></li>
        </ul>
    </div> 
    
    	<!--Script pour afficher le slider-->
	<script>
var slider = $('.test').bxSlider({
    mode: 'horizontal',
    autoControls: false,
    touchEnabled: true,
    pager: false
});

$('a.bx-next').click(function () {
    var current = slider.getCurrentSlide();
    alert(current+1);
});
$('a.bx-next').click(function () {
    var current = slider.getCurrentSlide();
    alert(current+1);
  
});
	</script>
    
    <div class="fighters index large-9 medium-8 columns content">
    <h3><?= __('Combattants') ?></h3>
    
    
    
    <?php
    if(!empty($fighters)){?>
   <p>
        Sur cette page, vous pouvez visualiser vos combattants et les modifier.
        Vous pouvez aussi choisir un combattant, en créer un nouveau ou bien passer au niveau suivant.
    </p> 
    
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">Name</th>
          
                <th scope="col">Level</th>
                <th scope="col">Exp.</th>
                
                <th scope="col">Health</th>
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
                    <?= $this->Html->link(__('Modifier'), ['action' => 'fighterEdit', $fighter->id]) ?>
                    <?= $this->Form->postLink(__('Supprimer'), ['action' => 'fighterDelete', $fighter->id], ['confirm' => __('Voulez vous vraiment supprimer le combattant: {0}?', $fighter->name)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php    } else {    ?>
    <p>Vous n'avez aucun combattant à afficher! Veuillez créer votre personnage pour débuter le jeu.</p>
    <?php }    ?>
     
    
    <?= $this->Html->link('Nouveau combattant', array('controller' => 'Arenas', 'action' => 'fighterNew'),array('class'=>'button_red')); ?>
    </div>
  
 
  
</div>
