<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TestRoom[]|\Cake\Collection\CollectionInterface $testRooms
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Quản lý phòng thi</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Phòng thi</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="card">
        <div class="card-header">
            <h4 class="float-left">Danh sách</h4>
            <?= $this->Html->link('<i class="fas fa-plus-square"></i>',['action' => 'add'],['class' => "btn btn-primary float-right ml-1",'escape' => false]) ?>
            <?= $this->Form->control('search',['class'=>'form-control float-right w-25 ml-1','type'=> 'text','id'=>'search','label'=>false,'placeholder'=>'Tìm kiếm phòng thi..','onkeyup'=>'searchTable(this.value,"admin/test-rooms/searchTable")']) ?>
        </div>
        <div class="card-body">
            <div class="content_table">
                <table class="table table-hover" cellpadding="0" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('name','Phòng') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('total_computer','Tổng số máy tính') ?></th>
                            <th scope="col" class="actions"><?= __('Hành vi') ?></th>
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
                                <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $testRoom->id], ['confirm' => __('Bạn chắc chắn muốn xóa # {0}?', $testRoom->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
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

