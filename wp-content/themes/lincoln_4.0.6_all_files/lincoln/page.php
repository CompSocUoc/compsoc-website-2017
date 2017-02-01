<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data, $post;

$classes = array();

// Get post or page id
if ( is_home() ) {
	$id = get_option( 'page_for_posts' );
} else {
	$id = get_the_ID();
}

// Register variables
$classes 						= array();
$style_attr						= array();
$single_pre 					= 'page_';

// Get metadata of event in single
$arr_page_meta_val  	= array();
$arr_page_meta 		= array( 
	// Layout
	'layout'						=> 'right_sidebar', 
	'custom_sidebar' 				=> '',
	'padding_top'					=> '',
	'padding_bottom'				=> '',
);

foreach ( $arr_page_meta as $meta => $val ) {
	if ( function_exists( 'get_field' ) ) {
		if ( get_field( $single_pre . $meta, $id ) ) {
			$arr_page_meta_val[$meta] = get_field( $single_pre . $meta, $id );
		}
	}
}
extract( shortcode_atts( $arr_page_meta, $arr_page_meta_val ) );

// Check view cart page
if (
	( function_exists( 'is_woocommerce' ) && is_woocommerce() ) ||
	( function_exists( 'is_cart' ) && is_cart() ) ||
	( function_exists( 'is_checkout' ) && is_checkout() ) || 
	( function_exists( 'is_account_page' ) && is_account_page() )
) {
	$layout = 'no_sidebar';
}

// Add class for page
if ( 'right_sidebar' == $layout ) {
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'no_sidebar' == $layout ) {
	$classes[] = 'no-sidebar';
}

// Add style for page
if ( ! empty( $padding_top ) ) {
	if ( is_numeric( $padding_top ) ) {
		$style_attr[] = 'padding-top: '. $padding_top .'px;';
	} else {
		$style_attr[] = 'padding-top: '. $padding_top .';';
	}
}
if ( ! empty( $padding_bottom ) ) {
	if ( is_numeric( $padding_bottom ) ) {
		$style_attr[] = 'padding-bottom: '. $padding_bottom .'px;';
	} else {
		$style_attr[] = 'padding-bottom: '. $padding_bottom .';';
	}
}

get_header(); ?>

	<div class="k2t-content <?php echo esc_attr( implode( ' ', $classes ) ) ?>" style="<?php echo esc_attr( implode( ' ', $style_attr ) ) ?>">

		<div class="container k2t-wrap">

			<!-- Main -->
			<main class="k2t-main page" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
	
					<?php get_template_part( 'content', 'page' ); ?>
	
				<?php endwhile; // end of the loop. ?>
	
				<div class="clear"></div>
				
				<?php if ( comments_open() ) :
						comments_template();
					endif;
				?>
			</main>

			<!-- Sidebar -->
			<?php
				if ( 'right_sidebar' == $layout || 'left_sidebar' == $layout ) {
					get_sidebar();
				}
			?>
		</div>
	</div><!-- .k2t-content -->

<?php get_footer(); ?>
