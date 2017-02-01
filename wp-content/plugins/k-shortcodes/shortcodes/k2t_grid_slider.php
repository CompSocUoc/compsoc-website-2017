<?php
/**
 * Shortcode grid_slider.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_k2t_grid_slider_shortcode' ) ) {
	function k2t_k2t_grid_slider_shortcode( $atts, $content ) {
		$html = $style = '';
		extract( shortcode_atts( array(
			'style'     => '',
			'id'		=> '',
			'class'		=> '',
		), $atts ) );

		//Global $cl
		$cl = array();

		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		if ( !preg_match_all( "/(.?)\[(k2t_grid_slide)\b(.*?)(?:(\/))?\]/s", $content, $matches ) ) {
			return do_shortcode( $content );
		} else {
			switch ( $style ) {
				case '2':
					if ( count( $matches[0] ) > 0 ) {
						// Enqueue Script
						wp_enqueue_script( 'jquery.eislideshow' );

						$html .= '<div '. $id  .' class="ei-slider '. $class .'"><ul class="ei-slider-large">';
						for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
							$slide = shortcode_parse_atts( $matches[3][$i] );

							// Get all attr of slide
							$title 			= isset( $slide['title'] ) ? $slide['title'] : '';
							$sub_title 		= isset( $slide['sub_title'] ) ? $slide['sub_title'] : '';
							$image			= isset( $slide['image'] ) ? $slide['image'] : '';
							$class			= isset( $slide['class'] ) ? $slide['class'] : '';

							// Render data by attr
							$image_url = is_numeric( $image ) ? wp_get_attachment_url( $image ) : $image;

							// Render html shortcode
							if ( ! empty( $image ) ) {
								$html .= '
	                                <li class="'. $class .'">
                                        <img src="'. $image_url .'" alt=""/>
                                        <div class="ei-title clearfix">
                                            '. ( ! empty( $title ) ? '<h2>' . $title . '</h2>' : '' ) .'
                                            '. ( ! empty( $sub_title ) ? '<h3>' . $sub_title . '</h3>' : '' ) .'
                                        </div>
                                    </li>
								';
							}
						}
						$html .= '</ul><ul class="ei-slider-thumbs"><li class="ei-slider-element">'. __( 'Current', 'k2t' ) .'</li>';
						for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
							$html .= '<li><a href="#">'. __( 'Slide', 'k2t' ) . $i .'</a></li>';
						}               
						$html .= '</ul></div>';
					}
					break;

				case '3':
					if ( count( $matches[0] ) > 0 ) {
						// Enqueue Script
						wp_enqueue_style( 'custom-flexslider' );
						wp_enqueue_script( 'jquery-flexslider' );

						$html .= '<div '. $id  .' class="flexslider flx-home-slider '. $class .'"><ul class="slides">';
						for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
							$slide = shortcode_parse_atts( $matches[3][$i] );

							// Get all attr of slide
							$title 			= isset( $slide['title'] ) ? $slide['title'] : '';
							$image			= isset( $slide['image'] ) ? $slide['image'] : '';
							$class			= isset( $slide['class'] ) ? $slide['class'] : '';

							// Render data by attr
							$image_url = is_numeric( $image ) ? wp_get_attachment_url( $image ) : $image;

							// Render html shortcode
							if ( ! empty( $image ) ) {
								$html .= '<li class="'. $class .'"><a href="#" title="'. $title .'"><img src="'. $image_url .'" alt="'. $title .'" /></a></li>';
							}
						}              
						$html .= '</ul></div>';
					}
					break;

				case '4':
					if ( count( $matches[0] ) > 0 ) {
						// Enqueue Script
						wp_enqueue_style( 'custom-flexslider' );
						wp_enqueue_script( 'jquery-flexslider' );

						$html .= '<div '. $id  .' class="flexslider service-slider '. $class .'"><ul class="slides">';
						for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
							$slide = shortcode_parse_atts( $matches[3][$i] );

							// Get all attr of slide
							$title 			= isset( $slide['title'] ) ? $slide['title'] : '';
							$sub_title		= isset( $slide['sub_title'] ) ? $slide['sub_title'] : '';
							$image			= isset( $slide['image'] ) ? $slide['image'] : '';
							$class			= isset( $slide['class'] ) ? $slide['class'] : '';

							// Render data by attr
							$image_url = is_numeric( $image ) ? wp_get_attachment_url( $image ) : $image;

							// Render html shortcode
							if ( ! empty( $image ) ) {
								$html .= '<li class="'. $class .'"><a href="#" title="'. $title .'"><img src="'. $image_url .'" alt="'. $title .'" /></a><div class="flex-caption"><h3>'. $title .'</h3><p>'. $sub_title .'</p></div></li>';
							}
						}              
						$html .= '</ul></div>';
					}
					break;

				default :
					// Default style 1
					if ( count( $matches[0] ) > 0 ) {
						// Enqueue Script
						wp_enqueue_style( 'iview' );
						wp_enqueue_script( 'raphael-min' );
						wp_enqueue_script( 'iview' );
						wp_enqueue_script( 'jquery-easing' );

						$html .= '<div '. $id  .' class="iview '. $class .'">';
						for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
							$slide = shortcode_parse_atts( $matches[3][$i] );

							// Get all attr of slide
							$title 			= isset( $slide['title'] ) ? $slide['title'] : '';
							$image			= isset( $slide['image'] ) ? $slide['image'] : '';
							$class			= isset( $slide['class'] ) ? $slide['class'] : '';

							// Render data by attr
							$image_url = is_numeric( $image ) ? wp_get_attachment_url( $image ) : $image;

							// Render html shortcode
							if ( ! empty( $image ) ) {
								$html .= '
									<div class="'. $class .'" data-iview:image="'. $image_url .'">
	                                    <div class="iview-caption caption1" data-x="100" data-y="300" data-transition="expandLeft">'. $title .'</div>
	                                </div>
								';
							}
						}
						$html .= '</div>';
					}
					break;
			}

			//Apply filters return
			$html = apply_filters( 'k2t_grid_slider_return', $html );

			return $html;
		}
	}
}
