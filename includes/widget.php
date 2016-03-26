<?php
/**
 * Boostrap the plugin
 *
 * @since  2.0.0
 *
 * @package SimpleFollowMeSocial
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'Sfmsb_Widget' )){

class Sfmsb_Widget extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 */

	function __construct() {

		$this->defaults = array(
			'title'    => esc_html_e('Social', 'sfmsb'),
			'size'     => '20',
			'position' => 'under',
			'text'     => esc_html_e('Follow me on:', 'sfmsb'),
			'color'    => '',
			'hover_color' => '',
			'style'    => 'circle',
			'layout'   => 'horizontal',
		);

	}



}
