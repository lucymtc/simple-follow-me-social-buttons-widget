<?php
/**
Plugin Name: Simple Follow Me Social Buttons Widget
Description: Widget to add some of the most popular follow me social buttons. Retina ready.
Version: 	 1.4
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
			} else{
				add_action( 'wp_enqueue_scripts', array('Sfmsb_Widget', 'add_style') );
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
		  * constants
		  * @since 1.0
		  */
		  
		  private function constants() {
		  	
		  	if( !defined('SFMSB_PLUGIN_DIR') )  { define('SFMSB_PLUGIN_DIR', plugin_dir_path( __FILE__ )); }
			if( !defined('SFMSB_PLUGIN_URL') )  { define('SFMSB_PLUGIN_URL', plugin_dir_url( __FILE__ ));  }
			if( !defined('SFMSB_PLUGIN_FILE') ) { define('SFMSB_PLUGIN_FILE',  __FILE__ );  }
			if( !defined('SFMSB_PLUGIN_VERSION') )  { define('SFMSB_PLUGIN_VERSION', '1.4');  } 
			
		  }
		  
		 /**
		  * variables
		  * @since 1.0 
		  */
		  
		  private function variables(){
		  	
			
			$this->available_buttons = array('twitter'     => array('name' => 'Twitter',
																	'color' => '84b3dc'), 
											 'facebook'    => array('name' => 'Facebook',
																	'color' => '6c97bf'), 
											 'googleplus'  => array('name' => 'Google+',
																	'color' => 'd68778'),  
											 'feed'        => array('name' => 'Rss Feed',
																	'color' => 'e1b96a'), 
											 'linkedin'     => array('name' => 'Linkedin',
																	'color' => '6c97bf'), 
											 'pinterest'    => array('name' => 'Pinterest',
																	'color' => 'd68678'), 
											 'wordpress'    => array('name' => 'WordPress',
																	'color' => '6b96be'), 
											 'github'	   => array('name' => 'Github',
																	'color' => '717272'),
											 'instagram'   => array('name' => 'Instagram',
																	'color' => 'b9a38c'),
											 'youtube'     => array('name' => 'Youtube',
																	'color' => 'd68778'),
											 'vimeo'     => array('name' => 'Vimeo',
																	'color' => '4b6079'),
											 'email'     => array('name' => 'Email',
																	'color' => '84b3dc'),
											 'soundcloud'     => array('name' => 'SoundCloud',
																	'color' => 'f6a46a')																																																															
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
 

