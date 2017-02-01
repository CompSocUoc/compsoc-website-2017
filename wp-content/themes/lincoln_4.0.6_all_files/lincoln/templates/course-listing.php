<?php
/**
 * The blog template file.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 * Template Name: Course Listing
 */

// Get theme options
global $smof_data, $blog_style, $wp_query;

// Register variables
$classes 						= array();
$style_attr						= array();
$taxonomy_pre 					= 'course-category-';

// Get metadata of event in single
$arr_page_meta_val  	= array();
$arr_page_meta 		= array( 
	// Layout
	'layout'						=> 'right_sidebar', 
	'custom_sidebar' 				=> '',
	'style'							=> '',
	'number'						=> '',
);

foreach ( $arr_page_meta as $meta => $val ) {
	if ( function_exists( 'get_field' ) ) {
		if ( ! empty( $smof_data[$taxonomy_pre . $meta] ) ) {
			$arr_page_meta_val[$meta] = $smof_data[$taxonomy_pre . $meta];
		}
	}
}
extract( shortcode_atts( $arr_page_meta, $arr_page_meta_val ) );

// Layout of single event
if ( 'right_sidebar' == $layout ) {
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'no_sidebar' == $layout ) {
	$classes[] = 'no-sidebar';
}

$class_pagi = '';
if ($smof_data['course-pagination-type'] == 'pagination_lite') {
	$class_pagi = 'pagination_lite';
}
// Get post format
get_header(); ?>

	<div class="k2t-content <?php echo esc_attr( implode( ' ', $classes ) ) ?> <?php echo esc_attr($class_pagi);?>">

		<div class="k2t-wrap">

			<main class="k2t-main page" role="main">
				<?php 	
					switch ( $style ) {
						case 'style-2':
							echo K_Course::K_Render_course_listing_masonry( $category_course_id, $number, 'columns-3', 'hide' , 'show' );
							break;
						default:
							echo K_Course::K_Render_course_listing_default( $number , 'show' , $category_course_id );
							break;
					}
				?>
			</main>


			<?php
				if ( 'right_sidebar' == $layout || 'left_sidebar' == $layout ) {
					get_sidebar();
				}
			?>

		</div><!-- .k2t-wrap -->
	</div><!-- .k2t-content -->

	<?php the_content();?>

<?php get_footer(); ?>
