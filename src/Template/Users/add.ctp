<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Add new user');
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Register') ?></legend>
        <?php
            echo $this->Form->control('name', ['placeholder' => 'Search']);
            echo $this->Form->control('email', ['placeholder' => 'example@cakelibrary.com']);
            echo $this->Form->control('password', ['placeholder' => 'Password']);
            echo $this->Form->control('confirm_password', ['type'=>'password', 'placeholder' => 'Confirm Password']);
			echo $this->Captcha->create('captcha_input_field_name', ['type'=>'math']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
