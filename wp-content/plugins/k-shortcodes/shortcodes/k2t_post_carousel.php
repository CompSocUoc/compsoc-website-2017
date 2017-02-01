<?php
/**
 * Shortcode k2t slider.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_k2t_post_carousel_shortcode' ) ) {
	function k2t_k2t_post_carousel_shortcode( $atts, $content ) {
		$html = $items = $script = $items_desktop = $items_tablet = $items_mobile = $single_item = $slide_speed = $auto_play = $stop_on_hover = $navigation = $pagination = $lazyLoad = $class = '';
		extract( shortcode_atts( array(
			'items'	        => '4',
			'items_desktop' => '4',
			'items_tablet'  => '2',
			'items_mobile'  => '1',
			'single_item'   => '',
			'slide_speed'   => '1000',
			'auto_play'	    => '',
			'stop_on_hover' => '',
			'navigation'    => '',
			'pagination'    => '',
			'pagi_pos'      => 'bottom',
			'pagi_style'    => '1',
			'lazyLoad'      => '',
			'id'		    => '',
			'class'         => '',
		), $atts));

	wp_enqueue_script( 'k2t-owlcarousel' );

	// Generate random id
	$length = 10;
	$id     = substr( str_shuffle( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, $length );
	$class  = ( $class != '' ) ? ' ' . $class . '' : '';
	$pagi_pos = ' pagi-' . $pagi_pos;
	$pagi_style  = ( $pagi_style != '1' ) ? ' pagi-style-2' : '';

	$html .= '<div id="' . $id . '" class="owl-carousel ' . $class . $pagi_pos . $pagi_style . '">';
	
	$html .= do_shortcode( $content );
	$html .= '</div>';

	// Set param for carousel
	$single_item = ( $single_item ) ? 'singleItem: true,' : '';
	$auto_play = ( $auto_play ) ? 'autoPlay: true,' : '';
	$stop_on_hover = ( $stop_on_hover ) ? 'stopOnHover: true,' : '';
	$navigation = ( $navigation ) ? 'navigation: true,' : 'navigation: false,';
	$pagination = ( $pagination ) ? 'pagination: true,' : 'pagination: false,';
	$lazyLoad = ( $lazyLoad ) ? 'lazyLoad: true,' : '';
	$script .= '<scr' . 'ipt>
			(function($) {
				"use strict";
				$(document).ready(function() {				
					$("#' . $id . '").owlCarousel({
						items 					: ' . $items . ',
						itemsDesktop      		: [1199,' . $items_desktop . '],
						itemsDesktopSmall		: [979,' . $items_desktop . '],
						itemsTablet       		: [768,' . $items_tablet . '],
						itemsMobile       		: [479,' . $items_mobile . '],
						slide_speed 			: ' . $slide_speed . ', '. $single_item . $auto_play . $stop_on_hover . $navigation . $pagination . $lazyLoad .'
					});
				});
			})(jQuery);
		</scr' . 'ipt>';
	//Apply filters return
	$html = apply_filters( 'k2t_k2t_post_carousel_return', $html . $script );
	return $html;
	}
}