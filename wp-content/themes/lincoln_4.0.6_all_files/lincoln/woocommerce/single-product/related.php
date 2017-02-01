<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $smof_data;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;
wp_enqueue_script('k2t-owlcarousel');
$related_column = $smof_data['product-related-products-column'];
if ( $products->have_posts() ) : ?>

	<div class="related products">

		<h2><?php _e( 'Related Products', 'woocommerce' ); ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('.related .products').owlCarousel({
				items: <?php echo esc_attr($related_column);?>,
				autoPlay: true,
				margin: 0,
				loop: false,
				nav: false,
				navText: [
					"<i class='zmdi zmdi-arrow-left'></i>",
					"<i class='zmdi zmdi-arrow-right'></i>"
				],
				dots: false,
				responsive: {
					320: {
						items: 1
					},
					480: {
						items: 1
					},
					768: {
						items: 2
					},
					992: {
						items: 2
					},
					1200: {
						items: <?php echo esc_attr($related_column);?>
					}
				},
			});
		});
	</script>

<?php endif;

wp_reset_postdata();
