<?php
/**
 * Themes functions config woocommerce.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link http://www.lunartheme.com
 */

// Don't duplicate me!
if ( ! class_exists( 'k2t_template_woo' ) ) {

	/**
	 * Class to apply woocommerce templates
	 *
	 * @since 4.0.0
	 */
	class k2t_template_woo {

		/**
		 * Constructor.
		 * @return  void
		 * @since   1.0
		 */
		function __construct() {
			global $smof_data;

			// Add action
			add_action( 'widgets_init', array( $this, 'k2t_woocommerce_widgets_init' ) );
			add_action( 'wp_enqueue_scripts',  array( $this, 'k2t_woocommerce_enqueue_style' ) );
			add_action( 'after_setup_theme', array( $this, 'k2t_woocommerce_image_dimensions' ), 1 );

			// Add filters
			add_filter( 'add_to_cart_fragments', array( $this, 'k2t_add_to_cart_fragment' ) );
			add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . $smof_data['shop-products-per-page'] . ';' ), 20 );

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25 );
			//woocommerce_template_loop_price
			add_action( 'woocommerce_single_product_summary',  array( $this, 'k2t_woocommerce_before_price' ), 5 );
			add_action( 'woocommerce_single_product_summary',  array( $this, 'k2t_woocommerce_after_rate' ), 10 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			add_action( 'woocommerce_after_single_product_summary',  array( $this, 'k2t_woocommerce_show_or_hide_related_product' ) );

			/**
			 * Add wishlist Shortcode
			 *
			 * @since 1.0
			 */
			function show_add_to_wishlist()
			{
				if ( is_plugin_active('yith-woocommerce-wishlist/init.php')){
					echo do_shortcode('[yith_wcwl_add_to_wishlist]');
				}
			}
			add_action('woocommerce_after_shop_loop_item', 'show_add_to_wishlist', 50 );
			add_action('woocommerce_single_product_summary', 'show_add_to_wishlist', 29 );

			/**
			 * Setting theme options for display results count
			 *
			 * @since 1.0
			 */
			if ( ! $smof_data['shop-display-result-count'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			/**
			 * Setting theme options for display ordering
			 *
			 * @since 1.0
			 */
			if ( ! $smof_data['shop-display-sorting'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}
		}
		/**
		 * Register widget.
		 *
		 * @since 1.0
		 */
		public static function k2t_woocommerce_widgets_init() {
			register_sidebar( array(
				'name'          => __( 'Shop Sidebar', 'k2t' ),
				'id'            => 'shop_sidebar',
				'description'   => __( 'This sidebar is used for WooCommerce Plugin, on shop pages.', 'k2t' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title"><span>',
				'after_title'   => '</span></h2>',
			) );
		}
		/**
		 * Enqueue style.
		 *
		 * @since 1.0
		 */
		public static function k2t_woocommerce_enqueue_style() {
			// Load woocommerce style.
			wp_enqueue_style( 'wcm-style', K2T_THEME_URL . 'assets/css/woocommerce.css' );
		}

	

		/**
		 * Change html structure to before shop item
		 *
		 * @since 1.0
		 */
		public static function k2t_woocommerce_before_shop_loop_item() {
			global $smof_data;
			echo '<article class="product-item"><div class="product-thumb">';
		}

		/**
		 * Change html structure to after shop item
		 *
		 * @since 1.0
		 */
		public static function k2t_woocommerce_after_shop_loop_item() {
			global $product;
			echo '</div></article>';
		}

		/**
		 * Change html structure to before item action
		 *
		 * @since 1.0
		 */
		public static function k2t_woocommerce_before_shop_loop_item_title() {
			echo '</div><div class="product-name">';
		}

		/**
		 * Change html structure to after item action
		 *
		 * @since 1.0
		 */
		public static function k2t_woocommerce_after_shop_loop_item_title() {
			echo '</div><div class="product-meta">';
		}

		

		/**
		 * Change html structure to price and rating on single product
		 *
		 * @since 1.0
		 */
		public static function k2t_woocommerce_before_price() {
			echo '<div class="p-rate-price">';
		}
		public static function k2t_woocommerce_after_rate() {
			echo '</div>';
		}

		/**
		 * Show or hide related product
		 *
		 * @since 1.0
		 */
		public static function k2t_woocommerce_show_or_hide_related_product() {
			global $smof_data;
			if ( $smof_data['product-single-display-related-products'] ) :
				woocommerce_output_related_products();
			endif;
		}

		/**
		 * Wishlist Button
		 *
		 * @return  array
		 * @since 	1.0
		 */
		public static function k2t_wishlist_button() {
		
			global $product, $yith_wcwl; 
			
			if ( class_exists( 'YITH_WCWL_UI' ) )  {
				$url          = $yith_wcwl->get_wishlist_url();
				$product_type = $product->product_type;
				$exists       = $yith_wcwl->is_product_in_wishlist( $product->id );
				$classes      = 'class="add_to_wishlist"';
				
				$html  = '<div class="yith-wcwl-add-to-wishlist">'; 
				    $html .= '<div class="yith-wcwl-add-button';  // the class attribute is closed in the next row	    
				    $html .= $exists ? ' hide" style="display:none;"' : ' show"';		    
				    $html .= '><a href="' . htmlspecialchars( $yith_wcwl->get_addtowishlist_url() ) . '" data-product-id="' . $product->id . '" data-product-type="' . $product_type . '" ' . $classes . ' ><i class="fa fa-heart"></i></a>';
				    $html .= '</div>';
				
				$html .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a href="' . $url . '"><i class="fa fa-heart"></i></a></div>';
				$html .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . $url . '"><i class="fa fa-heart"></i></a></div>';
				$html .= '<div style="clear:both"></div><div class="yith-wcwl-wishlistaddresponse"></div>';
				$html .= '</div>';
				
			return $html;
			}
		}

		/**
		 * Add shopcart menu to header
		 *
		 * @return  array
		 */
		public static function k2t_add_to_cart_fragment( $fragments ) {
			global $woocommerce;
			ob_start();
		?>
			<a class="cart-control" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php _e( 'View your shopping cart', 'emax' ); ?>">
				<i class="zmdi zmdi-shopping-cart"></i>
				<span><?php echo esc_html( $woocommerce->cart->get_cart_contents_count() ); ?></span>
			</a>
		<?php
			$fragments['a.cart-control'] = ob_get_clean();
			return $fragments;
		}
		public static function k2t_shoping_cart() {
			global $woocommerce;

			$cart_total = apply_filters( 'add_to_cart_fragments' , array() );

			echo '<div class="shop-cart">';
			echo ( $cart_total['a.cart-control'] );
			echo '<div class="shop-item">';
			echo '<div class="widget_shopping_cart_content"></div>';
			echo '</div>';
			echo '</div>';
		}

		/**
		 * Set WooCommerce image dimensions upon theme activation
		 * @since 1.0
		 */
		public static function k2t_woocommerce_image_dimensions() {

			global $pagenow;
			if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
				return;
			}

			$catalog = array(
				'width'  => '255', // px
				'height' => '340', // px
				'crop'	 => 1
			);
			 
			$single = array(
				'width'  => '427', // px
				'height' => '546', // px
				'crop'	 => 1
			);
			$thumbnail = array(
				'width' 	=> '90', // px
				'height'	=> '90', // px
				'crop'		=> 1
			);
			 
			// Image sizes
			update_option( 'shop_catalog_image_size', $catalog ); // Product category thumbs
			update_option( 'shop_single_image_size', $single ); // Single product image
			update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs
		}

	}

}
new k2t_template_woo();