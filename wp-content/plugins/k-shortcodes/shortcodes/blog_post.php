<?php
/**
 * Shortcode k2t slider.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_blog_post_shortcode' ) ) {
	function k2t_blog_post_shortcode( $atts, $content ) {
		$html = $i = $style = $cat = $script = $limit = $slider_open = $slider_close = $items = $items_desktop = $items_tablet = $items_mobile = $navigation = $pagination = $p_class = $anm = $anm_name = $anm_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'style'         => '2',
			'thumb_align'	=> 'top',
			'limit'	        => '-1',
			'cat'           => '',
			'slider'        => '',
			'items'         => '',
			'items_desktop' => '',
			'items_tablet'  => '',
			'items_mobile'  => '',
			'navigation'    => '',
			'pagination'    => '',
			'auto_play'     => '',
			'anm'           => '',
			'anm_name'      => '',
			'anm_delay'     => '',
			'id'            => '',
			'class'         => '',
		), $atts));

	$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
	$class = ( $class != '' ) ? ' ' . $class . '' : '';

	wp_enqueue_script( 'k2t-owlcarousel' );

	// Global variables
	global $post, $smof_data;

	// Filter post type
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => $limit,
		'cat'            => $cat,
	);

	// The query
	$blog = new WP_query( $args );

	$i = 0;
	$html .= '<div class="k2t-blog k2t-blog-post style-'. esc_attr( $style ) .'">';

	// Has slider in style 2
	if ( $slider ) {
		$html .= '<div class="owl-carousel"	data-items="'. esc_attr( $items ) .'" data-autoPlay="'. esc_attr( ( $auto_play ) ? 'true' : 'false' ) .'" data-margin="30" data-nav="'. esc_attr( ( $navigation ) ? 'true' : 'false' ) .'" data-dots="'. esc_attr( ( $pagination ) ? 'true' : 'false' ) .'" data-mobile="'. esc_attr( $items_mobile ) .'" data-tablet="'. esc_attr( $items_tablet ) .'" data-desktop="'. esc_attr( $items_desktop ) .'">';
	}

	while ( $blog->have_posts() ) : $blog->the_post();

		// Get post format
		$post_format = get_post_format();
		$link        = ( function_exists( 'get_field' ) ) ? get_field( 'link_format_url', get_the_ID() ) : '';

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
		
		ob_start(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'element hentry post-item ' . $post_format . '-post' ); ?>>
			<div class="post-inner">
				<?php if ( 'quote' == $post_format ) : ?>
					<header>
						<?php if ( $smof_data['blog-date'] ):?><span class="entry-date"><i class="zmdi zmdi-calendar-note"></i><?php the_time( 'j M Y' ); ?></span><?php endif;?><?php if ( $smof_data['blog-author'] ) : ?><span class="entry-author"><i class="zmdi zmdi-account"></i><?php the_author_posts_link();?></span><?php endif;?>
					</header>
				<?php endif;?>
				<?php include 'tmpl/blog/post-format.php'; ?>
				<?php if ( 'quote' != $post_format ) : ?>
					<div class="entry-content clearfix">
						<a href="<?php echo get_category_link($post_categories[0]);?>" title="<?php echo get_cat_name($post_categories[0]); ?>" class="cat-icon" style = "background-color : <?php function_exists( 'get_field' ) ? the_field('category_color', 'category_' . $post_categories[0]) : '';?>"><?php function_exists( 'get_field' ) ? the_field('category_icon', 'category_' . $post_categories[0]) : '';?></a><header><?php if ( $smof_data['blog-date'] ):?><span class="entry-date"><i class="zmdi zmdi-calendar-note"></i><?php the_time( 'j M Y' ); ?></span><?php endif;?><?php if ( $smof_data['blog-author'] ) : ?><span class="entry-author"><i class="zmdi zmdi-account"></i><?php the_author_posts_link();?></span><?php endif;?>
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
							$excerpt = $blog->post->post_excerpt;
							if ( ! empty( $excerpt ) )
								echo '<p>' . $excerpt . '</p>';
							else 
								echo $trimmed_content = '<p>' . wp_trim_words( get_the_content(), $smof_data['excerpt-length'] ) . '</p>';
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
					</div>
				<?php endif;?>
				<?php if ( 'quote' == $post_format ) : ?>
					<a href="<?php echo get_category_link($post_categories[0]);?>" title="<?php echo get_cat_name($post_categories[0]); ?>" class="cat-icon" style = "background-color : <?php function_exists( 'get_field' ) ? the_field('category_color', 'category_' . $post_categories[0]) : '';?>"><?php function_exists( 'get_field' ) ? the_field('category_icon', 'category_' . $post_categories[0]) : '';?></a>
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
			</div>
		</article>
		<?php
		$html .= ob_get_clean();
		$html = str_replace( '	', '', $html );
		$i++;

	endwhile;

	// Has slider in style 2
	if ( $slider ) {
		$html .= '</div>';
	}

	$html .= '</div>';
	// Restore original Post Data
	wp_reset_postdata();
		
	$html .= $slider_close;

	// Apply filters return
	$html = apply_filters( 'k2t_blog_post_return', $html );
	return $html . $script;
	}
}