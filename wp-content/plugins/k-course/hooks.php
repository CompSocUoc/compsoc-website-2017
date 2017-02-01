<?php
/*
Plugin Name: K Courses
Plugin URI: http://lunartheme.com
Description: Course post type with Single, Listing and Shortcodes for Eduction theme
Version: 4.0.6
Author: LunarTheme
Author URI: http://lunartheme.com
Text Domain: k2t
*/

/**
 * Load plugin textdomain.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'plugins_loaded', 'k_course_load_plugin_textdomain' );

function k_course_load_plugin_textdomain() {
  load_plugin_textdomain( 'k2t', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

if ( !function_exists('k_course_enqueue_plugin') ) {

	function k_course_enqueue_plugin(){
	
		/* Magnific Popup
		---------------------- */
		wp_enqueue_style( 'magnific-popup', plugin_dir_url( __FILE__ ). 'assets/css/magnific-popup.css' );
		/* Course
		---------------------- */
		wp_enqueue_style( 'course', plugin_dir_url( __FILE__ ). 'assets/css/course.css' );
	
		if( wp_script_is( 'jquery' ) ){
			wp_enqueue_script( 'jquery' );
		}
	
		wp_register_script( 'jquery-isotope',  plugin_dir_url( __FILE__ ) . 'assets/js/isotope.pkgd.min.js', array(), '', true );
		/* Expandable Javascript
		---------------------- */
		wp_register_script( 'expandable', plugin_dir_url( __FILE__ ). 'assets/js/expandable.js', array('jquery'), '1.0', true );
		/* Jquery Library: Inview
		---------------------- */
		wp_register_script( 'magnific-popup', plugin_dir_url( __FILE__ ) . 'assets/js/magnific-popup.js', array( 'jquery' ), '1.0', true );
		/* K Course
		---------------------- */
		wp_register_script( 'k-course', plugin_dir_url( __FILE__ ). 'assets/js/course.js', array( 'jquery' ), '1.0', true );

		wp_register_script( 'cd-dropdown', plugin_dir_url( __FILE__ ). 'assets/js/jquery.dropdown.js', array('jquery'), '1.0', true );

		
		/* Ajax load
		---------------------- */
		wp_localize_script('k-course-ajax', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
	}
	
	add_action( 'wp_enqueue_scripts', 'k_course_enqueue_plugin' );
}

//Enqueue Script and Css in Backend
if ( ! function_exists ( 'k_course_backend_scripts' ) ){
	function k_course_backend_scripts() {
		wp_enqueue_style( 'k-course-backend-style', plugin_dir_url( __FILE__ ) . 'assets/css/admin/backend.css' );
		wp_enqueue_script( 'k-course-extends-js', plugin_dir_url( __FILE__ ) . 'assets/js/admin/jquery.extends.js' );
	}
	add_action( 'admin_enqueue_scripts', 'k_course_backend_scripts' );
}

add_action( 'init', 'k2t_course_add_new_image_size' );
function k2t_course_add_new_image_size() {
    add_image_size( 'thumb_600x600', 600, 600, true ); // event default listing
    add_image_size( 'thumb_600x340', 600, 340, true ); // event default listing
    add_image_size( 'thumb_270x155', 270, 155, true ); // Related course in single
    add_image_size( 'thumb_130x130', 130, 130, true );
}


//Use single course template file to display post with type of k-course
if ( !function_exists( 'k2t_include_course_single_template' ) ) {
	function k2t_include_course_single_template ( $single_template ) {
		global $post;
		if ( is_singular('post-k-course') ){
			$single_template = k_course_include_template( 'course-single.php', false );
		}
		return $single_template;
	}
	add_filter( 'single_template', 'k2t_include_course_single_template' );
}

// Use single course template file to display category with taxonomy type of k-course-category
if(!function_exists('k2t_include_course_category_template')){
	function k2t_include_course_category_template( $template ){
		if( is_tax( 'k-course-category' ) ){
			$template = k_course_include_template( 'course-category.php', false );
		}
		return $template;
	}
	add_filter('template_include', 'k2t_include_course_category_template');
}

/* Add shortcode buttons to the TinyMCE editor */
// init process for registering our button
if( !function_exists('k_course_shortcode_button_init') ){
 	 function k_course_shortcode_button_init() {
	      //Abort early if the user will never see TinyMCE
	      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
	           return;
		 
	      //Add a callback to regiser our tinymce plugin   
	      add_filter('mce_external_plugins', 'k_course_register_tinymce_plugin'); 
	
	      // Add a callback to add our button to the TinyMCE toolbar
	      add_filter('mce_buttons', 'k_course_add_tinymce_button');
	}
	 
	add_action('init', 'k_course_shortcode_button_init');
	
	//This callback registers our plug-in
	function k_course_register_tinymce_plugin($plugin_array) {
	    $plugin_array['k_course_button'] = plugin_dir_url( __FILE__ ) . 'assets/js/shortcodes.js';
	    return $plugin_array;
	}
	
	//This callback adds our button to the toolbar
	function k_course_add_tinymce_button($buttons) {
	            //Add the button ID to the $button array
	    $buttons[] = "k_course_button";
	    return $buttons;
	}
	
}

if( !function_exists('k_course_process_shortcode') ){
	function k_course_process_shortcode($content){
		return do_shortcode($content);
	}
	add_filter('the_content', 'k_course_process_shortcode');
}

// replace template 
function k_course_include_template( $template = '', $include = true ){
	$child_path = get_stylesheet_directory();
	$template_path = locate_template( array( 'k-course/' . $template ) );
	if ( ! $template_path ) {
		$template_path = dirname( __FILE__ ) . '/templates/' . $template;
	}
	if ( ! file_exists( $template_path ) ) return false;
	if ( $include ) include ( $template_path );
	else return $template_path;
}

/* Include functions */
require_once( dirname(__FILE__) . '/inc/acf-content.php' ); // Add metadata of course
require_once( dirname(__FILE__) . '/inc/fn.misc.php' ); // Main function of plugin
require_once( dirname(__FILE__) . '/inc/registrations.php' ); // Section for registrations
require_once( dirname(__FILE__) . '/inc/class.k_course.php' ); // K_Course class
require_once( dirname(__FILE__) . '/inc/shortcodes/course-listing.php' ); // K Course shortcodes
