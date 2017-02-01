<?php
/**
 * Shortcode tab.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_tab_shortcode' ) ) {
	function k2t_tab_shortcode( $args, $content ) {
		extract( shortcode_atts( array(
			'big_tab'   => 'false',
			'active'    => '1',
			'mouse'     => 'click',
			'animation' => 'false',
			'direction' => 'horizontal',
			'id'        => '',
			'class'     => '',
		), $args ) );

		wp_enqueue_script( 'k2t-tabslet' );

		//Global $cl
		$cl = array( 'k2t-tab' );

		/*--------------Big Tab---------------*/
		if ( trim( $big_tab ) != 'true' ) { $big_tab_class = '';} else { $big_tab_class = ' k2t-big-tab'; }

		/*--------------Active---------------*/
		if ( !is_numeric( trim( $active ) ) ) { $data_active = '1';} else { $data_active = trim( $active ); }

		/*--------------Animation---------------*/
		if ( trim( $animation ) != 'true' ) { $data_animation = 'false';} else { $data_animation = 'true'; }

		/*--------------Mouse---------------*/
		if ( trim( $mouse ) != 'hover' ) { $data_mouse = 'click';} else { $data_mouse = 'hover'; $data_animation = 'false'; }

		/*--------------Direction---------------*/
		if ( trim( $direction ) == 'vertical' ) { $cl[] = 'tab-vertical';}


		if ( !preg_match_all( "/(.?)\[(tab_element)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab_element\])?(.?)/s", $content, $matches ) ) :
			return do_shortcode( $content );
		else :

			//Apply filters to cl
			$cl = apply_filters( 'k2t_tab_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '<div class="'.trim( $cl ). $big_tab_class . '" data-active="'.$data_active.'" data-mouse="'.$data_mouse.'" data-animation="'.$data_animation.'">';
		$html .= do_action( 'k2t_tab_open' );
		$html .= '<ul class="tabnav">';

		//List tab
		for ( $i = 0; $i < count( $matches[0] ); $i++ ):

			$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );

		$title = isset( $matches[3][$i]['title'] ) ? trim( $matches[3][$i]['title'] ) : '';
		$icon = isset( $matches[3][$i]['icon'] ) ? trim( $matches[3][$i]['icon'] ) : '';

		//Check and set parameter of toggle

		/*-----------Title-------------*/
		if ( $title == '' ) { $title_tab = 'Tab Title';}else { $title_tab = $title;}

		/*-----------Icon-------------*/
		if ( $icon != '' ) { $icon_html = '<i class="'.$icon.'"></i>';} else { $icon_html = '';}

		$html .= '<li><a data-href="#tab-'.( $i+1 ).'">'.$icon_html.'<span>'.$title_tab.'</span></a></li>';
		endfor;

		$html .= '</ul>';
		//Content for tab
		for ( $i = 0; $i < count( $matches[0] ); $i++ ):
			$html .= '<div id="tab-'.( $i+1 ).'" class="tab-content">'.do_shortcode( $matches[5][$i] ).'</div>';
		endfor;

		$html .= do_action( 'k2t_tab_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_tab_return', $html );

		return $html;

		endif;
	}
}
