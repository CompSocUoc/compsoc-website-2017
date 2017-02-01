<?php
/**
 * The template for displaying all single posts.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data;
$classes = array();
// Get single layout
$global_single_layout = $smof_data['single-layout'];
$single_layout        = ( function_exists( 'get_field' ) ) ? get_field( 'post_layout', get_the_ID(), true ) : '';

if ( get_post_type() != 'sfwd-certificates' ) :
	if ( 'right-sidebar' == $single_layout ) {
		$classes[] = 'right-sidebar';
	} elseif ( 'left-sidebar' == $single_layout ) {
		$classes[] = 'left-sidebar';
	} elseif ( 'no-sidebar' == $single_layout ) {
		$classes[] = 'no-sidebar';
	}
	elseif( 'default' == $single_layout || $single_layout == '' ){
		$classes[] = $global_single_layout;
	};
else :
	$classes[] = 'no-sidebar';
endif;
$learndash = array( 'sfwd-lessons', 'sfwd-quiz', 'sfwd-courses', "sfwd-topic", 'sfwd-certificates','sfwd-assignment' );
get_header(); ?>

	<div  class="k2t-content <?php echo implode( ' ', $classes ) ?>">
		<div class="k2t-wrap">
			<main class="k2t-blog" role="main">
				<?php
				
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'single' );

					if ( ( $smof_data['single-commnet-form'] && !in_array( get_post_type() ,$learndash ) ) || ( in_array( get_post_type() ,$learndash ) && $smof_data['ld-comment'] ) ) {
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					}
	
				endwhile;
				?>
			</main><!-- .k2t-blog -->

			<?php
				if ( 'right-sidebar' == $single_layout || 'left-sidebar' == $single_layout || 'right-sidebar' == $global_single_layout || 'left-sidebar' == $global_single_layout ) {
					$learndash = array( 'sfwd-lessons', 'sfwd-quiz', 'sfwd-courses', "sfwd-topic",'sfwd-assignment' );
					if ( in_array(  get_post_type(),  $learndash ) ):
						echo '<div class="k2t-sidebar learndash_sidebar">';
						dynamic_sidebar('learndash_sidebar');
						echo '</div>';
					elseif ( get_post_type() == 'sfwd-certificates' ) :
						//exit
					else :
						get_sidebar();	
					endif;
				}
			?>
		</div><!-- .k2t-wrap -->
	</div><!-- .k2t-content -->

<?php get_footer(); ?>
