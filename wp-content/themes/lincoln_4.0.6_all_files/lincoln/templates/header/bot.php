<?php
/**
 * The bottom header for theme.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

if ( $smof_data['header_section_3'] != '' ) :
	// Get all data of top header
	$data = json_decode ( $smof_data[ 'header_section_3' ], true );

	// Get number of column display
	$col = $data['columns_num'];
	
	// Get section properties
	$class 				= array();
	$style    			= array();
	$arr_section_val 	= array();
	$arr_section 		= array( 
		'bg_color' 				=> '', 
		'bg_image' 				=> '', 
		'opacity' 				=> '', 
		'boxshadow' 			=> '',
		'custom_css'			=> '', 
	);
	foreach ( $arr_section as $meta => $val ) {
		if ( ! empty( $data['setting'][$meta] ) ) {
			$arr_section_val[$meta] = k2t_decode($data['setting'][$meta]);
		}
	}
	extract( shortcode_atts( $arr_section, $arr_section_val ) );
	$rgb      = k2t_hex2rgb( $bg_color );

	// Render background color for section
	if ( ! empty( $hex ) ) {
		$a 				= ! empty( $opacity ) ? ',' . $opacity : ', 1';
		$style[] 		= 'background-color: rgba(' . $rgb['0'] . ',' . $rgb['1'] . ',' . $rgb['2'] . $a .');';
	}

	// Render background image for section
	if ( ! empty( $bg_image ) ) {
		$style[] 		= 'background-image: url( ' . $bg_image . ' );';
		if ( $hex == '' &&  $opacity != '' ) {
			$style[] 	= 'opacity: ' . $opacity . ';';
		}
	}

	// Render class for section
	if ( ! empty( $boxshadow ) ) {
		$class[] 		= 'box-shadow';
	}
	
	$trimmed_custom_css = trim($custom_css);
	// Render custom css for section
	if ( !empty($trimmed_custom_css) ) {
		echo '<style>' . $trimmed_custom_css . '</style>';
	}

	/**
	 * Bottom header output.
	 *
	 * @since  1.0
	 */
	function k2t_bot_header_value( $data, $id, $section ) {
		$values = $data['columns'][$id]['value'];
		$i = 0;
		foreach ( $values as $val ) {
			if ( function_exists( 'k2t_data' ) ) {
				k2t_data( $id, $i, $section );
			}
			$i++;
		}
	}
	?>
	<div class="k2t-header-bot <?php echo implode( ' ', $class ); ?>" style="<?php echo esc_attr( implode( ' ', $style ) ); ?>">
		<div class="k2t-wrap">
			<div class="k2t-row">
				<?php
					$section = 'header_section_3';
					for ( $i = 0; $i < $col; $i++ ) {
						echo '<div class="col-' . esc_attr( $data['columns'][$i]['percent'] ) . '">';
							k2t_bot_header_value( $data, $i, $section );
						echo '</div>';
					}
				?>
			</div><!-- .row -->
		</div><!-- .k2t-wrap -->
	</div><!-- .k2t-header-bot -->
<?php endif; ?>