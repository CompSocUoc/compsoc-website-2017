<?php
/**
 * Shortcode member.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_member_shortcode' ) ) {
	function k2t_member_shortcode( $atts, $content ) {
		$html = $image = $name = $role = $style = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = $style2_before = $style2_after = $image_link = $data = $width = $height = '';
		extract( shortcode_atts( array(
			'image'       => $image,
			'name'        => '',
			'role'        => '',
			'style'       => 'default',
			'facebook'    => '',
			'twitter'     => '',
			'skype'       => '',
			'pinterest'   => '',
			'instagram'   => '',
			'dribbble'    => '',
			'google_plus' => '',
			'anm'         => '',
			'anm_name'    => '',
			'anm_delay'   => '',
			'id'          => '',
			'class'       => '',
		), $atts ) );

		// Global $cl
		$cl = array( 'k2t-member' );

		// Animation
		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . ' team-area' : '';

		// Style ( 2 style )
		if ( trim( $style ) ) {
			$cl[] = 'style-' . $style;
		}
		if ( $name == '' ) {
			$alt_html = 'member '.( $i+1 );
		} else {
			$alt_html = trim( $name );
		}
		// Get member avatar
		$image_html = '';
		if ( !empty( $image ) ){
			if ( is_numeric( $image ) ){
				$img_id = preg_replace( '/[^\d]/', '', $image );
				$image    = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => '' ) );
				$image_link = $image['p_img_large'][0];
				$data       = ( file_exists( $image_link ) && isset( $image_link ) ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
				$width      = isset( $data[0] ) ? $data[0] : '';
				$height     = isset( $data[1] ) ? $data[1] : '';
				$image_html = '<img width="' . $width . '" height="' . $height . '" src="'. $image['p_img_large'][0] .'" alt="'. $alt_html .'" />';
			}else{
				$data       = ( file_exists( $image_link ) && isset( $image_link ) ) ? getimagesize( $image_link ) : array( 'auto', 'auto' );
				$width      = isset( $data[0] ) ? $data[0] : '';
				$height     = isset( $data[1] ) ? $data[1] : '';
				$image_html = '<img width="' . $width . '" height="' . $height . '" src="'. $image .'" alt="'. $alt_html .'" />';
			}
		}

		// Get member name and role
		if ( ( trim( $name ) == '' ) && ( trim( $role ) == '' ) ) {
			$name_role_html = '';
		} else {
			// Name output
			$name_html = ( trim( $name ) == '' ) ? '' : '<span class="member-name">' . trim( $name ) . '</span>';
			// Role output
			$role_html = ( trim( $role ) == '' ) ? '' : '<span class="member-role">' . trim( $role ) . '</span>';
			// To output div name-role
			$name_role_html = '<header>' . $name_html . $role_html . '</header>';
		}

		

		// Get social network
		if ( function_exists( 'k2t_social_array' ) ) {
			$social_array = k2t_social_array();
			$social_array['email']       = __( 'Email', 'k2t' );
			$social_array['googleplus']  = __( 'Google+', 'k2t' );
			$social_array['google_plus'] = __( 'Google+', 'k2t' );
		} else {
			$social_array = array();
		}
		$display_social = array();

		foreach ( $atts as $key => $val ) {
			if ( $key == 'email' ) $icon = 'envelope-alt';
			elseif ( $key == 'googleplus' || $key == 'google_plus' ) $icon = 'google-plus';
			else $icon = $key;

			if ( isset ( $social_array[$icon] ) && trim( $atts[$key] ) ) {
				$display_social[] = '<li class="'. esc_attr( $social_array[$icon] ) .'"><a href="' . esc_url( $atts[$key] ) . '" title="' . esc_attr( $social_array[$icon] ) . '"><i class="fa fa-' . $icon . '"></i></a></li>';
			}
		}

		// Join social media
		$html_social = '';
		if ( ! empty( $display_social ) ) {
			$html_social .= '<div class="social-bookmarks team-socials-link"><ul>';
			$html_social .= join( '', $display_social );
			$html_social .= '</ul></div>';
		} else {
			$html_social = '';
		}

		// Apply filters to cl
		$cl = apply_filters( 'k2t_member_classes', $cl );

		// Join cl class
		$cl = join( ' ', $cl );

		// Output to frontend
		$html = '<div ' . $id . $data_name . $data_delay . ' class="' . trim( $cl ) . $class . $anm . '">';
		$html .= '
			<article>
				<div class="team-avatar"><div class="mask"></div>'. $image_html .'</div>
				<div class="team-content clearfix">
					'. $name_role_html .'
					'. ( ! empty( $content ) ? '<p>' . do_shortcode( $content ) . '</p>' : '' ) .'
					<div class="social-media-widget">
						'. $html_social .'
					</div>
				</div>
			</article>
		';
		$html .= '</div>';

		// Apply filters return
		return apply_filters( 'k2t_member_return', $html );
	}
}
