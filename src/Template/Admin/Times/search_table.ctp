<table class="table table-hover border"cellpadding="0" cellspacing="0">
    <thead class="thead-light">
        <tr>
        <th scope="col"><?= $this->Paginator->sort('test_day','Ngày thi') ?></th>
        <th scope="col"><?= $this->Paginator->sort('start_time','Bắt đầu') ?></th>
        <th scope="col"><?= $this->Paginator->sort('last_time','Kết thúc') ?></th>
        <th scope="col" class="actions"><?= __('Hành vi') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($times as $time): ?>
        <tr>
            <td><?= date("d/m/Y", strtotime($time->test_day)) ?></td>
            <td><?= h(date('H:i',strtotime($time->start_time))) ?></td>
            <td><?= h(date('H:i',strtotime($time->last_time))) ?></td>
            <td class="actions">
                    <?= $this->Html->link('<i class="fas fa-tasks"></i>', ['action' => 'view',$time->id],['class' => 'btn btn-success', 'escape' => false]) ?>
                    <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $time->id], ['confirm' => __('Bạn chắc chắn xóa # {0}?', $time->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>