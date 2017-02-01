<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme option
global $smof_data;

get_header(); ?>

	<section class="k2t-not-found">
		<main class="k2t-wrap" role="main">
						
			<div class="error-404-image">
				<img src="<?php echo esc_url( $smof_data['404-image'] ); ?>" alt="" />
			</div><!--end:error-404-left-->
			
			<div class="error-404-text">
				<h2><?php echo esc_html( $smof_data['404-title'] );?></h2>
				<?php echo esc_html( $smof_data['404-text'] ); ?>
			</div><!--end:error-404-right-->

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="error-404-home btn-ripple k2t-element-hover"><i class="zmdi zmdi-home"></i></a>

		</main><!-- .k2t-wrap -->
	</section><!-- .k2t-not-found -->

<?php get_footer(); ?>
