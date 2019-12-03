<table class="table table-hover border"cellpadding="0" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('code') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('test_day') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject): ?>
                <tr>
                    <td><?= h($subject->code) ?></td>
                    <td><?= h($subject->name) ?></td>
                    <td><?= h($subject->test_day) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['action' => 'edit', $subject->id],['class' => 'btn btn-warning', 'escape' => false])?>
                        <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $subject->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>