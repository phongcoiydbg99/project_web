<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject $subject
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><?= $this->Html->link(
                ' Quản lý ',
                '/admin/tests',
                ['escape' => false]
            ) ?></li>
          <li class="breadcrumb-item active">Môn thi</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="card">
        <div class="card-header">
    <h3><?= h($subject->name) ?></h3>
    </div>
    <div class="row container">
            <div class="col-sm-6">
            <table class="table table-borderless">
            <tr>
                <th scope="row"><?= __('Mã môn học') ?></th>
                <td><?= h($subject->code) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('ID') ?></th>
                <td><?= h($subject->id) ?></td>
            </tr> 
            </table>  
            </div>
            <div class="col-sm-6">
            <table class="table table-borderless">
            <tr>
                <th scope="row"><?= __('Ngày thi') ?></th>
                <td><?= $time = date('d/m/Y',strtotime($subject->test_day)) ?></td>
            </tr>
            </table>  
            </div>
        
        </div>
        <div class="card-header">
            <h4 class="float-left">Danh sách phòng thi</h4>
        </div>
        <div class="card-body">
            <div class="content_table">
                <?php if (!empty($subject->test_rooms)): ?>
                <table class="table table-hover" cellpadding="0" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id','ID') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('name','Phòng') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('total_computer','Tổng số máy tính') ?></th>
                            <th scope="col" class="actions"><?= __('Hành vi') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subject->test_rooms as $testRooms): ?>
                        <tr>
                            <td><?= $this->Number->format($testRooms->id) ?></td>
                            <td><?= h($testRooms->name) ?></td>
                            <td><?= $this->Number->format($testRooms->total_computer) ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['action' => 'edit', $testRooms->id],['class' => 'btn btn-warning', 'escape' => false])?>
                                <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $testRooms->id], ['confirm' => __('Bạn chắc chắn muốn xóa # {0}?', $testRooms->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
        <div class="card-header">
            <h4 class="float-left">Danh sách thí sinh</h4>
        </div>
        <?php if (!empty($subject->users)): ?>
        <div class="card-body">
            <div class="content_table">
                <table class="table table-hover" cellpadding="0" cellspacing="0">
                    <thead class="thead-light"> 
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id','ID') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('username','Mã sinh viên') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('first_ame','Họ và tên đệm') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('last_name','Tên') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('date_birth','Ngày sinh') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('class','Lớp') ?></th>
                            <th scope="col" class="actions"><?= __('Hành vi') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subject->users as $users): ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->username) ?></td>
                            <td><?= h($users->first_name) ?></td>
                            <td><?= h($users->last_name) ?></td>
                            <td><?= h($users->date_birth) ?></td>
                            <td><?= h($users->class) ?></td>
                            <!-- <?php $user_test = $users->id.' '.$test->id;?> -->
                            <td class="actions">
                                <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['controller' => 'Users', 'action' => 'edit', $users->id],['class' => 'btn btn-warning', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['controller' => 'Users', 'action' => 'deleteTest',$user_test], ['confirm' => __('Bạn chắc chắn muốn xóa # {0}?', $users->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>   
            </div>
        </div>
        <?php endif; ?>
</div>
</div>