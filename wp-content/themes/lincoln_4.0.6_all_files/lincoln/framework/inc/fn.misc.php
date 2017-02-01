<?php
/**
 * Misc functions for theme.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

$upload_dir = wp_upload_dir();
if ( ! is_dir( $upload_dir["basedir"]. '/lincoln_data' ) ) {
    //mkdir - tells that need to create a directory
    wp_mkdir_p( $upload_dir["basedir"]. '/lincoln_data' );
}

