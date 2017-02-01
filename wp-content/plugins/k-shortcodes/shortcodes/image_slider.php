<?php
/**
 * Shortcode image slider.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_image_slider_shortcode' ) ) {
	function k2t_image_slider_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'auto'     => 'false',
			'auto_time'    => '5000',
			'speed'     => '500',
			'pager'     => 'true',
			'navi'     => 'true',
			'touch'     => 'true',
			'mousewheel'   => 'false',
			'loop'     => 'true',
			'keyboard'    => 'false',
			'caption_background_color' => '',
			'caption_opacity'  => '100',
		), $atts ) );

		wp_enqueue_script( 'k2t-swiper' );
		wp_enqueue_script( 'k2t-swiper-slider' );
		wp_enqueue_style( 'k2t-swiper' );

		//Global id pagination
		$pagination_id = 'pagination-'.rand( 100000, 999999 );

		//Global $cl and $data + overlay
		$cl = array( 'k2t-swiper-slider' );
		$data = array();
		$overlay = array();

		$cl[] = 'image-slider';

		/*--------------Auto--------------*/
		if ( trim( $auto ) != 'true' ) {$data[] = 'data-auto="false"';} else { $data[] = 'data-auto="true"';}

		/*--------------Auto time--------------*/
		if ( is_numeric( trim( $auto_time ) ) ) {$data[] = 'data-auto-time="'.trim( $auto_time ).'"';} else { $data[] = 'data-auto-time="5000"';}

		/*--------------Speed--------------*/
		if ( is_numeric( trim( $speed ) ) ) {$data[] = 'data-speed="'.trim( $speed ).'"';} else { $data[] = 'data-speed="5000"';}

		/*--------------Pager--------------*/
		if ( trim( $pager ) != 'false' ) {$data[] = 'data-pager="true"'; $data[] = 'data-pagination-selector="#'.$pagination_id.'"';} else { $data[] = 'data-pager="false"';}

		/*--------------Navi--------------*/
		if ( trim( $navi ) != 'false' ) {$data[] = 'data-navi="true"';} else { $data[] = 'data-navi="false"';}

		/*--------------Touch--------------*/
		if ( trim( $touch ) != 'false' ) {$data[] = 'data-touch="true"';} else { $data[] = 'data-touch="false"';}

		/*--------------Mousewheel--------------*/
		if ( trim( $mousewheel ) != 'true' ) {$data[] = 'data-mousewheel="false"';} else { $data[] = 'data-mousewheel="true"';}

		/*--------------Loop--------------*/
		if ( trim( $loop ) != 'false' ) {$data[] = 'data-loop="true"';} else { $data[] = 'data-loop="false"';}

		/*--------------Keyboard--------------*/
		if ( trim( $keyboard ) != 'true' ) {$data[] = 'data-keyboard="false"';} else { $data[] = 'data-keyboard="true"';}

		/*--------------Caption background color--------------*/
		if ( trim( $caption_background_color ) != '' ) {$overlay[] = 'background-color: '.trim( $caption_background_color );}

		/*--------------Caption Opacity--------------*/
		if ( is_numeric( trim( $caption_opacity ) ) ) {$overlay[] = 'opacity: '.( trim( $caption_opacity )/100 );}

		/*-----------------Preview-----------------*/
		$data[] = 'data-perview="1"';

		if ( !preg_match_all( "/(.?)\[(slide)\b(.*?)(?:(\/))?\](?:(.+?)\[\/slide\])?(.?)/s", $content, $matches ) ) :
			return do_shortcode( $content );
		else :

			//Apply filters to cl
			$cl = apply_filters( 'k2t_image_slider_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		//Join $data
		$data = join( ' ', $data );

		//Join style $overlay
		if ( !empty( $overlay ) ) { $overlay = ' style="'.trim( join( '; ', $overlay ) ).'"';} else { $overlay = ''; }


		$html = '<div class="'.esc_attr( trim( $cl ) ).'" '.trim( $data ).'><div class="k2t-swiper-slider-inner"><div class="k2t-swiper-slider-inner-deeper"><div class="k2t-swiper-container"><div class="swiper-wrapper">';
		$html .= do_action( 'k2t_image_slider_open' );

		for ( $i = 0; $i < count( $matches[0] ); $i++ ):

			$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );

		$title = isset( $matches[3][$i]['title'] ) ? trim( $matches[3][$i]['title'] ) : '';
		$desc = isset( $matches[3][$i]['desc'] ) ? trim( $matches[3][$i]['desc'] ) : '';
		$link = isset( $matches[3][$i]['link'] ) ? trim( $matches[3][$i]['link'] ) : '';
		$target = isset( $matches[3][$i]['target'] ) ? trim( $matches[3][$i]['target'] ) : '_blank';
		$caption_position = isset( $matches[3][$i]['caption_position'] ) ? trim( $matches[3][$i]['caption_position'] ) : 'bottom left';

		//Check parameter and set for HTML
		/*---------Title--------*/
		if ( $title == '' ) { $title_html = ''; } else { $title_html = '<h4 class="title">'.$title.'</h4>'; }

		/*---------Desc--------*/
		if ( $desc == '' ) { $desc_html = ''; } else { $desc_html = '<div class="desc"><p>'.$desc.'</p></div>'; }

		/*---------Target--------*/
		if ( $target != '_self' ) { $target = '_blank'; } else { $target = '_self'; }

		/*---------Link--------*/
		if ( $link == '' ) { $open_link = ''; $close_link = ''; } else { $open_link = '<a target="'.$target.'" href="'.esc_url( $link ).'">'; $close_link = '</a>'; }

		/*---------Caption Position--------*/
		if ( in_array( $caption_position, array( 'top left', 'top right', 'bottom left', 'bottom right', 'left top', 'right top', 'left bottom', 'right bottom' ) ) ) { $position = $caption_position; } else { $position = 'bottom left'; }

		//Position render class
		$position_array = explode( " ", $position );
		$position_class = '';
		foreach ( $position_array as $posi ) {
			$position_class .= 'caption-'.$posi.' ';
		}

		$html .= '<div class="swiper-slide"><div class="image-slide"><div class="image">'.$open_link.'<img src="'.do_shortcode( $matches[5][$i] ).'" alt="Gallery '.( $i+1 ).'" />'.$close_link.'</div>';
		if ( $title_html || $desc_html ) {
			$html .= '<div class="caption '.trim( $position_class ).'">'.$title_html.$desc_html.'<div class="caption-overlay"'.$overlay.'></div></div>';
		}
		$html .= '</div></div>';

		endfor;

		$html .= do_action( 'k2t_image_slider_close' );
		$html .= '</div></div>';
		$html .= ( $navi=='true' ) ? '<div class="k2t-swiper-navi"><ul><li><a class="prev"><i class="icon-chevron-left"></i></a></li><li><a class="next"><i class="icon-chevron-right"></i></a></li></ul></div>' : '';
		$html .= '</div>';
		$html .= ( $pager=='true' ) ? '<div class="pagination" id="'.$pagination_id.'"></div>' : '';
		$html .= '</div></div>';

		//Apply filters return
		$html = apply_filters( 'k2t_image_slider_return', $html );

		return $html;

		endif;
	}
}
