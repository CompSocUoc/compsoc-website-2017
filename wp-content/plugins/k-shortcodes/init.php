<?php
/*
Plugin Name: K Shortcodes
Plugin URI: http://lunartheme.com
Description: This is the plugin for setting up shortcodes for Lincoln theme
Version: 4.0.6
Author: LunarTheme
Author URI: http://lunartheme.com
Text Domain: k2t
*/

/*  [ Require Files. ]
- - - - - - - - - - - - - - - - - - - */
require_once( dirname( __FILE__ ) . '/functions.php' ); // Misc functions
require_once( dirname( __FILE__ ) . '/mce/mce.php' ); // Add mce buttons to post editor

/* ------------------------------------------------------- */
/* Return list shortcode name
/* ------------------------------------------------------- */

add_action( 'plugins_loaded','k_shortcode_textdomain_plugin' );

function k_shortcode_textdomain_plugin(){
	load_plugin_textdomain( 'k2t', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

if ( ! function_exists( 'k2t_return_list_shortcode' ) ) {
	function k2t_return_list_shortcode() {
		$shortcodes = 'animation, google_map, heading, dropcap, button, pre, pullquote, sub, sup, tooltip, br, clear, spacer, countdown, iconlist, fullwidth, imagebox, box, iconbox, hr, highlight, k2t_embed, k2t_slider, member, pricing, progress, toggle, accordion, tab, container, content_slider, awesome_slider, icon, brands, testimonial, circle_button, align, res_text_element, section, blockquote, blog_post, register, k2t_grid_slider';
		return $shortcodes;
	}
	
	/* ------------------------------------------------------- */
	/* Remove automatics - wpautop
	/* ------------------------------------------------------- */
	add_filter( 'the_content', 'k2t_pre_process_shortcode', 7 );
}

if ( ! function_exists( 'k2t_pre_process_shortcode' ) ) {
	function k2t_pre_process_shortcode( $content ) {
		$shortcodes = k2t_return_list_shortcode();
		$shortcodes = explode( ",", $shortcodes );
		$shortcodes = array_map( "trim", $shortcodes );

		global $shortcode_tags;

		// Backup current registered shortcodes and clear them all out
		$orig_shortcode_tags = $shortcode_tags;
		$shortcode_tags = array( );

		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( $shortcode, 'k2t_' . $shortcode . '_shortcode' );
		}
		// Do the shortcode (only the one above is registered)
		$content = do_shortcode( $content );

		// Put the original shortcodes back
		$shortcode_tags = $orig_shortcode_tags;

		return $content;
	}
	
	// Allow Shortcodes in Widgets
	add_filter( 'widget_text', 'k2t_pre_process_shortcode', 7 );
}

/* ------------------------------------------------------- */
/* Include Shortcode File - Add shortcodes to everywhere use*
/* ------------------------------------------------------- */
$shortcodes = k2t_return_list_shortcode();
$shortcodes = explode( ",", $shortcodes );
$shortcodes = array_map( "trim", $shortcodes );

foreach ( $shortcodes as $short_code ) {
	if( file_exists($k2t_shortcode_file = dirname( __FILE__ ) . '/shortcodes/' . $short_code . '.php') ){
		require_once $k2t_shortcode_file; //Include google map shortcode
		add_shortcode( $short_code, 'k2t_' . $short_code . '_shortcode' );
	}
}

/*-------------------------------------------------------------------
	Add param k2t icon.
--------------------------------------------------------------------*/
if ( class_exists( 'Vc_Manager' ) && ! function_exists( 'k2t_iconfont_settings_field' ) ) :
	function k2t_iconfont_settings_field( $settings, $value ) {
		$display = 'display:none;';
		$output  = '';
		if ( isset( $value ) && esc_attr( $value ) != "" ) {
			$display = 'display:block;';
			$output = '
				<div>
					<span class="edit-menu-icon-preview-' . esc_attr( $settings['param_name'] ) . '" rel-icon="icont_font_' . esc_attr( $settings['param_name'] ) . '" style="width:30px;height:30px;float:left;line-height:28px;font-size:22px;'. $display .';"><i class="' . esc_attr( $value ) . '"></i></span>
							'
						.'<input id="icont_font_' . esc_attr( $settings['param_name'] ) . '" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
						esc_attr( $settings['param_name'] ) . ' ' .
						esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" style = "width:283px" />' .
						'
					<a href="#" class="button" title="Add Icon" for="icont_font_' . esc_attr( $settings['param_name'] ) . '" id="k2ticon-generator-button-' . esc_attr( $settings['param_name'] ) . '">
						<span class="awesome-plus"></span>
					</a>
					<a href="#" class="button k2ticon-remove-button k2ticon-remove-button-' . esc_attr( $settings['param_name'] ) . '" title="Remove Icon" remove-for="icont_font_' . esc_attr( $settings['param_name'] ) . '" id="k2ticon-remove-button-' . esc_attr( $settings['param_name'] ) . '">
						<span class="awesome-minus"></span>
					</a>
				</div>
			';
		} else {

			$output = '
				<div>
					<span class="edit-menu-icon-preview-' . esc_attr( $settings['param_name'] ) . '" rel-icon="icont_font_' . esc_attr( $settings['param_name'] ) . '" style="width:30px;height:30px;float:left;line-height:28px;font-size:22px;display:none;"></span>
							'
						.'<input id="icont_font_' . esc_attr( $settings['param_name'] ) . '" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
						esc_attr( $settings['param_name'] ) . ' ' .
						esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" style = "width:352px" />' .
						'
					<a href="#" class="button" title="Add Icon" for="icont_font_' . esc_attr( $settings['param_name'] ) . '" id="k2ticon-generator-button-' . esc_attr( $settings['param_name'] ) . '">
						<span class="awesome-plus"></span>
					</a>
					<a href="#" class="button k2ticon-remove-button k2ticon-remove-button-' . esc_attr( $settings['param_name'] ) . '" title="Remove Icon" remove-for="icont_font_' . esc_attr( $settings['param_name'] ) . '" id="k2ticon-remove-button-' . esc_attr( $settings['param_name'] ) . '" style="display:none;">
						<span class="awesome-minus"></span>
					</a>
				</div>
			';
		}

		$output .='<scr' . 'ipt>
			// Trigger for select icon
			jQuery("#k2ticon-generator-button-' . esc_attr( $settings['param_name'] ) . '").on("click",function(){
				jQuery( "#k2ticon-generator-wrap, #k2ticon-generator-overlay" ).show();
				jQuery( "#k2ticon-generator-wrap, #k2ticon-generator-overlay" ).attr( "for",jQuery( this ).attr( "for" ) );
			});
			jQuery("#icont_font_' . esc_attr( $settings['param_name'] ) . '").on("change",function(){
				jQuery( "[rel-icon=\"" + jQuery(this).attr("id") + "\"]").html("<i class=\"" + jQuery(this).val() + "\"></i>");
			});

			// Remove Icon
			jQuery(".k2ticon-remove-button-' . esc_attr( $settings['param_name'] ) . '").on("click",function(){
				current_id = jQuery(this).attr("remove-for");
				jQuery("#" + current_id ).val("");
				jQuery("#" + current_id ).trigger("change");
				jQuery(this).css("display","none");
				jQuery("[rel-icon=\"" + current_id + "\"]").css("display","none");
				jQuery("#" + current_id ).css("width","352px");
				return false;
			});

		</scr' . 'ipt>'; // This is html markup that will be outputted in content elements edit form
		return $output;
	}
	add_shortcode_param( 'k2t_icon', 'k2t_iconfont_settings_field' );
endif;

/*-------------------------------------------------------------------
 * Enqueue Script and Css.
-------------------------------------------------------------------*/

if ( ! function_exists ( 'k2t_shortcodes_fontend_scripts' ) ) :
	function k2t_shortcodes_fontend_scripts() {

		global $smof_data;

		if( isset( $smof_data['key_map'] ) && $smof_data['key_map'] != '' ){
			$str = '//maps.googleapis.com/maps/api/js?key='.$smof_data['key_map'];
		}
		else
			$str = '//maps.google.com/maps/api/js?v=3.exp';

		if ( ! is_admin() ) {

			// Enqueue Script
			wp_enqueue_script( 'k2t-google-map', $str, array('jquery'), '', false );
			wp_register_script( 'k2t-slider', plugin_dir_url( __FILE__ ) . 'assets/js/k2t-slider.js', array(), '', true );
			//countdown
			wp_register_script( 'k-lodash', plugin_dir_url( __FILE__ ) . 'assets/js/lodash.min.js', array(), '', true );
			wp_register_script( 'k-countdown', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.countdown.min.js', array(), '', true );
			wp_register_script( 'k-event', plugin_dir_url( __FILE__ ) . 'assets/js/event.js', array(), '', true );

			wp_register_script( 'jquery-flexslider', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.flexslider-min.js', array( 'jquery' ), '2.1', true );
			wp_register_script( 'k2t-tooltipster', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.tooltipster.min.js', array( 'jquery' ), '3.2.6', true );
			wp_register_script( 'k2t-easy-pie-chart', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.easy-pie-chart.js', array( 'jquery' ), '1.6.3', true );
			wp_register_script( 'k2t-collapse', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.collapse.js', array( 'jquery' ), '1.0', true );
			wp_register_script( 'k2t-tabslet', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.tabslet.min.js', array( 'jquery' ), '1.4.2', true );
			wp_register_script( 'k2t-countTo', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.countTo.js', array( 'jquery' ), '1.0', true );
			wp_register_script( 'k2t-stickyMojo', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/stickyMojo.js', array( 'jquery' ), '1.0', true );
			wp_register_script( 'k2t-fittext', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.fittext.js', array( 'jquery' ), '1.2', true);
			wp_register_script( 'k2t-parallax', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.parallax.min.js', array(), '', true);
			wp_register_script( 'k2t-tipsy', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.tipsy.min.js', array(), '', true);
			wp_register_script( 'k2t-tubular', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.tubular.1.0.js', array(), '', true);
			// wp_register_script( 'k2t-owlcarousel', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/owl.carousel.min.js', array(), '', true);
			wp_register_script( 'k2t-inview', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.inview.min.js', array( 'jquery' ), '1.0', true );
			wp_register_script( 'iview', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/iview.js', array( 'jquery' ), '1.0', true );
			wp_register_script( 'raphael-min', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/raphael-min.js', array( 'jquery' ), '1.0', true );
			wp_register_script( 'jquery-easing', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.easing.1.3.js', array( 'jquery' ), '1.0', true );
			wp_register_script( 'jquery.eislideshow', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.eislideshow.js', array( 'jquery' ), '1.0', true );
			wp_register_script( 'masonry-min', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/masonry.pkgd.min.js', array( 'jquery' ), '1.0', true );
			wp_register_script( 'magnific-popup', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/magnific-popup.js', array( 'jquery' ), '1.0', true );

			wp_register_script( 'k2t-shortcodes', plugin_dir_url( __FILE__ ) . 'assets/js/shortcodes.js', array( 'jquery' ), '1.0', true );
			
			// Enqueue Style
			wp_register_style( 'iview', plugin_dir_url( __FILE__ ) . 'assets/css/vendor/iview.css' );
			wp_register_style( 'custom-flexslider', plugin_dir_url( __FILE__ ) . 'assets/css/vendor/flexslider.css' );
			wp_enqueue_style( 'k2t-animate', plugin_dir_url( __FILE__ ) . 'assets/css/animate.min.css' );
			wp_enqueue_style( 'magnific-popup', plugin_dir_url( __FILE__ ) . 'assets/css/magnific-popup.css' );
			wp_enqueue_style( 'k2t-plugin-shortcodes', plugin_dir_url( __FILE__ ) . 'assets/css/shortcodes.css' ); //Include Shortcode CSS File
			wp_enqueue_style( 'countdown', plugin_dir_url( __FILE__ ) . 'assets/css/flip-countdown.css' );
			wp_enqueue_style( 'k2t-plugin-shortcodes-responsive', plugin_dir_url( __FILE__ ) . 'assets/css/responsive.css' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'k2t_shortcodes_fontend_scripts' );
endif;

/*--------------------------------------------------------------
	Remove Filter
--------------------------------------------------------------*/
remove_filter('the_content', 'wpautop');
