<?php
/**
 * K2T Framework
 *
 * WARNING: This file is part of the K2T Core Framework.
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @version: 1.0
 * @package  K2T/Template
 * @author   themelead
 * @link     http://www.lunartheme.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Dont duplicate me!
if ( ! class_exists( 'K2TCoreFrontendWalker' ) ) {
	class K2TCoreFrontendWalker extends Walker_Nav_Menu {

		/**
		 *
		 *
		 * @var string $menu_megamenu_status are we currently rendering a mega menu?
		 */
		private $menu_megamenu_status = "";

		/**
		 *
		 *
		 * @var string $menu_megamenu_width use full width mega menu?
		 */
		private $menu_megamenu_width = "";

		/**
		 *
		 *
		 * @var string $menu_megamenu_position
		 */
		private $menu_megamenu_position = "";

		/**
		 *
		 *
		 * @var string $menu_megamenu_bg_image
		 */
		private $menu_megamenu_bg_image = "";

		/**
		 *
		 *
		 * @var string $menu_megamenu_bg_repeat
		 */
		private $menu_megamenu_bg_repeat = "";

		/**
		 *
		 *
		 * @var string $menu_megamenu_bg_size
		 */
		private $menu_megamenu_bg_size = "";

		/**
		 *
		 *
		 * @var string $menu_megamenu_bg_position
		 */
		private $menu_megamenu_bg_position = "";

		/**
		 *
		 *
		 * @var string $menu_megamenu_widget
		 */
		private $menu_megamenu_widget = "";

		/**
		 *
		 *
		 * @see Walker::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string  $output Passed by reference. Used to append additional content.
		 * @param int     $depth  Depth of page. Used for padding.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );

			if ( $depth === 0 && $this->menu_megamenu_status == "enabled" ) {
				$output .= "\n{first_level}\n";
				$output .= "\n$indent<ul>\n";
			} elseif ( $depth >= 2 && $this->menu_megamenu_status == "enabled" ) {
				$output .= "\n$indent<ul class=\"sub-menu deep-level\">\n";
			} else {
				$output .= "\n$indent<ul class=\"sub-menu\">\n";
			}
		}

		/**
		 *
		 *
		 * @see Walker::end_lvl()
		 * @since 3.0.0
		 *
		 * @param string  $output Passed by reference. Used to append additional content.
		 * @param int     $depth  Depth of page. Used for padding.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );
			$row_width = '';

			if ( $depth === 0  && $this->menu_megamenu_status == "enabled" ) {

				$output .= "\n</ul></div>\n";
				$menu_megamenu_bg_image_html    = ! empty( $this->menu_megamenu_bg_image ) ? 'background-image:url('.$this->menu_megamenu_bg_image.');' : '';
				$menu_megamenu_bg_repeat_html   = ! empty( $this->menu_megamenu_bg_repeat ) && ! empty( $this->menu_megamenu_bg_image ) ? 'background-repeat:'.$this->menu_megamenu_bg_repeat.';' : '';
				$menu_megamenu_bg_size_html     = ! empty( $this->menu_megamenu_bg_size ) && ! empty( $this->menu_megamenu_bg_image ) ? 'background-size:'.$this->menu_megamenu_bg_size.';-webkit-background-size:'.$this->menu_megamenu_bg_size.';-moz-background-size:'.$this->menu_megamenu_bg_size.';' : '';
				$menu_megamenu_bg_position_html = ! empty( $this->menu_megamenu_bg_position ) && ! empty( $this->menu_megamenu_bg_image ) ? 'background-position:'.$this->menu_megamenu_bg_position.';' : '';
				$output = str_replace( "{first_level}", "<div class=\"mega-container\" style=\"" . $menu_megamenu_bg_image_html . $menu_megamenu_bg_repeat_html . $menu_megamenu_bg_size_html . $menu_megamenu_bg_position_html . "\">", $output );

			} else {
				$output .= "$indent</ul>\n";
			}
		}

		/**
		 *
		 *
		 * @see Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string  $output       Passed by reference. Used to append additional content.
		 * @param object  $item         Menu item data object.
		 * @param int     $depth        Depth of menu item. Used for padding.
		 * @param int     $current_page Menu item ID.
		 * @param object  $args
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $smof_data;

			$item_output = $class_columns = '';
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			/* set some vars */
			if ( $depth === 0 ) {

				$this->menu_megamenu_status = get_post_meta( $item->ID, '_menu_item_k2t_megamenu_status', true );
				$this->menu_megamenu_width = get_post_meta( $item->ID, '_menu_item_k2t_megamenu_width', true );
				$this->menu_megamenu_position = get_post_meta( $item->ID, '_menu_item_k2t_megamenu_position', true );
				$this->menu_megamenu_bg_image = get_post_meta( $item->ID, '_menu_item_k2t_megamenu_bg_image', true );
				$this->menu_megamenu_bg_repeat = get_post_meta( $item->ID, '_menu_item_k2t_megamenu_bg_repeat', true );
				$this->menu_megamenu_bg_size = get_post_meta( $item->ID, '_menu_item_k2t_megamenu_bg_size', true );
				$this->menu_megamenu_bg_position = get_post_meta( $item->ID, '_menu_item_k2t_megamenu_bg_position', true );
			}

			$this->menu_megamenu_icon = get_post_meta( $item->ID, '_menu_item_k2t_megamenu_icon', true );
			$this->menu_megamenu_widget = get_post_meta( $item->ID, '_menu_item_k2t_megamenu_widget', true );

			/* we are inside a mega menu */
			if ( $depth === 1 && $this->menu_megamenu_status == "enabled" ) {
				
				if ( !empty( $this->menu_megamenu_widget ) ) {
					ob_start();
					dynamic_sidebar( $this->menu_megamenu_widget );
					$item_output .= ob_get_clean();
				}

				$title = apply_filters( 'the_title', $item->title, $item->ID );

				$heading = do_shortcode( $title );

				if ( empty( $this->menu_megamenu_widget ) ) {
					$item_output .= '<a href="'.esc_url( $item->url ).'" title="'.$title.'">'.$heading.'</a>';
				}

			} else {

				$atts = array();
				$atts['title']  = ! empty( $item->attr_title ) ? 'title="'  . esc_attr( $item->attr_title ) .'"' : '';
				$atts['target'] = ! empty( $item->target )     ? 'target="' . esc_attr( $item->target     ) .'"' : '';
				$atts['rel']    = ! empty( $item->xfn )      ? 'rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				$atts['url']    = ! empty( $item->url )         ? 'href="'   . esc_url( $item->url        ) .'"' : '';
				$atts['class']  = ! empty( $this->menu_megamenu_icon ) ? 'class="btn-ripple has-icon"' : 'class="btn-ripple"';
				$attributes = implode( ' ', $atts );

				$item_output .= $args->before;
				/* check if ne need to set an image */
				$item_output .= '<a '. $attributes .'>';

				if ( !empty( $this->menu_megamenu_icon ) ){
					$item_output .= '<i class="'. $this->menu_megamenu_icon .'"><!----></i>';
				}

				$item_output .= $args->link_before . '<span class="k2t-title-menu">' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>' . $args->link_after;

				if ( $depth === 0 && $args->has_children ) {
					$item_output .= ' <span class="caret"></span></a>';
				} else {
					$item_output .= '</a>';
				}
				$item_output .= $args->after;

			}

			/* check if we need to apply a divider */
			if ( $this->menu_megamenu_status != "enabled" && ( ( strcasecmp( $item->attr_title, 'divider' ) == 0 ) ||
					( strcasecmp( $item->title, 'divider' ) == 0 ) )
			) {
				$output .= $indent . '<li role="presentation" class="divider">';
			} else {

				$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

				$class_names = $value = '';
				$classes = empty( $item->classes ) ? array() : ( array ) $item->classes;
				$classes[] = 'menu-item-' . $item->ID;

				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );


				if ( $depth === 0 && $args->has_children ) {
					if ( $this->menu_megamenu_status == "enabled" && $this->menu_megamenu_width == 'yes' ) {
						$class_names .= ' k2t-megamenu mega-type-fullwidth mega-5';
					}elseif ( $this->menu_megamenu_status == "enabled" && $this->menu_megamenu_width == 'no' ) {
						if ( $this->menu_megamenu_position == 'fit-left' ) {
							$class_names .= ' k2t-megamenu mega-type-autowidth mega-4 fit-left';
						}elseif ( $this->menu_megamenu_position == 'fit-right' ) {
							$class_names .= ' k2t-megamenu mega-type-autowidth mega-4 fit-right';
						}
					}else {
						$class_names .= ' ';
					}
				}

				if ( $depth === 1 ) {
					if ( $this->menu_megamenu_status == "enabled" ) {
						$class_names .= ' k2t-megamenu-submenu';
					} else {
						$class_names .= ' k2t-dropdown-submenu';
					}
				}

				$class_names = $class_names ? ' class="' . esc_attr( $class_names ). $class_columns . '"' : '';

				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

				$output .= $indent . '<li' . $id . $value . $class_names .'>';

				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}

		/**
		 *
		 *
		 * @see Walker::end_el()
		 *
		 * @param string  $output Passed by reference. Used to append additional content.
		 * @param object  $item   Page data object. Not used.
		 * @param int     $depth  Depth of page. Not Used.
		 */
		function end_el( &$output, $item, $depth = 0, $args = array() ) {
			$output .= "</li>\n";
		}

		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth.
		 *
		 * This method shouldn't be called directly, use the walk() method instead.
		 *
		 * @see Walker::start_el()
		 * @since 2.5.0
		 *
		 * @param object  $element           Data object
		 * @param array   $children_elements List of elements to continue traversing.
		 * @param int     $max_depth         Max depth to traverse.
		 * @param int     $depth             Depth of current element.
		 * @param array   $args
		 * @param string  $output            Passed by reference. Used to append additional content.
		 * @return null Null on failure with no changes to parameters.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element )
				return;

			$id_field = $this->db_fields['id'];

			// Display this element.
			if ( is_object( $args[0] ) )
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a manu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array   $args passed from the wp_nav_menu function.
		 *
		 */
		public static function fallback( $args ) {
			if ( current_user_can( 'manage_options' ) ) {

				extract( $args );

				$fb_output = null;

				return $fb_output;
			}
		}
	}  // end K2TCoreFrontendWalker() class
}

// Don't duplicate me!
if ( ! class_exists( 'K2TCoreMegaMenus' ) ) {

	class K2TCoreMegaMenus extends Walker_Nav_Menu {

		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker_Nav_Menu::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string  $output Passed by reference.
		 * @param int     $depth  Depth of menu item. Used for padding.
		 * @param array   $args   Not used.
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker_Nav_Menu::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string  $output Passed by reference.
		 * @param int     $depth  Depth of menu item. Used for padding.
		 * @param array   $args   Not used.
		 */
		function end_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * Start the element output.
		 *
		 * @see Walker_Nav_Menu::start_el()
		 * @since 3.0.0
		 *
		 * @param string  $output Passed by reference. Used to append additional content.
		 * @param object  $item   Menu item data object.
		 * @param int     $depth  Depth of menu item. Used for padding.
		 * @param array   $args   Not used.
		 * @param int     $id     Not used.
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $_wp_nav_menu_max_depth, $wp_registered_sidebars;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			ob_start();
			$item_id = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = '';
			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) )
					$original_title = false;
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
				$original_title = get_the_title( $original_object->ID );
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive' ),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( __( '%s (Invalid)', 'k2t' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( __( '%s (Pending)', 'k2t' ), $item->title );
			}

			$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

			$submenu_text = '';
			if ( 0 == $depth )
				$submenu_text = 'style="display: none;"';

?>
			<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo ( $submenu_text ); ?>><?php _e( 'sub item', 'k2t' ); ?></span></span>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-order hide-if-js">
								<a href="<?php
			echo esc_url(
				add_query_arg(
					array(
						'action' => 'move-up-menu-item',
						'menu-item' => $item_id,
					)
				),
				'move-menu_item'
			);
			?>" class="item-move-up"><abbr title="<?php esc_attr_e( 'Move up', 'k2t' ); ?>">&#8593;</abbr></a>
								|
								<a href="<?php
			echo esc_url(
				add_query_arg(
					array(
						'action' => 'move-down-menu-item',
						'menu-item' => $item_id,
					)
				),
				'move-menu_item'
			);
			?>" class="item-move-down"><abbr title="<?php esc_attr_e( 'Move down', 'k2t' ); ?>">&#8595;</abbr></a>
							</span>
							<a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" title="<?php esc_attr_e( 'Edit Menu Item', 'k2t' ); ?>" href="<?php
			echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : esc_url( add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) );
			?>"><?php _e( 'Edit Menu Item', 'k2t' ); ?></a>
						</span>
					</dt>
				</dl>

				<div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
					<?php if ( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
								<?php _e( 'URL', 'k2t' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-thin">
						<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
							<?php _e( 'Navigation Label', 'k2t' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
							<?php _e( 'Title Attribute', 'k2t' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
							<?php _e( 'Open link in a new window/tab', 'k2t' ); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
							<?php _e( 'CSS Classes (optional)', 'k2t' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode( ' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
							<?php _e( 'Link Relationship (XFN)', 'k2t' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
							<?php _e( 'Description', 'k2t' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
							<span class="description"><?php _e( 'The description will be displayed in the menu if the current theme supports it.', 'k2t' ); ?></span>
						</label>
					</p>
					<?php do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args ); ?>
					<div class="clear"></div>
					<div class="k2t-mega-menu-options">
						<div class="field-megamenu-icon description-wide">
							<label for="edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ); ?>">
								<?php _e( 'Menu Icon', 'k2t' ); ?>
								<div>
									<?php 
										$display 				= ( isset( $item->k2t_megamenu_icon ) && $item->k2t_megamenu_icon != "" ) ? "display:inline-block;" : 'display:none;'; 
										$input_width 			= ( isset( $item->k2t_megamenu_icon ) && $item->k2t_megamenu_icon != "" ) ? 'width: 275px;' : 'width: 348px;';
									?>
									<span class="k2t-icon-preview" rel-icon="edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ); ?>" style="<?php echo ( $display );?>"><i class="<?php echo esc_attr( $item->k2t_megamenu_icon );?>"></i></span>
									
									<input type="text" id="edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ); ?>" class="k2t-receive-icon widefat code edit-menu-item-megamenu-icon enable-mega" name="menu-item-k2t-megamenu-icon[<?php echo esc_attr( $item_id) ; ?>]" value="<?php echo esc_attr( $item->k2t_megamenu_icon );?>"  style="<?php echo ( $input_width );?>"/>
									<a class="button k2t-add-icon" for="edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ); ?>" title="Add Icon">
										<span class="awesome-plus"></span>
									</a>
									<a remove-for="edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ); ?>" class="button k2t-remove-icon" title="Remove Icon" style="<?php echo ( $display );?>">
										<span class="awesome-minus"></span>
									</a>
								</div>	
							</label>
						</div>
						<p class="field-megamenu-status description-wide">
							<label for="edit-menu-item-megamenu-status-<?php echo esc_attr( $item_id ); ?>">
								<input type="checkbox" id="edit-menu-item-megamenu-status-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-status enable-mega" name="menu-item-k2t-megamenu-status[<?php echo esc_attr( $item_id ); ?>]" value="enabled" <?php checked( $item->k2t_megamenu_status, 'enabled' ); ?> />
								<strong><?php _e( 'Enable Mega Menu', 'k2t' ); ?></strong>
							</label>
						</p>
						<script>
							/*
							Bind Click For Menu Item
							*/
							(function($) {
								"use strict";
									$(document).ready(function() {
										/*
											Mega Menu Js		
										*/	
										var parent_<?php echo esc_attr( $item_id ); ?> = jQuery("#edit-menu-item-megamenu-status-<?php echo esc_attr( $item_id ); ?>").parent().parent().parent();
										var HideMega_<?php echo esc_attr( $item_id ); ?>   = jQuery( 'p.hide', parent_<?php echo esc_attr( $item_id ); ?> );
										if( jQuery( "#edit-menu-item-megamenu-status-<?php echo esc_attr( $item_id ); ?>" ).is( ':checked' ) && jQuery( "#edit-menu-item-megamenu-status-<?php echo esc_attr( $item_id ); ?>" ).val() == 'enabled' ) {
											HideMega_<?php echo esc_attr( $item_id ); ?>.css( 'display', 'block' );
										} else {
											HideMega_<?php echo esc_attr( $item_id ); ?>.css( 'display', 'none' );
										}
										jQuery("#edit-menu-item-megamenu-status-<?php echo esc_attr( $item_id ); ?>").bind('click',function(){		
											var parent = jQuery(this).parent().parent().parent();
											var HideMega   = jQuery( 'p.hide', parent );
											if( jQuery( this ).is( ':checked' ) && jQuery( this ).val() == 'enabled' ) {
												HideMega.css( 'display', 'block' );
											} else {
												HideMega.css( 'display', 'none' );
											}
										});
										/*
											End Mega Menu
										*/
									});
							})(jQuery);
							/*
							End Bind Click
							*/	
						</script>
                        <p class="field-megamenu-width description description-thin hide">
                            <label for="edit-menu-item-megamenu-width-<?php echo esc_attr( $item_id ); ?>">
                            	<?php _e( 'Mega menu fullwidth?', 'k2t' ); ?><br />
                                <select id="edit-menu-item-megamenu-width-<?php echo esc_attr( $item_id ); ?>" name="menu-item-k2t-megamenu-width[<?php echo esc_attr( $item_id ); ?>]" class="widefat code edit-menu-item-classes">
                                	<option value="yes" <?php selected( $item->k2t_megamenu_width, 'yes' );?>><?php _e( 'Yes', 'k2t' );?></option>
                                    <option value="no" <?php selected( $item->k2t_megamenu_width, 'no' );?>><?php _e( 'No', 'k2t' );?></option>
                                </select>
                            </label>
						</p>
                        <p class="field-megamenu-position description description-thin hide">
                            <label for="edit-menu-item-megamenu-position-<?php echo esc_attr( $item_id ); ?>">
                            	<?php _e( 'Mega menu position?', 'k2t' ); ?><br />
                                <select id="edit-menu-item-megamenu-position-<?php echo esc_attr( $item_id ); ?>" name="menu-item-k2t-megamenu-position[<?php echo esc_attr( $item_id ); ?>]" class="widefat code edit-menu-item-classes">
                                	<option value="fit-left" <?php selected( $item->k2t_megamenu_position, 'fit-left' );?>><?php _e( 'Left', 'k2t' );?></option>
                                    <option value="fit-right" <?php selected( $item->k2t_megamenu_position, 'fit-right' );?>><?php _e( 'Right', 'k2t' );?></option>
                                </select>
                            </label>
						</p>
                        <p class="field-megamenu-bg-image description description-wide hide">
                            <label for="edit-menu-item-megamenu-bg-image-<?php echo esc_attr( $item_id ); ?>">
                            	<?php _e( 'Mega menu background', 'k2t' ); ?><br />
                                <input style="width: 275px;" id="edit-menu-item-megamenu-bg-image-<?php echo esc_attr( $item_id ); ?>" name="menu-item-k2t-megamenu-bg_image[<?php echo esc_attr( $item_id ); ?>]" type="text" value="<?php echo esc_attr( $item->k2t_megamenu_bg_image );?>" />
                                <input class="button" onclick="k2t_upload_image_button('edit-menu-item-megamenu-bg-image-<?php echo esc_attr( $item_id ); ?>')" type="button" value="<?php _e( 'Upload Image', 'k2t' );?>" />
                            </label>
						</p>
                        <p class="field-megamenu-bg-repeat description description-thin hide">
                            <label for="edit-menu-item-megamenu-bg-repeat-<?php echo esc_attr( $item_id ); ?>">
                            	<?php _e( 'Mega menu background repeat', 'k2t' ); ?><br />
                                <select id="edit-menu-item-megamenu-bg-repeat-<?php echo esc_attr( $item_id ); ?>" name="menu-item-k2t-megamenu-bg_repeat[<?php echo esc_attr( $item_id ); ?>]" class="widefat code edit-menu-item-classes">
                                	<option value="no-repeat" <?php selected( $item->k2t_megamenu_bg_repeat, 'no-repeat' );?>><?php _e( 'No repeat', 'k2t' );?></option>
                                    <option value="repeat" <?php selected( $item->k2t_megamenu_bg_repeat, 'repeat' );?>><?php _e( 'Repeat', 'k2t' );?></option>
                                    <option value="repeat-x" <?php selected( $item->k2t_megamenu_bg_repeat, 'repeat-x' );?>><?php _e( 'Repeat x', 'k2t' );?></option>
                                    <option value="repeat-y" <?php selected( $item->k2t_megamenu_bg_repeat, 'repeat-y' );?>><?php _e( 'Repeat y', 'k2t' );?></option>
                                </select>
                            </label>
						</p>
						<p class="field-megamenu-bg-size description description-thin hide">
                            <label for="edit-menu-item-megamenu-bg-size-<?php echo esc_attr( $item_id ); ?>">
                            	<?php _e( 'Mega menu background size', 'k2t' ); ?><br />
                                <select id="edit-menu-item-megamenu-bg-size-<?php echo esc_attr( $item_id ); ?>" name="menu-item-k2t-megamenu-bg_size[<?php echo esc_attr( $item_id ); ?>]" class="widefat code edit-menu-item-classes">
                                	<option value="auto" <?php selected( $item->k2t_megamenu_bg_size, 'auto' );?>><?php _e( 'Auto', 'k2t' );?></option>
                                    <option value="cover" <?php selected( $item->k2t_megamenu_bg_size, 'cover' );?>><?php _e( 'Cover', 'k2t' );?></option>
                                    <option value="contain" <?php selected( $item->k2t_megamenu_bg_size, 'contain' );?>><?php _e( 'Contain', 'k2t' );?></option>
                                </select>
                            </label>
						</p>
                        <p class="field-megamenu-bg-position description description-thin hide">
                            <label for="edit-menu-item-megamenu-bg-position-<?php echo esc_attr( $item_id ); ?>">
                            	<?php _e( 'Mega menu bg position', 'k2t' ); ?>
                                <select id="edit-menu-item-megamenu-bg-position-<?php echo esc_attr( $item_id ); ?>" name="menu-item-k2t-megamenu-bg_position[<?php echo esc_attr( $item_id ); ?>]" class="widefat code edit-menu-item-classes">
                                	<option value="left top" <?php selected( $item->k2t_megamenu_bg_position, 'left top' )?>><?php _e( 'Left Top', 'k2t' )?></option>
                                    <option value="left center" <?php selected( $item->k2t_megamenu_bg_position, 'left center' )?>><?php _e( 'Left Center', 'k2t' )?></option>
                                    <option value="left bottom" <?php selected( $item->k2t_megamenu_bg_position, 'left bottom' )?>><?php _e( 'Left Bottom', 'k2t' )?></option>
                                    <option value="right top" <?php selected( $item->k2t_megamenu_bg_position, 'right top' )?>><?php _e( 'Right Top', 'k2t' )?></option>
                                    <option value="right center" <?php selected( $item->k2t_megamenu_bg_position, 'right center' )?>><?php _e( 'Right Center', 'k2t' )?></option>
                                    <option value="right bottom" <?php selected( $item->k2t_megamenu_bg_position, 'right bottom' )?>><?php _e( 'Right Bottom', 'k2t' )?></option>
                                    <option value="center top" <?php selected( $item->k2t_megamenu_bg_position, 'center top' )?>><?php _e( 'Center Top', 'k2t' )?></option>
                                    <option value="center center" <?php selected( $item->k2t_megamenu_bg_position, 'center center' )?>><?php _e( 'Center Center', 'k2t' )?></option>
                                    <option value="center bottom" <?php selected( $item->k2t_megamenu_bg_position, 'center bottom' )?>><?php _e( 'Center Bottom', 'k2t' )?></option>
                                </select>
                            </label>
						</p>
                        <p class="field-megamenu-widget description description-thin hide">
                            <label for="edit-menu-item-megamenu-widget-<?php echo esc_attr( $item_id ); ?>">
                            	<?php _e( 'Mega menu widget', 'k2t' ); ?>
                                <select id="edit-menu-item-megamenu-widget-<?php echo esc_attr( $item_id ); ?>" name="menu-item-k2t-megamenu-widget[<?php echo esc_attr( $item_id ); ?>]" class="widefat code edit-menu-item-classes">
                                <option value="none" <?php selected( $item->k2t_megamenu_widget, 'none' )?>><?php _e( 'None', 'k2t' );?></option>
                                <?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { ?>
                                     <option <?php selected( $item->k2t_megamenu_widget, ucwords( $sidebar['id'] ) )?> value="<?php echo ucwords( esc_attr( $sidebar['id'] ) ); ?>">
                                              <?php echo ucwords( $sidebar['name'] ); ?>
                                     </option>
                                <?php } ?>
                                </select>
                            </label>
						</p>
                        <div style="clear:both;margin-bottom: 10px;"></div>
					</div><!-- .k2t-mega-menu-options-->
                    <div style="clear:both;"></div>
					<p class="field-move hide-if-no-js description description-wide">
						<label>
							<span><?php _e( 'Move', 'k2t' ); ?></span>
							<a href="#" class="menus-move-up"><?php _e( 'Up one', 'k2t' ); ?></a>
							<a href="#" class="menus-move-down"><?php _e( 'Down one', 'k2t' ); ?></a>
							<a href="#" class="menus-move-left"></a>
							<a href="#" class="menus-move-right"></a>
							<a href="#" class="menus-move-top"><?php _e( 'To the top', 'k2t' ); ?></a>
						</label>
					</p>

					<div class="menu-item-actions description-wide submitbox">
						<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
							<p class="link-to-original">
								<?php printf( __( 'Original: %s', 'k2t' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
			echo esc_url(
				add_query_arg(
					array(
						'action' => 'delete-menu-item',
						'menu-item' => $item_id,
					),
					admin_url( 'nav-menus.php' )
				),
				'delete-menu_item_' . $item_id
			); ?>"><?php _e( 'Remove', 'k2t' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
			?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php _e( 'Cancel', 'k2t' ); ?></a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}

	} // end K2TCoreMegaMenus() class

}


// Don't duplicate me!
if ( ! class_exists( 'K2TMegaMenu' ) ) {

	/**
	 * Class to manipulate menus
	 *
	 * @since 3.4
	 */
	class K2TMegaMenu extends K2TMegaMenuFramework {

		function __construct() {

			add_action( 'wp_update_nav_menu_item', array( $this, 'save_custom_fields' ), 10, 3 );
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'add_custom_fields' ) );
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_data_to_menu' ) );

		} // end __construct();


		/**
		 * Function to replace normal edit nav walker for K2T Core mega menus
		 *
		 * @return string Class name of new navwalker
		 */
		function add_custom_fields() {

			return 'K2TCoreMegaMenus';

		}

		/**
		 * Add the custom fields menu item data to fields in database
		 *
		 * @return void
		 */
		function save_custom_fields( $menu_id, $menu_item_db_id, $args ) {

			$field_name_suffix = array( 'icon', 'status', 'width', 'position', 'bg_image', 'bg_repeat', 'bg_size', 'bg_position', 'widget' );
			if ( !isset( $_REQUEST['menu-item-k2t-megamenu-status'][$menu_item_db_id] ) ) {
				$_REQUEST['menu-item-k2t-megamenu-status'][$menu_item_db_id] = '';
			}
			$megamenu_status = $_REQUEST['menu-item-k2t-megamenu-status'][$menu_item_db_id];

			if ( !empty( $megamenu_status ) ) {
				foreach ( $field_name_suffix as $key ) {
					if ( !isset( $_REQUEST['menu-item-k2t-megamenu-'.$key][$menu_item_db_id] ) ) {
						$_REQUEST['menu-item-k2t-megamenu-'.$key][$menu_item_db_id] = '';
					}

					$value = $_REQUEST['menu-item-k2t-megamenu-'.$key][$menu_item_db_id];
					update_post_meta( $menu_item_db_id, '_menu_item_k2t_megamenu_'.$key, $value );
				}}else {
				foreach ( $field_name_suffix as $key ) {
					delete_post_meta( $menu_item_db_id, '_menu_item_k2t_megamenu_'.$key );
				}
			} 
			if ( isset( $_REQUEST['menu-item-k2t-megamenu-icon'][$menu_item_db_id] ) ) {
				$value = $_REQUEST['menu-item-k2t-megamenu-icon'][$menu_item_db_id];
				update_post_meta( $menu_item_db_id, '_menu_item_k2t_megamenu_icon', $value );
			}
			
		}

		/**
		 * Add custom fields data to the menu
		 *
		 * @return object Add custom fields data to the menu object
		 */
		function add_data_to_menu( $menu_item ) {

			$menu_item->k2t_megamenu_icon = get_post_meta( $menu_item->ID, '_menu_item_k2t_megamenu_icon', true );
			$menu_item->k2t_megamenu_status = get_post_meta( $menu_item->ID, '_menu_item_k2t_megamenu_status', true );
			$menu_item->k2t_megamenu_width = get_post_meta( $menu_item->ID, '_menu_item_k2t_megamenu_width', true );
			$menu_item->k2t_megamenu_position = get_post_meta( $menu_item->ID, '_menu_item_k2t_megamenu_position', true );
			$menu_item->k2t_megamenu_bg_image = get_post_meta( $menu_item->ID, '_menu_item_k2t_megamenu_bg_image', true );
			$menu_item->k2t_megamenu_bg_repeat = get_post_meta( $menu_item->ID, '_menu_item_k2t_megamenu_bg_repeat', true );
			$menu_item->k2t_megamenu_bg_size = get_post_meta( $menu_item->ID, '_menu_item_k2t_megamenu_bg_size', true );
			$menu_item->k2t_megamenu_bg_position = get_post_meta( $menu_item->ID, '_menu_item_k2t_megamenu_bg_position', true );
			$menu_item->k2t_megamenu_widget = get_post_meta( $menu_item->ID, '_menu_item_k2t_megamenu_widget', true );
			return $menu_item;
		}

	} // end K2TMegaMenu() class

}