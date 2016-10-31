

    <?php $this->assign('title', 'WebArena - Réinitialisation du mot de passe');?>
	<?php $this->assign('header_title', 'Réinitialisation du mot de passe');?>

		<section>
			<?= $this->Form->create('Email') ?>
			<fieldset>
				<legend><?= __('Entrer votre adresse mail') ?></legend>
				<?= $this->Form->input('email',['label' => 'E-mail']) ?>
        <?= $this->Form->button(__('Réinitialiser')); ?>
			</fieldset>
			<?= $this->Form->end() ?>
		</section>
