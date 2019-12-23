<tr class="subject_content<?=$i?>">     
    <td>
        <input type="text" class="auto form-control"  onclick="autoclick(<?=$i?>)" onkeyup="autoComplete(<?=$i?>,this.value,'admin/users/autoComplete')"  value="" name='subjects[0]' id='subjects<?=$i?>'>
        <div class="autocomplete autocomplete<?=$i?>" >
            <ul name='ul' class="autocomplete-list" style="" >
              <?php 

                foreach ($subjects as $index => $value) 
                {
                    echo '<li  value="'.$index.'" class="list'.$index.'" onclick="list(this,'.$index.','.$i.')">'.$value.'</li>';

                }
              ?>
            </ul>
        </div>
    </td>
    <td>
         <button type="button" class="ml-2 btn btn-danger" onclick="deleteTest(<?=$i?>)"><i class="far fa-trash-alt"></i></button>
    </td>
</tr>