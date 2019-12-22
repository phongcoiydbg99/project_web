<ul name='ul' class="autocomplete-list" style="" >
  <?php 

    foreach ($testRooms as $index => $value) 
    {
        echo '<li  value="'.$index.'"  onclick="listTest(this,'.$index.','.$i.')">'.$value.'</li>';

    }
  ?>
</ul>