<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.9
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if (empty($woocommerce_loop['loop'])) {
    $woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if (empty($woocommerce_loop['columns'])) {
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);
}

// Ensure visibility
if (!$product || !$product->is_visible()) {
    return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if (0 == ($woocommerce_loop['loop'] - 1) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns']) {
    $classes[] = 'first';
}
if (0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns']) {
    $classes[] = 'last';
}
//$classes[]="col-xs-12";
?>
<li <?php post_class($classes); ?>>
    <?php do_action('woocommerce_before_shop_loop_item'); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-4 woo-wrapper-thumb">
            <a href="<?php the_permalink(); ?>">

                <?php
                /**
                 * woocommerce_before_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action('woocommerce_before_shop_loop_item_title');
                ?>
            </a>
            <div class="wrapper-product-option">
                <?php

                /**
                 * woocommerce_after_shop_loop_item hook
                 *
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                do_action('woocommerce_after_shop_loop_item');

                ?>
            </div>
        </div>
        <div class="woo-wrapper-info col-xs-12 col-sm-8">
            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

            <div class="item-title">
                <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action('woocommerce_after_shop_loop_item_title');
                do_action('woocommerce_template_single_rating');
                ?>
            </div>
            <?php echo apply_filters('woocommerce_short_description', $post->post_excerpt) ?>
        </div>
    </div>
</li>
