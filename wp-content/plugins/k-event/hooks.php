<?php
/*
Plugin Name: K Events
Plugin URI: http://lunartheme.com
Description: Event post type with Single, Listing and Shortcodes for Eduction theme
Version: 4.0.6
Author: LunarTheme
Author URI: http://lunartheme.com
Text Domain: k2t
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!defined('K_EVENT_BASE_PATH')){
	define('K_EVENT_BASE_PATH', dirname(__FILE__));
}

add_action( 'plugins_loaded', 'k_event_load_plugin_textdomain' );

function k_event_load_plugin_textdomain() {
  load_plugin_textdomain( 'k2t', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

if ( !function_exists('k_event_enqueue_plugin') ) {
	function k_event_enqueue_plugin(){
	
		/* Magnific Popup
		---------------------- */
		wp_enqueue_style( 'magnific-popup', plugin_dir_url( __FILE__ ). 'assets/css/magnific-popup.css' );
		/* Countdown
		---------------------- */
		wp_enqueue_style( 'countdown', plugin_dir_url( __FILE__ ). 'assets/css/flip-countdown.css' );
		/* Event
		---------------------- */
		wp_enqueue_style( 'event', plugin_dir_url( __FILE__ ). 'assets/css/event.css' );
	
		if( wp_script_is( 'jquery' ) ){
			wp_enqueue_script( 'jquery' );
		}
		

		wp_register_script( 'jquery-isotope',  plugin_dir_url( __FILE__ ) . 'assets/js/isotope.pkgd.min.js', array(), '', true );
		/* Expandable Javascript
		---------------------- */
		wp_register_script( 'expandable', plugin_dir_url( __FILE__ ). 'assets/js/expandable.js', array('jquery'), '1.0', true );
		/* Expandable Javascript
		---------------------- */
		wp_register_script( 'cd-dropdown', plugin_dir_url( __FILE__ ). 'assets/js/jquery.dropdown.js', array('jquery'), '1.0', true );
		/* Jquery Library: Inview
		---------------------- */
		wp_register_script( 'magnific-popup', plugin_dir_url( __FILE__ ) . 'assets/js/magnific-popup.js', array( 'jquery' ), '1.0', true );
		/* Jquery Library: Inview
		---------------------- */
		wp_register_script( 'calendar', plugin_dir_url( __FILE__ ) . 'assets/js/calendar.js', array( 'jquery' ), '1.0', true );
		wp_register_script( 'jquery-formatDateTime', plugin_dir_url( __FILE__ ) . 'assets/js/format-datetime-master/jquery.formatDateTime.js', array( 'jquery' ), '1.0', true );
		wp_register_script( 'underscore', plugin_dir_url( __FILE__ ) . 'assets/js/underscore/underscore-min.js', array( 'jquery' ), '1.0', true );
		wp_register_script( 'jquery-migrate', plugin_dir_url( __FILE__ ) . 'assets/js/jquery-migrate-1.2.1.min.js', array( 'jquery' ), '1.0', true );
		/* K Event
		---------------------- */
		wp_register_script( 'k-event', plugin_dir_url( __FILE__ ). 'assets/js/event.js', array( 'jquery' ), '1.0', true );
		/* Ajax load
		---------------------- */
		wp_localize_script('k-event-ajax', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));

		/* Countdown --*/
		wp_register_script( 'k-countdown', plugin_dir_url( __FILE__ ). 'assets/js/jquery.countdown.min.js', array('jquery'), '1.0', true );
		wp_register_script( 'k-lodash', plugin_dir_url( __FILE__ ). 'assets/js/lodash.min.js', array('jquery'), '1.0', true );
	}
	
	add_action( 'wp_enqueue_scripts', 'k_event_enqueue_plugin' );
}

//Enqueue Script and Css in Backend
if ( ! function_exists ( 'k_event_backend_scripts' ) ){
	function k_event_backend_scripts() {
		wp_enqueue_style( 'k-event-backend-style', plugin_dir_url( __FILE__ ) . 'assets/css/admin/backend.css' );
		wp_enqueue_script( 'k-event-backend-js', plugin_dir_url( __FILE__ ) . 'assets/js/admin/event.js' );
		wp_enqueue_script( 'k-event-extends-js', plugin_dir_url( __FILE__ ) . 'assets/js/admin/jquery.extends.js' );
	}
	add_action( 'admin_enqueue_scripts', 'k_event_backend_scripts' );
}

add_action( 'init', 'k2t_event_add_new_image_size' );
function k2t_event_add_new_image_size() {
    add_image_size( 'thumb_600x600', 600, 600, true ); // event default listing
    add_image_size( 'thumb_600x450', 600, 450, true ); // event recent
    add_image_size( 'thumb_130x130', 130, 130, true );
}


//Use single event template file to display post with type of k-event
if ( !function_exists( 'k2t_include_event_single_template' ) ) {
	function k2t_include_event_single_template ( $single_template ) {
		global $post;
		if ( is_singular('post-k-event') ){
			$single_template = k_event_include_template( 'event-single.php', false );
		}
		return $single_template;
	}
	add_filter( 'single_template', 'k2t_include_event_single_template' );
}

// Use single event template file to display category with taxonomy type of k-event-category
if(!function_exists('k2t_include_event_category_template')){
	function k2t_include_event_category_template( $template ){
		if( is_tax('k-event-category') ){
			$template = k_event_include_template( 'event-category.php', false );
		}
		return $template;
	}
	add_filter('template_include', 'k2t_include_event_category_template');
}

/* Add shortcode buttons to the TinyMCE editor */
// init process for registering our button
if( !function_exists('k_event_shortcode_button_init') ){
 	 function k_event_shortcode_button_init() {
	      //Abort early if the user will never see TinyMCE
	      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
	           return;
		 
	      //Add a callback to regiser our tinymce plugin   
	      add_filter('mce_external_plugins', 'k_event_register_tinymce_plugin'); 
	
	      // Add a callback to add our button to the TinyMCE toolbar
	      add_filter('mce_buttons', 'k_event_add_tinymce_button');
	}
	 
	add_action('init', 'k_event_shortcode_button_init');
	
	//This callback registers our plug-in
	function k_event_register_tinymce_plugin($plugin_array) {
	    $plugin_array['k_event_button'] = plugin_dir_url( __FILE__ ) . 'assets/js/shortcodes.js';
	    return $plugin_array;
	}
	
	//This callback adds our button to the toolbar
	function k_event_add_tinymce_button($buttons) {
	            //Add the button ID to the $button array
	    $buttons[] = "k_event_button";
	    return $buttons;
	}
	
}

if( !function_exists('k_event_process_shortcode') ){
	function k_event_process_shortcode($content){
		return do_shortcode($content);
	}
	add_filter('the_content', 'k_event_process_shortcode');
}

// replace template 
function k_event_include_template( $template = '', $include = true ){
	$child_path = get_stylesheet_directory();
	$template_path = locate_template( array( 'k-event/' . $template ) );
	if ( ! $template_path ) {
		$template_path = dirname( __FILE__ ) . '/templates/' . $template;
	}
	if ( ! file_exists( $template_path ) ) return false;
	if ( $include ) include ( $template_path );
	else return $template_path;
}

/* Include functions */
require_once( dirname(__FILE__) . '/inc/acf-content.php' ); // Add metadata of event
require_once( dirname(__FILE__) . '/inc/fn.misc.php' ); // Main function of plugin
require_once( dirname(__FILE__) . '/inc/registrations.php' ); // Section for registrations
require_once( dirname(__FILE__) . '/inc/class.k_event.php' ); // K_Event class
require_once( dirname(__FILE__) . '/inc/shortcodes/event-listing.php' ); // K Event shortcodes
require_once( dirname(__FILE__) . '/inc/shortcodes/recent-event.php' ); // K Event shortcodes recent
