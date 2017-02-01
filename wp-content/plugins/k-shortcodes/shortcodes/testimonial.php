<?php
/**
 * Shortcode testimonial.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_testimonial_shortcode' ) ) {
	function k2t_testimonial_shortcode( $atts, $content ) {
		$html = $style = $image_html = $enable_pagination = $position_author = '';
		extract( shortcode_atts( array(
			'items'	        => '3',
			'items_desktop' => '3',
			'items_tablet'  => '3',
			'items_mobile'  => '3',
			'style'			=> 'style-1',
			'item_margin'	=> '0',
			'enable_pagination' => 'false',
			'position_author' => 'top',
			'navigation'    => '',
			'pagination'    => '',
			'id'		    => '',
			'class'         => '',
		), $atts));

		wp_enqueue_script( 'k2t-owlcarousel' );

		// Generate random id
		$length = 10;
		$id     = substr( str_shuffle( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, $length );
		switch ( $style ) {
			case 'style-1':
				$html .= '<div class="k2t-testimonial k2t-itesti ' . $style . ' "><div id="' . $id . '" class="owl-carousel ' . $class . '" data-items="1" data-autoPlay="true" data-margin="0" data-loop="true" data-nav="false"	data-dots="' . $enable_pagination . '" data-mobile="1" data-tablet="1" data-desktop="1" data-URLhashListener="true">';

				if (!preg_match_all("/(.?)\[(testi)\b(.*?)(?:(\/))?\](?:(.+?)\[\/testi\])/s", $content, $matches)) :
					return do_shortcode($content);
				else :
					for($i = 0; $i < count($matches[0]); $i++):
						$testi_obj 				= shortcode_parse_atts($matches[3][$i]);
						$testi_content 			= $matches[5][$i];
						$image 					= $testi_obj['image'];
						if( $position_author == 'top'){
							$html .= '<div data-hash="testi-'. esc_attr( $i ) .'"><div class="testimonial-info"><div class="testimonial-meta">'. esc_html( $testi_obj['name'] ) .'</div></div><div class="testimonial-content"><div class="speech">' . do_shortcode( $testi_content ) . '</div></div></div>';
						}
						else 
							$html .= '<div data-hash="testi-'. esc_attr( $i ) .'"><div class="testimonial-content"><div class="speech">' . do_shortcode( $testi_content ) . '</div></div><div class="testimonial-info"><div class="testimonial-meta bottom">'. esc_html( $testi_obj['name'] ) .'</div></div></div>';
						if ( !empty( $image ) ){
							if ( is_numeric( $image ) ){
								$img_id 	= preg_replace( '/[^\d]/', '', $image );
								$image    	= wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => '' ) );
								$image_link = $image['p_img_large'][0];
								$data       =  ( file_exists( $image_link ) && isset( $image_link ) ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
								$width      = isset( $data[0] ) ? $data[0] : '';
								$height     = isset( $data[1] ) ? $data[1] : '';
								$image_html .= '<a href="#testi-'. esc_attr( $i ) .'"><img width="' . $width . '" height="' . $height . '" src="'. $image['p_img_large'][0] .'" alt="Avatar" /></a>';
							}else{
								$data       = isset( $image_link ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
								$width      = isset( $data[0] ) ? $data[0] : '';
								$height     = isset( $data[1] ) ? $data[1] : '';
								$image_html .= '<a href="#testi-'. esc_attr( $i ) .'"><img width="' . $width . '" height="' . $height . '" src="'. $image .'" alt="Avatar" /></a>';
							}
						}
					endfor;
					$html .= '</div>';

					// 
					if ( ! empty( $image_html ) ) {
						$html .= '<div class="testimonial-image">'. $image_html .'</div>';
					}

				endif;
				$html .= '</div>';
				break;
			
			default:
				$html .= '<div class="k2t-testimonial k2t-itesti ' . $style . '"><div id="' . $id . '" class="owl-carousel ' . $class . '" data-items="'.$items.'" data-autoPlay="true" data-margin="30" data-loop="true" data-nav="false"	data-dots="' . $enable_pagination . '" data-mobile="'.$items_mobile.'" data-tablet="'.$items_tablet.'" data-desktop="'.$items_desktop.'" data-URLhashListener="true">';
				if (!preg_match_all("/(.?)\[(testi)\b(.*?)(?:(\/))?\](?:(.+?)\[\/testi\])/s", $content, $matches)) :
					return do_shortcode($content);
				else :
					for($i = 0; $i < count($matches[0]); $i++):
						$testi_obj 				= shortcode_parse_atts($matches[3][$i]);
						$testi_content 			= $matches[5][$i];
						$image 					= $testi_obj['image'];
						if ( !empty( $image ) ){
							if ( is_numeric( $image ) ){
								$img_id 	= preg_replace( '/[^\d]/', '', $image );
								$image    	= wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => '' ) );
								$image_link = $image['p_img_large'][0];
								$data       =  ( file_exists( $image_link ) && isset( $image_link ) ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
								$width      = isset( $data[0] ) ? $data[0] : '';
								$height     = isset( $data[1] ) ? $data[1] : '';
								$image_html = '<a href="#"><img width="' . $width . '" height="' . $height . '" src="'. $image['p_img_large'][0] .'" alt="Avatar" /></a>';
							}
							else{
								$data       = isset( $image_link ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
								$width      = isset( $data[0] ) ? $data[0] : '';
								$height     = isset( $data[1] ) ? $data[1] : '';
								$image_html = '<a href="#"><img width="' . $width . '" height="' . $height . '" src="'. $image .'" alt="Avatar" /></a>';
							}
						}
						$html .= '<div class="k-item k2t-element-hover" data-hash="testi-'. esc_attr( $i ) .'"><div class="testimonial-info"><div class="testimonial-image">'. $image_html .'</div><div class="testimonial-meta"><div class="testimonial-name">'. esc_html( $testi_obj['name'] ) .'</div><div class="testimonial-position">' . esc_html($testi_obj['position_teacher']) . '</div></div></div><div class="testimonial-content"><div class="speech">"' . do_shortcode( $testi_content ) . '"</div></div></div>';
					endfor;
					$html .= '</div>';
				endif;
				$html .= '</div>';
				break;
		}
		//Apply filters return
		$html = apply_filters( 'k2t_k2t_slider_return', $html );

		return $html;
	}
}


if ( ! function_exists( 'xx' ) ) {
	function xxx( $atts, $content ) {
		$html = '';
		extract( shortcode_atts( array(
			'image'     => '',
			'name'      => '',
			'position'  => '',
			'id'        => '',
			'class'     => '',
		), $atts ) );

		$cl = array( 'k2t-testimonial style-' . $style );

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';
		$align = ( $align != '' ) ? ' ' . $align . '' : '';

		/*-------------Image------------*/
		$image_html = '';
		if ( !empty( $image ) ){
			if ( is_numeric( $image ) ){
				$img_id = preg_replace( '/[^\d]/', '', $image );
				$image    = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => '' ) );
				$image_link = $image['p_img_large'][0];
				$data       = ( file_exists( $image_link ) && isset( $image_link ) ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
				$width      = isset( $data[0] ) ? $data[0] : '';
				$height     = isset( $data[1] ) ? $data[1] : '';
				$image_html = '<img width="' . $width . '" height="' . $height . '" src="'. $image['p_img_large'][0] .'" alt="Avatar" />';
			}else{
				$data       = ( file_exists( $image_link ) && isset( $image_link ) ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
				$width      = isset( $data[0] ) ? $data[0] : '';
				$height     = isset( $data[1] ) ? $data[1] : '';
				$image_html = '<img width="' . $width . '" height="' . $height . '" src="'. $image .'" alt="Avatar" />';
			}
		}


		/*-------------Target------------*/
		if ( in_array( trim( $target ), array( '_blank', '_self' ) ) ) { $target = trim( $target ); } else { $target = '_blank'; }

		/*-------------Link Name------------*/
		if ( trim( $link_name ) != '' ) { $open_link = '<a href="' . trim( $link_name ) . '" target="' . $target . '">'; $close_link = '</a>'; } else { $open_link = ''; $close_link = ''; }

		/*-------------From------------*/
		if ( trim( $from ) != '' ) { $from_html = '<span class="testimonial-from">' . $open_link . trim( $from ) . $close_link . '</span>'; } else { $from_html = ''; }

		/*-------------Name------------*/
		if ( trim( $name ) != '' ) { $name_html = '<span class="testimonial-author">' . trim( $name ) . '</span>'; } else { $name_html = ''; }

		/*-------------Position------------*/
		if ( trim( $position ) != '' ) { $position_html = '<span class="testimonial-position">' . trim( $position ) . '</span>'; } else { $position_html = ''; }

		//Apply filters to cl
		$cl = apply_filters( 'k2t_testimonial_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		if ( '1' == $style ) {
			$html = '<div class="' . trim( $cl ) . $anm . $class . '" ' . $data_name . $data_delay . $id . '>';
			$html .= do_action( 'k2t_testimonial_open' );
			$html .= '<div class="testimonial-inner ' . $align . '"><div class="testimonial-content"><div class="speech"><p>' . do_shortcode( $content ) . '</p></div></div><div class="testimonial-info">' . $image_html . '<div class="testimonial-meta">' . $name_html . $position_html . $from_html . '</div></div></div>';
			$html .= do_action( 'k2t_testimonial_close' );
			$html .= '</div>';
		} else if ( '3' == $style ) {
			$html = '<div class="' . trim( $cl ) . $anm . $class . '" ' . $data_name . $data_delay . $id . '>';
			$html .= do_action( 'k2t_testimonial_open' );
			$html .= '<div class="testimonial-inner ' . $align . '"><div class="testimonial-content"><div class="testimonial-avatar">' . $image_html . '</div><div class="speech"><p>' . do_shortcode( $content ) . '</p></div></div><div class="testimonial-info"><div class="testimonial-meta">' . $name_html . $position_html . $from_html . '</div></div></div>';
			$html .= do_action( 'k2t_testimonial_close' );
			$html .= '</div>';
		}else {
			$html = '<div class="' . trim( $cl ) . $anm . $class . '" ' . $data_name . $data_delay . $id . '>';
			$html .= do_action( 'k2t_testimonial_open' );
			$html .= '<article>';
            $html .= '<a class="testimonial-avatar" href="#">' . $image_html . '</a>';
            $html .= '<div class="testimonial-content">';
            $html .= '<p>' . do_shortcode( $content ) . '</p>';
            $html .= '</div>';
            $html .= '<p class="testimonial-author"><a  href="#">'. $name_html .'</a></p>';
            $html .= '</article>';
            $html .= do_action( 'k2t_testimonial_close' );
            $html .= '</div>';
		}
		

		//Apply filters return
		$html = apply_filters( 'k2t_testimonial_return', $html );

		return $html;
	}
}
