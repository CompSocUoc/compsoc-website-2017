<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

// Enqueue Script
wp_enqueue_script( 'sequence-jquery-min' );

$attachment_ids = array();
$video_link = get_post_meta( get_the_ID(), '_video_url', 'true');

?>

	<div id="sequence-slider">
		<div id="sequence" class="k2t-element-hover">
			<ul>
			<?php 
				if ( !empty( $video_link ) ) :
					echo '<li>';
					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );
					echo '</li>';
				endif;	// for yith plugin video feature.
				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
					$image_id = $product->get_image_id();
					$get_image = wp_get_attachment_url( $image_id );
					$attachment_ids = $product->get_gallery_attachment_ids();
					if ( $attachment_ids ) {
						foreach ( $attachment_ids as $attachment_id ) { 
							// Get image link by attachment ID
							$image_link  = wp_get_attachment_url( $attachment_id );
							$image_title = esc_attr( get_the_title( $attachment_id ) );
							$image_alt   = esc_attr( get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) );
							$image       = wp_get_attachment_image_src( $attachment_id, 'thumb_500x500' );
							$image_class = '';
							if ($image_link) { 
								$image_html = '<img class="model product-slider-image" data-zoom-image="' . $image_link . '" src="' . $image[0] . '" alt="' . $image_alt . '" title="' . $image_title . '" />';
								echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li>%1$s</li>', $image_html ), $attachment_id, $post->ID, $image_class );
							}
						}
					}
					else{
						echo $image_out = '<li><img class="product-no-silder" src="' . $get_image . '" alt= "" /></li>';
					}
				}
			?>
			</ul>
		</div>
		<?php if ( $attachment_ids ) { ?>
			<ul id="nav">
				<?php
					if ( !empty( $video_link ) ) :
						echo '<li></li>';
					endif;	// for yith plugin video feature.
				?>
				<?php foreach ( $attachment_ids as $attachment_id ) { 
					$image_link  = wp_get_attachment_url( $attachment_id );
					$image_title = esc_attr( get_the_title( $attachment_id ) );
					$image_alt   = esc_attr( get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) );
					$image       = aq_resize( $image_link, 100, 65, true );
					$image_class = '';
					if ($image_link) { 
						echo '<li></li>';
					}
				} ?>
			</ul>
			<script type="text/javascript">	
				(function($) {
					"use strict";

					$(document).ready(function(){
						var options = {
							nextButton: true,
							prevButton: true,
							animateStartingFrameIn: true,
							autoPlayDelay: 3000,
							preloader: true,
							pauseOnHover: false,
							preloadTheseFrames: [1],
							preloadTheseImages: [
								<?php foreach ( $attachment_ids as $attachment_id ) { 
									$image_link  = wp_get_attachment_url( $attachment_id );
									$image_title = esc_attr( get_the_title( $attachment_id ) );
									$image_alt   = esc_attr( get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) );
									
								} ?>
							]
						};
						
						var sequence = $("#sequence").sequence(options).data("sequence");

						sequence.afterLoaded = function(){
							$("#nav").fadeIn(100);
							$("#nav li:nth-child("+(sequence.settings.startingFrameID)+")").addClass("active");
						}

						sequence.beforeNextFrameAnimatesIn = function(){
							$("#nav li:not(:nth-child("+(sequence.nextFrameID)+")) ").removeClass("active");
							$("#nav li:nth-child("+(sequence.nextFrameID)+") ").addClass("active");
						}
						
						$("#nav li").click(function(){
							$(this).removeClass("active").addClass("active");
							sequence.nextFrameID = $(this).index()+1;
							sequence.goTo(sequence.nextFrameID);
						});
					});
				})(jQuery);
			</script>
		<?php } ?>
	</div><!--end:sequence-slider-->
