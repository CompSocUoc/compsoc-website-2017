<?php
/**
 * The template for displaying title and breadcrumb of project.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data, $post;
$show_hide_date = (function_exists('get_field')) ? get_field('show_hide_date', get_the_ID()) : 'no'; 
$show_hide_date = empty($show_hide_date) ? 'yes' : $show_hide_date;
$show_hide_author = (function_exists('get_field')) ? get_field('show_hide_author', get_the_ID()) : 'no'; 
$show_hide_author = empty($show_hide_author) ? 'yes' : $show_hide_author;
// Get post or page id
$id 		= get_the_ID();
$classes 	= $css = $html = array();

// Check pre
if ( is_tax( 'k-project-category' ) || is_tax( 'k-project-tag' ) ) {
	$pre 		= 'project-category-';
	$single_pre = 'project_category_';
} else {
	$pre 		= 'project-';
	$single_pre = 'project_';
}

// Get metadata of project in single
$arr_titlebar_meta_val  = array();
$arr_titlebar_meta 		= array( 
	'layout'									=> '',
	'display_titlebar' 							=> 'show', 
	'titlebar_font_size' 						=> '', 
	'titlebar_color' 							=> '', 
	'pading_top' 								=> '',
	'pading_bottom'								=> '', 
	'background_color' 							=> '', 
	'background_image' 							=> '', 
	'background_position' 						=> '', 
	'background_size' 							=> '', 
	'background_repeat' 						=> '', 
	'background_parallax' 						=> '', 
	'titlebar_overlay_opacity' 					=> '', 
	'titlebar_clipmask_opacity' 				=> '',
	'titlebar_custom_content'  					=> ''
);
foreach ( $arr_titlebar_meta as $meta => $val ) {
	if ( function_exists( 'get_field' ) ) {
		$default_titlebar = get_field( $single_pre . $meta, $id );
		if ( $default_titlebar && $default_titlebar != 'default' ) {
			$arr_titlebar_meta_val[$meta] = $default_titlebar;
		} else {
			if ( isset( $smof_data[ $pre . str_replace( '_', '-', $meta ) ] ) ) {
				$arr_titlebar_meta_val[$meta] = $smof_data[ $pre . str_replace( '_', '-', $meta ) ];
				if ( $arr_titlebar_meta_val[$meta] == 1 ) {
					$arr_titlebar_meta_val[$meta] = 'show';
				}
			}
		}
	}
}
extract( shortcode_atts( $arr_titlebar_meta, $arr_titlebar_meta_val ) );

if ( 'right_sidebar' == $layout ) {
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'no_sidebar' == $layout ) {
	$classes[] = 'no-sidebar';
}

// Title bar font size
if ( $titlebar_font_size ) {
	if ( is_numeric( $titlebar_font_size ) ) {
		$titlebar_font_size = ! empty( $titlebar_font_size ) ? 'font-size:' . $titlebar_font_size . 'px;' : '';
	} else {
		$titlebar_font_size = ! empty( $titlebar_font_size ) ? 'font-size:' . $titlebar_font_size . ';' : '';
	}
}

// Title bar color
if ( $titlebar_color ) {
	$titlebar_color = ! empty( $titlebar_color ) ? 'color:' . $titlebar_color . ';' : '';
}

// Padding for title bar
if ( $pading_top ) {
	if ( is_numeric( $pading_top ) ) {
		$css[] = ! empty( $pading_top ) ? 'padding-top:' . $pading_top . 'px;' : '';
	} else {
		$css[] = ! empty( $pading_top ) ? 'padding-top:' . $pading_top . ';' : '';
	}
}
if ( $pading_bottom ) {
	if ( is_numeric( $pading_bottom ) ) {
		$css[] = ! empty( $pading_bottom ) ? 'padding-bottom:' . $pading_bottom . 'px;' : '';
	} else {
		$css[] = ! empty( $pading_bottom ) ? 'padding-bottom:' . $pading_bottom . ';' : '';
	}
}

// Background color
if ( $background_color ) {
	$css[] = ! empty( $background_color ) ? 'background-color: ' . $background_color . ';' : '';
}

// Background image
if ( $background_image ) {
	if ( is_numeric( $background_image ) ) {
		$background_image = wp_get_attachment_image_src( $background_image );
		$background_image = $background_image[0];
	}
	$css[] = ! empty( $background_image ) ? 'background-image: url(' . $background_image . ');' : '';
	$css[] = ! empty( $background_position ) ? 'background-position: ' . $background_position . ';' : '';
	$css[] = ! empty( $background_repeat ) ? 'background-repeat: ' . $background_repeat . ';' : '';
	if ( 'full' == $background_size ) {
		$css[] = ! empty( $background_size ) ? 'background-size: 100%;' : '';
	} else {
		$css[] = ! empty( $background_size ) ? 'background-size: ' . $background_size . ';' : '';
	}
}

// Background parallax
$inline_attr = '';
if ( $background_parallax ) {
	$classes[] = empty( $background_parallax ) ? '' : 'parallax';
	if( function_exists( 'k2t_parallax_trigger_script' ) ){ k2t_parallax_trigger_script(); }
	$inline_attr = 'data-stellar-background-ratio="0.5"';
}

// Title bar mask color & background
if ( $titlebar_overlay_opacity || $titlebar_clipmask_opacity ) {
	$html[] = empty( $titlebar_overlay_opacity ) ? '' : '<div class="mask colors" style="opacity: 0.'. esc_attr( $titlebar_overlay_opacity ) .';"></div>';
	$html[] = empty( $titlebar_clipmask_opacity ) ? '' : '<div class="mask pattern" style="opacity: 0.'. esc_attr( $titlebar_clipmask_opacity ) .';"></div>';
}

if ( 'show' == $display_titlebar ) :
?>

	<div class="k2t-title-bar <?php echo esc_attr( implode( ' ', $classes ) ); ?>" style="<?php echo esc_attr( implode( '', $css ) ); ?>" <?php echo esc_attr($inline_attr); ?>>
		<?php echo implode( ' ', $html ); ?>
		<div>
			<div class="container k2t-wrap">
				<h1 class="main-title" style="<?php echo esc_attr($titlebar_font_size . $titlebar_color); ?>">
					<?php
						if ( is_single() ) {
							printf( single_post_title() );
						} elseif ( is_tax( 'k-project-category' ) || is_tax( 'k-project-tag' ) ) {

							global $wp_query;
						    $term = $wp_query->get_queried_object();
						    printf(  $term->name );

						}
					?>
				</h1>
				<div class="main-excerpt">
					<?php
						if ( ! empty( $titlebar_custom_content ) ) {

							echo do_shortcode( $titlebar_custom_content );
							
						} else {
							if ( is_single() ) {

								$author_id=$post->post_author;
								if( $show_hide_date == 'yes' ){
									echo '<span class="entry-date"><i class="zmdi zmdi-calendar-note"></i>' . get_the_date() . '</span>';
								}
								if( $show_hide_author == 'yes'){
									echo '<span class="entry-author"><i class="zmdi zmdi-account"></i>' .  get_the_author_meta( 'user_nicename', $author_id ) . '</span>';
								}
								
							} elseif ( is_tax( 'k-project-category' ) || is_tax( 'k-project-tag' ) ) {

								global $wp_query;
							    $term = $wp_query->get_queried_object();
							    printf(  esc_html( $term->description ) );

							}
						}
					?>
				</div><!-- .main-excerpt -->
			</div>
		</div>
			
	</div><!-- .k2t-title-bar -->

<?php endif;