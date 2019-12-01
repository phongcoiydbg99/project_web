<?php 
foreach ($subjects as $subject)
{
    foreach ($subject->test_rooms as $test_rooms)
    {
        if ($test_rooms->name == $check_name)
        {
            if ($check_id == $test_rooms->_joinData->id) {
                echo '<option value='.$test_rooms->_joinData->id.'selected>'.date('H:i',strtotime($test_rooms->_joinData->start_time)).' - '.date('H:i',strtotime($test_rooms->_joinData->last_time)).'</option>';
            }
            else
            echo '<option value='.$test_rooms->_joinData->id.'>'.date('H:i',strtotime($test_rooms->_joinData->start_time)).' - '.date('H:i',strtotime($test_rooms->_joinData->last_time)).'</option>';
        }
    }
}
?>