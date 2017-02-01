<?php
if( function_exists('register_field_group') ):

register_field_group(array (
	'key' => 'group_54227be67e229',
	'title' => 'Project Options',
	'fields' => array (
		array (
			'key' => 'field_54227be6907e9',
			'label' => __('Project Layout', 'k2t'),
			'name' => '',
			'prefix' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'placement' 		=> 'left',
		),
		array (
			'key' => 'field_5437e5160b139',
			'label' => __('Project sidebar content', 'k2t'),
			'name' => 'project_sidebar_content',
			'prefix' => '',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'choices' => array (
				'show' => 'True',
				'hided' => 'False',
			),
			'default_value' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'disabled' => 0,
			'readonly' => 0,
			'conditional_logic' => 0,
		),
		array (
			'key' => 'field_54227be690889',
			'label' => __('Project information', 'k2t'),
			'name' => '',
			'prefix' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'placement' 		=> 'left',
		),
		array (
			'key' => 'field_54227ccb3b6d9',
			'label' => __('Project size', 'k2t'),
			'name' => 'project_size',
			'prefix' => '',
			'type' => 'select',
			'instructions' => __('Only support Masonry Free Style', 'k2t'),
			'required' => 0,
			'conditional_logic' => 0,
			'choices' => array (
				'small' => __('Small', 'k2t'),
				'vertical' => __('Horizontal', 'k2t'),
				'horizontal' => __('Vertical', 'k2t'),
				'big' => __('Big', 'k2t'),
			),
			'default_value' => array (
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
			'key' => 'field_55c079fd3d507',
			'label' => __('Project member', 'k2t'),
			'name' => 'project_member',
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
				0 => 'post-k-teacher',
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 1,
			'return_format' => 'object',
			'ui' => 1,
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
		array (
			'key' => 'field_54227de93b6e9',
			'label' => __('Show/Hide meta', 'k2t'),
			'name' => 'single_display_meta',
			'prefix' => '',
			'type' => 'select',
			'instructions' => __('Meta will be shown or not in single project', 'k2t'),
			'required' => 0,
			'conditional_logic' => 0,
			'choices' => array (
				'show' => 'Show',
				'hided' => 'Hide',
			),
			'default_value' => array (
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
			'key' => 'field_54227ce43b6d9',
			'label' => __('Meta client', 'k2t'),
			'name' => 'project_client',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_54227de93b6e9',
						'operator' => '==',
						'value'    => 'show',
					),
				),
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
			'key' => 'field_54227cf23b6d9',
			'label' => __('Meta Work', 'k2t'),
			'name' => 'project_work',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_54227de93b6e9',
						'operator' => '==',
						'value'    => 'show',
					),
				),
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
			'key' => 'field_54227d053b6d9',
			'label' => __('Meta Start Date', 'k2t'),
			'name' => 'project_start_date',
			'prefix' => '',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_54227de93b6e9',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'display_format' => 'F j, Y',
			'return_format' => 'F j, Y',
			'first_day' => 1,
		),
		array (
			'key' => 'field_54227d053b6e9',
			'label' => __('Meta End Date', 'k2t'),
			'name' => 'project_end_date',
			'prefix' => '',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_54227de93b6e9',
						'operator' => '==',
						'value'    => 'show',
					),
				),
			),
			'display_format' => 'F j, Y',
			'return_format' => 'F j, Y',
			'first_day' => 1,
		),
		array (
			'key' => 'field_54227d443b6d9',
			'label' => __('Meta Website', 'k2t'),
			'name' => 'project_website',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_54227de93b6e9',
						'operator' => '==',
						'value'    => 'show',
					),
				),
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
			'key' => 'field_54227d4f3b6f9',
			'label' => __('Meta Website Link', 'k2t'),
			'name' => 'project_website_link',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_54227de93b6e9',
						'operator' => '==',
						'value'    => 'show',
					),
				),
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
			'key' => 'field_54227d2b3b6d9',
			'label' => __('Meta text link button', 'k2t'),
			'name' => 'project_text_link',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_54227de93b6e9',
						'operator' => '==',
						'value'    => 'show',
					),
				),
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
			'key' => 'field_54227d373b6d9',
			'label' => __('Meta link button', 'k2t'),
			'name' => 'project_link',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					'rule_rule_rule_rule_0' => array(
						'field'    => 'field_54227de93b6e9',
						'operator' => '==',
						'value'    => 'show',
					),
				),
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
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post-k-project',
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
?>