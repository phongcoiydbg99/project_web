<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $time
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
                '/admin/ca-thi',
                ['escape' => false]
            ) ?></li>
          <li class="breadcrumb-item active">Ca thi</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<?php 
    $myTemplates = [
            // 'formStart' => '<form{{attrs}}>',
            'error' => '<div class="text-danger mt-2">{{content}}</div>',
            'inputContainer' => '<div class="form-group{{required}}">{{content}}<span class="help">{{help}}</span></div>',
            'inputContainerError' => '<div class="form-group {{type}}{{required}}">{{content}}{{error}}</div>',
        ];
    $this->Form->setTemplates($myTemplates);
?>
<div class="content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="tests form large-9 medium-8 columns content card">
                <div class="card-header ">
                    <h3 class="float-left">Danh sách môn thi</h3>
                    <a href="#" class="btn btn-primary float-right ml-1" onclick="upload(this)" data-toggle="modal" data-target="#myModal1"><i class="fas fa-plus-square"></i></a> 
                    <div class="modal fade" id="myModal1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Thêm phòng và môn thi</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <?= $this->Form->create($test,['id'=>'form2','action'=>'addTest']) ?>
                                    <div class="form-group">
                                        <label for="pwd">Phòng thi: </label>
                                        <input type="text" class="auto form-control"  onclick="autoclick(0)" onkeyup="autoComplete(0,this.value,'admin/tests/autoCompleteRoom')"  value="" name='testRoom[<?=$time->id?>][0]' id='tests0'>
                                        <div class="autocomplete autocomplete0" >
                                            <ul name='ul' class="autocomplete-list" style="" >
                                              <?php 

                                                foreach ($testRooms as $index => $value) 
                                                {
                                                    echo '<li  value="'.$index.'"  onclick="listTestByTime(this,'.$index.',0,'.$time->id.')">'.$value.'</li>';

                                                }
                                              ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Môn thi:</label>
                                        <input type="text" class="auto form-control"  onclick="autoclick(1)" onkeyup="autoComplete(1,this.value,'admin/tests/autoCompleteSubject')"  value="" name='subject[<?=$time->id?>][1]' id='tests1'>
                                        <div class="autocomplete autocomplete1" >
                                            <ul name='ul' class="autocomplete-list" style="" >
                                              <?php 

                                                foreach ($subjects as $index => $value) 
                                                {
                                                    echo '<li  value="'.$index.'" onclick="listTestByTime(this,'.$index.',1,'.$time->id.')">'.$value.'</li>';

                                                }
                                              ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr >
                                    <?= $this->Form->button('Submit',['class'=>'btn btn-primary float-right']) ?>
                                    <?= $this->Form->end() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-warning float-right ml-1" onclick="upload(this)" data-toggle="modal" data-target="#myModal"><i class="fas fa-pencil-alt"></i></a> 
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Sửa ca thi</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <?= $this->Form->create($time,['id'=>'form1']) ?>
                                    <?php
                                        echo $this->Form->control('test_day' , ['class' => 'form-control datepicker','required' => false,'type'=> 'text','value'=>date("Y-m-d", strtotime($time->test_day)),'label' => ['text'=>'Ngày thi']]);
                                        echo $this->Form->control('start_time',['type'=> 'text','id'=>'start_time','label'=>'Thời gian bắt đầu','value'=>date('H:i',strtotime($time->start_time)),'class'=>'form-group']);
                                        echo $this->Form->control('last_time',['type'=> 'text','id'=>'last_time','label'=>'Thời gian kết thúc','value'=>date('H:i',strtotime($time->last_time)),'class'=>'form-group']);
                                        $i = 0;
                                    ?>
                                    <hr >
                                    <?= $this->Form->button('Submit',['class'=>'btn btn-primary float-right']) ?>
                                    
                                    <?= $this->Form->end() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row container">
                        <div class="col-sm-6">
                        <table class="table table-borderless">
                        <tr>
                            <th scope="row"><?= __('Ngày thi:') ?></th>
                            <td><?= date("d/m/Y", strtotime($time->test_day)) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Thời gian bắt đầu:') ?></th>
                            <td><?= h(date('H:i',strtotime($time->start_time)))  ?></td>
                        </tr> 
                        </table>  
                        </div>
                        <div class="col-sm-6">
                        <table class="table table-borderless">
                        <tr>
                            <th scope="row"></th>
                            <td><br></td>
                        </tr> 
                        <tr>
                            <th scope="row"><?= __('Thời gian kết thúc:') ?></th>
                            <td><?= h(date('H:i',strtotime($time->last_time)))  ?></td>
                        </tr> 
                        </table>  
                        </div>
                    
                    </div>
                <?php if (!empty($time->tests)): ?>
                    <div class="content_table">
                        <div class=" table-responsive p-0" style="height:400px">
                        <table class="table table-hover border table-head-fixed"cellpadding="0" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                <th scope="col"><?= $this->Paginator->sort('subject_id','Mã môn') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('subject_id','Tên môn') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('test_room_id','Phòng thi') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('computer_registered','Máy đã đăng ký') ?></th> 
                                <th scope="col"><?= $this->Paginator->sort('total','Tổng') ?></th> 
                                <th scope="col" class="actions"><?= __('Hành vi') ?></th>
                            </tr>
                            </thead>
                        <tbody>
                            <?php foreach ($time->tests as $test): ?>
                            <tr>
                                <td><?= $test->has('subject') ? $test->subject->code : '' ?></td>
                                <td><?= $test->has('subject') ? $test->subject->name : '' ?></td>
                                <td><?= $test->has('test_room') ? $test->test_room->name: '' ?></td> 
                                <td><?= $this->Number->format($test->computer_registered) ?></td>
                                <td><?= $test->has('test_room') ? $test->test_room->total_computer: '' ?></td>
                                <td class="actions">
                                    <?php $test_id = $test->id.' '.$time->id?>
                                    <?= $this->Html->link('<i class="fas fa-tasks"></i>', ['controller'=>'tests','action' => 'view',$test->id],['class' => 'btn btn-success', 'escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'deleteTest', $test_id], ['confirm' => __('Bạn chắc chắn xóa # {0}?', $test_id),'class' => 'btn btn-danger', 'escape' => false]) ?>
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
    </div>
</div>
<script>
    var id = 0;
    $('#start_time').timepicker({
                uiLibrary: 'bootstrap4',
                icons: {
                     rightIcon: '<i class="fas fa-clock"></i>'
                 }
            }); 
     $('#last_time').timepicker({
                uiLibrary: 'bootstrap4',
                icons: {
                     rightIcon: '<i class="fas fa-clock"></i>'
                 }
            });
    $('#form1').submit(function(){
        var check = true;
        
        if (check&&$('#start_time').val() >= $('#last_time').val())
        {
            alert('Thời gian bắt đầu lớn hơn thời gian kết thúc'); 
            check = false;
        }
        if(!check) $('.myModal').show();
        return check;
    })
    $('#form2').submit(function(){
        var check = true;
        
        $( ".auto" ).each(function(index,e) {
            if ($(e).val() == '')
            {
                alert('Bạn chưa điền đủ thông tin');
                check = false;
                return false;   
            }
        });
        if (check&&$('#start_time').val() >= $('#last_time').val())
        {
            alert('Thời gian bắt đầu lớn hơn thời gian kết thúc'); 
            check = false;
        }
        if(!check) $('.myModal').show();
        return check;
    })
    function addTest()
    {
        console.log($('#tests'+id).val());
        id ++;
        $.ajax({
            url: baseUrl + 'admin/tests/addTests',
            type: 'post',
            data: {
                id : id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (res) {
                $('.add_content').append(res);
            },
            error: function () {

            }
        })
        
    }
</script>
