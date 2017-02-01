<?php
/**
 * The template for displaying single post content.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data;

// Get post format
$post_format = get_post_format();
$link        = ( function_exists( 'get_field' ) ) ? get_field( 'link_format_url', get_the_ID() ) : '';

// Display categories
$display_categories = ( function_exists( 'get_field' ) ) ? get_field( 'display_categories', get_the_ID() ) : '';

// Display post time
$display_post_date = ( function_exists( 'get_field' ) ) ? get_field( 'display_post_date', get_the_ID() ) : '';

// Display tags
$display_tags = ( function_exists( 'get_field' ) ) ? get_field( 'display_tags', get_the_ID() ) : '';

// Display author post bio
$display_authorbox = ( function_exists( 'get_field' ) ) ? get_field( 'display_authorbox', get_the_ID() ) : '';

// Display related post
$display_related_post = ( function_exists( 'get_field' ) ) ? get_field( 'display_related_post', get_the_ID() ) : '';
$post_categories = wp_get_post_categories( get_the_ID() );
$learndash = array( 'sfwd-lessons', 'sfwd-quiz', 'sfwd-courses', "sfwd-topic", 'sfwd-certificates','sfwd-assignment' );
?>

<div id="main-col" <?php post_class(); ?>>

	<section class="entry-box k2t-element-hover">
		
		<?php include get_template_directory() . '/templates/blog/post-format.php'; ?>
		<div class="entry-content">
			<?php if( !empty($post_categories) ): ?>
				<?php 
					if ( is_array( $learndash ) && in_array( get_post_type() ,$learndash ) ) :
						$cat_link = add_query_arg( 'ld-pt', get_post_type() , get_category_link($post_categories[0]) );
					endif;
				?>
				<a href="<?php echo esc_url( $cat_link );?>" title="<?php echo get_cat_name($post_categories[0]); ?>" class="cat-icon" style = "background-color : <?php function_exists( 'get_field' ) ? the_field('category_color', 'category_' . $post_categories[0]) : '';?>">
					<?php echo ( function_exists( 'get_field' ) ) ? the_field('category_icon', 'category_' . $post_categories[0]) : '<i class="zmdi zmdi-folder-outline"></i>' ;?>
				</a>
			<?php endif;?>
			<div class="post-entry clearfix">
				<?php the_content(); ?>
			</div><!-- .post-entry -->
			

			<?php if (function_exists( 'k2t_social_share' ) ) {k2t_social_share();}?>
			
			<div class="clearfix">
				<?php if ( ( $smof_data['single-tags'] && !in_array( get_post_type() ,$learndash ) ) || ( in_array( get_post_type() ,$learndash ) && $smof_data['ld-tags'] ) )
					$tags = get_the_tags();
					if( $tags ) {

						echo '<div class="widget_tag_cloud"><div class="tagcloud"><span>' . __('<i class="zmdi zmdi-labels"></i>TAGS:', 'k2t') . '</span>';
						foreach ( $tags as $key => $tag) {
							if ( in_array( get_post_type() ,$learndash ) ) :
								$tag_link = add_query_arg( 'ld-pt',get_post_type(),get_tag_link( $tag->term_id ) );
							endif;
							echo '<a href="'. esc_url( $tag_link ) .'" title="'. esc_attr( $tag->name ) .'">'. esc_attr( $tag->name ) .'</a>';
						}
						echo '</div></div>';
					}	
				?>
				<?php if ( ( $smof_data['single-comments'] && !in_array( get_post_type() ,$learndash ) ) || ( in_array( get_post_type() ,$learndash ) && $smof_data['ld-show-number-comment'] ) ) : ?>
					<span class="entry-comment">
						<i class="zmdi zmdi-comment-alt-text"></i>
						<a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?></a>
					</span>
				<?php endif; ?>
			</div>
		</div>
		
	</section><!--end:entry-box-->

	<?php if( $smof_data['single-related-post'] && ! ( in_array( get_post_type(), $learndash ) ) ) : ?>
		<div class="related-post">
			<h3><?php echo esc_html( $smof_data['single-related-post-title'] );?></h3>
			<div class="related-post-wrap">
				<?php
					wp_enqueue_script('k2t-owlcarousel');
					$related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => $smof_data['single-related-post-number'], 'post__not_in' => array($post->ID) ) );
					if( $related ) foreach( $related as $post ) {
					setup_postdata($post); ?>

			            <div class="post">
			            	<a rel="external" href="<?php echo the_permalink()?>">
			            		<?php 
			            		if ( has_post_thumbnail() ) :
									echo get_the_post_thumbnail( get_the_ID(), 'thumb_500x500' );
								else :
									echo '<img src="' . get_template_directory_uri() . '/assets/img/placeholder/500x500.png" alt="' . get_the_title() . '" />';
								endif;
			            		?>
			            	</a>
				        	<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
			 			</div>
					<?php }
				wp_reset_postdata(); ?>
			</div>
		</div>
	<?php endif; ?>


	<?php if ( '1' == $display_authorbox || 'default' == $display_authorbox && $smof_data['single-authorbox'] || ( in_array( get_post_type() ,$learndash ) && $smof_data['ld-author'] ) ) { ?>
	<article class="about-author k2t-element-hover clearfix">                             
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), '130', '' );?> 
		<h4><?php echo get_the_author_link();?></h4>
		<p class="role">                   
			<?php 
				global $current_user;
			    get_currentuserinfo();
			    $user_roles = $current_user->roles;
			    $user_role = array_shift($user_roles);
			    echo esc_html($user_role);
			?>
		</p>
		<p class="description"><?php echo get_the_author_meta( 'description' );?></p>
	</article><!--about-author-->
	<?php }?>
	
	<?php if ( ( $smof_data['single-nav'] && !in_array( get_post_type() ,$learndash ) ) || ( in_array( get_post_type() ,$learndash ) && $smof_data['ld-footer-nav'] ) ) { ?>
	<footer class="single-footer-nav">
		<div class="prev-post">
			<?php $n = get_adjacent_post(true, '', false); ?>
			<?php if ( ! empty( $n ) ) :?>
		        <a class="post btn-ripple" href="<?php echo esc_url( get_permalink( $n->ID ) );?>" title="<?php echo apply_filters( 'the_title', $n->post_title );?>">
		        	<span><i class="zmdi zmdi-arrow-left"></i><?php _e( 'Previous', 'k2t' );?></span>
		        	<span class="tt"><?php echo apply_filters( 'the_title', $n->post_title );?></span>
		        </a>
	    	<?php endif;?>
	    </div>
	    <div class="next-post">
	    	<?php $p = get_adjacent_post(true, '', true);?>
	    	<?php if ( ! empty( $p ) ) :?>
	        <a class="post btn-ripple" href="<?php echo esc_url( get_permalink( $p->ID ) );?>" title="<?php echo apply_filters( 'the_title', $p->post_title );?>">
	        	<span><?php _e( 'Next', 'k2t' );?><i class="zmdi zmdi-arrow-right"></i></span>
	        	<span class="tt"><?php echo apply_filters( 'the_title', $p->post_title );?><span>
	        </a>
	        <?php endif;?>                          
	    </div>
	</footer>
	<?php }?>

</div>

