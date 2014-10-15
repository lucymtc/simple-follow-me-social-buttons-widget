/**
 * admin scripts
 * author Lucy Tomás
 * @since 2.4
 */

jQuery(document).ready(function($) {

	if ( $(".sfmsb-specificfeeds-notice").length > 0 ){
		init_specificfeeds_notice();
	}	

	function init_specificfeeds_notice(){

		$( 'a#sfmsb-specificfeeds-close' ).on( 'click', function( e ){
			
			e.preventDefault();
			
			//remove before response so there is no waiting
			$('.sfmsb-specificfeeds-notice').remove();
		
   			var data = {
				action    					: 'sfmsb_notice_viewed',
				specificfeeds_viewed_notice : 1,
				nonce	  					: sfmsb_vars.nonce
			};
   		
	   		$.post(sfmsb_vars.ajaxurl, data, function(response){
	   			
	   			if( response == 'success') {
	   				//$('.sfmsb-specificfeeds-notice').remove();
	   			}
	   			
	   		});

		});
	}


});