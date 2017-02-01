<?php
/**
 * Shortcode brands.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_brands_shortcode' ) ) {
	$html = $column = $related_url = $padding = $grayscale = $title = $tooltip = $link = $target = $tooltip = $class_tip = $anm = $anm_name = $anm_delay = $id = $class = '';
	function k2t_brands_shortcode( $args, $content ) {
		extract( shortcode_atts( array(
			'column'    => '4',
			'padding'   => 'false',
			'grayscale' => 'false',
			'related_url' => '',
			'title'     => '',
			'tooltip'   => '',
			'link'      => '',
			'target'    => '',
			'tooltip'   => '',
			'anm'       => '',
			'anm_name'  => '',
			'anm_delay' => '',
			'id'        => '',
			'class'     => '',
		), $args ) );

		//Global $cl
		$cl = array( 'k2t-brands' );

		if ( ! preg_match_all( "/(.?)\[(brand)\b(.*?)(?:(\/ ) )?\]/s", $content, $matches ) ) :
			return do_shortcode( $content );
		else :
			//Numbers band element
			$number_band = count( $matches[0] );

		/*----------------Brands column-----------------*/
		if ( ! in_array( trim( $column ), array( '1', '2', '3', '4', '5', '6', '7', '8' ) ) ) { $columns = '4';} else { $columns = trim( $column );}

		$cl[] = 'brands-'.$columns.'-columns';

		/*----------------Padding-----------------*/
		if ( trim( $padding ) == 'true' ) { $cl[] = 'has-padding';}

		/*----------------Grayscale-----------------*/
		if ( trim( $grayscale ) == 'true' ) { $cl[] = 'enable-grayscale';}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_brands_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		$html = '<div ' . $id . ' class="' . trim( $cl ) . $class . '">';
		$html .= do_action( 'k2t_brands_open' );
		$html .= '<div class="brand-table"><div class="brand-row">';

		for ( $i = 0; $i < count( $matches[0] ); $i++ ):

			$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );

			$title     = isset( $matches[3][$i]['title'] ) ? trim( $matches[3][$i]['title'] ) : '';
			$tooltip   = isset( $matches[3][$i]['tooltip'] ) ? trim( $matches[3][$i]['tooltip'] ) : 'false';
			$related_url   = isset( $matches[3][$i]['related_url'] ) ? trim( $matches[3][$i]['related_url'] ) : 'javascript:void(0)';
			$link      = isset( $matches[3][$i]['link'] ) ? trim( $matches[3][$i]['link'] ) : '';
			$target    = isset( $matches[3][$i]['target'] ) ? trim( $matches[3][$i]['target'] ) : '_self';
			$anm       = isset( $matches[3][$i]['anm'] ) ? trim( $matches[3][$i]['anm'] ) : '';
			$anm_name  = isset( $matches[3][$i]['anm_name'] ) ? trim( $matches[3][$i]['anm_name'] ) : '';
			$anm_delay = isset( $matches[3][$i]['anm_delay'] ) ? trim( $matches[3][$i]['anm_delay'] ) : '';
			if ( $anm ) {
				$anm        = ' animated';
				$data_name  = ' data-animation="' . $anm_name . '"';
				$data_delay = ' data-animation-delay="' . $anm_delay . '"';
			}

			/*-----------Title-------------*/
			if ( $title == '' ) {
				$title_html = 'Brand '.( $i+1 ).' title';
				$alt_html = 'Brand '.( $i+1 );
			} else {
				$title_html = trim( $title );
				$alt_html = trim( $title );
			}

			/*-----------Get image-------------*/
			$img = '';
			if ( !empty( $link ) ){
				if ( is_numeric( $link ) ){
					$img_id = preg_replace( '/[^\d]/', '', $link );

					$alt = wp_get_attachment_image( $img_id );
					$img = $alt;
					// var_dump($alt);
					// $image    = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => '' ) );
					// $image_link = $image['p_img_large'][0];
					// $data       = ( file_exists( $image_link ) && isset( $image_link ) ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
					// $width      = isset( $data[0] ) ? $data[0] : '';
					// $height     = isset( $data[1] ) ? $data[1] : '';
					// $img = '<img width="' . $width . '" height="' . $height . '" alt="'. $alt .'" src="'. $image['p_img_large'][0] .'" />';
				}else{
					$data       = ( file_exists( $image_link ) && isset( $image_link ) ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
					$width      = isset( $data[0] ) ? $data[0] : '';
					$height     = isset( $data[1] ) ? $data[1] : '';
					$img = '<img width="' . $width . '" height="' . $height . '" src="'. $link .'" />';
				}
			}

			/*-----------Tooltip-------------*/
			if ( $tooltip == 'true' ) { $class_tip = ' class="hastip tooltip-top"'; wp_enqueue_script( 'k2t-tipsy' ); } else { $class_tip = '';}

			$data_name = $data_delay = '';
			$html .= '<div class="brand-cell ' . $anm . '" ' . $data_name . ' ' . $data_delay . '><a href="'. $related_url .'" target="blank_">'. $img .'</a></div>';

			//Check to add brand-row
			if ( ( ( ( $i+1 ) % $columns ) == '0' ) && ( ( $i+1 ) < $number_band ) ) {
				$html .= '</div><div class="brand-row">';
			}

		endfor;

		$html .= '</div></div>';
		$html .= do_action( 'k2t_brands_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_brands_return', $html );

		return $html;

		endif;
	}
}
