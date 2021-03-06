<?php 
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_55acc8d4c8b5f',
	'title' => 'Course settings',
	'fields' => array (
		array(
			'key'               => 'field_53df41c5593c3',
			'label'             => __('Course Layout', 'k2t'),
			'name'              => '',
			'prefix'            => '',
			'type'              => 'tab',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'placement' 		=> 'left',
		),
		array(
			'key'               => 'field_53df40dd593a7',
			'label'             => __('Course layout', 'k2t'),
			'name'              => 'course_layout',
			'prefix'            => '',
			'type'              => 'select',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'choices' => array(
				'default'       => __('Default', 'k2t'),
				'right_sidebar' => __('Right Sidebar', 'k2t'),
				'left_sidebar'  => __('Left Sidebar', 'k2t'),
				'no_sidebar'    => __('No Sidebar', 'k2t'),
			),
			'default_value' => array(),
			'allow_null'    => 0,
			'multiple'      => 0,
			'ui'            => 0,
			'ajax'          => 0,
			'placeholder'   => '',
			'disabled'      => 0,
			'readonly'      => 0,
		),
		array(
			'key'               => 'field_53df4176c939b',
			'label'             => __('Custom sidebar name', 'k2t'),
			'name'              => 'course_custom_sidebar',
			'prefix'            => '',
			'type'              => 'text',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'default_value'     => '',
			'placeholder'       => '',
			'prepend'           => '',
			'prepend'           => '',
			'maxlength'         => '',
			'readonly'          => 0,
			'disabled'          => 0,
		),
		array (
			'key' => 'field_55baea6451c2a',
			'label' => __('Course information', 'k2t'),
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
		),
		array (
			'key' => 'field_55baea8551c2b',
			'label' => __('Start date', 'k2t'),
			'name' => 'course_start_date',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'd/m/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
		array (
			'key' => 'field_55baea9751c2c',
			'label' => __('Course ID', 'k2t'),
			'name' => 'course_id',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55baeab351c2d',
			'label' => __('Product', 'k2t'),
			'name' => 'course_product',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'product',
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 1,
			'return_format' => 'object',
			'ui' => 1,
		),
		array (
			'key' => 'field_55baeb3251c2e',
			'label' => __('Address', 'k2t'),
			'name' => 'course_address',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55baeb5d51c2f',
			'label' => __('Duration', 'k2t'),
			'name' => 'course_duration',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55bf8f6e7f3ef',
			'label' => __('Who are instructors?', 'k2t'),
			'name' => 'course_who_is_speakers',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'teacher' => __('Teacher', 'k2t'),
				'out_school' => __('Out School', 'k2t'),
			),
			'default_value' => array (
				'' => '',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'disabled' => 0,
			'readonly' => 0,
		),
		array (
			'key' => 'field_55bf8fd97f3f0',
			'label' => __('Teacher', 'k2t'),
			'name' => 'course_teacher',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_55bf8f6e7f3ef',
						'operator' => '==',
						'value' => 'teacher',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'post-k-teacher',
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 1,
			'return_format' => 'object',
			'ui' => 1,
		),
		array (
			'key' => 'field_55baeb6551c30',
			'label' => __('Speakers', 'k2t'),
			'name' => 'course_speakers',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_55bf8f6e7f3ef',
						'operator' => '==',
						'value' => 'out_school',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Row',
			'sub_fields' => array (
				array (
					'key' => 'field_55baebb5b6a34',
					'label' => __('Avatar', 'k2t'),
					'name' => 'course_speaker_avatar',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array (
					'key' => 'field_55baebcfb6a35',
					'label' => __('Name', 'k2t'),
					'name' => 'course_speaker_name',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_55baebe1b6a36',
					'label' => __('Role', 'k2t'),
					'name' => 'course_speaker_role',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
			),
		),
		array (
			'key' => 'field_55baec0fb6a38',
			'label' => __('Subscribe URL', 'k2t'),
			'name' => 'course_subscribe_url',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55baec1fb6a39',
			'label' => __('Subscribe Button Text', 'k2t'),
			'name' => 'course_subscribe_button_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55cc5d9f666df',
			'label' => __('Download', 'k2t'),
			'name' => 'course_download',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Row',
			'sub_fields' => array (
				array (
					'key' => 'field_55cc5db7666e0',
					'label' => __('Download text', 'k2t'),
					'name' => 'course_download_text',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_55cc5dc8666e1',
					'label' => __('Download link', 'k2t'),
					'name' => 'course_download_link',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
			),
		),
		array(
			'key'               => 'field_53fey96493014',
			'label'             => __('Course Titlebar', 'k2t'),
			'name'              => '',
			'prefix'            => '',
			'type'              => 'tab',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'placement' 		=> 'left',
		),
		array(
			'key'               => 'field_53fd4b60de834',
			'label'             => __('Show/Hide Title Bar', 'k2t'),
			'name'              => 'course_display_titlebar',
			'prefix'            => '',
			'type'              => 'select',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'choices' => array(
				'show'  => 'Show',
				'hided' => 'Hide',
			),
			'default_value' => 'show',
			'allow_null'    => 0,
			'multiple'      => 0,
			'ui'            => 0,
			'ajax'          => 0,
			'placeholder'   => '',
			'disabled'      => 0,
			'readonly'      => 0,
		),

		array(
			'key' => 'field_57adb2409979441',
			'label' => __('Show/Hide Date', 'k2t'),
			'name' => 'show_hide_date',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes'  => __('Yes','k2t'),
				'no' => __('No','k2t'),
				),
			'default_value' => array(),
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),

		array(
			'key' => 'field_57ds3adb2409979441',
			'label' => __('Show/Hide Author', 'k2t'),
			'name' => 'show_hide_author',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes'  => __('Yes','k2t'),
				'no' => __('No','k2t'),
			),
			'default_value' => array(),
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		
		array(
			'key'               => 'field_542e57d79ab06',
			'label'             => __('Course titlebar font size', 'k2t'),
			'name'              => 'course_titlebar_font_size',
			'prefix'            => '',
			'type'              => 'text',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'default_value'     => '',
			'placeholder'       => '',
			'prepend'           => '',
			'prepend'           => '',
			'maxlength'         => '',
			'readonly'          => 0,
			'disabled'          => 0,
		),
		array(
			'key'               => 'field_53fftwwt93019',
			'label'             => __('Course title bar color', 'k2t'),
			'name'              => 'course_titlebar_color',
			'prefix'            => '',
			'type'              => 'color_picker',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'default_value'     => '',
		),
		array(
			'key'               => 'field_53feec3fa3016',
			'label'             => __('Padding top', 'k2t'),
			'name'              => 'course_pading_top',
			'prefix'            => '',
			'type'              => 'text',
			'instructions'      => 'Unit: px (Ex: 10px)',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				)
			),
			'default_value'     => '',
			'placeholder'       => '',
			'prepend'           => '',
			'prepend'           => '',
			'maxlength'         => '',
			'readonly'          => 0,
			'disabled'          => 0,
		),
		array(
			'key'               => 'field_53feac3f93127',
			'label'             => __('Padding bottom', 'k2t'),
			'name'              => 'course_pading_bottom',
			'prefix'            => '',
			'type'              => 'text',
			'instructions'      => 'Unit: px (Ex: 10px)',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				)
			),
			'default_value'     => '',
			'placeholder'       => '',
			'prepend'           => '',
			'prepend'           => '',
			'maxlength'         => '',
			'readonly'          => 0,
			'disabled'          => 0,
		),
		array(
			'key'               => 'field_53feeced93019',
			'label'             => __('Background color', 'k2t'),
			'name'              => 'course_background_color',
			'prefix'            => '',
			'type'              => 'color_picker',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'default_value'     => '',
		),
		array(
			'key'               => 'field_53feecb29d018',
			'label'             => __('Background image', 'k2t'),
			'name'              => 'course_background_image',
			'prefix'            => '',
			'type'              => 'image',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'return_format' 	=> 'url',
			'preview_size'      => 'thumbnail',
			'library'           => 'all',
		),
		array(
			'key'               => 'field_53feeda19301b',
			'label'             => __('Background position', 'k2t'),
			'name'              => 'course_background_position',
			'prefix'            => '',
			'type'              => 'select',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'choices' => array(
				''      		=> __('None', 'k2t'),
				'left top'      => __('Left Top', 'k2t'),
				'left center'   => __('Left Center', 'k2t'),
				'left bottom'   => __('Left Bottom', 'k2t'),
				'right top'     => __('Right Top', 'k2t'),
				'right center'  => __('Right Center', 'k2t'),
				'right bottom'  => __('Right Bottom', 'k2t'),
				'center top'    => __('Center top', 'k2t'),
				'center center' => __('Center Center', 'k2t'),
				'center bottom' => __('Center Bottom', 'k2t'),
			),
			'default_value' => array(),
			'allow_null'    => 0,
			'multiple'      => 0,
			'ui'            => 0,
			'ajax'          => 0,
			'placeholder'   => '',
			'disabled'      => 0,
			'readonly'      => 0,
		),
		array(
			'key'               => 'field_53fui1a09367b',
			'label'             => __('Background size', 'k2t'),
			'name'              => 'course_background_size',
			'prefix'            => '',
			'type'              => 'select',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'choices' => array(
				''		  => 'None',
				'inherit' => 'Inherit',
				'cover'   => 'Cover',
				'contain' => 'Contain',
				'full'    => '100%',
			),
			'default_value' => array(),
			'allow_null'    => 0,
			'multiple'      => 0,
			'ui'            => 0,
			'ajax'          => 0,
			'placeholder'   => '',
			'disabled'      => 0,
			'readonly'      => 0,
		),
		array(
			'key'               => 'field_52rkuda09301b',
			'label'             => __('Background repeat', 'k2t'),
			'name'              => 'course_background_repeat',
			'prefix'            => '',
			'type'              => 'select',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'choices' => array(
				''		  	=> 'None',
				'no-repeat' => 'No Repeat',
				'repeat'    => 'Repeat',
				'repeat-x'  => 'Repeat X',
				'repeat-y'  => 'Repeat Y',
			),
			'default_value' => 'repeat',
			'allow_null'    => 0,
			'multiple'      => 0,
			'ui'            => 0,
			'ajax'          => 0,
			'placeholder'   => '',
			'disabled'      => 0,
			'readonly'      => 0,
		),
		array(
			'key'               => 'field_543363k1939f7',
			'label'             => __('Background parallax', 'k2t'),
			'name'              => 'course_background_parallax',
			'prefix'            => '',
			'type'              => 'select',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'choices' => array(
				'1' => 'True',
				'0' => 'False',
			),
			'default_value' => array(),
			'allow_null'    => 0,
			'multiple'      => 0,
			'ui'            => 0,
			'ajax'          => 0,
			'placeholder'   => '',
			'disabled'      => 0,
			'readonly'      => 0,
		),
		array(
			'key'               => 'field_53fef060930j0',
			'label'             => __('Titlebar overlay opacity', 'k2t'),
			'name'              => 'course_titlebar_overlay_opacity',
			'prefix'            => '',
			'type'              => 'select',
			'instructions'      => 'Set your overlay opacity in titlebar',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'choices' => array(
				0   => 0,
				1 	=> 1,
				2 	=> 2,
				3 	=> 3,
				4 	=> 4,
				5 	=> 5,
				6 	=> 6,
				7 	=> 7,
				8 	=> 8,
				9 	=> 9,
				10  => 10,
			),
			'default_value' => array(),
			'allow_null'    => 0,
			'multiple'      => 0,
			'ui'            => 0,
			'ajax'          => 0,
			'placeholder'   => '',
			'disabled'      => 0,
			'readonly'      => 0,
		),
		array(
			'key'               => 'field_53fef07ch3021',
			'label'             => __('Titlebar clipmask opacity', 'k2t'),
			'name'              => 'course_titlebar_clipmask_opacity',
			'prefix'            => '',
			'type'              => 'select',
			'instructions'      => 'Set your clipmask opacity in titlebar',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'choices' => array(
				0   => 0,
				1 	=> 1,
				2 	=> 2,
				3 	=> 3,
				4 	=> 4,
				5 	=> 5,
				6 	=> 6,
				7 	=> 7,
				8 	=> 8,
				9 	=> 9,
				10  => 10,
			),
			'default_value' => array(),
			'allow_null'    => 0,
			'multiple'      => 0,
			'ui'            => 0,
			'ajax'          => 0,
			'placeholder'   => '',
			'disabled'      => 0,
			'readonly'      => 0,
		),
		array(
			'key'               => 'field_53fef0eb93tr3',
			'label'             => __('Custom titlebar content', 'k2t'),
			'name'              => 'course_titlebar_custom_content',
			'prefix'            => '',
			'type'              => 'wysiwyg',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_53fd4b60de834',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'default_value'     => '',
			'tabs'              => 'all',
			'toolbar'           => 'full',
			'media_upload'      => 1,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post-k-course',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

endif;