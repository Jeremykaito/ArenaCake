
	<?php $this->assign('title', 'WebArena - Connexion');?>
		<?php $this->assign('header_title', 'Connexion');?>

		<section>
			<?= $this->Flash->render('auth') ?>
			<?= $this->Form->create() ?>
			<fieldset>
				<legend><?= __("Se connecter") ?></legend>
				<?= $this->Form->input('email',['label' => 'E-mail']) ?>
				<?= $this->Form->input('password',['label' => 'Mot de passe']) ?>
			</fieldset>
			<?= $this->Form->button(__('Se Connecter')); ?>
			<?= $this->Form->end() ?>
		</section>

		<p><?php echo $this->Html->link('Mot de passe oublié', array('controller' => 'Public', 'action' => 'resetPassword')); ?></p>
