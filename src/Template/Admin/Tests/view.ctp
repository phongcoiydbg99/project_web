<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Test $test
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
        <h3><?= h($test->subject->name) ?></h3>
        </div>
        <div class="row container">
            <div class="col-sm-6">
            <table class="table table-borderless">
            <tr>
                <th scope="row"><?= __('Phòng thi') ?></th>
                <td><?= $test->has('test_room') ? $this->Html->link($test->test_room->name, ['controller' => 'TestRooms', 'action' => 'view', $test->test_room->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Máy đã đăng ký') ?></th>
                <td><?= $this->Number->format($test->computer_registered) ?></td>
            </tr> 
            </table>  
            </div>
            <div class="col-sm-6">
            <table class="table table-borderless">
            <tr>
                <th scope="row"><?= __('Thời gian bắt đầu') ?></th>
                <td><?= h($test->start_time) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Thời gian kết thúc') ?></th>
                <td><?= h($test->last_time) ?></td>
            </tr> 
            </table>  
            </div>
        
        </div>
    <div class="related card container">
        <div class="card-header">
            <h4 class="float-left">Danh sách</h4>
            <a href="#" class="btn btn-primary float-right ml-1" onclick="upload(this)" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus-circle"></i></a> 
            <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Thêm sinh viên</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <?= $this->Form->create($add) ?>
                            <input type="text" class="auto form-control"  value="" onkeyup="autoComplete(this.value)" name='user[0]'>
                            <div class="autocompleteuser" >
                                <ul name='ul' class="autocomplete-list" style="" >
                                  <?php 

                                    foreach ($users as $index => $value) 
                                    {
                                        echo '<li  value="'.$index.'" class="list'.$index.'" onclick="list(this,'.$index.')">'.$value.'</li>';

                                    }
                                  ?>
                                </ul>
                            </div>
                            <hr >
                            <?= $this->Form->button('Submit',['class'=>'btn btn-primary float-right']) ?>
                            
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($test->users)): ?>
        <div class="card-body">
            <div class="content_table">
                <table class="table table-hover border" cellpadding="0" cellspacing="0">
                    <thead class="thead-light"> 
                        <tr>
                            <th scope="col"><?= __('Id') ?></th>
                            <th scope="col"><?= __('Mã sinh viên') ?></th>
                            <th scope="col"><?= __('Họ và tên đệm') ?></th>
                            <th scope="col"><?= __('Tên') ?></th>
                            <th scope="col"><?= __('Ngày sinh') ?></th>
                            <th scope="col"><?= __('Lớp') ?></th>
                            <th scope="col" class="actions"><?= __('Hành vi') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($test->users as $users): ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->username) ?></td>
                            <td><?= h($users->first_name) ?></td>
                            <td><?= h($users->last_name) ?></td>
                            <td><?= h($users->date_birth) ?></td>
                            <td><?= h($users->class) ?></td>
                            <?php $user_test = $users->id.' '.$test->id;?>
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
</div>
<script>
    function autoComplete(name)
    {
        console.log(name);
        $.ajax({
            url: baseUrl + 'admin/tests/autoComplete',
            type: 'post',
            data: {
                name : name,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (res) {
                $('.autocompleteuser').html(res);
            },
            error: function () {

            }
        })    
    }
    function list(event,index)
    {
        $('.auto').val('');
        $('.auto').attr('name','user['+index+']');
        $('.auto').val($(event).text());
    }
</script>
