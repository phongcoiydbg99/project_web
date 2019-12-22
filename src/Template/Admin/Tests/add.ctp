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
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><?= $this->Html->link(
                ' Ca thi ',
                '/admin/tests',
                ['escape' => false]
            ) ?></li>
          <li class="breadcrumb-item active">Thêm ca thi</li>
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
    <?= $this->Form->create($test,['id'=>'form1']) ?>
    <fieldset>
        <div class="row">
            <div class="col-md-8 col-lg-8" >
                <div class="card" style="height: 500px">
                    <div class="card-header">
                        <h3 class="float-left">Thêm môn thi và phòng thi</h3>
                        <button type="button" class="btn btn-primary float-right" onclick="addTest()"><i class="fas fa-plus-square" ></i></button>
                    </div>
                    
                        <table class="table border border-bottom-0"cellpadding="0" cellspacing="0">
                            <thead class="">
                                <tr>
                                <th scope="col">Phòng thi</th>
                                <th scope="col">Môn thi</th>
                                <th scope="col" class="actions"><?= __('Hành vi') ?></th>
                            </tr>
                            </thead>
                            <tbody class="add_content">
                                    <tr class="">
                                        <td colspan="" rowspan="" headers="">
                                            <input type="text" class="auto form-control"  onclick="autoclick(0)" onkeyup="autoComplete(0,this.value,'admin/tests/autoCompleteRoom')"  value="" name='testRoom[0][0]' id='tests0'>
                                            <div class="autocomplete autocomplete0" >
                                                <ul name='ul' class="autocomplete-list" style="" >
                                                  <?php 

                                                    foreach ($testRooms as $index => $value) 
                                                    {
                                                        echo '<li  value="'.$index.'"  onclick="listTest(this,'.$index.',0)">'.$value.'</li>';

                                                    }
                                                  ?>
                                                </ul>
                                            </div>
                                        </td>
                                        <td colspan="" rowspan="" headers="">
                                            <input type="text" class="auto form-control"  onclick="autoclick(1)" onkeyup="autoComplete(1,this.value,'admin/tests/autoCompleteSubject')"  value="" name='subject[0][1]' id='tests1'>
                                            <div class="autocomplete autocomplete1" >
                                                <ul name='ul' class="autocomplete-list" style="" >
                                                  <?php 

                                                    foreach ($subjects as $index => $value) 
                                                    {
                                                        echo '<li  value="'.$index.'" onclick="listTest(this,'.$index.',1)">'.$value.'</li>';

                                                    }
                                                  ?>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="actions">
                                            <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $test->id], ['confirm' => __('Bạn chắc chắn xóa # {0}?', $test->id),'class' => 'ml-2 btn btn-danger', 'escape' => false]) ?>
                                         </td>
                                    </tr>
                            </tbody>
                        </table>                     
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="tests form large-9 medium-8 columns content card">
                    <div class="card-header "><h3>Thêm ca thi</h3></div>
                    <div class="card-body">
                    <?php

                        // echo $this->Form->control('subject_id', ['options' => $subjects]);
                        // echo $this->Form->control('test_room_id', ['options' => $testRooms]);
                        // echo $this->Form->control('test_room_id', ['options' => $testRooms,'class'=>"form-control",'label'=>'Phòng thi']);
                        echo $this->Form->control('start_time',['type'=> 'text','id'=>'start_time','label'=>'Thời gian bắt đầu']);
                        echo $this->Form->control('last_time',['type'=> 'text','id'=>'last_time','label'=>'Thời gian kết thúc']);
                        $i = 0;
                    ?>
                    </div>
                    <div class="card-footer">
                        <?= $this->Form->button('Xác nhận',['class'=>'btn btn-primary float-right']) ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    
    <?= $this->Form->end() ?>   
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
