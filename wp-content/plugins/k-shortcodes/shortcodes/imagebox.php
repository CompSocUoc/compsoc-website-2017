<?php
/**
 * Shortcode image box.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_imagebox_shortcode' ) ) {
	function k2t_imagebox_shortcode( $atts, $content ) {
		$html = $image = $image_hover = $title = $title = $title_pos = $link = $target = $image_position = $effect = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'image'          => $image,
			'image_hover'    => $image_hover,
			'title'          => '',
			'title_pos'      => 'below_image',
			'link'           => '',
			'target'         => '_self',
			'image_position' => '',
			'effect'         => '',
			'anm'            => '',
			'anm_name'       => '',
			'anm_delay'      => '',
			'id'             => '',
			'class'          => '',
		), $atts ) );

		//Global $cl
		$cl = array( 'k2t-imagebox' );

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		/*-----------Target-------------*/
		if ( trim( $target ) != '_blank' ) {$target = '_self';} else {$target = '_blank';}

		/*-----------Link-------------*/
		if ( trim( $link ) != '' ) {$open_link = '<a href="' . esc_url( trim( $link ) ) . '" target="' . $target . '">'; $close_link = '</a>';} else {$open_link = ''; $close_link = '';}

		/*-----------Image position & Title position-------------*/
		if ( in_array( trim( $image_position ), array( 'left', 'right' ) ) ) {
			$cl[] = 'image-' . trim( $image_position ); $position = 'true';
		} else {
			$position = 'false';
			if ( trim( $title_pos ) != 'above_image' ) {$cl[] = 'title-below'; $title_post_class = ' title-below';} else {$cl[] = 'title-above'; $title_post_class = ' title-above';}
		}

		/*-----------Effect-------------*/
		if ( in_array( trim( $effect ), array( 'fade', 'slide' ) ) ) { $cl[] = 'thumb-effect-' . trim( $effect ); $effect = 'true';} else { $effect = 'false';}

		/*-----------Image-------------*/
		if ( ( trim( $image ) != '' ) && ( trim( $image_hover ) != '' ) && ( $effect == 'true' ) ) {
			$image_id       = preg_replace( '/[^\d]/', '', $image );
			$img            = wpb_getImageBySize( array( 'attach_id' => $image_id, 'thumb_size' => '' ) );
			$image_hover_id = preg_replace( '/[^\d]/', '', $image_hover );
			$img_hover      = wpb_getImageBySize( array( 'attach_id' => $image_hover_id, 'thumb_size' => '' ) );

			$image_html = '<div class="image">' . $open_link . '<div class="image1"><img src="' . esc_attr( trim( $img['p_img_large'][0] ) ) . '" alt="image" /></div><div class="image2"><img src="' . esc_attr( trim( $img_hover['p_img_large'][0] ) ) . '" alt="image" /></div>' . $close_link . '</div>';
		}

		/*-----------Title-------------*/
		if ( trim( $title ) != '' ) {$title_html = '<div class="title"><h3 class="h">' . $title . '</h3></div>'; $title_position = '<h3 class="title">' . $title . '</h3>';} else {$title_html = ''; $title_position = '';}

		/*-----------Css-------------*/
		if ( trim( $css ) != '' ) {$style = 'style="' . esc_attr( trim( $css ) ) . '"';} else {$style = '';}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_imagebox_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		if ( $position == 'true' ) {
			$html = '<div class="' . trim( $cl ). $anm . '" ' . $style . $data_name . $data_delay . $id . '>';
			$html .= do_action( 'k2t_imagebox_open' );
			$html .= '<div class="imagebox-inner">';
			$html .= $image_html . '<div class="text">' . $title_position . '<div class="desc">' . do_shortcode( $content ) . '</div></div>';
			$html .= '</div>';
			$html .= do_action( 'k2t_imagebox_close' );
			$html .= '</div>';
		} else {
			if ( $title_post_class == ' title-below' ) {
				$html = '<div class="' . trim( $cl ). $anm . '" ' . $style . $data_name . $data_delay . $id . '>';
				$html .= do_action( 'k2t_imagebox_open' );
				$html .= $image_html . '<div class="text">' . $title_html . '<div class="desc">' . do_shortcode( $content ) . '</div></div>';
				$html .= do_action( 'k2t_imagebox_close' );
				$html .= '</div>';
			}else {
				$html = '<div class="' . trim( $cl ). $anm . '" ' . $style . $data_name . $data_delay . $id . '>';
				$html .= do_action( 'k2t_imagebox_open' );
				$html .= $title_html.$image_html . '<div class="text"><div class="desc">' . do_shortcode( $content ) . '</div></div>';
				$html .= do_action( 'k2t_imagebox_close' );
				$html .= '</div>';
			}
		}

		//Apply filters return
		$html = apply_filters( 'k2t_imagebox_return', $html );

		return $html;
	}
}
