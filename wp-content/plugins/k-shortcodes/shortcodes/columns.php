<?php
/* ------------------------------------------------------- */
/* Columns
/* ------------------------------------------------------- */
if (!function_exists('k2t_columns_shortcode')){
	function k2t_columns_shortcode($atts,$content){
		
		//Global $cl
		$cl = array('k2t-columns');
		
		//Apply filters to cl
		$cl = apply_filters('k2t_columns_classes',$cl);
		
		//Join cl class
		$cl = join(' ', $cl);
		
		if (!preg_match_all("/(.?)\[(col)\b(.*?)(?:(\/))?\](?:(.+?)\[\/col\])?(.?)/s", $content, $matches)){
			return do_shortcode($content);		
		} else {
			//Global $style
			$style_col = array();
			$return = '<div class="'.trim($cl).'">';
			$return .= do_action('k2t_columns_open');
			$return .= '<div class="layer-table"><div class="layer-row">';
			for($i = 0; $i < count($matches[0]); $i++):
				$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
				//Set parameter default of columns
				/*-----------Size-------------*/
				$size = isset( $matches[3][$i]['size'] ) ? trim($matches[3][$i]['size']) : '1/2';
				$size_class = ' col-'.str_replace("/", "-", $size);
				$border = isset( $matches[3][$i]['border'] ) ? trim($matches[3][$i]['border']) : 'false';
				$padding_left = isset( $matches[3][$i]['padding_left'] ) ? trim($matches[3][$i]['padding_left']) : '';
				$padding_right = isset( $matches[3][$i]['padding_right'] ) ? trim($matches[3][$i]['padding_right']) : '';
				$padding_top = isset( $matches[3][$i]['padding_top'] ) ? trim($matches[3][$i]['padding_top']) : '';
				$padding_bottom = isset( $matches[3][$i]['padding_bottom'] ) ? trim($matches[3][$i]['padding_bottom']) : '';
				$background_image = isset( $matches[3][$i]['background_image'] ) ? trim($matches[3][$i]['background_image']) : '';
				$background_color = isset( $matches[3][$i]['background_color'] ) ? trim($matches[3][$i]['background_color']) : '';
				$text_white = isset( $matches[3][$i]['text_white'] ) ? trim($matches[3][$i]['text_white']) : 'false';
				
				if($text_white != 'true'){ $class_textwhite = '';} else { $class_textwhite = ' text-white';}
				
				/*-----------Border-------------*/
				if($border == 'true'){ $has_border = ' has-border'; } else { $has_border = ''; }
				
				/*-----------Padding left-------------*/
				if(is_numeric($padding_left)){ $padding_left = 'padding-left: '.$padding_left.'px'; } else { $padding_left = ''; }
				
				/*-----------Padding right-------------*/
				if(is_numeric($padding_right)){ $padding_right = 'padding-right: '.$padding_right.'px'; } else { $padding_right = '';}
				
				/*-----------Padding Top-------------*/
				if(is_numeric($padding_top)){ $padding_top = 'padding-top: '.$padding_top.'px'; } else { $padding_top = '';}
				
				/*-----------Padding Bottom-------------*/
				if(is_numeric($padding_bottom)){ $padding_bottom = 'padding-bottom: '.$padding_bottom.'px'; } else { $padding_bottom = ''; }
				
				/*-----------Background Image-------------*/
				if($background_image != ''){ $background_image = 'background-image: url("'.$background_image.'")'; } else { $background_image = ''; }
				
				/*-----------Background Color-------------*/
				if($background_color != ''){ $background_color = 'background-color: '.$background_color; } else { $background_color = '';}
				
				//Check to join style of col
				if(($padding_left != '') || ($padding_right != '') || ($padding_top != '') || ($padding_bottom != '') || ($background_image != '') || ($background_color != '')){ 
					$style_col_html = ' style="'.$padding_left.$padding_right.$padding_top.$padding_bottom.$background_image.$background_color.'"'; 
				} else { 
					$style_col_html = ''; 
				}
				
				$return .= '<div class="col'.$size_class.$has_border.$class_textwhite.'"'.$style_col_html.'>'.do_shortcode($matches[5][$i]).'</div>';
				
			endfor;
			$return .= '</div></div>';
			$return .= do_action('k2t_columns_close');
			$return .= '</div>';
			
			//Apply filters return
			$return = apply_filters('k2t_columns_return',$return);
			
			return $return;	
		}
	}
}