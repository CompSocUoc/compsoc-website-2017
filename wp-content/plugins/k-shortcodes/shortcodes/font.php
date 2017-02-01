<?php
/* ------------------------------------------------------- */
/* Font
/* ------------------------------------------------------- */
if (!function_exists('k2t_font_shortcode')){
	function k2t_font_shortcode($atts,$content = NULL){
		extract(shortcode_atts(array(
			'font'		=>  '',
			'tag'		=>	'',
			'size'		=>	'',
			'align'		=>  'left',
			'font_weight'	=> '',
			'css'		=> '',
		), $atts));
		
		//Global $cl
		$cl = array('k2t-google-font');
		
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'k2t-google-font-' . str_replace(' ','-',$font), "$protocol://fonts.googleapis.com/css?family=" . str_replace(' ','+', $font ) . ":100,200,300,400,500,600,700,800,900&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese" );
		/*-----------Font Family-------------*/
		$style = 'font-family:\''.$font.'\';';
		/*-----------Font Size-------------*/
		if ( $size ) {
			$style .= 'font-size:'.$size.'px;';
		}
		/*-----------Font Weight-------------*/
		if (in_array(trim($font_weight),array('100','200','300','400','500','600','700','800','900'))){ $style .= 'font-weight: '.trim($font_weight).';';}
		
		/*-----------CSS-------------*/
		if(trim($css) != ''){ $style .= trim($css);}
		
		$style = 'style="'.esc_attr($style).'"';
		
		if ( in_array(trim($tag),array('h1','h2','h3','h4','h5','h6','span','p'))) {$tag = trim($tag); $cl[] = 'tag-'.$tag;} else { $tag = 'h2'; $cl[] = 'tag-h2';}
		
		/*-----------Align-------------*/
		if ( !in_array(trim($align),array('left','right','center'))) { $cl[] = ' align-left';}else {$cl[] = ' align-'.trim($align);}
		
		//Apply filters to cl
		$cl = apply_filters('k2t_font_classes',$cl);
		
		//Join cl class
		$cl = join(' ', $cl);
		
		$return = '<'.$tag.' '.$style.' class="'.trim($cl).'">';
		$return .= do_action('k2t_font_open');
		$return .=  do_shortcode($content);
		$return .= do_action('k2t_font_close');
		$return .= '</'.$tag.'>';
			
		//Apply filters return
		$return = apply_filters('k2t_font_return',$return);
		
		return $return;	
	}
}