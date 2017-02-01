<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme option
global $smof_data;
?>
	</div><!-- .k2t-body -->

	<?php if ( ! is_404() ) : ?>
	<footer class="k2t-footer">

		<?php
			// Get bottom info
			$bottom_background_image    = $smof_data['bottom-background-image'];
			$bottom_background_color    = $smof_data['bottom-background-color'];
			$bottom_background_repeat   = $smof_data['bottom-background-repeat'];
			$bottom_background_size     = $smof_data['bottom-background-size'];
			$bottom_background_position = $smof_data['bottom-background-position'];
			$bottom_sidebars_layout     = $smof_data['bottom-sidebars-layout'];

			// Get footer info
			$footer_background_image    = $smof_data['footer-background-image'];
			$footer_background_color    = $smof_data['footer-background-color'];
			$footer_background_repeat   = $smof_data['footer-background-repeat'];
			$footer_background_size     = $smof_data['footer-background-size'];
			$footer_background_position = $smof_data['footer-background-position'];

			$bottom_class = $footer_class = array();

			if ( ! empty( $bottom_background_image ) ) {
				$bottom_class[] = 'background-image:url(' . $bottom_background_image . ');';
			}
			if ( ! empty( $bottom_background_color ) ) {
				$bottom_class[] = 'background-color:' . $bottom_background_color . ';';
			}
			if ( ! empty( $bottom_background_repeat ) ) {
				$bottom_class[] = 'background-repeat:' . $bottom_background_repeat . ';';
			}
			if ( ! empty( $bottom_background_size ) ) {
				$bottom_class[] = 'background-size:' . $bottom_background_size . ';';
			}
			if ( ! empty( $bottom_background_position ) ) {
				$bottom_class[] = 'background-position:' . $bottom_background_position . ';';
			}

			if ( ! empty( $footer_background_image ) ) {
				$footer_class[] = 'background-image:url(' . $footer_background_image . ');';
			}
			if ( ! empty( $footer_background_color ) ) {
				$footer_class[] = 'background-color:' . $footer_background_color . ';';
			}
			if ( ! empty( $footer_background_repeat ) ) {
				$footer_class[] = 'background-repeat:' . $footer_background_repeat . ';';
			}
			if ( ! empty( $footer_background_size ) ) {
				$footer_class[] = 'background-size:' . $footer_background_size . ';';
			}
			if ( ! empty( $footer_background_position ) ) {
				$footer_class[] = 'background-position:' . $footer_background_position . ';';
			}
		?>

		<?php 
			// Render footer bottom
			ob_start();
			if ( ! empty( $bottom_sidebars_layout ) ) {
				switch( $bottom_sidebars_layout ) {
					case 'layout-2':
						for ( $i = 1; $i <= 3; $i++ ) {
							if ( is_dynamic_sidebar( 'footer-' . $i ) ) {
								echo '<div class="col-4">'; 
									dynamic_sidebar( 'footer-' . $i );
								echo '</div>';
							}
						}
						break;
					case 'layout-3':
						for ( $i = 1; $i <= 3; $i++ ) {
							if ( is_dynamic_sidebar( 'footer-' . $i ) ) {
								if ( $i == 1 ) {
									echo '<div class="col-6">';
								} else {
									echo '<div class="col-3">'; 
								}
									dynamic_sidebar( 'footer-' . $i );
								echo '</div>';
							}
						}
						break;
					case 'layout-4':
						for ( $i = 1; $i <= 3; $i++ ) {
							if ( is_dynamic_sidebar( 'footer-' . $i ) ) {
								if ( $i == 2 ) {
									echo '<div class="col-6">';
								} else {
									echo '<div class="col-3">'; 
								}
									dynamic_sidebar( 'footer-' . $i );
								echo '</div>';
							}
						}
						break;
					case 'layout-5':
						for ( $i = 1; $i <= 3; $i++ ) {
							if ( is_dynamic_sidebar( 'footer-' . $i ) ) {
								if ( $i == 3 ) {
									echo '<div class="col-6">';
								} else {
									echo '<div class="col-3">'; 
								}
									dynamic_sidebar( 'footer-' . $i );
								echo '</div>';
							}
						}
						break;
					case 'layout-6':
						for ( $i = 1; $i <= 2; $i++ ) {
							if ( is_dynamic_sidebar( 'footer-' . $i ) ) {
								echo '<div class="col-6">'; 
									dynamic_sidebar( 'footer-' . $i );
								echo '</div>';
							}
						}
						break;
					case 'layout-7':
						for ( $i = 1; $i <= 1; $i++ ) {
							if ( is_dynamic_sidebar( 'footer-' . $i ) ) {
								echo '<div class="col-12">'; 
									dynamic_sidebar( 'footer-' . $i );
								echo '</div>';
							}
						}
						break;
					default:
						for ( $i = 1; $i <= 4; $i++ ) {
							if ( is_dynamic_sidebar( 'footer-' . $i ) ) {
								echo '<div class="col-3">'; 
									dynamic_sidebar( 'footer-' . $i );
								echo '</div>';
							}
						}
						break;
				}
			}
			$footer_bottom = ob_get_clean();
		?>

		<?php $footer_bottom_check = str_replace( '<div class="col-4"></div>', '', $footer_bottom ); if ( ! empty( $footer_bottom_check ) ) : ?>
			<div class="k2t-bottom" style="<?php echo esc_attr( implode( ' ', $bottom_class ) ); ?>">
				<div class="k2t-wrap">
					<div class="k2t-row">
						<?php echo ( $footer_bottom );?>
					</div><!-- .k2t-row -->
				</div><!-- .k2t-wrap -->
			</div><!-- .k2t-bottom -->
		<?php endif;?>

		<?php if( $smof_data['footer-copyright-text'] != '' || $smof_data['footer-bottom-menu'] ): ?>
			<div class="k2t-info" style="<?php echo esc_attr( implode( ' ', $footer_class ) ); ?>">
				<div class="container">
					<div class="k2t-row">
						<?php if( $smof_data['footer-copyright-text'] != '' ): ?>
							<div class="col-6">
								<?php echo ( $smof_data['footer-copyright-text'] ); ?>
							</div>
						<?php endif;?>
						<?php if ( $smof_data['footer-bottom-menu'] ) : ?>
							<div class="col-6">
								<?php
									if(is_active_sidebar('footer-bottom')){
										dynamic_sidebar('footer-bottom');
										}
									?>
							</div>
						<?php endif;?>
					</div>
				</div>
			</div><!-- .k2t-info -->
		<?php endif;?>

	</footer><!-- .k2t-footer -->
	<?php endif;?>
</div><!-- .k2t-container -->

<!-- Show Offcanvas sidebar -->
<?php if ( $smof_data['offcanvas-turnon'] && ! is_404() ) : ?>
	<?php
	$offcanvas_style = '';
	
	if ( isset( $smof_data['offcanvas-sidebar-background-image'] ) && $smof_data['offcanvas-sidebar-background-image'] ) {
		$offcanvans_sidebar_background_image = $smof_data['offcanvas-sidebar-background-image'];
	}
	if ( ! empty( $offcanvans_sidebar_background_image ) ) {
		$offcanvas_style .= 'background-image: url(' . $offcanvans_sidebar_background_image . ');';
	}

	if ( isset( $smof_data['offcanvas-sidebar-background-position'] ) && $smof_data['offcanvas-sidebar-background-position'] ) {
		$offcanvans_sidebar_background_position = $smof_data['offcanvas-sidebar-background-position'];
	}
	if ( ! empty( $offcanvans_sidebar_background_position ) ) {
		$offcanvas_style .= 'background-position: ' . $offcanvans_sidebar_background_position . ';';
	}

	if ( isset( $smof_data['offcanvas-sidebar-background-repeat'] ) && $smof_data['offcanvas-sidebar-background-repeat'] ) {
		$offcanvans_sidebar_background_repeat = $smof_data['offcanvas-sidebar-background-repeat'];
	}
	if ( ! empty( $offcanvans_sidebar_background_repeat ) ) {
		$offcanvas_style .= 'background-repeat: ' . $offcanvans_sidebar_background_repeat . ';';
	}

	if ( isset( $smof_data['offcanvas-sidebar-background-size'] ) && $smof_data['offcanvas-sidebar-background-size'] ) {
		$offcanvans_sidebar_background_size = $smof_data['offcanvas-sidebar-background-size'];
	}
	if ( ! empty( $offcanvans_sidebar_background_size ) ) {
		$offcanvas_style .= 'background-size: ' . $offcanvans_sidebar_background_size . ';';
	}
	if ( isset( $smof_data['offcanvas-sidebar-background-color'] ) && $smof_data['offcanvas-sidebar-background-color'] ) {
		$offcanvans_sidebar_background_color = $smof_data['offcanvas-sidebar-background-color'];
	}
	if ( ! empty( $offcanvans_sidebar_background_color ) ) {
		$offcanvas_style .= 'background-color: ' . $offcanvans_sidebar_background_color . ';';
	}

	$offcanvans_sidebar_text_color = $smof_data['offcanvas-sidebar-text-color']; 
	if ( ! empty( $offcanvans_sidebar_text_color ) ) {
		$offcanvas_style .= 'color: ' . $offcanvans_sidebar_text_color . ' !important;';
	}


	$offcanvas_sidebar_custom_css = $smof_data['offcanvas-sidebar-custom-css'];
	if ( ! empty( $offcanvas_sidebar_custom_css ) ) {
		echo '
			<style>
				'. $offcanvas_sidebar_custom_css .'
			</style>
		';
	}
	?>
	<div class="offcanvas-sidebar <?php echo esc_attr( $smof_data['offcanvas-sidebar-position'] . '-pos');?>" style="<?php echo esc_attr( $offcanvas_style );?>">
		<a id="close-canvas" onclick="javascript:return false;" class="open-sidebar k2t-element-hover btn-ripple" href="#"><span class="inner"></span></a>
		<div class="k2t-sidebar">			
			<?php dynamic_sidebar( $smof_data['offcanvas-sidebar'] ); ?>
		</div>
	</div>
<?php endif; ?>
<!-- End Show Offcanvas sidebar -->

<?php if ( ! is_404() ) : ?>

	<div class="k2t-searchbox">
		<div class="k2t-searchbox-close hamburger hamburger--squeeze js-hamburger is-active">
        	<div class="hamburger-box">
          		<div class="hamburger-inner"></div>
        	</div>
      	</div>
		<div class="mark"></div>
		<form class="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
			<input type="text" value="<?php echo esc_url( get_search_query() ); ?>" name="s" id="s" placeholder="<?php esc_html_e('Type your keyword','k2t'); ?>" />
			<button type="submit" value="" id="searchsubmit"><i class="fa fa-search"></i></button>
		</form>
	</div>

<?php
	if ( $smof_data['footer-gototop'] ) :
		echo '<a href="#" class="k2t-btt k2t-element-hover"><i class="zmdi zmdi-chevron-up"></i></a>';
	endif;
endif;

wp_footer();  ?>
</body>
</html>
