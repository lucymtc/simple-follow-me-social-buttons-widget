<?php
/**
 * Helper functions
 *
 * @since  3.5.0
 *
 * @package SimpleFollowMeSocial
 */

namespace Lucymtc\SimpleFollowMeSocial\Helper;

/**
 * Returns the list of categories with icons.
 * @return array
 */
function get_icons_collections(){
	$cache_key = 'sfmsb_categories_icons_' . get_icons_filetime();
	// Get cached result.
	if( ! $icons_set = wp_cache_get( $cache_key ) ){
		$icons_set = file_get_contents( get_icons_file_path() );
		$icons_set = json_decode( $icons_set );
		wp_cache_set( $cache_key, $icons_set );
	}
	return apply_filters( 'sfmsb_categories_icons', $icons_set );
}

// function get_only_icons(){
// 	$cache_key = 'sfmsb_icons_' . get_icons_filetime();
// 	// Get cached result.
// 	if( ! $result = wp_cache_get( $cache_key ) ){
// 		$result = array();
// 		$icons_set = get_full_icons();
// 		foreach( $icons_set as $category => $icons ) {
// 			$icons = (array) $icons->icons;
// 			array_push( $result, $icons);
// 		}
// 		// To remove the categories keys in the array so we only return icons.
// 		$result = array_reduce( $result, 'array_merge', array() );
// 		wp_cache_set( $cache_key, $result );
// 	}

// 	return apply_filters( 'sfmsb_icons', $result );
// }


/**
 * Returns the path to the json file containing the list of icons available in the plugin
 * @return string
 */
function get_icons_file_path(){
	return apply_filters( 'sfmsb_icons_file_path', SFMSB_PLUGIN_INC . '/icons.json' );
}

/**
 * Returns the timestamp of last update of the icons json file
 * @return int
 */
function get_icons_filetime(){
	$file = get_icons_file_path();
	if( ! file_exists( $file ) ){
		return new WP_Error( 'error', esc_html_e( 'The file '. $file .' is missing', 'sfmsb' ) );
	}
	return filemtime( $file );
}
