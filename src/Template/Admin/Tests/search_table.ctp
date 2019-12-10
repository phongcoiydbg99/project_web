<table class="table table-hover border"cellpadding="0" cellspacing="0">
    <thead class="thead-light">
        <tr>
        <!-- <th scope="col"><?= $this->Paginator->sort('id') ?></th> -->
        <th scope="col"><?= $this->Paginator->sort('subject_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('test_room_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('test_day') ?></th>
        <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
        <th scope="col"><?= $this->Paginator->sort('last_time') ?></th>
        <th scope="col"><?= $this->Paginator->sort('computer_registered') ?></th>
        <th scope="col"><?= $this->Paginator->sort('total') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($tests as $test): ?>
        <tr>
            <!-- <td><?= $this->Number->format($test->id) ?></td> -->
            <td><?= $test->has('subject') ? $this->Html->link($test->subject->name, ['controller' => 'Subjects', 'action' => 'view', $test->subject->id]) : '' ?></td>
            <td><?= $test->has('test_room') ? $this->Html->link($test->test_room->name, ['controller' => 'TestRooms', 'action' => 'view', $test->test_room->id]) : '' ?></td>
            <td><?= $test->has('subject') ? $test->subject->test_day : '' ?></td>
            <td><?= h($test->start_time) ?></td>
            <td><?= h($test->last_time) ?></td>
            <td><?= $this->Number->format($test->computer_registered) ?></td>
            <td><?= $test->has('test_room') ? $this->Html->link($test->test_room->total_computer, ['controller' => 'TestRooms', 'action' => 'view', $test->test_room->id]) : '' ?></td>
            <td class="actions">
                 <?= $this->Html->link(__('View'), ['action' => 'view', $test->id]) ?>
                 <?= $this->Html->link(__('Edit'), ['action' => 'edit', $test->id]) ?>
                 <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $test->id], ['confirm' => __('Are you sure you want to delete # {0}?', $test->id)]) ?>
             </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>