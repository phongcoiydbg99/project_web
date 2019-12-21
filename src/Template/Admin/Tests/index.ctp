<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Test[]|\Cake\Collection\CollectionInterface $tests
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
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
            <h3 class="float-left"><?= __('Danh sách') ?></h3>
            <?= $this->Form->control('search',['class'=>'form-control float-right w-25 ml-1','type'=> 'text','id'=>'search','label'=>false,'placeholder'=>'Tìm kiếm tên môn học..','onkeyup'=>'searchTable(this.value,"admin/tests/searchTable")']) ?>
        </div>
        <div class="card-body">
            <div class="content_table">
                <table class="table table-hover border"cellpadding="0" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                        <!-- <th scope="col"><?= $this->Paginator->sort('id') ?></th> -->
                        <th scope="col"><?= $this->Paginator->sort('subject_id','Tên môn') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('test_room_id','Phòng thi') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('test_day','Ngày thi') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('start_time','Bắt đầu') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('last_time','Kết thúc') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('computer_registered','Máy đã đăng ký') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('total','Tổng') ?></th>
                        <th scope="col" class="actions"><?= __('Hành vi') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tests as $test): ?>
                        <tr>
                            <!-- <td><?= $this->Number->format($test->id) ?></td> -->
                            <!-- <td><?= $test->has('subject') ? $this->Html->link($test->subject->name, ['controller' => 'Subjects', 'action' => 'view', $test->subject->id]) : '' ?></td>
                            <td><?= $test->has('test_room') ? $this->Html->link($test->test_room->name, ['controller' => 'TestRooms', 'action' => 'view', $test->test_room->id]) : '' ?></td> -->
                            <td><?= $test->has('subject') ? $test->subject->name : '' ?></td>
                            <td><?= $test->has('test_room') ? $test->test_room->name: '' ?></td> 
                            <td><?= $test->has('subject') ? $test->subject->test_day->i18nFormat('dd/MM/yyyy') : '' ?></td>
                            <td><?= h(date('H:i',strtotime($test->start_time))) ?></td>
                            <td><?= h(date('H:i',strtotime($test->last_time))) ?></td>
                            <td><?= $this->Number->format($test->computer_registered) ?></td>
                            <td><?= $test->has('test_room') ? $this->Html->link($test->test_room->total_computer, ['controller' => 'TestRooms', 'action' => 'view', $test->test_room->id]) : '' ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="fas fa-tasks"></i>', ['action' => 'view',$test->id],['class' => 'btn btn-success', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $test->id], ['confirm' => __('Bạn chắc chắn xóa # {0}?', $test->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
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