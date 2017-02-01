<?php
/**
 * Icon list for menu and visuak composer.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

/*--------------------------------------------------------------
	Define icon path
--------------------------------------------------------------*/
function k2t_vc_icon_url() {
	return K2T_FRAMEWORK_URL . 'extensions/plugins/k2t-icon/assets/';
}

/*--------------------------------------------------------------
	Icon init
--------------------------------------------------------------*/
function k2t_vc_icon_init() {
	// Enqueue icon font style
	wp_register_style( 'icon-font-style-awesome', k2t_vc_icon_url() . 'css/icon-font-style.css' );
	wp_register_style( 'icon-font-style', k2t_vc_icon_url() . 'css/material-design-iconic-font.min.css' );

	// Enqueue icon font style back-end
	wp_register_style( 'k2ticon-icon-generator', k2t_vc_icon_url() . 'css/generator.css' );

	// Enqueue icon font script
	wp_register_script( 'k2ticon-icon-generator', k2t_vc_icon_url() . 'js/generator.js', array( 'jquery' ), '', false );

	if ( ! is_admin() ) {
		wp_enqueue_style( 'icon-font-style' );
	} elseif ( is_admin() ) {
		wp_enqueue_style( 'icon-font-style-awesome' );
		wp_enqueue_style( 'icon-font-style' );
		wp_enqueue_style( 'k2ticon-icon-generator' );	
		wp_enqueue_script( 'k2ticon-icon-generator' );		
	}
}
add_action( 'init', 'k2t_vc_icon_init' );

/*--------------------------------------------------------------
	Generate icon box
--------------------------------------------------------------*/
function k2t_vc_icon_generator() {
	include_once 'inc/list.php'; ?>
	<div id="k2ticon-generator-overlay" class="k2ticon-overlay-bg" style="display:none"></div>
	<div id="k2ticon-generator-wrap" style="display:none">
		<div id="k2ticon-generator">
			<a href="#" id="k2ticon-generator-close"><span class="k2ticon-close-icon"></span></a>
			<div id="k2ticon-generator-shell">
				
				<table border="0" id="k2ticon-generator-options">
					<tr>
						<td class="generator-title">
							<span>Icon Pack:</span>
						</td>							
						<td>
							<select name="icon-pack" id="k2ticon-generator-select-pack">
							   <!--<option value="fontawesome-icons-list">Font Awesome icons</option>
							   <option value="line-icons-list">Line icons</option>-->
							   <option value="material-icons-list">Material Design</option>
							</select>
						</td>
					</tr>
				</table>
				
				<div class="k2ticon-generator-icon-select">
					<ul class="material-icon-list">
					<?php 
					foreach ( $k2ticon_icon_list['material'] as $material_icon ) {
						$selected_icon = ( 'zmdi-apple' == $material_icon ) ? ' checked' : '';
						echo '<li><input name="name" type="radio" value="' . esc_attr( $material_icon ) . '" id="' . esc_attr( $material_icon ) . '" '. $selected_icon .' ><label for="' . esc_attr( $material_icon ) . '"><i class="zmdi ' . esc_attr( $material_icon ) . '"></i></label></li>';
					} 
					?>
					</ul>
					<?php if(false): ?>
					<ul class="fontawesome-icon-list">
					<?php 
					foreach ( $k2ticon_icon_list['fontawesome'] as $font_awesome_icon ) {
						$selected_icon = ( 'awesome-adjust' == $font_awesome_icon ) ? ' checked' : '';
						echo '<li><input name="name" type="radio" value="' . esc_attr( $font_awesome_icon ) . '" id="' . esc_attr( $font_awesome_icon ) . '" '. $selected_icon .' ><label for="' . esc_attr( $font_awesome_icon ) . '"><i class="' . esc_attr( $font_awesome_icon ) . '"></i></label></li>';
					} 
					?>
					</ul>
					<ul class="line-icon-list" style="display:none">
					<?php 
					foreach ( $k2ticon_icon_list['line'] as $line_icon ) {
						echo '<li><input name="name" type="radio" value="' . esc_attr( $line_icon ) . '" id="' . esc_attr( $line_icon ) . '"><label for="' . esc_attr( $line_icon ) . '"><i class="' . esc_attr( $line_icon ) . '"></i></label></li>';
					} 
					?>
					</ul>
					<?php endif ?>
				</div>
				
				<input name="k2ticon-generator-insert" type="submit" class="button button-primary button-large" id="k2ticon-generator-insert" value="Insert Icon">
				<div class="k2ticon-clear"></div>
				
				<input type="hidden" name="k2ticon-generator-url" id="k2ticon-generator-url" value="<?php echo k2t_vc_icon_url(); ?>" />
				<input type="hidden" name="k2ticon-generator-result" id="k2ticon-generator-result" value="" />
				<input type="hidden" name="k2ticon-compatibility-mode" id="k2ticon-compatibility-mode" value="k2t_" />
			</div>
		</div>
	</div>
	
<?php
}
add_action( 'admin_footer', 'k2t_vc_icon_generator' );

?>