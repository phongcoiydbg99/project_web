<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TestRoom $testRoom
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Test Rooms'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="testRooms form large-9 medium-8 columns content">
    <?= $this->Form->create($testRoom) ?>
    <fieldset>
        <legend><?= __('Add Test Room') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('total_computer');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
