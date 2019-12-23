<?php foreach ($subjects as $subject): ?>
    <td class='subject_code'><?= $subject->code?></td>
    <td><?= $subject->name?></td>
    <td class='test_day'>
        <select class="form-control" id="test_day<?= $subject->id?>" onchange="selectTestday(this,<?= $subject->id?>)" >
        <?php 
            $check_time_id = '';
            $names = Array();
            foreach ($subject->tests as $tests)
            {
                array_push($names, date('d/m/Y',strtotime($tests->time->test_day)));
            }
            $names = array_count_values($names);
            foreach ($names as $index => $value)
            {
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
                    if ($tests->test_room->name == $check_name && $test_day == $check_day)
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
<?php endforeach; ?>