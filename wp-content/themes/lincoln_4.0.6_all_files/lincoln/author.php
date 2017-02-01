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
$query = get_queried_object();
$crr_user =  wp_get_current_user();
if ( $query->user_login == $crr_user->user_login ) :
	$classes[] = 'author-admin';
endif;
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

	<?php if ( $query->user_login == $crr_user->user_login ) : ?>
	<div class="k2t-content user-page right-sidebar" >

		<div class="container k2t-wrap">

			<!-- Main -->
			<main class="k2t-main page " role="main">
				<div class="user-info">
					<?php 
					$user_meta = get_user_meta( $crr_user->ID );
					//var_dump($user_meta);
					$contact = k2t_social_array();
					$contact['custom_email'] = 'custom_email';
					$contact['k2t-youtube'] = 'k2t-youtube';

					echo '<div class="user-info-left k2t-element-hover">';
						echo get_avatar( $crr_user->ID, 270 );
						echo '<div class="contact">';
							foreach( $contact as $k => $v ) :
								$social = $k;
								if ( $k == 'custom_email') $social = 'email';
								if ( $k == 'k2t-youtube') $social = 'youtube';
								if ( isset( $user_meta[$k . '-text'][0] ) && ! empty( $user_meta[$k . '-text'][0] ) )  
									$text = $user_meta[$k . '-text'][0];
								else 
									$text = $k;
								if ( isset( $user_meta[$k][0] )  && !empty( $user_meta[$k][0] ) ) :
									echo '<p class="' .$k . '">  <a href="' . $user_meta[$k][0] . '"> <span class="user-social"> <i class="fa fa-' . $social . '"></i> </span>' . $text . ' </a>';
								endif;
							endforeach;
						echo '</div>';
					echo '</div>';
					echo '<div class="user-info-right">';
						echo '<p class="profile"><i class="zmdi zmdi-account"></i><span class="s-title">' . esc_html__( 'Profile', '' ) . '</span>';
						if ( isset( $user_meta['description'][0] ) && !empty( $user_meta['description'][0] ) )
							echo '<span class="p-content">' . $user_meta['description'][0] . "</span></p>";
						echo '<p class="user-location"><i class="zmdi zmdi-layers"></i><span class="s-title">' . esc_html__( 'Location', '' ) . '</span>';
						if ( isset( $user_meta['user-location'][0] ) && !empty( $user_meta['user-location'][0] ) )
							echo '<span class="u-location">' . $user_meta['user-location'][0] . "</span></p>";
					echo '</div>';
					?>
				</div>
				<div class="user-content">
					<?php
					if ( is_plugin_active( 'sfwd-lms/sfwd_lms.php') ) :
						echo '<h3><span class="ldr-title">' . esc_html__( 'Registered Courses', 'k2t' ) . ' </span></h3>';
						echo do_shortcode('[ld_profile]');
					endif;
					?>
				</div>
			</main>
			<!-- Sidebar -->
			<?php
				if ( is_plugin_active( 'sfwd-lms/sfwd_lms.php') ) :
					echo '<div class="k2t-sidebar learndash_sidebar">';
						dynamic_sidebar( 'learndash_sidebar' );
					echo '</div>';
				else :
					get_sidebar();
				endif;
			?>
		</div>
	</div><!-- .k2t-content -->
	<?php else: ?>
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
											'author'    => $query->ID,
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
											'author'    => $query->ID,
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
											'author'    => $query->ID,
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
	<?php endif;?>
<?php get_footer(); ?>
