<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $times
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Quản lý ca thi</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Thống kê</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <h3 class="float-left"><?= __('Danh sách') ?></h3>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="row">
                         <div class="col-lg-1">
                         </div>
                        <div class="col-lg-8">
                            <input type="text" class="float-right ml-5 datepicker" required="false" name="test_day" placeholder="Tìm kiếm ngày thi" onchange="searchTable(this.value,'admin/times/searchTable')">
                        </div>
                         <div class="col-lg-3">
                              <?= $this->Html->link('<i class="fas fa-plus-square"></i>',['action' => 'add'],['class' => "btn btn-primary float-right ml-1",'escape' => false]) ?>
                              <?= $this->Form->postLink('<i class="fas fa-download"></i>', ['action' => 'export'], ['class' => 'btn btn-primary float-right ml-1', 'escape' => false]) ?>
                         </div>
                        
                    </div>
                    
                </div>
                
            </div>
        </div>
        <div class="card-body">
            <div class="content_table">
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
                    <?= $this->Paginator->first('<< ' . __('Đầu')) ?>
                    <?= $this->Paginator->prev('< ' . __('Trước')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('Sau') . ' >') ?>
                    <?= $this->Paginator->last(__('Cuối') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(['format' => __('Trang {{page}} của {{pages}}, Hiển thị {{current}} bản ghi trong tổng số {{count}} bản ghi')]) ?></p>
            </div>
        </div>
    </div>
</div>
<script>

</script>