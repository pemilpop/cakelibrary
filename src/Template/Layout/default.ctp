<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: ';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
	<?= $this->Html->css('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css') ?>

	<?=  $this->Html->script('//code.jquery.com/jquery-1.10.2.js'); ?>
    <?= $this->Html->script('//code.jquery.com/ui/1.11.4/jquery-ui.js') ?>
    <?= $this->Html->script('autocomplete') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <?php
                if ($this->Session->read('Auth.User')) { 
                    echo'<h1>'. $this->Html->link( $this->Session->read('Auth.User')['name']
                        , ['controller' => 'users', 'action' => 'view'
                        , $this->Session->read('Auth.User')['id'] ]).'</h1>';
                }
                ?>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul>
                <li><?=$this->Html->link('BOOKS', ['controller' => 'books', 'action' => 'index']) ?></li>
                <li><?=$this->Html->link('AUTHORS', ['controller' => 'authors', 'action' => 'index']) ?></li>
            </ul>
            <ul class="login">
			<li>
				<?php 
					if (!$this->Session->read('Auth.User')) { 
						echo $this->Html->link('Login', ['controller' => 'users', 'action' => 'login']);
					} else {
						echo  $this->Html->link($this->Session->read('User.name'). ' Logout', ['controller' => 'users', 'action' => 'logout']);
					}
				?>
			</li>
            </ul>
        </div>
    </nav>
	
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
