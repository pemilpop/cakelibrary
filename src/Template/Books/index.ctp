<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book[]|\Cake\Collection\CollectionInterface $books
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Book'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('New Author'), ['controller' => 'Authors', 'action' => 'add']) ?></li>
    </ul>
    <?php  $cell = $this->cell('Posts'); ?>
    <?= $cell ?>
</nav>
<div class="books index large-9 medium-8 columns content">
    <h3><?= __('Books') ?></h3>
    <div style="width:30%">
        <?= $this->Form->input('search', ['label' => false, 'placeholder' => 'Search', 'id' => 'search']) ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('author') ?></th>
                <th scope="col"><?= $this->Paginator->sort('published') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= h($book->title) ?></td>
                <td><?= $book->has('author') ? $this->Html->link($book->author->name, ['controller' => 'Authors', 'action' => 'view', $book->author->id]) : '' ?></td>
                
                <td><?= h($book->published) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $book->slug]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $book->slug]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $book->slug], ['confirm' => __('Are you sure you want to delete  {0} ?', $book->title)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
