<?php
/**
 * The blog template file.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 * Template Name: Event Listing Grid
 */

// Get theme options
global $smof_data, $blog_style, $wp_query;

// Register variables
$classes 						= array();
$style_attr						= array();
$taxonomy_pre 					= 'event-category-';

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
if ($smof_data['event-pagination-type'] == 'pagination_lite') {
	$class_pagi = 'pagination_lite';
}
// Get post format
get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<div class="k2t-content <?php echo esc_attr( implode( ' ', $classes ) ) ?> <?php echo esc_attr($class_pagi);?>">

		<div class="k2t-wrap">

			<main class="k2t-main page" role="main">
				<?php 	
					switch ( $style ) {
						case 'style-3':
							echo K_Event::K_Render_event_listing_masonry( 'columns-2', $number, 'show', 'show' );
							break;
						case 'style-5':
							echo K_Event::K_Render_event_listing_carousel( 'columns-2', $number, 'show', 'show' );
							break;
						default:
							echo K_Event::K_Render_event_listing_default( $number, 'show');
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

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
