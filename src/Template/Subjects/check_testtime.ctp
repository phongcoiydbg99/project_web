<?php 
    foreach ($subject->test_rooms as $test_rooms)
    {
        if ($test_rooms->name == $check_name)
        {
            if ($check_id == $test_rooms->_joinData->id) {
                echo '<option selected>'.date('H:i',strtotime($test_rooms->_joinData->start_time)).' - '.date('H:i',strtotime($test_rooms->_joinData->last_time)).'</option>';
            }
            else
            echo '<option>'.date('H:i',strtotime($test_rooms->_joinData->start_time)).' - '.date('H:i',strtotime($test_rooms->_joinData->last_time)).'</option>';
        }
    }
?>