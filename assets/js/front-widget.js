/**
 * front widget scripts
 * author Lucy Tomás
 * @since 3.1
 */


jQuery(document).ready(function($) {

	hover_effect_init();


	function hover_effect_init (){
		
		$('.sfmsb_widget').each( function(el){
			
			var id_widget = $(this).attr('id');
			var hover_color = $('#' + id_widget + ' .sfmsb-follow-social-buttons').attr('data-hover');
			
			if( hover_color && hover_color != 'undefined'){
				
					$('#' + id_widget + ' a').hover( 
						function(){
							$(this).find('span').css('color', hover_color);
						}, 
						function(){
							$(this).find('span').css('color', $(this).find('span').attr('data-color'));
						} 
					);

			}


		});
		
	}
	
});


 

