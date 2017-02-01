<?php
/**
 * Shortcode pricing.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_pricing_shortcode' ) ) {
	function k2t_pricing_shortcode( $atts, $content ) {
		$html = $separated = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'separated' 		=> 'false',
			'anm'       		=> '',
			'anm_name'  		=> '',
			'anm_delay' 		=> '',
			'id'        		=> '',
			'class'     		=> '',
			'pricing_content' 	=> '',
		), $atts ) );
		//Global $cl
		$cl = array( 'k2t-pricing' );

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		if ( !preg_match_all( "/(.?)\[(pricing_column)\b(.*?)(?:(\/))?\]/s", $content, $matches ) ) {
			return do_shortcode( $content );
		} else {
			$number_pricing_column = count( $matches[0] );
			//Add class number process
			$cl[] = 'pricing-'.$number_pricing_column;

			//Check has-del
			$old_price_check = '';
			for ( $i = 0; $i < count( $matches[0] ); $i++ ):
				$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );
				$price_get = isset( $matches[3][$i]['price'] ) ? trim( $matches[3][$i]['price'] ) : '';
				$old_price_get = isset( $matches[3][$i]['old_price'] ) ? trim( $matches[3][$i]['old_price'] ) : '';
				if ( $old_price_get != '' ) {
					$old_price_check .= $old_price_get;
				}else {
					$old_price_check .= '';
				}
				//Check isset price
				$price_check = '';
				if ( $price_get != '' ) {
					$price_check .= 'a';
				}else {
					$price_check .= '';
				}

			endfor;

			if ( trim( $old_price_check ) == '' ) { $cl[] = 'no-del';} else {$cl[] = 'has-del';}

			//Check separated true or false
			if ( trim( $separated ) == 'true' ) { $cl[] = 'separated';}

			//Apply filters to cl
			$cl = apply_filters( 'k2t_pricing_classes', $cl );

			//Join cl class
			$cl = join( ' ', $cl );

			$columns = count( $matches[0] );
			if ( $columns > 5 ) $columns = 5;

			$html = '<section class="table-'. $columns .'col clearfix '.trim( $cl ) .'">';
			$html .= do_action( 'k2t_pricing_open' );
			for ( $i = 0; $i < count( $matches[0] ); $i++ ):
				//Get parameter of pricing column to set
				$title = isset( $matches[3][$i]['title'] ) ? trim( $matches[3][$i]['title'] ) : '';
				$sub_title = isset( $matches[3][$i]['sub_title'] ) ? trim( $matches[3][$i]['sub_title'] ) : '';
				$image = isset( $matches[3][$i]['image'] ) ? trim( $matches[3][$i]['image'] ) : '';
				$price = isset( $matches[3][$i]['price'] ) ? trim( $matches[3][$i]['price'] ) : '';
				$old_price = isset( $matches[3][$i]['old_price'] ) ? trim( $matches[3][$i]['old_price'] ) : '';
				$unit = isset( $matches[3][$i]['unit'] ) ? trim( $matches[3][$i]['unit'] ) : '';
				$unit_position = isset( $matches[3][$i]['unit_position'] ) ? trim( $matches[3][$i]['unit_position'] ) : 'left';
				$price_per = isset( $matches[3][$i]['price_per'] ) ? trim( $matches[3][$i]['price_per'] ) : '';
				$link = isset( $matches[3][$i]['link'] ) ? esc_url( trim( $matches[3][$i]['link'] ) ) : '';
				$link_text = isset( $matches[3][$i]['link_text'] ) ? trim( $matches[3][$i]['link_text'] ) : 'SIGN UP NOW';
				if( $matches[3][$i]['link_target'] != '_self' ){
					$link_target = '_blank';
				}
				else{
					$link_target = '_self';
				}
				$featured = isset( $matches[3][$i]['featured'] ) ? trim( $matches[3][$i]['featured'] ) : 'false';
				$features_list = isset( $matches[3][$i]['features_list'] ) ? trim( $matches[3][$i]['features_list'] ) : 'false';
				$color = isset( $matches[3][$i]['color'] ) ? trim( $matches[3][$i]['color'] ) : '';
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
						$data       = isset( $image_link ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
						$width      = isset( $data[0] ) ? $data[0] : '';
						$height     = isset( $data[1] ) ? $data[1] : '';
						$image_html = '<img width="' . $width . '" height="' . $height . '" src="'. $image .'" alt="Avatar" />';
					}
				}

				// Convert to Html data
				$price_html = !empty( $price ) ? '<span>'. $price .'</span>' : '';
				$unit_html = !empty( $unit ) ? '<sup>'. $unit .'</sup>' : '';
				$price_per_html = !empty( $price_per ) ? '/'. $price_per : '';
				$content = ( isset( $matches[3][$i]['pricing_content'] ) && !empty( $matches[3][$i]['pricing_content'] ) ) ? $matches[3][$i]['pricing_content'] : '';
				$button_html = !empty( $link ) ? do_shortcode( '[button target="'. $link_target .'" link="'. $link .'" icon_position="right" size="medium" align="center" anm_name="bounce" button_style="green" title="'. $link_text .'"]' ) : '';

				// Class
				$column_class = '';
				if ( $i == 0 ){
					$column_class .= ' pricing-column-first';
				}
				if ( $featured == 'true' ){
					$column_class .= ' pricing-special ';
				}

                $html .= '<div class="pricing-column '. $column_class .'">
	                <div class="k2t-element-hover">
	                    <div class="pricing-header">
	                    	<div class="pricing-image">' . $image_html . '</div>
	                        <h3 class="pricing-title">'.$title.'</h3>
	                        <p class="pricing-sub_title">'.$sub_title.'</p></div>
	                    <div class="price">'. $unit_html . $price_html . $price_per_html .'</div>
	                    <div class="description">'. $content .'</div>
	                    <div class="pricing-footer">'. $button_html .'</div>
                    </div>			
                </div>';
                endfor;
            $html .= do_action( 'k2t_pricing_close' );              
            $html .= '</section>';
            //Apply filters return
			$html = apply_filters( 'k2t_pricing_return', $html );
			return $html;
		}
	}
}
