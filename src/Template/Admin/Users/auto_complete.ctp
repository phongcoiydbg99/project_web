<ul name='ul' class="autocomplete-list" style="" >
  <?php 

    foreach ($subjects as $index => $value) 
    {
        echo '<li  value="'.$index.'" class="list'.$index.'" onclick="list(this,'.$index.','.$i.')">'.$value.'</li>';
    }
  ?>
</ul>
<script type="text/javascript"></script>