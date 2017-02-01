<?php
/*
Plugin Name: K Project
Plugin URI: http://lunartheme.com
Description: Project post type with Single, Listing and Shortcodes for Eduction theme
Version: 4.0.6
Author: LunarTheme
Author URI: http://lunartheme.com
Text Domain: k2t
*/

add_action( 'plugins_loaded', 'k_project_load_plugin_textdomain' );

function k_project_load_plugin_textdomain() {
  load_plugin_textdomain( 'k2t', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}


add_action( 'wp_enqueue_scripts', 'k_project_enqueue_plugin' );
if ( !function_exists('k_project_enqueue_plugin') ) {
function k_project_enqueue_plugin(){

	/* Swiper
	---------------------- */
	wp_enqueue_style( 'k2t-owlcarousel', plugin_dir_url( __FILE__ ). 'includes/css/owl.carousel.css' );
	/* Magnific Popup
	---------------------- */
	wp_enqueue_style( 'magnific-popup', plugin_dir_url( __FILE__ ). 'includes/css/magnific-popup.css' );
	/* Expandable
	---------------------- */
	wp_enqueue_style( 'expandable', plugin_dir_url( __FILE__ ). 'includes/css/expandable.css' );
	/* project
	---------------------- */
	wp_enqueue_style( 'project', plugin_dir_url( __FILE__ ) . 'includes/css/project.css' );

	if( wp_script_is( 'jquery' ) ){
		wp_enqueue_script( 'jquery' );
	}

	/* Slider: swiper
	---------------------- */
	wp_register_script( 'k2t-owlcarousel', plugin_dir_url( __FILE__ ). 'includes/js/owl.carousel.min.js', array( 'jquery' ), '1.0', true );

	/* Jquery Library: Inview
	---------------------- */
	wp_register_script( 'k2t-inview', plugin_dir_url( __FILE__ ). 'includes/js/jquery.inview.min.js', array( 'jquery' ), '1.0', true );
	/* Jquery Library: Isotope
	---------------------- */
	wp_register_script( 'jquery-isotope', plugin_dir_url( __FILE__ ). 'includes/js/isotope.pkgd.min.js', array( 'jquery' ), '1.0', true );
	/* Jquery Library: Imagesloaded
	---------------------- */
	wp_register_script( 'jquery-imagesloaded', plugin_dir_url( __FILE__ ). 'includes/js/imagesloaded.pkgd.min.js', array( 'jquery' ), '3.1.6', true );
	/* Ajax load
	---------------------- */
	wp_register_script( 'k-project', plugin_dir_url( __FILE__ ). 'includes/js/portfolio.js', array( 'jquery' ), '1.0', true );
	/* StickyMojo Javascript
	---------------------- */
	wp_register_script( 'k2t-stickyMojo', plugin_dir_url( __FILE__ ). 'includes/js/stickyMojo.js', array('jquery'), '1.0', true );
	/* Modernizr Javascript
	---------------------- */
	wp_register_script( 'modernizr', plugin_dir_url( __FILE__ ). 'includes/js/modernizr.js', array('jquery'), '1.0', true );
	/* Expandable Javascript
	---------------------- */
	wp_register_script( 'expandable', plugin_dir_url( __FILE__ ). 'includes/js/expandable.js', array('jquery'), '1.0', true );

	wp_register_script( 'cd-dropdown', plugin_dir_url( __FILE__ ). 'assets/js/jquery.dropdown.js', array('jquery'), '1.0', true );
	
	/* Ajax load
	---------------------- */
	wp_register_script( 'k2t-ajax', plugin_dir_url( __FILE__ ). 'includes/js/ajax.js', array( 'jquery' ), '1.0', true );
	wp_localize_script('k2t-ajax', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
	/* Jquery Library: Inview
	---------------------- */
	wp_register_script( 'magnific-popup', plugin_dir_url( __FILE__ ) . 'includes/js/magnific-popup.js', array( 'jquery' ), '1.0', true );
}
}

//Enqueue Script and Css in Backend
if ( ! function_exists ( 'k2t_project_backend_scripts' ) ) :
	function k2t_project_backend_scripts() {
		wp_enqueue_style( 'k2t-project-backend', plugin_dir_url( __FILE__ ) . 'includes/admin/css/k2t-backend.css' );
	}
	add_action( 'admin_enqueue_scripts', 'k2t_project_backend_scripts' );
endif;


if ( !function_exists( 'k2t_add_new_image_size_project' ) ) {
	add_action( 'init', 'k2t_add_new_image_size_project' );
	function k2t_add_new_image_size_project() {
		add_image_size( 'thumb_100x100', 100, 100, true ); // avatar teacher
		add_image_size( 'thumb_350x350', 435, 435, true ); // project small
		add_image_size( 'thumb_350x700', 435, 900, true ); // project horizontal
		add_image_size( 'thumb_700x350', 900, 435, true ); // project vertical
		add_image_size( 'thumb_700x700', 900, 900, true ); // project big
		add_image_size( 'thumb_500x9999', 700, 9999, false ); //for masony of project
		add_image_size( 'thumb_400x256', 400, 256, true ); // project related
	}
}

//Include single and taxonomy to project plugin
if ( !function_exists( 'k2t_include_single_template_project' ) ) {
	function k2t_include_single_template_project ( $single_template ) {
		global $post;
		if ( $post->post_type == 'post-k-project' ) {
			$single_template = dirname(__FILE__) . '/includes/single-post-k-project.php';
		}
		return $single_template;
	}
	add_filter( 'single_template', 'k2t_include_single_template_project' );
}

//Taxonomy file
if(!function_exists('k2t_include_taxonomy_template_project')){
	function k2t_include_taxonomy_template_project( $template ){
		if( is_tax( 'k-project-category' ) || is_tax( 'k-project-tag' ) ){
			$template = dirname(__FILE__). '/includes/taxonomy-project-category.php';
		}
		return $template;
	}
	add_filter('template_include', 'k2t_include_taxonomy_template_project');
}

/* Include functions */
require_once( dirname(__FILE__) . '/includes/project-post-type.php' ); // Register project and category
require_once( dirname(__FILE__) . '/includes/func-project.php' ); // Main function of plugin
require_once( dirname(__FILE__) . '/includes/admin/acf-content.php' ); // project option
require_once( dirname(__FILE__) . '/includes/mce/mce.php'); // Add mce buttons to post editor
require_once( dirname(__FILE__) . '/includes/shortcodes/project.php'); // Add mce buttons to post editor
require_once( dirname(__FILE__) . '/includes/widget/recent-project.php'); // Add widget






