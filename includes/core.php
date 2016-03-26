<?php
/**
 * Boostrap the plugin
 *
 * @since  3.5.0
 *
 * @package SimpleFollowMeSocial
 */

namespace Lucymtc\SimpleFollowMeSocial\Core;

/**
 * Deafult setup
 * @return void
 */
function setup(){
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'init', $n('i18n') );
	add_action( 'init', $n('init') );
	add_action( 'admin_enqueue_scripts', $n('enqueue_scripts') );
}

/**
 * load texdomain
 * @return void
 */
function i18n(){
	$locale = apply_filters('plugin_locale', get_locale(), 'sfmsb');
	load_textdomain( 'sfmsb', WP_LANG_DIR.'/simple-follow-me-social-buttons-widget/sfmsb-'. $locale .'.mo');
	load_plugin_textdomain( 'sfmsb', false,  dirname( plugin_basename( SFMSB_PLUGIN_FILE ) ) . '/languages/' );
}

/**
 * Fires an action so plugins can hook into.
 * @return void
 */
function init(){
	do_action('sfmsb_init');
}

/**
 * Enqueues scripts and styles
 * @param  String $hook
 * @return void
 */
function enqueue_scripts( $hook ) {
		$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_style( 'sfmsb', SFMSB_PLUGIN_URL . 'assets/css/sfmsb' . $min . '.css', array(), SFMSB_PLUGIN_VERSION);
		wp_enqueue_script( 'sfmsb', SFMSB_PLUGIN_URL . 'assets/js/sfmsb' . $min . '.js', array( 'jquery'), SFMSB_PLUGIN_VERSION, true );
}

/**
 * On plugin activation
 * @return void
 */
function activate(){}

/**
 * On plugin deactivation
 * @return void
 */
function deactivate(){}

/**
 * Returns the list of icons available in the flugin
 * @return array
 */
function get_icons(){

	$file = get_icons_file_path();
	if( ! file_exists( $file ) ){
		return new WP_Error( 'error', esc_html_e( 'The file '. $file .' is missing', 'sfmsb' ) );
	}

	$last_update = filemtime( $file );
	$cache_key = 'sfmsb_icons_' . $last_update;

	// Get cached result.
	if( ! $result = wp_cache_get( $cache_key ) ){

		$result = array();
		$icons_set = file_get_contents( SFMSB_PLUGIN_INC . '/icons.json');
		$icons_set = json_decode( $icons_set );
		foreach( $icons_set as $category => $icons ) {
			$icons = (array) $icons;
			array_push( $result, $icons);
		}
		// To remove the categories keys in the array so we only return icons.
		$result = array_reduce( $result, 'array_merge', array() );
		wp_cache_set( $cache_key, $result );
	}

	return apply_filters( 'sfmsb_icons', $result );
}

/**
 * Returns the path to the json file containing the list of icons available in the plugin
 * @return string
 */
function get_icons_file_path(){
	return apply_filters( 'sfmsb_icons_file_path', SFMSB_PLUGIN_INC . '/icons.json' );
}
