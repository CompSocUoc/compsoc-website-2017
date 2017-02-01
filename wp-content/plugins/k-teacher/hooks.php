<?php
/*
Plugin Name: K Teachers
Plugin URI: http://lunartheme.com
Description: Teacher post type with Single, Listing and Shortcodes for Eduction theme
Version: 4.0.6
Author: LunarTheme
Author URI: http://lunartheme.com
Text Domain: k2t
*/

add_action( 'plugins_loaded', 'k_teacher_load_plugin_textdomain' );

function k_teacher_load_plugin_textdomain() {
  load_plugin_textdomain( 'k2t', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! defined( 'K_TEACHER_PLG_PATH' ) ){
	define('K_TEACHER_PLG_PATH', plugin_dir_path( __FILE__ ));
}
if ( ! defined( 'K_TEACHER_PLG_DIRECTORY' ) ){
    $plugin_path = explode('/', str_replace('\\', '/', K_TEACHER_PLG_PATH));
    define('K_TEACHER_PLG_DIRECTORY', $plugin_path[count($plugin_path) - 2 ]);
}


if ( !function_exists('k_teacher_enqueue_plugin') ) {
	function k_teacher_enqueue_plugin(){
	
		/* Magnific Popup
		---------------------- */
		wp_enqueue_style( 'magnific-popup', plugin_dir_url( __FILE__ ). 'assets/css/magnific-popup.css' );

		/* Teacher
		---------------------- */
		wp_enqueue_style( 'teacher', plugin_dir_url( __FILE__ ). 'assets/css/teacher.css' );
	
		if( wp_script_is( 'jquery' ) ){
			wp_enqueue_script( 'jquery' );
		}

		/* Jquery Library: Inview
		---------------------- */
		wp_register_script( 'magnific-popup', plugin_dir_url( __FILE__ ) . 'assets/js/magnific-popup.js', array( 'jquery' ), '1.0', true );

		/* Jquery Library: isotope
		---------------------- */
		wp_register_script( 'isotope-js', plugin_dir_url( __FILE__ ). 'assets/js/isotope.pkgd.min.js', array( 'jquery' ), '1.0', true );
		/* K Teacher
		---------------------- */
		wp_register_script( 'teacher-js', plugin_dir_url( __FILE__ ). 'assets/js/teacher.js', array( 'jquery' ), '1.0', true );
		/* Ajax load
		---------------------- */
		wp_localize_script('k-teacher-ajax', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));


	}
	
	add_action( 'wp_enqueue_scripts', 'k_teacher_enqueue_plugin' );
}

//Enqueue Script and Css in Backend
if ( ! function_exists ( 'k_teacher_backend_scripts' ) ){
	function k_teacher_backend_scripts() {
		wp_enqueue_style( 'k-teacher-backend-style', plugin_dir_url( __FILE__ ) . 'assets/css/admin/backend.css' );
		wp_enqueue_script( 'k-teacher-backend-js', plugin_dir_url( __FILE__ ) . 'assets/js/admin/teacher.js' );
		wp_enqueue_script( 'k-teacher-extends-js', plugin_dir_url( __FILE__ ) . 'assets/js/admin/jquery.extends.js' );
	}
	add_action( 'admin_enqueue_scripts', 'k_teacher_backend_scripts' );
}

add_action( 'init', 'k2t_teacher_add_new_image_size' );
function k2t_teacher_add_new_image_size() {
	add_image_size( 'thumb_130x130', 130, 130, true ); // teacher classic listing thumb
    add_image_size( 'thumb_500x500', 500, 500, true ); // teacher default listing
}


/**
 * Use single teacher template file to display post with type of k-teacher
 * All file in k-teacher/templates can be override in themes/theme_name/k-teacher/
 */
if ( !function_exists( 'k2t_include_teacher_single_template' ) ) {
	function k2t_include_teacher_single_template ( $single_template ) {
		global $post;
		if ( is_singular('post-k-teacher') ){
            if (locate_template('k-teacher/teacher-single.php') != '') {
                $single_template = get_template_directory() . '/k-teacher/teacher-single.php';
                echo ( $single_template );
            }else {
                $single_template = dirname(__FILE__) . '/templates/teacher-single.php';
            }
		}
		return $single_template;
	}
	add_filter( 'single_template', 'k2t_include_teacher_single_template' );
}

/* Add shortcode buttons to the TinyMCE editor */
// init process for registering our button
if( !function_exists('k_teacher_shortcode_button_init') ){
 	 function k_teacher_shortcode_button_init() {
	      //Abort early if the user will never see TinyMCE
	      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
	           return;
		 
	      //Add a callback to regiser our tinymce plugin   
	      add_filter('mce_external_plugins', 'k_teacher_register_tinymce_plugin'); 
	
	      // Add a callback to add our button to the TinyMCE toolbar
	      add_filter('mce_buttons', 'k_teacher_add_tinymce_button');
	}
	 
	add_action('init', 'k_teacher_shortcode_button_init');
	
	//This callback registers our plug-in
	function k_teacher_register_tinymce_plugin($plugin_array) {
	    $plugin_array['k_teacher_button'] = plugin_dir_url( __FILE__ ) . 'assets/js/shortcodes.js';
	    return $plugin_array;
	}
	
	//This callback adds our button to the toolbar
	function k_teacher_add_tinymce_button($buttons) {
	            //Add the button ID to the $button array
	    $buttons[] = "k_teacher_button";
	    return $buttons;
	}
	
}

if( !function_exists('k_teacher_process_shortcode') ){
	function k_teacher_process_shortcode($content){
		return do_shortcode($content);
	}
	add_filter('the_content', 'k_teacher_process_shortcode');
}

/**
 * Download teacher ICAL
 */
if ( ! function_exists( 'k2t_teachers_ical' ) ) {
    function k2t_teachers_ical() {
        if(isset($_GET['ical_id'])&& $_GET['ical_id']>0){
            // - start collecting output -
            ob_start();

            // - file header -
            header('Content-type: text/calendar');
            header('Content-Disposition: attachment; filename="uni ical.ics"');
            global $post;
            // - content header -
            ?>
            <?php
            $content = "BEGIN:VCALENDAR\r\n";
            $content .= "VERSION:2.0\r\n";
            $content .= 'PRODID:-//'.get_bloginfo( 'name' )."\r\n";
            $content .= "CALSCALE:GREGORIAN\r\n";
            $content .= "METHOD:PUBLISH\r\n";
            $content .= 'X-WR-CALNAME:'.get_bloginfo( 'name' )."\r\n";
            $content .= 'X-ORIGINAL-URL:'.get_permalink( $_GET['ical_id'] )."\r\n";
            $content .= 'X-WR-CALDESC:'.get_the_title( $_GET['ical_id'] )."\r\n";
            ?>
            <?php

            $date_format 		= get_option( 'date_format' );
            $hour_format 		= get_option( 'time_format' );
            $startdate 			= get_field( $_GET['ical_id'], 'teacher_start_date' );
            if ( $startdate ) {
                $startdate = gmdate( "Ymd\THis", $startdate );// convert date ux
            }
            $enddate 			= get_field( $_GET['ical_id'], 'teacher_end_date' );
            if( $enddate ){
                $enddate = gmdate( "Ymd\THis", $enddate );
            }

            //// - grab gmt for start -
            $gmts = get_gmt_from_date( $startdate ); // this function requires Y-m-d H:i:s, hence the back & forth.
            $gmts = strtotime($gmts);

            // - grab gmt for end -
            $gmte = get_gmt_from_date( $enddate ); // this function requires Y-m-d H:i:s, hence the back & forth.
            $gmte = strtotime( $gmte );

            // - Set to UTC ICAL FORMAT -
            $stime = date( 'Ymd\THis', $gmts );
            $etime = date( 'Ymd\THis', $gmte );

            // - item output -
            ?>
            <?php
            $content .= "BEGIN:VEVENT\r\n";
            $content .= 'DTSTART:'.$startdate."\r\n";
            $content .= 'DTEND:'.$enddate."\r\n";
            $content .= 'SUMMARY:'.get_the_title( $_GET['ical_id'] )."\r\n";
            $content .= 'DESCRIPTION:'.get_post( $_GET['ical_id'] )->post_excerpt."\r\n";
            $content .= 'LOCATION:'.get_field( $_GET['ical_id'],'teacher_address' )."\r\n";
            $content .= "END:VEVENT\r\n";
            $content .= "END:VCALENDAR\r\n";
            // - full output -
            $tfteachersical = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }
    }
    add_action('init','k2t_teachers_ical');
}

/**
 * Load teacher ajax with calendar
 */
if ( ! function_exists( 'k2t_calendar_data_json' ) ) {
    function k2t_calendar_data_json() {
        if( isset( $_GET['cal_json'] ) && $_GET['cal_json']==1 ) {
            $post_type 					= 'post-k-teacher';
            $UTCConverGet 				= $_GET['nTimeOffsetToUTC'];
            $cat 						= $_GET['cat'];
            $style 						= $_GET['style'];
            $args 						= array(
                'post_type' 					=> $post_type,
                'posts_per_page' 				=> -1,
                'post_status' 					=> 'publish',
                'ignore_sticky_posts' 			=> 1,
            );

            if( ! is_array( $cat ) && $cat != '' ) {
                $cats 				= explode(",",$cat);
                if( is_numeric( $cats[0] ) ) {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'k-teacher-category',
                            'field'    => 'id',
                            'terms'    => $cats,
                            'operator' => 'IN',
                        )
                    );
                } else {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'k-teacher-category',
                            'field'    => 'slug',
                            'terms'    => $cats,
                            'operator' => 'IN',
                        )
                    );
                }
            } elseif ( count( $cat ) > 0 && $cat != '' ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'k-teacher-category',
                        'field'    => 'id',
                        'terms'    => $cat,
                        'operator' => 'IN',
                    )
                );
            }

            $the_query 				= new WP_Query( $args );
            $data_rs 				= $rs = array();
            $success 				= 1;
            if( $the_query->have_posts() ) {
                $date_format 		= get_option('date_format');
                $hour_format 		= get_option('time_format');
                while( $the_query->have_posts() ){
                    $the_query->the_post();

                    // Get metadata of teacher in single
                    $single_pre 			= 'teacher_';
                    $arr_teacher_meta_val  	= array();
                    $arr_teacher_meta 		= array(
                        // Infomation
                        'start_date'					=> '',
                        'end_date'						=> '',
                        'color'							=> '',
                    );

                    foreach ( $arr_teacher_meta as $meta => $val ) {
                        if ( function_exists( 'get_field' ) ) {
                            if ( get_field( $single_pre . $meta, $id ) ) {
                                $arr_teacher_meta_val[$meta] = get_field( $single_pre . $meta, $id );
                            }
                        }
                    }
                    extract( shortcode_atts( $arr_teacher_meta, $arr_teacher_meta_val ) );

                    $color_teacher = get_post_meta(get_the_ID(),'color_teacher', true );
                    $ar_rs = array(
                        'style'					=> $style,
                        'id' 					=> get_the_ID(),
                        'title' 				=> get_the_title(),
                        'posttype' 				=> $post_type,
                        'url' 					=> get_permalink(),
                        'class' 				=> $color,
                        'start'					=> strtotime( $start_date ) * 1000 + ( $UTCConverGet*60*60*1000 ),
                        'end'					=> strtotime( $start_date ) * 1000 + ( $UTCConverGet*60*60*1000 ),
                        'startDate'				=> date_i18n( get_option('date_format'), strtotime($start_date)),
                        'endDate'				=> date_i18n( get_option('date_format'), strtotime($end_date)),
                    );
                    $rs[] = $ar_rs;
                }
            }
            $data_rs = array(
                'success' 		=> $success,
                'result' 		=> $rs,
            );
            echo str_replace('\/', '/', json_encode($data_rs));
            exit;
        }

    }
    add_action( 'wp_ajax_k2t_calendar_data', 'k2t_calendar_data_json' );
    add_action( 'wp_ajax_nopriv_k2t_calendar_data', 'k2t_calendar_data_json' );
}

/* Include functions */
require_once( dirname(__FILE__) . '/inc/acf-content.php' ); // Add metadata of teacher
require_once( dirname(__FILE__) . '/inc/fn.misc.php' ); // Main function of plugin
require_once( dirname(__FILE__) . '/inc/registrations.php' ); // Section for registrations
require_once( dirname(__FILE__) . '/inc/shortcodes/teacher-listing.php' ); // K Teacher shortcodes
require_once( dirname(__FILE__) . '/inc/shortcodes/teacher-filter-bar.php' );






