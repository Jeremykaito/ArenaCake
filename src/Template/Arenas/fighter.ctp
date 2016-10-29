
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
    
    
    
    
    <div class="fighters form large-9 medium-8 columns content">
    <form method="post" accept-charset="utf-8" action="/WebArenaGoupSIA-01-AE/fighters/edit/1"><div style="display:none;"><input type="hidden" name="_method" value="PUT"></div>    <fieldset>
        <legend>Edit Fighter</legend>
            <div class="input text required">
            <label for="name">Name</label>
            <input type="text" name="name" required="required" maxlength="45" id="name" value="Aragorn">
            </div>
            <div class="input select">
                <label for="player-id">Player</label>
                <select name="player_id" id="player-id">
                    <option value="4e7b8797-5a3c-2df1-c077-3a31b4715557">4e7b8797-5a3c-2df1-c077-3a31b4715557</option>
                    <option value="545f827c-576c-4dc5-ab6d-27c33186dc3e" selected="selected">545f827c-576c-4dc5-ab6d-27c33186dc3e</option>
                    <option value="b1ee586e-942e-f23b-e352-2948ee614e93">b1ee586e-942e-f23b-e352-2948ee614e93</option></select>
            </div>
            <div class="input number required">
                <label for="coordinate-x">Coordinate X</label>
                <input type="number" name="coordinate_x" required="required" id="coordinate-x" value="2">
            </div>
            <div class="input number required">
                <label for="coordinate-y">Coordinate Y</label>
                <input type="number" name="coordinate_y" required="required" id="coordinate-y" value="3">
            </div><div class="input number required">
                <label for="level">Level</label>
                <input type="number" name="level" required="required" id="level" value="6">
            </div><div class="input number required"><label for="xp">Xp</label>
                <input type="number" name="xp" required="required" id="xp" value="14">
            </div>
        <button type="submit">Submit</button>    
    </form></div>
    
    
</div>
