<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="page-entry">
		<div id="ld_courses_listing">
			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'k2t' ),
					'after'  => '</div>',
				) );
			?>
		</div>
	</div><!-- .page-entry -->
	
</article><!-- #post-## -->
