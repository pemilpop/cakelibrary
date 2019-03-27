<!-- src/Template/Common/view.ctp -->
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <?= $this->fetch('sidebar') ?>
    </ul>
</nav>
<?= $this->fetch('content') ?>