<?php
/**
 * The template for displaying woocommerce.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data;

$classes = array();

$pre = 'shop-';
if ( is_product() ) {
	$pre = 'product-';
}


$arr_page_meta_val  	= array();
$arr_page_meta 		= array( 
	// Layout
	'layout'						=> 'right_sidebar', 
	'column'						=> '',
);

foreach ( $arr_page_meta as $meta => $val ) {
	if ( function_exists( 'get_field' ) ) {
		if ( ! empty( $smof_data[$pre . $meta] ) ) {
			$arr_page_meta_val[$meta] = $smof_data[$pre . $meta];
		}
	}
}
extract( shortcode_atts( $arr_page_meta, $arr_page_meta_val ) );

// Layout of woocommerce
if ( 'right_sidebar' == $layout ) {
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'no_sidebar' == $layout ) {
	$classes[] = 'no-sidebar';
}

get_header(); ?>
	<div class="k2t-content <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<section class="k2t-wrap">
			<main id="main" class="k2t-shop <?php if ( ! is_product() ) : echo 'columns-' . esc_attr( $column ) . ''; endif; ?>">

				<?php woocommerce_content(); ?>
				
			</main><!-- #main -->
			
			<?php
			if ( 'no_sidebar' != $layout ) { ?>
				<div class="k2t-shop-sidebar" role="complementary">
					<?php
						dynamic_sidebar( 'shop_sidebar' );	
					?>
				</div><!-- .k2t-sidebar -->
			<?php } ?>

		</section><!-- .container -->

		<?php 
		$product_custom_footer = isset ( $smof_data['product-custom-footer'] ) ? $smof_data['product-custom-footer'] : '';
		if ( ! empty( $product_custom_footer ) ) :
			echo '<div>';
			echo apply_filters( 'the_content', $product_custom_footer );
			echo '</div>';
		endif;?>

	</div><!-- .k2t-content -->
<?php get_footer(); ?>