<?php
/**
 * The template for displaying Category pages
 */
get_header();


// Register variables
$classes 						= array();
$style_attr						= array();
$taxonomy_pre 					= 'course-category-';

// Get metadata of event in single
$arr_page_meta_val  	= array();
$arr_page_meta 		= array( 
	// Layout
	'layout'						=> 'right_sidebar', 
	'custom_sidebar' 				=> '',
	'style'							=> '',
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
$term = get_queried_object()->term_taxonomy_id;

?>
<div class="k2t-content <?php echo esc_attr( implode( ' ', $classes ) ) ?>" style="<?php echo esc_attr( implode( ' ', $style_attr ) ) ?>">

	<div class="container k2t-wrap">

		<!-- Main -->
		<main class="k2t-main page" role="main">
			<?php 
				switch ( $style ) {
					case 'style-2':
						echo K_Course::K_Render_course_listing_masonry( $number, 'columns-3', 'hide' , 'show', 'show', 'text' , $term );
						break;
					default:
						echo K_Course::K_Render_course_listing_default( $number , 'show', 'show', $term );
						break;
				}
			 ?>
		</main>

		<!-- Sidebar -->
		<?php
			if ( 'right_sidebar' == $layout || 'left_sidebar' == $layout ) {
				get_sidebar();
			}
		?>
	</div>

</div>
<?php get_footer(); ?>