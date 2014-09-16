jQuery(document).ajaxSuccess(function(e, xhr, settings) {
  
  	init();
  
});

jQuery(document).ready(function() {
	init();
});
 
 
function init (){
	
	jQuery('.sfmsb-color-picker').wpColorPicker();
		                
	//** Icon events
	jQuery('.sfmsb-icons-container a').on('click', function(event, ui){
		
		var tmp = jQuery(this).find('span').attr('class').split(' ');
		tmp = tmp[0].split('-');
								
		var icon_name = tmp[2];
		var widget = '#' + jQuery(this).closest('.widget').attr('id');
								
		jQuery(widget + ' .sfmsb-initial-message').css('display', 'none');
		jQuery(widget + ' .sfmsb-input-block').css('display', 'none');
		jQuery(widget + ' .sfmsb-input-block.sfmsb-' + icon_name).css('display', 'block');
							
	});
	
	//** Input events
	jQuery('.sfmsb-icons-container input[type=text]').keyup(function() {
			
			var tmp = jQuery(this).attr('id').split('-');
			tmp = tmp[3].split('_');
			
			var icon_name = tmp[1];
			
			var widget = '#' + jQuery(this).closest('.widget').attr('id');
			
			var aTag	  = jQuery(widget + ' .sfmsb-icon-' + icon_name).closest('a');
			 
			if(jQuery(this).val() == ''){
				aTag.attr('class', 'sfmsb-disable');
			}else{
				aTag.attr('class', 'sfmsb-pending');
			}
	});
	
}