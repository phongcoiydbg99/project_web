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
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Môn thi</a></li>
          <li class="breadcrumb-item active">Sửa môn thi</li>
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
            'input' => '<input type="{{type}}" name="{{name}}" class="form-control " {{attrs}}/>',
            'inputContainerError' => '<div class="form-group {{type}}{{required}}">{{content}}{{error}}</div>',
        ];
    $this->Form->setTemplates($myTemplates);
?>
<div class="content">
<?= $this->Form->create($subject) ?>
<fieldset>
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="subjects form large-9 medium-8 columns content card">
                <div class="card-header "><h3>Thêm môn thi</h3></div>
                <div class="card-body">
                    <?php

                        echo $this->Form->control('code');
                        echo $this->Form->control('name');
                        echo $this->Form->control('test_day',['type'=> 'text','id'=>'datepicker','value'=>date("Y-m-d", strtotime($subject->test_day))]);
                        // echo $this->Form->control('users._ids', ['options' => $users,'class'=>"form-control"]);
                    ?>
                </div>
            </div> 
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header ">
                    <h3 class="float-left">Thêm phòng thi và lịch thi</h3>
                    <?= $this->Form->button('<i class="fas fa-plus-square"></i>',['class' => "btn btn-danger float-right",'type'=>'button','onclick'=>'addTests()','escape' => false]) ?>
                </div>
                <div class="card-body">
                    <div class="row add_content">
                        <?php 
                        $i =0;
                        foreach ($subject->tests as $test) { ?>
                            <div class=" row subject_content<?=$i?>">
                                <div class="col-lg-3"><?= $this->Form->control('tests.'.$i.'.test_room_id', ['options' => $testRooms,'class'=>"form-control",'label'=>false]) ?></div>
                                <div class="col-lg-4"><?= $this->Form->control('tests.'.$i.'.start_time',['type'=> 'text','id'=>'start_time'.$i,'label'=>false]) ?></div>
                                <div class="col-lg-4"><?= $this->Form->control('tests.'.$i.'.last_time',['type'=> 'text','id'=>'last_time'.$i,'label'=>false]) ?></div>
                                <div class="col-lg-1">
                                    <?= $this->Form->button('<i class="fas fa-minus"></i>',['class' => "btn btn-light float-right",'type'=>'button','onclick'=>'deleteTests('.$i.','.$test->id.')','escape' => false]) ?>
                                </div>
                            </div>
                            <?php
                            $start_time = date('H:i',strtotime($test->start_time));
                            $last_time = date('H:i',strtotime($test->last_time));
                            ?>
                            <script type="text/javascript">
                                var i = <?php echo json_encode($i) ?>;
                                var start_time = <?php echo json_encode($start_time) ?>;
                                var last_time = <?php echo json_encode($last_time) ?>;
                                console.log(i);
                                 $('#start_time'+i).timepicker({
                                            uiLibrary: 'bootstrap4',
                                            value: start_time
                                        }); 
                                 $('#last_time'+i).timepicker({
                                            uiLibrary: 'bootstrap4',
                                            value: last_time
                                        });
                            </script>
                        <?php 
                        $i++;
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<?= $this->Form->button('Submit',['class'=>'btn btn-primary']) ?>
<?= $this->Form->end() ?>
</div>
<script type="text/javascript">
    var id = <?php echo json_encode($i) ?>;
    $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd'
            });
    
    function addTests()
    {
    id++;
    $.ajax({
            url: baseUrl + 'admin/subjects/addTests',
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
    function deleteTests(id,test_id)
    {
        $(".subject_content"+id).remove();
        if(typeof test_id !== 'undefined')
        {
            $.ajax({
            url: baseUrl + 'admin/subjects/deleteTests',
            type: 'post',
            data: {
                id : test_id
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
        
    }
</script>