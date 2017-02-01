<?php
/**
 * The template for displaying featured post.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'k2t-featured-post' ); ?>>
	<div class="k2t-thumb">
		<?php
			$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
			$image     = aq_resize( $thumbnail, 380, 380, true );
			if ( has_post_thumbnail() ) :
				echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
			else :
				echo '<img src="' . get_template_directory_uri() . '/assets/img/placeholder/380x380.png" alt="' . esc_attr( get_the_title() ) . '" />';
			endif;
		?>
		<div class="mask"><a href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a></div>
	</div><!-- .k2t-thumb -->
	<div class="k2t-entry">
		<span class="ribbon"><?php _e( 'Featured', 'k2t' ); ?></span>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<div class="k2t-meta">
			<div class="post-author">
				<?php echo sprintf( __( 'Posted by <span>%s</span>', 'k2t' ), get_the_author_link() );?>
			</div>
			<div class="posted-on">
				<i class="fa fa-clock-o"></i><?php the_time( 'j M Y' ); ?>
			</div>
			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
				<div class="post-comment">
					<a href="<?php comments_link(); ?>"><i class="fa fa-comments"></i><?php comments_number( '0 Comment', '1 Comment', '% Comments' ); ?></a>
				</div>
			<?php endif; ?>
		</div><!-- .k2t-meta -->

		<?php
			$content = get_the_content();
			$trimmed_content = wp_trim_words( $content, 40 );
			echo esc_html($trimmed_content);
		?>

		<div class="other-post">
			<h2><?php _e( 'Other Posts', 'k2t' ); ?></h2>
			<?php
			// Build arguments to query for related posts
			$args = array(
				'category_name'    => 'featured',
				'post__not_in'     => array( $post->ID ),
				'posts_per_page'   => 3,
				'orderby'          => 'rand',
			);
			$related = new WP_Query( $args );
			echo '<ul>';
				while ( $related->have_posts() ) : $related->the_post();
					the_title( sprintf( '<li><i class="fa fa-caret-right"></i><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></li>' );
				endwhile;
				// Reset global query object
				wp_reset_postdata();
			echo '</ul>';
			?>
		</div><!-- .other-post -->
	</div><!-- .k2t-entry -->
</div><!-- .k2t-featured-post -->