<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject[]|\Cake\Collection\CollectionInterface $subjects
 */
?>
<nav class="large-3 medium-4 columns mt-5" id="actions-sidebar">
    <ul class="side-nav h4">
        <li class="heading"><?= $this->getRequest()->getSession()->read('Auth.User.first_name') . ' ' . $this->getRequest()->getSession()->read('Auth.User.last_name') ?></li>
        <li><?= $this->Html->link(__('New Subject'), ['action' => 'add']) ?></li>

    </ul>
</nav>

<div class="subjects index large-9 medium-8 columns content">
    <div class="card">
        <div class="card-header"><h3><?= __('Subjects') ?></h3></div>
        <div class="card-body table-responsive p-0" style="height:250px">
            <table class="table table-head-fixed" cellpadding="0" cellspacing="0">
                <thead class="thead-light">
                <tr>
                    <th scope="col" colspan=></th>
                    <th scope="col" colspan=><?= $this->Paginator->sort('code') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('test_day') ?></th>
                    <th scope="col" class="text-primary">Phòng thi</th>
                    <th scope="col" class="text-primary">Thời gian thi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($subjects as $subject): ?>
                    <?php $i = 0; ?>
                    <?php foreach ($subject->test_rooms as $test_rooms): ?>
                        <tr>
                            <?php 
                            $disabled = ''; $checked = '';
                            if (!empty($subject->tests[$i]['users']))
                                {
                                    foreach ($subject->tests[$i]['users'] as $users)
                                    {
                                        if($users['id'] == $id){
                                            $disabled = 'disabled';
                                            $checked = 'checked';
                                        }
                                    }
                                } 
                            else{
                                    $disabled = '';
                                    $checked = '';
                                } 
                            ?>
                                <td><input type="checkbox" class="checkBox" onclick="testCheckBox(this,<?=$subject->id?>,<?= $test_rooms->_joinData->test_room_id ?>,<?= $test_rooms->_joinData->id ?>) " <?= $disabled .' '. $checked?>></td>
                                <td class='subject_code'><?= $subject->code?></td>
                                <td><?= $subject->name?></td>
                                <td class='test_day'><?= $subject->test_day?></td>
                                <td><?= $test_rooms->name?></td>
                                <td class="test_time"><?= date('H:i',strtotime($test_rooms->_joinData->start_time)).' - '.date('H:i',strtotime($test_rooms->_joinData->last_time)) ?></td>
                        </tr>
                    <?php $i ++; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="subjects index large-9 medium-8 columns content">
    <div class="card">
        <?=$this->Form->create()?>
        <div class="card-body table-responsive p-0" style="height:300px">
            <table class="table table-head-fixed" cellpadding="0" cellspacing="0">
                <thead class="thead-light">
                <tr>
                    <th scope="col" colspan=></th>
                    <th scope="col" class="text-primary">Code</th>
                    <th scope="col" class="text-primary">Name</th>
                    <th scope="col" class="text-primary">Test day</th>
                    <th scope="col" class="text-primary">Phòng thi</th>
                    <th scope="col" class="text-primary">Thời gian thi</th>
                    <th scope="col" class="actions text-primary"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody class="check_content">
                    <?php foreach ($subjects as $subject): ?>
                    <?php $i = 0; ?>
                    <?php foreach ($subject->test_rooms as $test_rooms): ?>
                        <tr>
                            <?php 
                             if (!empty($subject->tests[$i]['users']))
                                {
                                    foreach ($subject->tests[$i]['users'] as $users)
                                    {
                                        if($users['id'] == $id){?>
                                            <td style="width: 44px"></td>
                                            <td><input type="text" class="border-0" name="subject[<?= $subject['tests'][$i]['id']?>][code]" value="<?= $subject->code?>" style="width:50px" readonly></td>
                                            <td><input type="text" class="border-0" name="subject[<?= $subject['tests'][$i]['id']?>][name]" value="<?= $subject->name?>" style="width:50px"readonly></td>
                                            <td><input type="text" class="border-0" name="subject[<?= $subject['tests'][$i]['id']?>][test_day]" value="<?= $subject->test_day?>" style="width:80px"readonly></td>
                                            <td><input type="text" class="border-0" name="subject[<?= $subject['tests'][$i]['id']?>][room]" value="<?= $test_rooms->name?>" style="width:50px"readonly></td>
                                            <td><input type="text" class="border-0" name="subject[<?= $subject['tests'][$i]['id']?>][time]" value="<?= date('H:i',strtotime($test_rooms->_joinData->start_time)).' - '.date('H:i',strtotime($test_rooms->_joinData->last_time))?>" style="width:100px"readonly></td>
                                            
                                            <td class="actions">
                                            <?= $this->Form->postLink('Delete', ['action' => 'delete_test', $users['_joinData']['id']], ['block' => true,'confirm' => __('Are you sure you want to delete # {0}?', $users['_joinData']['id'])]) ?>
                                            </td>
                             <?php       }
                                    }
                                }
                            ?>
                               
                        </tr>
                    <?php $i ++; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?= $this->Form->button('Submit',['class'=>'btn btn-primary float-right']) ?>
        </div>
        <?= $this->Form->end()?>
        <?= $this->fetch('postLink')?>
    </div>
</div>
<script>
    var arrCheck = new Array();
    $( document ).ready(function() {
        $( ".checkBox" ).each(function(index,check) {
            if ($(check).is(':checked')){
            var subject_code = $(check).parent().parent().find('.subject_code').text();
            var test_day = $(check).parent().parent().find('.test_day').text();
            var test_time = $(check).parent().parent().find('.test_time').text();
            arrCheck.push([subject_code,test_day,test_time.slice(0,5),test_time.slice(-5)]);
            console.log(arrCheck);
                $( ".checkBox" ).each(function(index) {
                    var check_code = $(this).parent().parent().find('.subject_code').text();
                    var check_day = $(this).parent().parent().find('.test_day').text();
                    var check_time = $(this).parent().parent().find('.test_time').text();
                    var start_time = check_time.slice(0,5);
                    var last_time = check_time.slice(-5);
                    if ( subject_code == check_code)
                    {
                        $(this).prop('disabled',true);
                    }
                    else {
                        for (var i =0 ; i < arrCheck.length;i++)
                        {
                            if (check_day == arrCheck[i][1])
                            {
                                if ((start_time >= arrCheck[i][2]&& start_time <= arrCheck[i][3])||(last_time >= arrCheck[i][2]&& last_time <= arrCheck[i][3]))
                                    $(this).prop('disabled',true);
                            }
                        }
                    }
                    // $(check).prop('disabled',false);
                });
            }
        })
    });
    function testCheckBox(check,subject_id,test_room_id,id) {
        if ($(check).is(':checked'))
        {
            var subject_code = $(check).parent().parent().find('.subject_code').text();
            var test_day = $(check).parent().parent().find('.test_day').text();
            var test_time = $(check).parent().parent().find('.test_time').text();
            arrCheck.push([subject_code,test_day,test_time.slice(0,5),test_time.slice(-5)]);
            console.log(arrCheck);
                $( ".checkBox" ).each(function(index) {
                    var check_code = $(this).parent().parent().find('.subject_code').text();
                    var check_day = $(this).parent().parent().find('.test_day').text();
                    var check_time = $(this).parent().parent().find('.test_time').text();
                    var start_time = check_time.slice(0,5);
                    var last_time = check_time.slice(-5);
                    if ( subject_code == check_code)
                    {
                        $(this).prop('disabled',true);
                    }
                    else {
                        for (var i =0 ; i < arrCheck.length;i++)
                        {
                            if (check_day == arrCheck[i][1])
                            {
                                if ((start_time >= arrCheck[i][2]&& start_time <= arrCheck[i][3])||(last_time >= arrCheck[i][2]&& last_time <= arrCheck[i][3]))
                                    $(this).prop('disabled',true);
                            }
                        }
                    }
                    // $(check).prop('disabled',false);
                });
            $.ajax({
                url: baseUrl + '/subjects/checkBox',
                type: 'post',
                data: {
                    subject_id: subject_id,
                    test_room_id: test_room_id,
                    id : id
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: 'html',
                success: function (res) {
                    $('.check_content').append(res);
                },
                error: function () {

                }
            })
        }
        
    }

</script>