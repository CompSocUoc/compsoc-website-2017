<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data, $post;

// Get prefix name of custom sidebar
$pre = 'single';
if ( is_singular( 'post-k-event' ) ) {
	$pre = 'event';
} elseif ( is_tax( 'k-event-category' ) ) {
	$pre = 'event-category';
} else if ( is_singular( 'post-k-teacher' ) ) {
	$pre = 'teacher';
} else if ( is_singular( 'post-k-course' ) ) {
	$pre = 'course';
} else if ( is_tax( 'k-course-category' ) ) {
	$pre = 'course-category';
} else if ( is_singular( 'product' ) ) {
	$pre = 'product';
} else if ( is_tax( 'product_cat' ) ) {
	$pre = 'shop';
} else if ( is_page() ){
	$pre = 'page';
} else if ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) {
	$pre = 'blog';
}

// Get custom sidebar
$custom_sidebar = ( function_exists( 'get_field' ) ) ? get_field( $pre . '_custom_sidebar', get_the_ID() ) : '';
if ( ! isset( $custom_sidebar ) || empty( $custom_sidebar ) ) { 
	$custom_sidebar = isset( $smof_data[$pre . '-custom-sidebar'] ) ? $smof_data[$pre . '-custom-sidebar'] : '';
}
if ( ! isset( $custom_sidebar ) || empty( $custom_sidebar ) ) {
	$custom_sidebar = 'primary_sidebar';
}

?>
<div class="k2t-sidebar" role="complementary">
	<?php
		dynamic_sidebar( $custom_sidebar );
	?>
</div><!-- .k2t-sidebar -->