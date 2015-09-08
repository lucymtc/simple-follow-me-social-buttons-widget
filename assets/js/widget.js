/**
 * widget scripts
 * author Lucy Tomás
 * @since 1.0 
 */

jQuery(document).ajaxSuccess(function(e, xhr, settings) {
  	
  	var sfmsb_form = new sfmsb();
  	sfmsb_form.init();
  
});

jQuery(document).ready(function($) {

	var sfmsb_form = new sfmsb();
	sfmsb_form.init();
	
});

// Closure

function sfmsb (){

	function get_random_id(){

		var num = Math.floor((Math.random() * 999) + 1); 
		var id  = 'sfmsb-' + num;

		return id;

	}

	// public methods
	return {

		/**
		 * init_icons
		 * inits hover color effect
		 */

		init : function () {

			jQuery( '.sfmsb-color-picker' ).wpColorPicker();

			//** Icon events
			jQuery( '.sfmsb-icons-container a.sfmsb-disable, .sfmsb-icons-container a.sfmsb-enable' ).on( 'click', function( event, ui ){
				
				jQuery('.sfmsb-icons-container').removeClass('extra-message');
				jQuery('p#sfmsb-specififeeds-message').css('display', 'none');

				var tmp = jQuery( this ).find( 'span' ).attr( 'class' ).split( ' ' );
				tmp 	= tmp[0].split( '-' );

				var icon_name = tmp[2];

				// get the id of the widget on the widgets page
				var widget 	  = '#' + jQuery( this ).closest( '.widget' ).attr( 'id' );

				// if undefined probably not the widgets page, for example could com from a page builder
				// so set id to the icons container to work with that element

				if( widget == '#undefined') {

					widget = '#' + jQuery( this ).closest( '.sfmsb-icons-container ' ).attr( 'id' );	

						if( widget == '#undefined') {
						
							widget = get_random_id();
							jQuery( this ).closest( '.sfmsb-icons-container ' ).attr('id', widget);

							widget = '#' + widget;	
						}

				}

				
				jQuery( widget + ' .sfmsb-initial-message' ).css( 'display', 'none' );
				jQuery( widget + ' .sfmsb-input-block' ).css( 'display', 'none' );
				jQuery( widget + ' .sfmsb-input-block.sfmsb-' + icon_name ).css( 'display', 'block' );

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

	} // 

}
