<?php 
foreach ($subjects as $subject)
{
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
}

?>
