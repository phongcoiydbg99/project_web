<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
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
<?= $this->Form->create($user) ?>
    <fieldset>
    <legend><?= __('Add User') ?></legend>
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="users form large-9 medium-8 columns content card container">
                <div class="card-header"><h3>Thêm sinh viên</h3></div>
                <div class="card-body">
                    <?php
                        echo $this->Form->control('username');
                        echo $this->Form->control('password');
                        echo $this->Form->control('role');
                        echo $this->Form->control('first_name');
                        echo $this->Form->control('last_name');
                        echo $this->Form->control('date_birth',['type'=> 'text','id'=>'datepicker']);
                        echo $this->Form->control('class');
                        $i = 0;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-left">Thêm môn thi</h3>
                    <?= $this->Form->button('<i class="fas fa-plus-square"></i>',['class' => "btn btn-danger float-right",'type'=>'button','onclick'=>'addTests()','escape' => false]) ?>
                </div>
                <div class="card-body">
                    <div class="add_content">
                        <div class="row subject_content<?=$i?>">
                            <div class="col-lg-6"><?= $this->Form->control('subjects', ['options' => $subjects,'class'=>"form-control",'label'=>false]) ?>
                            </div>
                            <div class="col-lg-1">
                                 <?= $this->Form->button('<i class="fas fa-minus"></i>',['class' => "btn btn-light float-right",'type'=>'button','onclick'=>'deleteTests('.$i.')','escape' => false]) ?>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>  
<script type="text/javascript">
    $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd'
            });
</script>
