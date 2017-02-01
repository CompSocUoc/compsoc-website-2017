<?php
/**
 * This file contains the code that displays the course list.
 * 
 * @since 2.1.0
 * 
 * @package LearnDash\Course
 */
?>
<div class="ld-grid-item">
	<div class="ld-inner-item k2t-element-hover">
		<div class="ld-entry-content entry-content">
			<?php the_post_thumbnail(); ?>
			<div class="ld-entry-item">
				<?php the_title( '<h2 class="ld-entry-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ); ?>
				<?php global $more; $more = 0; ?>
				<?php the_content( __( 'Read more.', 'learndash' ) ); ?>
			</div>
		</div>
	</div>
</div>