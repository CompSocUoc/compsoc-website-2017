<?php
/**
 * The template display blog navigation.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

global $wp_query, $wp_rewrite, $smof_data, $nav;

$nav_query = $nav = '';

// Prepare variables
$query        = $nav_query ? $nav_query : $wp_query;
$max          = $query->max_num_pages;
$current_page = max( 1, get_query_var( 'paged' ) );
$big          = 99999;

$nav = '';
if ( is_page_template( 'templates/event-listing.php' ) ) {
	$nav = $smof_data['event-pagination-type'];
}

// Get type of page navigation if necessary

if ( $max > 1 ) :
		?>
		<?php if( $nav == 'pagination_lite') : ?>
			<div class="k2t-pagination-lite">
				<div class="prev-post btn-ripple">
					<?php previous_posts_link(__( '<i class="zmdi zmdi-long-arrow-left"></i>Previous', 'k2t' )); ?>
				</div>
				<div class="next-post btn-ripple">
					<?php next_posts_link(__( 'Next<i class="zmdi zmdi-long-arrow-right"></i>', 'k2t' )); ?>
				</div>
			</div>
		<?php else : ?>
			<div class="k2t-navigation">
				<?php
				echo '' . paginate_links(
					array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => '?paged=%#%',
						'current'   => $current_page,
						'total'     => $max,
						'type'      => 'list',
						'prev_text' => __( '<i class="zmdi zmdi-long-arrow-left"></i>', 'k2t' ),
						'next_text' => __( '<i class="zmdi zmdi-long-arrow-right"></i>', 'k2t' )
					)
				) . ' ';
				?>
			</div> 
		<?php endif; ?>
	<?php

endif;
