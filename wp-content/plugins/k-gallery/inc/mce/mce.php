<?php
/**
 * This file has all the main portfolio shortcode functions
 */
if ( !function_exists('k2t_refresh_mce') ){
	function k2t_refresh_mce($ver) {
	  $ver += 3;
	  return $ver;
	}
}
// init process for button control
add_filter( 'tiny_mce_version', 'k2t_refresh_mce');

add_action('init', 'k2t_pre_gallery_button');
if ( !function_exists('k2t_pre_add_gallery_buttons') ) {
	function k2t_pre_gallery_button() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )		return;
	 
	   // Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", "k2t_pre_add_gallery_tinymce_plugin");
			add_filter('mce_buttons', 'k2t_pre_register_gallery_buttons');
		}
	}
}
if ( !function_exists('k2t_pre_register_gallery_buttons') ) {
	function k2t_pre_register_gallery_buttons($buttons) {	
		array_push($buttons,'k2t_pre_gallery_button');
		return $buttons;
	}
}
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
if ( !function_exists('k2t_pre_add_gallery_tinymce_plugin') ) {
	function k2t_pre_add_gallery_tinymce_plugin($plugin_array) {
		$plugin_array['k2t_pre_gallery_button'] = plugin_dir_url( __FILE__ ) . '/js/mce.js';
		return $plugin_array;
	}
}