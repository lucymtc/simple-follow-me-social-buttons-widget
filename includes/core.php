<?php
/**
 * Boostrap the plugin
 *
 * @since  3.5.0
 *
 * @package SimpleFollowMeSocial
 */

namespace Lucymtc\SimpleFollowMeSocial\Core;

use Lucymtc\SimpleFollowMeSocial\Helper as Helper;

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
	add_action( 'admin_footer', $n('print_templates'), 1 );
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
	if( is_admin() && 'widgets.php' === $hook ){
		wp_enqueue_style( 'sfmsb-admin', SFMSB_PLUGIN_URL . 'assets/css/sfmsb-admin' . $min . '.css', array(), SFMSB_PLUGIN_VERSION);
		wp_register_script( 'sfmsb-admin', SFMSB_PLUGIN_URL . 'assets/js/sfmsb-admin' . $min . '.js', array( 'jquery', 'backbone', 'underscore'), SFMSB_PLUGIN_VERSION, true );
		wp_localize_script(
			'sfmsb-admin',
			'sfmsbWidget',
			apply_filters( __NAMESPACE__ . '/vars', array(
				'collections' => Helper\get_icons_collections(),
				'iconColor' => '#ff0000',
				'iconHoverColor' => '#000000',
				'defaultGroup' => 'others',
				'defaultStyle' => 'square'
			))
		);
		wp_enqueue_script( 'sfmsb-admin' );
	}
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
 * Output templates for JS.
 */
function print_templates(){
	include_once SFMSB_PLUGIN_TEMPLATES . 'icon.php';
}

// add_action('sfmsb_init', function(){

// echo '<pre>';
// 	$icons = get_only_icons();

// 	print_r($icons);
// 	exit;
// });
/**
 * Returns only the list of icons without categories
 * @return array
 */

