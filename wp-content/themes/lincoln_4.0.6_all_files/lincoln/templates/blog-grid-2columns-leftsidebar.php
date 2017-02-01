<?php
/**
 * The blog template file.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 * Template Name: Blog Grid 2 Columns left sidebar
 */

// Get theme options
global $smof_data, $blog_style, $wp_query;
$blog_style = 'grid';
$classes = '';
if ($smof_data['pagination-type'] == 'pagination_lite') {
	$classes = 'pagination_lite';
}

$page_select_categories         = ( function_exists( 'get_field' ) ) ? get_field( 'page_select_categories', $id ) : '';

// Get category by id
$post_of_cats = '';
if ( is_numeric( $page_select_categories ) ) {
	$post_of_cats = $page_select_categories;
} else {
	$i = 0;
	if ( is_array( $page_select_categories ) && count( $page_select_categories ) > 0 ) {
		foreach( $page_select_categories as $key => $val ) {
			if ( $i == count( $page_select_categories ) ) {
				$post_of_cats .= $val;
			} else {
				$post_of_cats .= ',' . $val;
			}
			$i++;
		}
	}
}

// Get post format
$post_format = get_post_format();
$link        = ( function_exists( 'get_field' ) ) ? get_field( 'link_format_url', get_the_ID() ) : '';
get_header(); ?>

	<div class="k2t-content left-sidebar b-grid <?php echo esc_attr($classes);?>">

		<div class="k2t-wrap">

			<main class="k2t-blog" role="main">
				<div class="grid-layout column-2 clearfix">

					<?php
						$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
						$args = array(
							'post_type'      => 'post',
							'posts_per_page' => get_option('posts_per_page '),
							'paged'			 => $paged,
							'cat'			 => $post_of_cats,
						);
						$wp_query = new WP_query( $args );
						if ( $wp_query->have_posts() ) :
							while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
								get_template_part( 'templates/blog/content', 'grid' );
							endwhile;
							include_once get_template_directory() . '/templates/navigation.php';
						endif;
						wp_reset_postdata();
					?>
				</div>
			</main><!-- .k2t-main -->

			<?php get_sidebar(); ?>

		</div><!-- .k2t-wrap -->
	</div><!-- .k2t-content -->

<?php get_footer(); ?>
