<?php

/**
* CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
* Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
*
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
* @link          http://cakephp.org CakePHP(tm) Project
* @since         0.10.0
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?= $this->Html->meta('icon') ?>
  <?= $this->Html->css('base.css') ?>
  <?= $this->Html->css('template.css') ?>
  <!--Ne pas supprimer-->
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
  <!---->

  <title><?= $this->fetch('title') ?></title>
</head>

<body>
<header>
  <!--Menu de navigation-->
  <nav>
    <!--//If the player is logged in-->
    <?php
    if ($this->request->session()->read('PlayerLoggedIn')){?>
      <ul>
        <li><?= $this->Html->link('Jouer', array('controller' => 'Arenas', 'action' => 'sight')); ?></li>
        <li><?= $this->Html->link('Champions', array('controller' => 'Arenas', 'action' => 'fighter')); ?></li>
        <li id="logo">
          <?= $this->Html->link(
          $this->Html->image('menu/logo.png', array('alt' => "Web ARENA")),
          array('controller' => 'Arenas', 'action' => 'index'),
          array('escape' => false)
        );?>
      </li>
      <li><?= $this->Html->link('Journal', array('controller' => 'Arenas', 'action' => 'diary')); ?></li>
      <li><?= $this->Html->link('Hall of fame', array('controller' => 'Public', 'action' => 'hall')); ?></li>
      <li id="sortie">
      <?= $this->Html->link(
          $this->Html->image('menu/sortie.png', array('alt' => "Deconnexion")),
          array('controller' => 'Public', 'action' => 'logout'),
          array('escape' => false)
        ); ?>
      <li>
    </ul>
    <?php
  }
  //If the player is NOT logged in
  else { ?>
    <ul>
      <li><?= $this->Html->link('Connexion', array('controller' => 'Public', 'action' => 'login')); ?></li>
      <li id="logo">
        <?= $this->Html->link(
        $this->Html->image('menu/logo.png', array('alt' => "Web ARENA")),
        array('controller' => 'Arenas', 'action' => 'index'),
        array('escape' => false)
        );?>
      </li>
      <li><?= $this->Html->link('Inscription', array('controller' => 'Public', 'action' => 'add')); ?></li>
      <li><?= $this->Html->link('Hall of fame', array('controller' => 'Public', 'action' => 'hall')); ?></li>
    </ul>
  <?php } ?>
</nav>
  <figure class="header_left">
    <?= $this->Html->image('champions/rogue.png', array('alt' => "Rogue")); ?>
    <?= $this->Html->image('champions/elf.png', array('alt' => "Elf")); ?>
  </figure>
  <figure class="header_right">
    <?= $this->Html->image('champions/xena.png', array('alt' => "Xena")); ?>
    <?= $this->Html->image('champions/sorcier.png', array('alt' => "Sorcier")); ?>
  </figure>
</header>

<!--Conteneur principal de la page -->
<main class="container clearfix">
  <?= $this->Flash->render() ?>
  <h1><?= $this->fetch('header_title') ?></h1>
  <?= $this->fetch('content') ?>
</main>

<!--Footer -->
<footer>
  <section id="information">
    <h3>Groupe : SI1 Gr1-01-AE</h3>
    <p>Options : A, E, D</p>
    <p>Auteurs : Jeremy Ha, Emmanuel Jequier, Annelyse Nugue, Kevin Rahetilahy<p/>
</section>
<p id="copyright">Copyright 2016 © - ArenaCake</p>
</footer>

</body>
</html>
