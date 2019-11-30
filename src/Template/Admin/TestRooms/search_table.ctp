<table class="table table-hover mt-5" cellpadding="0" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_computer') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($testRooms as $testRoom): ?>
            <tr>
                <td><?= $this->Number->format($testRoom->id) ?></td>
                <td><?= h($testRoom->name) ?></td>
                <td><?= $this->Number->format($testRoom->total_computer) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['action' => 'edit', $testRoom->id],['class' => 'btn btn-warning', 'escape' => false])?>
                    <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $testRoom->id], ['confirm' => __('Are you sure you want to delete # {0}?', $testRoom->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>