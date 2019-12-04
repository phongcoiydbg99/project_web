<table class="table table-hover border" cellpadding="0" cellspacing="0">
    <thead class="thead-light"> 
        <tr>
            <!-- <th scope="col"><?= $this->Paginator->sort('id') ?></th> -->
            <th scope="col" class="pl-4"><?= $this->Paginator->sort('username') ?></th>
            <th scope="col"><?= $this->Paginator->sort('last_name','Họ và tên') ?></th>
            <th scope="col"><?= $this->Paginator->sort('date_birth') ?></th>
            <th scope="col"><?= $this->Paginator->sort('class') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <!-- <td><?= $this->Number->format($user->id) ?></td> -->
            <td class="pl-4"><?= h($user->username) ?></td>
            <td><?= h($user->first_name.' '.$user->last_name) ?></td>
            <td><?= h($user->date_birth->i18nFormat('yyyy-MM-dd')) ?></td>
            <td><?= h($user->class) ?></td>
            <td class="actions">
                <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['action' => 'edit', $user->id],['class' => 'btn btn-warning', 'escape' => false]) ?>
                <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>    