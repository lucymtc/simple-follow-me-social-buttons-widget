jQuery(document).ajaxSuccess(function(e, xhr, settings) {
  
  	init();
  
});

jQuery(document).ready(function($) {

	init();
	init_specificfeeds_notice();

	function init_specificfeeds_notice(){

		$( 'a#sfmsb-specificfeeds-close' ).on( 'click', function( e ){
			
			e.preventDefault();

		
   			var data = {
			action    					: 'sfmsb_notice_viewed',
			specificfeeds_viewed_notice : 1,
			nonce	  					: sfmsb_vars.nonce
		};
   		
	   		$.post(sfmsb_vars.ajaxurl, data, function(response){
	   			
	   			if( response == 'success') {
	   				$('.sfmsb-specificfeeds-notice').remove();
	   			}
	   			
	   		});

		});
	}
	
});


 
 
function init (){
	
	jQuery( '.sfmsb-color-picker' ).wpColorPicker();
		                
	//** Icon events
	jQuery( '.sfmsb-icons-container a.sfmsb-disable, .sfmsb-icons-container a.sfmsb-enable' ).on( 'click', function( event, ui ){
		
		jQuery('.sfmsb-icons-container').removeClass('extra-message');
		jQuery('p#sfmsb-specififeeds-message').css('display', 'none');

		var tmp = jQuery( this ).find( 'span' ).attr( 'class' ).split( ' ' );
		tmp 	= tmp[0].split( '-' );
								
		var icon_name = tmp[2];
		var widget 	  = '#' + jQuery( this ).closest( '.widget' ).attr( 'id' );
								
		jQuery( widget + ' .sfmsb-initial-message' ).css( 'display', 'none' );
		jQuery( widget + ' .sfmsb-input-block' ).css( 'display', 'none' );
		jQuery( widget + ' .sfmsb-input-block.sfmsb-' + icon_name ).css( 'display', 'block' );

		if( icon_name == 'specificfeeds' ) {

			jQuery( widget + ' .sfmsb-icons-container').addClass('extra-message');
			jQuery( widget + ' p#sfmsb-specififeeds-message').css('display', 'inline');
	
		}
							
	});
	
	//** Input events
	jQuery( '.sfmsb-icons-container input[type=text]' ).keyup( function() {
			
			var tmp = jQuery( this ).attr( 'id' ).split( '-' );
			tmp 	= tmp[3].split( '_' );
			
			var icon_name = tmp[1];
			var widget 	  = '#' + jQuery( this ).closest( '.widget' ).attr( 'id' );
			var aTag      = jQuery( widget + ' .sfmsb-icon-' + icon_name ).closest( 'a' );
			 
			if( jQuery(this).val() == '' ){

				aTag.attr( 'class', 'sfmsb-disable' );

			}else{

				aTag.attr( 'class', 'sfmsb-pending' );
			}
	});
	
}