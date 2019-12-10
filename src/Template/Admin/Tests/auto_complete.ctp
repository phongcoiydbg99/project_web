<ul name='ul' class="autocomplete-list" style="" >
	<?php 

	foreach ($users as $index => $value) 
	{
	    echo '<li  value="'.$index.'" class="list'.$index.'" onclick="list(this,'.$index.')">'.$value.'</li>';

	}
	?>
</ul>