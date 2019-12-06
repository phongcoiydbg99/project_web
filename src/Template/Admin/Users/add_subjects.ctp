<div class="row subject_content<?=$i?> mb-3">
    <div class="col-lg-10">
        <!-- <?= $this->Form->control('subjects'.$i, ['type'=>'text','class'=>"form-control",'label'=>false,'onclick'=>'autoclick('.$i.')','onkeyup'=>'autoComplete('.$i.',this.value,"admin/users/autoComplete")','name'=>'subjects[0]']) ?> -->
        
        <input type="text" class="auto form-control"  onclick="autoclick(<?=$i?>)" onkeyup="autoComplete(<?=$i?>,this.value,'admin/users/autoComplete')" value="" name='subjects[0]' id='subjects<?=$i?>'>
        <div class="autocomplete autocomplete<?=$i?>">
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
