<?php
/**
 * SMOF Options Machine Class
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.0.0
 * @author      Syamil MJ
 */
global $smof_data;
class Options_Machine {

	/**
	 * PHP5 contructor
	 *
	 * @since 1.0.0
	 */
	function __construct( $options ) {

		$return = $this->optionsframework_machine( $options );

		$this->Inputs = $return[0];
		$this->Menu = $return[1];
		$this->Defaults = $return[2];

	}
	/**
	 * Sanitize option
	 *
	 * Sanitize & returns default values if don't exist
	 *
	 * Notes:
	 * - For further uses, you can check for the $value['type'] and performs
	 * more speficic sanitization on the option
	 * - The ultimate objective of this function is to prevent the "undefined index"
	 * errors some authors are having due to malformed options array
	 */
	static function sanitize_option( $value ) {
		$defaults = array(
			'name' => '',
			'desc' => '',
			'id'   => '',
			'std'  => '',
			'mod'  => '',
			'type' => ''
		);

		$value = wp_parse_args( $value, $defaults );

		return $value;

	}
	/**
	 * Process options data and build option fields
	 *
	 * @uses get_theme_mod()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function optionsframework_machine( $options ) {
		global $smof_output, $smof_details, $smof_data;
		if ( empty( $options ) )
			return;
		if ( empty( $smof_data ) )
			$smof_data = of_get_options();

		$data        = $smof_data;
		$defaults    = array();
		$counter     = 0;
		$menu        = '';
		$output      = '';
		$update_data = false;

		do_action(
			'optionsframework_machine_before',
			array(
				'options' => $options,
				'smof_data' => $smof_data,
			)
		);
		if ( $smof_output != '' ) {
			$output .= $smof_output;
			$smof_output = '';
		}
		
		$options = apply_filters('optionsframework_machine_before', $options);
		
		foreach ( $options as $value ) {
			// continue if option is not required
			if( ! empty($value['disable']) && $value['disable'] == true ){
				continue;
			}
			
			// sanitize option
			if ( $value['type'] != "heading" )
				$value = self::sanitize_option( $value );

			$counter++;
			$val = '';

			//create array of defaults
			if ( $value['type'] == 'multicheck' ) {
				if ( is_array( $value['std'] ) ) {
					foreach ( $value['std'] as $i=>$key ) {
						$defaults[$value['id']][$key] = true;
					}
				} else {
					$defaults[$value['id']][$value['std']] = true;
				}
			} else {
				if ( isset( $value['id'] ) ) $defaults[$value['id']] = $value['std'];
			}

			/* condition start */
			if ( ! empty( $smof_data ) || ! empty( $data ) ) {

				if ( array_key_exists( 'id', $value ) && ! isset( $smof_data[$value['id']] ) ) {
					$smof_data[$value['id']] = $value['std'];
					if ( $value['type'] == "checkbox" && $value['std'] == 0 ) {
						$smof_data[$value['id']] = 0;
					} else {
						$update_data = true;
					}
				}
				if ( array_key_exists( 'id', $value ) && empty( $smof_details[$value['id']] ) ) {
					$smof_details[$value['id']] = $smof_data[$value['id']];
				}
				
				//Start Heading
				if ( $value['type'] != 'heading' ) {
					$class = ''; if ( isset( $value['class'] ) ) { $class = $value['class']; }

					//hide items in checkbox group
					$fold = '';
					if ( array_key_exists( 'fold', $value ) ) {
						if ( isset( $smof_data[$value['fold']] ) && $smof_data[$value['fold']] ) {
							$fold='f_'. $value['fold'] . ' ';
						} else {
							$fold='f_'. $value['fold'] . ' temphide ';
						}
					}

					// Add class conditional_logic
					if ( ! empty( $value['conditional_logic'] ) ){
						$class .= $value['conditional_logic']['field'] . ' ' . $value['conditional_logic']['value'];
					}

					$output .= '<div id="section-' . $value['id'] . '" class="'.$fold.'section section-' . $value['type'] . ' ' . $class . '">' . "\n";

					//only show header if 'name' value exists
					if ( $value['name'] ) $output .= '<h3 class="heading">' . $value['name'] . '</h3>' . "\n";

					$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";

				}
				//End Heading

				//switch statement to handle various options type
				switch ( $value['type'] ) {

					//text input
				case 'text':
					$t_value = '';
					$t_value = stripslashes( $smof_data[$value['id']] );

					$mini ='';
					if ( empty( $value['mod'] ) ) $value['mod'] = '';
					if ( $value['mod'] == 'mini' ) { $mini = 'mini';}

					$output .= '<input class="of-input ' . esc_attr( $mini ) . '" name="' . esc_attr( $value['id'] ) . '" id="' .  esc_attr( $value['id'] )  . '" type="' .  esc_attr( $value['type'] )  . '" value="' .  esc_attr( $t_value )  . '" />';
					break;
				case 'textarea':
					$cols = '8';
					$ta_value = '';
					$css_editor = 0;
					$js_editor = 0;
					if ( isset( $value['options'] ) ) {
						$ta_options = $value['options'];
						if ( isset( $ta_options['cols'] ) ) {
							$cols = $ta_options['cols'];
						}
					}
					if(isset( $value['is_css_editor'] )){

						$css_editor = 1;
					}
					if(isset( $value['is_js_editor'] )){

						$js_editor = 1;
					}

					$ta_value = stripslashes( $smof_data[$value['id']] );
					if($css_editor == 0 && $js_editor == 0 ){
					$output .= '<textarea class="of-input" name="'.esc_attr( $value['id'] ).'" id="'. esc_attr( $value['id'] ) .'" cols="'. esc_attr( $cols ) .'" rows="8">'.esc_attr( $ta_value ).'</textarea>';
					}
					else if($css_editor == 1){
						$output .= '
						<textarea class="of-input" name="'.esc_attr( $value['id'] ).'_pre" id="'. esc_attr( $value['id'] ) .'_pre" cols="'. $cols .'" rows="8">'.esc_attr( $ta_value ).'</textarea>
						<textarea class="of-input" style="display:none" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>
						<script>

								var editor'.str_replace( "-" , "_" ,$value['id']).' = ace.edit("'. str_replace( "-" , "_" ,$value['id']) .'_pre");
								editor'.str_replace( "-" , "_" ,$value['id']).'.setTheme("ace/theme/textmate");
									editor'.str_replace( "-" , "_" ,$value['id']).'.session.setMode("ace/mode/css");
									editor'.str_replace( "-" , "_" ,$value['id']).'.renderer.setScrollMargin(10, 10);
									editor'.str_replace( "-" , "_" ,$value['id']).'.setOptions({
									    // "scrollPastEnd": 0.8,
									    autoScrollEditorIntoView: false
									});
								editor'.str_replace( "-" , "_" ,$value['id']).'.setValue(jQuery("#'. $value['id'] .'").val()) // moves cursor to the end
							
								editor'.str_replace( "-" , "_" ,$value['id']).'.getSession().on("change", function () {
							       jQuery("#'. $value['id'] .'").val(editor'.str_replace( "-" , "_" ,$value['id']).'.getSession().getValue());
							    });

						</script>';

					}
					else  if($js_editor == 1){
						$output .= '
						<textarea class="of-input" name="'.esc_attr( $value['id'] ).'_pre" id="'. esc_attr( $value['id'] ) .'_pre" cols="'. $cols .'" rows="8">'.esc_attr( $ta_value ).'</textarea>
						<textarea class="of-input" style="display:none" name="'.esc_attr( $value['id'] ).'" id="'. esc_attr( $value['id'] ) .'" cols="'. $cols .'" rows="8">'.esc_attr( $ta_value ).'</textarea>
						<script>

								var editor'.str_replace( "-" , "_" ,$value['id']).' = ace.edit("'. str_replace( "-" , "_" ,$value['id']) .'_pre");
								editor'.str_replace( "-" , "_" ,$value['id']).'.setTheme("ace/theme/textmate");
									editor'.str_replace( "-" , "_" ,$value['id']).'.session.setMode("ace/mode/javascript");
									editor'.str_replace( "-" , "_" ,$value['id']).'.renderer.setScrollMargin(10, 10);
									editor'.str_replace( "-" , "_" ,$value['id']).'.setOptions({
									    // "scrollPastEnd": 0.8,
									    autoScrollEditorIntoView: false
									});
									editor'.str_replace( "-" , "_" ,$value['id']).'.setValue(jQuery("#'. $value['id'] .'").val()) // moves cursor to the end
							
									editor'.str_replace( "-" , "_" ,$value['id']).'.getSession().on("change", function () {
								       jQuery("#'. $value['id'] .'").val(editor'.str_replace( "-" , "_" ,$value['id']).'.getSession().getValue());
								    });

						</script>';

					}


					break;

					//radiobox option
				case "radio":
					$checked = ( isset( $smof_data[$value['id']] ) ) ? checked( $smof_data[$value['id']], $option, false ) : '';
					foreach ( $value['options'] as $option=>$name ) {
						$output .= '<input class="of-input of-radio" name="'. esc_attr( $value['id'] ) .'" type="radio" value="'. esc_attr( $option ) .'" ' . checked( $smof_data[$value['id']], $option, false ) . ' /><label class="radio">'.$name.'</label><br/>';
					}
					break;

					//checkbox option
				case 'checkbox':
					if ( empty( $smof_data[$value['id']] ) ) {
						$smof_data[$value['id']] = 0;
					}

					$fold = '';
					if ( array_key_exists( "folds", $value ) ) $fold="fld ";

					$output .= '<input type="hidden" class="'.$fold.'checkbox of-input" name="'. esc_attr( $value['id'] ) .'" id="'. esc_attr( $value['id'] ) .'" value="0"/>';
					$output .= '<input type="checkbox" class="'.$fold.'checkbox of-input" name="'. esc_attr( $value['id'] ) .'" id="'. esc_attr( $value['id'] ) .'" value="1" '. checked( $smof_data[$value['id']], 1, false ) .' />';
					break;

					//multiple checkbox option
				case 'multicheck':
					( isset( $smof_data[$value['id']] ) )? $multi_stored = $smof_data[$value['id']] : $multi_stored="";

					foreach ( $value['options'] as $key => $option ) {
						if ( empty( $multi_stored[$key] ) ) {$multi_stored[$key] = '';}
						$of_key_string = $value['id'] . '_' . $key;
						$output .= '<input type="checkbox" class="checkbox of-input" name="'. esc_attr( $value['id'] ) .'['. esc_attr( $key ) .']'.'" id="'. esc_attr( $of_key_string ) .'" value="1" '. checked( $multi_stored[$key], 1, false ) .' /><label class="multicheck" for="'. $of_key_string .'">'. $option .'</label><br />';
					}
					break;

					// Color picker
				case "color":
					$default_color = '';
					if ( isset( $value['std'] ) ) {
						$default_color = ' data-default-color="' .$value['std'] . '" ';
					}
					$output .= '<input name="' . esc_attr( $value['id'] ) . '" id="' . esc_attr( $value['id'] ) . '" class="of-color"  type="text" value="' . esc_attr( $smof_data[$value['id']] ) . '"' . $default_color .' />';

					break;

					//typography option
				case 'typography':

					$typography_stored = isset( $smof_data[$value['id']] ) ? $smof_data[$value['id']] : $value['std'];

					/* Font Size */

					if ( isset( $typography_stored['size'] ) ) {
						$output .= '<div class="select_wrapper typography-size" original-title="Font size">';
						$output .= '<select class="of-typography of-typography-size select" name="'. esc_attr( $value['id'] ) .'[size]" id="'. esc_attr( $value['id'] ) .'_size">';
						for ( $i = 9; $i < 20; $i++ ) {
							$test = $i.'px';
							$output .= '<option value="'. esc_attr( $i ) .'px" ' . selected( $typography_stored['size'], $test, false ) . '>'. $i .'px</option>';
						}

						$output .= '</select></div>';

					}

					/* Line Height */
					if ( isset( $typography_stored['height'] ) ) {

						$output .= '<div class="select_wrapper typography-height" original-title="Line height">';
						$output .= '<select class="of-typography of-typography-height select" name="'. esc_attr( $value['id'] ) .'[height]" id="'. esc_attr( $value['id'] ) .'_height">';
						for ( $i = 20; $i < 38; $i++ ) {
							$test = $i.'px';
							$output .= '<option value="'. esc_attr( $i ) .'px" ' . selected( $typography_stored['height'], $test, false ) . '>'. $i .'px</option>';
						}

						$output .= '</select></div>';

					}

					/* Font Face */
					if ( isset( $typography_stored['face'] ) ) {

						$output .= '<div class="select_wrapper typography-face" original-title="Font family">';
						$output .= '<select class="of-typography of-typography-face select" name="'. esc_attr( $value['id'] ) .'[face]" id="'. esc_attr( $value['id'] ) .'_face">';

						$faces = array( 'arial'=>'Arial',
							'verdana'=>'Verdana, Geneva',
							'trebuchet'=>'Trebuchet',
							'georgia' =>'Georgia',
							'times'=>'Times New Roman',
							'tahoma'=>'Tahoma, Geneva',
							'palatino'=>'Palatino',
							'helvetica'=>'Helvetica' );
						foreach ( $faces as $i=>$face ) {
							$output .= '<option value="'. esc_attr( $i ) .'" ' . selected( $typography_stored['face'], $i, false ) . '>'. $face .'</option>';
						}

						$output .= '</select></div>';

					}

					/* Font Weight */
					if ( isset( $typography_stored['style'] ) ) {

						$output .= '<div class="select_wrapper typography-style" original-title="Font style">';
						$output .= '<select class="of-typography of-typography-style select" name="'. esc_attr( $value['id'] ) .'[style]" id="'. esc_attr( $value['id'] ) .'_style">';
						$styles = array( 'normal'=>'Normal',
							'italic'=>'Italic',
							'bold'=>'Bold',
							'bold italic'=>'Bold Italic' );

						foreach ( $styles as $i=>$style ) {

							$output .= '<option value="'. esc_attr( $i ) .'" ' . selected( $typography_stored['style'], $i, false ) . '>'. $style .'</option>';
						}
						$output .= '</select></div>';

					}

					/* Font Color */
					if ( isset( $typography_stored['color'] ) ) {

						$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector typography-color"><div style="background-color: '.$typography_stored['color'].'"></div></div>';
						$output .= '<input class="of-color of-typography of-typography-color" original-title="Font color" name="'. esc_attr( $value['id'] ) .'[color]" id="'. esc_attr( $value['id'] ) .'_color" type="text" value="'. esc_attr( $typography_stored['color'] ) .'" />';

					}

					break;

					//border option
				case 'border':

					/* Border Width */
					$border_stored = $smof_data[$value['id']];

					$output .= '<div class="select_wrapper border-width">';
					$output .= '<select class="of-border of-border-width select" name="'. esc_attr( $value['id'] ) .'[width]" id="'. esc_attr( $value['id'] ) .'_width">';
					for ( $i = 0; $i < 21; $i++ ) {
						$output .= '<option value="'. esc_attr( $i ) .'" ' . selected( $border_stored['width'], $i, false ) . '>'. $i .'</option>';     }
					$output .= '</select></div>';

					/* Border Style */
					$output .= '<div class="select_wrapper border-style">';
					$output .= '<select class="of-border of-border-style select" name="'. esc_attr( $value['id'] ) .'[style]" id="'. esc_attr( $value['id'] ) .'_style">';

					$styles = array( 'none'=>'None',
						'solid'=>'Solid',
						'dashed'=>'Dashed',
						'dotted'=>'Dotted' );

					foreach ( $styles as $i=>$style ) {
						$output .= '<option value="'. esc_attr( $i ) .'" ' . selected( $border_stored['style'], $i, false ) . '>'. $style .'</option>';
					}

					$output .= '</select></div>';

					/* Border Color */
					$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div style="background-color: '.$border_stored['color'].'"></div></div>';
					$output .= '<input class="of-color of-border of-border-color" name="'. esc_attr( $value['id'] ) .'[color]" id="'. esc_attr( $value['id'] ) .'_color" type="text" value="'. $border_stored['color'] .'" />';

					break;

					//images checkbox - use image as checkboxes
				case 'images':

					$i = 0;

					$select_value = ( isset( $smof_data[$value['id']] ) ) ? $smof_data[$value['id']] : '';

					foreach ( $value['options'] as $key => $option ) {
						$i++;

						$checked = '';
						$selected = '';
						if ( NULL!=checked( $select_value, $key, false ) ) {
							$checked = checked( $select_value, $key, false );
							$selected = 'of-radio-img-selected';
						}
						$output .= '<span>';
						$output .= '<input type="radio" id="of-radio-img-' . esc_attr( $value['id'] ) . esc_attr( $i ) . '" class="checkbox of-radio-img-radio" value="'. esc_attr( $key ) .'" name="'. esc_attr( $value['id'] ) .'" '.$checked.' />';
						$output .= '<div class="of-radio-img-label">'. $key .'</div>';
						$output .= '<img src="'.esc_url( $option ).'" alt="" class="of-radio-img-img '. $selected .'" onClick="document.getElementById(\'of-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
						$output .= '</span>';
					}

					break;

					//info (for small intro box etc)
				case "info":
					$info_text = $value['std'];
					$output .= '<div class="of-info">'.$info_text.'</div>';
					break;

					//display a single image
				case "image":
					$src = $value['std'];
					$output .= '<img src="'.esc_url( $src ).'">';
					break;

					//tab heading
				case 'heading':
					if ( $counter >= 2 ) {
						$output .= '</div>'."\n";
					}
					//custom icon
					$icon = '';
					if ( isset( $value['icon'] ) ) {
						$icon = $value['icon'];
					}
					$header_class = str_replace( ' ', '', strtolower( $value['name'] ) );
					$jquery_click_hook = str_replace( ' ', '', strtolower( $value['name'] ) );
					$jquery_click_hook = "of-option-" . trim( preg_replace( '/ +/', '', preg_replace( '/[^A-Za-z0-9 ]/', '', urldecode( html_entity_decode( strip_tags( $jquery_click_hook ) ) ) ) ) );

					$menu .= '<li class="'. $header_class .'">' . $icon . '<a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $value['name'] .'</a></li>';
					$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
					break;

					//drag & drop slide manager
				case 'slider':
					$output .= '<div class="slider"><ul id="'.$value['id'].'">';
					$slides = $smof_data[$value['id']];
					$count = count( $slides );
					if ( $count < 2 ) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_slider_function( $value['id'], $value['std'], $oldorder, $order );
					} else {
						$i = 0;
						foreach ( $slides as $slide ) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_slider_function( $value['id'], $value['std'], $oldorder, $order );
						}
					}
					$output .= '</ul>';
					$output .= '<a href="#" class="button slide_add_button">Add New Slide</a></div>';

					break;

					//drag & drop block manager
				case 'sorter':

					// Make sure to get list of all the default blocks first
					$all_blocks = $value['std'];

					$temp = array(); // holds default blocks
					$temp2 = array(); // holds saved blocks

					foreach ( $all_blocks as $blocks ) {
						$temp = array_merge( $temp, $blocks );
					}

					$sortlists = isset( $data[$value['id']] ) && !empty( $data[$value['id']] ) ? $data[$value['id']] : $value['std'];

					foreach ( $sortlists as $sortlist ) {
						$temp2 = array_merge( $temp2, $sortlist );
					}

					// now let's compare if we have anything missing
					foreach ( $temp as $k => $v ) {
						if ( !array_key_exists( $k, $temp2 ) ) {
							$sortlists['disabled'][$k] = $v;
						}
					}

					// now check if saved blocks has blocks not registered under default blocks
					foreach ( $sortlists as $key => $sortlist ) {
						foreach ( $sortlist as $k => $v ) {
							if ( !array_key_exists( $k, $temp ) ) {
								unset( $sortlist[$k] );
							}
						}
						$sortlists[$key] = $sortlist;
					}

					// assuming all sync'ed, now get the correct naming for each block
					foreach ( $sortlists as $key => $sortlist ) {
						foreach ( $sortlist as $k => $v ) {
							$sortlist[$k] = $temp[$k];
						}
						$sortlists[$key] = $sortlist;
					}

					$output .= '<div id="'.$value['id'].'" class="sorter">';


					if ( $sortlists ) {

						foreach ( $sortlists as $group=>$sortlist ) {

							$output .= '<ul id="'.$value['id'].'_'.$group.'" class="sortlist_'.$value['id'].'">';
							$output .= '<h3>'.$group.'</h3>';

							foreach ( $sortlist as $key => $list ) {

								$output .= '<input class="sorter-placebo" type="hidden" name="'. esc_attr( $value['id'] ) .'['. esc_attr( $group ) .'][placebo]" value="placebo">';

								if ( $key != "placebo" ) {

									$output .= '<li id="'.$key.'" class="sortee">';
									$output .= '<input class="position" type="hidden" name="'. esc_attr( $value['id'] ).'['. esc_attr( $group ) .']['. esc_attr( $key ) .']" value="'. esc_attr( $list ) .'">';
									$output .= $list;
									$output .= '</li>';

								}

							}

							$output .= '</ul>';
						}
					}

					$output .= '</div>';
					break;

					//background images option
				case 'tiles':

					$i = 0;
					$select_value = isset( $smof_data[$value['id']] ) && !empty( $smof_data[$value['id']] ) ? $smof_data[$value['id']] : '';
					if ( is_array( $value['options'] ) ) {
						foreach ( $value['options'] as $key => $option ) {
							$i++;

							$checked = '';
							$selected = '';
							if ( NULL!=checked( $select_value, $option, false ) ) {
								$checked = checked( $select_value, $option, false );
								$selected = 'of-radio-tile-selected';
							}
							$output .= '<span>';
							$output .= '<input type="radio" id="of-radio-tile-' . esc_attr( $value['id'] ) . esc_attr( $i ) . '" class="checkbox of-radio-tile-radio" value="'. esc_attr( $option ) .'" name="'. esc_attr( $value['id'] ).'" '.$checked.' />';
							$output .= '<div class="of-radio-tile-img '. $selected .'" style="background: url('.$option.')" onClick="document.getElementById(\'of-radio-tile-'. $value['id'] . $i.'\').checked = true;"></div>';
							$output .= '</span>';
						}
					}

					break;

					//backup and restore options data
				case 'backup':

					$instructions = $value['desc'];
					$backup = of_get_options( BACKUPS );
					$init = of_get_options( 'smof_init' );


					if ( empty( $backup['backup_log'] ) ) {
						$log = 'No backups yet';
					} else {
						$log = $backup['backup_log'];
					}

					$output .= '<div class="backup-box">';
					$output .= '<div class="instructions">'.$instructions."\n";
					$output .= '<p><strong>'. __( 'Last Backup : ', 'k2t' ).'<span class="backup-log">'.$log.'</span></strong></p></div>'."\n";
					$output .= '<a href="#" id="of_backup_button" class="button" title="Backup Options">Backup Options</a>';
					$output .= '<a href="#" id="of_restore_button" class="button" title="Restore Options">Restore Options</a>';
					$output .= '</div>';

					break;
				// Backup and restore options data
				case 'advance_importer':
					$instructions = $value['desc'];
					$backup = of_get_options( BACKUPS );
					
					$advan_import_id = $value['id'];
					$advance_import_data = $value['advance_importer'];
					$array_backup = array();
					$json_data_save = "";
					foreach($advance_import_data as $aid)
					{
						if(isset($smof_data[$aid])){
							$array_backup[$aid] = $smof_data[$aid];
						}
					}
					$output .= '<div class="k2t-importer-box">';
					$output .= '<a href="#" id="k2t_export_button" class="button k2t_export_button" title="Backup" for="'.$value['id'].'" descript="'.$value['desc'].'"  style="margin-right:10px;">Export Header</a>';
					$output .= '<input type="hidden" class="'. esc_attr( $fold ) .'  of-input" name="'.esc_attr( $value['id'] ).'" id="'. esc_attr( $value['id'] ) .'" value=\''.( k2t_encode(json_encode ( $array_backup ) ))  .'\'/>';
					$output .= '<a href="#" id="k2t_import_button" class="button k2t_import_button" title="Restore" for="'.$value['id'].'" style="margin-right:10px;">Import Header</a>';
					$output .= '</div>';
					$output .= '<div class="advance_import_export_popup" style="display:block">
									<div class="k2t_waiting_spin" style="color: rgb(255, 255, 255);font-size: 171%;text-align: center;border-radius: 12px;width: 100px;height: 100px;position: absolute;top: 100px;left: 250px;display: none;z-index: 999999999;background: rgba(0, 0, 0, 0.498039);">
										<i class="awesome-spinner" style="color: #FCFCFC;position: absolute;with: 50%;left: 26%;top: 22%;font-size: 50px;"></i>
									</div>
									<style>
										.awesome-spinner{
												color: #056b16;margin-right:5px;
												-moz-animation: spinoff 2.5s infinite linear;
												-webkit-animation: spinoff 2.5s infinite linear;
										}
									</style>
									<div class="advance_backup_option_popup" id="advance_backup_option_popup_for_advance_backup_section_2" advance_backup-options-popup-name="advance_backup_section_2">
										
										<div class="notice_popup">
											<p>Choise one type : </p>
											<select class="notice_popup_choise">
												<option value="restore">Restore</option>
												<option value="save_to_back_up_list">Save to Backup list</option>
												<option value="restore_and_save_to_backup_list" style="display:none">Restore and Save to Backup list</option>
											</select>
											<button style="margin:0;margin-left:0px; margin-top:10px;" class="button notice_popup_choise_cancel" type="button" onclick="">Cancel</button>
											<button style="margin:0;margin-left:0px; margin-top:10px;" class="button-primary notice_popup_choise_accept" type="button" onclick="">Accept</button>
										</div>

										<div class="advance_backup_options_popup_content">
											<!-- 
											POPUP CLOSE 
											-->
											<div class="k2t_advance_backup_option_popup_control_close"><i class="awesome-close"></i></div>
											
											<!-- 
											POPUP FOR LIST 
											-->
											<div class="k2t_advance_backup_options_popup_content_list" style="display:block">
												<!-- 
												POPUP LOADING
												-->
												<div class="head_options_popup_loading"></div>
												<h3 class="advance_backup_options_popup_content_heading">Choose A Backup</h3>
												<ul class="k2t_advance_backup_options_feature advance_backup_options_list_feature">
												</ul>
											</div>
											<div class="advance_backup_option_popup_control" style="">
												<div class="abop_control" style="float:left;">
													<button style="margin:0;margin-left:10px; margin-top:5px;" class="button submit-button advance_backup_option_popup_control_upload_file" type="button" onclick="">Upload a backup file</button>
													<input style="" size=20 class="abop_control_file_upload" type="file" onclick="">
													
												</div>
												<div class="abop_control" style="float:right;">
													<button style="margin:0;margin-top:5px; margin-right:10px;" class="button submit-button advance_backup_option_popup_control_cancel" type="button" onclick="">cancel</button>
													<button style="margin-top:10px; margin-right:10px;" type="button" class="button-primary advance_backup_option_popup_control_backup">Import Now</button>
												</div>
											</div>
										</div>
									</div>
					</div>';
					break;

					// Uploader 3.5
				/* Backup And Restore Data */
				case 'k2t_advance_backup':
					
				    /* format setting outer wrapper */
					$link_content_backup = K2T_FRAMEWORK_URL . "assets/images/lincoln_data";
					$data_demo = json_decode( '{"vers_cats":{"lincoln":"Lincoln"},"versions":{"lincoln_1":{"home_id":5,"title":"Lincoln Lite Database","cat":"lincoln"},"lincoln_2":{"home_id":5,"title":"Lincoln Full Database","cat":"lincoln"}}}' );
					$vers_cats = !empty( $data_demo->vers_cats ) ? $data_demo->vers_cats : '';
					$versions = !empty( $data_demo->versions ) ? $data_demo->versions : '';
					//print_r($vers_cats);
					$output .= '
					<div class="format-setting type-backup">';
					$demo_data_installed = get_option('k2t_demo_data_installed');
					$button_label = __('Install base demo content', 'k2t');
					if($demo_data_installed != 'yes') { 
						$output .= '<a href="javascript:void(0)" class="button" id="k2t_install_demo_pages" >'. $button_label .'</a>';
						$output .= '								<div class="advance_import_export_popup" style="display:block">
									
									<div class="advance_backup_data_popup" id="advance_backup_data_popup_for_advance_backup_section_2" advance_backup-options-popup-name="advance_backup_section_2">
										
										<div class="notice_popup">
											<p>Choise one type : </p>
											<select class="notice_popup_choise">
												<option value="save_to_back_up_list">Save to Backup list</option>
												<option value="restore">Restore</option>
												<option value="restore_and_save_to_backup_list">Restore and Save to Backup list</option>
											</select>
											<button style="margin:0;margin-left:0px; margin-top:10px;" class="button notice_popup_choise_cancel" type="button" onclick="">Cancel</button>
											<button style="margin:0;margin-left:0px; margin-top:10px;" class="button-primary notice_popup_choise_accept" type="button" onclick="">Accept</button>
										</div>

										<div class="advance_backup_data_popup_content">
											<!-- 
											POPUP CLOSE 
											-->
											<div class="k2t_advance_backup_data_popup_control_close"><i class="fa fa-close"></i></div>
											
											<!-- 
											POPUP FOR LIST 
											-->
											<div class="k2t_advance_backup_data_popup_content_list" style="display:block">
												<!-- 
												POPUP LOADING
												-->
												<div class="head_data_popup_loading"></div>
												<h3 class="advance_backup_data_popup_content_heading">Install Sample Data</h3>
												<div class="advance_backup_data_popup_step_1" style="display:block">
													<p>This installation will make your website look the same as <a href="http://demo.lunartheme.com/grid">Lincoln WordPress Theme for Business and Portfolio</a></p>
													<div class="advance_backup_data_wrong">
														<span class="advance_backup_data_hilight_red">Important Information</span>
														<ul>
															<li><i class="dashicons dashicons-arrow-right" style="color: #056b16;margin-right:5px;"></i>The installation process will delete all data on this website.</li>
															<li><i class="dashicons dashicons-arrow-right" style="color: #056b16;margin-right:5px;"></i>It\'s not recommended to install sample data on production website.</li>
															<li><i class="dashicons dashicons-arrow-right" style="color: #056b16;margin-right:5px;"></i>All required plugins of this theme will be automatically installed and activated.</li>
															<li><i class="dashicons dashicons-arrow-right" style="color: #056b16;margin-right:5px;"></i>During the installation process, please do not close window.</li>
														<ul>

													</div>
													<div style="margin-bottom:10px;display:none;">
														<input style="width:inherit;margin-bottom:0px !important" class="drop_all_old_data" type="checkbox" onclick="" value="0" id="drop_all_old_data" checked><label for = "drop_all_old_data">Enable Drop All Old Data</label>
													</div>
													<div style="margin-bottom:30px;">
														<input style="width:15px;height:15px;margin-bottom:0px !important" class="agree" type="checkbox" onclick="" value="0" id="agree_backup_args"><label for = "agree_backup_args">I agree with all alert information and backup data</label>
													</div>
												</div>
												<div class="advance_backup_data_popup_step_2" style="display:none">
													<p>Installing!!! Please Don\'t close web browser before install finish.</p>
													<div class="advance_backup_data_wrong">
														<span class="advance_backup_data_hilight_green">Installing Process : </span>
														<ul>
															<li id="process_install_active_plugin"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Installed and Actived all require plugins...</li>
															<li id="process_backup_theme_options"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup theme options done...</li>
															<li id="process_backup_widget"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup widget done..</li>
															<li  id="process_upload_database"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Uploading Database....</li>
															<li  id="process_upload_asset"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Uploading Asset....</li>
															<li id="process_reconfig_setting"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Reconfig setting and clear cache...</li>
															<li  id="proces_done"  style="display:none"><i class="dashicons dashicons-yes" style="color: #056b16;margin-right:5px;"></i>Backup Finish.Go click <a href="'.esc_url( site_url() ).'" target"_blank">Here</a> to see your site...</li>
														<ul>

													</div>
												</div>
												
											</div>
											<style>
												.dashicons.dashicons-update{
														color: #056b16;margin-right:5px;
														-moz-animation: spinoff .5s infinite linear;
														-webkit-animation: spinoff .5s infinite linear;
												}
											</style>
											<div class="advance_backup_data_popup_control" style="">
												<div class="abop_control" style="float:left;">
													<div class="process_percent_container" style="display:none;">
														<div class="process_percent" style="width:0%;"><span>Installing... 0%</span></div>
													</div>
												</div>
												<div class="abop_control" style="float:right;">
													<button style="margin:0;margin-top:5px; margin-right:10px;" class="button submit-button advance_backup_data_popup_control_start" type="button" onclick="">Start importing now</button>
													<button style="margin:0;margin-top:5px; margin-right:10px; display:none" class="button submit-button advance_backup_data_popup_control_cancel" type="button" onclick="">Close</button>
												</div>
											</div>
										</div>
									</div>
								</div>';
					} 
					else {
						$output .= '
						<div class="clear"></div>
						<br />
						<p>' . _e('<strong>Note:</strong> You have already installed base demo content.', 'k2t') .'</p>';
					}
					$output .= '
					<div class="clear"></div>
					<br />
					<div class="format-setting-label"><h3 class="label">Set up one of our theme versions</h3></div>
					<div class="ver-install-result"></div>
					<div class="sort_data_ver">
					<ul class="versions-filters">
						<li>
							<a href="#" data-filter="*" class="button active">All</a>
						</li>';
						if ( count( $vers_cats ) > 0 ){

							foreach($vers_cats as $slug => $name):
								$output .= '
								<li>
									<a href="#" data-filter=".sort-'.$slug.'" class="button">'.$name.'</a>
								</li>';
							endforeach;
						}
					$output .= '</ul>';				
					$output .= '<div class="k2t-theme-versions">';
						if (  count( $versions ) > 0 ){
							foreach($versions as $key => $v): 
								$output .= ' <div class="theme-ver sort-'.$v->cat.'">';
									$output .= '<img src="'.esc_url( $link_content_backup.'/'.$v->cat.'/'.$key.'/'.$key.'.jpg' ) .'"> ';
									$output .= '<button class="button-primary install-ver" data-type_name="' . $v->cat . '"  data-ver="'.$key.'" data-home_id="'.$v->home_id.'">Install version</button>';									
									$output .= '<h4>'.$v->title.'</h4>';
								$output .= '</div>';
							endforeach; 
						}
					$output .= '</div></div>';

					$output .= '</div>';
					break;
					//export or import data between different installs	
				case 'get_theme_option_widget':

					/* Save Theme Options */
					global $smof_data,$wpdb;
					$data  = k2t_encode( serialize( $smof_data ));
					$output .= 'Theme Options : <textarea id="theme_options_backup" rows="8">'. $data .'</textarea>'."\n";
					/* Save Widget */	
					$sidebars_widgets = get_option('sidebars_widgets');
					$custom_sidebars_widgets = get_option('cs_sidebars');
					$data_widget_backup['sidebars_widgets'] =  $sidebars_widgets;
					$data_widget_backup['cs_sidebars'] =  $custom_sidebars_widgets;
					$widget_datas = $wpdb->get_results("SELECT * FROM wp_options WHERE option_name LIKE 'widget%'");
					$widget_data_backup = array();
					foreach($widget_datas as $widget_data){
						$data_widget_backup[$widget_data->option_name] =  get_option($widget_data->option_name);
					}
					$widget_backup = k2t_encode(  serialize ( $data_widget_backup ) );
					$output .= 'Theme Widgets : <textarea id="widget_backup" rows="8">'. $widget_backup .'</textarea>'."\n";
					break;
				case 'transfer':

					$instructions = $value['desc'];
					$output .= '<a href="#" id="of_import_button" class="button" title="Restore Options">Import Options</a>';
					$output .= '<a href="#" id="of_import_button_widgets" class="button" title="Restore Options">Import Widgets</a>';
					
					break;

					// google font field
				case 'select_google_font':
					$output .= '<div class="select_wrapper">';
					$output .= '<select class="select of-input google_font_select" name="'. esc_attr( $value['id'] ) .'" id="'. esc_attr( $value['id'] ) .'">';
					foreach ( $value['options'] as $select_key => $option ) {
						$output .= '<option value="'. esc_attr( $select_key ) .'" ' . selected( ( isset( $smof_data[$value['id']] ) )? $smof_data[$value['id']] : "", $option, false ) . ' />'.$option.'</option>';
					}
					$output .= '</select></div>';

					if ( isset( $value['preview']['text'] ) ) {
						$g_text = $value['preview']['text'];
					} else {
						$g_text = '0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz';
					}
					if ( isset( $value['preview']['size'] ) ) {
						$g_size = 'style="font-size: '. $value['preview']['size'] .';"';
					} else {
						$g_size = '';
					}
					$hide = " hide";
					if ( $smof_data[$value['id']] != "none" && $smof_data[$value['id']] != "" )
						$hide = "";

					$output .= '<p class="'.$value['id'].'_ggf_previewer google_font_preview'.$hide.'" '. $g_size .'>'. $g_text .'</p>';
					break;

					//JQuery UI Slider
				case 'sliderui':
					$s_val = $s_min = $s_max = $s_step = $s_edit = '';//no errors, please

					$s_val  = stripslashes( $smof_data[$value['id']] );

					if ( empty( $value['min'] ) ) { $s_min  = '0'; }else { $s_min = $value['min']; }
					if ( empty( $value['max'] ) ) { $s_max  = $s_min + 1; }else { $s_max = $value['max']; }
					if ( empty( $value['step'] ) ) { $s_step  = '1'; }else { $s_step = $value['step']; }

					if ( empty( $value['edit'] ) ) {
						$s_edit  = ' readonly="readonly"';
					}
					else {
						$s_edit  = '';
					}

					if ( $s_val == '' ) $s_val = $s_min;

					//values
					$s_data = 'data-id="'.$value['id'].'" data-val="'.$s_val.'" data-min="'.$s_min.'" data-max="'.$s_max.'" data-step="'.$s_step.'"';

					//html output
					$output .= '<input type="number" name="'. esc_attr( $value['id'] ) .'" id="'. esc_attr( $value['id'] ) .'" value="'. esc_attr( $s_val ) .'" class="mini" />';
					$output .= '<div id="'.$value['id'].'-slider" class="smof_sliderui" style="margin-left: 7px;" '. $s_data .'></div>';

					break;

					//select option
				case 'select':
					$mini = $logicstic = '';
					if ( empty( $value['mod'] ) ) $value['mod'] = '';
					if ( $value['mod'] == 'mini' ) { $mini = 'mini';}
					if ( ! empty( $value['logicstic'] ) && $value['logicstic'] === true ) { $logicstic = 'logicstic'; }
					$k2t_logictic = $has_hidden_option_array = $hidden_option_array = '';
					if ( !empty( $value['k2t_logictic'] ) ) { $hidden_option_array =  k2t_encode(json_encode($value['k2t_logictic']));  $has_hidden_option_array = "has_hidden_option_array"; }
					$output .= '<div class="select_wrapper ' . $mini . $logicstic . '">';
					$output .= '<select class="select of-input  '. ' ' . esc_attr( $has_hidden_option_array )  . '" data-hidden-option-array = "' . esc_attr( $hidden_option_array ) . '" name="'. esc_attr( $value['id'] ).'" id="'. esc_attr( $value['id'] ) .'">';

					foreach ( $value['options'] as $select_ID => $option ) {
						$theValue = $option;
						if ( !is_numeric( $select_ID ) )
							$theValue = $select_ID;
						$output .= '<option id="' . esc_attr( $select_ID ) . '" value="'.$theValue.'" ' . selected( $smof_data[$value['id']], $theValue, false ) . ' />'.$option.'</option>';
					}
					$output .= '</select></div>';
					break;

					//Switch option
				case 'switch':
				

					$data = $smof_data[ $value['id'] ];

					if ( empty( $smof_data[$value['id']] ) ) {
						$smof_data[$value['id']] = 0;
					}
					$fold = $logicstic = '';
					$k2t_logictic = $has_hidden_option_array = $hidden_option_array = '';
					if ( array_key_exists( "folds", $value ) ) $fold="s_fld ";

					$cb_enabled = $cb_disabled = '';//no errors, please

					//Get selected
					if ( $data == 0 ) {
						$cb_enabled = '';
						$cb_disabled = ' selected';
					} else {
						$cb_enabled = ' selected';
						$cb_disabled = '';
					}

					//Label ON
					if ( empty( $value['on'] ) ) {
						$on = "On";
					}else {
						$on = $value['on'];
					}

					//Label OFF
					if ( empty( $value['off'] ) ) {
						$off = "Off";
					}else {
						$off = $value['off'];
					}
					if ( !empty( $value['logicstic'] ) && $value['logicstic'] === true ) { $logicstic = 'logicstic'; }
					if ( !empty( $value['k2t_logictic'] ) ) { $hidden_option_array =  k2t_encode(json_encode($value['k2t_logictic']));  $has_hidden_option_array = "has_hidden_option_array"; 

						$output .= '<p class="switch-options ' . $logicstic . ' ' . $has_hidden_option_array  . '" data-hidden-option-array = "' . $hidden_option_array . '">';
					
					}else{

						$output .= '<p class="switch-options ' . $logicstic . ' ' . $has_hidden_option_array  . '">';

					}
					$output .= '<label class="'.$fold.'cb-enable'. $cb_enabled .'" data-id="'.$value['id'].'"><span>'. $on .'</span></label>';
					$output .= '<label class="'.$fold.'cb-disable'. $cb_disabled .'" data-id="'.$value['id'].'"><span>'. $off .'</span></label>';

					if ( !empty( $value['k2t_logictic'] ) ) {
						$output .= '<input type="checkbox"  data-hidden-option-array = "' . $hidden_option_array . '" id="'.$value['id'].'" class="'.$fold.'checkbox of-input main_checkbox" name="'.$value['id'].'"  value="'. $data .'" '. checked( $data, 1, false ) .' />';
					}else{
						$output .= '<input type="checkbox"  id="'. esc_attr( $value['id'] ) .'" class="'.$fold.'checkbox of-input main_checkbox" name="'. esc_attr( $value['id'] ) .'"  value="'. $data .'" '. checked( $data, 1, false ) .' />';
					
					}
					$output .= '</p>';

					break;
				case "upload":
				case "media":

					if ( empty( $value['mod'] ) ) $value['mod'] = '';

					$u_val = '';
					if ( $smof_data[$value['id']] ) {
						$u_val = stripslashes( $smof_data[$value['id']] );
					}

					$output .= Options_Machine::optionsframework_media_uploader_function( $value['id'], $u_val, $value['mod'] );

					break;
				case "k2t_header_option":
					$data = ! empty( $value['id'] ) ? json_decode ( $smof_data[ $value['id'] ], true ) : array( 'setting' => array( 'custom_css' => '' ) );

					wp_enqueue_script( 'jquery-ui-resizable' );
					$output .= '<input type="hidden" class="'.$fold.'checkbox of-input k2t_header_option_value" name="'. esc_attr( $value['id'] ) .'" id="'. esc_attr( $value['id'] ) .'" value=\''.stripslashes( esc_attr( $smof_data[$value['id']] ) ).'\'/>';
					$output .= '
					<script type="text/javascript">
					jQuery.noConflict();
					jQuery(function() {
					';
					if($smof_data[$value['id']] == ''){
					$output .= '				

						//  Deafult Array Of Content	

						var k2t_header_options_array_'.$value['id'].' = 
						{
							"name": "'.$value['id'].'",
							"setting":{ 
								"fullwidth"			: "",
								"header_height"		: "",
								"bg_image"			: "",
								"bg_color"			: "",
								"opacity"			: "",
								"fixed_abs" 		: "fixed",
								"align_column_1" 	: "left",
								"align_column_2" 	: "left",
								"align_column_3" 	: "left",
								"boxshadow"			: "",
								"custom_css"		: ""
							},
							"columns_num"			: 1,
							"htmlData"				: "",
							"columns"				: [{ 
								"id" 				: 1,
								"percent"			: "90",
								"value" 			: [],
							}],
						};
						';
					}else{
						// Add Load Content Data
					$output .= 'var k2t_header_options_array_'.$value['id'].' = jQuery.parseJSON(\''.$smof_data[$value['id']].'\')'; 
					}
					$output .= '
					
				
					/* 

					Open All Params 
					
					*/

					function theme_options_display_all_'.$value['id'].'(){
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_popup_content_list" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].'  .k2t_header_options_feature_wp_editor_params" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_search_box_params" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_social_params" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_custom_menu_params" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_cart_params" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_widget_params" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_logo_params" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_canvas_sidebar_params" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_setting_params" ).css( "display","block" );
					}
					


					/* 

					Hidden All Params 

					*/


					function theme_options_hidden_all'.$value['id'].'(){
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_popup_content_list" ).css( "display","none" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_wp_editor_params" ).css( "display","none" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_search_box_params" ).css( "display","none" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_social_params" ).css( "display","none" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_custom_menu_params" ).css( "display","none" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_cart_params" ).css( "display","none" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_widget_params" ).css( "display","none" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_logo_params" ).css( "display","none" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_canvas_sidebar_params" ).css( "display","none" );
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_setting_params" ).css( "display","none" );
					}


					/* 


					Clear ALl Attr Of Header Popup 


					*/


					function k2t_clear_attr_header_popup'.$value['id'].'(){
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).removeAttr( "current-columns" );
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).removeAttr( "current-item-id" );
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).removeAttr( "current-setting" );
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).removeAttr( "current-type" );
					}

					

					/*

						Get value For Params

					*/

					function get_value_for_params'.$value['id'].'(ui)
					{
						if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "main_menu" ){
							
							/*

							MAIN MENU

							*/
							var k2t_heading_option_main_menu_default = jQuery.parseJSON(ui.attr( "item-value" ));
							jQuery( "#custom_class_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_main_menu_default["custom_class"])) ;
							jQuery( "#custom_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_main_menu_default["custom_id"]));

							
						}else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "search_box" ){
							
							/*

							Search Box

							*/
							var k2t_heading_option_search_box_default =  jQuery.parseJSON(ui.attr( "item-value" ));
							//console.log(jQuery.base64.btoa(k2t_heading_option_search_box_default["custom_id"]));
							jQuery( "#custom_search_box_class_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_search_box_default["custom_class"]));
							jQuery( "#custom_search_box_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_search_box_default["custom_id"]));
						
						}else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "cart" ) {
							
							/*

							CARD

							*/

							var k2t_heading_option_card_default = jQuery.parseJSON(ui.attr( "item-value" ));
							jQuery( "#custom_card_class_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_card_default["custom_class"]));
							jQuery( "#custom_card_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_card_default["custom_id"]));
							
						}else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "custom_menu" ) {
						
							/*

							Custom Menu

							*/

							var k2t_heading_option_custom_menu_default = jQuery.parseJSON(ui.attr( "item-value" ));
							jQuery( "#custom_menu_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_custom_menu_default["menu_id"]));
							jQuery( "#custom_custom_menu_class_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_custom_menu_default["custom_class"]));
							jQuery( "#custom_custom_menu_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_custom_menu_default["custom_id"]));
							

						}else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "widget" ) {
						
							/*

							Custom Widget

							*/

							var k2t_heading_option_widget_default = jQuery.parseJSON(ui.attr( "item-value" ));
							jQuery( "#widget_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_widget_default["widget_id"]));
							jQuery( "#custom_widget_class_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_widget_default["custom_class"]));
							jQuery( "#custom_widget_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_widget_default["custom_id"]));
							

						}else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "logo" ) {
						
							/*

							Custom Logo

							*/

							var k2t_heading_option_logo_default = jQuery.parseJSON(ui.attr( "item-value" ));
							jQuery( "#custom_logo_class_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_logo_default["custom_class"]));
							jQuery( "#custom_logo_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_logo_default["custom_id"]));
							
						}
						else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "canvas_sidebar" ){
							
							/*
							
							canvas sidebar
							
							*/

							var k2t_heading_option_canvas_sidebar_default = jQuery.parseJSON(ui.attr( "item-value" ));

							jQuery( "#custom_canvas_sidebar_class_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_canvas_sidebar_default["custom_class"]));
							
							jQuery( "#custom_canvas_sidebar_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_canvas_sidebar_default["custom_id"]));
						
						}
						else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "wp_editor" ) {
							
							/*
							
							Text Editor
							
							*/
							
							var k2t_heading_option_wp_editor_default = jQuery.parseJSON(ui.attr( "item-value" ));

							jQuery( "#k2t_editor_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_wp_editor_default["value"]));

							jQuery( "#custom_wp_editor_class_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_wp_editor_default["custom_class"]));

							jQuery( "#custom_wp_editor_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_wp_editor_default["custom_id"]));
						
						}
						else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "social" ) {
							
							/*
							
							Social
							
							*/
							
							jQuery( ".social_list_'.$value['id'].' .header_options_social_list_popup .checkbox" ).each(function(){
								jQuery(this).prop( "checked", false );
							})

							var k2t_heading_option_social_default = jQuery.parseJSON(ui.attr( "item-value" ));
							jQuery( "#custom_social_class_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_social_default["custom_class"]));
							jQuery( "#custom_social_id_'.$value['id'].'" ).val(jQuery.base64.atob(k2t_heading_option_social_default["custom_id"]));

							jQuery.each(k2t_heading_option_social_default["value"],function(index, value){
								jQuery( ".social_list_'.$value['id'].' #'.$value['id'].'_" + value).prop( "checked", true );
							});
									
						}
					}
					
					/*

					
					Resizeable Action Of Columns

					*/
					
					var one_cols_size = 44.6;
					if(k2t_header_options_array_'.$value['id'].'["columns_num"] == "1"){ one_cols_size = 44.6;}
					else if(k2t_header_options_array_'.$value['id'].'["columns_num"] == "2"){ one_cols_size = 43;}
					else if(k2t_header_options_array_'.$value['id'].'["columns_num"] == "3"){ one_cols_size = 41;}
					
					
					var startW = 0;
					var startH = 0;
					var max_width = 0;
					jQuery( "#k2t_header_options_for_'.$value['id'].'  .k2t_header_options_columns_content" ).resizable({disabled: false});
					jQuery( "#k2t_header_options_for_'.$value['id'].'  .k2t_header_options_columns_content" ).resizable(
						{
							grid: one_cols_size,
							minWidth: 40,
							maxWidth: 550,
							create: function( event, ui ) {
								
								max_width = jQuery(this).width() + jQuery(this).next( ".k2t_header_options_columns_content" ).width() - one_cols_size;
								jQuery( this ).resizable( "option", "maxWidth", max_width );
							},
							start : function(event,ui){
								
								startW = jQuery(this).width();
								max_width = jQuery(this).width() + jQuery(this).next( ".k2t_header_options_columns_content" ).width() - one_cols_size;
								jQuery( this ).resizable( "option", "maxWidth", max_width );
							},
							resize: function (event, ui)
							{
								
								new_width = jQuery(this).width();
								$odd = startW - new_width;
								next_width = jQuery(this).next( ".k2t_header_options_columns_content" ).width()+$odd;
								jQuery(this).next( ".k2t_header_options_columns_content" ).css( "width",next_width);
								startW = jQuery(this).width();
								jQuery(this).attr( "columns_percent",Math.round(jQuery(this).width()/one_cols_size));
								jQuery(this).next( ".k2t_header_options_columns_content" ).attr( "columns_percent",Math.round(jQuery(this).next( ".k2t_header_options_columns_content" ).width()/one_cols_size));
								k2t_reset_main_array_'.$value['id'].'();
							},
						}
					);
					

					/*

					
					Element Sortable


					*/

					jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_elements" ).sortable({
						items: ".k2t_header_options_item",
						connectWith: ".k2t_header_options_elements",
						receive: function(event, ui) {
							k2t_reset_main_array_'.$value['id'].'();
						}
					});

					

					k2t_delete_action_'.$value['id'].'();
					function k2t_delete_action_'.$value['id'].'()
					{

						/*

					
						Delete Item


						*/

						jQuery( "#k2t_header_options_for_'.$value['id'].'   .k2t_header_options_item .dashicons_item" ).on( "click",function(e){
							if(confirm( "Are you sure you want to delete this?" )){
									jQuery(this).parent().remove();
									k2t_reset_main_array_'.$value['id'].'();
									e.preventDefault();
									e.stoppropagation();
							}	
						});		
						

						/*

						
						Delete Columns


						*/

						jQuery( "#k2t_header_options_for_'.$value['id'].'   .k2t_header_options_columns > .dashicons_columns" ).on( "click",function(e){

							if(confirm( "Are you sure you want to delete this?" )){
								if (jQuery(this).parent().hasClass( "k2t_header_options_columns" )) {
									jQuery( "#k2t_header_options_for_'.$value['id'].' .parentcolid_" + jQuery(this).parent().attr( "col-id" ) + "_'.$value['id'].'" ).remove();
									$id = parseInt(jQuery(this).attr( "col-id" )) - 1;
									k2t_header_options_array_'.$value['id'].'["columns_num"] = k2t_header_options_array_'.$value['id'].'["columns_num"] - 1;
									k2t_header_options_array_'.$value['id'].'["columns"].splice(jQuery.inArray(k2t_header_options_array_'.$value['id'].'[$id], k2t_header_options_array_'.$value['id'].'),1);
									k2t_reset_main_array_'.$value['id'].'();
									
									/*
									
									REPLACE ALL ELEMENT COL-ID AND CLASS OF COLUMNS
									
									*/
									
									var i = 1;
									jQuery( "#k2t_header_options_for_'.$value['id'].'" ).find( ".k2t_header_options_columns" ).each(function(){
										
										jQuery(this).attr( "col-id",i);
										i++;
									});

									i=1;
									var k; k = 0;
									jQuery( "#k2t_header_options_for_'.$value['id'].'" ).find( ".k2t_header_options_columns_content" ).each(function(){

										jQuery(this).attr( "parentcolid",i);
										jQuery(this).removeClassPrefix( "parentcolid_" );
										jQuery(this).addClass( "parentcolid_" + i + "_'.$value['id'].'" );
										if(k2t_header_options_array_'.$value['id'].'["columns_num"] == "1" ){
											jQuery(this).attr( "columns_percent","12" );
											jQuery(this).css( "width","535" );
											k2t_header_options_array_'.$value['id'].'["columns"][k]["percent"] = "12";
											k2t_reset_main_array_'.$value['id'].'();
										}else if(k2t_header_options_array_'.$value['id'].'["columns_num"] == "2" ){
											jQuery(this).attr( "columns_percent","6" );
											jQuery(this).css( "width","258" );
											k2t_header_options_array_'.$value['id'].'["columns"][k]["percent"] = "6";
											k2t_reset_main_array_'.$value['id'].'();
										}
										k++;
										i++;

									});
									
								};
								e.preventDefault();
								e.stoppropagation();	
							}

						});
					}
					
					
					

					/*

					
					Add element


					*/

					jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_add_elelement" ).bind( "click",function(){
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).css( "display","block" );
						theme_options_hidden_all'.$value['id'].'();
						jQuery( ".k2t_header_options_popup_content_list" ).css( "display","block" );
						k2t_clear_attr_header_popup'.$value['id'].'();
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-columns",jQuery(this).parent().parent().attr( "col-id" ));
					});
					


					

					';				
					$output .='
					
						
						/*

						Reset Main Element Data

						*/


					function k2t_reset_main_array_'.$value['id'].'(){
					
						/*
						
						CLEAR ALL DATA:
					
						*/
						var $stt = 0;
						var cols_num = jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).length;
						
						var $stt = 0;
						var $stt_arr =0;
						jQuery.each(k2t_header_options_array_'.$value['id'].'["columns"],function(){
							k2t_header_options_array_'.$value['id'].'["columns"][parseInt($stt_arr)]["value"] = [];
							$stt_arr++;
						});
						
						jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).each(function(){
							/* Remove All Old Element */
							k2t_header_options_array_'.$value['id'].'["columns"][parseInt($stt)]["percent"] = jQuery(this).attr( "columns_percent" );
							jQuery(this).find( ".k2t_header_options_elements .k2t_header_options_item" ).each(function(){
								$value = jQuery(this).attr( "item-value" );
								$id = jQuery(this).attr( "item-id" );
								$type = jQuery(this).attr( "item-type" );
								k2t_header_options_array_'.$value['id'].'["columns"][parseInt($stt)]["value"].push({id:$id,type:$type,value:jQuery.parseJSON($value)});
							});
							$stt++;
						});
						k2t_header_options_array_'.$value['id'].'["htmlData"] = "";
						jQuery( "#'.$value['id'].'" ).attr( "value",JSON.stringify(k2t_header_options_array_'.$value['id'].'));
						jQuery( "#'.$value['id'].'" ).val(JSON.stringify(k2t_header_options_array_'.$value['id'].'));
					
						/* Reset Columns Nums */
						jQuery( "#k2t_header_options_for_'.$value['id'].'").attr("columns_num",k2t_header_options_array_'.$value['id'].'["columns_num"]);
					}
					var k2t_heading_option_main_menu_default;
					

					/*
						
						FUNCTION FOR OPTION SETTING - LOAD FOR ARRAY
					
					*/

					jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_icon" ).on( "click",function(){
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).css( "display","block" );
						// Hide All
						theme_options_hidden_all'.$value['id'].'();
						jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_feature_setting_params" ).css( "display","block" );
						k2t_clear_attr_header_popup'.$value['id'].'();

						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-setting","true" );
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).removeAttr( "current-type" );

						if(k2t_header_options_array_'.$value['id'].'["setting"]["opacity"] != ""){
							jQuery("#opacity_setting_slide'.$value['id'].'-slider").slider("value",parseInt(jQuery.base64.atob(k2t_header_options_array_'.$value['id'].'["setting"]["opacity"])));
						}else{
							jQuery("#opacity_setting_slide'.$value['id'].'-slider").slider("value",100);
						}
					});
					/* 

					Edit Element Value 

					*/


					jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_item" ).on( "click",function(){
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).css( "display","block" );
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-type",jQuery(this).attr( "item-type" ));
						
						theme_options_hidden_all'.$value['id'].'();
						var param_type = jQuery(this).attr( "for" );
						var id = jQuery(this).attr( "id" );
						
						jQuery( "#header_option_popup_for_'.$value['id'].' ." + param_type).css( "display","block" );
						
						k2t_clear_attr_header_popup'.$value['id'].'();
						
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-type",jQuery(this).attr( "item-type" ));
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-item-id",jQuery(this).attr( "item-id" ));
						get_value_for_params'.$value['id'].'(jQuery(this))		 // Get Value For Params

					});						
					/* 

					Add Columns. 
					Max= 3 

					*/
					jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_add_columns" ).on( "click",function(){
						

						var width=100;
						
						if(jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).length == 0){
							
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).css( "width","535.2px" );
							width = 535.2;
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns" ).removeAttr( "data-cols" );
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_wrapper_row" ).append( "<div class=\'parentcolid_1_'.$value['id'].' k2t_header_options_columns_content  \'  parentcolid=\"1\" style=\'width:"+width+"px;float:left;\'><div class=\'k2t_header_options_row k2t_header_options_columns \' col-id=\'1\'><div class=\'dashicons_columns dashicons dashicons-trash\'></div><div class=\'k2t_header_options_top_gray\'></div><div class=\'k2t_header_options_elements\'></div><div class=\'k2t_header_options_add_element_columns\'><div class=\'k2t_header_options_add_elelement\'><i class=\'awesome-plus\'></i></div></div></div></div>" );
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).attr( "columns_percent","12" );
							
						}else if(jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).length == 1){
							width = 258;
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).css( "width","258px" );
							
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns" ).removeAttr( "data-cols" );
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_wrapper_row" ).append( "<div class=\'parentcolid_2_'.$value['id'].' k2t_header_options_columns_content \'  parentcolid=\"2\" style=\'width:"+width+"px;float:left;\'><div class=\'k2t_header_options_row k2t_header_options_columns \' col-id=\'2\'><div class=\'dashicons_columns dashicons dashicons-trash\'></div><div class=\'k2t_header_options_top_gray\'></div><div class=\'k2t_header_options_elements\'></div><div class=\'k2t_header_options_add_element_columns\'><div class=\'k2t_header_options_add_elelement\'><i class=\'awesome-plus\'></i></div></div></div></div>" );
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).attr( "columns_percent","6" );
							
						}else if(jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).length == 2){
							width = 166;
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).css( "width","164px" );
							
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns" ).removeAttr( "data-cols" );
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_wrapper_row" ).append( "<div class=\'parentcolid_3_'.$value['id'].' k2t_header_options_columns_content  \'  parentcolid=\"3\" style=\'width:"+width+"px;float:left;\'><div class=\'k2t_header_options_row k2t_header_options_columns \' col-id=\'3\'><div class=\'dashicons_columns dashicons dashicons-trash\'></div><div class=\'k2t_header_options_top_gray\'></div><div class=\'k2t_header_options_elements\'></div><div class=\'k2t_header_options_add_element_columns\'><div class=\'k2t_header_options_add_elelement\'><i class=\'awesome-plus\'></i></div></div></div></div>" );
							jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_columns_content" ).attr( "columns_percent","4" );
						}
						
						
						/* 

						Row Click 

						*/

						jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_add_elelement" ).bind( "click",function(){
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).css( "display","block" );
							// Hide All
							theme_options_hidden_all'.$value['id'].'();
							jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_options_popup_content_list" ).css( "display","block" );
							k2t_clear_attr_header_popup'.$value['id'].'();
							//Add current element
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr(\'current-columns\',jQuery(this).parent().parent().attr(\'col-id\'));
						});
						
						/* 

						Edit Element Value 

						*/

						jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_item" ).on( "click",function(){
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).css( "display","block" );
							theme_options_hidden_all'.$value['id'].'();
							var param_type = jQuery(this).attr( "for" );
							var id = jQuery(this).attr( "id" );
							jQuery( "." + param_type).css( "display","block" );
						});
						
						
						
						
						if(k2t_header_options_array_'.$value['id'].'["columns_num"] == 3){ 

							alert( "Max of columns is 3" );
						}
						else{ 
															
						var columnsnum = k2t_header_options_array_'.$value['id'].'["columns_num"] + 1;
						
						k2t_header_options_array_'.$value['id'].'["columns_num"] = columnsnum;
						
						k2t_header_options_array_'.$value['id'].'["columns"].push({ "id" : k2t_header_options_array_'.$value['id'].'["columns_num"],"value" :[]});

						};
						
						/* Bind Action Delete */
						k2t_delete_action_'.$value['id'].'();

						jQuery( "#k2t_header_options_for_'.$value['id'].'  .k2t_header_options_elements" ).sortable({
							 items: ".k2t_header_options_item",
							 connectWith: ".k2t_header_options_elements",
							 stop     : function(event,ui){ 
								
							},
							receive: function(event, ui) {
								k2t_reset_main_array_'.$value['id'].'();
							  }
						});

						var one_cols_size = 44.6;
						if(k2t_header_options_array_'.$value['id'].'["columns_num"] == "1"){ one_cols_size = 44.6;}
						else if(k2t_header_options_array_'.$value['id'].'["columns_num"] == "2"){ one_cols_size = 43;}
						else if(k2t_header_options_array_'.$value['id'].'["columns_num"] == "3"){ one_cols_size = 41;}
						
						var startW = 0;
						var startH = 0;
						var max_width = 0;
						jQuery( "#k2t_header_options_for_'.$value['id'].'  .k2t_header_options_columns_content" ).resizable({disabled: false});
						jQuery( "#k2t_header_options_for_'.$value['id'].'  .k2t_header_options_columns_content" ).resizable(
							{
								grid: one_cols_size,
								minWidth: 20,
								maxWidth: 550,
								create: function( event, ui ) {
									max_width = jQuery(this).width() + jQuery(this).next( ".k2t_header_options_columns_content" ).width() - one_cols_size + 20;
									jQuery( this ).resizable( "option", "maxWidth", max_width );
								},
								start : function(event,ui){
									startW = jQuery(this).width();
									max_width = jQuery(this).width() + jQuery(this).next( ".k2t_header_options_columns_content" ).width() - one_cols_size + 20;
									jQuery( this ).resizable( "option", "maxWidth", max_width );
								},
								resize: function (event, ui)
							    {
									new_width = jQuery(this).width();
									$odd = startW - new_width;
										next_width = jQuery(this).next( ".k2t_header_options_columns_content" ).width()+$odd;
										jQuery(this).next( ".k2t_header_options_columns_content" ).css( "width",next_width);
									
									startW = jQuery(this).width();
									
									jQuery(this).attr( "columns_percent",Math.round(jQuery(this).width()/one_cols_size));
									jQuery(this).next( ".k2t_header_options_columns_content" ).attr( "columns_percent",Math.round(jQuery(this).next( ".k2t_header_options_columns_content" ).width()/one_cols_size));
									
									
									k2t_reset_main_array_'.$value['id'].'();
							    },
								
							}
						);
						jQuery( "#k2t_header_options_for_'.$value['id'].'  .k2t_header_options_columns_content" ).last().resizable( {disabled: true} );

						jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_item" ).on( "click",function(){
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).css( "display","block" );
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-type",jQuery(this).attr( "item-type" ));
							theme_options_hidden_all'.$value['id'].'();
							var param_type = jQuery(this).attr( "for" );
							var id = jQuery(this).attr( "id" );
							jQuery( "#header_option_popup_for_'.$value['id'].' ." + param_type).css( "display","block" );
							k2t_clear_attr_header_popup'.$value['id'].'();
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-type",jQuery(this).attr( "item-type" ));
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-item-id",jQuery(this).attr( "item-id" ));
							
							get_value_for_params'.$value['id'].'(jQuery(this));		 // Get Value For Params
						});


						k2t_reset_main_array_'.$value['id'].'();
					});

	
					jQuery( "#header_option_popup_for_'.$value['id'].' ul.header_options_list_feature li" ).on( "click",function(){
						
						/* 

						Find Columns 

						*/

						var current_columns = jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-columns" );
						var i = jQuery( "#k2t_header_options_for_'.$value['id'].' [col-id=" + current_columns + "] .k2t_header_options_elements .k2t_header_options_item" ).length;				
						theme_options_hidden_all'.$value['id'].'();
						var rel = jQuery(this).attr( "rel" );
						jQuery( "."+rel).css( "display","block" );
						/* Edit Element Value */
						var rel = jQuery(this).attr( "rel" );
						jQuery( "."+rel).css( "display","block" );
						/* Find Columns */
						$type = jQuery(this).attr( "param-type" );
						$k = parseInt(current_columns) - 1;
						$i = k2t_header_options_array_'.$value['id'].'["columns"][parseInt($k)]["value"].length;
						if($i == -1 ){ $i = 0; }
						$k2t_times = parseInt(jQuery.now());
						jQuery( "#k2t_header_options_for_'.$value['id'].' [col-id=" + current_columns + "] .k2t_header_options_elements" ).append( "<div class=\"k2t_header_options_item\" item-value=\"\" item-type=\"" + $type + "\" item-id=\"" +  $k2t_times + "\" for=\"" + jQuery(this).attr( "rel" ) + "\" item-value=\"\"><div class=\"dashicons_item dashicons dashicons-trash\"></div>" + jQuery(this).html() + "</div>" );
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-item-id",$k2t_times);
						jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-type",$type);
						
						/*

						SortAble For Item

						*/	

						jQuery( "#k2t_header_options_for_'.$value['id'].'  .k2t_header_options_elements" ).sortable({
							 items: ".k2t_header_options_item",
							 connectWith: ".k2t_header_options_elements",
						});

						/* 

						Bind Action Edit Element Value 

						*/

						jQuery( "#k2t_header_options_for_'.$value['id'].' .k2t_header_options_item" ).on( "click",function(){
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).css( "display","block" );
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-type",jQuery(this).attr( "item-type" ));
							theme_options_hidden_all'.$value['id'].'();
							var param_type = jQuery(this).attr( "for" );
							var id = jQuery(this).attr( "id" );
							jQuery( "#header_option_popup_for_'.$value['id'].' ." + param_type).css( "display","block" );
							k2t_clear_attr_header_popup'.$value['id'].'();
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-type",jQuery(this).attr( "item-type" ));
							jQuery( "#header_option_popup_for_'.$value['id'].'.header_option_popup" ).attr( "current-item-id",jQuery(this).attr( "item-id" ));
							
							get_value_for_params'.$value['id'].'(jQuery(this));		 // Get Value For Params
						});
						
						/* Bind Action Delete */
						k2t_delete_action_'.$value['id'].'();

					});
					
					jQuery( "#header_option_popup_for_'.$value['id'].' .k2t_header_option_popup_control_save" ).on( "click",function(){
						
						/*
						
						CASE SETTING
						
						*/
						
						if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-setting" ) == "true" )
						{
						
							/*
						
							SETTING
						
							*/
						
							k2t_header_options_array_'.$value['id'].'["setting"]["fullwidth"] 		= jQuery.base64.btoa(jQuery( "#fullwidth_setting_'.$value['id'].'" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["header_height"] 	= jQuery.base64.btoa(jQuery( "#header_height_setting_'.$value['id'].'" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["bg_color"] 		= jQuery.base64.btoa(jQuery( "#bg_color_setting_'.$value['id'].'" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["bg_image"] 		= jQuery.base64.btoa(jQuery( "#bg_image_setting_'.$value['id'].'_upload" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["opacity"] 		= jQuery.base64.btoa(jQuery( "#opacity_setting_'.$value['id'].'" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["fixed_abs"] 		= jQuery.base64.btoa(jQuery( "#header_position_'.$value['id'].'" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["align_column_1"] 	= jQuery.base64.btoa(jQuery( "#align_column_1_setting_'.$value['id'].'" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["align_column_2"] 	= jQuery.base64.btoa(jQuery( "#align_column_2_setting_'.$value['id'].'" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["align_column_3"] 	= jQuery.base64.btoa(jQuery( "#align_column_3_setting_'.$value['id'].'" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["boxshadow"] 		= jQuery.base64.btoa(jQuery( "#boxshadow_setting_'.$value['id'].'" ).val());
							k2t_header_options_array_'.$value['id'].'["setting"]["custom_css"] 		= jQuery.base64.btoa(jQuery( "#custom_css_setting_'.$value['id'].'" ).val());
							jQuery( "#header_option_popup_for_'.$value['id'].'" ).css( "display","none" );
						
						}
						
						
						if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "main_menu" ){
							
							/*
						
							MAIN MENU
						
							*/
						
							var k2t_heading_option_main_menu_default = { custom_class : "", custom_id : "" };
							k2t_heading_option_main_menu_default["custom_class"] =  jQuery.base64.btoa(jQuery( "#custom_class_'.$value['id'].'" ).val());
							k2t_heading_option_main_menu_default["custom_id"] =  jQuery.base64.btoa(jQuery( "#custom_id_'.$value['id'].'" ).val());
							var current_item_id = jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-item-id" );
							jQuery( "[item-id=\'"+ current_item_id + "\']" ).attr( "item-value",JSON.stringify(k2t_heading_option_main_menu_default));
							
						}else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "search_box" )
						{
							
						
							/*
						
							Search Box
						
							*/
						
							var k2t_heading_option_search_box_default = { custom_class : "", custom_id : "" };
							k2t_heading_option_search_box_default["custom_class"] =  jQuery.base64.btoa(jQuery( "#custom_search_box_class_'.$value['id'].'" ).val() );
							k2t_heading_option_search_box_default["custom_id"] = jQuery.base64.btoa( jQuery( "#custom_search_box_id_'.$value['id'].'" ).val() );
							var current_item_id = jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-item-id" );
							jQuery( "[item-id=\'"+ current_item_id + "\']" ).attr( "item-value",JSON.stringify(k2t_heading_option_search_box_default));
							
						}
						else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "cart" )
						{
							
							/*
						
							CARD BOX
						
							*/
						
							var k2t_heading_option_card_default = { custom_class : "", custom_id : "" };
							k2t_heading_option_card_default["custom_class"] =  jQuery.base64.btoa(jQuery( "#custom_card_class_'.$value['id'].'" ).val() );
							
							k2t_heading_option_card_default["custom_id"] =  jQuery.base64.btoa(jQuery( "#custom_card_id_'.$value['id'].'" ).val() );
							var current_item_id = jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-item-id" );
							jQuery( "[item-id=\'"+ current_item_id + "\']" ).attr( "item-value",JSON.stringify(k2t_heading_option_card_default));
							
						}
						
						else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "widget" )
						{
						
							/*
						
							Widgets
						
							*/
						
							var k2t_heading_option_widget_default = { widget_id:"", custom_class : "", custom_id : "" };
							k2t_heading_option_widget_default["widget_id"] =  jQuery.base64.btoa(jQuery( "#widget_id_'.$value['id'].'" ).val() );
							k2t_heading_option_widget_default["custom_class"] =  jQuery.base64.btoa(jQuery( "#custom_widget_class_'.$value['id'].'" ).val() );
							k2t_heading_option_widget_default["custom_id"] =  jQuery.base64.btoa(jQuery( "#custom_widget_id_'.$value['id'].'" ).val() );
							var current_item_id = jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-item-id" );
							jQuery( "[item-id=\'"+ current_item_id + "\']" ).attr( "item-value",JSON.stringify(k2t_heading_option_widget_default));
						
						}

						else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "logo" )
						{
						
							/*
						
							LOGO
						
							*/
						
							var k2t_heading_option_logo_default = { custom_class : "", custom_id : "" };

							k2t_heading_option_logo_default["custom_class"] =  jQuery.base64.btoa(jQuery( "#custom_logo_class_'.$value['id'].'" ).val() );

							k2t_heading_option_logo_default["custom_id"] =  jQuery.base64.btoa(jQuery( "#custom_logo_id_'.$value['id'].'" ).val() );

							var current_item_id = jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-item-id" );

							jQuery( "[item-id=\'"+ current_item_id + "\']" ).attr( "item-value",JSON.stringify(k2t_heading_option_logo_default));

						}

						else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "canvas_sidebar" )
						{
						
							/*
						
							Canvas Sidebar
						
							*/
						
							var k2t_heading_option_canvas_sidebar_default = { custom_class : "", custom_id : "" };

							k2t_heading_option_canvas_sidebar_default["custom_class"] =  jQuery.base64.btoa(jQuery( "#custom_canvas_sidebar_class_'.$value['id'].'" ).val() );

							k2t_heading_option_canvas_sidebar_default["custom_id"] = jQuery.base64.btoa( jQuery( "#custom_canvas_sidebar_id_'.$value['id'].'" ).val() );

							var current_item_id = jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-item-id" );

							jQuery( "[item-id=\'"+ current_item_id + "\']" ).attr( "item-value",JSON.stringify(k2t_heading_option_canvas_sidebar_default));
						
						}

						else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "custom_menu" )
						{
						
							/*
						
							Custom Menu
						
							*/
						
							var k2t_heading_option_custom_menu_default = { menu_id: "" , custom_class : "" , custom_id : "" };

							k2t_heading_option_custom_menu_default["menu_id"] =  jQuery.base64.btoa(jQuery( "#custom_menu_id_'.$value['id'].'" ).val() );

							k2t_heading_option_custom_menu_default["custom_class"] =  jQuery.base64.btoa(jQuery( "#custom_custom_menu_class_'.$value['id'].'" ).val() );

							k2t_heading_option_custom_menu_default["custom_id"] =  jQuery.base64.btoa(jQuery( "#custom_custom_menu_id_'.$value['id'].'" ).val() );

							var current_item_id = jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-item-id" );

							jQuery( "[item-id=\'"+ current_item_id + "\']" ).attr( "item-value",JSON.stringify(k2t_heading_option_custom_menu_default));
							
						}
						
						else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "wp_editor" )
						{
						
							/*
						
							Text Editor
						
							*/
						
							var k2t_heading_option_wp_editor_default = { value:"", custom_class : "", custom_id : "" };
							
							k2t_heading_option_wp_editor_default["value"] =  jQuery.base64.btoa(jQuery( "#k2t_editor_'.$value['id'].'" ).val() );
							
							k2t_heading_option_wp_editor_default["custom_class"] =  jQuery.base64.btoa(jQuery( "#custom_wp_editor_class_'.$value['id'].'" ).val() );
							
							k2t_heading_option_wp_editor_default["custom_id"] =  jQuery.base64.btoa(jQuery( "#custom_wp_editor_id_'.$value['id'].'" ).val() );
							
							var current_item_id = jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-item-id" );
							
							jQuery( "[item-id=\'"+ current_item_id + "\']" ).attr( "item-value",JSON.stringify(k2t_heading_option_wp_editor_default));
							
						}else if(jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-type" ) == "social" )
						{
							
							/*
						
							Social BOX
						
							*/
						
							var k2t_heading_option_social_default = { value:[  ], custom_class : "", custom_id : "" };

							k2t_heading_option_social_default["custom_class"] =  jQuery.base64.btoa(jQuery( "#custom_social_class_'.$value['id'].'" ).val() );

							k2t_heading_option_social_default["custom_id"] =  jQuery.base64.btoa(jQuery( "#custom_social_id_'.$value['id'].'" ).val() );

							jQuery( "#header_option_popup_for_'.$value['id'].' .social_list_'.$value['id'].' .header_options_social_list_popup .checkbox" ).each(function(){
								
								if(jQuery(this).is( ":checked" )){
								
									k2t_heading_option_social_default["value"].push(jQuery(this).attr( "rel" ));

								}
							});
							var current_item_id = jQuery( "#header_option_popup_for_'.$value['id'].'" ).attr( "current-item-id" );

							jQuery( "[item-id=\'" + current_item_id + "\']" ).attr( "item-value",JSON.stringify(k2t_heading_option_social_default));
						}

						jQuery( "#header_option_popup_for_'.$value['id'].'" ).css( "display","none" );

						k2t_clear_attr_header_popup'.$value['id'].'();

						theme_options_hidden_all'.$value['id'].'();

						k2t_reset_main_array_'.$value['id'].'();
					});

					/*
						END ACTION SAVE POPUP
					*/
					});
					';
					
							
							
							$output .= '</script>
					';

					if($smof_data[$value['id']] != ''){
						$header_option_data = (Array)json_decode ($smof_data[$value['id']], true);
					}else{
						$header_option_data = (Array)json_decode ('{"name":"'.$value['id'].'","setting":{"fullwidth":"","header_height":"","bg_image":"","bg_color":"","opacity":"","fixed_abs":"fixed","align_column_1":"left","align_column_2":"left","align_column_3":"left","boxshadow":"","custom_css":""},"columns_num":1,"htmlData":"","columns":[{"id":1,"value":[],"percent":12}]}',true);
					}
					
					$one_cols_size = "44.6";
					if($header_option_data["columns_num"] == "1"){ $one_cols_size = "44.6";}
					else if($header_option_data["columns_num"] == "2"){ $one_cols_size = "43";}
					else if($header_option_data["columns_num"] == "3"){ $one_cols_size = "41.5";}

					$output .= '
						
					<div id="k2t_header_options_for_'.$value['id'].'" class="k2t_header_options_wrapper"  header-options-name="'.$value['id'].'" columns_num="'.$header_option_data["columns_num"].'" >
							<div><div id="k2t_header_options_for_top_header" class="k2t_header_options_wrapper_row">';
					
					
					//Load All Struct Of Its

					$cols_id = 1;
					if ( count( $header_option_data["columns"] ) > 0 ) {
						foreach($header_option_data["columns"] as $cols){
							$output .= '
								<div class="parentcolid_'.$cols_id.'_'.$value['id'].' k2t_header_options_columns_content" columns_percent="'.$cols["percent"].'" parentcolid="'.$cols_id.'" style="width: '.($cols["percent"]*$one_cols_size).'px; float: left;">
									<div class="k2t_header_options_row k2t_header_options_columns " col-id="'.$cols_id.'"><div class="k2t_header_options_top_gray"></div>
										<div class="dashicons_columns dashicons dashicons-trash"></div>
										<div class="k2t_header_options_elements">
							';
											foreach($cols["value"] as $vl){
												$output .= '<div class="k2t_header_options_item" item-value="'.htmlspecialchars (json_encode($vl["value"])).'" item-type="'.$vl["type"].'" item-id="'.$vl["id"].'" for="k2t_header_options_feature_'.$vl["type"].'_params"><div class="dashicons_item dashicons dashicons-trash"></div>'.str_replace( "_"," ",$vl["type"]).'</div>';
											};
							$output .= '
										</div>
										<div class="k2t_header_options_add_element_columns">
											<div class="k2t_header_options_add_elelement"><i class="awesome-plus"></i></div>
										</div>
									</div>

								</div>
							';
							$cols_id++;
						};
					}
					$s_data = 'data-id="opacity_setting_'.$value['id'].'" data-val="10" data-min="0" data-max="100" data-step="1"';
		
					$output .= '	</div>
						<div class="k2t_header_options_setting">
							<div class="k2t_header_options_icon" rel="k2t_header_options_feature_setting"></div>
							<div class="k2t_header_options_add_columns" id="k2t_header_options_add_columns_'.$value['id'].'"></div>
						</div>
						</div>
						
					</div>
					<div class="header_option_popup" id="header_option_popup_for_'.$value['id'].'" header-options-popup-name="'.$value['id'].'">
						
						<div class="header_options_popup_content">
							<!-- POPUP CLOSE -->
							
							<div class="k2t_header_option_popup_control_close"><i class="awesome-close"></i></div>
							
							<!-- POPUP LOADING -->
							
							<div class="head_options_popup_loading"></div>
							
							<!-- POPUP FOR LIST -->


							<div class="k2t_header_options_popup_content_list" style="display:block">
								<h3 class="header_options_popup_content_heading">Choose Element</h3>
								<ul class="k2t_header_options_feature header_options_list_feature">
									<li class="k2t_header_options_feature_wp_editor" rel="k2t_header_options_feature_wp_editor_params" param-type="wp_editor">'. __( 'Text Editor', 'k2t' ) .'</li>
									<li class="k2t_header_options_feature_search_box" rel="k2t_header_options_feature_search_box_params" param-type="search_box">'. __( 'Search Box', 'k2t' ) .'</li>
									<li class="k2t_header_options_feature_social" rel="k2t_header_options_feature_social_params" param-type="social">'. __( 'Social', 'k2t' ) .' </li>
									<li class="k2t_header_options_feature_cart" rel="k2t_header_options_feature_cart_params" param-type="cart">'. __( 'WooCommerce Cart', 'k2t' ) .'</li>
									<li class="k2t_header_options_feature_widget" rel="k2t_header_options_feature_widget_params" param-type="widget">'. __( 'Widgets', 'k2t' ) .'</li>
									<li class="k2t_header_options_feature_logo" rel="k2t_header_options_feature_logo_params" param-type="logo">'. __( 'Logo', 'k2t' ) .'</li>
									<li class="k2t_header_options_feature_canvas_sidebar" rel="k2t_header_options_feature_canvas_sidebar_params" param-type="canvas_sidebar">'. __( 'Canvas Sidebar', 'k2t' ) .'</li>
									<li class="k2t_header_options_feature_custom_menu" rel="k2t_header_options_feature_custom_menu_params" param-type="custom_menu">'. __( 'Custom Menu', 'k2t' ) .'</li>
									<li class="k2t_header_options_feature_login" rel="k2t_header_options_feature_login_params" param-type="login">'. __( 'Login', 'k2t' ) .'</li>
								</ul>
							</div>
							
							<!-- POPUP FOR VISSUAL EDITOR -->

							<div class="k2t_header_options_feature k2t_header_options_feature_wp_editor_params" style="display:none;">
								<h3 class="header_options_popup_content_heading">Text Editor</h3>
								<div class="header_options_popup_content-inner">
									<div class="explain">Insert your content ( shortcode allowed )</div>
									'.Options_Machine::k2t_wp_editor($value['id'],'').'</br>
									<div class="explain">Custom Class</div>
									<input class="of-input " name="custom_wp_editor_class_'. esc_attr( $value['id'] ) .'" id="custom_wp_editor_class_'. esc_attr( $value['id'] ) .'" type="text" value="">
									<div class="explain">Custom ID</div>
									<input class="of-input " name="custom_wp_editor_id_'. esc_attr( $value['id'] ) .'" id="custom_wp_editor_id_'. esc_attr( $value['id'] ) .'" type="text" value="">
								</div>	
							</div>

							<!-- POPUP FOR ELEMENT WP SEARCHBOX -->
							
							<div class="k2t_header_options_feature k2t_header_options_feature_search_box_params"  style="display:none;">
								<h3 class="header_options_popup_content_heading">Search Box</h3>
								<div class="header_options_popup_content-inner">
									<input class="of-input " name="custom_search_box_class_'. esc_attr( $value['id'] ) .'" id="custom_search_box_class_'. esc_attr( $value['id'] ) .'" type="text" value="">
									<div class="explain">Custom ID</div>
									<input class="of-input " name="custom_search_box_id_'. esc_attr( $value['id'] ) .'" id="custom_search_box_id_'. esc_attr( $value['id'] ).'" type="text" value="">
								</div>
							</div>

							<!-- POPUP FOR ELEMENT WP SOCIAL -->

							<div class="k2t_header_options_feature k2t_header_options_feature_social_params"  style="display:none;">
								<h3 class="header_options_popup_content_heading">Social Network</h3>
								<div class="header_options_popup_content-inner">
									<div class="explain">Enable your social network on <b>Social Tab</b></div></br>
									'.Options_Machine::k2t_get_social_list($value['id'],'').'
									<div class="explain">Custom Class</div>
									<input class="of-input " name="custom_social_class_'. esc_attr( $value['id'] ) .'" id="custom_social_class_'. esc_attr( $value['id'] ) .'" type="text" value="">
									<div class="explain">Custom ID</div>
									<input class="of-input " name="custom_social_id_'. esc_attr( $value['id'] ).'" id="custom_social_id_'. esc_attr( $value['id'] ) .'" type="text" value="">
								</div>
							</div>

							<!-- POPUP FOR ELEMENT CUSTOM MENU -->

							<div class="k2t_header_options_feature k2t_header_options_feature_custom_menu_params"  style="display:none;">
								<h3 class="header_options_popup_content_heading">Custom Menu</h3>
								<div class="header_options_popup_content-inner">
									'.Options_Machine::k2t_get_menu_list($value['id'],'').'
									<div class="explain">Custom Class</div>
									<input class="of-input " name="custom_custom_menu_class_'.esc_attr( $value['id'] ).'" id="custom_custom_menu_class_'.esc_attr( $value['id'] ).'" type="text" value="">
									<div class="explain">Custom ID</div>
									<input class="of-input " name="custom_custom_menu_id_'.esc_attr( $value['id'] ).'" id="custom_custom_menu_id_'.esc_attr( $value['id'] ).'" type="text" value="">
								</div>
							</div>

							<!-- POPUP FOR ELEMENT CART -->

							<div class="k2t_header_options_feature k2t_header_options_feature_cart_params"  style="display:none;">
								<h3 class="header_options_popup_content_heading">WooCommerce Cart</h3>
								<div class="header_options_popup_content-inner">
									'.Options_Machine::k2t_get_shop_info('','').'
									<div class="explain">Custom Class</div>
									<input class="of-input " name="custom_card_class_'.esc_attr( $value['id'] ).'" id="custom_card_class_'.esc_attr( $value['id'] ).'" type="text" value="">
									<div class="explain">Custom ID</div>
									<input class="of-input " name="custom_card_id_'.esc_attr( $value['id'] ).'" id="custom_card_id_'.esc_attr( $value['id'] ).'" type="text" value="">
								</div>
							</div>

							<!-- POPUP FOR ELEMENT WIDGET -->
							
							<div class="k2t_header_options_feature k2t_header_options_feature_widget_params"  style="display:none;">
								<h3 class="header_options_popup_content_heading">Widget Sidebar</h3>
								<div class="header_options_popup_content-inner">									<div class="explain">Custom Class</div>
									<input class="of-input" name="custom_widget_class_'.esc_attr( $value['id'] ).'" id="custom_widget_class_'.esc_attr( $value['id'] ).'" type="text" value="">
									<div class="explain">Custom ID</div>
									<input class="of-input " name="custom_widget_id_'.esc_attr( $value['id'] ).'" id="custom_widget_id_'.esc_attr( $value['id'] ).'" type="text" value="">
								</div>
							</div>

							<!-- POPUP FOR ELEMENT LOGO -->

							<div class="k2t_header_options_feature k2t_header_options_feature_logo_params"  style="display:none;">
								<h3 class="header_options_popup_content_heading">Logo</h3>
								<div class="header_options_popup_content-inner">
									<div class="explain">Custom Class</div>
									<input class="of-input " name="custom_logo_class_'.esc_attr( $value['id'] ).'" id="custom_logo_class_'.esc_attr( $value['id'] ).'" type="text" value="">
									<div class="explain">Custom ID</div>
									<input class="of-input " name="custom_logo_id_'.esc_attr( $value['id'] ).'" id="custom_logo_id_'.esc_attr( $value['id'] ).'" type="text" value="">
								</div>
							</div>

							<!-- POPUP FOR ELEMENT LOGIN -->
							
							<div class="k2t_header_options_feature k2t_header_options_feature_login_params"  style="display:none;">
								<h3 class="header_options_popup_content_heading">'. __( 'Login', 'k2t' ) .'</h3>
								<div class="header_options_popup_content-inner">							
									<div class="explain">Custom Class</div>
									<input class="of-input" name="custom_widget_class_'.esc_attr( $value['id'] ).'" id="custom_widget_class_'.esc_attr( $value['id'] ).'" type="text" value="">
									<div class="explain">Custom ID</div>
									<input class="of-input" name="custom_widget_id_'.esc_attr( $value['id'] ).'" id="custom_widget_id_'.esc_attr( $value['id'] ).'" type="text" value="">
								</div>
							</div>

							
							<!-- CANVAS SIDEBAR -->

							<div class="k2t_header_options_feature k2t_header_options_feature_canvas_sidebar_params"  style="display:none;">
								<h3 class="header_options_popup_content_heading">Canvas Sidebar</h3>
								<div class="header_options_popup_content-inner">
									'.Options_Machine::k2t_get_widget_list($value['id'],'').'
									<div class="explain">Custom Class</div>
									<input class="of-input " name="custom_canvas_sidebar_class_'.esc_attr( $value['id'] ).'" id="custom_canvas_sidebar_class_'.esc_attr( $value['id'] ).'" type="text" value="">
									<div class="explain">Custom ID</div>
									<input class="of-input " name="custom_canvas_sidebar_id_'.esc_attr( $value['id'] ).'" id="custom_canvas_sidebar_id_'.esc_attr( $value['id'] ).'" type="text" value="">
								</div>
							</div>

							<!-- POPUP FOR ELEMENT SETTING OF HEADER -->

							<div class="k2t_header_options_feature k2t_header_options_feature_setting_params"  style="display:none;">
								<h3 class="header_options_popup_content_heading">Section Settings</h3>
								<div class="header_options_popup_content-inner">
									
									<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
									</div>
									<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
										<div class="explain">'. __( 'Header height (unit: px)', 'k2t' ) .'</div>
										<input name="header_height_setting_'.esc_attr( $value['id'] ).'" id="header_height_setting_'.esc_attr( $value['id'] ).'" type="text" value="'. ( ! empty( $data['setting']['header_height'] ) ? k2t_decode( $data['setting']['header_height'] ) : '' ) .'" />
										<div class="clear"> </div>
									</div>
									<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
										<div class="explain">Background Color</div>
										<input name="bg_color_setting_'.esc_attr( $value['id'] ).'" id="bg_color_setting_'.esc_attr( $value['id'] ).'" class="of-color"  type="text" data-default-color="" value="'. ( ! empty( $data['setting']['bg_color'] ) ? k2t_decode( $data['setting']['bg_color'] ) : '' ) .'" />
										<div class="clear"> </div>
									</div>
									<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
									</div>
									<div class="clear"> </div>
									<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
										<div class="explain">'. __( 'Align column 1', 'k2t' ) .'</div>
										<select name="align_column_1_setting_'.esc_attr( $value['id'] ).'" id="align_column_1_setting_'.esc_attr( $value['id'] ).'">
											<option value="left" '. ( ! empty( $data['setting']['align_column_1'] ) ? selected( k2t_decode( $data['setting']['align_column_1'] ), 'left', false ) : '' ) .'>'. __( 'Left', 'k2t' ) .'</option>
											<option value="center" '. ( ! empty( $data['setting']['align_column_1'] ) ? selected( k2t_decode( $data['setting']['align_column_1'] ), 'center', false ) : '' ) .'>'. __( 'Center', 'k2t' ) .'</option>
											<option value="right" '. ( ! empty( $data['setting']['align_column_1'] ) ? selected( k2t_decode( $data['setting']['align_column_1'] ), 'right', false ) : '' ) .'>'. __( 'Right', 'k2t' ) .'</option>
										</select>
										<div class="clear"> </div>
									</div>
									<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
										<div class="explain">'. __( 'Align column 2', 'k2t' ) .'</div>
										<select name="align_column_2_setting_'.esc_attr( $value['id'] ).'" id="align_column_2_setting_'.esc_attr( $value['id'] ).'">
											<option value="left" '. ( ! empty( $data['setting']['align_column_2'] ) ? selected( k2t_decode( $data['setting']['align_column_2'] ), 'left', false ) : '' ) .'>'. __( 'Left', 'k2t' ) .'</option>
											<option value="center" '. ( ! empty( $data['setting']['align_column_2'] ) ? selected( k2t_decode( $data['setting']['align_column_2'] ), 'center', false ) : '' ) .'>'. __( 'Center', 'k2t' ) .'</option>
											<option value="right" '. ( ! empty( $data['setting']['align_column_2'] ) ? selected( k2t_decode( $data['setting']['align_column_2'] ), 'right', false ) : '' ) .'>'. __( 'Right', 'k2t' ) .'</option>
										</select>
										<div class="clear"> </div>
									</div>
									<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
										<div class="explain">'. __( 'Align column 3', 'k2t' ) .'</div>
										<select name="align_column_3_setting_'.esc_attr( $value['id'] ).'" id="align_column_3_setting_'.esc_attr( $value['id'] ).'">
											<option value="left" '. ( ! empty( $data['setting']['align_column_3'] ) ? selected( k2t_decode( $data['setting']['align_column_3'] ), 'left', false ) : '' ) .'>'. __( 'Left', 'k2t' ) .'</option>
											<option value="center" '. ( ! empty( $data['setting']['align_column_3'] ) ? selected( k2t_decode( $data['setting']['align_column_3'] ), 'center', false ) : '' ) .'>'. __( 'Center', 'k2t' ) .'</option>
											<option value="right" '. ( ! empty( $data['setting']['align_column_3'] ) ? selected( k2t_decode( $data['setting']['align_column_3'] ), 'right', false ) : '' ) .'>'. __( 'Right', 'k2t' ) .'</option>
										</select>
										<div class="clear"> </div>
									</div>
									<div class="option">
										<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
											<div class="explain">Opacity (value from 0 to 100, eg: 100)</div>
											<div class="controls">
												<input type="number" name="opacity_setting_'.esc_attr( $value['id'] ).'" id="opacity_setting_'.esc_attr( $value['id'] ).'" value="'. ( ! empty( $data['setting']['opacity'] ) ? k2t_decode( $data['setting']['opacity'] ) : '100' ) .'" class="mini" />
												<div id="opacity_setting_slide'.$value['id'].'-slider" class="smof_sliderui" style="margin-left: 7px;" '. $s_data .'></div>
											</div>
										</div>
										<div class="clear"> </div>
										<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
											
										</div>
										<div class="clear"> </div>
										<div class="k2t_header_options_feature_setting_left" style="position:relative;margin-bottom: 10px;">
											<div class="explain">Custom Css</div>
											<textarea style="display:none" class="of-input"  style="display:none;" data-editor = "'.esc_attr( $value['id'] ).'-editor"  data-mode="css" data-theme="chrome" name="custom_css_setting_'.esc_attr( $value['id'] ).'" id="custom_css_setting_'.esc_attr( $value['id'] ).'" cols="8" rows="4">
											</textarea>
											
											<textarea class="of-input of-input-ace"  data-editor = "'.esc_attr( $value['id'] ).'-editor"  data-mode="css" data-theme="chrome" name="custom_css_setting_'.esc_attr( $value['id'] ).'_pre" id="custom_css_setting_'.esc_attr( $value['id'] ).'_pre" cols="8" rows="4">'. ( ! empty( $data['setting']['custom_css'] ) ? k2t_decode( $data['setting']['custom_css'] ) : '' ) .'</textarea>
											<script type="text/javascript">
												var editor'.$value['id'].' = ace.edit("custom_css_setting_'.$value['id'].'_pre");
												editor'.$value['id'].'.setTheme("ace/theme/textmate");
													editor'.$value['id'].'.session.setMode("ace/mode/css");
													editor'.$value['id'].'.renderer.setScrollMargin(10, 10);
													editor'.$value['id'].'.setOptions({
													    // "scrollPastEnd": 0.8,
													    autoScrollEditorIntoView: false
													});

												editor'.$value['id'].'.getSession().on("change", function () {
											       jQuery("#custom_css_setting_'.$value['id'].'").val(editor'.$value['id'].'.getSession().getValue());
											    });
											</script>
										</div>
									</div>
								</div>
							</div>
							<div class="header_option_popup_control">
								<div class="k2t_header_option_popup_control_save button-primary">Save</div>
								<div class="k2t_header_option_popup_control_cancel button submit-button">Cancel</div>
							</div>
						</div>
					</div>
				';
				break;

				}

				do_action( 'optionsframework_machine_loop', array(
						'options' => $options,
						'smof_data' => $smof_data,
						'defaults' => $defaults,
						'counter' => $counter,
						'menu'  => $menu,
						'output' => $output,
						'value'  => $value
					) );
				if ( $smof_output != "" ) {
					$output .= $smof_output;
					$smof_output = "";
				}

				//description of each option
				if ( $value['type'] != 'heading' ) {
					if ( empty( $value['desc'] ) ) { $explain_value = ''; } else {
						$explain_value = '<div class="explain">'. $value['desc'] .'</div>'."\n";
					}
					$output .= '</div>'.$explain_value."\n";
					$output .= '<div class="clear"> </div></div></div>'."\n";
				}

			} /* condition empty end */

		}

		if ( $update_data == true ) {
			of_save_options( $smof_data );
		}

		$output .= '</div>';

		do_action( 'optionsframework_machine_after', array(
				'options'  => $options,
				'smof_data'  => $smof_data,
				'defaults'  => $defaults,
				'counter'  => $counter,
				'menu'   => $menu,
				'output'  => $output,
				'value'   => $value
			) );
		if ( $smof_output != "" ) {
			$output .= $smof_output;
			$smof_output = "";
		}

		return array( $output, $menu, $defaults );

	}
	/**
	 * Native media library uploader
	 *
	 * @uses get_theme_mod()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_media_uploader_function( $id, $std, $mod ) {

		$data = of_get_options();
		$smof_data = of_get_options();

		$uploader = '';
		$upload = "";
		if ( isset( $smof_data[$id] ) )
			$upload = $smof_data[$id];
		$hide = '';

		if ( $mod == "min" ) {$hide ='hide';}

		if ( $upload != "" ) { $val = $upload; } else {$val = $std;}

		$uploader .= '<input class="'.$hide.' upload of-input" name="'. esc_attr( $id ) .'" id="'. esc_attr( $id ) .'_upload" value="'. esc_attr( $val ) .'" />';

		//Upload controls DIV
		$uploader .= '<div class="upload_button_div">';
		//If the user has WP3.5+ show upload/remove button
		if ( function_exists( 'wp_enqueue_media' ) ) {
			$uploader .= '<span class="button media_upload_button" id="'.$id.'">Upload</span>';

			if ( !empty( $upload ) ) {$hide = '';} else { $hide = 'hide';}
			$uploader .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
		}
		else {
			$output .= '<p class="upload-notice"><i>Upgrade your version of WordPress for full media support.</i></p>';
		}

		$uploader .='</div>' . "\n";

		//Preview
		$uploader .= '<div class="screenshot">';
		if ( !empty( $upload ) ) {
			$uploader .= '<a class="of-uploaded-image" href="'. esc_url( $upload ) . '">';
			$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.esc_url( $upload ).'" alt="" />';
			$uploader .= '</a>';
		}
		$uploader .= '</div>';
		$uploader .= '<div class="clear"></div>' . "\n";

		return $uploader;

	}
	public static function optionsframework_media_uploader_function_for_header( $id,$value, $std, $mod ) {

		$data = of_get_options();
		$smof_data = of_get_options();

		$uploader = '';
		$upload = $value;
		
		$hide = '';

		if ( $mod == "min" ) {$hide ='hide';}

		if ( $upload != "" ) { $val = $upload; } else {$val = $std;}

		$uploader .= '<div id="section-'. $id .'" class="section section-media "><input class="'.$hide.' upload of-input" name="'. esc_attr( $id ) .'" id="'. esc_attr( $id ) .'_upload" value="'. esc_attr( $val ) .'" />';

		//Upload controls DIV
		$uploader .= '<div class="upload_button_div">';
		//If the user has WP3.5+ show upload/remove button
		if ( function_exists( 'wp_enqueue_media' ) ) {
			$uploader .= '<span class="button media_upload_button" id="'.$id.'">Upload</span>';

			if ( !empty( $upload ) ) {$hide = '';} else { $hide = 'hide';}
			$uploader .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
		}
		else {
			$output .= '<p class="upload-notice"><i>Upgrade your version of WordPress for full media support.</i></p>';
		}

		$uploader .='</div>' . "\n";

		//Preview
		$uploader .= '<div class="screenshot">';
		if ( !empty( $upload ) ) {
			$uploader .= '<a class="of-uploaded-image" href="'. esc_url( $upload ) . '">';
			$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.esc_url( $upload ).'" alt="" />';
			$uploader .= '</a>';
		}
		$uploader .= '</div>';
		$uploader .= '<div class="clear"></div>' . "\n</div>";

		return $uploader;

	}
	/**
	 * Drag and drop slides manager
	 *
	 * @uses get_theme_mod()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_slider_function( $id, $std, $oldorder, $order ) {

		$data = of_get_options();
		$smof_data = of_get_options();

		$slider = '';
		$slide = array();
		if ( isset( $smof_data[$id] ) )
			$slide = $smof_data[$id];

		if ( isset( $slide[$oldorder] ) ) { $val = $slide[$oldorder]; } else {$val = $std;}

		//initialize all vars
		$slidevars = array( 'title', 'url', 'link', 'description' );

		foreach ( $slidevars as $slidevar ) {
			if ( empty( $val[$slidevar] ) ) {
				$val[$slidevar] = '';
			}
		}

		//begin slider interface
		if ( !empty( $val['title'] ) ) {
			$slider .= '<li><div class="slide_header"><strong>'.stripslashes( $val['title'] ).'</strong>';
		} else {
			$slider .= '<li><div class="slide_header"><strong>Slide '.$order.'</strong>';
		}

		$slider .= '<input type="hidden" class="slide of-input order" name="'. esc_attr( $id ) .'['. esc_attr( $order ).'][order]" id="'. esc_attr( $id ).'_'. esc_attr( $order ) .'_slide_order" value="'. esc_attr( $order ) .'" />';

		$slider .= '<a class="slide_edit_button" href="#">Edit</a></div>';

		$slider .= '<div class="slide_body">';

		$slider .= '<label>Title</label>';
		$slider .= '<input class="slide of-input of-slider-title" name="'. esc_attr( $id ) .'['.esc_attr( $order ).'][title]" id="'. esc_attr( $id ) .'_'.esc_attr( $order ) .'_slide_title" value="'. stripslashes( esc_attr( $val['title'] ) ) .'" />';

		$slider .= '<label>Image URL</label>';
		$slider .= '<input class="upload slide of-input" name="'. esc_attr( $id ) .'['.esc_attr( $order ).'][url]" id="'. esc_attr( $id ) .'_'.esc_attr( $order ) .'_slide_url" value="'. esc_attr( $val['url'] ) .'" />';

		$slider .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.$id.'_'.$order .'">Upload</span>';

		if ( !empty( $val['url'] ) ) {$hide = '';} else { $hide = 'hide';}
		$slider .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'_'.$order .'" title="' . $id . '_'.$order .'">Remove</span>';
		$slider .='</div>' . "\n";
		$slider .= '<div class="screenshot">';
		if ( !empty( $val['url'] ) ) {

			$slider .= '<a class="of-uploaded-image" href="'. esc_url( $val['url'] ) . '">';
			$slider .= '<img class="of-option-image" id="image_'.$id.'_'.$order .'" src="'.esc_url( $val['url'] ).'" alt="" />';
			$slider .= '</a>';

		}
		$slider .= '</div>';
		$slider .= '<label>Link URL (optional)</label>';
		$slider .= '<input class="slide of-input" name="'. esc_attr( $id ) .'['.esc_attr( $order ).'][link]" id="'. esc_attr( $id ) .'_'.esc_attr( $order ) .'_slide_link" value="'. esc_attr( $val['link'] ) .'" />';

		$slider .= '<label>Description (optional)</label>';
		$slider .= '<textarea class="slide of-input" name="'. esc_attr( $id ) .'['.esc_attr( $order ).'][description]" id="'. esc_attr( $id ) .'_'.esc_attr( $order ) .'_slide_description" cols="8" rows="8">'.stripslashes( esc_attr( $val['description'] ) ).'</textarea>';

		$slider .= '<a class="slide_delete_button" href="#">Delete</a>';
		$slider .= '<div class="clear"></div>' . "\n";

		$slider .= '</div>';
		$slider .= '</li>';
		return $slider;
	}
	/**
	 * Call All Sidebar and Active Curent sidebar
	 *
	 * @uses wp_get_sidebars_widgets()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return dropdown of sidebar
	 */
	public static function k2t_get_widget_list( $id, $value ) {
		$output      = '';
		$widget_list = wp_get_sidebars_widgets();
		$output .= '
				<div class="explain">Select Widget</div>
				<select class="select of-input" name="widget_id_'. esc_attr( $id ) .'" id="widget_id_'. esc_attr( $id ) .'">';
			
		foreach( $widget_list as $key => $wl )
		{
			if( $key <> 'wp_inactive_widgets' ) {
				$output .= '<option id="widget_key_'. esc_attr( $key ) .'" value="'. esc_attr( $key ) .'">'.$key.'</option>';
			}
		}
		$output .= '</select>';
		return $output;
	}
	/**
	 * Call menu avaiable
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return dropdown of menu
	 */
	public static function k2t_get_menu_list( $id, $value ) {
		$output = '';
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		$output .= '
				<div class="explain">Select Menu</div>
				<select class="select of-input" name="custom_menu_id_'. esc_attr( $id ) .'" id="custom_menu_id_'. esc_attr( $id ) .'">';
			
		foreach($menus as $menu)
		{
			
				$output .= '<option id="'. esc_attr( $menu->name ) .'" value="'. esc_attr( $menu->name ) .'">'.$menu->name.'</option>';
			
		}
		$output .= '</select>';
		if($value != ''){
			
		}else{
		}
		return $output;
	}
	public static function k2t_get_social_list($id,$value)
	{			
		global $of_options, $smof_data;	
		$output = '<div class="social_list_'.$id.'" style="width:100%;overflow:auto;">';
		foreach ( k2t_social_array() as $s => $c )
		{
			//print_r($smof_data["social-".$s]);
			if(isset($smof_data["social-".$s]) && $smof_data["social-".$s] <> '')
			{
				$output .= '<div class="header_options_social_list_popup header_options_social_list_popup_'.$s.'  " ><input type="checkbox" class="checkbox of-input" rel='.esc_attr( $s ).' name="'.esc_attr( $id ).'_'.esc_attr( $s ).'" id="'.esc_attr( $id ).'_'.esc_attr( $s ).'" value="1"  /><label class="multicheck" for="">'. $c .'</label></div>';
			}else{
				$output .= '<div class="header_options_social_list_popup header_options_social_list_popup_'.$s.'  "  style="display:none;"> <input type="checkbox" class="checkbox of-input" rel='.esc_attr( $s ).' name="'.esc_attr( $id ).'_'.esc_attr( $s ).'" id="'.esc_attr( $id ).'_'.esc_attr( $s ).'" value="1"  /><label class="multicheck" for="" >'. $c .'</label></div>';
			}
		}
		$output .= '</div>';
		return $output;
	}
	public static function k2t_get_shop_info($id,$value){
		$output = '';
		$output .= '';
		return $output;
	}
	public static function k2t_wp_editor($id,$save)
	{
		global $of_options, $smof_data;	
		$content = '';
		$editor_id = "k2t_editor_".$id;
		//wp_editor( $content, $editor_id);
		$output = "<textarea name='".esc_attr( $editor_id )."' class='k2t_wp_editor' id='".esc_attr( $editor_id )."' placeholder='Enter your content...' class='inputwide'> </textarea>";
		return $output;
	}
}
?>