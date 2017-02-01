<?php
/**
 * The template display blog navigation.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

global $wp_query, $wp_rewrite, $smof_data;

$nav_query = $nav = '';

// Prepare variables
$query        = $nav_query ? $nav_query : $wp_query;
$max          = $query->max_num_pages;
$current_page = max( 1, get_query_var( 'paged' ) );
$big          = 99999;
$nav = $smof_data['pagination-type'];

// Get type of page navigation if necessary

if ( $max > 1 ) :

	if ( 'pagination_ajax' == $nav ) :

		if ( ! is_singular() ) {
			wp_enqueue_script( 'infinitescroll-script' );
			wp_enqueue_script( 'jquery-imageloaded-script' );
			echo '<scr' . 'ipt>'; ?>
				
				(function($) {
					"use strict";

					$(document).ready(function() {
						var $container = $( '.k2t-blog .masonry-layout' );
						$container.imagesLoaded(function(){
							$container.masonry({
								itemSelector: '.hentry'
							});
						});
						$container.infinitescroll(
							{
								navSelector: '.nav-seemore', // selector for the paged navigation
								nextSelector: '.nav-seemore a', // selector for the NEXT link (to page 2)
								itemSelector: '.hentry', // selector for all items you'll retrieve
								loading: {
									finishedMsg: 'No more pages to load.',
									img: 'http://i.imgur.com/qkKy8.gif'
								}
							},
							function( newElements ) {
								// hide new items while they are loading
								var $newElems = $( newElements ).css({ opacity: 0 });
								// ensure that images load before adding to masonry layout
								$newElems.imagesLoaded(function(){
									// show elems now they're ready
									$newElems.animate({ opacity: 1 });
									$container.masonry( 'appended', $newElems, true );
								}); 
								$(".k2t-thumb-gallery").owlCarousel({
									singleItem: true,
									pagination: true,
									navigation: true,
									slideSpeed: 300,
									rewindSpeed: 5000,
									navigationText: [
										'<i class="zmdi zmdi-arrow-left"></i>',
										'<i class="zmdi zmdi-arrow-right"></i>'
									],
								});
							}
						);
					});
				})(jQuery);

			<?php
			echo '</scr' . 'ipt>';
		}
		?>
		<div class="nav-seemore">
			<div class="nav-seemore-inner">
				<?php echo next_posts_link( __( 'Load More', 'k2t' ) ); ?>
			</div>
		</div>
	<?php elseif('pagination_lite' == $nav) : ?>
		<div class="k2t-pagination-lite">
			<div class="prev-post btn-ripple">
				<?php previous_posts_link(__( '<i class="zmdi zmdi-long-arrow-left"></i>Previous', 'k2t' )); ?>
			</div>
			<div class="next-post btn-ripple">
				<?php next_posts_link(__( 'Next<i class="zmdi zmdi-long-arrow-right"></i>', 'k2t' )); ?>
			</div>
		</div>
	<?php
	else : ?>
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
	<?php endif;

endif;
