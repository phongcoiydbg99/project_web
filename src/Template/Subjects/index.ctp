<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject[]|\Cake\Collection\CollectionInterface $subjects
 */
?>

<?php 
$check_test = false;
if (date('d/m/Y, h:i A') > date('d/m/Y, h:i A',strtotime($session['last_time'])))
   {
    echo '<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="text-danger">Thông báo:</h4>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">';
          echo $this->Html->link(
                    ' Trang chủ ',
                    '/',
                    ['escape' => false]
                ) ;
          echo '</li>
          <li class="breadcrumb-item active">Đăng kí thi</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content h-25">
    <div class="bg-danger container rounded p-lg-2">    
    <p><h4>Đang khóa đăng ký học, bạn vui lòng thử lại sau!</h4></p>
</div>
    </div>';
      }
else {?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="text-danger">Thời gian đăng kí:</h4>
        
        <h4><?= date('d/m/Y, h:i A',strtotime($session['start_time'])) ?> - <?= date('d/m/Y, h:i A',strtotime($session['last_time'])) ?></h4> 
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><?= $this->Html->link(
                    ' Trang chủ ',
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
                    <th scope="col" colspan=><?= $this->Paginator->sort('Mã môn học') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Tên môn học') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Ngày thi') ?></th>
                    <th scope="col" class="text-primary">Phòng thi</th>
                    <th scope="col" class="text-primary">Thời gian thi</th>
                    <th scope="col" class="text-primary">Số lượng</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($subjects as $subject): ?>
                    <?php if($subject->_matchingData['UsersSubjects']['status'] == 0){ ?>
                    <tr class="content_subject<?= $subject->id?>">
                            <td class='subject_code'><?= $subject->code?></td>
                            <td><?= $subject->name?></td>
                            <td class='test_day'>
                                <select class="form-control" id="test_day<?= $subject->id?>" onchange="selectTestday(this,<?= $subject->id?>)" >
                                <?php 
                                    $check_day = '';
                                    $check_time_id = '';
                                    foreach ($subject->tests as $tests)
                                    {
                                        if(!empty($tests->users) && $tests->users[0]['id'] === $id)
                                        {
                                            $check_day = date('d/m/Y',strtotime($tests->time->test_day));
                                            $check_time_id = $tests->time->id;
                                        }
                                    }
                                    $names = Array();
                                    foreach ($subject->tests as $tests)
                                    {
                                        array_push($names, date('d/m/Y',strtotime($tests->time->test_day)));
                                    }
                                    $names = array_count_values($names);
                                    foreach ($names as $index => $value)
                                    {
                                        if ($check_day == '') {$check_day = $index;}
                                        if ($index == $check_day)
                                                {echo '<option selected>'.$index.'</option>'; }
                                            else echo '<option>'.$index.'</option>'; 
                                    }
                                 ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" id="test_room<?= $subject->id?>" onchange="selectTesttime(this,<?= $subject->id?>)" >
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
                                    foreach ($subject->tests as $tests)
                                    {
                                        $test_day = date('d/m/Y',strtotime($tests->time->test_day));
                                        if ($test_day == $check_day  )
                                        {
                                        array_push($names,$tests->test_room->name);
                                        }
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
                                        foreach ($subject->tests as $tests)
                                        {
                                            $test_day = date('d/m/Y',strtotime($tests->time->test_day));
                                            if ($tests->test_room->name == $check_name&& $test_day == $check_day)
                                            {
                                                $test_time = date('H:i',strtotime($tests->time->start_time)).' - '.date('H:i',strtotime($tests->time->last_time));
                                                // $data = array_merge($data,[$test_time=>$test_rooms->_joinData->id]);
                                                if($check_id == '') $check_id = $tests->id;
                                                if ($check_id == $tests->id) {
                                                    echo '<option value='.$tests->id.'  selected>'.$test_time.'</option>';
                                                }
                                                else
                                                echo '<option value='.$tests->id.'>'.$test_time.'</option>';
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
                                            echo '<input class="form-control border-0 bg-white" style="width: 80px" value='.$tests->computer_registered.'/'.$tests->test_room->total_computer.' readonly>';
                                        }
                                    }
                            ?>
                            </td>
                        
                   </tr>
                <?php }?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?= $this->Form->button('Xác nhận',['class'=>'btn btn-primary float-right']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<?php } ?>
<script>
    $(document).ready(function()
    {
        var check = <?php echo json_encode($check_test)?>;
        console.log(check);
    });
    function selectTestday(check_name,subject_id){
        var check_day = check_name.value;
        console.log(check_day);
    $.ajax({
        url: baseUrl + '/subjects/checkTestday',
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
            $('.content_subject'+subject_id).html(res); 
        },
        error: function () {

        }
    })    
    }
    function selectTesttime(check_name,subject_id){
        console.log($('#test_day'+subject_id).val());
        var chech_day = $('#test_day'+subject_id).val();
    $.ajax({
        url: baseUrl + '/subjects/checkTesttime',
        type: 'post',
        data: {
            check_day: chech_day,
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