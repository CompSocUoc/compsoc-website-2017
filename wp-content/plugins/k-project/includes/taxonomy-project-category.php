<?php
/**
 * The template for displaying Category pages
 */
 
get_header();

//include( 'class.k_course.php' );

// Register variables
$classes 						= array();
$style_attr						= array();
$taxonomy_pre 					= 'project-category-';

// Get metadata of event in single
$arr_page_meta_val  	= array();
$arr_page_meta 		= array( 
	// Layout
	'layout'						=> 'right_sidebar', 
	'custom_sidebar' 				=> '',
	'style'							=> '',
	'child_style'					=> '',
	'number'						=> '',
);

foreach ( $arr_page_meta as $meta => $val ) {
	if ( function_exists( 'get_field' ) ) {
		if ( ! empty( $smof_data[$taxonomy_pre . $meta] ) ) {
			$arr_page_meta_val[$meta] = $smof_data[$taxonomy_pre . $meta];
		}
	}
}
extract( shortcode_atts( $arr_page_meta, $arr_page_meta_val ) );

// Layout of single course
if ( 'right_sidebar' == $layout ) {
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'no_sidebar' == $layout ) {
	$classes[] = 'no-sidebar';
}

// Get current term
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

?>
<div class="k2t-content <?php echo esc_attr( implode( ' ', $classes ) ) ?>" style="<?php echo esc_attr( implode( ' ', $style_attr ) ) ?>">

	<div class="container k2t-wrap">

		<!-- Main -->
		<main class="k2t-main page" role="main">
			<?php echo do_shortcode( '[k2t-project categories="'. $term->term_id .'" taxonomy="'. $term->taxonomy .'" number="'. $number .'" column="3" style="' . $style . '" child_style="' . $child_style . '" filter="false" filter_style="center" padding="true" /]' );?>
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