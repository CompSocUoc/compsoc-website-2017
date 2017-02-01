<?php
/**
 * Shortcode icon.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_icon_shortcode' ) ) {
	function k2t_icon_shortcode( $atts, $content = null ) {
		$html = $icon = $color = $size = $link = $target = $title = $background_color = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'icon'             => '',
			'color'            => '',
			'size'             => '',
			'link'             => '',
			'target'           => '',
			'title'            => '',
			'background_color' => '',
			'anm'              => '',
			'anm_name'         => '',
			'anm_delay'        => '',
			'id'               => '',
			'class'            => '',
		), $atts ) );

		wp_enqueue_script( 'k2t-tipsy' );

		//Global $cl and $style
		$cl = array( 'k2t-icon' );
		$style_icon = array();
		$style_i = array();

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		/*----------------Title----------------*/
		if ( trim( $title ) == '' ) { $title_html = '';} else { $title_html = ' original-title="' . trim( $title ) . '"'; $cl[] = 'hastip'; $cl[] = 'tooltip-top';}

		/*----------------Target----------------*/
		if ( trim( $target ) != '_blank' ) { $target = '_self';} else { $target = '_blank';}

		/*----------------Link----------------*/
		if ( trim( $link ) == '' ) { $open_link = ''; $close_link = '';} else { $open_link = '<a href="' . esc_url( trim( $link ) ) . '" target="' . $target . '">'; $close_link = '</a>';}

		/*----------------Icon----------------*/
		if ( trim( $icon ) == '' ) { $icon_class = '';} else { $icon_class = '' . trim( $icon );}

		/*----------------Size----------------*/
		if ( is_numeric( trim( $size ) ) ) {
			$style_icon[] = 'width: ' . trim( $size ) . 'px';
			$style_icon[] = 'height: ' . trim( $size ) . 'px';
			$style_icon[] = 'font-size: ' . ( trim( $size )/2 ) . 'px';
			$style_i[] = 'line-height: ' . trim( $size ) . 'px';
		}

		/*----------------Color----------------*/
		if ( trim( $color ) != '' ) { $style_icon[] = 'color: ' . trim( $color );}

		/*----------------Background Color----------------*/
		if ( trim( $background_color ) != '' ) { $style_icon[] = 'background-color: ' . trim( $background_color ); $cl[] = 'has-background-color';}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_icon_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		//Join style_icon
		if ( !empty( $style_icon ) ) {
			$style_icon_html = ' style="' . esc_attr( trim( join( '; ', $style_icon ) ) ) . '"';
		} else {
			$style_icon_html = '';
		}

		//Join style_i
		if ( !empty( $style_i ) ) {
			$style_i_html = ' style="' . esc_attr( trim( join( '; ', $style_i ) ) ) . '"';
		} else {
			$style_i_html = '';
		}

		$html = '<div ' . $data_name . $data_delay . $id . ' class="' . trim( $cl ). $anm . $class . '"' . $style_icon_html.$title_html . '>';
		$html .= do_action( 'k2t_icon_open' );
		$html .= $open_link . '<i class="' . $icon_class . '"' . $style_i_html . '></i>' . $close_link;
		$html .= do_action( 'k2t_icon_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_icon_return', $html );

		return $html;
	}
}
