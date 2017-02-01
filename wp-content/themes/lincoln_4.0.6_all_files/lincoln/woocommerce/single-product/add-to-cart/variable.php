<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">

<div class="variations">
	<?php if ( ! empty( $available_variations ) ) : ?>
		<div class="clearfix inner">
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<div>
						<div class="wrapper-dropdown-3">
							<?php
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
								wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
							?>
						</div>
					</div>
		        <?php endforeach;?>

			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			

			<div class="variations_input">
				<?php woocommerce_quantity_input(); ?>
			</div>
		</div>

		<div class="single_variation"></div>

		<div class="variations_button">
			<button type="submit" class="single_add_to_cart_button button alt btn-ripple"><?php echo $product->single_add_to_cart_text(); ?></button>
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="" />
		</div>

		<?php do_action( 'woocommerce_after_single_variation' ); ?>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'lincoln' ); ?></p>

	<?php endif; ?>

</div></form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>