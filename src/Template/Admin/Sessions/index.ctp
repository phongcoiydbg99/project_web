<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Session[]|\Cake\Collection\CollectionInterface $sessions
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Quản lý kì thi</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="card">
        <div class="card-header">
            <h4 class="float-left">Kì thi</h4>
            <?= $this->Html->Link('<i class="fas fa-plus-circle"></i>', ['action' => 'add'], ['class' => 'btn btn-primary float-right ml-1', 'escape' => false]) ?>
        </div>
        <div class="card-body">
            <div class="content_table">
                <table class="table table-hover border" cellpadding="0" cellspacing="0">
                    <thead class="thead-light"> 
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('name','Tên học kì') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('year','Năm') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('start_time','Bắt đầu đăng ký') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('last_time','Kết thúc đăng ký') ?></th>
                            <th scope="col" class="actions "><?= __('Hành vi') ?></th>
                            <th colspan="" rowspan="" headers="" scope="col">Chọn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sessions as $session): ?>
                        <tr>
                            <td><?= h($session->name) ?></td>
                            <td><?= h($session->year) ?></td>
                            <td><?= h($session->start_time) ?></td>
                            <td><?= h($session->last_time) ?></td>
                            <td class="actions"> 
                                <?= $this->Html->link('<i class="fas fa-tasks"></i>', ['action' => 'view', $session->id],['class' => 'btn btn-success', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['action' => 'edit', $session->id],['class' => 'btn btn-warning', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $session->id], ['confirm' => __('Bạn chắc chắn xóa # {0}?', $session->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
                            </td>
                            <?php if ($session->choose == 1) {?>
                            <td>
                                <div class="custom-control custom-radio">
                                  <input type="radio" class="custom-control-input" id="customRadio<?=$session->id?>" name="example" onchange='radioSession(<?=$session->id?>)' checked>
                                  <label class="custom-control-label" for="customRadio<?=$session->id?>"></label>
                                </div>
                            </td>
                            <?php }else{ ?>
                            <td>
                                <div class="custom-control custom-radio">
                                  <input type="radio" class="custom-control-input" id="customRadio<?=$session->id?>" name="example" onchange='radioSession(<?=$session->id?>)'>
                                  <label class="custom-control-label" for="customRadio<?=$session->id?>"></label>
                                </div>
                            </td>
                            <?php }?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="paginator">
                <ul class="pagination">
                    <?php
                    $this->Paginator->templates([
                        'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'prevDisabled' => '<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'current' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'first' => '<li class="page-item "><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'last' => '<li class="page-item "><a class="page-link" href="{{url}}">{{text}}</a></li>'
                    ]); ?>
                    <?= $this->Paginator->first('<< ' . __('First')) ?>
                    <?= $this->Paginator->prev('< ' . __('Previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('Next') . ' >') ?>
                    <?= $this->Paginator->last(__('Last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
            </div>
        </div>
    </div>
</div>
<script>
    function radioSession(id)
    {
        $.ajax({
            url: baseUrl + 'admin/sessions/radioSession',
            type: 'post',
            data: {
                id : id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (res) {
            },
            error: function () {

            }
        })  
    }
</script>