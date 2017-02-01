<?php
/**
 * The template for displaying footer version 1.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 * Template Name: Footer Version 1
 */


get_header(); ?>

	<div class="k2t-content no-sidebar">

		<main class="k2t-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
		
	</div><!-- .k2t-content -->

<?php get_footer(); ?>