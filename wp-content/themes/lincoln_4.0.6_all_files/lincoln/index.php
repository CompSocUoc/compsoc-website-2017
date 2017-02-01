<?php
/**
 * The main template file.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data;

$classes 				= array();
$pre 					= 'blog-';

// Get metadata of event in single
$arr_event_meta_val  	= array();
$arr_event_meta 		= array( 
	// Layout
	'layout'				=> 'right_sidebar', 
	'style' 				=> 'large',
);

foreach ( $arr_event_meta as $meta => $val ) {
	if ( function_exists( 'get_field' ) ) {
		if ( $smof_data[ $pre . $meta ] ) {
			$arr_event_meta_val[$meta] = $smof_data[ $pre . $meta ];
		}
	}
}
extract( shortcode_atts( $arr_event_meta, $arr_event_meta_val ) );

if ( 'right_sidebar' == $layout ) {
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'two_sidebars' == $layout ) {
	$classes[] = 'two-sidebars';
} else {
	$classes[] = 'no-sidebar';
}
if ($smof_data['pagination-type'] == 'pagination_lite') {
	$classes[] = 'pagination_lite';
}
if ( $style ) {
	$classes[] = 'b-' . $style;
}

// Blog masonry full width
$fullwidth = ( isset ( $smof_data['blog-masonry-full-width'] ) && $smof_data['blog-masonry-full-width'] ) ? ' fullwidth' : '';

get_header(); ?>

	<div class="k2t-content <?php echo esc_attr( implode( ' ', $classes ) ) . $fullwidth ?>">

		<div class="k2t-wrap">

			<?php
				if ( 'two_sidebars' == $layout ) {
					echo '<div class="k2t-btc">';

					if ( 'small' == $style ) {
						$featured = new WP_Query( 'category_name=featured&posts_per_page=1' );

						while ( $featured->have_posts() ) : $featured->the_post();				
							include_once K2T_TEMPLATE_PATH . 'blog/content-featured.php';
						endwhile;

						// Reset global query object
						wp_reset_postdata();
					}

					// Get secondary sidebar for blog 3 columns
					get_sidebar( 'sub' );
				}
			?>
			<main class="k2t-blog" role="main">
				
				<?php

					

					if ( 'masonry' == $style ) {
						wp_enqueue_script( 'jquery-isotope' );
						wp_enqueue_script( 'k2t-masonry' );
						echo '<div class="masonry-layout ' . $smof_data['blog-masonry-column'] . ' ">';
						echo '<div class="grid-sizer"></div>';
					}
					if ( 'grid' == $style ) {
						echo '<div class="grid-layout clearfix ' . $smof_data['blog-grid-column'] . ' ">';
					}
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							
							if ( 'large' == $style ) {
								include K2T_TEMPLATE_PATH . 'blog/content-large.php';
							} elseif ( 'medium' == $style ) {
								include K2T_TEMPLATE_PATH . 'blog/content-medium.php';
							} elseif ( 'grid' == $style ) {
								include K2T_TEMPLATE_PATH . 'blog/content-grid.php';
							} elseif ( 'masonry' == $style ) {
								include K2T_TEMPLATE_PATH . 'blog/content-masonry.php';
							}
						
						endwhile;
					else :
						get_template_part( 'content', 'none' );
					endif;

					if ( 'masonry' == $style ) {
						echo '</div>';
					}
					if ( 'grid' == $style ) {
						echo '</div>';
					}

				

					include_once K2T_TEMPLATE_PATH . 'navigation.php';

				?>

			</main><!-- .k2t-main -->

			<?php
				if ( 'two_sidebars' == $layout ) {
					echo '</div>';
				}
				if ( 'no_sidebar' != $layout ) {
					get_sidebar();
				}
			?>

		</div><!-- .k2t-wrap -->
	</div><!-- .k2t-content -->

<?php get_footer(); ?>
