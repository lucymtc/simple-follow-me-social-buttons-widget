<?php
/** 
 * @package    SFMSB
 * @subpackage admin
 * @author     Lucy Tomás
 * @since 	   2.4
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if( !class_exists( 'Sfmsb_Admin' )){
 
class Sfmsb_Admin {
 	
	/**
	 * Class contructor
	 * 
	 * @since 1.0
	 */
	
	private function __construct() {}

	public static function add_admin_scripts() {

		wp_register_script( 'sfmsb-admin-script', SFMSB_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), SFMSB_PLUGIN_VERSION );

		wp_enqueue_script('sfmsb-admin-script');

		wp_localize_script( 'sfmsb-admin-script', 'sfmsb_vars', array(
					'ajaxurl'  => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'follow_nonce' )
				) );

	}

}//class
}