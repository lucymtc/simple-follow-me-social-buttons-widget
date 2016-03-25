<?php
/**
 * Plugin Name: Simple Follow Me Social Buttons Widget
 * Plugin URI:  http://wordpress.org/plugins
 * Description: Widget to add some of the most popular follow me social buttons. Retina ready.
 * Version:     3.5.0
 * Author:      Lucy Tomas
 * Author URI:  http://lucytomas.com
 * License:     GPLv2+
 * Text Domain: sfmsb
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2016 Lucy Tomas (email : lucy@wptips.me)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using grunt-wp-plugin
 * Copyright (c) 2013 10up, LLC
 * https://github.com/10up/grunt-wp-plugin
 */

// Useful global constants
if ( ! defined( 'SFMSB_PLUGIN_PATH' ) ) { define( 'SFMSB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) ); }
if ( ! defined( 'SFMSB_PLUGIN_URL' ) ) { define( 'SFMSB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );  }
if ( ! defined( 'SFMSB_PLUGIN_FILE' ) ) { define( 'SFMSB_PLUGIN_FILE',  __FILE__ );  }
if ( ! defined( 'SFMSB_PLUGIN_VERSION' ) ) { define( 'SFMSB_PLUGIN_VERSION', '3.5.0' );  }
if ( ! defined( 'SFMSB_PLUGIN_INC' ) ) { define( 'SFMSB_PLUGIN_INC', SFMSB_PLUGIN_PATH . 'includes/' ); }


// Admin Setup.
include_once SFMSB_PLUGIN_INC . 'core.php';

// Activation/Deactivation.
register_activation_hook( __FILE__, '\Lucymtc\SimpleFollowMeSocial\Core\activate' );
register_deactivation_hook( __FILE__, '\Lucymtc\SimpleFollowMeSocial\Core\deactivate' );

// Core.
\Lucymtc\SimpleFollowMeSocial\Core\setup();

