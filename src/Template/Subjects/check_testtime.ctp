<?php 
foreach ($subjects as $subject)
{
    foreach ($subject->tests as $tests)
    {
        if ($tests->test_room->name == $check_name)
        {
            if ($check_id == $tests->id) {
                echo '<option value='.$tests->id.'selected>'.date('H:i',strtotime($tests->time->start_time)).' - '.date('H:i',strtotime($tests->time->last_time)).'</option>';
            }
            else
            echo '<option value='.$tests->id.'>'.date('H:i',strtotime($tests->time->start_time)).' - '.date('H:i',strtotime($tests->time->last_time)).'</option>';
        }
    }
}
?>
