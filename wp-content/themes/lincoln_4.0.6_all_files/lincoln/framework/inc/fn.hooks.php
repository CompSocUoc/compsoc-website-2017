<?php

/**
 * Required action filters
 *
 * @uses add_action()
 *
 * @since 1.0.0
 */

/**
 * AJAX Saving Options
 *
 * @since 1.0.0
 */
add_action( 'wp_ajax_of_ajax_post_action', 'of_ajax_callback' );

/*
	Remove script version
*/
function k2t_remove_version( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'k2t_remove_version', 9999 );
add_filter( 'script_loader_src', 'k2t_remove_version', 9999 );
remove_filter( 'the_content', 'wpautop', 9 );

// func change logo for default login page
function my_login_logo() {
	global $smof_data;
	if( isset( $smof_data['login_logo'] ) && $smof_data['login_logo'] != ''):
	?>
    <style type="text/css">
        .login h1 a {
            background: url(<?php echo $smof_data['login_logo']; ?>) no-repeat center center !important;
            width: 100% !important;
        }
    </style>
<?php endif; }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function k2t_update_k_post_type_slug(){
	global $smof_data;
	if( isset( $smof_data['k2t-event-slug'] ) && !empty( $smof_data['k2t-event-slug'] ) ) 
		update_option( 'k2t-event-slug', $smof_data['k2t-event-slug'], 'yes' );
	if( isset( $smof_data['k2t-event-category-slug'] )  && !empty( $smof_data['k2t-event-category-slug'] ) ) 
		update_option( 'k2t_event_category_slug', $smof_data['k2t-event-category-slug'], 'yes' );
	if( isset( $smof_data['k2t-event-tag-slug'] )  && !empty( $smof_data['k2t-event-tag-slug'] ) ) 
		update_option( 'k2t_event_tag_slug', $smof_data['k2t-event-tag-slug'], 'yes' );
	if( isset( $smof_data['k2t-course-slug'] )  && !empty( $smof_data['k2t-course-slug'] ) ) 
		update_option( 'k2t_course_slug', $smof_data['k2t-course-slug'], 'yes' );
	if( isset( $smof_data['k2t-course-category-slug'] )  && !empty( $smof_data['k2t-course-category-slug'] ) ) 
		update_option( 'k2t_course_category_slug', $smof_data['k2t-course-category-slug'], 'yes' );
	if( isset( $smof_data['k2t-course-tag-slug'] )  && !empty( $smof_data['k2t-course-tag-slug'] ) ) 
		update_option( 'k2t_course_tag_slug', $smof_data['k2t-course-tag-slug'], 'yes' );
	if( isset( $smof_data['k2t-teacher-slug'] )  && !empty( $smof_data['k2t-teacher-slug'] ) ) 
		update_option( 'k2t_teacher_slug', $smof_data['k2t-teacher-slug'], 'yes' );
}
add_action('init','k2t_update_k_post_type_slug');
// Hooks on Back-end


/**
 * Create admin option page.
 *
 * @return  void
 */

function lincoln_welcome_admin_menu() {
	global $submenu, $pagenow;

	if ( current_user_can( 'edit_theme_options' ) ) {
		$menu = 'add_menu_' . 'page';
		// Add page menu
		$menu(
			esc_html__( 'Lincoln Welcome', 'k2t' ),
			esc_html__( 'Lincoln Welcome', 'k2t' ),
			'manage_options',
			'lincoln-welcome',
			array( 'lincoln_welcome', 'html' ),
			get_template_directory_uri() . '/framework/assets/images/back-end-logo.png',
			2
		);

		// Add submenu
		$sub_menu = 'add_submenu_' . 'page';
		$sub_menu(
			'Lincoln WP',
			esc_html__( ' Dashboard', 'k2t' ),
			esc_html__( 'Dashboard', 'k2t' ),
			'manage_options',
			'lincoln-welcome',
			array( 'lincoln_welcome', 'html' )
		);

	}

	// redirect to welcome page
	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) && $_GET['activated'] == 'true' ) {
		wp_redirect( admin_url ( 'admin.php?page=lincoln-welcome' ) );
	}

	lincoln_welcome::initialize();
}
add_action( 'admin_menu', 'lincoln_welcome_admin_menu' );



if( is_admin() ){

	//Enqueue Script and Css in Backend
	if ( ! function_exists ( 'k_backend_scripts' ) ){
		function k_backend_scripts() {
			wp_enqueue_style( 'k-backend-style', K2T_THEME_URL . 'assets/css/k2t-backend.css' );
			wp_enqueue_script( 'k2t-media-load', K2T_FRAMEWORK_URL . 'assets/js/media-load.js', array(), '1.0', true );
		}
		add_action( 'admin_enqueue_scripts', 'k_backend_scripts' );
	}
	
	/*--------------------------------------------------------------
	Var for Script Backup
	--------------------------------------------------------------*/
	if ( ! function_exists( 'k2t_sample_import_add_admin_head' ) ) {
		function k2t_sample_import_add_admin_head() {
			echo '<scr' . 'ipt>';
			echo 'var home_url = "' . esc_url( site_url() ) . '";';
			echo 'var installing_proccess  = 0;';
			echo 'var cache_installing_url = "' . K2T_FRAMEWORK_URL . 'inc/k2timporter/tmp_backup/cache_proccess";';
			echo '</scr' . 'ipt>';
		}
		add_action( 'admin_head', 'k2t_sample_import_add_admin_head');
	}
}

// Enqueue css login admin
function themeslug_enqueue_style() {
	wp_enqueue_style( 'admin-style', K2T_FRAMEWORK_URL . 'assets/css/admin-style.css' );
}
add_action( 'login_enqueue_scripts', 'themeslug_enqueue_style', 10 );


// Hooks on Front-end
if( ! is_admin() ){
	
	/*--------------------------------------------------------------
	Enqueue front-end script
	--------------------------------------------------------------*/
	if ( ! function_exists( 'k2t_front_end_enqueue_script' ) ) :
		function k2t_front_end_enqueue_script() {
			global $smof_data;

			// Load jquery easing.
			wp_enqueue_script( 'jquery-easing-script', K2T_THEME_URL . 'assets/js/vendor/jquery-easing.js', array(), '', true );
	
			// Load parallax library.
			wp_enqueue_script( 'jquery-stellar-script', K2T_THEME_URL . 'assets/js/vendor/jquery.stellar.min.js', array(), '', true );
	
			// Load infinite scroll library.
			wp_register_script( 'infinitescroll-script', K2T_THEME_URL . 'assets/js/vendor/jquery.infinitescroll.min.js', array(), '', true );
	
			// Load infinite scroll library.
			wp_register_script( 'jquery-imageloaded-script', K2T_THEME_URL . 'assets/js/vendor/jquery.imageloaded.min.js', array(), '', true );
	
			// Load zoom effect for title bar.
			if ( function_exists( 'get_field' ) && get_field( 'background_zoom', get_the_ID() ) ) {
				wp_enqueue_script( 'zoomeffects-script', K2T_THEME_URL . 'assets/js/vendor/zoom-effect.js', array(), '', true );
			}

			// Enqueue jquery ripple
			wp_enqueue_script( 'ripple', K2T_THEME_URL . 'assets/js/vendor/ripple.js', array(), '', true );
	
			// Register background slider
			wp_register_script( 'jquery-cbpBGSlideshow', K2T_THEME_URL . 'assets/js/vendor/jquery.cbpBGSlideshow.js', array(), '', true );

	
			// Enqueue jquery isotope
			wp_register_script( 'k2t-masonry', K2T_THEME_URL . 'assets/js/masonry.js', array( 'jquery' ), '', true );
			wp_register_script( 'jquery-isotope', K2T_THEME_URL . 'assets/js/vendor/isotope.pkgd.min.js', array(), '', true );
	
			// Jquery Library: Imagesloaded
			wp_register_script( 'jquery-imagesloaded', K2T_THEME_URL . 'assets/js/vendor/imagesloaded.pkgd.min.js', array( 'jquery' ), '3.1.6', true );
		
			// Enqueue jquery isotope
			wp_register_script( 'sequence-jquery-min', K2T_THEME_URL . 'assets/js/vendor/sequence.jquery-min.js', array(), '', true );

			wp_enqueue_script( 'k2t-owlcarousel', K2T_THEME_URL . 'assets/js/vendor/owl.carousel.min.js', array(), '', true);
	
			// Load our custom javascript.
			$mainParams = array();
			wp_enqueue_script( 'jquery-mousewheel', K2T_THEME_URL . 'assets/js/vendor/jquery.mousewheel.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'k2t-main-script', K2T_THEME_URL . 'assets/js/main.js', array( 'jquery' ), '', true );
			if ( isset( $smof_data['offcanvas-swipe'] ) && $smof_data['offcanvas-swipe'] ) {
				$mainParams['offcanvas_turnon'] = $smof_data['offcanvas-turnon'];
			}
			if ( isset( $smof_data['sticky-menu'] ) ) {
				$mainParams['sticky_menu'] = $smof_data['sticky-menu'];
			}
			if ( isset( $smof_data['smart-sticky'] ) ) {
				$mainParams['smart_sticky'] = $smof_data['smart-sticky'];
			}
			if ( 'masonry' == $smof_data['blog-style'] ) {
				$mainParams['blog_style'] = $smof_data['blog-style'];
			}
			wp_localize_script( 'k2t-main-script', 'mainParams', $mainParams );
			
			// Adds the comment-reply JavaScript to the single post pages
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
	
		}
		add_action( 'wp_enqueue_scripts', 'k2t_front_end_enqueue_script' );
	endif;
	
	/*--------------------------------------------------------------
		Enqueue front-end style
	--------------------------------------------------------------*/
	if ( ! function_exists( 'k2t_front_end_enqueue_style' ) ) :
		function k2t_front_end_enqueue_style() {
			global $wp_styles, $smof_data;
			
			wp_enqueue_style( 'k2t-owlcarousel', K2T_THEME_URL . 'assets/css/vendor/owl.carousel.css' );
			
			// Load background slider
			wp_enqueue_style( 'k2t-cbpBGSlideshow', K2T_THEME_URL . 'assets/css/vendor/cbpBGSlideshow.css' );

			// Load font awesome for first active theme
			wp_enqueue_style( 'k2t-font-awesome-min', K2T_THEME_URL . 'assets/css/vendor/font-awesome.min.css' );	
			// Style for mega menu
			wp_enqueue_style( 'k2t-megamenu-style', K2T_THEME_URL . 'assets/css/megamenu.css' );
	
			// Load popular stylesheet.
			wp_enqueue_style( 'k2t-owl-style', K2T_THEME_URL . 'assets/css/popular.css' );
	
			// Load single product gallery
			wp_enqueue_style( 'k2t-sequencejs-theme.modern-slide', K2T_THEME_URL . 'assets/css/vendor/sequencejs-theme.modern-slide-in.css' );

			// Load our k shortcodes stylesheet.
			wp_enqueue_style( 'k2t-shortcodes', K2T_THEME_URL . 'assets/css/k-shortcodes.css' );
			
			// Load our k gallery stylesheet.
			wp_enqueue_style( 'k2t-gallery', K2T_THEME_URL . 'assets/css/k-gallery.css' );

			// Load our k project stylesheet.
			wp_enqueue_style( 'k2t-project', K2T_THEME_URL . 'assets/css/k-project.css' );

			// Load our k event stylesheet.
			wp_enqueue_style( 'k2t-event', K2T_THEME_URL . 'assets/css/k-event.css' );

			// Load our k teacher stylesheet.
			wp_enqueue_style( 'k2t-teacher', K2T_THEME_URL . 'assets/css/k-teacher.css' );

			// Load our k course stylesheet.
			wp_enqueue_style( 'k2t-course', K2T_THEME_URL . 'assets/css/k-course.css' );

			// Load our k learndash stylesheet.
			wp_enqueue_style( 'k2t-learndash', K2T_THEME_URL . 'assets/css/k-learndash.css' );
			
			// Load our rtl stylesheet.
			if( isset( $smof_data['rtl_lang'] ) && $smof_data['rtl_lang'] == '1' ){
				wp_enqueue_style( 'k2t-rtl-style', K2T_THEME_URL . 'rtl.css' );
			}
			
			// Load our main stylesheet.
			wp_enqueue_style( 'k2t-main-style', K2T_THEME_URL . 'assets/css/main.css' );

			// learndash
			
			wp_enqueue_style( 'k2t-ld-grid', K2T_THEME_URL . 'assets/css/learndash-grid.css' );

			wp_enqueue_style( 'k2t-humberger-css', K2T_THEME_URL . 'assets/css/vendor/hamburgers.css' );
	
			if ( isset ( $smof_data['theme-primary-color'] ) && $smof_data['theme-primary-color'] != 'default' && $smof_data['theme-primary-color'] != 'custom' ) {
				if( file_exists( K2T_THEME_PATH . 'assets/css/skin/'. $smof_data['theme-primary-color'] .'.css' ) )
					wp_enqueue_style( 'theme-'. $smof_data['theme-primary-color'] .'-color', K2T_THEME_URL . 'assets/css/skin/'. $smof_data['theme-primary-color'] .'.css' );
			}
	
			// Load responsive stylesheet.
			wp_enqueue_style( 'k2t-reponsive-style', K2T_THEME_URL . 'assets/css/responsive.css' );
			
			//Enqueue shortcodes style css update
			if( file_exists( K2T_THEME_PATH . 'assets/css/shortcodes-update.css' ) ){
				wp_enqueue_style( 'k2t-plugin-shortcodes-update', K2T_THEME_URL . 'assets/css/shortcodes-update.css' );
			}
			//Enqueue portfolio style css update
			if( file_exists( K2T_THEME_PATH . 'assets/css/portfolio-update.css' ) ){
				wp_enqueue_style( 'k2t-plugin-portfolio-update', K2T_THEME_URL . 'assets/css/portfolio-update.css' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'k2t_front_end_enqueue_style' );
	endif;
		
	
	/*--------------------------------------------------------------
	Enqueue front-end inline script
	--------------------------------------------------------------*/
	if ( ! function_exists( 'k2t_front_end_enqueue_inline_script' ) ) :
		function k2t_front_end_enqueue_inline_script() {
			// Get theme options
			global $smof_data;
	
			if ( ! wp_script_is(' k2t-inline-scripts', 'scripts' ) ) {
	
				if ( isset( $smof_data['blog-style'] ) && 'timeline' == $smof_data['blog-style'] ) {
					echo '
					<scr' . 'ipt>
						jQuery(window).load(function($) {
							var $ = jQuery;
							function timeline_indicator() {
								var post = $( ".b-timeline" ).find( ".hentry" );
								$.each( post, function( i,obj ) {           
									var posLeft = $( obj ).css( "left" );
									if( posLeft == "0px" ) {
										$(obj).addClass( "post-left" );
									} else {
										$(obj).addClass( "post-right" );
									}
								});
							}
	
							// Pagination load more
							function timeline_pagination() {
								var $container = $( ".k2t-blog-timeline" );
								$container.isotope({
									itemSelector : ".hentry"
								}); 
								$container.infinitescroll({
									navSelector: ".nav-seemore-inner", // selector for the paged navigation
									nextSelector: ".nav-seemore-inner a", // selector for the NEXT link (to page 2)
									itemSelector: ".hentry", // selector for all items you"ll retrieve
									loading: {
										finishedMsg: "No more pages to load.",
										img: "http://i.imgur.com/qkKy8.gif"
									}
								},
									function( newElements ) {
										$container.isotope( "appended", $( newElements ) );
										timeline_indicator();
									} 
								);
							}
	
							var container = document.querySelector(".k2t-blog-timeline");
							var msnry = new Masonry( container, {
								itemSelector: ".hentry",
								columnWidth: container.querySelector(".hentry")
							});
	
							msnry.on( "layoutComplete", function() {
								timeline_indicator();
								timeline_pagination();
							});
							// manually trigger initial layout
							msnry.layout();
						});
					</scr' . 'ipt>';
				}
	
				global $wp_scripts;
				$wp_scripts->scripts[] = 'k2t-inline-scripts';
			}
		}
		add_action( 'wp_footer', 'k2t_front_end_enqueue_inline_script', 10000 );
	endif;
	
	/**
	 * Enqueue stylesheet.
	 *
	 * @package Lincoln
	 * @author  LunarTheme
	 * @link    http://www.lunartheme.com
	 */
	
	/*--------------------------------------------------------------
		Custom CSS
	--------------------------------------------------------------*/
	if ( ! function_exists( 'adjustBrightness' ) ) {
		function adjustBrightness($hex, $steps) {
		    // Steps should be between -255 and 255. Negative = darker, positive = lighter
		    $steps = max(-255, min(255, $steps));

		    // Normalize into a six character long hex string
		    $hex = str_replace('#', '', $hex);
		    if (strlen($hex) == 3) {
		        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
		    }

		    // Split into three parts: R, G and B
		    $color_parts = str_split($hex, 2);
		    $return = '#';

		    foreach ($color_parts as $color) {
		        $color   = hexdec($color); // Convert to decimal
		        $color   = max(0,min(255,$color + $steps)); // Adjust color
		        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
		    }

		    return $return;
		}
	}
	

	if ( ! function_exists( 'k2t_front_end_enqueue_inline_css' ) ) {
		function k2t_front_end_enqueue_inline_css() {
			global $smof_data, $content_width; 
			?>
			<style>
				
				<?php
				/* Content width
				------------------------------------------------- */
				if ( ! empty( $smof_data['boxed-layout'] ) ) {
					echo '
						.boxed .k2t-container { max-width: ' . $smof_data['use-content-width'] . 'px; }
					';
				} else {
					if ( isset ( $smof_data['use-content-width'] ) ) {
						echo '
							.k2t-wrap, .container { max-width: ' . $smof_data['use-content-width'] . 'px; }
						';
					}
				}
				
				/* Show hide dot ":::" */

				if( isset( $smof_data['show_hide_dot'] ) && $smof_data['show_hide_dot'] == 0 ){
					echo '
						.widget #ld_course_info h4:after,
						.k2t-gallery-heading .gallery-title:after,
						.k2t-project-heading h2:before,
						.k2t-project-heading h2:after,
						.k2t-heading.has-border.two_dots .h:before,
						.k2t-heading.has-border.two_dots .h:after,
						.k2t-title-bar .main-title:after,
						.widget-title:after{
							display: none;
						}
					';
				}
				/* Body color */
				if( isset( $smof_data['body_color'] ) ){
					echo '
						.k2t-body{
							background: ' . $smof_data['body_color'] . ';
						}
					';
				}
				/* Sidebar width
				------------------------------------------------- */
				$sidebar_width = $smof_data['sidebar_width'];
				$page_sidebar_width = ( function_exists( 'get_field' ) ) ? get_field( 'page_sidebar_width', get_the_ID() ) : '';
				if ( is_page() && ! empty( $page_sidebar_width ) && $page_sidebar_width != 0 )  {
					if ( ! empty( $page_sidebar_width ) ) {
						echo '
							.k2t-sidebar, .k2t-sidebar-sub { width:' . $page_sidebar_width . '% !important; }
							.k2t-blog, .k2t-main { width:' . ( 100 - $page_sidebar_width ) . '% !important; }
						';
					}
				} else {
					if ( ! empty( $sidebar_width ) ) {
						echo '
							.k2t-sidebar, .k2t-sidebar-sub { width:' . $sidebar_width . '% !important; }
							.k2t-blog, .k2t-main {width:' . ( 100 - $sidebar_width ) . '% !important; }
						';
					}
				}

				// PRIMARY COLOR 
				if ( $smof_data['theme-primary-color'] == 'custom' ) :?>
				#close-canvas, .shop-cart .cart-control span, .mc4wp-form input[type=submit], .k2t-btt:hover,.wpcf7 #commentform input[type="submit"],.k2t-button a,.k2t-header-top, blockquote:before, q:before, .k2t-blog .post-item .more-link, .k2t-blog .cat-icon,.k2t_widget_recent_event .join-event,.teacher-listing.classic.no-border .social a:hover i, article[class*="course-"] .more-link, .more-link, .k2t-searchbox .mark, .k2t-blog .post-item .more-link:hover, .k2t-navigation ul li span.current,.k2t-footer .widget.social-widget ul li a:hover,.k2t-header-mid .k2t-menu li ul > li.current-menu-ancestor > a, .single-post-k-event .event-link, .single-post-k-course .course-link,.k2t-gallery-heading .filter-list li:after,.k2t-related-course .related-thumb a i, .teacher-listing.classic.has-border i, .project-fields .project-link,.widget #wp-calendar td#today, .widget #wp-calendar caption, .event-classic-item .more-link, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce-page #payment #place_order:hover, .shop-cart .shop-item .buttons .button:hover, .woocommerce table.wishlist_table .add_to_cart_button, .woocommerce div.product .single_add_to_cart_button:hover, .woocommerce div.product .single_add_to_cart_button:focus, .woocommerce div.product .single_add_to_cart_button, .k2t-page-topnav ul.menu > li > a:before, .event-listing-masonry .masonry-item .read-more, .owl-dots > div.active, .owl-nav > div > i:hover, .vc_tta.vc_tta-style-outline.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active a,.k2t-recent-event .event-info .read-more,.widget .tagcloud a:hover,button, input[type="button"], input[type="reset"], input[type="submit"],.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #payment #place_order, .shop-cart .shop-item .buttons .button, .event-isotope-filter li:after,.widget_categories > ul > .cat-item > a:before,.error404, .error404 .k2t-body, .teacher-connect table th,.woocommerce .woocommerce-pagination ul.page-numbers li .page-numbers.current, .widget_product_categories > ul > .cat-item > a:before,.woocommerce .widget_price_filter .price_slider_wrapper .ui-state-default, .woocommerce .widget_price_filter .price_slider_wrapper .ui-slider-range,.single-product-image-wrap #nav li.active, .entry-box .widget_tag_cloud .tagcloud a:hover, .about-author, .form-submit #submit,.single-footer-nav, #bbpress-forums li.bbp-header, .course-isotope-filter li:after{
					background: <?php echo $smof_data['primary-color']; ?>;
				}
				#commentform > p.focus input[type="text"], #commentform > p.focus input[type="email"],.k2t-footer .widget.social-widget ul li a:hover,
				.entry-box .widget_tag_cloud .tagcloud a:hover,#commentform > p.focus textarea, .teacher-listing.classic.has-border i, .owl-nav > div > i:hover, .widget .tagcloud a:hover{
					border-color: <?php echo $smof_data['primary-color']; ?>;
				}
				.widget-title > span{
					border-color: <?php echo $smof_data['link-hover-color']; ?>;
				}
				.k2t-iconbox.layout-4 .iconbox-icon i, .course-isotope-filter li, .b-medium-special.b-medium .k2t-blog .post-item header h2:hover a, .k2t-info .widget_nav_menu ul li a:hover, .k2t-page-topnav ul.menu > li.active > a, .k2t-btt,.event-isotope-filter li.active, .contact-info .vc_icon_element.vc_icon_element-outer .vc_icon_element-inner:hover .vc_icon_element-icon:before,.woocommerce .cart-collaterals .cart_totals table tr.order-total td, .woocommerce .b-action .cart-contents:hover,.b-action .yith-wcwl-add-to-wishlist a, .woocommerce-page .cart-collaterals .cart_totals table tr.order-total td, .k2t-gallery-heading .filter-list li.active, .k2t-gallery-heading .filter-list li:hover,.k2t-header-mid .k2t-menu > li.current-menu-item > a, .k2t-header-mid .k2t-menu > li.current-menu-parent > a, .k2t-header-mid .k2t-menu > li.current-menu-ancestor > a, .k2t-header-mid .search-box:hover,.k2t-heading.has-border.two_dots .h:before, .k2t-heading.has-border.two_dots .h:after,.widget ul li.current-cat a,.widget-title:after,.vc_toggle.vc_toggle_default .vc_toggle_title h4:hover, .k2t-footer .k2t-wrap .k2t-row > div a:hover{
					color: <?php echo $smof_data['primary-color']; ?> !important;
				}
				.k2t-header-mid .k2t-menu > li:hover a,
				.k2t-header-mid .k2t-menu > li.current-menu-item > a, 
				.k2t-header-mid .k2t-menu > li.current-menu-parent > a, 
				.k2t-header-mid .k2t-menu > li.current-menu-ancestor > a,
				.k2t-header-mid .k2t-menu > li > a:hover {
					border-bottom-color: <?php echo $smof_data['primary-color'];?>;
				}
				#commentform > p.focus input[type="text"],
				#commentform > p.focus input[type="email"],
				#commentform > p.focus textarea {
					border-bottom: 3px solid <?php echo $smof_data['primary-color'];?>;
				}

				.k2t-gallery-shortcode .view .mask {
					background: rgba(33, 150, 243, 0.95);
				}

				<?php endif;
				/* Logo margin
				------------------------------------------------- */
				if ( isset ( $smof_data['logo-margin-top'] ) || isset ( $smof_data['logo-margin-left'] ) || isset ( $smof_data['logo-margin-right'] ) || isset ( $smof_data['logo-margin-bottom'] ) ) {
					echo '
						.k2t-logo { margin-top: ' . $smof_data['logo-margin-top'] . 'px;margin-left: ' . $smof_data['logo-margin-left'] . 'px;margin-right: ' . $smof_data['logo-margin-right'] . 'px;margin-bottom: ' . $smof_data['logo-margin-bottom'] . 'px; }
					';
				}
	
				/* Global color scheme
				------------------------------------------------- */
				if ( $smof_data['heading-color'] || $smof_data['heading-font'] ) {
					echo '
						h1, h2, h3, h4, h1 *, h2 *, h3 *, h4 * { color: ' . $smof_data['heading-color'] . '; font-family: ' . $smof_data['heading-font'] . '; }
					';
				}
				if ( $smof_data['text-color'] ) {
					echo '
						body, button, input, select, textarea { color: ' . $smof_data['text-color'] . '; }
					';
				}
				if ( $smof_data['footer-background-color'] || $smof_data['footer-color'] ) {
					echo '
						/*.k2t-footer .k2t-bottom, .k2t-footer .k2t-bottom * { background-color: ' . $smof_data['footer-background-color'] . ';color: ' . $smof_data['footer-color'] . '; }*/
						.k2t-footer .widget { color: ' . $smof_data['footer-color'] . '; }
					';
				}
				if ( $smof_data['footer-link-color'] ) {
					echo '
						.k2t-footer a { color: ' . $smof_data['footer-link-color'] . '; }
					';
				}
	
				if ( $smof_data['link-color'] ) {
					echo '
						a { color: ' . $smof_data['link-color'] . '; }
					';
				}
				if ( $smof_data['link-hover-color'] ) {
					echo '
						a:hover, a:focus,
						.k2t-header-mid .k2t-menu > li:hover a, 
						.k2t-header-mid .k2t-menu > li > a:hover, 
						.k2t-header-mid .k2t-menu > li.current-menu-item > a, 
						.k2t-header-mid .k2t-menu > li.current-menu-parent > a, 
						.k2t-header-mid .k2t-menu > li.current-menu-ancestor > a 
						{ color: ' . $smof_data['link-hover-color'] . '!important; }
					';
				}
	
				if ( $smof_data['main-menu-color'] ) {
					echo '
						.k2t-header-mid .k2t-menu li a{ 
							color: ' . $smof_data['main-menu-color'] . '!important; 
						}
					';
				}
				if ( $smof_data['sub-menu-color'] ) {
					echo '
						.k2t-header-mid .k2t-menu li ul li a span::before,
						.k2t-header-mid .k2t-menu > li:hover a{ color: ' . $smof_data['sub-menu-color'] . ' !important; }
					';
				}
				
				/* Typography
				------------------------------------------------- */
				if ( $smof_data['body-font'] || $smof_data['body-size'] ) {
					echo '
						body { font-family: ' . $smof_data['body-font'] . '; font-size: ' . $smof_data['body-size'] . 'px; }
					';
				}
				if ( $smof_data['mainnav-font'] || $smof_data['mainnav-size'] ) {
					echo '
						.k2t-header-mid .k2t-menu, .k2t-header .k2t-menu .mega-container ul, .vertical-menu .k2t-header-mid .k2t-menu { font-family: ' . $smof_data['mainnav-font'] . '; font-size: ' . $smof_data['mainnav-size'] . 'px; }
					';
				}
				if ( $smof_data['mainnav-text-transform'] ) {
					echo '
						.k2t-header-mid .k2t-menu > li > a { text-transform: ' . $smof_data['mainnav-text-transform'] . '; }
					';
				}
				if ( $smof_data['mainnav-font-weight'] ) {
					echo '
						.k2t-header-mid .k2t-menu > li > a { font-weight: ' . $smof_data['mainnav-font-weight'] . '; }
					';
				}
				if ( $smof_data['h1-size'] || $smof_data['h2-size'] || $smof_data['h3-size'] || $smof_data['h4-size'] || $smof_data['h5-size'] || $smof_data['h6-size'] ) {
					echo '
						h1 { font-size: ' . $smof_data['h1-size'] . 'px; }
						h2 { font-size: ' . $smof_data['h2-size'] . 'px; }
						h3 { font-size: ' . $smof_data['h3-size'] . 'px; }
						h4 { font-size: ' . $smof_data['h4-size'] . 'px; }
						h5 { font-size: ' . $smof_data['h5-size'] . 'px; }
						h6 { font-size: ' . $smof_data['h6-size'] . 'px; }
					';
				}
				if ( $smof_data['submenu-mainnav-size'] ) {
					echo '
						.k2t-header-mid .k2t-menu .sub-menu { font-size: ' . $smof_data['submenu-mainnav-size'] . 'px; }
					';
				}
			
				/* Custom CSS
				------------------------------------------------- */
				if ( isset ( $smof_data['custom_css'] ) ) {
					$custom_css = $smof_data['custom_css'];
					echo $custom_css;
				}
	
				?>
	
				/* Primary color
				------------------------------------------------- */
				
	
			</style>	
		<?php }
		add_action( 'wp_head','k2t_front_end_enqueue_inline_css' );
	}
	
	/*--------------------------------------------------------------
		Enqueue theme style
	--------------------------------------------------------------*/
	if ( ! function_exists( 'k2t_enqueue_theme_style' ) ) {
		function k2t_enqueue_theme_style() {
			global $wp_styles, $smof_data;
	
			
		}
		add_action( 'wp_enqueue_scripts', 'k2t_enqueue_theme_style' );
	}
	
	/*--------------------------------------------------------------
		Enqueue google fonts
	--------------------------------------------------------------*/
	if ( ! function_exists( 'k2t_enqueue_google_fonts' ) ) {
		function k2t_enqueue_google_fonts() {
			global $wp_styles, $smof_data;
			
			$protocol = is_ssl() ? 'https' : 'http';
			if ( isset ( $smof_data['body-font'] ) && in_array ( $smof_data['body-font'], k2t_google_fonts() ) ) {
				$body_font = $smof_data['body-font'];
				wp_enqueue_style( 'k2t-google-font-' . str_replace( ' ','-',$body_font ), "$protocol://fonts.googleapis.com/css?family=" . str_replace(' ','+', $body_font ) . ":100,200,300,400,500,600,700,800,900&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese" );
			}
			
			if ( isset ( $smof_data['heading-font'] ) && in_array ( $smof_data['heading-font'], k2t_google_fonts() ) ) {
				$heading_font = $smof_data['heading-font'];		
				wp_enqueue_style( 'k2t-google-font-' . str_replace( ' ','-',$heading_font ), "$protocol://fonts.googleapis.com/css?family=" . str_replace(' ','+', $heading_font ) . ":100,200,300,400,500,600,700,800,900&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese" );
			}
			
			if ( isset ( $smof_data['mainnav-font'] ) && in_array ( $smof_data['mainnav-font'], k2t_google_fonts() ) ) {
				$mainnav_font = $smof_data['mainnav-font'];		
				wp_enqueue_style( 'k2t-google-font-' . str_replace( ' ','-',$mainnav_font ), "$protocol://fonts.googleapis.com/css?family=" . str_replace(' ','+', $mainnav_font ) . ":100,200,300,400,500,600,700,800,900&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese" );
			}
		}
		add_action( 'wp_enqueue_scripts', 'k2t_enqueue_google_fonts' );
	}

}

// Hooks on Back-end
else{
	
	/**
	 * Removes tabs such as the "Design Options" from the Visual Composer Settings
	 *
	 * @package Lincoln
	 */
	if ( class_exists( 'Vc_Manager' ) ) :
		vc_set_as_theme( true );
	endif;
	
	/*-------------------------------------------------------------------
		Map for Visual Composer Shortcode.
	--------------------------------------------------------------------*/
	if ( class_exists( 'Vc_Manager' ) ) :
		if ( ! function_exists( 'k2t_vc_map_shortcodes' ) ) :
	
			function k2t_vc_map_shortcodes() {

				// Include plugin.php
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
				$k2t_icon = array( '', 'fa fa-glass', 'fa fa-music', 'fa fa-search', 'fa fa-envelope-o', 'fa fa-heart', 'fa fa-star', 'fa fa-star-o', 'fa fa-user', 'fa fa-film', 'fa fa-th-large', 'fa fa-th', 'fa fa-th-list', 'fa fa-check', 'fa fa-remove', 'fa fa-close', 'fa fa-times', 'fa fa-search-plus', 'fa fa-search-minus', 'fa fa-power-off', 'fa fa-signal', 'fa fa-gear', 'fa fa-cog', 'fa fa-trash-o', 'fa fa-home', 'fa fa-file-o', 'fa fa-clock-o', 'fa fa-road', 'fa fa-download', 'fa fa-arrow-circle-o-down', 'fa fa-arrow-circle-o-up', 'fa fa-inbox', 'fa fa-play-circle-o', 'fa fa-rotate-right', 'fa fa-repeat', 'fa fa-refresh', 'fa fa-list-alt', 'fa fa-lock', 'fa fa-flag', 'fa fa-headphones', 'fa fa-volume-off', 'fa fa-volume-down', 'fa fa-volume-up', 'fa fa-qrcode', 'fa fa-barcode', 'fa fa-tag', 'fa fa-tags', 'fa fa-book', 'fa fa-bookmark', 'fa fa-print', 'fa fa-camera', 'fa fa-font', 'fa fa-bold', 'fa fa-italic', 'fa fa-text-height', 'fa fa-text-width', 'fa fa-align-left', 'fa fa-align-center', 'fa fa-align-right', 'fa fa-align-justify', 'fa fa-list', 'fa fa-dedent', 'fa fa-outdent', 'fa fa-indent', 'fa fa-video-camera', 'fa fa-photo', 'fa fa-image', 'fa fa-picture-o', 'fa fa-pencil', 'fa fa-map-marker', 'fa fa-adjust', 'fa fa-tint', 'fa fa-edit', 'fa fa-pencil-square-o', 'fa fa-share-square-o', 'fa fa-check-square-o', 'fa fa-arrows', 'fa fa-step-backward', 'fa fa-fast-backward', 'fa fa-backward', 'fa fa-play', 'fa fa-pause', 'fa fa-stop', 'fa fa-forward', 'fa fa-fast-forward', 'fa fa-step-forward', 'fa fa-eject', 'fa fa-chevron-left', 'fa fa-chevron-right', 'fa fa-plus-circle', 'fa fa-minus-circle', 'fa fa-times-circle', 'fa fa-check-circle', 'fa fa-question-circle', 'fa fa-info-circle', 'fa fa-crosshairs', 'fa fa-times-circle-o', 'fa fa-check-circle-o', 'fa fa-ban', 'fa fa-arrow-left', 'fa fa-arrow-right', 'fa fa-arrow-up', 'fa fa-arrow-down', 'fa fa-mail-forward', 'fa fa-share', 'fa fa-expand', 'fa fa-compress', 'fa fa-plus', 'fa fa-minus', 'fa fa-asterisk', 'fa fa-exclamation-circle', 'fa fa-gift', 'fa fa-leaf', 'fa fa-fire', 'fa fa-eye', 'fa fa-eye-slash', 'fa fa-warning', 'fa fa-exclamation-triangle', 'fa fa-plane', 'fa fa-calendar', 'fa fa-random', 'fa fa-comment', 'fa fa-magnet', 'fa fa-chevron-up', 'fa fa-chevron-down', 'fa fa-retweet', 'fa fa-shopping-cart', 'fa fa-folder', 'fa fa-folder-open', 'fa fa-arrows-v', 'fa fa-arrows-h', 'fa fa-bar-chart-o', 'fa fa-bar-chart', 'fa fa-twitter-square', 'fa fa-facebook-square', 'fa fa-camera-retro', 'fa fa-key', 'fa fa-gears', 'fa fa-cogs', 'fa fa-comments', 'fa fa-thumbs-o-up', 'fa fa-thumbs-o-down', 'fa fa-star-half', 'fa fa-heart-o', 'fa fa-sign-out', 'fa fa-linkedin-square', 'fa fa-thumb-tack', 'fa fa-external-link', 'fa fa-sign-in', 'fa fa-trophy', 'fa fa-github-square', 'fa fa-upload', 'fa fa-lemon-o', 'fa fa-phone', 'fa fa-square-o', 'fa fa-bookmark-o', 'fa fa-phone-square', 'fa fa-twitter', 'fa fa-facebook', 'fa fa-github', 'fa fa-unlock', 'fa fa-credit-card', 'fa fa-rss', 'fa fa-hdd-o', 'fa fa-bullhorn', 'fa fa-bell', 'fa fa-certificate', 'fa fa-hand-o-right', 'fa fa-hand-o-left', 'fa fa-hand-o-up', 'fa fa-hand-o-down', 'fa fa-arrow-circle-left', 'fa fa-arrow-circle-right', 'fa fa-arrow-circle-up', 'fa fa-arrow-circle-down', 'fa fa-globe', 'fa fa-wrench', 'fa fa-tasks', 'fa fa-filter', 'fa fa-briefcase', 'fa fa-arrows-alt', 'fa fa-group', 'fa fa-users', 'fa fa-chain', 'fa fa-link', 'fa fa-cloud', 'fa fa-flask', 'fa fa-cut', 'fa fa-scissors', 'fa fa-copy', 'fa fa-files-o', 'fa fa-paperclip', 'fa fa-save', 'fa fa-floppy-o', 'fa fa-square', 'fa fa-navicon', 'fa fa-reorder', 'fa fa-bars', 'fa fa-list-ul', 'fa fa-list-ol', 'fa fa-strikethrough', 'fa fa-underline', 'fa fa-table', 'fa fa-magic', 'fa fa-truck', 'fa fa-pinterest', 'fa fa-pinterest-square', 'fa fa-google-plus-square', 'fa fa-google-plus', 'fa fa-money', 'fa fa-caret-down', 'fa fa-caret-up', 'fa fa-caret-left', 'fa fa-caret-right', 'fa fa-columns', 'fa fa-unsorted', 'fa fa-sort', 'fa fa-sort-down', 'fa fa-sort-desc', 'fa fa-sort-up', 'fa fa-sort-asc', 'fa fa-envelope', 'fa fa-linkedin', 'fa fa-rotate-left', 'fa fa-undo', 'fa fa-legal', 'fa fa-gavel', 'fa fa-dashboard', 'fa fa-tachometer', 'fa fa-comment-o', 'fa fa-comments-o', 'fa fa-flash', 'fa fa-bolt', 'fa fa-sitemap', 'fa fa-umbrella', 'fa fa-paste', 'fa fa-clipboard', 'fa fa-lightbulb-o', 'fa fa-exchange', 'fa fa-cloud-download', 'fa fa-cloud-upload', 'fa fa-user-md', 'fa fa-stethoscope', 'fa fa-suitcase', 'fa fa-bell-o', 'fa fa-coffee', 'fa fa-cutlery', 'fa fa-file-text-o', 'fa fa-building-o', 'fa fa-hospital-o', 'fa fa-ambulance', 'fa fa-medkit', 'fa fa-fighter-jet', 'fa fa-beer', 'fa fa-h-square', 'fa fa-plus-square', 'fa fa-angle-double-left', 'fa fa-angle-double-right', 'fa fa-angle-double-up', 'fa fa-angle-double-down', 'fa fa-angle-left', 'fa fa-angle-right', 'fa fa-angle-up', 'fa fa-angle-down', 'fa fa-desktop', 'fa fa-laptop', 'fa fa-tablet', 'fa fa-mobile-phone', 'fa fa-mobile', 'fa fa-circle-o', 'fa fa-quote-left', 'fa fa-quote-right', 'fa fa-spinner', 'fa fa-circle', 'fa fa-mail-reply', 'fa fa-reply', 'fa fa-github-alt', 'fa fa-folder-o', 'fa fa-folder-open-o', 'fa fa-smile-o', 'fa fa-frown-o', 'fa fa-meh-o', 'fa fa-gamepad', 'fa fa-keyboard-o', 'fa fa-flag-o', 'fa fa-flag-checkered', 'fa fa-terminal', 'fa fa-code', 'fa fa-mail-reply-all', 'fa fa-reply-all', 'fa fa-star-half-empty', 'fa fa-star-half-full', 'fa fa-star-half-o', 'fa fa-location-arrow', 'fa fa-crop', 'fa fa-code-fork', 'fa fa-unlink', 'fa fa-chain-broken', 'fa fa-question', 'fa fa-info', 'fa fa-exclamation', 'fa fa-superscript', 'fa fa-subscript', 'fa fa-eraser', 'fa fa-puzzle-piece', 'fa fa-microphone', 'fa fa-microphone-slash', 'fa fa-shield', 'fa fa-calendar-o', 'fa fa-fire-extinguisher', 'fa fa-rocket', 'fa fa-maxcdn', 'fa fa-chevron-circle-left', 'fa fa-chevron-circle-right', 'fa fa-chevron-circle-up', 'fa fa-chevron-circle-down', 'fa fa-html5', 'fa fa-css3', 'fa fa-anchor', 'fa fa-unlock-alt', 'fa fa-bullseye', 'fa fa-ellipsis-h', 'fa fa-ellipsis-v', 'fa fa-rss-square', 'fa fa-play-circle', 'fa fa-ticket', 'fa fa-minus-square', 'fa fa-minus-square-o', 'fa fa-level-up', 'fa fa-level-down', 'fa fa-check-square', 'fa fa-pencil-square', 'fa fa-external-link-square', 'fa fa-share-square', 'fa fa-compass', 'fa fa-toggle-down', 'fa fa-caret-square-o-down', 'fa fa-toggle-up', 'fa fa-caret-square-o-up', 'fa fa-toggle-right', 'fa fa-caret-square-o-right', 'fa fa-euro', 'fa fa-eur', 'fa fa-gbp', 'fa fa-dollar', 'fa fa-usd', 'fa fa-rupee', 'fa fa-inr', 'fa fa-cny', 'fa fa-rmb', 'fa fa-yen', 'fa fa-jpy', 'fa fa-ruble', 'fa fa-rouble', 'fa fa-rub', 'fa fa-won', 'fa fa-krw', 'fa fa-bitcoin', 'fa fa-btc', 'fa fa-file', 'fa fa-file-text', 'fa fa-sort-alpha-asc', 'fa fa-sort-alpha-desc', 'fa fa-sort-amount-asc', 'fa fa-sort-amount-desc', 'fa fa-sort-numeric-asc', 'fa fa-sort-numeric-desc', 'fa fa-thumbs-up', 'fa fa-thumbs-down', 'fa fa-youtube-square', 'fa fa-youtube', 'fa fa-xing', 'fa fa-xing-square', 'fa fa-youtube-play', 'fa fa-dropbox', 'fa fa-stack-overflow', 'fa fa-instagram', 'fa fa-flickr', 'fa fa-adn', 'fa fa-bitbucket', 'fa fa-bitbucket-square', 'fa fa-tumblr', 'fa fa-tumblr-square', 'fa fa-long-arrow-down', 'fa fa-long-arrow-up', 'fa fa-long-arrow-left', 'fa fa-long-arrow-right', 'fa fa-apple', 'fa fa-windows', 'fa fa-android', 'fa fa-linux', 'fa fa-dribbble', 'fa fa-skype', 'fa fa-foursquare', 'fa fa-trello', 'fa fa-female', 'fa fa-male', 'fa fa-gittip', 'fa fa-sun-o', 'fa fa-moon-o', 'fa fa-archive', 'fa fa-bug', 'fa fa-vk', 'fa fa-weibo', 'fa fa-renren', 'fa fa-pagelines', 'fa fa-stack-exchange', 'fa fa-arrow-circle-o-right', 'fa fa-arrow-circle-o-left', 'fa fa-toggle-left', 'fa fa-caret-square-o-left', 'fa fa-dot-circle-o', 'fa fa-wheelchair', 'fa fa-vimeo-square', 'fa fa-turkish-lira', 'fa fa-try', 'fa fa-plus-square-o', 'fa fa-space-shuttle', 'fa fa-slack', 'fa fa-envelope-square', 'fa fa-wordpress', 'fa fa-openid', 'fa fa-institution', 'fa fa-bank', 'fa fa-university', 'fa fa-mortar-board', 'fa fa-graduation-cap', 'fa fa-yahoo', 'fa fa-google', 'fa fa-reddit', 'fa fa-reddit-square', 'fa fa-stumbleupon-circle', 'fa fa-stumbleupon', 'fa fa-delicious', 'fa fa-digg', 'fa fa-pied-piper', 'fa fa-pied-piper-alt', 'fa fa-drupal', 'fa fa-joomla', 'fa fa-language', 'fa fa-fax', 'fa fa-building', 'fa fa-child', 'fa fa-paw', 'fa fa-spoon', 'fa fa-cube', 'fa fa-cubes', 'fa fa-behance', 'fa fa-behance-square', 'fa fa-steam', 'fa fa-steam-square', 'fa fa-recycle', 'fa fa-automobile', 'fa fa-car', 'fa fa-cab', 'fa fa-taxi', 'fa fa-tree', 'fa fa-spotify', 'fa fa-deviantart', 'fa fa-soundcloud', 'fa fa-database', 'fa fa-file-pdf-o', 'fa fa-file-word-o', 'fa fa-file-excel-o', 'fa fa-file-powerpoint-o', 'fa fa-file-photo-o', 'fa fa-file-picture-o', 'fa fa-file-image-o', 'fa fa-file-zip-o', 'fa fa-file-archive-o', 'fa fa-file-sound-o', 'fa fa-file-audio-o', 'fa fa-file-movie-o', 'fa fa-file-video-o', 'fa fa-file-code-o', 'fa fa-vine', 'fa fa-codepen', 'fa fa-jsfiddle', 'fa fa-life-bouy', 'fa fa-life-buoy', 'fa fa-life-saver', 'fa fa-support', 'fa fa-life-ring', 'fa fa-circle-o-notch', 'fa fa-ra', 'fa fa-rebel', 'fa fa-ge', 'fa fa-empire', 'fa fa-git-square', 'fa fa-git', 'fa fa-hacker-news', 'fa fa-tencent-weibo', 'fa fa-qq', 'fa fa-wechat', 'fa fa-weixin', 'fa fa-send', 'fa fa-paper-plane', 'fa fa-send-o', 'fa fa-paper-plane-o', 'fa fa-history', 'fa fa-circle-thin', 'fa fa-header', 'fa fa-paragraph', 'fa fa-sliders', 'fa fa-share-alt', 'fa fa-share-alt-square', 'fa fa-bomb', 'fa fa-soccer-ball-o', 'fa fa-futbol-o', 'fa fa-tty', 'fa fa-binoculars', 'fa fa-plug', 'fa fa-slideshare', 'fa fa-twitch', 'fa fa-yelp', 'fa fa-newspaper-o', 'fa fa-wifi', 'fa fa-calculator', 'fa fa-paypal', 'fa fa-google-wallet', 'fa fa-cc-visa', 'fa fa-cc-mastercard', 'fa fa-cc-discover', 'fa fa-cc-amex', 'fa fa-cc-paypal', 'fa fa-cc-stripe', 'fa fa-bell-slash', 'fa fa-bell-slash-o', 'fa fa-trash', 'fa fa-copyright', 'fa fa-at', 'fa fa-eyedropper', 'fa fa-paint-brush', 'fa fa-birthday-cake', 'fa fa-area-chart', 'fa fa-pie-chart', 'fa fa-line-chart', 'fa fa-lastfm', 'fa fa-lastfm-square', 'fa fa-toggle-off', 'fa fa-toggle-on', 'fa fa-bicycle', 'fa fa-bus', 'fa fa-ioxhost', 'fa fa-angellist', 'fa fa-cc', 'fa fa-shekel', 'fa fa-sheqel', 'fa fa-ils', 'fa fa-meanpath' );
				sort( $k2t_icon );
				trim( join( 'fa ', $k2t_icon ) );
	
				$k2t_margin_top = array(
					'param_name'  => 'mgt',
					'heading'     => __( 'Margin Top', 'k2t' ),
					'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
					'type'        => 'textfield',
				);
				$k2t_margin_right = array(
					'param_name'  => 'mgr',
					'heading'     => __( 'Margin Right', 'k2t' ),
					'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
					'type'        => 'textfield',
				);
				$k2t_margin_bottom = array(
					'param_name'  => 'mgb',
					'heading'     => __( 'Margin Bottom', 'k2t' ),
					'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
					'type'        => 'textfield',
				);
				$k2t_margin_left = array(
					'param_name'  => 'mgl',
					'heading'     => __( 'Margin Left', 'k2t' ),
					'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
					'type'        => 'textfield',
				);
				$k2t_id = array(
					'param_name'  => 'id',
					'heading'     => __( 'ID', 'k2t' ),
					'description' => __( '(Optional) Enter a unique ID.', 'k2t' ),
					'type'        => 'textfield',
				);
				$k2t_class = array(
					'param_name'  => 'class',
					'heading'     => __( 'Class', 'k2t' ),
					'description' => __( '(Optional) Enter a unique class name.', 'k2t' ),
					'type'        => 'textfield',
				);
				$k2t_animation = array(
					'param_name' => 'anm',
					'heading' 	 => __( 'Enable Animation', 'k2t' ),
					'type' 		 => 'checkbox',
					'value'      => array(
						'' => true
					)
				);
				$k2t_animation_name = array(
					'param_name' => 'anm_name',
					'heading' 	 => __( 'Animation', 'k2t' ),
					'type' 		 => 'dropdown',
					'dependency' => array(
						'element' => 'anm',
						'value'   => array( '1' ),
						'not_empty' => false,
					),
					'value'      => array( 'bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'flip', 'flipInX', 'flipInY', 'lightSpeedIn', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'rollIn', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp' ),
				);
				$k2t_animation_delay = array(
					'param_name'  => 'anm_delay',
					'heading'     => __( 'Animation Delay', 'k2t' ),
					'description' => __( 'Numeric value only, 1000 = 1second.', 'k2t' ),
					'type'        => 'textfield',
					'std'		  => '2000',
					'dependency' => array(
						'element' => 'anm',
						'value'   => array( '1' ),
						'not_empty' => false,
					),
				);
	
				/*  [ Row ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_row', array(
						'name'        => __( 'Row', 'k2t' ),
						'icon'        => 'fa fa-tasks',
						'category'    => __( 'Structure', 'k2t' ),
						'description' => '',
					)
				);	

				/*  [ Posts Slider ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_posts_slider', array(
						'name'        => __( 'Posts Slider', 'k2t' ),
						'icon'        => 'fa fa-refresh',
						'category'    => __( 'Content', 'k2t' ),
						'description' => '',
					)
				);

				/*  [ Flickr Widget ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_flickr', array(
						'name'        => __( 'Flickr Widget', 'k2t' ),
						'icon'        => 'fa fa-flickr',
						'category'    => __( 'Content', 'k2t' ),
						'description' => '',
					)
				);


				/*  [ Masonry Media Grid ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_masonry_media_grid', array(
						'name'        => __( 'Masonry Media Grid', 'k2t' ),
						'icon'        => 'fa fa-th',
						'category'    => __( 'Content', 'k2t' ),
						'description' => '',
					)
				);


				/*  [ Revolution Slider ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'rev_slider_vc', array(
						'name'        => __( 'Revolution Slider', 'k2t' ),
						'icon'        => 'fa fa-refresh',
						'category'    => __( 'Content', 'k2t' ),
						'description' => '',
					)
				);
				
				/*  [ Featured products ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'featured_products', array(
						'name'        => __( 'Featured products', 'k2t' ),
						'icon'        => 'fa fa-star',
						'category'    => __( 'WooCommerce', 'k2t' ),
						'description' => '',
					)
				);

				/*  [ Recent products ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'recent_products', array(
						'name'        => __( 'Recent products', 'k2t' ),
						'icon'        => 'fa fa-clock-o',
						'category'    => __( 'WooCommerce', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ Column ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_column', array(
						'name'        => __( 'Row', 'k2t' ),
						'icon'        => 'fa fa-tasks',
						'category'    => __( 'Structure', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Tabs]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_tabs', array(
						'name'        => __( 'Tabs', 'k2t' ),
						'icon'        => 'fa fa-folder',
						'category'    => __( 'Content', 'k2t' ),
						'description' => '',
					)
				);
				
				/*  [ VC Vertical tab ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_tour', array(
						'name'        => __( 'Vertical tabs', 'k2t' ),
						'icon'        => 'fa fa-list-ul',
						'category'    => __( 'Structure', 'k2t' ),
						'description' => '',
					)
				);
				
	
				/*  [ VC Tab]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_tab', array(
						'name'        => __( 'Text Block', 'k2t' ),
						'icon'        => 'fa fa-text-height',
						'category'    => __( 'Content', 'k2t' ),
						'description' => '',
					)
				);
				
	
				/*  [ VC Column Text ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_column_text', array(
						'name'        => __( 'Text Block', 'k2t' ),
						'icon'        => 'fa fa-text-height',
						'category'    => __( 'Content', 'k2t' ),
						'description' => '',
					)
				);
				
	
				/*  [ VC Separator ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_separator', array(
						'name'        => __( 'Separator', 'k2t' ),
						'icon'        => 'fa fa-minus',
						'category'    => __( 'Structure', 'k2t' ),
						'description' => '',
					)
				);
				
				/*  [ VC Separator With Text ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_text_separator', array(
						'name'        => __( 'Separator with text', 'k2t' ),
						'icon'        => 'fa fa-text-width',
						'category'    => __( 'Structure', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Message Box ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_message', array(
						'name'        => __( 'Message box', 'k2t' ),
						'icon'        => 'fa fa-file-text-o',
						'category'    => __( 'Content', 'k2t' ),
						'description' => '',
					)
				);
				
				/*  [ VC Facebook ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_facebook', array(
						'name'        => __( 'Facebook like', 'k2t' ),
						'icon'        => 'fa fa-facebook',
						'category'    => __( 'Socials', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Tweetmeme ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_tweetmeme', array(
						'name'        => __( 'Tweetmeme', 'k2t' ),
						'icon'        => 'fa fa-twitter',
						'category'    => __( 'Socials', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Google Plus ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_googleplus', array(
						'name'        => __( 'Google Plus', 'k2t' ),
						'icon'        => 'fa fa-google-plus',
						'category'    => __( 'Socials', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Pinterest ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_pinterest', array(
						'name'        => __( 'Pinterest', 'k2t' ),
						'icon'        => 'fa fa-pinterest',
						'category'    => __( 'Socials', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Single Image ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_single_image', array(
						'name'        => __( 'Single Image', 'k2t' ),
						'icon'        => 'fa fa-image',
						'category'    => __( 'Content', 'k2t' ),
						'description' => '',
					)
				);
				
	
				/*  [ VC Gallery ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_gallery', array(
						'name'        => __( 'Gallery', 'k2t' ),
						'icon'        => 'fa fa-caret-square-o-right',
						'category'    => __( 'Media', 'k2t' ),
						'description' => '',
					)
				);
				
	
				/*  [ VC Carousel ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_images_carousel', array(
						'name'        => __( 'Carousel', 'k2t' ),
						'icon'        => 'fa fa-exchange',
						'category'    => __( 'Media', 'k2t' ),
						'description' => '',
					)
				);
				
	
				/*  [ VC Toggle ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_toggle', array(
						'name'        => __( 'Toggles', 'k2t' ),
						'icon'        => 'fa fa-indent',
						'category'    => __( 'Structure', 'k2t' ),
						'description' => '',
					)
				);
				
	
				/*  [ VC Video ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_video', array(
						'name'        => __( 'Video', 'k2t' ),
						'icon'        => 'fa fa-video-camera',
						'category'    => __( 'Media', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Raw HTML ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_raw_html', array(
						'name'        => __( 'Raw HTML code', 'k2t' ),
						'icon'        => 'fa fa-code',
						'category'    => __( 'Structure', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Raw JS ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_raw_js', array(
						'name'        => __( 'Raw JS code', 'k2t' ),
						'icon'        => 'fa fa-code',
						'category'    => __( 'Structure', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Empty Space ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_empty_space', array(
						'name'        => __( 'Empty Space', 'k2t' ),
						'icon'        => 'fa fa-arrows-v',
						'category'    => __( 'Structure', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC Custom Heading ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_custom_heading', array(
						'name'        => __( 'Custom Heading', 'k2t' ),
						'icon'        => 'fa fa-header',
						'category'    => __( 'Typography', 'k2t' ),
						'description' => '',
					)
				);
				
				/*  [ VC WP Search ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_search', array(
						'name'        => __( 'WP Search', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP Meta ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_meta', array(
						'name'        => __( 'WP Meta', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP recent comments ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_recentcomments', array(
						'name'        => __( 'WP Recent Comments', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP calendar ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_calendar', array(
						'name'        => __( 'WP Calendar', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP pages ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_pages', array(
						'name'        => __( 'WP Pages', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP Tagcloud ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_tagcloud', array(
						'name'        => __( 'WP Tagcloud', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP custom menu ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_custommenu', array(
						'name'        => __( 'WP Custom Menu', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP text ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_text', array(
						'name'        => __( 'WP Text', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP posts ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_posts', array(
						'name'        => __( 'WP Posts', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP categories ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_categories', array(
						'name'        => __( 'WP Categories', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP archives ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_archives', array(
						'name'        => __( 'WP Archives', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ VC WP rss ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'vc_wp_rss', array(
						'name'        => __( 'WP RSS', 'k2t' ),
						'icon'        => 'fa fa-wordpress',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
	
				/*  [ Contact form 7 ]
				- - - - - - - - - - - - - - - - - - - */
				vc_map_update(
					'contact-form-7', array(
						'name'        => __( 'Contact Form 7', 'k2t' ),
						'icon'        => 'fa fa-envelope',
						'category'    => __( 'WordPress', 'k2t' ),
						'description' => '',
					)
				);
				/*  [ Lincoln Register ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_register_shortcodes = array(
					'base'            => 'register',
					'name'            => __( 'Lincoln register', 'k2t' ),
					'icon'            => 'fa fa-photo',
					'category'        => __( 'Lincoln Shortcode', 'k2t' ),
					'params'          => array(
						array(
							'param_name'  => 'title',
							'heading'     => __( 'Register Title', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'website',
							'heading'     => __( 'website', 'k2t' ),
							'type'        => 'checkbox',
							'value'		  => array(
								'' 	=> 'true',
								),
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'first_name',
							'heading'     => __( 'First name', 'k2t' ),
							'type'        => 'checkbox',
							'value'		  => array(
								'' 	=> 'true',
								),
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'last_name',
							'heading'     => __( 'Last name', 'k2t' ),
							'type'        => 'checkbox',
							'value'		  => array(
								'' 	=> 'true',
								),
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'bio',
							'heading'     => __( 'bio', 'k2t' ),
							'type'        => 'checkbox',
							'value'		  => array(
								'' 	=> 'true',
								),
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'submit',
							'heading'     => __( 'Text on submit button', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
						),

						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
					)
				);
				vc_map( $k2t_register_shortcodes );
				
				/*  [ Brands ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_brands = array(
					'base'            => 'brands',
					'name'            => __( 'Brands', 'k2t' ),
					'icon'            => 'fa fa-photo',
					'category'        => __( 'Content', 'k2t' ),
					'as_parent'       => array( 'only' => 'brand' ),
					'content_element' => true,
					'js_view'         => 'VcColumnView',
					'params'          => array(
						array(
							'param_name'  => 'column',
							'heading' 	  => __( 'Column', 'k2t' ),
							'description' => __( 'Select column display brand', 'k2t'),
							'type' 		  => 'dropdown',
							'value'       => array( '1', '2', '3', '4', '5', '6', '7', '8' ),
						),
						array(
							'param_name'  => 'padding',
							'heading'     => __( 'Padding', 'k2t' ),
							'description' => __( 'If you select true, it will be padding between item', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => 'true',
							)
						),
						array(
							'param_name'  => 'grayscale',
							'heading'     => __( 'Grayscale', 'k2t' ),
							'description' => __( 'Display grayscale.', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => 'true'
							)
						),
						$k2t_id, $k2t_class
					)
				);
				vc_map( $k2t_brands );
	
				/*  [ Brand Items ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_brands_item = array(
					'base'            => 'brand',
					'name'            => __( 'Brands Item', 'k2t' ),
					'icon'            => 'fa fa-photo',
					'category'        => __( 'Content', 'k2t' ),
					'as_child'        => array( 'only' => 'brands' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'title',
							'heading'     => __( 'Brand Title', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'tooltip',
							'heading'     => __( 'Tooltip', 'k2t' ),
							'description' => __( 'Enable tooltip.', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => 'true'
							)
						),

						array(
							'param_name'  => 'related_url',
							'heading'     => __( 'Related url', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),

						array(
							'param_name'  => 'link',
							'heading'     => __( 'Upload Brand', 'k2t' ),
							'type'        => 'attach_image',
							'holder'      => 'div',
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
					)
				);
				vc_map( $k2t_brands_item );
	
				/*  [ Button ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_button = array(
					'base'            => 'button',
					'name'            => __( 'Button', 'k2t' ),
					'icon'            => 'fa fa-dot-circle-o',
					'category'        => __( 'Typography', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'title',
							'heading'     => __( 'Button Text', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'link',
							'heading'     => __( 'Link', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name' => 'target',
							'heading' 	 => __( 'Link Target', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Open in a new window', 'k2t' )                      => '_blank',
								__( 'Open in the same frame as it was clicked', 'k2t' )  => '_self'
							),
							'dependency' => array(
								'element' 		=> 'link',
								'not_empty'   	=> true,
							),
						),
						array(
							'param_name' => 'icon',
							'heading' 	 => __( 'Choose Icon', 'k2t' ),
							'type' 		 => 'k2t_icon',
							'value'      => '',
						),
						array(
							'param_name' => 'icon_position',
							'heading' 	 => __( 'Icon Position', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Right', 'k2t' ) 				=> 'right',
								__( 'Left', 'k2t' )  				=> 'left'
							),
							'dependency' => array(
								'element' 		=> 'icon',
								'not_empty'   	=> true,
							),
						),
						array(
							'param_name' => 'button_style',
							'heading' 	 => __( 'Button style', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Default button', 'k2t' ) 		=> 'default',
								__( 'Outline button', 'k2t' ) 		=> 'outline',
								__( 'Around button', 'k2t' ) 		=> 'around',
								__( 'Shadow button', 'k2t' ) 		=> 'shadow',
							),
						),
						array(
							'param_name' => 'button_color',
							'heading' 	 => __( 'Button color', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Default', 'k2t' )   			=> 'default',
								__( 'Red', 'k2t' )   				=> 'red',
								__( 'Deep Purple', 'k2t' ) 			=> 'deep_purple',
								__( 'Blue', 'k2t' )  				=> 'blue',
								__( 'Green', 'k2t' )  				=> 'green',
								__( 'Amber', 'k2t' )  				=> 'amber',
								__( 'Deep Orange', 'k2t' )  		=> 'deep_orange',
								__( 'Black', 'k2t' )  				=> 'black',
								__( 'White', 'k2t' )  				=> 'white',
								__( 'Custom', 'k2t' )  				=> 'custom',
							),
							'dependency' => array(
								'element' => 'button_style',
								'value'   => array( 'default', 'around', 'shadow' )
							),
						),
						array(
							'param_name'  => 'color',
							'heading'     => __( 'Button Background Color', 'k2t' ),
							'type'        => 'colorpicker',
							'dependency' => array(
								'element' => 'button_color',
								'value'   => array( 'custom' )
							),
						),
						array(
							'param_name'  => 'text_color',
							'heading'     => __( 'Button Text Color', 'k2t' ),
							'type'        => 'colorpicker',
							'dependency' => array(
								'element' => 'button_color',
								'value'   => array( 'custom' )
							),
						),
						array(
							'param_name'  => 'hover_bg_color',
							'heading'     => __( 'Background Hover Color', 'k2t' ),
							'type'        => 'colorpicker',
							'dependency' => array(
								'element' => 'button_color',
								'value'   => array( 'custom' )
							),
						),
						array(
							'param_name'  => 'hover_text_color',
							'heading'     => __( 'Text Hover Color', 'k2t' ),
							'type'        => 'colorpicker',
							'dependency' => array(
								'element' => 'button_color',
								'value'   => array( 'custom' )
							),
						),
						array(
							'param_name'  => 'border_color',
							'heading'     => __( 'Button border Color', 'k2t' ),
							'type'        => 'colorpicker',
							'dependency' => array(
								'element' => 'button_color',
								'value'   => array( 'custom' )
							),
						),
						array(
							'param_name'  => 'border_width',
							'heading'     => __( 'Button border width', 'k2t' ),
							'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'dependency' => array(
								'element' => 'button_color',
								'value'   => array( 'custom' )
							),
						),
						array(
							'param_name'  => 'hover_border_color',
							'heading'     => __( 'Border Hover Color', 'k2t' ),
							'type'        => 'colorpicker',
							'dependency' => array(
								'element' => 'button_color',
								'value'   => array( 'custom' )
							),
						),
						array(
							'param_name' => 'size',
							'heading' 	 => __( 'Size', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Small', 'k2t' ) 				=> 'small',
								__( 'Medium', 'k2t' ) 				=> 'medium',
								__( 'Large', 'k2t' )  				=> 'large'
							),
						),
						array(
							'param_name' => 'align',
							'heading' 	 => __( 'Align', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Left', 'k2t' )   				=> 'left',
								__( 'Center', 'k2t' ) 				=> 'center',
								__( 'Right', 'k2t' )  				=> 'right'
							),
						),
						array(
							'param_name'  => 'fullwidth',
							'heading'     => __( 'Button Full Width', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => 'true'
							)
						),
						array(
							'param_name'  => 'pill',
							'heading'     => __( 'Pill', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => 'true'
							)
						),
						array(
							'param_name'  => 'radius',
							'heading'     => __( 'Button radius', 'k2t' ),
							'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'dependency' => array(
								'element' => 'pill',
								'value'   => 'true'
							),
						),
						array(
							'param_name'  => 'd3',
							'heading'     => __( '3D', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => 'true'
							)
						),
						$k2t_margin_top,
						$k2t_margin_right,
						$k2t_margin_bottom,
						$k2t_margin_left,
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_button );
	
				/*  [ Circle button ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_circle_button = array(
					'base'            => 'circle_button',
					'name'            => __( 'Circle Button', 'k2t' ),
					'icon'            => 'fa fa-circle',
					'category'        => __( 'Typography', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'name',
							'heading'     => __( 'Button Name', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'link',
							'heading'     => __( 'Link To', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name' => 'icon_hover',
							'heading' 	 => __( 'Icon Hover', 'k2t' ),
							'type' 		 => 'k2t_icon',
							'value'      => '',
						),
						array(
							'param_name'  => 'background_color',
							'heading'     => __( 'Button Background Color', 'k2t' ),
							'type'        => 'colorpicker',
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_circle_button );
	
				/*  [ Google Map ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_google_map = array(
					'base'            => 'google_map',
					'name'            => __( 'K2t Google Maps', 'k2t' ),
					'icon'            => 'fa fa-map-marker',
					'category'        => __( 'Marketing', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'z',
							'heading'     => __( 'Zoom Level', 'k2t' ),
							'description' => __( 'Between 0-20', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'lat',
							'heading'     => __( 'Latitude', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'lon',
							'heading'     => __( 'Longitude', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'w',
							'heading'     => __( 'Width', 'k2t' ),
							'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'h',
							'heading'     => __( 'Height', 'k2t' ),
							'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'address',
							'heading'     => __( 'Address', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name' => 'marker',
							'heading' 	 => __( 'Marker', 'k2t' ),
							'type' 		 => 'checkbox',
							'value'      => array(
								'' => 'true'
							),
							'dependency' => array(
								'element' => 'address',
								'not_empty'   => true,
							),
						),
						array(
							'param_name'  => 'markerimage',
							'heading'     => __( 'Marker Image', 'k2t' ),
							'description' => __( 'Change default Marker.', 'k2t' ),
							'type'        => 'attach_image',
							'holder'      => 'div',
							'dependency' => array(
								'element' => 'marker',
								'value'   => array( 'true' ),
							),
						),
						array(
							'param_name' => 'traffic',
							'heading' 	 => __( 'Show Traffic', 'k2t' ),
							'type' 		 => 'checkbox',
							'value'      => array(
								'' => 'true'
							)
						),
						array(
							'param_name' => 'draggable',
							'heading' 	 => __( 'Draggable', 'k2t' ),
							'type' 		 => 'checkbox',
							'value'      => array(
								'' => 'true'
							)
						),
						array(
							'param_name' => 'infowindowdefault',
							'heading' 	 => __( 'Show Info Map', 'k2t' ),
							'type' 		 => 'checkbox',
							'value'      => array(
								'' => 'true'
							)
						),
						array(
							'param_name'  => 'infowindow',
							'heading'     => __( 'Content Info Map', 'k2t' ),
							'description' => __( 'Strong, br are accepted.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name' => 'hidecontrols',
							'heading' 	 => __( 'Hide Control', 'k2t' ),
							'type' 		 => 'checkbox',
							'value'      => array(
								'' => 'true'
							)
						),
						array(
							'param_name' => 'scrollwheel',
							'heading' 	 => __( 'Scroll wheel zooming', 'k2t' ),
							'type' 		 => 'checkbox',
							'value'      => array(
								'' => 'true'
							)
						),
						array(
							'param_name' => 'maptype',
							'heading' 	 => __( 'Map Type', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'ROADMAP', 'k2t' )   => 'ROADMAP',
								__( 'SATELLITE', 'k2t' ) => 'SATELLITE',
								__( 'HYBRID', 'k2t' )    => 'HYBRID',
								__( 'TERRAIN', 'k2t' )   => 'TERRAIN'
							),
						),
						array(
							'param_name' => 'mapstype',
							'heading' 	 => __( 'Map style', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'None', 'k2t' )   => '',
								__( 'Subtle Grayscale', 'k2t' )   => 'grayscale',
								__( 'Blue water', 'k2t' ) => 'blue_water',
								__( 'Pale Dawn', 'k2t' ) => 'pale_dawn',
								__( 'Shades of Grey', 'k2t' ) => 'shades_of_grey',
							),
						),
						array(
							'param_name'  => 'color',
							'heading'     => __( 'Background Color', 'k2t' ),
							'type'        => 'colorpicker',
						),
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_google_map );
	
				/*  [ Heading ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_heading = array(
					'base'            => 'heading',
					'name'            => __( 'Heading', 'k2t' ),
					'icon'            => 'fa fa-header',
					'category'        => __( 'Typography', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'content',
							'heading'     => __( 'Title', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'value'       => ''
						),
						array(
							'param_name' => 'h',
							'heading' 	 => __( 'Heading Tag', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array( 
								__( 'H1', 'k2t' ) => 'h1', 
								__( 'H2', 'k2t' ) => 'h2', 
								__( 'H3', 'k2t' ) => 'h3', 
								__( 'H4', 'k2t' ) => 'h4', 
								__( 'H5', 'k2t' ) => 'h5', 
								__( 'H6', 'k2t' ) => 'h6', 
								__( 'Custom', 'k2t' ) => 'custom' ),
						),
						array(
							'param_name'  => 'font_size',
							'heading'     => __( 'Custom Font Size', 'k2t' ),
							'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'dependency' => array(
								'element' => 'h',
								'value'   => array( 'custom' )
							),
						),
						array(
							'param_name' => 'align',
							'heading' 	 => __( 'Align', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Left', 'k2t' )   => 'left',
								__( 'Center', 'k2t' ) => 'center',
								__( 'Right', 'k2t' )  => 'right'
							),
						),
						array(
							'param_name'  => 'font',
							'heading'     => __( 'Title Font', 'k2t' ),
							'description' => __( 'Use Google Font', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'color',
							'heading'     => __( 'Title Color', 'k2t' ),
							'type'        => 'colorpicker',
						),
						array(
							'param_name' => 'border',
							'heading' 	 => __( 'Has border', 'k2t' ),
							'type' 		 => 'checkbox',
							'value'      => array(
								'' => 'true'
							)
						),
						array(
							'param_name' => 'border_style',
							'heading' 	 => __( 'Border Style', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Two Dots', 'k2t' )   			=> 'two_dots',
								__( 'Short Line', 'k2t' )   		=> 'short_line',
								__( 'Bottom Icon', 'k2t' ) 		=> 'bottom_icon',
								__( 'Heading', 'k2t' )  			=> 'heading',
								__( 'Boxed Heading', 'k2t' )  		=> 'boxed_heading',
								__( 'Bottom Border', 'k2t' )  		=> 'bottom_border',
								__( 'Line Through', 'k2t' )  		=> 'line_through',
								__( 'Double Line', 'k2t' )  		=> 'double_line',
								__( 'Dotted Line', 'k2t' )  		=> 'three_dotted',
								__( 'Fat Line', 'k2t' )  			=> 'fat_line',
							),
							'dependency' => array(
								'element' => 'border',
								'value'   => array( 'true' )
							),
						),
						array(
							'param_name'  => 'border_color',
							'heading'     => __( 'Border Color', 'k2t' ),
							'type'        => 'colorpicker',
							'dependency' => array(
								'element' => 'border',
								'value'   => array( 'true' )
							),
						),
						array(
							'param_name' => 'icon',
							'heading' 	 => __( 'Choose Icon', 'k2t' ),
							'type' 		 => 'k2t_icon',
							'value'      => '',
							'dependency' => array(
								'element' => 'border_style',
								'value'   => array( 'bottom_icon', 'boxed_heading' )
							),
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_heading );
	
				/*  [ Icon Box ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_icon_box = array(
					'base'            => 'iconbox',
					'name'            => __( 'Icon Box', 'k2t' ),
					'icon'            => 'fa fa-th',
					'category'        => __( 'Marketing', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name' => 'layout',
							'heading' 	 => __( 'Layout', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array( '1', '2', '3', '4' , '5', '6' ),
						),
						array(
							'param_name'  => 'bgcolor',
							'heading'     => __( 'Background Color', 'k2t' ),
							'type'        => 'colorpicker',
							'dependency' => array(
								'element' => 'layout',
								'value'   => array( '1' )
							),
						),
						array(
							'param_name'  => 'title',
							'heading'     => __( 'Title', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'title_link',
							'heading'     => __( 'Title link to', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'fontsize',
							'heading'     => __( 'Title Font Size', 'k2t' ),
							'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name' => 'text_transform',
							'heading' 	 => __( 'Text Transform', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Inherit', 'k2t' )    => 'inherit',
								__( 'Uppercase', 'k2t' )  => 'uppercase',
								__( 'Lowercase', 'k2t' )  => 'lowercase',
								__( 'Initial', 'k2t' )    => 'initial',
								__( 'Capitalize', 'k2t' ) => 'capitalize',
							),
						),
						array(
							'param_name'  => 'color',
							'heading'     => __( 'Title Color', 'k2t' ),
							'type'        => 'colorpicker',
						),
						array(
							'param_name'  => 'title_margin_bottom',
							'heading'     => __( 'Title margin bottom', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
						),
						array(
							'param_name' => 'icon_type',
							'heading' 	 => __( 'Icon Type', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								'Icon Fonts' => 'icon_fonts',
								'Graphics'   => 'graphics',
							)
						),
						array(
							'param_name' => 'graphic',
							'heading' 	 => __( 'Choose Images', 'k2t' ),
							'type' 		 => 'attach_image',
							'dependency' => array(
								'element' => 'icon_type',
								'value'   => array( 'graphics' )
							),
						),
						array(
							'param_name' => 'icon',
							'heading' 	 => __( 'Choose Icon', 'k2t' ),
							'type' 		 => 'k2t_icon',
							'dependency' => array(
								'element' => 'icon_type',
								'value'   => array( 'icon_fonts' )
							),
							'value'      => '',
						),
						array(
							'param_name'  => 'icon_font_size',
							'heading'     => __( 'Icon size', 'k2t' ),
							'type'        => 'textfield',
							'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
							'dependency' => array(
								'element' => 'icon_type',
								'value'   => array( 'icon_fonts' )
							),
						),
						array(
							'param_name' => 'icon_color',
							'heading' 	 => __( 'Icon Color', 'k2t' ),
							'type' 		 => 'colorpicker',
							'dependency' => array(
								'element' => 'icon_type',
								'value'   => array( 'icon_fonts' )
							),
						),
						array(
							'param_name'  => 'link',
							'heading'     => __( 'Link to', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'link_text',
							'heading'     => __( 'Link text', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'content',
							'heading'     => __( 'Content', 'k2t' ),
							'type'        => 'textarea_html',
							'holder'      => 'div',
							'value'       => ''
						),
						$k2t_margin_top,
						$k2t_margin_right,
						$k2t_margin_bottom,
						$k2t_margin_left,
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_icon_box );
	
				/*  [ Icon List ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_icon_list = array(
					'base'            => 'iconlist',
					'name'            => __( 'Icon List', 'k2t' ),
					'icon'            => 'fa fa-list',
					'category'        => __( 'Typography', 'k2t' ),
					'as_parent'       => array( 'only' => 'li' ),
					'content_element' => true,
					'js_view'         => 'VcColumnView',
					'params'          => array(
						array(
							'param_name' => 'icon',
							'heading' 	 => __( 'Choose Icon', 'k2t' ),
							'type' 		 => 'k2t_icon',
							'value'      => '',
						),
						array(
							'param_name'  => 'color',
							'heading'     => __( 'Icon Color', 'k2t' ),
							'type'        => 'colorpicker',
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				$k2t_icon_list_item = array(
					'base'            => 'li',
					'name'            => __( 'Icon List', 'k2t' ),
					'icon'            => 'fa fa-ellipsis-v',
					'category'        => __( 'Typography', 'k2t' ),
					'as_child'        => array( 'only' => 'iconlist' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'title',
							'heading'     => __( 'Title', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name' => 'icon',
							'heading' 	 => __( 'Choose Icon', 'k2t' ),
							'type' 		 => 'k2t_icon',
							'value'      => '',
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
					)
				);
				vc_map( $k2t_icon_list );
				vc_map( $k2t_icon_list_item );
	
				/*  [ Member ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_member = array(
					'base'            => 'member',
					'name'            => __( 'Member', 'k2t' ),
					'icon'            => 'fa fa-user',
					'category'        => __( 'Common', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name' => 'style',
							'heading' 	 => __( 'Style Member', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Default', 'k2t' ) => 'default',
								__( 'Boxed', 'k2t' )  => 'boxed',
							)
						),
						array(
							'param_name'  => 'image',
							'heading'     => __( 'Member Avatar', 'k2t' ),
							'type'        => 'attach_image',
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'name',
							'heading'     => __( 'Member Name', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'role',
							'heading'     => __( 'Role', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'facebook',
							'heading'     => __( 'Facebook URL', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'twitter',
							'heading'     => __( 'Twitter URL', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'skype',
							'heading'     => __( 'Skype', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'pinterest',
							'heading'     => __( 'Pinterest URL', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'instagram',
							'heading'     => __( 'Instagram', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'dribbble',
							'heading'     => __( 'Dribbble URL', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'google_plus',
							'heading'     => __( 'Google Plus URL', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'content',
							'heading'     => __( 'Member Info', 'k2t' ),
							'type'        => 'textarea_html',
							'holder'      => 'div',
							'value'       => ''
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_member );
	
				/*  [ Pricing Table ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_pricing = array(
					'base'            => 'pricing',
					'name'            => __( 'Pricing Table', 'k2t' ),
					'icon'            => 'fa fa-table',
					'category'        => __( 'Marketing', 'k2t' ),
					'as_parent'       => array( 'only' => 'pricing_column' ),
					'content_element' => true,
					'js_view'         => 'VcColumnView',
					'params'          => array(
						array(
							'param_name' => 'separated',
							'heading' 	 => __( 'Separated', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'True', 'k2t' )  => 'true',
								__( 'False', 'k2t' ) => 'false',
							)
						),
						$k2t_id,
						$k2t_class
					)
				);
				$k2t_pricing_item = array(
					'base'            => 'pricing_column',
					'name'            => __( 'Pricing Columns', 'k2t' ),
					'icon'            => 'fa fa-table',
					'category'        => __( 'Marketing', 'k2t' ),
					'as_child'        => array( 'only' => 'pricing' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'title',
							'heading'     => __( 'Title', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'sub_title',
							'heading'     => __( 'Sub Title', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'image',
							'heading'     => __( 'Pricing Image', 'k2t' ),
							'type'        => 'attach_image',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'price',
							'heading'     => __( 'Price', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'price_per',
							'heading'     => __( 'Price Per', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'unit',
							'heading'     => __( 'Unit', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'link',
							'heading'     => __( 'Link to', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'link_text',
							'heading'     => __( 'Link Text', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name' => 'link_target',
							'heading' 	 => __( 'Link Target', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Open in a new window', 'k2t' )                      => '_blank',
								__( 'Open in the same frame as it was clicked', 'k2t' )  => '_self'
							),
						),
						array(
							'param_name' => 'featured',
							'heading' 	 => __( 'Featured', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'False', 'k2t' ) => 'false',
								__( 'True', 'k2t' )  => 'true',
							)
						),
						array(
							'param_name'  => 'pricing_content',
							'heading'     => __( 'List Item', 'k2t' ),
							'description' => __( 'Using ul li tag.', 'k2t' ),
							'type'        => 'textarea_html',
							'holder'      => 'div',
							'value'       => ''
						),
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_pricing );
				vc_map( $k2t_pricing_item );
	
				/*  [ Progress ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_progress = array(
					'base'            => 'progress',
					'name'            => __( 'Progress', 'k2t' ),
					'icon'            => 'fa fa-sliders',
					'category'        => __( 'Common', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'percent',
							'heading'     => __( 'Percent', 'k2t' ),
							'description' => __( 'Numeric value only, between 1-100.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'color',
							'heading'     => __( 'Color', 'k2t' ),
							'type'        => 'colorpicker',
						),
						array(
							'param_name'  => 'background_color',
							'heading'     => __( 'Background Color', 'k2t' ),
							'type'        => 'colorpicker',
						),
						array(
							'param_name'  => 'text_color',
							'heading'     => __( 'Text Color', 'k2t' ),
							'type'        => 'colorpicker',
						),
						array(
							'param_name'  => 'title',
							'heading'     => __( 'Title', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'height',
							'heading'     => __( 'Height', 'k2t' ),
							'description' => __( 'Numeric value only, unit is pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'striped',
							'heading'     => __( 'Striped', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => 'true'
							)
						),
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_progress );
	
				/*  [ Responsive Text ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_responsive_text = array(
					'base'            => 'responsive_text',
					'name'            => __( 'Responsive text', 'k2t' ),
					'icon'            => 'fa fa-arrows-alt',
					'category'        => __( 'Typography', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'compression',
							'heading'     => __( 'Compression', 'k2t' ),
							'description' => __( 'Numeric value only.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'min_size',
							'heading'     => __( 'Min Font Size', 'k2t' ),
							'description' => __( 'Numeric value only, unit is pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'max_size',
							'heading'     => __( 'Max Font Size', 'k2t' ),
							'description' => __( 'Numeric value only, unit is pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_responsive_text );
	
				/*  [ Testimonial ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_textimonial = array(
					'base'            => 'testimonial',
					'name'            => __( 'testimonials', 'k2t' ),
					'icon'            => 'fa fa-exchange',
					'category'        => __( 'Content', 'k2t' ),
					'as_parent'       => array( 'only' => 'testi' ),
					'js_view'         => 'VcColumnView',
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'style',
							'heading'     => __( 'Testimonial Style', 'k2t' ),
							'type'        => 'dropdown',
							'value'      => array(
								__('Style 1', 'k2t') => 'style-1',
								__('Style 2', 'k2t') => 'style-2',
							),
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'items',
							'heading'     => __( 'Items', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'dependency'  => array(
								'element' => 'style',
								'value'   => array( 'style-2' ),
							),
						),
						array(
							'param_name'  => 'items_mobile',
							'heading'     => __( 'Items Mobile', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'dependency'  => array(
								'element' => 'style',
								'value'   => array( 'style-2' ),
							),
						),
						array(
							'param_name'  => 'items_tablet',
							'heading'     => __( 'Items Tablet', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'dependency'  => array(
								'element' => 'style',
								'value'   => array( 'style-2' ),
							),
						),
						array(
							'param_name'  => 'items_desktop',
							'heading'     => __( 'Items Desktop', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'dependency'  => array(
								'element' => 'style',
								'value'   => array( 'style-2' ),
							),
						),
						array(
							'param_name'  => 'enable_pagination',
							'heading'     => __( 'Enable pagination', 'k2t' ),
							'type'        => 'dropdown',
							'value'      => array(
								__('False', 'k2t') => 'false',
								__('True', 'k2t') => 'true',
							),
							'holder'      => 'div',
							'dependency'  => array(
								'element' => 'style',
								'value'   => array( 'style-1','style-2' ),
							),
						),
						array(
							'param_name'  => 'position_author',
							'heading'     => __( 'Position Author Name', 'k2t' ),
							'type'        => 'dropdown',
							'value'      => array(
								__('Top', 'k2t') => 'top',
								__('Bottom', 'k2t') => 'bottom',
							),
							'holder'      => 'div',
							'dependency'  => array(
								'element' => 'style',
								'value'   => array( 'style-1' ),
							),
						),
						$k2t_class
					)
				);
				vc_map( $k2t_textimonial );
				$k2t_testi = array(
					'base'            => 'testi',
					'name'            => __( 'Testimonial', 'k2t' ),
					'icon'            => 'fa fa-comments-o',
					'category'        => __( 'Marketing', 'k2t' ),
					'as_child'        => array( 'only' => 'testimonial' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'image',
							'heading'     => __( 'Avatar', 'k2t' ),
							'description' => __( 'Choose avatar for testimonial author.', 'k2t' ),
							'type'        => 'attach_image',
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'name',
							'heading'     => __( 'Name', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'position_teacher',
							'heading'     => __( 'Position', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'content',
							'heading'     => __( 'Text', 'k2t' ),
							'description' => __( 'Enter your testimonial.', 'k2t' ),
							'type'        => 'textarea_html',
							'holder'      => 'div',
							'value'       => ''
						),
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_testi );
	
				/*  [ Blockquote ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_blockquote = array(
					'base'            => 'blockquote',
					'name'            => __( 'Blockquote', 'k2t' ),
					'icon'            => 'fa fa-quote-left',
					'category'        => __( 'Typography', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name' => 'style',
							'heading' 	 => __( 'Style', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Style 1', 'k2t' )   => '1',
								__( 'Style 2', 'k2t' )   => '2',
							),
						),
						array(
							'param_name' => 'align',
							'heading' 	 => __( 'Align', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Left', 'k2t' )   => 'left',
								__( 'Center', 'k2t' ) => 'center',
								__( 'Right', 'k2t' )  => 'right'
							),
						),
						array(
							'param_name'  => 'author',
							'heading'     => __( 'Author', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'link_author',
							'heading'     => __( 'Link to', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'content',
							'heading'     => __( 'Content', 'k2t' ),
							'type'        => 'textarea_html',
							'holder'      => 'div',
							'value'       => ''
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_blockquote );
	
				/*  [ Countdown ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_countdown = array(
					'base'            => 'countdown',
					'name'            => __( 'Countdown', 'k2t' ),
					'icon'            => 'fa fa-sort-numeric-desc',
					'category'        => __( 'Common', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'time',
							'heading'     => __( 'Time', 'k2t' ),
							'description' => __( 'The time in this format: m/d/y h:mm tt', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name' => 'align',
							'heading' 	 => __( 'Align', 'k2t' ),
							'type' 		 => 'dropdown',
							'value'      => array(
								__( 'Left', 'k2t' )   => 'left',
								__( 'Center', 'k2t' ) => 'center',
								__( 'Right', 'k2t' )  => 'right'
							),
						),
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_countdown );
	
				/*  [ Embed ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_embed = array(
					'base'            => 'k2t_embed',
					'name'            => __( 'Embed', 'k2t' ),
					'icon'            => 'fa fa-terminal',
					'category'        => __( 'Media', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'width',
							'heading'     => __( 'Width', 'k2t' ),
							'description' => __( 'Numeric value only, Unit is Pixel.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'content',
							'heading'     => __( 'URL or embed code', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
							'value'       => ''
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_embed );
	
				/*  [ K2T Slider ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_slider = array(
					'base'            => 'k2t_slider',
					'name'            => __( 'K2T Carousel', 'k2t' ),
					'icon'            => 'fa fa-exchange',
					'category'        => __( 'Content', 'k2t' ),
					'as_parent'       => array( 'only' => 'vc_single_image, vc_raw_html, event, member' ),
					'js_view'         => 'VcColumnView',
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'items',
							'heading'     => __( 'Slides per view', 'k2t' ),
							'description' => __( 'Numeric value only.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'items_desktop',
							'heading'     => __( 'Slides per view on desktop', 'k2t' ),
							'description' => __( 'Item to display for desktop small (device width <= 1200px).', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'items_tablet',
							'heading'     => __( 'Slides per view on tablet', 'k2t' ),
							'description' => __( 'Item to display for tablet (device width <= 768px).', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'items_mobile',
							'heading'     => __( 'Slides per view on mobile', 'k2t' ),
							'description' => __( 'Item to display for mobile (device width <= 480px).', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'item_margin',
							'heading'     => __( 'Margin between items', 'k2t' ),
							'description' => __( 'Ex: 30', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div',
						),
						array(
							'param_name'  => 'auto_play',
							'heading'     => __( 'Auto Play', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => true
							),
						),
						array(
							'param_name'  => 'navigation',
							'heading'     => __( 'Navigation', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => true
							),
						),
						array(
							'param_name'  => 'pagination',
							'heading'     => __( 'Pagination', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'value'       => array(
								'' => true
							),
						),
						$k2t_class
					)
				);
				vc_map( $k2t_slider );
	
				/*  [ Blog Post ]
				- - - - - - - - - - - - - - - - - - - */
				$k2t_blog_post = array(
					'base'            => 'blog_post',
					'name'            => __( 'Blog Post', 'k2t' ),
					'icon'            => 'fa fa-file-text',
					'category'        => __( 'Content', 'k2t' ),
					'content_element' => true,
					'params'          => array(
						array(
							'param_name'  => 'limit',
							'heading'     => __( 'Number of posts to show', 'k2t' ),
							'description' => __( 'Empty is show all posts.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'cat',
							'heading'     => __( 'Show posts associated with certain categories', 'k2t' ),
							'description' => __( 'Using category id, separate multiple categories with commas.', 'k2t' ),
							'type'        => 'textfield',
							'holder'      => 'div'
						),
						array(
							'param_name' => 'slider',
							'heading' 	 => __( 'Enable Slider', 'k2t' ),
							'type' 		 => 'checkbox',
							'value'      => array(
								'' => true
							),
						),
						array(
							'param_name'  => 'items',
							'heading'     => __( 'Items', 'k2t' ),
							'description' => __( 'Numeric value only.', 'k2t' ),
							'type'        => 'textfield',
							'dependency' => array(
								'element' => 'slider',
								'value'   => array( '1' ),
							),
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'items_desktop',
							'heading'     => __( 'Items for Desktop small', 'k2t' ),
							'description' => __( 'Item to display for desktop small (device width <= 1366px).', 'k2t' ),
							'type'        => 'textfield',
							'dependency' => array(
								'element' => 'slider',
								'value'   => array( '1' ),
							),
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'items_tablet',
							'heading'     => __( 'Items for Tablet', 'k2t' ),
							'description' => __( 'Item to display for tablet (device width <= 768px).', 'k2t' ),
							'type'        => 'textfield',
							'dependency' => array(
								'element' => 'slider',
								'value'   => array( '1' ),
							),
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'items_mobile',
							'heading'     => __( 'Items for Mobile', 'k2t' ),
							'description' => __( 'Item to display for mobile (device width <= 480px).', 'k2t' ),
							'type'        => 'textfield',
							'dependency' => array(
								'element' => 'slider',
								'value'   => array( '1' ),
							),
							'holder'      => 'div'
						),
						array(
							'param_name'  => 'navigation',
							'heading'     => __( 'Navigation', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'dependency' => array(
								'element' => 'slider',
								'value'   => array( '1' ),
							),
							'value'       => array(
								'' => 'true'
							)
						),
						array(
							'param_name'  => 'pagination',
							'heading'     => __( 'Pagination', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'dependency' => array(
								'element' => 'slider',
								'value'   => array( '1' ),
							),
							'value'       => array(
								'' => 'true'
							)
						),
						array(
							'param_name'  => 'auto_play',
							'heading'     => __( 'Auto Play', 'k2t' ),
							'type'        => 'checkbox',
							'holder'      => 'div',
							'dependency' => array(
								'element' => 'slider',
								'value'   => array( '1' ),
							),
							'value'       => array(
								'' => 'true'
							)
						),
						$k2t_animation,
						$k2t_animation_name,
						$k2t_animation_delay,
						$k2t_id,
						$k2t_class
					)
				);
				vc_map( $k2t_blog_post );

				/*  [ K2t Event ]
				- - - - - - - - - - - - - - - - - - - */
				if ( is_plugin_active( 'k-event/hooks.php' ) ) {
					$k2t_event_listing = array(
						'base'            => 'k_event_listing',
						'name'            => __( 'K Event Listing', 'k2t' ),
						'icon'            => 'fa fa-calendar',
						'category'        => __( 'Lincoln Shortcode', 'k2t' ),
						'content_element' => true,
						'params'          => array(
							array(
								'param_name'  => 'style',
								'heading'     => __( 'Event Listing Style', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Calendar 1', 'k2t') 	=> 'style-1',
									__('Calendar 2', 'k2t') 	=> 'style-2',
									__('Grid', 'k2t') 			=> 'style-3',
									__('Classic', 'k2t') 		=> 'style-4',
									__('Carousel', 'k2t') 		=> 'style-5',
								),
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'masonry_column',
								'heading'     => __( 'Masonry Columns', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('2 Columns', 'k2t') => 'columns-2',
									__('3 Columns', 'k2t') => 'columns-3',
									__('4 Columns', 'k2t') => 'columns-4',
								),
								'holder'      => 'div',
								'dependency' => array(
									'element' => 'style',
									'value'   => array( 'style-3', 'style-5' ),
								),
							),
							array(
								'param_name'  => 'cate_event_id',
								'heading'     => __( 'Categories Event ID', 'k2t' ),
								'description' => __('Choose Event ID in K-Event Categories, Numeric value only'),
								'type'        => 'textfield',
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'style-3', 'style-4', 'style-5' ),
								),
							),
							array(
								'param_name'  => 'event_masonry_filter',
								'heading'     => __( 'Show/Hide Filter', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Show', 'k2t') => 'show',
									__('Hide', 'k2t') => 'hide',
								),
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'style-3'),
								),
							),
							array(
								'param_name'  => 'post_per_page',
								'heading'     => __( 'Event per page', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'std'         => '4',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'style-3', 'style-4' ),
								),
							),
							array(
								'param_name'  => 'number_post_show',
								'heading'     => __( 'Number of post show', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'std'         => '9',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'style-5' ),
								),
							),
							array(
								'param_name'  => 'event_pagination',
								'heading'     => __( 'Show/Hide Pagination', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Show', 'k2t') => 'show',
									__('Hide', 'k2t') => 'hide',
								),
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'style-3', 'style-4', 'style-5' ),
								),
							),
							array(
								'param_name'  => 'event_navigation',
								'heading'     => __( 'Show/Hide Navigation', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Show', 'k2t') => 'show',
									__('Hide', 'k2t') => 'hide',
								),
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'style-5' ),
								),
							),
							$k2t_animation,
							$k2t_animation_name,
							$k2t_animation_delay,
							$k2t_id,
							$k2t_class
						)
					);
					vc_map( $k2t_event_listing );
				}

				/*  [ K2t Event Recent ]
				- - - - - - - - - - - - - - - - - - - */
				if ( is_plugin_active( 'k-event/hooks.php' ) ) {
					$k2t_event_recent = array(
						'base'            => 'k_event_recent',
						'name'            => __( 'K Event Recent', 'k2t' ),
						'icon'            => 'fa fa-calendar',
						'category'        => __( 'Lincoln Shortcode', 'k2t' ),
						'content_element' => true,
						'params'          => array(
							array(
								'param_name'  => 'recent_text_detail',
								'heading'     => esc_html__( 'Text Detail', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'k_recent_url',
								'heading'     => esc_html__( 'Related URL', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
							),
							$k2t_animation,
							$k2t_animation_name,
							$k2t_animation_delay,
							$k2t_id,
							$k2t_class
						)
					);
					vc_map( $k2t_event_recent );
				}

				/*  [ K2t Course ]
				- - - - - - - - - - - - - - - - - - - */
				if ( is_plugin_active( 'k-course/hooks.php' ) ) {
					$k2t_course_listing = array(
						'base'            => 'k_course_listing',
						'name'            => __( 'K Course Listing', 'k2t' ),
						'icon'            => 'fa fa-leanpub',
						'category'        => __( 'Lincoln Shortcode', 'k2t' ),
						'content_element' => true,
						'params'          => array(
							array(
								'param_name'  => 'style',
								'heading'     => __( 'Course Listing Style', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Classic', 'k2t') => 'style-1',
									__('Grid', 'k2t') => 'style-2',
									__('Carousel','k2t') => 'style-3',
								),
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'masonry_column',
								'heading'     => __( 'Grid Columns', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('2 Columns', 'k2t') => 'columns-2',
									__('3 Columns', 'k2t') => 'columns-3',
									__('4 Columns', 'k2t') => 'columns-4',
								),
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'style-2','style-3' ),
								),
							),
							array(
								'param_name'  => 'course_masonry_filter',
								'heading'     => __( 'Show/Hide Filter', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Show', 'k2t') => 'show',
									__('Hide', 'k2t') => 'hide',
								),
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'style-2' ),
								),
							),
							array(
								'param_name'  => 'course_carousel_navi',
								'heading'     => __( 'Show/Hide Navigation', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Show', 'k2t') => 'show',
									__('Hide', 'k2t') => 'hide',
								),
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'style-3' ),
								),
							),

							array(
								'param_name'  => 'category_course_id',
								'heading'     => __( 'Category Course ID', 'k2t' ),
								'description' => __('Choose Course ID in K-Course Categories, Numeric value only'),
								'type'        => 'textfield',
								'holder'      => 'div',
							),

							array(
								'param_name'  => 'post_per_page',
								'heading'     => __( 'Course per page', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'std'         => '5',
							),
							array(
								'param_name'  => 'course_date',
								'heading'     => __( 'Show/Hide Datetime', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Show', 'k2t') => 'show',
									__('Hide', 'k2t') => 'hide',
								),
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'course_price',
								'heading'     => __( 'Show Text or Price on Apply button', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Text Apply', 'k2t') => 'text',
									__('Price', 'k2t') => 'price',
								),
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'course_pagination',
								'heading'     => __( 'Show/Hide Pagination', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Show', 'k2t') => 'show',
									__('Hide', 'k2t') => 'hide',
								),
								'holder'      => 'div',
							),
							$k2t_animation,
							$k2t_animation_name,
							$k2t_animation_delay,
							$k2t_id,
							$k2t_class
						)
					);
					vc_map( $k2t_course_listing );
				}

				/*  [ K2t Teacher ]
				- - - - - - - - - - - - - - - - - - - */
				if ( is_plugin_active( 'k-teacher/hooks.php' ) ) {
					$k2t_teacher_listing = array(
						'base'            => 'k_teacher_listing',
						'name'            => __( 'K Teacher Listing', 'k2t' ),
						'icon'            => 'fa fa-group',
						'category'        => __( 'Lincoln Shortcode', 'k2t' ),
						'content_element' => true,
						'params'          => array(
							array(
								'param_name'  => 'style',
								'heading'     => __( 'Teacher Listing Style', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Classic', 'k2t') => 'style-classic',
									__('Shadow Box', 'k2t') => 'style-shadow-box',
								),
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'column',
								'heading'     => __( 'Teacher Columns', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('2 Columns', 'k2t') => 'columns-2',
									__('3 Columns', 'k2t') => 'columns-3',
									__('4 Columns', 'k2t') => 'columns-4',
								),
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'cat',
								'heading'     => __( 'Teacher Categories ID', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'std'		  => '',
							),
							array(
								'param_name'  => 'teacher_per_page',
								'heading'     => __( 'Teacher per page', 'k2t' ),
								'description' => __( 'Fill out -1 if you want to display ALL teachers.', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'std'         => '12',
							),
							array(
								'param_name'  => 'excerpt',
								'heading'     => __( 'Show/Hide Excerpt', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Show', 'k2t') => 'show',
									__('Hide', 'k2t') => 'hide',
								),
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'excerpt_length',
								'heading'     => __( 'Excerpt Length', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'std'         => '20',
								'dependency'  => array(
									'element' => 'excerpt',
									'value'   => array( 'show' ),
								),
							),
							$k2t_animation,
							$k2t_animation_name,
							$k2t_animation_delay,
							$k2t_id,
							$k2t_class
						)
					);
					vc_map( $k2t_teacher_listing );
				}

				/*  [ K2t Gallery ]
				- - - - - - - - - - - - - - - - - - - */
				if ( is_plugin_active( 'k-gallery/init.php' ) ) {
					$k2t_gallery_listing = array(
						'base'            => 'k2t-gallery',
						'name'            => __( 'K2t Gallery', 'k2t' ),
						'icon'            => 'fa fa-image',
						'category'        => __( 'Lincoln Shortcode', 'k2t' ),
						'content_element' => true,
						'params'          => array(
							array(
								'param_name'  => 'title',
								'heading'     => __( 'Title', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'number',
								'heading'     => __( 'Number image to show', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'categories',
								'heading'     => __( 'Categories', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'filter',
								'heading'     => __( 'Show/Hide Filter', 'k2t' ),
								'type'        => 'dropdown',
								'value'       => array(
									__('True', 'k2t') 		=> 'true',
									__('False', 'k2t') 		=> 'false',
								),
								'std'		  => 'true',
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'filter_style',
								'heading'     => __( 'Filter style', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Dropdown', 'k2t') 	=> 'dropdown',
									__('List', 'k2t') 		=> 'list',
								),
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'filter',
									'value'   => array( 'true' ),
								),
							),
							array(
								'param_name'  => 'text_align',
								'heading'     => __( 'Filter Align', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Left', 'k2t') 	    => 'left',
									__('Center', 'k2t') 	=> 'center',
									__('Right', 'k2t') 		=> 'right',
								),
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'filter',
									'value'   => array( 'true' ),
								),
							),
							array(
								'param_name'  => 'column',
								'heading'     => __( 'Columns', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('2 Columns', 'k2t') 	=> '2',
									__('3 Columns', 'k2t') 	=> '3',
									__('4 Columns', 'k2t') 	=> '4',
									__('5 Columns', 'k2t') 	=> '5',
									__('6 Columns', 'k2t') 	=> '6',
								),
								'holder'      => 'div'
							),
							$k2t_animation,
							$k2t_animation_name,
							$k2t_animation_delay,
							$k2t_id,
							$k2t_class
						)
					);
					vc_map( $k2t_gallery_listing );
				}

				/*  [ K2t Project ]
				- - - - - - - - - - - - - - - - - - - */
				if ( is_plugin_active( 'k-project/init.php' ) ) {
					$k2t_project_listing = array(
						'base'            => 'k2t-project',
						'name'            => __( 'K2t Project', 'k2t' ),
						'icon'            => 'fa fa-image',
						'category'        => __( 'Lincoln Shortcode', 'k2t' ),
						'content_element' => true,
						'params'          => array(
							array(
								'param_name'  => 'title',
								'heading'     => __( 'Title', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'filter',
								'heading'     => __( 'Show Filter', 'k2t' ),
								'type'        => 'dropdown',
								'value'       => array(
									__('True', 'k2t') 		=> 'true',
									__('False', 'k2t') 		=> 'false',
								),
								'std'		  => 'true',
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'filter_align',
								'heading'     => __( 'Filter Align', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Left', 'k2t') 	=> 'left',
									__('Center', 'k2t') 	=> 'center',
									__('Right', 'k2t') 	=> 'right',
								),
								'holder'      => 'div',
								'dependency'  => array(
									'element' => 'filter',
									'value'   => array( 'true' ),
								),
							),
							array(
								'param_name'  => 'text_align',
								'heading'     => __( 'Text Align', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Left', 'k2t') 	=> 'left',
									__('Center', 'k2t') 	=> 'center',
									__('Right', 'k2t') 	=> 'right',
								),
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'column',
								'heading'     => __( 'Columns', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('2 Columns', 'k2t') 	=> '2',
									__('3 Columns', 'k2t') 	=> '3',
									__('4 Columns', 'k2t') 	=> '4',
									__('5 Columns', 'k2t') 	=> '5',
								),
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'number',
								'heading'     => __( 'Number projects to show', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'categories',
								'heading'     => __( 'Categories', 'k2t' ),
								'type'        => 'textfield',
								'holder'      => 'div',
							),
							array(
								'param_name'  => 'padding',
								'heading'     => __( 'Project Padding', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Yes', 'k2t') 	=> 'true',
									__('No', 'k2t') 	=> 'false',
								),
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'style',
								'heading'     => __( 'Project Style', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('Text Grid', 'k2t') 	=> 'text-grid',
									__('Text Masonry', 'k2t') 	=> 'text-masonry',
								),
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'child_style',
								'heading'     => __( 'Child Style', 'k2t' ),
								'type'        => 'dropdown',
								'value'      => array(
									__('None', 'k2t') 	=> 'none',
									__('Masonry Free Style', 'k2t') 	=> 'masonry_free_style',
								),
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'text-masonry' ),
								),
								'holder'      => 'div'
							),
							$k2t_animation,
							$k2t_animation_name,
							$k2t_animation_delay,
							$k2t_id,
							$k2t_class
						)
					);
					vc_map( $k2t_project_listing );
				}


			}
	
			add_action( 'admin_init', 'k2t_vc_map_shortcodes' );
	
			/*  [ Extend container class (parents) ]
			- - - - - - - - - - - - - - - - - - - - - - - - - */
			class WPBakeryShortCode_Accordion extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_Brands extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_Iconlist extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_Pricing extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_Sticky_Tab extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_K2t_Slider extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_testimonial extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_K2t_Lincoln_Slider extends WPBakeryShortCodesContainer {}
	
			/*  [ Extend shortcode class (children) ]
			- - - - - - - - - - - - - - - - - - - - - - - - - */
			class WPBakeryShortCode_Toggle extends WPBakeryShortCode {}
			class WPBakeryShortCode_Brand extends WPBakeryShortCode {}
			class WPBakeryShortCode_Li extends WPBakeryShortCode {}
			class WPBakeryShortCode_Pricing_Column extends WPBakeryShortCode {}
			class WPBakeryShortCode_Step extends WPBakeryShortCode {}
			class WPBakeryShortCode_Tab extends WPBakeryShortCode {}
			class WPBakeryShortCode_K2t_Lincoln_Slide extends WPBakeryShortCode {}
	
		endif;
	endif;
	
	/*-------------------------------------------------------------------
		Remove Default Visual Composer Shortcode.
	--------------------------------------------------------------------*/
	if ( class_exists( 'Vc_Manager' ) ) :
		if ( ! function_exists( 'k2t_remove_default_shortcodes' ) ) :
	
			function k2t_remove_default_shortcodes() {

			}
			add_action( 'admin_init', 'k2t_remove_default_shortcodes' );
	
		endif;
	endif;
	
	/*-------------------------------------------------------------------
		Remove Teaser Metabox.
	--------------------------------------------------------------------*/
	if ( class_exists( 'Vc_Manager' ) ) :
		if ( is_admin() ) :
			if ( ! function_exists( 'k2t_vc_remove_teaser_metabox' ) ) :
	
			function k2t_vc_remove_teaser_metabox() {
				$post_types = get_post_types( '', 'names' ); 
				foreach ( $post_types as $post_type ) {
					remove_meta_box( 'vc_teaser',  $post_type, 'side' );
				}
			}
	
			add_action( 'do_meta_boxes', 'k2t_vc_remove_teaser_metabox' );
	
			endif;
		endif;
	endif;
	
	/*-------------------------------------------------------------------
		Incremental ID Counter for Templates.
	--------------------------------------------------------------------*/
	if ( class_exists( 'Vc_Manager' ) ) :
		if ( ! function_exists( 'k2t_vc_templates_id_increment' ) ) :
	
			function k2t_vc_templates_id_increment() {
				static $count = 0; $count++;
				return $count;
			}
	
		endif;
	endif;
	
}