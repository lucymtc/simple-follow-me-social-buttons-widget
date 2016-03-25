<?php
/**
 * Boostrap the plugin
 *
 * @since  2.0.0
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
function get_all_icons(){
	$icons = file_get_contents( SFMSB_PLUGIN_INC . '/icons.json');
	$icons = json_decode( $icons );

	return apply_filters( 'sfmsb_icons', $icons );
}
