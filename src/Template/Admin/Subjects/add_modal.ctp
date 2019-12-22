<?= $this->Form->create($subject,['id'=>'form'.$subject->id]) ?>
<?php
     echo $this->Form->controls(
        ['code' => ['class' => 'form-control','required' => false,'id' => 'code','label' => ['text'=>'Mã môn học:']],
                            
         'name' => ['class' => 'form-control','required' => false,'id' => 'name','label' => ['text'=>'Tên môn học']],
        ],['legend' => '']
    );
?>
<hr >
<?= $this->Form->button('Submit',['class'=>'btn btn-primary float-right','id'=>'btn'.$subject->id]) ?>

<?= $this->Form->end() ?>