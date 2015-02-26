<?php
/**
Plugin Name: Simple Follow Me Social Buttons Widget
Description: Widget to add some of the most popular follow me social buttons. Retina ready.
Version: 	 3.3.1
Author: 	 Lucy Tomás
Author URI:  https://wordpress.org/support/profile/lucymtc
License: 	 GPLv2
*/
 
 /* Copyright 2014 Lucy Tomás (email: lucy@wptips.me)
  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 // If this file is called directly, exit.
if ( !defined( 'ABSPATH' ) ) exit;

if( !class_exists('SFMSB') ) {
	
	/**
	 * Main class
	 * @since   1.0
	 */
	
final class SFMSB {

		private static $instance = null;
	
		public $default_options = array();
		
		/**
		 * Instance
		 * This functions returns the only one true instance of the plugin main class
		 * 
		 * @return object instance
		 * @since  1.0
		 */
		
		public static function instance (){
			
			if( self::$instance == null ){
					
				self::$instance = new SFMSB;
				self::$instance->constants();
				self::$instance->includes();
				self::$instance->load_textdomain();
				self::$instance->variables();
			}
			
			return self::$instance;
		}
		
		/**
		 * Class Contructor
		 * 
		 * @since 1.0
		 */

		 private function __construct () {
		 
			$this->default_options = array();
			
			add_action( 'widgets_init', array('Sfmsb_Widget', 'register_widgets') );
			
			if( is_admin() ) {

				add_action( 'admin_enqueue_scripts', array('Sfmsb_Widget', 'add_admin_scripts') );
				add_action( 'admin_enqueue_scripts', array('Sfmsb_Admin', 'add_admin_scripts') );
				add_action( 'admin_notices', 		 array('SFMSB', 'specificfeeds_notice') );

			} else{
				
				add_action( 'wp_enqueue_scripts', array('Sfmsb_Widget', 'add_scripts') );
			}

			add_action('wp_ajax_sfmsb_notice_viewed', array('SFMSB', 'specificfeeds_save_notice_viewed'));
			add_action('wp_ajax_nopriv_sfmsb_notice_viewed', array('SFMSB', 'specificfeeds_save_notice_viewed'));
			
		 }
		 
		
		 /**
		  * includes
		  * 
		  * @since 1.0
		  */
		  
		  private function includes () {
		  	
			require_once( SFMSB_PLUGIN_DIR . '/includes/widget.php');
			require_once( SFMSB_PLUGIN_DIR . '/includes/admin.php');
		
		 }

		
	     /**
		  * constants
		  * @since 1.0
		  */
		  
		  private function constants() {
		  	
		  	if( !defined('SFMSB_PLUGIN_DIR') )  	{ define('SFMSB_PLUGIN_DIR', plugin_dir_path( __FILE__ )); }
			if( !defined('SFMSB_PLUGIN_URL') )  	{ define('SFMSB_PLUGIN_URL', plugin_dir_url( __FILE__ ));  }
			if( !defined('SFMSB_PLUGIN_FILE') ) 	{ define('SFMSB_PLUGIN_FILE',  __FILE__ );  }
			if( !defined('SFMSB_PLUGIN_VERSION') )  { define('SFMSB_PLUGIN_VERSION', '3.3.1');  } 
			
		  }
		  
		 /**
		  * variables
		  * @since 1.0 
		  */
		  
		  private function variables(){
		  	
			
			$this->available_buttons = array(
											 'specificfeeds'	 => array( 'name' => 'SpecificFeeds','color' => 'd68678' ),
											 'twitter'      	 => array( 'name' => 'Twitter',    	 'color' => '84b3dc' ), 
											 'facebook'     	 => array( 'name' => 'Facebook',   	 'color' => '6c97bf' ), 
											 'googleplus'   	 => array( 'name' => 'Google+',    	 'color' => 'd68778' ),  
											 'feed'         	 => array( 'name' => 'Rss Feed',   	 'color' => 'e1b96a' ), 
											 'linkedin'     	 => array( 'name' => 'Linkedin',   	 'color' => '6c97bf' ), 
											 'pinterest'    	 => array( 'name' => 'Pinterest',  	 'color' => 'd68678' ), 
											 'wordpress'    	 => array( 'name' => 'WordPress',  	 'color' => '6b96be' ), 
											 'github'	    	 => array( 'name' => 'Github',     	 'color' => '717272' ),
											 'instagram'    	 => array( 'name' => 'Instagram',  	 'color' => 'b9a38c' ),
											 'youtube'      	 => array( 'name' => 'Youtube',    	 'color' => 'd68778' ),
											 'vimeo'        	 => array( 'name' => 'Vimeo',      	 'color' => '4b6079' ),
											 'email'        	 => array( 'name' => 'Email',      	 'color' => '84b3dc' ),
											 'soundcloud'   	 => array( 'name' => 'SoundCloud', 	 'color' => 'f6a46a' ),
											 'itunes'       	 => array( 'name' => 'iTunes', 	 	 'color' => 'cf95f5' ),
											 'bloglovin'    	 => array( 'name' => 'Bloglovin',  	 'color' => '5ed3f5' ),
											 'flickr'       	 => array( 'name' => 'Flickr', 	 	 'color' => 'f66db4' ),
											 'tumblr'      	  	 => array( 'name' => 'Tumblr', 	 	 'color' => '436381' ),
											 'hubpages'     	 => array( 'name' => 'HubPages', 	 'color' => '717272' ),
											 'deviantart'   	 => array( 'name' => 'Deviantart', 	 'color' => 'c0ca65' ),
											 'feedly'  	    	 => array( 'name' => 'Feedly', 	 	 'color' => '6bc581' ),
											 'slideshare'   	 => array( 'name' => 'SlideShare', 	 'color' => 'e7a463' ),
											 'vine'         	 => array( 'name' => 'Vine', 		 'color' => '6bc3ad' ),
											 'goodreads'    	 => array( 'name' => 'GoodReads',  	 'color' => '8d7469' ),
											 'vk'           	 => array( 'name' => 'VK', 		 	 'color' => '6c97bf' ),
											 'sanscritique' 	 => array( 'name' => 'SensCritique', 'color' => '9ed47b' ),
											 'yelp'         	 => array( 'name' => 'Yelp', 		 'color' => 'b33e3a' ),
											 'lastfm'       	 => array( 'name' => 'Last.fm', 	 'color' => 'd5565a' ),
											 'trover'       	 => array( 'name' => 'Trover', 		 'color' => 'b79344' ),
											 'xing'       		 => array( 'name' => 'Xing.com', 	 'color' => '498383' ),
											 'behance'      	 => array( 'name' => 'Behance', 	 'color' => '717272' ),
											 'stackoverflow'	 => array( 'name' => 'Stackoverflow','color' => 'f2ab5a' ),
											 'blogger'			 => array( 'name' => 'Blogger',		 'color' => 'f5b075' ),
											 'reddit'			 => array( 'name' => 'Reddit',		 'color' => 'd3f3fe' ),
											 '500px'			 => array( 'name' => '500px.com',	 'color' => '717272' ),
											 'remind'			 => array( 'name' => 'Remind', 		 'color' => '72c9ff' ),
											 'dribbble'			 => array( 'name' => 'Dribbble',	 'color' => 'efa3be' ),
											 'picasa'			 => array( 'name' => 'Picasa',		 'color' => 'b06bb3' ),
											 'rdio'				 => array( 'name' => 'Rdio',		 'color' => '4e9ace' ),
											 'skype'			 => array( 'name' => 'Skype',		 'color' => '47bfeb' ),
											 'stumbleupon'		 => array( 'name' => 'Stumbleupon',	 'color' => 'e47961' ),
											 'foursquare'		 => array( 'name' => 'Foursquare',	 'color' => 'f37496' ),
											 'ello'		    	 => array( 'name' => 'Ello.co',		 'color' => '717272' ),
											 'openclipart'		 => array( 'name' => 'Openclipart',	 'color' => '74ab40' ),
											 'stitcher'			 => array( 'name' => 'Stitcher',	 'color' => '717272' ),
											 'canalcocina'		 => array( 'name' => 'CanalCocina',	 'color' => '717272' ),
											 'kukers'			 => array( 'name' => 'Kukers',		 'color' => '778752' ),
											 'tastespotting'	 => array( 'name' => 'TasteSpotting','color' => '808285' ),
											 'foodgawker'		 => array( 'name' => 'Foodgawker',	 'color' => '808285' ),
											 'tripadvisor'		 => array( 'name' => 'Tripadvisor',	 'color' => '73b35b' ),
											 'scoopit'			 => array( 'name' => 'Scoop.it',	 'color' => '88ad69' ),
											 'twitch'			 => array( 'name' => 'Twitch',		 'color' => '8d79b0' ),
											 'tunein'			 => array( 'name' => 'Tunein',		 'color' => '6fb6af' ),
											 'steam'			 => array( 'name' => 'Steam',		 'color' => '467293' ),
											 'scribd'			 => array( 'name' => 'Scribd',		 'color' => '3074a0' ),
											 'ravelry'			 => array( 'name' => 'Ravelry',		 'color' => 'de4d7d' ),
											 'issuu'			 => array( 'name' => 'ISSUU',		 'color' => 'ec8569' ),
											 'etsy'				 => array( 'name' => 'Etsy',		 'color' => 'd97850' ),
											 'anobii'			 => array( 'name' => 'ANOBII',		 'color' => 'f4995d' ),
											 'myspace'			 => array( 'name' => 'Myspace',		 'color' => '717272' ),
											 'blogconnect'		 => array( 'name' => 'Blog-Connect', 'color' => '717272' ),
											 'weibo'			 => array( 'name' => 'Weibo',		 'color' => 'd73e3e' ),
											 'fotocommunity'	 => array( 'name' => 'fotocommunity','color' => '717272' ),
											 'dawanda'			 => array( 'name' => 'Dawanda',		 'color' => 'ca5452' ),
											 'aboutme'			 => array( 'name' => 'about.me',	 'color' => '265979' ),
											 'eyeem'			 => array( 'name' => 'EyeEm',		 'color' => '717272' ),
											 'notonthehighstreet'=> array( 'name' => 'notonthehighstreet.com','color' => '2098bb' ),
											 'odnoklassniki'	 => array( 'name' => 'Odnoklassniki (ok.ru)', 'color' => 'eb9633' )
											 );
			
		  }
		
		/**
		 * load_textdomain
		 * @since 1.0
		 */
		public function load_textdomain() {
			
			load_plugin_textdomain('sfmsb_domain', false,  dirname( plugin_basename( SFMSB_PLUGIN_FILE ) ) . '/languages/' );	
	 	}

	 	/**
	 	 * specificfeeds_notice
	 	 * displays a notice to inform specificfeeds icon has been added 
	 	 *
	 	 * @since 2.3
	 	 */

	 	public static function specificfeeds_notice() {
	 	
	 		$option = get_option('sfmsb_specificfeeds_viewed_notice');

	 		if( empty($option ) ) {
	 	?>
			    <div class="updated sfmsb-specificfeeds-notice">
			    	
			        <p>
			        	<span class="sfmsb-icon-specificfeeds square"></span>
			        	<span class="sfmsb-icon-specificfeeds circle"></span>
			        	<span><?php _e( '<strong>Simple Follow Me Social Buttons Widget</strong> has included <a href="http://www.specificfeeds.com"><strong>SpecificFeeds.com</strong></a> icon. You still don\'t know about SpecificFeeds? <a href="http://www.specificfeeds.com/rss">Learn more from here</a>, it\'s 100% FREE.', 'sfmsb_domain' ); ?></span>
			        </p>

			        <a href="javascript:void(0);" id="sfmsb-specificfeeds-close"><span class="sfmsb-icon-close"></span></a>
			    </div>
    	<?php	
    		}// if ! option
	 	}

	 	/**
	 	 * specificfeeds_save_notice_viewed
	 	 * saves option to indicate that the notice has been closed to not show again
		 *	
	 	 * @since 2.3
	 	 */

	 	public static function specificfeeds_save_notice_viewed(){
	 		
			
	 		if( isset($_POST['specificfeeds_viewed_notice']) && 
	 			isset($_POST['specificfeeds_viewed_notice']) == 1 && 
	 			is_user_logged_in()) {

	 			update_option('sfmsb_specificfeeds_viewed_notice', 1);
	 			echo 'success';

	 		} 

	 		die();
	 	}
		
		
}// class
	
	
}// if !class_exists


SFMSB::instance();