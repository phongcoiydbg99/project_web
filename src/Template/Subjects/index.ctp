<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject[]|\Cake\Collection\CollectionInterface $subjects
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="text-danger">Thời gian đăng kí:</h4>
        <h4><?= $session['start_time'] ?> - <?= $session['last_time'] ?></h4>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><?= $this->Html->link(
                    ' Home ',
                    '/',
                    ['escape' => false]
                ) ?></li>
          <li class="breadcrumb-item active">Đăng kí thi</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="card">
        <div class="card-header"><h3>Đăng kí thi</h3></div>
        <?= $this->Form->create() ?>
        <div class="card-body table-responsive p-0" style="height:250px">
            <table class="table table-head-fixed" cellpadding="0" cellspacing="0">
                <thead class="thead-light">
                <tr>
                    <th scope="col" colspan=><?= $this->Paginator->sort('code') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('test_day') ?></th>
                    <th scope="col" class="text-primary">Phòng thi</th>
                    <th scope="col" class="text-primary">Thời gian thi</th>
                    <th scope="col" class="text-primary">Số lượng</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($subjects as $subject): ?>
                    <tr>
                            <td class='subject_code'><?= $subject->code?></td>
                            <td><?= $subject->name?></td>
                            <td class='test_day'><?= $subject->test_day->i18nFormat('dd/MM/yyyy')?></td>
                            <td>
                                <select class="form-control" id="test_room" onchange="selectTesttime(this,<?= $subject->id?>)" >
                                <?php 
                                    $i = 0;
                                    $check_name = '';
                                    $check_id = '';
                                    foreach ($subject->tests as $tests)
                                    {
                                        if(!empty($tests->users) && $tests->users[0]['id'] === $id)
                                        {
                                            $check_name = $tests->test_room->name;
                                            $check_id = $tests->id;
                                        }
                                    }
                                    $names = Array();
                                    foreach ($subject->test_rooms as $test_rooms)
                                    {
                                        array_push($names,$test_rooms->name);
                                    }
                                    $names = array_count_values($names);
                                    foreach ($names as $index => $value)
                                    {
                                        if ($check_name == '') {$check_name = $index;}
                                        if ($index == $check_name)
                                            {echo '<option selected>'.$index.'</option>'; }
                                        else echo '<option>'.$index.'</option>'; 
                                    }
                                ?>
                                </select>
                            </td>
                            <td >
                                <select class="form-control test" id="test_time_<?= $subject->id?>" name = 'subject[<?= $subject->id?>]' onclick="selectTest(this,<?= $subject->id?>)">
                                    <?php 
                                        $data = Array();
                                        foreach ($subject->test_rooms as $test_rooms)
                                        {
                                            if ($test_rooms->name == $check_name)
                                            {
                                                $test_time = date('H:i',strtotime($test_rooms->_joinData->start_time)).' - '.date('H:i',strtotime($test_rooms->_joinData->last_time));
                                                // $data = array_merge($data,[$test_time=>$test_rooms->_joinData->id]);
                                                if($check_id == '') $check_id = $test_rooms->_joinData->id;
                                                if ($check_id == $test_rooms->_joinData->id) {
                                                    echo '<option value='.$test_rooms->_joinData->id.'  selected>'.$test_time.'</option>';
                                                }
                                                else
                                                echo '<option value='.$test_rooms->_joinData->id.'>'.$test_time.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td colspan="" rowspan="" headers="" class="test<?= $subject->id?>">
                            <?php 
                                foreach ($subject->tests as $tests)
                                    {
                                        if($tests->id == $check_id)
                                        {
                                            echo $tests->computer_registered.'/'.$tests->test_room->total_computer;
                                        }
                                    }
                            ?>
                            </td>
                   </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?= $this->Form->button('Submit',['class'=>'btn btn-primary float-right']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>
    function createArr(name)
    {
        var arr = [];
        $('.'+name).each(function(index) {
             arr.push($(this).val());
        })

        return arr;
    }
    $(document).ready(function()
    {
        var arr = createArr('test');
        console.log(arr);
        // $.ajax({
        //         url: baseUrl + '/subjects/checkTest',
        //         type: 'post',
        //         data: {
        //             arr: arr
        //         },
        //         headers: {
        //             'X-CSRF-TOKEN': csrfToken
        //         },
        //         dataType: 'json',
        //         success: function (res) {
        //               alert(data);
        //         },
        //         error: function () {

        //         }
        //     })
    });
    function selectTesttime(check_name,subject_id){
    $.ajax({
                url: baseUrl + '/subjects/checkTesttime',
                type: 'post',
                data: {
                    check_name: check_name.value,
                    subject_id: subject_id
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: 'html',
                success: function (res) {
                    $('#test_time_'+subject_id).html(res);
                    console.log($('#test_time_'+subject_id).val());
                    var id = $('#test_time_'+subject_id).val();
                    $.ajax({
                        url: baseUrl + '/subjects/checkTest',
                        type: 'post',
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        dataType: 'html',
                        success: function (ress) {
                            $('.test'+subject_id).html(ress);
                        },
                        error: function () {

                        }
                    })    
                },
                error: function () {

                }
            })    
    }
        
    function selectTest(check_test,subject_id)
    {
        var id = $(check_test).val();
        $.ajax({
            url: baseUrl + '/subjects/checkTest',
            type: 'post',
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (ress) {
                $('.test'+subject_id).html(ress);
            },
            error: function () {

            }
        })    
    }


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