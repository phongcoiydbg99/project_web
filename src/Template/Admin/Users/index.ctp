<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Quản lý sinh viên</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Sinh viên</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="card">
        <div class="card-header">
            <h4 class="float-left">Danh sách</h4>
            <?= $this->Html->Link('<i class="fas fa-plus-circle"></i>', ['action' => 'add'], ['class' => 'btn btn-primary float-right ml-1', 'escape' => false]) ?>
            <a href="#" class="btn btn-primary float-right ml-1" onclick="upload(this)" data-toggle="modal" data-target="#myModal"><i class="fas fa-upload"></i></a> 
            <?= $this->Form->postLink('<i class="fas fa-download"></i>', ['action' => 'export'], ['class' => 'btn btn-primary float-right ml-1', 'escape' => false]) ?>
            <?= $this->Form->control('search',['class'=>'form-control float-right w-25 ml-1','type'=> 'text','id'=>'search','label'=>false,'placeholder'=>'Tìm kiếm tên sinh viên..','onkeyup'=>'searchTable(this.value,"admin/users/searchTable")']) ?>
            <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Import</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <?= $this->Form->create($import,['type' => 'file','action' => 'import']) ?>
                            <div class="form-group">
                                <label class="sr-only" for="csv"> CSV </label>
                                <?php echo $this->Form->input('csv', ['type'=>'file','class' => '', 'label' => false, 'placeholder' => 'csv upload','accept'=>'.csv,.xls,.xlsx']); ?>
                            </div>
                            <hr >
                            <button type="submit" name="submit" class="btn btn-default float-right"> Upload </button>
                            
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="content_table">
                <table class="table table-hover border" cellpadding="0" cellspacing="0">
                    <thead class="thead-light"> 
                        <tr>
                            <!-- <th scope="col"><?= $this->Paginator->sort('id') ?></th> -->
                            <th scope="col" class="pl-4"><?= $this->Paginator->sort('username','Mã sinh viên') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('last_name','Họ và tên') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('date_birth','Ngày sinh') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('class','Lớp') ?></th>
                            <th scope="col" class="actions"><?= __('Hành vi') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <!-- <td><?= $this->Number->format($user->id) ?></td> -->
                            <td class="pl-4"><?= h($user->username) ?></td>
                            <td><?= h($user->first_name.' '.$user->last_name) ?></td>
                            <td><?= h($user->date_birth->i18nFormat('dd/MM/yyyy')) ?></td>
                            <td><?= h($user->class) ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['action' => 'edit', $user->id],['class' => 'btn btn-warning', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Bạn chắc chắn muốn xóa # {0}?', $user->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
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

