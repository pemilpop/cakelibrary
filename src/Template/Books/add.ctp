<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Author'), ['controller' => 'Authors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="books form large-9 medium-8 columns content">
    <?= $this->Form->create($book) ?>
    <fieldset>
        <legend><?= __('Add Book') ?></legend>
        <?php
			echo $this->Form->control('title', ['placeholder' => 'Title']);
            //echo $this->Form->control('author_id', ['options' => $authors]);
			echo $this->Form->control('author_name', ['type' => 'text', 'required'=>true, 'id'=>'autocomplete' , 'placeholder' => 'Ionescu Vasile']);
            echo $this->Form->control('description', ['type' => 'textarea', 'escape' => false , 'placeholder' => 'Description']);
            echo '<b>'.$this->Form->control('published',['placeholder' => '1980']).'</b>';
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

