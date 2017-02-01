<?php
/**
 * Shortcode box.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_box_shortcode' ) ) {
	function k2t_box_shortcode( $atts, $content ) {
		$html = $width = $background_color = $background_image = $padding_top = $padding_right = $padding_bottom = $padding_left = $overlay_opacity = $overlay_color = $effect = $align = $id = $class = '';
		extract( shortcode_atts( array(
			'width'            => '',
			'background_color' => '',
			'background_image' => $background_image,
			'padding_top'      => '10',
			'padding_bottom'   => '10',
			'padding_left'     => '10',
			'padding_right'    => '10',
			'overlay_opacity'  => '',
			'overlay_color'    => '',
			'effect'           => '',
			'align'            => 'left',
			'id'               => '',
			'class'            => '',
		), $atts ) );

		//Global variable
		$cl            = array( 'k2t-box' );
		$style         = array();
		$bg_style      = array();
		$overlay_style = array();
		$background_id = preg_replace( '/[^\d]/', '', $background_image );
		$img           = wpb_getImageBySize( array( 'attach_id' => $background_id, 'thumb_size' => '' ) );
		$id            = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class         = ( $class != '' ) ? ' ' . $class . '' : '';

		/*-----------Width-------------*/
		if ( trim( $width ) != '' ) { $style[] = 'width: ' . $width . 'px'; }

		/*-----------Padding Top-------------*/
		if ( is_numeric( trim( $padding_top ) ) ) { $style[] = 'padding-top: ' . $padding_top . 'px'; } else { $style[] = 'padding-top: 100px'; }

		/*-----------Padding Bottom-------------*/
		if ( is_numeric( trim( $padding_bottom ) ) ) { $style[] = 'padding-bottom: ' . $padding_bottom . 'px'; } else { $style[] = 'padding-bottom: 100px'; }

		/*-----------Padding Left-------------*/
		if ( is_numeric( trim( $padding_left ) ) ) { $style[] = 'padding-left: ' . $padding_left . 'px'; } else { $style[] = 'padding-left: 30px'; }

		/*-----------Padding Right-------------*/
		if ( is_numeric( trim( $padding_right ) ) ) { $style[] = 'padding-right: ' . $padding_right . 'px'; } else { $style[] = 'padding-right: 30px'; }

		/*-----------Background Image-------------*/
		if ( trim( $background_image ) != '' ) { $bg_style[] = 'background-image: url(' . trim( $img['p_img_large'][0] ) . ')'; }

		/*-----------Background Color-------------*/
		if ( trim( $background_color ) != '' ) {
			$bg_style[] = 'background-color: ' . trim( $background_color );
		}

		/*-----------Overlay Color-------------*/
		if ( trim( $overlay_color ) != '' ) {
			$overlay_style[] = 'background-color: ' . trim( $overlay_color );
		}

		/*-----------Overlay Opacity-------------*/
		if ( is_numeric( trim( $overlay_opacity ) ) ) {
			$overlay_style[] = 'opacity: ' .  ( trim( $overlay_opacity ) / 100 );
		}

		/*-----------Align-------------*/
		if ( !in_array( trim( $align ), array( 'left', 'right', 'center' ) ) ) { $cl[] = 'align-left'; } else { $cl[] = 'align-' . trim( $align ); }

		/*-----------Effect-------------*/
		if ( in_array( trim( $effect ), array( 'parallax', 'zoom' ) ) ) {
			if ( trim( $effect ) == 'zoom' ) { $cl[] = 'k2t-zoom'; } else { $cl[] = 'k2t-parallax'; wp_enqueue_script( 'k2t-parallax' ); }
		}

		//Join Style attr for k2t-box, bg-element and overlay
		$style = join( ' ;', $style );
		if ( ! empty( $bg_style ) ) { $bg_style_inline = 'style="' . esc_attr( join( ';', $bg_style ) ) . '"'; } else { $bg_style_inline = ''; }
		if ( ! empty( $overlay_style ) ) { $overlay_style_inline = 'style="' . esc_attr ( trim( join( '; ', $overlay_style ) ) ) . '"'; } else { $overlay_style_inline = ''; }

		//Apply filters to cl
		$cl = apply_filters( 'k2t_box_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '<div ' . $id . ' class="' . trim( $cl ) . $class . '" style="' . esc_attr( $style ) . '">';
		$html .= do_action( 'k2t_box_open' );
		$html .= '<div class="bg-element" ' . $bg_style_inline . '></div><div class="box-overlay" ' . $overlay_style_inline . '></div><div class="box-content-wrapper"><div class="box-content">' . do_shortcode( $content ) . '</div></div>';
		$html .= do_action( 'k2t_box_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_imagebox_return', $html );

		return $html;
	}
}
