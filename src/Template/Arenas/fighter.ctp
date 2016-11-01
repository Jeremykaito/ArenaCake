<?= $this->Html->css('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('jquery.min.js');?>
<?= $this->Html->script('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('Datatables.shCore'); ?>

    <?php
    echo $this->Html->script('BxSlider.jquery.bxslider.min');
    echo $this->Html->css('BxSlider.jquery.bxslider');

    echo $this->Html->css('Arenas/index.css');
    echo $this->Html->css('champions/fighters.css');

    $this->assign('title', 'WebArena - Champions');
    $this->assign('header_title', 'Champions');?>

	<script>
		$(document).ready(function () {
		  $('#fighters').DataTable({
		    "paging":   false,
		    "info":     false,
		    "filter":   false,
				"columnDefs": [
			{ targets: [4], sortable: false}]
		  });
		});
        </script>


<div id="main-content">
    <!-- access session variables -->
    <?php pr( $this->request->session()->read('PlayerFighterSkin'));?>
    <?php pr( $this->request->session()->read('PlayerFighterId'));?>
    	
    

    <div class="fighters index large-9 medium-8 columns content">
    <h3><?= __('Combattants') ?></h3>



    <?php
    if(!empty($playerfighters)){?>
   <p>
        Sur cette page, vous pouvez visualiser vos combattants et les modifier.
        Vous pouvez aussi choisir un combattant, en créer un nouveau ou bien passer au niveau suivant.
    </p>

    <table id="fighters" cellpadding="0" cellspacing="0">
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
            <?php foreach ($playerfighters as $fighter): ?>
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

    
    <!-- Select a personnage and level-->
                 <?= $this->Form->create() ?>
                <fieldset>

                    <legend><?= __('Combattant') ?></legend>

                    <h4> Sélection du combattant:</h4>
                    <?php  echo $this->Form->input('name',['label'=>'Nom' ,'options' => $fighterslist]); ?>
                        <div id="fighterslider">
                            <ul class="oSlider">
                                <li><?php  echo $this->Html->image("miniatures/rogue.png", ["alt" => "rogue"]);?></li>
                                <li><?php  echo $this->Html->image("miniatures/xena.png", ["alt" => "xena"]);?></li>
                                <li><?php  echo $this->Html->image("miniatures/sorcier.png", ["alt" => "sorcier"]);?></li>
                                <li><?php  echo $this->Html->image("miniatures/elf.png", ["alt" => "elf"]);?></li>
                            </ul>
                        </div> 
                    <?php  echo $this->Form->input('avatar',['type' => 'hidden']); ?> 

                    
                    
                </fieldset>
                <?= $this->Form->button(__('Jouer')) ?>
                <?= $this->Form->end() ?>


    <?php    } else {    ?>
    <p>Vous n'avez aucun combattant à afficher! Veuillez créer votre personnage pour débuter le jeu.</p>
    <?php }    ?>

    </div>

 <!--Script pour afficher le slider-->
	<script>
            var slider = $('.oSlider').bxSlider({
                mode: 'horizontal',
                autoControls: false,
                touchEnabled: true,
                pager: false
            });

            /** initialize input value **/
            var current=0; //default
            $("#avatar").val(getCorrespondigAvatar(current));

            $('a.bx-next').click(function () {
                var current = slider.getCurrentSlide();
                //alert(current+1);
                $("#avatar").val(getCorrespondigAvatar(current));
            });
            $('a.bx-prev').click(function () {
                var current = slider.getCurrentSlide();
                //alert(current+1);
                $("#avatar").val(getCorrespondigAvatar(current));
            });

            function getCorrespondigAvatar(currentid){

                switch (currentid) {
                    case 0: avatar = "rogue"; break;
                    case 1: avatar = "xena"; break;
                    case 2: avatar = "sorcier";break;
                    case 3: avatar = "elf";break;
                }
                return avatar;
            }


	</script>

    <?= $this->Html->link('Nouveau combattant', array('controller' => 'Arenas', 'action' => 'fighterNew'),array('class'=>'button_red')); ?>
    <br>   
        
</div>
