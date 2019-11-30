
<div class=" row subject_content<?=$id?> mb-3">
    <div class="col-lg-3"><?= $this->Form->control('tests.'.$id.'.test_room_id', ['options' => $testRooms,'class'=>"form-control",'label'=>false]) ?></div>
    <div class="col-lg-4"><?= $this->Form->control('tests.'.$id.'.start_time',['type'=> 'text','id'=>'start_time'.$id,'label'=>false]) ?></div>
    <div class="col-lg-4"><?= $this->Form->control('tests.'.$id.'.last_time',['type'=> 'text','id'=>'last_time'.$id,'label'=>false]) ?></div>
    <div class="col-lg-1">
        <?= $this->Form->button('<i class="fas fa-minus"></i>',['class' => "btn btn-light float-right",'type'=>'button','onclick'=>'deleteTests('.$id.')','escape' => false]) ?>
    </div>
</div>
<script type="text/javascript">
	 $('#start_time'+id).timepicker({
                uiLibrary: 'bootstrap4',
            }); 
     $('#last_time'+id).timepicker({
                uiLibrary: 'bootstrap4',
            });
</script>