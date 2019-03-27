<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $book->slug],
                ['confirm' => __('Are you sure you want to delete # {0}?', $book->slug)]
            )
        ?></li>
        <li><?= $this->Html->link(__('New Author'), ['controller' => 'Authors', 'action' => 'add']) ?></li>
    </ul>
     <?php  $cell = $this->cell('Posts'); ?>
    <?= $cell ?>
</nav>
<div class="books form large-9 medium-8 columns content">
    <?= $this->Form->create($book) ?>
    <fieldset>
        <legend><?= __('Edit Book') ?></legend>
        <?php
			echo $this->Form->control('title');
            echo $this->Form->control('author_name', 
									  ['type'=>'text', 
									  'required'=>true,
									  'id'=>'autocomplete',
                                      'placeholder' => 'Ionescu Vasile']
									  );
            echo $this->Form->control('description', ['type' => 'textarea', 'escape' => false, 'placeholder' => 'Description']);
            echo $this->Form->control('published',['placeholder' => 'Search']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
