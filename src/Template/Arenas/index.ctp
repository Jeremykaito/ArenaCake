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
	
	<!--Présentation du jeu-->
	<section class='cadre_gris'>
            
            <div>
		<h2>Bienvenue dans WebArena !</h2>
		<p>WebArena est un jeu multijoueur qui vous permet d'affronter vos amis en ligne.</p>
		<p>Créez un ou plusieurs personnages, gagnez des équipements et de l'expérience, et devenez toujours plus fort !</p>
		<p>L'Arène Herbeuse est remplie de trophées laissés par d'autres aventuriers qui, comme vous, ont tenté leur chance dans l'Arène.
		Prenez garde car vous pourriez bien tomber dans un piège ou bien nez à nez avec un monstre errant...</p>
		<p>Consultez le Hall of Fame pour tout connaître de vos statistiques et vous améliorer continuellement.</p>
		<p>L'Arène Herbeuse n'attend plus que vous ! Êtes-vous prêt ?</p>
            </div>
            
            <div id="sliderPerso">
		<!-- Le slider des personnages-->
		<ul class="bxslider">
			<li><?php  echo $this->Html->image("champions/rogue.png", ["alt" => "rogue"]);?></li>
			<li><?php  echo $this->Html->image("champions/xena.png", ["alt" => "xena"]);?></li>
			<li><?php  echo $this->Html->image("champions/sorcier.png", ["alt" => "sorcier"]);?></li>
			<li><?php  echo $this->Html->image("champions/elf.png", ["alt" => "elf"]);?></li>
		</ul>
                <?= $this->Html->link('Inscription', array('controller' => 'Players', 'action' => 'add'),array('class'=>'button_red')); ?>
            </div>  
            
        </section>
	
	<!--Présentation des combattants-->
	<section class='cadre_gris'>
	
		<h2>Les combattants de l'Arène Herbeuse</h2>
		
		<!-- La description des personnages-->
		<dl>
                        <dt><?php echo $this->Html->image("champions/rogue.png", ["alt" => "rogue"])?> Sly le voleur</dt>
			<dd> Sly a grandi dans l'Arène Herbeuse. Habitué à l'arpenter depuis son enfance, il doit sa survie à sa grande 
			agilité et à son intelligence hors du commun. Son arme de prédilection est le poignard, qui lui sert à couper les
			bourses pleines d'or des honnêtes citoyens de l'Arène.</dd>
			
			<dt><?php  echo $this->Html->image("champions/xena.png", ["alt" => "xena"]);?>Xena la guerrière</dt>
			<dd>Après avoir vaincu de nombreux adversaires dans divers tournois, Xena a décidé de se mesurer à l'âpreté de l'Arène herbeuse.
			Accompagnée de sa fidèle épée, elle espère bien faire mordre la poussière à quiconque osera se mettre en travers de sa route.</dd>
			
			<dt><?php  echo $this->Html->image("champions/sorcier.png", ["alt" => "sorcier"]);?>Mantis le sorcier</dt>
			<dd>D'aussi loin qu'il s'en souvienne, Mantis a toujours été attiré par les arts sombres. Sous la houlette du grand Merlin, 
			il a repoussé les limites de son esprit dont il se sert désormais comme d'une arme. Assoiffé de gloire et de reconnaissance, 
			Mantis compte bien se forger une réputation dans l'Arène Herbeuse.</dd>
			
			<dt><?php  echo $this->Html->image("champions/elf.png", ["alt" => "elf"]);?>Winky l'elfe</dt>
			<dd>Sous son air timide et effrayé, Winky cache bien son jeu. Combattante aguerrie, elle connaît sur le bout des doigts les
			secrets de la magie de son peuple. Ses yeux bleus perçants et son bâton sont ses principaux alliés pour venir à bout des ennemis 
			qu'elle rencontre. On raconte qu'elle serait à la recherche d'un trésor légendaire enfoui dans le sol de l'Arène Herbeuse...</dd>
		</dl>
	</section>

	<aside class='news'>
		<h3 class='text_light'>Un nouveau combattant fait son entrée dans l'Arène !</h3>
                <p>Découvrez Winky, le nouveau personnage de WebArena. Winky est une elfe qui semble
                être à la recherche d'un trésor légendaire enfoui dans l'Arène Herbeuse...</p>
                <p>Vous pouvez jouer avez Winky dès maintenant !</p>
	</aside>
        
        <aside class='news'>
		<h3 class='text_light'>Un nouveau combattant fait son entrée dans l'Arène !</h3>
                <p>Découvrez Winky, le nouveau personnage de WebArena. Winky est une elfe qui semble
                être à la recherche d'un trésor légendaire enfoui dans l'Arène Herbeuse...</p>
                <p>Vous pouvez jouer avez Winky dès maintenant !</p>
	</aside>