<?php
/**
 * Theme functions for Lincoln
 *
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
/*--------------------------------------------------------------
	Define Constants
--------------------------------------------------------------*/
define( 'K2T_THEME_PATH', get_template_directory() . '/' );
define( 'K2T_THEME_URL', get_template_directory_uri() . '/' );
define( 'K2T_FRAMEWORK_PATH', K2T_THEME_PATH . 'framework/' );
define( 'K2T_FRAMEWORK_URL', K2T_THEME_URL . 'framework/' );
define( 'K2T_TEMPLATE_PATH', K2T_THEME_PATH . 'templates/' );

/*--------------------------------------------------------------
	Admin - Framework
--------------------------------------------------------------*/
require_once K2T_FRAMEWORK_PATH . 'index.php';
require_once K2T_FRAMEWORK_PATH . 'inc/k2timporter/import.php'; // Advance Importer
require_once K2T_FRAMEWORK_PATH . 'extensions/plugins/k2t-icon/hooks.php'; // add Icon Feature
require_once K2T_FRAMEWORK_PATH . 'extensions/widgets/widget-register.php'; // Adding widgets

/*--------------------------------------------------------------
	3rd-plugins
--------------------------------------------------------------*/
require_once K2T_FRAMEWORK_PATH . 'extensions/plugins/class-tgm-plugin-activation.php'; // Load TGM Plugin Activation library if not already loaded
require_once K2T_FRAMEWORK_PATH . 'extensions/plugins/aq-resizer.php'; // Integration aq resizer script
require_once K2T_FRAMEWORK_PATH . 'inc/register_custom_fields.php'; // Adding advanced custom fields
require_once K2T_FRAMEWORK_PATH . 'inc/mega-menu/mega-menu-framework.php'; // Adding k2t mega menu
require_once K2T_FRAMEWORK_PATH . 'inc/mega-menu/mega-menus.php';
if ( class_exists( 'Woocommerce' ) ) {
	require_once K2T_FRAMEWORK_PATH . 'inc/class.k2t_template_woo.php'; // Integrated Woocommerce plugin
}

/*-------------------------------------------------------------------
	Encode And Decode string Functions
--------------------------------------------------------------------*/
if ( ! function_exists( 'k2t_encode' ) ) {
	function k2t_encode( $string = '' ) {
		return base64_encode( $string );
	}
}
if ( ! function_exists( 'k2t_decode' ) ) {
	function k2t_decode( $string = '' ) {
		return base64_decode( $string );
	}
}

add_filter('deprecated_constructor_trigger_error', '__return_false');
add_filter( 'wpcf7_support_html5_fallback', '__return_true' );
remove_filter('the_content', 'wpautop');