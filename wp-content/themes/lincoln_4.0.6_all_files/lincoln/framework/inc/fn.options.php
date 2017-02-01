<?php
/**
 * SMOF Interface
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */

add_action( 'admin_init', 'optionsframework_admin_init' );
add_action( 'admin_menu', 'optionsframework_add_admin' );

/**
 * Admin Init
 *
 * @uses wp_verify_nonce()
 * @uses header()
 *
 * @since 1.0.0
 */
function optionsframework_admin_init() {
	// Rev up the Options Machine
	$init_option = get_option( 'init_option', true );

	if ( ( isset( $_GET['page'] ) && ( $_GET['page'] == 'optionsframework' ) ) || $init_option ) :
		global $of_options, $options_machine, $smof_data, $smof_details;
		update_option( 'init_option', false, true);

		if ( empty( $options_machine ) ){
			$_of_options = $of_options;
			$of_options = array();
			foreach($_of_options as &$option){
				if( !empty($option['id']) )
					$of_options[$option['id']] = $option;
				else{
					$of_options[] = $option;
				}
			}
			unset($_of_options);
			$options_machine = new Options_Machine( $of_options );
		}

		do_action( 'optionsframework_admin_init_before', array(
				'of_options'  => $of_options,
				'options_machine' => $options_machine,
				'smof_data'   => $smof_data
			) );

		if ( empty( $smof_data['smof_init'] ) ) { // Let's set the values if the theme's already been active
			of_save_options( $options_machine->Defaults );
			of_save_options( date( 'r' ), 'smof_init' );
			$smof_data = of_get_options();
			$options_machine = new Options_Machine( $of_options );
		}

		do_action( 'optionsframework_admin_init_after', array(
				'of_options'  => $of_options,
				'options_machine' => $options_machine,
				'smof_data'   => $smof_data
			) );
	endif;
}

/**
 * Create Options page
 *
 * @uses add_theme_page()
 * @uses add_action()
 *
 * @since 1.0.0
 */
function optionsframework_add_admin() {

	$of_page = add_theme_page( THEMENAME, 'Theme Options', 'edit_theme_options', 'optionsframework', 'optionsframework_options_page' );

	// Add framework functionaily to the head individually
	add_action( "admin_print_scripts-$of_page", 'of_load_only' );
	add_action( "admin_print_styles-$of_page", 'of_style_only' );
	
}

/**
 * Build Options page
 *
 * @since 1.0.0
 */
function optionsframework_options_page() {

	global $options_machine;

	include_once K2T_FRAMEWORK_PATH . 'theme-options/admin_options_page.php';

}
 
/**
 * Head Hook
 *
 * @since 1.0.0
 */
function of_head() { do_action( 'of_head' ); }

/**
 * Add default options upon activation else DB does not exist
 *
 * DEPRECATED, Class_options_machine now does this on load to ensure all values are set
 *
 * @since 1.0.0
 */
function of_option_setup() {
	global $of_options, $options_machine;
	$options_machine = new Options_Machine( $of_options );
		
	if ( ! of_get_options() ) {
		of_save_options( $options_machine->Defaults );
	}
}

/**
 * Get header classes
 *
 * @since 1.0.0
 */
function of_get_header_classes_array() {
	global $of_options;
	
	foreach ( $of_options as $value ) {
		if ( $value['type'] == 'heading' )
			$hooks[] = str_replace(' ', '', strtolower( $value['name'] ) );	
	}
	return $hooks;
}

/**
 * Get options from the database and process them with the load filter hook.
 *
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @return array
 */
function of_get_options( $key = null, $data = null ) {
	global $smof_data;

	do_action( 'of_get_options_before', array(
		'key'  => $key,
		'data' => $data
	));
	if ( $key != null ) {
		// Get one specific value
		$data = get_theme_mod( $key, $data );
	} else {
		// Get all values
		$data = get_theme_mods();	
	}
	$data = apply_filters( 'of_options_after_load', $data );
	if ( $key == null ) {
		$smof_data = $data;
	} else {
		$smof_data[$key] = $data;
	}
	do_action( 'of_option_setup_before', array(
		'key'  => $key,
		'data' => $data
	));
	return $data;
}

/**
 * Save options to the database after processing them
 *
 * @param $data Options array to save
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @uses update_option()
 * @return void
 */
function of_save_options( $data, $key = null ) {
	global $smof_data;
    if ( empty( $data ) )
        return;

    do_action( 'of_save_options_before', array(
		'key'  => $key,
		'data' => $data
	));
	$data = apply_filters( 'of_options_before_save', $data );
	if ( $key != null ) {
		// Update one specific value
		if ( $key == BACKUPS ) {
			unset( $data['smof_init'] ); // Don't want to change this.
		}
		set_theme_mod( $key, $data );
	} else { // Update all values in $data
		foreach ( $data as $k=>$v ) {
			if ( empty( $smof_data[$k] ) || $smof_data[$k] != $v ) {
				// Only write to the DB when we need to
				set_theme_mod( $k, $v );
			} else if ( is_array( $v ) ) {
				foreach ( $v as $key=>$val ) {
					if ( $key != $k && $v[$key] == $val ) {
						set_theme_mod( $k, $v );
						break;
					}
				}
			}
	  	}
	}
    do_action( 'of_save_options_after', array(
		'key'  => $key,
		'data' => $data
	));
}

/**
 * Create Options page
 *
 * @uses wp_enqueue_style()
 *
 * @since 1.0.0
 */
function of_style_only() {
	wp_enqueue_style( 'admin-style', K2T_FRAMEWORK_URL . 'assets/css/admin-style.css' );
	wp_enqueue_style( 'jquery-ui-custom-admin', K2T_FRAMEWORK_URL .'assets/css/jquery-ui-custom.css' );

	if ( ! wp_style_is( 'wp-color-picker', 'registered' ) ) {
		wp_register_style( 'wp-color-picker', K2T_FRAMEWORK_URL . 'assets/css/color-picker.min.css' );
	}
	wp_enqueue_style( 'wp-color-picker' );
	do_action( 'of_style_only_after' );
}

/**
 * Create Options page
 *
 * @uses add_action()
 * @uses wp_enqueue_script()
 *
 * @since 1.0.0
 */
function of_load_only() {
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-slider' );
	wp_enqueue_script( 'jquery-input-mask', K2T_FRAMEWORK_URL .'assets/js/jquery.maskedinput-1.2.2.js', array(), '', true );
	
	wp_enqueue_script( 'swfobject2', K2T_FRAMEWORK_URL . 'assets/js/opensave.js',  array(), '', true );
	// Enqueue jquery isotope
	wp_enqueue_script( 'jquery-isotope', K2T_THEME_URL . '/assets/js/vendor/isotope.pkgd.min.js', array(), '', true );
	wp_enqueue_script( 'jquery-ace-grid', K2T_FRAMEWORK_URL . 'assets/js/editor/vendor/ace.js', array('jquery'), '', false );

	wp_enqueue_script( 'tipsy', K2T_FRAMEWORK_URL .'assets/js/jquery.tipsy.js', array(), '', true );
	wp_enqueue_script( 'cookie', K2T_FRAMEWORK_URL . 'assets/js/cookie.js', array(), '', true );
	wp_enqueue_script( 'smof', K2T_FRAMEWORK_URL .'assets/js/smof.js', array(), '', true );

	wp_enqueue_script( 'k2t_admin_javascript' ); // themelead scripts

	// Enqueue colorpicker scripts for versions below 3.5 for compatibility
	if ( ! wp_script_is( 'wp-color-picker', 'registered' ) ) {
		wp_register_script( 'iris', K2T_FRAMEWORK_URL .'assets/js/iris.min.js', array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
		wp_register_script( 'wp-color-picker', K2T_FRAMEWORK_URL .'assets/js/color-picker.min.js', array( 'jquery', 'iris' ) );
	}
	wp_enqueue_script( 'wp-color-picker' );


	/**
	 * Enqueue scripts for file uploader
	 */
	if ( function_exists( 'wp_enqueue_media' ) )
		wp_enqueue_media();

	do_action( 'of_load_only_after' );

}


/**
 * Ajax Save Options
 *
 * @uses get_option()
 *
 * @since 1.0.0
 */
function of_ajax_callback() {
	global $options_machine, $of_options;

	$nonce = $_POST['security'];

	if ( ! wp_verify_nonce( $nonce, 'of_ajax_nonce' ) ) die( '-1' );

	//get options array from db
	$all = of_get_options();

	$save_type = $_POST['type'];

	//Uploads
	if ( $save_type == 'upload' ) {

		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
		$filename['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] );

		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';
		$uploaded_file = wp_handle_upload( $filename, $override );

		$upload_tracking[] = $clickedID;

		//update $options array w/ image URL
		$upload_image = $all; //preserve current data

		$upload_image[$clickedID] = $uploaded_file['url'];

		of_save_options( $upload_image );


		if ( !empty( $uploaded_file['error'] ) ) {echo 'Upload Error: ' . $uploaded_file['error']; }
		else { echo esc_url( $uploaded_file['url'] ); } // Is the Response

	}
	elseif ( $save_type == 'image_reset' ) {

		$id = $_POST['data']; // Acts as the name

		$delete_image = $all; //preserve rest of data
		$delete_image[$id] = ''; //update array key with empty value
		of_save_options( $delete_image ) ;

	}
	elseif ( $save_type == 'backup_options' ) {

		$backup = $all;
		$backup['backup_log'] = date( 'r' );

		of_save_options( $backup, BACKUPS ) ;

		die( '1' );
	}
	elseif ( $save_type == 'restore_options' ) {

		$smof_data = of_get_options( BACKUPS );

		of_save_options( $smof_data );

		die( '1' );
	}
	elseif ( $save_type == 'import_options' ) {

		//$smof_data = unserialize( ( $_POST['data'] ) ); //100% safe - ignore theme check nag
		$wp_upload_dir = wp_upload_dir();
		$versionsUrl =  'http://host.lunartheme.com/lincoln_data';
		$options = $versionsUrl.'/options.txt';
		$file_headers = @get_headers($options);
		
		if($file_headers[0] == 'HTTP/1.1 200 OK') {
			$tmpZip = $wp_upload_dir["basedir"] . '/lincoln_data/options.txt';
			file_put_contents($tmpZip, file_get_contents($options));
			$data = unserialize(base64_decode(file_get_contents($tmpZip)));
			of_save_options($data);	
			die( '1' );						
		} else {
			die( '-1' );
		}

	}
	elseif ( $save_type == 'import_options_widgets' ) {
 
		$wp_upload_dir = wp_upload_dir();
		$versionsUrl = 'http://host.lunartheme.com/lincoln_data';
		$widgets_json = $versionsUrl.'/widget.txt';
		$file_headers = @get_headers($widgets_json);
	
		if($file_headers[0] == 'HTTP/1.1 200 OK') {
			$tmpZip = $wp_upload_dir["basedir"] . '/lincoln_data/widget.txt';
			file_put_contents($tmpZip, file_get_contents($widgets_json));
			$data = unserialize( base64_decode(file_get_contents($tmpZip)) );
			foreach($data as $key=>$value){
				k2t_options($key,(array)$value);
			}
			die( '1' );	
		}else {
			die( '-1' );
		}

 	}
	elseif ( $save_type == 'save' ) {

		wp_parse_str( stripslashes( $_POST['data'] ), $smof_data );
		unset( $smof_data['security'] );
		unset( $smof_data['of_save'] );
		of_save_options( $smof_data );

		die( '1' );
	}
	elseif ( $save_type == 'reset' ) {
		of_save_options( $options_machine->Defaults );

		die( '1' ); //options reset
	}

	die();
}

/*--------------------------------------------------------------
	Refine Get Options Of WP
--------------------------------------------------------------*/

function k2t_options( $option_name, $option_value = '' ){
	if( get_option( $option_name) != "" && get_option( $option_name ) != $option_value ) {
		update_option( $option_name,$option_value );
	} else{
		add_option( $option_name,$option_value );
	}
}

/**
 * For use in themes
 *
 * @since forever
 */
$data = of_get_options();
if ( empty( $smof_details ) )
	$smof_details = array();