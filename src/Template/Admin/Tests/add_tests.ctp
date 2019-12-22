<?php 
    $i = $id*2;
?>
<tr class="test_content<?=$id?>">
    <td colspan="" rowspan="" headers="">
        <input type="text" class="auto form-control"  onclick="autoclick(<?=$i?>)" onkeyup="autoComplete(<?=$i?>,this.value,'admin/tests/autoCompleteRoom')"  value="" name='tests[<?=$id?>][0]' id='tests<?=$i?>'>
        <div class="autocomplete autocomplete<?=$i?>" >
            <ul name='ul' class="autocomplete-list" style="" >
              <?php 

                foreach ($testRooms as $index => $value) 
                {
                    echo '<li  value="'.$index.'"  onclick="listTest(this,'.$index.','.$i.')">'.$value.'</li>';

                }
              ?>
            </ul>
        </div>
    </td>
    <?php 
    $i++;
    ?>
    <td colspan="" rowspan="" headers="">
        <input type="text" class="auto form-control"  onclick="autoclick(<?=$i?>)" onkeyup="autoComplete(<?=$i?>,this.value,'admin/tests/autoCompleteSubject')"  value="" name='tests[<?=$id?>][1]' id='tests<?=$i?>'>
        <div class="autocomplete autocomplete<?=$i?>" >
            <ul name='ul' class="autocomplete-list" style="" >
              <?php 

                foreach ($subjects as $index => $value) 
                {
                    echo '<li  value="'.$index.'" onclick="listTest(this,'.$index.','.$i.')">'.$value.'</li>';

                }
              ?>
            </ul>
        </div>
    </td>
    <td class="actions">
        <button type="button" class="ml-2 btn btn-danger" onclick="deleteTestByTime(<?=$id?>)"><i class="far fa-trash-alt"></i></button>
     </td>
</tr>