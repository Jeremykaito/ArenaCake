

    <?php $this->assign('title', 'WebArena - Réinitialisation du mot de passe');?>
	<?php $this->assign('header_title', 'Réinitialisation du mot de passe');?>

		<section>
			<?= $this->Form->create('Email') ?>
			<fieldset>
				<legend><?= __('Rénitialisation du mot de passe') ?></legend>
				<?= $this->Form->input('email',['label' => 'E-mail']) ?>
			</fieldset>
			<?= $this->Form->button(__('Réinitialiser')); ?>
			<?= $this->Form->end() ?>
		</section>


