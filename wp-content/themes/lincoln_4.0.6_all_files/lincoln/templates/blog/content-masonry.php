<?php
/**
 * The template for displaying content masonry.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data, $post;
$blog_style = $smof_data['blog-style'];

// Get all categories of post
$post_categories = wp_get_post_categories( get_the_ID() );
$post_categories_html = '';
if ( count( $post_categories ) > 0 ){
	foreach ($post_categories as $key => $value) {
		$category_name = get_the_category_by_ID( $value );
		$category_link = get_category_link( $value );
		if ( $key == 0 ){
			$post_categories_html .= '<a href="'. $category_link .'">'. $category_name .'</a>';
		}else{
			$post_categories_html .= ', <a href="'. $category_link .'">'. $category_name .'</a>';
		}
	}
}

// Get post format
$post_format = get_post_format();
$link        = ( function_exists( 'get_field' ) ) ? get_field( 'link_format_url', get_the_ID() ) : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'element hentry post-item ' . $post_format . '-post' ); ?>>
	<div class="post-inner k2t-element-hover">
	<!-- Display if blog style Large 2 and not format quote -->


		<?php if ( 'quote' == $post_format ) : ?>
			<header>
				<?php if ( $smof_data['blog-date'] ):?>
	            	<span class="entry-date"><i class="zmdi zmdi-calendar-note"></i><?php the_time( 'j M Y' ); ?></span>
	            <?php endif;?>
	    		<?php if ( $smof_data['blog-author'] ) : ?>
	            	<span class="entry-author"><i class="zmdi zmdi-account"></i><?php the_author_posts_link();?></span>
	            <?php endif;?>
	           
	        </header>
	    <?php endif;?>

		<!-- Include thumb -->
	    <?php include get_template_directory() . '/templates/blog/post-format.php'; ?>

	    <!-- Display if blog style Masonry and not format quote -->
	    <?php if ( 'quote' != $post_format ) : ?>

		    <div class="entry-content clearfix">
		    	<?php if( isset( $smof_data['blog-categories-icons'] ) && $smof_data['blog-categories-icons'] == '1' ): ?>
			    	<a href="<?php echo get_category_link($post_categories[0]);?>" title="<?php echo get_cat_name($post_categories[0]); ?>" class="cat-icon" style = "background-color : <?php function_exists( 'get_field' ) ? the_field('category_color', 'category_' . $post_categories[0]) : '';?>">
				    	<?php function_exists( 'get_field' ) ? the_field('category_icon', 'category_' . $post_categories[0]) : '<i class="zmdi zmdi-graduation-cap"></i>';?>
				    </a>
				<?php endif; ?>
		    	<header>
					<?php if ( $smof_data['blog-date'] ):?>
		            	<span class="entry-date"><i class="zmdi zmdi-calendar-note"></i><?php the_time( 'j M Y' ); ?></span>
		            <?php endif;?>
		    		<?php if ( $smof_data['blog-author'] ) : ?>
		            	<span class="entry-author"><i class="zmdi zmdi-account"></i><?php the_author_posts_link();?></span>
		            <?php endif;?>
		            
		    		<?php 
		    			if ( 'link' == $post_format ) {
							the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( $link ) ), '</a></h2>' );
						} else {
							if ( $smof_data['blog-post-link'] ) {
								the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
							}
						}
		    		?>
		        </header>

		        <?php
					if ( 'excerpts' == $smof_data['blog-display'] ) {
						$excerpt = get_the_excerpt();
						if(!empty( $excerpt )) {
							echo ( $trimmed_content = '<p class="excerpt">' . wp_trim_words( get_the_excerpt(), $smof_data['excerpt-length'] ) . '</p>' );
						}
					} else {
						the_content();			
					}
				?>
		        <div class= "footer-content clearfix">
			        <?php 
				       	if ( $smof_data['blog-readmore'] ) {
				        	echo '<a class="more-link btn-ripple" href="' . get_permalink() . '">'. __( 'Read more', 'k2t' ) .'<i class="zmdi zmdi-chevron-right"></i></a>';
				        }
			        ?>

		            <?php if ( $smof_data['blog-number-comment'] ) :?>
			            <span class="entry-comment"><i class="zmdi zmdi-comment-alt-text"></i><a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?></a></span>
			        <?php endif;?>
			    </div>
		        
		    </div><!--end:entry-content-->

		<?php endif;?>

		<?php if ( 'quote' == $post_format ) : ?>
			<?php if( isset( $smof_data['blog-categories-icons'] ) && $smof_data['blog-categories-icons'] == '1' ): ?>
				<a href="<?php echo get_category_link($post_categories[0]);?>" title="<?php echo get_cat_name($post_categories[0]); ?>" class="cat-icon" style = "background-color : <?php function_exists( 'get_field' ) ? the_field('category_color', 'category_' . $post_categories[0]) : '';?>">
					<?php function_exists( 'get_field' ) ? the_field('category_icon', 'category_' . $post_categories[0]) : '<i class="zmdi zmdi-graduation-cap"></i>';?>
				</a>
			<?php endif; ?>
	        <div class= "footer-content clearfix">
		        <?php 
			       	if ( $smof_data['blog-readmore'] ) {
			        	echo '<a class="more-link btn-ripple" href="' . get_permalink() . '">'. __( 'Read more', 'k2t' ) .'<i class="zmdi zmdi-chevron-right"></i></a>';
			        }
		        ?>

	            <?php if ( $smof_data['blog-number-comment'] ) :?>
		            <span class="entry-comment"><i class="zmdi zmdi-comment-alt-text"></i><a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?></a></span>
		        <?php endif;?>
		    </div>

		<?php endif ?>
	</div><!--post-inner-->
    
</article><!--end:post-item-->