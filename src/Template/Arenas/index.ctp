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
                controls:false
	});
});
</script>

<!--Présentation du jeu-->
<div id="intro">
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
				<li><?php  echo $this->Html->image("champions/Voleur.png", ["alt" => "Voleur"]);?></li>
				<li><?php  echo $this->Html->image("champions/Xena.png", ["alt" => "Xena"]);?></li>
				<li><?php  echo $this->Html->image("champions/Sorcier.png", ["alt" => "Sorcier"]);?></li>
				<li><?php  echo $this->Html->image("champions/Elfe.png", ["alt" => "Elfe"]);?></li>
			</ul>
			<?= $this->Html->link('Inscription', array('controller' => 'Public', 'action' => 'add'),array('class'=>'button_red')); ?>
		</div>

	</section>
			<!--Présentation des combattants-->
			<section class='cadre_gris'>

				<h2>Les combattants de l'Arène Herbeuse</h2>
				<!-- La description des personnages-->
				<dl>
					<dt><?php echo $this->Html->image("champions/Voleur.png", ["alt" => "Voleur"])?> Sly le voleur</dt>
					<dd> Sly a grandi dans l'Arène Herbeuse. Habitué à l'arpenter depuis son enfance, il doit sa survie à sa grande
						agilité et à son intelligence hors du commun. Son arme de prédilection est le poignard, qui lui sert à couper les
						bourses pleines d'or des honnêtes citoyens de l'Arène.</dd>

						<dt><?php  echo $this->Html->image("champions/Xena.png", ["alt" => "Xena"]);?>Xena la guerrière</dt>
						<dd>Après avoir vaincu de nombreux adversaires dans divers tournois, Xena a décidé de se mesurer à l'âpreté de l'Arène Herbeuse.
							Accompagnée de sa fidèle épée, elle espère bien faire mordre la poussière à quiconque osera se mettre en travers de sa route.</dd>

							<dt><?php  echo $this->Html->image("champions/Sorcier.png", ["alt" => "Sorcier"]);?>Mantis le Sorcier</dt>
							<dd>D'aussi loin qu'il s'en souvienne, Mantis a toujours été attiré par les arts sombres. Sous la houlette du grand Merlin,
								il a repoussé les limites de son esprit dont il se sert désormais comme d'une arme. Assoiffé de gloire et de reconnaissance,
								Mantis compte bien se forger une réputation dans l'Arène Herbeuse.</dd>

								<dt><?php  echo $this->Html->image("champions/Elfe.png", ["alt" => "Elfe"]);?>Winky l'Elfe</dt>
								<dd>Sous son air timide et effrayé, Winky cache bien son jeu. Combattante aguerrie, elle connaît sur le bout des doigts les
									secrets de la magie de son peuple. Ses yeux bleus perçants et son bâton sont ses principaux alliés pour venir à bout des ennemis
									qu'elle rencontre. On raconte qu'elle serait à la recherche d'un trésor légendaire enfoui dans le sol de l'Arène Herbeuse...</dd>
								</dl>
							</section>
</div>
<aside class='cadre_jaune news'>
	<h3 class='text_light'>Un nouveau combattant fait son entrée dans l'Arène !</h3>
	<p>Winky est une Elfe qui semble
		être à la recherche d'un trésor légendaire enfoui dans l'Arène Herbeuse...</p>
		<p>Vous pouvez jouer avec Winky dès maintenant !</p>
	</aside>

	<aside class='cadre_jaune news'>
		<h3 class='text_light'>Nouvelle fonctionnalité</h3>
		<p>Une nouvelle fonctionnalité a été ajoutée : le Hall of Fame ! Cette page
			vous permet de voir les statistiques des joueurs de WebArena. Utile pour s'améliorer !</p>
		</aside>
