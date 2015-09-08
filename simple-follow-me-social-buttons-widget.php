<?php
/**
Plugin Name: Simple Follow Me Social Buttons Widget
Description: Widget to add some of the most popular follow me social buttons. Retina ready.
Version: 	 3.3.3
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
		public $plugin_vesion 	= null;

		
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
				self::$instance->set_plugin_version();
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
				
			} else{
				
				add_action( 'wp_enqueue_scripts', array('Sfmsb_Widget', 'add_scripts') );
			}

		 }
		 
		
		 /**
		  * includes
		  * 
		  * @since 1.0
		  */
		  
		  private function includes () {
		  	
			require_once( SFMSB_PLUGIN_DIR . '/includes/widget.php');
			
		 }

		/**
		  * set_plugin_version
		  * 
		  * @since 3.3.3
		  */

		 public function set_plugin_version() {

		 	$this->plugin_vesion = get_option( 'sfmsb_version' );

		 	
		 	if( $this->plugin_vesion == false || $this->plugin_vesion < '3.3.2' ) {
		 		delete_option('sfmsb_specificfeeds_viewed_notice');
		 	}

		 	if( $this->plugin_vesion != SFMSB_PLUGIN_VERSION ) {

		 		update_option( 'sfmsb_version', SFMSB_PLUGIN_VERSION );
		 		$this->plugin_vesion = SFMSB_PLUGIN_VERSION;

		 	}
 	
		 }

		
	     /**
		  * constants
		  * @since 1.0
		  */
		  
		  private function constants() {
		  	
		  	if( !defined('SFMSB_PLUGIN_DIR') )  	{ define('SFMSB_PLUGIN_DIR', plugin_dir_path( __FILE__ )); }
			if( !defined('SFMSB_PLUGIN_URL') )  	{ define('SFMSB_PLUGIN_URL', plugin_dir_url( __FILE__ ));  }
			if( !defined('SFMSB_PLUGIN_FILE') ) 	{ define('SFMSB_PLUGIN_FILE',  __FILE__ );  }
			if( !defined('SFMSB_PLUGIN_VERSION') )  { define('SFMSB_PLUGIN_VERSION', '3.3.3');  } 
			
		  }
		  
		 /**
		  * variables
		  * @since 1.0 
		  */
		  
		  private function variables(){
		  	
			
			$this->available_buttons = array(
											 'twitter'      	 => array( 'name' => 'Twitter',    	 'color' => '55acee' ), 
											 'facebook'     	 => array( 'name' => 'Facebook',   	 'color' => '3a5795' ), 
											 'googleplus'   	 => array( 'name' => 'Google+',    	 'color' => 'd73d32' ),  
											 'feed'         	 => array( 'name' => 'Rss Feed',   	 'color' => 'ffa500' ),
											 'specificfeeds'	 => array( 'name' => 'SpecificFeeds','color' => 'e52e13' ), 
											 'linkedin'     	 => array( 'name' => 'Linkedin',   	 'color' => '0077b5' ), 
											 'pinterest'    	 => array( 'name' => 'Pinterest',  	 'color' => 'cb2027' ), 
											 'wordpress'    	 => array( 'name' => 'WordPress',  	 'color' => '3274ae' ), 
											 'github'	    	 => array( 'name' => 'Github',     	 'color' => '101010' ),
											 'instagram'    	 => array( 'name' => 'Instagram',  	 'color' => 'b09375' ),
											 'youtube'      	 => array( 'name' => 'Youtube',    	 'color' => 'e12b28' ),
											 'vimeo'        	 => array( 'name' => 'Vimeo',      	 'color' => '1ab7ea' ),
											 'email'        	 => array( 'name' => 'Email',      	 'color' => '2758a6' ),
											 'soundcloud'   	 => array( 'name' => 'SoundCloud', 	 'color' => 'f6a46a' ),
											 'itunes'       	 => array( 'name' => 'iTunes', 	 	 'color' => 'd545e3' ),
											 'bloglovin'    	 => array( 'name' => 'Bloglovin',  	 'color' => '4bd1fa' ),
											 'flickr'       	 => array( 'name' => 'Flickr', 	 	 'color' => 'ff0084' ),
											 'tumblr'      	  	 => array( 'name' => 'Tumblr', 	 	 'color' => '36465d' ),
											 'hubpages'     	 => array( 'name' => 'HubPages', 	 'color' => '222222' ),
											 'deviantart'   	 => array( 'name' => 'Deviantart', 	 'color' => '4c5e51' ),
											 'feedly'  	    	 => array( 'name' => 'Feedly', 	 	 'color' => '87bf31' ),
											 'slideshare'   	 => array( 'name' => 'SlideShare', 	 'color' => 'f6931e' ),
											 'vine'         	 => array( 'name' => 'Vine', 		 'color' => '00bd8e' ),
											 'goodreads'    	 => array( 'name' => 'GoodReads',  	 'color' => '693d17' ),
											 'vk'           	 => array( 'name' => 'VK', 		 	 'color' => '4c75a3' ),
											 'sanscritique' 	 => array( 'name' => 'SensCritique', 'color' => '231f20' ),
											 'yelp'         	 => array( 'name' => 'Yelp', 		 'color' => 'd51600' ),
											 'lastfm'       	 => array( 'name' => 'Last.fm', 	 'color' => 'd51007' ),
											 'trover'       	 => array( 'name' => 'Trover', 		 'color' => 'f1b731' ),
											 'xing'       		 => array( 'name' => 'Xing.com', 	 'color' => '006567' ),
											 'behance'      	 => array( 'name' => 'Behance', 	 'color' => '333333' ),
											 'stackoverflow'	 => array( 'name' => 'Stackoverflow','color' => 'f37a21' ),
											 'blogger'			 => array( 'name' => 'Blogger',		 'color' => 'ff6600' ),
											 'reddit'			 => array( 'name' => 'Reddit',		 'color' => 'cee3f8' ),
											 '500px'			 => array( 'name' => '500px.com',	 'color' => '222222' ),
											 'remind'			 => array( 'name' => 'Remind', 		 'color' => '36b2ff' ),
											 'dribbble'			 => array( 'name' => 'Dribbble',	 'color' => 'e14c86' ),
											 'picasa'			 => array( 'name' => 'Picasa',		 'color' => '9762ad' ),
											 'rdio'				 => array( 'name' => 'Rdio',		 'color' => '007dc3' ),
											 'skype'			 => array( 'name' => 'Skype',		 'color' => '00aff0' ),
											 'stumbleupon'		 => array( 'name' => 'Stumbleupon',	 'color' => 'eb4924' ),
											 'foursquare'		 => array( 'name' => 'Foursquare',	 'color' => 'f84676' ),
											 'ello'		    	 => array( 'name' => 'Ello.co',		 'color' => '000000' ),
											 'openclipart'		 => array( 'name' => 'Openclipart',	 'color' => '4e9a06' ),
											 'stitcher'			 => array( 'name' => 'Stitcher',	 'color' => '101010' ),
											 'canalcocina'		 => array( 'name' => 'CanalCocina',	 'color' => '101010' ),
											 'kukers'			 => array( 'name' => 'Kukers',		 'color' => '678817' ),
											 'tastespotting'	 => array( 'name' => 'TasteSpotting','color' => '252525' ),
											 'foodgawker'		 => array( 'name' => 'Foodgawker',	 'color' => '808285' ),
											 'tripadvisor'		 => array( 'name' => 'Tripadvisor',	 'color' => '4c8a37' ),
											 'scoopit'			 => array( 'name' => 'Scoop.it',	 'color' => '6cab36' ),
											 'twitch'			 => array( 'name' => 'Twitch',		 'color' => '6441a5' ),
											 'tunein'			 => array( 'name' => 'Tunein',		 'color' => '2cb6a8' ),
											 'steam'			 => array( 'name' => 'Steam',		 'color' => '171a21' ),
											 'scribd'			 => array( 'name' => 'Scribd',		 'color' => '1a7bba' ),
											 'ravelry'			 => array( 'name' => 'Ravelry',		 'color' => 'c84a89' ),
											 'issuu'			 => array( 'name' => 'ISSUU',		 'color' => 'ef5227' ),
											 'etsy'				 => array( 'name' => 'Etsy',		 'color' => 'f37020' ),
											 'anobii'			 => array( 'name' => 'ANOBII',		 'color' => 'f15614' ),
											 'myspace'			 => array( 'name' => 'Myspace',		 'color' => '101010' ),
											 'blogconnect'		 => array( 'name' => 'Blog-Connect', 'color' => '101010' ),
											 'weibo'			 => array( 'name' => 'Weibo',		 'color' => 'd72729' ),
											 'fotocommunity'	 => array( 'name' => 'fotocommunity','color' => '101010' ),
											 'dawanda'			 => array( 'name' => 'Dawanda',		 'color' => 'c00e0e' ),
											 'aboutme'			 => array( 'name' => 'about.me',	 'color' => '044a75' ),
											 'eyeem'			 => array( 'name' => 'EyeEm',		 'color' => '101010' ),
											 'notonthehighstreet'=> array( 'name' => 'notonthehighstreet.com','color' => '0180c4' ),
											 'odnoklassniki'	 => array( 'name' => 'Odnoklassniki (ok.ru)', 'color' => 'e47d16' )
											 );
			
		  }
		
		/**
		 * load_textdomain
		 * @since 1.0
		 */
		public function load_textdomain() {
			
			load_plugin_textdomain('sfmsb_domain', false,  dirname( plugin_basename( SFMSB_PLUGIN_FILE ) ) . '/languages/' );	
	 	}

	 
}// class
	
	
}// if !class_exists


SFMSB::instance();