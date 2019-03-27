
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Register'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <fieldset>
        <legend><?= __('Login') ?></legend>
        <?php
            echo $this->Form->create();
			echo $this->Form->control('email');
			echo $this->Form->control('password');
			echo $this->Form->button('Login');
			echo $this->Form->end();
        ?>
    </fieldset>
</div>