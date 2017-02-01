<?php
/**
 * The template for displaying title and breadcrumb of event.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data, $post;

// Get post or page id
if ( is_home() ) {
	$id = get_option( 'page_for_posts' );
} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
	$id = get_option( 'woocommerce_shop_page_id' );
} else {
	$id = get_the_ID();
}
// Display post time
$display_post_date = ( function_exists( 'get_field' ) ) ? get_field( 'display_post_date', get_the_ID() ) : '';
// Display author
$show_hide_author = ( function_exists( 'get_field' ) ) ? get_field( 'show_hide_author', get_the_ID() ) : '';

$classes = $css = $html = array();
// Check pre
$pre 		= 'page-';
$single_pre = 'page_';
if ( is_single() ) {
	if ( is_singular( 'post-portfolio' ) ) {
		$pre = 'portfolio-';
		$single_pre = 'portfolio_';
	} elseif ( is_singular( 'product' ) ) {
		$pre = 'product-';
		$single_pre = 'product_';
	} else {
		$pre = 'single-';
		$single_pre = 'single_';
	}
} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
	$pre = 'shop-';
	$single_pre = 'shop_';
}elseif ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) {
	$pre = 'blog-';
	$single_pre = 'blog_';
}

// Get metadata of event in single
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
		if ( get_field( $single_pre . $meta, $id, false ) ) {
			$arr_titlebar_meta_val[$meta] = get_field( $single_pre . $meta, $id, false );
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

if ( is_singular( 'product' ) ) {
	if ( 'right_sidebar' == $layout ) {
		$classes[] = 'right-sidebar';
	} elseif ( 'left_sidebar' == $layout ) {
		$classes[] = 'left-sidebar';
	} elseif ( 'no_sidebar' == $layout ) {
		$classes[] = 'no-sidebar';
	}
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
		$background_image = wp_get_attachment_image_src( $background_image, 'full' );
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
	$classes[] 	= empty( $background_parallax ) ? '' : 'parallax';
	$css[] 		= 'background-size:' . $background_size . ';' . 'background-attachment: fixed';
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
						if ( is_tag() ) {

							printf( single_tag_title() );

						} elseif ( is_day() ) {

							printf( the_time( 'F j, Y' ) );

						} elseif ( is_month() ) {

							printf( the_time( 'F, Y' ) );

						} elseif ( is_year() ) {

							printf( the_time( 'Y' ) );

						} elseif ( is_search() ) {

							printf( __( 'Search for ', 'k2t' ) . get_search_query() );

						} elseif ( is_front_page() ) {

							printf( bloginfo( 'name' ) );

						} elseif ( is_single() ) {

							printf( single_post_title() );

						} elseif ( is_tax( 'portfolio-category' ) ) {

							global $wp_query;
						    $term = $wp_query->get_queried_object();
						    printf(  $term->name );

						} elseif ( is_category() ) {

							printf( single_cat_title() );

						} elseif ( is_author() ) {

							global $wp_query;

							$curauth = $wp_query->get_queried_object();

							printf( $curauth->nickname );

						} elseif ( is_page() ) {

							the_title();

						} elseif ( is_home() ) {

							printf( __( 'Blog', 'k2t' ) );

						} elseif ( is_404() ) {

							printf( __( 'Error 404', 'k2t' ) );
							
						} elseif (  function_exists( 'is_product_category' ) && is_product_category() ) {

							$id          = get_the_ID();
							$product_cat = wp_get_post_terms( $id, 'product_cat' );
							$title = $slug = array();
							if ( $product_cat ) {
								foreach ( $product_cat as $category ) {
									$title[] = "{$category->name}";
								}
							}

							printf( $title[0] );

						} elseif ( is_post_type_archive( 'product' ) ) {

							printf( __( 'Shop', 'k2t' ) );

						} elseif ( is_post_type_archive() ) {

							printf( post_type_archive_title() );
							
						} elseif (
							( function_exists( 'is_woocommerce' ) && is_woocommerce() ) ||
							( function_exists( 'is_cart' ) && is_cart() ) ||
							( function_exists( 'is_checkout' ) && is_checkout() )
						) {
							$product_cat = wp_get_post_terms( $id, 'product_cat' );
							$title = array();
							if ( $product_cat ) {
								foreach ( $product_cat as $category ) {
									$title[] = "{$category->name}";
								}
							}
							echo ( $title[0] );
						}
					?>
				</h1>
				<div class="main-excerpt">
					<?php
						if ( is_single() ) {
							
							if ( is_singular( 'product' ) ) {
								global $post;
								$content = get_extended( $post->ID );
								if (empty($titlebar_custom_content)) {
									echo __( 'ID: ', 'k2t' ) . esc_html( $content['main'] );
								} else {
									echo esc_html($titlebar_custom_content);
								}
								
							} else if ( is_singular( 'post-project' ) ){
								$categories = get_the_terms(get_the_ID(), 'project-category');
								$cat_name = $categories[0]->name;
                        		echo '<span class="entry-category">' .  esc_html($cat_name) . '</span>';
							} else {
								$author_id=$post->post_author;
								if( isset( $display_post_date ) && $display_post_date != '2' ) {
									echo '<span class="entry-date"><i class="zmdi zmdi-calendar-note"></i>' . get_the_date() . '</span>';	
								}
								if( isset( $show_hide_author ) && $show_hide_author != '2' ) {
									echo '<span class="entry-author"><i class="zmdi zmdi-account"></i>' .  get_the_author_meta( 'user_nicename', $author_id ) . '</span>';
								}
							}
							
						} elseif ( is_tax( 'portfolio-category' ) ) {
							global $wp_query;
						    $term = $wp_query->get_queried_object();
						    printf(  esc_html( $term->description ) );
						} elseif ( is_category() ) {
							// Show an optional term description.
							$term_description = term_description();
							if ( ! empty( $term_description ) ) {
								printf( '<div class="taxonomy-description">%s</div>', $term_description );
							} elseif ( $titlebar_custom_content ) {
								echo do_shortcode( $titlebar_custom_content );
							}
						} else {
							if ( ! empty( $titlebar_custom_content ) ) {
								echo do_shortcode( $titlebar_custom_content );
							}
						}
					?>
				</div><!-- .main-excerpt -->
			</div>
		</div>
		
		<?php
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			if ( $smof_data['shop-breadcrumb'] ) {
				echo '<div><div class="container k2t-wrap breadcrumb">';
				k2t_breadcrumbs();
				echo '</div><!-- k2t-wrap --></div>';
			}
		} else {
			if ( is_author() ) {
				global $wp_query;
				$curauth = $wp_query->get_queried_object();
				echo '<div><div class="container k2t-wrap breadcrumb"><p class="author-email">';
					printf( $curauth->user_email );
				echo '</p></div><!-- k2t-wrap --></div>';
			}
			else 
				if ( $smof_data['breadcrumb'] ) {
				echo '<div><div class="container k2t-wrap breadcrumb">';
				k2t_breadcrumbs();
				echo '</div><!-- k2t-wrap --></div>';
			}
		}
		?>
			
	</div><!-- .k2t-title-bar -->

<?php endif;