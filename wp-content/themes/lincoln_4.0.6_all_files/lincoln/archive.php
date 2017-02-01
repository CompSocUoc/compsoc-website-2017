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

$classes = array();

// Get blog layout
$blog_layout = $smof_data['blog-layout'];

// Get blog style
$blog_style = $smof_data['blog-style'];

if ( 'right_sidebar' == $blog_layout ) {
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $blog_layout ) {
	$classes[] = 'left-sidebar';
} else {
	$classes[] = 'no-sidebar';
}

if ( is_plugin_active( 'sfwd-lms/sfwd_lms.php') ) :
	$ld_pt = $_GET['ld-pt'];
	$query = get_queried_object();
	$classes[] = 'learndash-archive';
	$classes[] = ( in_array( $ld_pt, array('sfwd-courses', 'sfwd-lessons' )  ) ) ? 'b-grid' : '';
endif;
if ( $blog_style ) {
	$classes[] = 'b-' . $blog_style;
}
// Blog masonry full width
$fullwidth = ( isset ( $smof_data['blog-masonry-full-width'] ) && $smof_data['blog-masonry-full-width'] ) ? ' fullwidth' : '';

get_header(); ?>

	<div class="k2t-content <?php echo esc_attr( implode( ' ', $classes ) ) . $fullwidth ?>">

		<div class="k2t-wrap">

			<main class="k2t-blog" role="main">
				
				<?php
					if ( 'masonry' == $blog_style ) {
						wp_enqueue_script( 'jquery-isotope' );
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
						if ( is_plugin_active( 'sfwd-lms/sfwd_lms.php') && isset( $ld_pt ) && !empty( $ld_pt ) ) :
							switch ( $ld_pt ) {
								case 'sfwd-courses':
									if ( is_tag() ) :
										$tax = 'tag';
									elseif ( is_category() ) :
										$tax = 'cat';
									endif;
									$args = array(
										'post_type' => 'sfwd-courses',
										$tax 	=> $query->slug,
										'posts_per_page' => '-1',
										);
									$courses = new WP_query( $args );
									echo '<div class="grid-layout column-2 clearfix">';
									while ( $courses->have_posts() ) : $courses->the_post();
										include K2T_TEMPLATE_PATH . 'blog/content-grid.php';
									endwhile;
									echo '</div>';
									break;
								case 'sfwd-quiz':
									$args = array(
										'post_type' => 'sfwd-quiz',
										'tag' 	=> $query->slug,
										);
									$quiz = new WP_query( $args );
									echo '<ul class="quiz_list">';
									while ( $quiz->have_posts() ) : $quiz->the_post();
										echo '<li>';
											echo '<h4><a href="' . get_permalink() . '">';
												the_title();
											echo '</a></h4>';
										echo '</li>';
									endwhile;
									echo '</ul>';
									break;
								case 'sfwd-lessons':
									if ( is_tag() ) :
										$tax = 'tag';
									elseif ( is_category() ) :
										$tax = 'cat';
									endif;
									$args = array(
										'post_type' => 'sfwd-lessons',
										$tax 	=> $query->slug,
										'posts_per_page' => '-1',
										);
									$lessons = new WP_query( $args );
									echo '<div class="grid-layout column-2 clearfix">';
									while ( $lessons->have_posts() ) : $lessons->the_post();
										include K2T_TEMPLATE_PATH . 'blog/content-grid.php';
									endwhile;
									echo '</div>';
									break;
								default:
									# code...
									break;
							}
						else :
							get_template_part( 'content', 'none' );
						endif;
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
