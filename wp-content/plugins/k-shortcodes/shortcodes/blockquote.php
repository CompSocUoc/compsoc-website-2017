<?php
/**
 * Shortcode blockquote.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_blockquote_shortcode' ) ) {
	function k2t_blockquote_shortcode( $atts, $content ) {
		$html =  $align = $author = $link_author = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'style'       =>  '1',
			'align'       =>  'none',
			'author'      => '',
			'link_author' => '',
			'anm'         => '',
			'anm_name'    => '',
			'anm_delay'   => '',
			'id'          => '',
			'class'       => '',
		), $atts ) );

		//Global $cl
		$cl = array( 'k2t-pullquote' );

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		/*-------------Style------------*/
		if ( !empty( $style ) ){ $cl[] = 'style-' . $style;}

		/*-------------Align------------*/
		if ( in_array( trim( $align ), array( 'left', 'right', 'center' ) ) ) { $cl[] = 'align-' . trim( $align ); $not_align = ''; } else { $not_align = ' style="width: 100%; margin: 0; float: none;"'; }

		/*-------------Link Author------------*/
		$open_link = ! empty( $link_author ) ? ' - <a href="' . trim( $link_author ) . '">' . trim( $link_author ) . '</a>' : '';

		/*-------------Author------------*/
		$author_html = !empty( $author ) ? '<cite><span>' . trim( $author ) . '</span>' . $open_link . '</cite>' : '';

		//Apply filters to cl
		$cl = apply_filters( 'k2t_blockquote_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '<div class="' . trim( $cl ) . $class . $anm . '"' . $not_align  . $id . $data_name . $data_delay . '>';
		$html .= do_action( 'k2t_blockquote_open' );
		$html .= '<blockquote>' . do_shortcode( $content ).$author_html . '</blockquote>';
		$html .= do_action( 'k2t_blockquote_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_blockquote_return', $html );

		return $html;
	}
}
