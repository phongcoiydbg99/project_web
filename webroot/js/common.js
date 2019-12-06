$(document).ready(function()
    {
	var mouse_is_inside=''; 
        $('.autocomplete').hover(function(){ 
            mouse_is_inside=true; 
        }, function(){ 
            mouse_is_inside=false; 
        });

        $("body").mouseup(function(){ 
            if(! mouse_is_inside) $('.autocomplete').hide(0);
        });
		
		$('.datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd',
                iconsLibrary: 'fontawesome',
            });
        $('.pick_time').timepicker({
                uiLibrary: 'bootstrap4',
                icons: {
                     rightIcon: '<i class="fas fa-clock"></i>'
                 }
            }); 
    });