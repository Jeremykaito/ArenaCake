<html lang="fr">

  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <title>WebArena - Log in</title>
  </head>

  <body>
	<header>
		<h1>Log in</h1>
	</header>
	
	<main>	

		<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Log in') ?></legend>
        <?= $this->Form->input('email') ?>
        <?= $this->Form->input('password') ?>
   </fieldset>
		<?= $this->Form->button(__('Submit')); ?>
		<?= $this->Form->end() ?>
	</main>
	
	<footer>
		
  	</footer>
  </body>
</html>