<?php
/**
 * Shortcode embed.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_k2t_embed_shortcode' ) ) {
	function k2t_k2t_embed_shortcode( $atts, $content ) {
		$html = $width = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'width'     => '',
			'anm'       => '',
			'anm_name'  => '',
			'anm_delay' => '',
			'id'        => '',
			'class'     => '',
		), $atts ) );

		$cl = array( 'media-container' );

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		/*-------------Style--------------*/
		if ( is_numeric( trim( $width ) ) ) { $width_style = ' style="width: '.trim( $width ).'px;"';} else { $width_style = '';}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_k2t_embed_classes', $cl );
		//Join $cl
		$cl = join( ' ', $cl );

		//Check content is url or iframe
		$sub_content = substr( trim( $content ), 0, 4 );
		if ( $sub_content == 'http' ) {
			$html = '<div class="' . trim( $cl ) . $anm . $class . '"' . $width_style . $data_name . $data_delay . $id . '>';
			$html .= do_action( 'k2t_k2t_embed_open' );
			$html .= do_shortcode( '[embed]'.trim( $content ).'[/embed]' );
			$html .= do_action( 'k2t_k2t_embed_close' );
			$html .= '</div>';
		} else {
			$html = '<div class="'.trim( $cl ).'"'.$width_style.'>';
			$html .= do_action( 'k2t_k2t_embed_open' );
			$html .= trim( $content );
			$html .= do_action( 'k2t_k2t_embed_close' );
			$html .= '</div>';
		}

		//Apply filters return
		$html = apply_filters( 'k2t_k2t_embed_return', $html );

		return $html;
	}
}
