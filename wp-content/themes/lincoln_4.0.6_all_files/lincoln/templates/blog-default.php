<?php
/**
 * The blog template file.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 * Template Name: Blog default template
 */

// Get theme options
global $smof_data;

$classes = array();

// Get blog layout
$blog_layout = $smof_data['blog-layout'];

// Get blog style
$blog_style = $smof_data['blog-style'];

if ( 'right_sidebar' == $blog_layout ) {
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $blog_layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'two_sidebars' == $blog_layout ) {
	$classes[] = 'two-sidebars';
} else {
	$classes[] = 'no-sidebar';
}
if ($smof_data['pagination-type'] == 'pagination_lite') {
	$classes[] = 'pagination_lite';
}
if ( $blog_style ) {
	$classes[] = 'b-' . $blog_style;
}

// Blog masonry full width
$fullwidth = ( isset ( $smof_data['blog-masonry-full-width'] ) && $smof_data['blog-masonry-full-width'] ) ? ' fullwidth' : '';

get_header(); ?>

	<div class="k2t-content <?php echo esc_attr( implode( ' ', $classes ) ) . $fullwidth ?>">

		<div class="k2t-wrap">

			<?php
				if ( 'two_sidebars' == $blog_layout ) {
					echo '<div class="k2t-btc">';

					if ( 'small' == $blog_style ) {
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

					

					if ( 'masonry' == $blog_style ) {
						wp_enqueue_script( 'jquery-isotope' );
						wp_enqueue_script( 'k2t-masonry' );
						echo '<div class="masonry-layout ' . $smof_data['blog-masonry-column'] . ' ">';
						echo '<div class="grid-sizer"></div>';
					}
					if ( 'grid' == $blog_style ) {
						echo '<div class="grid-layout clearfix ' . $smof_data['blog-grid-column'] . ' ">';
					}
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							
							if ( 'large' == $blog_style ) {
								include K2T_TEMPLATE_PATH . 'blog/content-large.php';
							} elseif ( 'medium' == $blog_style ) {
								include K2T_TEMPLATE_PATH . 'blog/content-medium.php';
							} elseif ( 'grid' == $blog_style ) {
								include K2T_TEMPLATE_PATH . 'blog/content-grid.php';
							} elseif ( 'masonry' == $blog_style ) {
								include K2T_TEMPLATE_PATH . 'blog/content-masonry.php';
							}
						
						endwhile;
					else :
						get_template_part( 'content', 'none' );
					endif;

					if ( 'masonry' == $blog_style ) {
						echo '</div>';
					}
					if ( 'grid' == $blog_style ) {
						echo '</div>';
					}

				

					include_once K2T_TEMPLATE_PATH . 'navigation.php';

				?>

			</main><!-- .k2t-main -->

			<?php
				if ( 'two_sidebars' == $blog_layout ) {
					echo '</div>';
				}
				if ( 'no_sidebar' != $blog_layout ) {
					get_sidebar();
				}
			?>

		</div><!-- .k2t-wrap -->
	</div><!-- .k2t-content -->

<?php get_footer(); ?>
