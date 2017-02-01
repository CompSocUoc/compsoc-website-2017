<?php
/**
 * Shortcode button.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_button_shortcode' ) ) {
	function k2t_button_shortcode( $atts, $content ) {
		$html = $title = $link = $target = $icon = $icon_position = $subtitle = $color = $text_color = $size = $align = $fullwidth = $transparent = $pill = $popover_title = $popover_content = $popover_image = $popover_effect = $popover_theme = $popover_width = $trigger = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'title'           => '',
			'link'            => '',
			'target'          =>  '_self',
			'icon'            => '',
			'icon_position'   =>  'right',
			'subtitle'        => '',
			'radius'          => '',
			'size'            => 'small',
			'align'           => 'left',
			'fullwidth'       => 'false',
			'button_style'	  => 'default',
			'button_color'	  => 'light_blue',
			'color'           => '',
			'text_color'      => '',
			'hover_bg_color'  => '',
			'hover_text_color'=> '',
			'border_color'    => '',
			'border_width'    => '1',
			'hover_border_color'=> '',
			'transparent'     => 'false',
			'pill'            => 'false',
			'popover_title'   => '',
			'popover_content' => '',
			'popover_image'   => '',
			'popover_effect'  => 'fade',
			'popover_theme'   => 'light',
			'popover_width'   => '300',
			'trigger'         => 'hover',
			'mgt'             => '',
			'mgr'             => '',
			'mgb'             => '',
			'mgl'             => '',
			'anm'             => '',
			'anm_name'        => '',
			'anm_delay'       => '',
			'id'              => '',
			'class'           => '',
			'd3'			  => 'false',
		), $atts ) );

		wp_enqueue_script( 'k2t-tooltipster' );

		$length = 10;
		$id = empty( $id ) ? substr( str_shuffle( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, $length ) : $id;

		//Create $cl to save class of button and $inner to save class btn
		$cl = array( 'k2t-button' );
		$inner = array( 'k2t-btn btn-ripple' );

		$data_name = $data_delay = '';
		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}

		$class = ( $class != '' ) ? ' ' . $class . '' : '';if ( !empty( $mgt ) )
		$mgt = !empty( $mgt ) ? ( is_numeric( $mgt ) ? 'margin-top: ' . $mgt . 'px;' : 'margin-top: ' . $mgt . ';' ) : '';
		$mgr = !empty( $mgr ) ? ( is_numeric( $mgr ) ? 'margin-right: ' . $mgr . 'px;' : 'margin-right: ' . $mgr . ';' ) : '';
		$mgb = !empty( $mgb ) ? ( is_numeric( $mgb ) ? 'margin-bottom: ' . $mgb . 'px;' : 'margin-bottom: ' . $mgb . ';' ) : '';
		$mgl = !empty( $mgl ) ? ( is_numeric( $mgl ) ? 'margin-left: ' . $mgl . 'px;' : 'margin-left: ' . $mgl . ';' ) : '';

		/*-----------Link-------------*/
		if ( trim( $link ) != '' ) { $href = ' href="' . esc_url( $link ) . '"'; } else { $href = ''; }

		/*-----------Target-------------*/
		if ( trim( $target ) != '_self' ) { $target = '_blank'; } else { $target = '_self'; }

		/*-----------Target-------------*/
		if ( ! empty( $button_style ) ) { $cl[] = 'button-' . $button_style; }

		/*-----------Custom Style-------------*/
		$inner_css = $mask_inner_css = array();
		$text_color_render = '';
		$hover_css = '';
		if ( $button_color == 'custom' ){
			/*-----------Text color-------------*/
			if( !empty( $text_color ) ) {
				$inner_css[] = 'color: ' . esc_attr( trim( $text_color ) ) . ';';
				$text_color_render = 'color: ' . esc_attr( trim( $text_color ) ) . ';';
			}

			/*-----------Background Color-------------*/
			if ( !empty( $color ) ) {
				$inner_css[] = 'background-color: ' . esc_attr( trim( $color ) ) . ';';
			}

			/*-----------Border color-------------*/
			if ( !empty( $border_color ) ) {
				$inner_css[] = 'border-color: ' . esc_attr( trim( $border_color ) ) . ';';
			}

			/*-----------Border width-------------*/
			$button_size = 60;
			if ( $size == 'small' ) $button_size = 36;
			if ( $size == 'large' ) $button_size = 70;
			if ( !empty( $border_width ) ) {
				if ( is_numeric( $border_width ) ){
					$inner_css[] = 'border-width: ' . esc_attr( trim( $border_width ) ) . 'px;';
					$inner_css[] = 'line-height: ' . esc_attr( trim( ( $button_size - ( intval( $border_width ) * 2 ) ) ) ) . 'px;';
				}else{
					$inner_css[] = 'border-width: ' . esc_attr( trim( $border_width ) ) . ';';
					$int_border_width = str_replace( 'px', '', $border_width );
					$int_border_width = str_replace( '%', '', $int_border_width );
                    $inner_css[] = 'line-height: ' . esc_attr( trim( ( $button_size - ( intval( $int_border_width ) * 2 ) ) ) ) . 'px;';
				}
			}

			/*-----------Hover-------------*/
			if ( !empty( $hover_bg_color ) || !empty( $hover_text_color ) || !empty( $hover_border_color ) ){
				$hover_css .= '<style>';
				if( !empty( $hover_bg_color ) ){
					$hover_css .= '#'. $id .':hover {background-color:'. $hover_bg_color .' !important;}';
				}
				if( !empty( $hover_text_color ) ){
					$hover_css .= '#'. $id .':hover *{color:'. $hover_text_color .' !important;}';
				}
				if( !empty( $hover_border_color ) ){
					$hover_css .= '#'. $id .':hover {border-color:'. $hover_border_color .' !important;}';
				} 
				$hover_css .= '</style>';
			}

		} elseif ( $button_color == 'red' ){
			$class .= ' red';
		} elseif ( $button_color == 'deep_purple' ){
			$class .= ' deep_purple';
		} elseif ( $button_color == 'blue' ){
			$class .= ' blue';
		} elseif ( $button_color == 'green' ){
			$class .= ' green';
		} elseif ( $button_color == 'amber' ){
			$class .= ' amber';
		} elseif ( $button_color == 'deep_orange' ){
			$class .= ' deep_orange';
		} elseif ( $button_color == 'black' ){
			$class .= ' black';
		} elseif ( $button_color == 'white' ){
			$class .= ' white';
		}

		/*-----------Border radius-------------*/
		if ( !empty( $radius ) ) {
			if ( is_numeric( $radius ) ){
				$inner_css[] = 'border-radius: ' . esc_attr( trim( $radius ) ) . 'px;';
			}else{
				$inner_css[] = 'border-radius: ' . esc_attr( trim( $radius ) ) . ';';
			}
		}

		/*-----------Icon-------------*/
		$html_icon = '';
		if ( trim( $icon ) != '' ) {
			$inner[] = 'has-icon';
			$icons_list = explode( " ", $icon );
			$html_icon .= '<span class="button-icon" style="'. $text_color_render .'">';
			$html_icon .= '<i class="' . $icon . '"></i> ';
			$html_icon = trim( $html_icon );
			$html_icon .= '</span>';
		};

		/*-----------Content Null-------------*/
		if ( empty( $title ) ) { $inner[] = 'btn-no-content'; };

		/*-----------Align-------------*/
		if ( ! in_array( trim( $align ), array( 'left', 'right', 'center' ) ) ) { $cl[] = 'align-left'; } else { $cl[] = 'align-' . trim( $align ); };

		/*-----------Size-------------*/
		if ( ! in_array( trim( $size ), array( 'tiny', 'small', 'medium', 'large' ) ) ) { $inner[] = 'btn-small'; } else { $inner[] = 'btn-' . trim( $size ); };

		/*-----------Full Width-------------*/
		if ( trim( $fullwidth ) == 'true' ) { $cl[] = 'button-fullwidth'; };

		/*-----------Pill-------------*/
		if ( trim( $pill ) == 'true' ) { $inner[] = 'btn-pill'; }
		
		/*-----------3D-------------*/
		if ( trim( $d3 ) == 'true' ) { $inner[] = 'btn-3d k2t-element-hover'; }

		/*-----------Popover Theme-------------*/
		if ( in_array( trim( $popover_theme ), array( 'dark', 'color' ) ) ) { $data_theme = ' data-theme="tooltipster-' . trim( $popover_theme ) . '"'; } else { $data_theme = ''; }

		/*-----------Popover effect-------------*/
		if ( in_array( trim( $popover_effect ), array( 'fade', 'slide', 'popup', 'swing' ) ) ) { $popover_effect = trim( $popover_effect ); } else { $popover_effect = 'fade'; }

		/*-----------Trigger-------------*/
		if ( trim( $trigger ) != 'click' ) { $trigger = 'hover'; } else { $trigger = 'click'; }

		$popover_wid = ( !is_numeric( trim( $popover_width ) ) ) ? '300' : trim( $popover_width );

		// Get attachment id
		$img_id = preg_replace( '/[^\d]/', '', $popover_image );

		// Get image file
		$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => '' ) );

		/*-----------Popover-------------*/
		$html_popover = '';
		if ( ( trim( $popover_title ) == '' ) && ( trim( $popover_content ) == '' ) && ( trim( $popover_image ) == '' ) ) {
			$html_popover = '';
			$data_popover = '';
		} else {
			$cl[] = 'k2t-tooltipster';
			$data_popover = ' data-max-width="' . $popover_wid . '" data-trigger="' . $trigger . '"' . $data_theme . ' data-effect="' . $popover_effect . '"';
			//Popover Image
			if ( trim( $popover_image ) != '' ) { $popover_image_html = '<div class="tooltipster-image"><img src="' . trim( $img['p_img_large'][0] ) . '" alt="Image"></div>'; } else { $popover_image_html = ''; }
			//Popover Title
			if ( trim( $popover_title ) != '' ) { $popover_title_html = '<div class="tooltipster-header"><h4>' . trim( $popover_title ) . '</h4></div>'; } else { $popover_title_html = ''; }
			//Popover Content
			if ( trim( $popover_content ) != '' ) { $popover_content_html = '<div class="tooltipster-desc"><p>' . do_shortcode( $popover_content ) . '</p></div>'; $has_desc = ' has-desc'; } else { $popover_content_html = ''; $has_desc = ''; }

			$html_popover .= '<div class="tooltipster-markup' . $has_desc . '">' . $popover_image_html . '<div class="tooltipster-text">' . $popover_title_html . $popover_content_html . '</div></div>';
		}

		/*-----------Subtitle-------------*/
		if ( trim( $subtitle ) != '' ) {
			$inner[] = 'btn-has-subtitle';
			/*-----------Icon Position-------------*/
			$inner[] = 'btn-icon-left';
		} else {
			/*-----------Icon Position-------------*/
			if ( trim( $icon_position ) != 'left' ) { $inner[] = 'button-icon-right'; } else { $inner[] = 'button-icon-left'; };
		}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_button_classes', $cl );

		//Join cl class and inner class
		$cl = join( ' ', $cl );
		$inner = join( ' ', $inner );
		$inner_css = join( ' ', $inner_css );
		$mask_inner_css = join( ' ', $mask_inner_css );

		$html = '<div class="' . trim( $cl ) .  $anm . $class . '"' . $data_popover . $data_name  . $data_delay . '>';
		$html .= do_action( 'k2t_button_open' );
		//Render HTML if has subtitle
		if ( trim( $subtitle ) == '' ) {
			if( trim( $icon_position ) != 'left' ){
				$html .= '<a id="'. $id .'" style="' . $inner_css . $mgt . $mgr . $mgb . $mgl . '" class="' . trim( $inner ) . '"' . $href . ' target="' . $target . '"><span class="button-text" style="' . $text_color_render . '"><span class="text">' . $title . '</span>' . $html_icon . '</span></a>' . $html_popover;
			}
			else{
				$html .= '<a id="'. $id .'" style="' . $inner_css . $mgt . $mgr . $mgb . $mgl . '" class="' . trim( $inner ) . '"' . $href . ' target="' . $target . '"><span class="button-text" style="' . $text_color_render . '"> ' . $html_icon . ' <span class="text">' . $title . '</span></span></a>' . $html_popover;
			}
		} else {
			$html .= '<a id="'. $id .'" style="' . $inner_css . $mgt . $mgr . $mgb . $mgl . '" class="' . trim( $inner ) . '"' . $href . ' target="' . $target . '"><span class="button-text" style="' . $text_color_render . '">' . $html_icon . '<span class="text"><span class="button-main">' .  $title  . '</span><span class="button-subtitle">' . $subtitle . '</span></span></span></a>' . $html_popover;
		}
		$html .= do_action( 'k2t_button_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_button_return', $html );

		return $html.$hover_css;
	}
}