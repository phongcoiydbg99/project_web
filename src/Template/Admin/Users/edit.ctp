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
                '/admin/quan-ly-sinh-vien',
                ['escape' => false]
            ) ?></li>
          <li class="breadcrumb-item active">Sửa sinh viên</li>
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
                            ['username' => ['class' => 'form-control','required' => false,'id' => 'username','label' => ['text'=>'Mã sinh viên']],
                                                
                             'password' => ['class' => 'form-control','required' => false,'id' => 'password','label' => ['text'=>'Mật khẩu'],'value'=> $user->password],
                             'first_name' => ['class' => 'form-control','required' => false,'id' => 'first_name','label' => ['text'=>'Họ và tên đệm']],
                             'last_name' => ['class' => 'form-control','required' => false,'id' => 'last_name','label' => ['text'=>'Tên']],
                             'date_birth' => ['class' => 'form-control datepicker','required' => false,'type'=> 'text','id'=>'datepicker','value'=>date("Y-m-d", strtotime($user->date_birth)),'label' => ['text'=>'Ngày sinh']],
                             'class' => ['class' => 'form-control','required' => false,'id' => 'class','label' => ['text'=>'Lớp']],
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
                <table class="table border border-bottom-0"cellpadding="0" cellspacing="0">
                    <thead class="">
                        <tr>
                        <th scope="col">Môn thi</th>
                        <th scope="col" class="actions"><?= __('Hành vi') ?></th>
                    </tr>
                    </thead>
                    <tbody class="add_content">
                        <?php foreach ($user->subjects as $subject): ?>
                            <?php if($subject->session_id == $session_id) {?>
                            <tr class="subject_content<?=$i?>">     
                                <td>
                                    <input type="text" class="auto form-control"  onclick="autoclick(<?=$i?>)" onkeyup="autoComplete(<?=$i?>,this.value,'admin/users/autoComplete')"  value="<?=$subject->code.'- '.$subject->name?>" name='subjects[<?=$subject->id?>]' id='subjects<?=$i?>'>
                                    
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
                                </td>
                                <td>
                                     <button type="button" class="ml-2 btn btn-danger" onclick="deleteTests(<?=$i?>,<?=$subject['_joinData']['id']?>)"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>    
                        <?php } ?>
                        <?php $i++;?>
                        <?php endforeach ?>
                    </tbody>
                </table>  
            </div>
        </div>
    </div>
</fieldset>
<?= $this->Form->button('Xác nhận',['class'=>'btn btn-primary']) ?>
<?= $this->Form->end() ?>
</div>
<script>
    var id = <?php echo json_encode($i)?>;
</script>