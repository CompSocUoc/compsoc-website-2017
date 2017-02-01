<?php

Class K2T_Teacher_Register{
	public $custom_fields = array();
	public $custom_fields_types = array();
	public $taxonomies = array();
	public $terms = array();
	public $post_types = array();
	
	public function __construct(){
		// Set default custom fields types
		$this->custom_fields_types = array(
			'input-text' => '',
			'input-number' => '',
			'input-checkbox' => '',
			'input-radio' => '',
			'input-file' => '',
			'input-hidden' => '',
			'select-box' => '',
			'textarea' => '',
			'date-picker' => ''
		);
		
		// Register hook action
		$this->hook();
	}
	
	protected function hook(){
		add_action( 'init', array($this, '_register_post_type'), 1 );
		add_action( 'init', array($this, '_register_taxonomy'), 1 );
		add_action( 'init', array($this, '_add_term'), 1 );
		// add_action( 'add_meta_boxes', array($this, 'register_custom_boxes') );
		add_action( 'save_post', array($this, 'save_cf_data') );
		add_action( 'admin_footer', array($this, 'enqueue_script_inline') );
	}
	
	/**
	 * Add custom field to post edit page of specified post type
	 */
	public function register_custom_boxes(){
		$cf_standard = array(
			'id' => '',
			'title' => '',
			'field_name' => '',
			'type' => '',
			'options' => '', 
			'default_value' => '',
			'style' => '',
			'callback' => '',
			'required' => true
		);
		
		foreach($this->get_custom_field() as $cfs){
			$cfs_content = '';
			if( !empty($cfs['fields']) ){
				foreach((array)$cfs['fields'] as $cf){
					$cf = array_merge($cf_standard, $cf);
					$content = $this->get_cf_content($cf);
	
					if( is_callable($cf['callback']) ){
						$callback_return = call_user_func($cf['callback'], $cf);
					}
					
					if( $content == '' && !empty($callback_return) ){
						$content = (string) $callback_return;
					}
					
					$cfs_content .= '<div class="k2t-custom-field">' . $content . '</div>';
				}
			}
			
			// Add metabox to edit post page with specified post type
			$post_types = array_keys($this->post_types);
			if( !$post_types )  $post_types = array('post', 'page');
			
			add_meta_box(
				$cfs['id'], // HTML 'id' attribute of the edit screen section
				__( $cfs['title'], 'k2t' ), // Title of the edit screen section, visible to user
				array($this, 'render_meta_box'), // Function that prints out the HTML for the edit screen section
				current($post_types), // The type of writing screen on which to show the edit screen section
				'normal',
				'high',
				array('cfs_content' => $cfs_content)
			);
		}
	}

	public function render_meta_box($post, $metabox){
		echo trim($metabox['args']['cfs_content']);
	}
	
	/**
	 *  Function to add more terms 
	 */
	public function add_term($term, $taxonomy = '', $args = array()){
		if( is_array( $term ) ){
			foreach($term as $regis){
				@$this->add_term( (string)current($regis), (string)next($regis), (array)next($regis) );
			}
			return $this;
		}
		
		// If the taxonomy is not existed, register it first
		$this->register_taxonomy($taxonomy, $args);
		
		$this->terms[] = array(
			'term' => (string)$term,
			'taxonomy' => (string)$taxonomy,
			'args' => (array)$args
		);
		
		return $this;
	}
	
	public function _add_term(){
		foreach($this->terms as $term){
			$term_exists = term_exists( $term['term'], $term['taxonomy'] );
			if( $term_exists !== 0 && $term_exists !== null  ){
				return $term_exists;
			}
			//
			return wp_insert_term( $term['term'], $term['taxonomy'], $term['args'] );
		}
	}
	
	/**
	 *  Register taxonomy
	 */
	 
	 public function register_taxonomy($taxonomy, $args = array()){
	 	if( is_array($taxonomy) ){
	 		foreach($taxonomy as $tax){
	 			if( !isset($tax['taxonomy']) ) continue;
				else{
					$tax['taxonomy'] = strtolower( trim( (string)$tax['taxonomy'] ) );
					if( empty($tax['args']) )  $tax['args'] = array();
				}
				
	 			$this->register_taxonomy($tax['taxonomy'], $tax['args']);
	 		}
			// always return true;
			return $this;
	 	}
		
	 	if( !taxonomy_exists($taxonomy) ){
			$args_default = array(
				'public' => true,
				'rewrite' => false,
				'hierarchical' => true,
				'show_ui'             => true,
				'show_admin_column'   => true,
				'query_var'           => true,
			);
			
			$this->taxonomies[] = array(
				'taxonomy' => (string)$taxonomy, 
				'post-type' => !empty($args['post-type']) ? (array)$args['post-type'] : array('post', 'page'), 
				'args' => array_merge($args_default, (array)$args)); 
		}
		
		// always return true;
		return $this;
	 }
	
	public function _register_taxonomy(){
		//ilogs($this->taxonomies);
		foreach($this->taxonomies as $tax){
			register_taxonomy(
				$tax['taxonomy'], // taxonomy
				$tax['post-type'], // post type
				$tax['args'] // args
			);
		}
		return $this;
	}
	
	/**
	 * Register post type
	 */
	public function register_post_type($post_type, $args = array()){
		if( is_array($post_type) ){
			foreach($post_type as $ptype){
				if( !isset($ptype['post-type']) ){
					continue;
				}
				else{
					$ptype['post-type'] = strtolower( trim( (string)$ptype['post-type'] ) );
					if( empty($ptype['args']) ) $ptype['args'] = array();
					$this->register_post_type( $ptype['post-type'], $ptype['args'] );
				}
			}
			
			// always return true;\
			return $this->post_types;
		}
		
		$args_default = array(  
			'labels' 				=> array(),  
			'menu_position' 		=> 5, 
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'has_archive' 			=> true,
			'hierarchical' 			=> false,
			'supports' 				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);
		
		$args = array_merge($args_default, (array)$args);
		$this->post_types[$post_type] = array(
			'post-type' => $post_type,
			'args' => $args
		);
		
		// always return true;
		return $this->post_types;
	}
	
	public function _register_post_type(){
		foreach($this->post_types as $ptype){
			register_post_type($ptype['post-type'], $ptype['args']);
		}
		flush_rewrite_rules();
		
		return $this;
	}
	
	/**
	 * Get custom field registered
	 */
	public function get_custom_field($field_id = null){
		$fields = array();
		ksort($this->custom_fields);
		foreach($this->custom_fields as &$f){
			$fields = array_merge($fields, $f);
		}
		
		if( $field_id === NULL )
			return $fields;
		else{
			return isset($fields[$field_id]) ? $fields[$field_id] : null;
		}
		
	}
	
	/**
	 * Get content of a specific custom field via type of field
	 */
	protected function get_cf_content($cf){
		if( !isset($cf['type']) ) return '';
		$cf_type = strtolower(trim($cf['type']));
		if( $cf_content = $this->get_cf_content_type($cf_type, $cf) ){
			return $cf_content;
		}
		// Always return something
		return '';  
	}
	
	/**
	 * Get content of all custom fields registered
	 */
	public function get_cf_content_type($type, $field){
		global $post;
		$type = strtolower(trim($type));
		
		if( !isset($this->custom_fields_types[$type]) ){
			return '';
		}
		
		if( is_callable($callback = $this->custom_fields_types[$type]) ){
			return (string) call_user_func($callback, $field);
		}
		elseif( is_string($this->custom_fields_types[$type]) ){
			if( $this->custom_fields_types[$type] != '' ){
				return $this->custom_fields_types[$type];
			}
			
			if( ! $value = get_post_meta( $post->ID, $field['field_name'], true ) ){
				$value = !empty($field['default_value']) ? $field['default_value'] : '';
			}
			if( $jd = @json_decode($value, true) ){
				$value = $jd;
			}
			
			$desc = !empty($field['desc']) ? trim($field['desc']) : '';
			$input = '<p><label for="'.$field['id'].'" class="label">'.$field['title'].'</label></p>';
			if( $desc != '' ){
				$input .= '<p class="cf-desc">' .$desc. '</p>';
			}
			
			switch($type){
				case 'input-text':
					$input .= '<input type="text" id="'.$field['id'].'" class="input-text'.( !empty($field['required']) ? ' required-field' : '' ).'" style="'.$field['style'].'" name="'.$field['field_name'].'" value="'. esc_attr($value) .'"  />';
					
					$input = apply_filters('cf_input_text', $input, $field);
					break;
					
				case 'input-number':
					$input .= '<input type="number" id="'.$field['id'].'" class="input-number'.( !empty($field['required']) ? ' required-field' : '' ).'" style="'.$field['style'].'" name="'.$field['field_name'].'" value="'. esc_attr($value) .'"';
					if( isset($field['min']) ) $input .= 'min="'.abs($field['min']).'"';
					if( isset($field['max']) ) $input .= 'max="'.abs($field['max']).'"';
					$input .= ' step="any" />';
					
					$input = apply_filters('cf_input_number', $input, $field);
					break;
					
				case 'input-checkbox':
					foreach((array)$field['values'] as $v => $label){
						$input .= '<label for="'.$field['id'].'-'.$v.'">';
						$input .= '<input type="checkbox" id="'.$field['id'].'-'.$v.'" class="input-checkbox" style="'.$field['style'].'" name="'.$field['field_name'].'" value="'. esc_attr($v) .'" '.( in_array($v, (array)$value) ? 'checked' : '').' />';
						$input .= $label.'</label><br/>';
					}
					
					$input = apply_filters('cf_input_checkbox', $input, $field);
					break;
					
				case 'input-radio':
					foreach((array)$field['values'] as $v => $label){
						$input .= '<label for="'.$field['id'].'-'.$v.'">';
						$input .= '<input type="radio" id="'.$field['id'].'-'.$v.'" class="input-radio" style="'.$field['style'].'" name="'.$field['field_name'].'" value="'. esc_attr($v) .'" '.( in_array($v, (array)$value) ? 'checked' : '').' />';
						$input .= $label.'</label><br/>';
					}
					
					$input = apply_filters('cf_input_radio', $input, $field);
					break;
					
				case 'input-file':
					$input .= '<input type="file" id="'.$field['id'].'" class="input-file hidden'.( !empty($field['required']) ? ' required-field' : '' ).'" style="'.$field['style'].'" name="'.$field['field_name'].'" value="" />';
					$input .= '<a href="javascript://" class="button" onclick="alert(1)" style="width: auto">'.__('Add file', 'ruby').'</a>';
					
					$input = apply_filters('cf_input_file', $input, $field);
					break;
					
				case 'input-hidden':
					$input .= '<input type="hidden" id="'.$field['id'].'" name="'.$field['field_name'].'" value="'. esc_attr($value) .'" />';
					
					$input = apply_filters('cf_input_hidden', $input, $field);
					break;
					
				case 'select-box':
					$input .= '<select id="'.$field['id'].'" class="input-select" name="'.$field['field_name'].'">';
					foreach((array)$field['options'] as $v => $label){
						$input .= '<option value="'. esc_attr($v) .'"'.( in_array($v, (array)$value) ? 'selected' : '').'>'.$label.'</option>';
					}
					$input .=  '</select>';
					
					$input = apply_filters('cf_select_box', $input, $field);
					break;
					
				case 'textarea':
					$input .= '<textarea id="'.$field['id'].'" name="'.$field['field_name'].'" class="textarea" style="padding: 10px"';
					if( !empty($field['rows']) ) $input .= ' rows="'.abs($field['rows']).'"';
					if( !empty($field['cols']) ) $input .= ' cols="'.abs($field['cols']).'"';
					$input .= '>'. esc_textarea($value) .'</textarea>';
					
					$input = apply_filters('cf_input_textarea', $input, $field);
					break;
				case 'date-picker':
					$input .= '<input type="text" id="'.$field['id'].'" class="input-text date-picker '.( $field['required'] ? ' required-field' : '' ).'" style="'.$field['style'].'" name="'.$field['field_name'].'" value="'. esc_attr($value) .'" />';
					
					$input = apply_filters('cf_input_datepicker', $input, $field);
					
					if( empty($this->scripts) ){
						$this->scripts = array();
					}
					$this->scripts[] = '$("#'.$field['id'].'").datepicker({ dateFormat: "dd-mm-yy" });';
					break;
				default:
					$input = '';
			}
			
			return $input;
		}
		
		return '';
	}
	
	public function enqueue_script_inline(){
		if( !empty($this->scripts) ){
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					<?php echo implode("\n", (array)$this->scripts) ?>
				});
			</script>
			<?php
		}
	}
	
	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	function save_cf_data( $post_id ) { 
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */
	
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
	
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
	
		} else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}
		
		$meta_keys = k2t_teacher_array_values_deep($this->custom_fields, 'field_name');
		foreach($meta_keys as $mkey){
			if( !isset($_POST[$mkey]) ){
				continue;
			}
			
			if( is_array($_POST[$mkey]) ){
				$_POST[$mkey] = json_encode($_POST[$mkey]);
			}
			else{
				$_POST[$mkey] = sanitize_text_field($_POST[$mkey]);
			}
			
			update_post_meta($post_id, $mkey, $_POST[$mkey]);
		}
	}
	
}