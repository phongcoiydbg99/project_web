<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TestRoom $testRoom
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Test Room'), ['action' => 'edit', $testRoom->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Test Room'), ['action' => 'delete', $testRoom->id], ['confirm' => __('Are you sure you want to delete # {0}?', $testRoom->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Test Rooms'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Test Room'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="testRooms view large-9 medium-8 columns content">
    <h3><?= h($testRoom->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($testRoom->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($testRoom->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Computer') ?></th>
            <td><?= $this->Number->format($testRoom->total_computer) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Tests') ?></h4>
        <?php if (!empty($testRoom->tests)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Subject Id') ?></th>
                <th scope="col"><?= __('Test Room Id') ?></th>
                <th scope="col"><?= __('Start Time') ?></th>
                <th scope="col"><?= __('Last Time') ?></th>
                <th scope="col"><?= __('Computer Registered') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($testRoom->tests as $tests): ?>
            <tr>
                <td><?= h($tests->id) ?></td>
                <td><?= h($tests->subject_id) ?></td>
                <td><?= h($tests->test_room_id) ?></td>
                <td><?= h($tests->start_time) ?></td>
                <td><?= h($tests->last_time) ?></td>
                <td><?= h($tests->computer_registered) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tests', 'action' => 'view', $tests->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tests', 'action' => 'edit', $tests->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tests', 'action' => 'delete', $tests->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tests->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
