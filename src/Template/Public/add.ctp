

    <?php $this->assign('title', 'WebArena - Inscription');?>
	<?php $this->assign('header_title', 'Inscription');?>

		<section>
			<?= $this->Form->create($player) ?>
			<fieldset>
				<legend><?= __('S\'inscrire') ?></legend>
				<?= $this->Form->input('email',['label' => 'E-mail']) ?>
				<?= $this->Form->input('password',['label' => 'Mot de passe']) ?>
			</fieldset>
			<?= $this->Form->button(__('Inscription')); ?>
			<?= $this->Form->end() ?>
		</section>
