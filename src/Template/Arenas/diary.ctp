<?php 
	$this->assign('title', 'WebArena - Journal');	
	$this->assign('header_title', 'Journal');?>

<section class='cadre_gris'>
    
    <p>Bienvenue dans le journal ! </p>
    <p>Ici, vous pouvez voir les évènements qui se sont produits au cours des dernières 24h à proximité de vos personnages.</p>
    <p>Ainsi, vous êtes sûr de n'avoir rien raté pendant votre absence !</p>
    
    <?php 
    if(!empty($events)){?>
    <table>
    <?php 
    foreach ($events as $event): ?>
    <tr>
        <td><?= $event->name ?></td>
        <td><?= $event->date ?></td>
        <td><?= $event->coordinate_x ?></td>
        <td><?= $event->coordinate_y ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    <?php
    }
    else{?>
        <p>Il n'y a aucun évènement à afficher ! Revenez plus tard.</p>
    <?php }
    ?>
</section>