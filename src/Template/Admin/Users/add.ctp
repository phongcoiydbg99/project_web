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
            <li class="breadcrumb-item"><?= $this->Html->link(
                ' Sinh viên ',
                '/admin/users',
                ['escape' => false]
            ) ?></li>
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
            'inputContainerError' => '<div class="form-group is-invalid {{type}}{{required}}">{{content}}{{error}}</div>',
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
                            // echo $this->Form->control('username', ['class' => 'form-control']);
                            // echo $this->Form->control('password', ['class' => 'form-control']);
                            // echo $this->Form->control('first_name', ['class' => 'form-control']);
                            // echo $this->Form->control('last_name', ['class' => 'form-control']);
                            // echo $this->Form->control('date_birth',['type'=> 'text','class'=> ['datepicker', 'form-control']]);
                            // echo $this->Form->control('class' , ['class' => 'form-control']);
                            // echo $this->Form->control('subjects._ids', ['options' => $subjects]);
                            echo $this->Form->controls(
                                ['username' => ['class' => 'form-control ','required' => false,'id' => 'username','label' => ['text'=>'Mã sinh viên']],
                                                    
                                 'password' => ['class' => 'form-control ','required' => false,'id' => 'password','label' => ['text'=>'Mật khẩu']],
                                 'first_name' => ['class' => 'form-control','required' => false,'id' => 'first_name','label' => ['text'=>'Họ và tên đệm']],
                                 'last_name' => ['class' => 'form-control','required' => false,'id' => 'last_name','label' => ['text'=>'Tên']],
                                 'date_birth' => ['class' => 'form-control datepicker','required' => false,'type'=> 'text','id'=>'','label' => ['text'=>'Ngày sinh']],
                                 'class' => ['class' => 'form-control','required' => false,'id' => 'class','label' => ['text'=>'Lớp']],
                                ],['legend' => '']
                            );
                            $i = 0;
                            $id = 0;
                            $id ++;
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
                                     <?= $this->Form->button('<i class="fas fa-minus"></i>',['class' => "btn btn-danger float-right",'type'=>'button','onclick'=>'deleteTest('.$i.')','escape' => false]) ?>
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
<script>
    var id = <?php echo json_encode($i)?>;
</script>
