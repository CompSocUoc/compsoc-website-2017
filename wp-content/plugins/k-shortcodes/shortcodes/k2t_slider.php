<?php
/**
 * Shortcode k2t slider.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_k2t_slider_shortcode' ) ) {
	function k2t_k2t_slider_shortcode( $atts, $content ) {
		$html = '';
		extract( shortcode_atts( array(
			'items'	        => '4',
			'items_desktop' => '4',
			'items_tablet'  => '2',
			'items_mobile'  => '1',
			'item_margin'	=> '0',
			'auto_play'	    => '',
			'navigation'    => '',
			'pagination'    => '',
			'id'		    => '',
			'class'         => '',
		), $atts));

		wp_enqueue_script( 'k2t-owlcarousel' );

		// Generate random id
		$length = 10;
		$id     = substr( str_shuffle( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, $length );

		$html .= '<div id="' . $id . '" class="k2t-carousel owl-carousel ' . $class . '"
			data-items="'. esc_attr( $items ) .'" data-autoPlay="'. esc_attr( ( $auto_play ) ? 'true' : 'false' ) .'" data-margin="'. esc_attr( $item_margin ) .'" data-loop="true" data-nav="'. esc_attr( ( $navigation ) ? 'true' : 'false' ) .'"
			data-dots="'. esc_attr( ( $pagination ) ? 'true' : 'false' ) .'" data-mobile="'. esc_attr( $items_mobile ) .'" data-tablet="'. esc_attr( $items_tablet ) .'" data-desktop="'. esc_attr( $items_desktop ) .'">';
		$html .= do_shortcode( $content );
		$html .= '</div>';
		
		//Apply filters return
		$html = apply_filters( 'k2t_k2t_slider_return', $html );

		return $html;
	}
}