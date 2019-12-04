<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
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
          <li class="breadcrumb-item"><a href="#">Sinh viên</a></li>
          <li class="breadcrumb-item active">Thêm sinh viên</li>
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
    <?= $this->Form->create($user) ?>
        <fieldset>
        <div class="row">
            <div class="col-md-8 col-lg-8">
                <div class="users form large-9 medium-8 columns content card container">
                    <div class="card-header"><h3>Thêm sinh viên</h3></div>
                    <div class="card-body">
                        <?php
                            // echo $this->Form->control('role');
                            // echo $this->Form->control('first_name');
                            // echo $this->Form->control('last_name');
                            // echo $this->Form->control('date_birth',['type'=> 'text','id'=>'datepicker']);
                            // echo $this->Form->control('class');
                            // echo $this->Form->control('subjects._ids', ['options' => $subjects]);
                            echo $this->Form->controls(
                                ['username' => ['class' => 'form-control is-invalid','required' => false,'id' => 'username','label' => ['text'=>'Username']],
                                                    
                                 'password' => ['class' => 'form-control is-invalid','required' => false,'id' => 'password','label' => ['text'=>'Password']],
                                 'first_name' => ['class' => 'form-control is-invalid','required' => false,'id' => 'first_name','label' => ['text'=>'First name']],
                                 'last_name' => ['class' => 'form-control is-invalid','required' => false,'id' => 'last_name','label' => ['text'=>'Last name']],
                                 'date_birth' => ['class' => 'form-control is-invalid','required' => false,'type'=> 'text','id'=>'datepicker','label' => ['text'=>'date_birth']],
                                 'class' => ['class' => 'form-control is-invalid','required' => false,'id' => 'class','label' => ['text'=>'Class']],
                                ],['legend' => '']
                            );
                            $i = 0;
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Thêm môn thi</h3>
                        <?= $this->Form->button('<i class="fas fa-plus-square"></i>',['class' => "btn btn-primary float-right",'type'=>'button','onclick'=>'addSubjects()','escape' => false]) ?>
                    </div>
                    <div class="card-body">
                        <div class="add_content mt-3">
                            <div class="row subject_content<?=$i?> mb-3">
                                <div class="col-lg-10">
                                    <!-- <?= $this->Form->control('subjects'.$i, ['type'=>'text','class'=>"subject_value form-control",'label'=>false,'onclick'=>'autoclick('.$i.')','onkeyup'=>'autoComplete('.$i.',this.value,"admin/users/autoComplete")','name'=>'subjects[0]']) ?> -->
                                    <input type="text" class="auto form-control"  onclick="autoclick(<?=$i?>)" onkeyup="autoComplete(<?=$i?>,this.value,'admin/users/autoComplete')"  value="" name='subjects[0]' id='subjects<?=$i?>'>
                                    <div class="autocomplete autocomplete<?=$i?>" >
                                        <ul name='ul' class="autocomplete-list" style="" >
                                          <?php 

                                            foreach ($subjects as $index => $value) 
                                            {
                                                echo '<li  value="'.$index.'" class="list'.$index.'" onclick="list(this,'.$index.','.$i.')">'.$value.'</li>';

                                            }
                                          ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                     <?= $this->Form->button('<i class="fas fa-minus"></i>',['class' => "btn btn-danger float-right",'type'=>'button','onclick'=>'deleteTests('.$i.')','escape' => false]) ?>
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <div class="card-footer">
                    <?= $this->Form->button('Submit',['class'=>'btn btn-primary float-right']) ?>
                    </div>
                </div>
            </div>
        </div>
        </fieldset>
    <?= $this->Form->end() ?>  
</div>
<script type="text/javascript">
    var mouse_is_inside=''; 
    var id = <?php echo json_encode($i)?>;
    $(document).ready(function()
    {
        $('.autocomplete').hover(function(){ 
            mouse_is_inside=true; 
        }, function(){ 
            mouse_is_inside=false; 
        });

        $("body").mouseup(function(){ 
            if(! mouse_is_inside) $('.autocomplete').hide(0);
        });
    });
    $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd'
            });
    function autoclick(i)
    {
      $('.autocomplete'+i).slideDown(0); 
    }
    function list(event,index,id)
    {
        check = false;
        $('#subjects'+id).val('');
        $( ".auto" ).each(function(index,e) {
            if ($(event).text() == $(e).val())
            {
                alert('Môn đăng ký của bạn bị trùng');
                check = true;
            }
        });
        if (!check){
        $('#subjects'+id).attr('name','subjects['+index+']');
        $('#subjects'+id).val($(event).text());
        }
        $('.autocomplete'+id).hide(0);

    }
    function autoComplete(i,name,url)
    {
        $.ajax({
            url: baseUrl + url,
            type: 'post',
            data: {
                name : name,
                id : i
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (res) {
                $('.autocomplete'+i).html(res);
            },
            error: function () {

            }
        })    
    }
    function addSubjects()
    {
        id++;
        $.ajax({
                url: baseUrl + 'admin/users/addSubjects',
                type: 'post',
                data: {
                    id :id,
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
    function deleteTests(id)
    {
        $(".subject_content"+id).remove();
    }
</script>
