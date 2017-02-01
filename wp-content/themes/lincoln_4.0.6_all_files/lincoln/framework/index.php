<?php
/*
Title		: SMOF
Description	: Slightly Modified Options Framework
Version		: 1.5.2
Author		: Syamil MJ
Author URI	: http://aquagraphite.com
License		: GPLv3 - http://www.gnu.org/copyleft/gpl.html

Credits		: Thematic Options Panel - http://wptheming.com/2010/11/thematic-options-panel-v2/
		 	  Woo Themes - http://woothemes.com/
		 	  Option Tree - http://wordpress.org/extend/plugins/option-tree/

Contributors: Syamil MJ - http://aquagraphite.com
			  Andrei Surdu - http://smartik.ws/
			  Jonah Dahlquist - http://nucleussystems.com/
			  partnuz - https://github.com/partnuz
			  Alex Poslavsky - https://github.com/plovs
			  Dovy Paukstys - http://simplerain.com
*/

define( 'SMOF_VERSION', '1.5.2' );

/**
 * Definitions
 *
 * @since 1.4.0
 */
$theme_version = '';
$smof_output = '';
	    
if( function_exists( 'wp_get_theme' ) ) {
	if( is_child_theme() ) {
		$temp_obj = wp_get_theme();
		$theme_obj = wp_get_theme( $temp_obj->get('Template') );
	} else {
		$theme_obj = wp_get_theme();    
	}

	$theme_version = $theme_obj->get('Version');
	$theme_name = $theme_obj->get('Name');
	$theme_uri = $theme_obj->get('ThemeURI');
	$author_uri = $theme_obj->get('AuthorURI');
} else {
	$theme_data = wp_get_theme( get_template_directory().'/style.css' );
	$theme_version = $theme_data['Version'];
	$theme_name = $theme_data['Name'];
	$theme_uri = $theme_data['ThemeURI'];
	$author_uri = $theme_data['AuthorURI'];
}

if ( !defined( 'ADMIN_PATH' ) )
	define( 'ADMIN_PATH', get_template_directory() . '/framework/' );
if ( !defined( 'ADMIN_DIR' ) )
	define( 'ADMIN_DIR', get_template_directory_uri() . '/framework/' );

define( 'ADMIN_IMAGES', ADMIN_DIR . 'assets/images/' );

define( 'THEMENAME', $theme_name );
/* Theme version, uri, and the author uri are not completely necessary, but may be helpful in adding functionality */
define( 'THEMEVERSION', $theme_version );
define( 'THEMEURI', $theme_uri );
define( 'THEMEAUTHORURI', $author_uri );

define( 'BACKUPS', 'backups' );


/**
 * Required Files
 *
 * @since 1.0.0
 */

// Action hooks
require_once K2T_FRAMEWORK_PATH . 'inc/class.lincoln_welcome.php'; 	
// Lincoln welcome
require_once K2T_FRAMEWORK_PATH . 'inc/sample_data.php'; 	

require_once K2T_FRAMEWORK_PATH . 'inc/fn.misc.php';
// Options filter functions
require_once K2T_FRAMEWORK_PATH . 'inc/fn.filters.php';
// Functions using in template files
require_once K2T_FRAMEWORK_PATH . 'inc/fn.theme.php';
// Almost action hooks
require_once K2T_FRAMEWORK_PATH . 'inc/fn.hooks.php';
// Option framework functions
require_once K2T_FRAMEWORK_PATH . 'inc/fn.options.php';
// SMOF Options Machine Class
require_once K2T_FRAMEWORK_PATH . 'inc/class.options_machine.php';
// Register theme options fields manually
require_once K2T_FRAMEWORK_PATH . 'theme-options/register_options_fields.php';