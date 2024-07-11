<?php
/**
 * Minimal WP Theme
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Minimal WP Theme
 */

namespace Core;

// Useful global constants

define( 'CORE_URL', get_stylesheet_directory_uri() );
define( 'CORE_TEMPLATE_URL', get_template_directory_uri() ); 
define( 'CORE_PATH', dirname( __FILE__ ). '/' ); 
define( 'CORE_INC', CORE_PATH . 'includes/' );
define( 'CORE_PLUGINS_PATH', plugins_url() );
define( 'CORE_WIDGET', CORE_INC . 'widgets/' );
define( 'CORE_SHORTCODE', CORE_INC . 'shortcodes/' );
define( 'CORE_VENDOR', CORE_PATH . 'vendor/' );
define( 'CORE_DIST', CORE_URL . '/js/dist/' );

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}


require_once CORE_INC . 'image-settings.php';
require_once CORE_INC . 'tools.php';
require_once CORE_INC . 'site-functions.php';
require_once CORE_INC . 'widgets.php';
require_once CORE_INC . 'custom-posts.php';
require_once CORE_INC . 'custom-settings.php';
require_once CORE_INC . 'shortcodes.php';
require_once CORE_INC . 'custom-block-patterns.php';
require_once CORE_INC . 'performance-functions.php';
require_once CORE_INC . 'ticket-functions.php';
require_once CORE_INC . 'commerce-functions.php';
require_once CORE_INC . 'show-functions.php';


 /**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', '\Core\upvancouver_enqueue_styles' );
function upvancouver_enqueue_styles() 
{	
	// wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'upvanvcouver-style', get_stylesheet_uri(), array(), _S_VERSION ); 
} 
