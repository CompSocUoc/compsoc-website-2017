<?php

global $GLOBALS;

// Disable some theme options by id if not required
if( ! function_exists( 'k2t_disable_of_options' ) ){
	function k2t_disable_of_options($options = array()){
		global $of_options, $of_options_disable;
		$of_options_disable = array(
		);
		
		if( !empty($options) ){
			$options =& $of_options;
		}
		
		foreach( $of_options_disable as $op_id ){
			if( is_string( $op_id ) && isset( $of_options[$op_id] ) ){
				$of_options[$op_id]['disable'] = true;
			}
		}
		
		return $options;
	}
	
	add_filter('optionsframework_machine_before', 'k2t_disable_of_options');
}

if ( ! function_exists( 'k2t_render_titlebar_options' ) ) {
	function k2t_render_titlebar_options( $pre, $of_options ) {
		/* Titlebar */
		$of_options[] = array( 'name' => __( 'Titlebar', 'k2t' ),
			'type' => 'info',
			'std'  => __( 'Titlebar', 'k2t' ),
		);

		$of_options[] = array( 'name' => __( 'Show / Hide titlebar', 'k2t' ),
			'type' => 'switch',
			'std'  => true,
			'id'   => $pre . '-display-titlebar',
			'k2t_logictic' => array(
				'0' => array( ),
				'1' => array(  $pre . '-titlebar-font-size', $pre . '-titlebar-color', $pre . '-pading-top', $pre . '-pading-bottom', $pre . '-background-color', $pre . '-background-image', $pre . '-background-position', $pre . '-background-size', $pre . '-background-repeat', $pre . '-background-parallax', $pre . '-titlebar-overlay-opacity', $pre . '-titlebar-clipmask-opacity', $pre . '-titlebar-custom-content',  ),
			),
		);

		$of_options[] = array( 'name' => __( 'Titlebar title font size', 'k2t' ),
			'type' => 'text',
			'std'  => '',
			'id'   => $pre . '-titlebar-font-size',
			'desc' => __( 'Unit: px.', 'k2t' ),
		);

		$of_options[] = array( 'name' => __( 'Titlebar title color', 'k2t' ),
			'type' => 'color',
			'std'  => '',
			'id'   => $pre . '-titlebar-color',
		);

		$of_options[] = array( 'name' => __( 'Padding top', 'k2t' ),
			'type' => 'text',
			'std'  => '',
			'id'   => $pre . '-pading-top',
			'desc' => __( 'Unit: px. Eg: 10px;', 'k2t' ),
		);

		$of_options[] = array( 'name' => __( 'Padding bottom', 'k2t' ),
			'type' => 'text',
			'std'  => '',
			'id'   => $pre . '-pading-bottom',
			'desc' => __( 'Unit: px. Eg: 10px;', 'k2t' ),
		);

		$of_options[] = array( 'name' => __( 'Background color', 'k2t' ),
			'type' => 'color',
			'std'  => '',
			'id'   => $pre . '-background-color',
		);

		$of_options[] = array( 'name' => __( 'Background image', 'k2t' ),
			'type' => 'media',
			'std'  => '',
			'id'   => $pre . '-background-image',
		);

		$of_options[] = array( 'name' => __( 'Background position', 'k2t' ),
			'type' => 'select',
			'std'  => 'left',
			'options' => array(
				'left top'      => __( 'Left Top', 'k2t' ),
				'left center'   => __( 'Left Center', 'k2t' ),
				'left bottom'   => __( 'Left Bottom', 'k2t' ),
				'right top'     => __( 'Right Top', 'k2t' ),
				'right center'  => __( 'Right Center', 'k2t' ),
				'right bottom'  => __( 'Right Bottom', 'k2t' ),
				'center top'    => __( 'Center Top', 'k2t' ),
				'center center' => __( 'Center Center', 'k2t' ),
				'center bottom' => __( 'Center Bottom', 'k2t' ),
			),
			'id'   => $pre . '-background-position',
		);

		$of_options[] = array( 'name' => __( 'Background size', 'k2t' ),
			'type' => 'select',
			'std'  => 'inherit',
			'options' => array(
				'inherit' 		=> __( 'Inherit', 'k2t' ),
				'cover'    		=> __( 'Cover', 'k2t' ),
				'contain'  		=> __( 'Contain', 'k2t' ),
				'full'  		=> __( '100%', 'k2t' ),
			),
			'id'   => $pre . '-background-size',
		);

		$of_options[] = array( 'name' => __( 'Background repeat', 'k2t' ),
			'type' => 'select',
			'std'  => 'repeat',
			'options' => array(
				'no-repeat' => __( 'No Repeat', 'k2t' ),
				'repeat'    => __( 'Repeat', 'k2t' ),
				'repeat-x'  => __( 'Repeat X', 'k2t' ),
				'repeat-y'  => __( 'Repeat Y', 'k2t' ),
			),
			'id'   => $pre . '-background-repeat',
		);

		$of_options[] = array( 'name' => __( 'Background parallax', 'k2t' ),
			'type' => 'switch',
			'std'  => false,
			'id'   => $pre . '-background-parallax',
		);

		$of_options[] = array( 'name' => __( 'Titlebar overlay opacity', 'k2t' ),
			'type' => 'sliderui',
			'min'  => 0,
			'max'  => 10,
			'std'  => 0,
			'step' => 1,
			'id'   => $pre . '-titlebar-overlay-opacity',
		);

		$of_options[] = array( 'name' => __( 'Titlebar clipmask opacity', 'k2t' ),
			'type' => 'sliderui',
			'min'  => 0,
			'max'  => 10,
			'std'  => 0,
			'step' => 1,
			'id'   => $pre . '-titlebar-clipmask-opacity',
		);

		$of_options[] = array( 'name' => __( 'Titlebar custom content', 'k2t' ),
			'type' => 'textarea',
			'std'  => '',
			'id'   => $pre . '-titlebar-custom-content',
		);
		return $of_options;
	}
}


// Social Share Function
if ( ! function_exists( 'k2t_social_share_options' ) ) {
	function k2t_social_share_options( $pre, $of_options ) {
		/* Titlebar */
		$of_options[] = array( 'name' => __( 'Show Facebook Share', 'k2t' ),
			'type' => 'switch',
			'std'  => true,
			'id'   => $pre . '-social-share-facebook',
		);
		$of_options[] = array( 'name' => __( 'Show Twitter Share', 'k2t' ),
			'type' => 'switch',
			'std'  => true,
			'id'   => $pre . '-social-share-twitter',
		);
		$of_options[] = array( 'name' => __( 'Show Google Plus Share', 'k2t' ),
			'type' => 'switch',
			'std'  => true,
			'id'   => $pre . '-social-share-google',
		);
		$of_options[] = array( 'name' => __( 'Show Linkedin Share', 'k2t' ),
			'type' => 'switch',
			'std'  => true,
			'id'   => $pre . '-social-share-linkedin',
		);
		$of_options[] = array( 'name' => __( 'Show Tumblr Share', 'k2t' ),
			'type' => 'switch',
			'std'  => true,
			'id'   => $pre . '-social-share-tumblr',
		);
		$of_options[] = array( 'name' => __( 'Show Email Share', 'k2t' ),
			'type' => 'switch',
			'std'  => true,
			'id'   => $pre . '-social-share-email',
		);
		return $of_options;
	}
}



// Add some theme options if needs
if( ! function_exists('k2t_add_of_options') ){
	function k2t_add_of_options($options = array()){
		$add_options = array(
			// option array to add here
		);
		
		foreach($add_options as $option){
			if( !empty($option['id']) && !isset($options[$option['id']]) )
				$options[$option['id']] = $option;
			else{
				$options[] = $option;
			}
		}

		return $options;
	}
	
	add_filter('optionsframework_machine_before', 'k2t_add_of_options', 9);
}

//================= Register theme option's fields =======================

/*-----------------------------------------------------------------------------------*/
/* General */
/*-----------------------------------------------------------------------------------*/

$of_options = array(
	array( 'name' => __( 'General', 'k2t' ),
		'type' => 'heading',
		'icon' => '<i class="zmdi zmdi-settings"></i>',
	)
);

$of_options[] = array( 'name' => __( 'General', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'General', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Show/Hide breadcrumb', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'breadcrumb',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Show/Hide page loader', 'k2t' ),
	'type' => 'switch',
	'std'  => false,
	'id'   => 'pageloader',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Show/Hide ":::"', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'show_hide_dot',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Show/Hide place holder', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'place_holder',
	'desc' => '',
);
$of_options[] = array( 'name' => __( 'Show/Hide Right To Left Language', 'k2t' ),
	'type' => 'switch',
	'std'  => false,
	'id'   => 'rtl_lang',
	'desc' => '',
);

$of_options[] = array( 'name' => esc_html__( 'API Key', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'key_map',
	'desc' => esc_html__( 'Please enter Google Map API Key for Contact page', 'k2t' ),
);

// change logo for default login page
$of_options[] = array( 'name' => __( 'Logo For Default Login Page', 'k2t' ),
	'type' => 'media',
	'id'   => 'login_logo',
	'std'  => '',
	'desc' => __( 'The logo size in our demo is 116x33px. Please use jpg, jpeg, png or gif image for best performance.', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Sidebar width', 'k2t' ),
	'type' => 'sliderui',
	'id'   => 'sidebar_width',
	'min'  => 0,
	'max'  => 100,
	'step' => 1,
	'std'  => 25,
	'desc' => __( 'Unit: %', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Header Code', 'k2t' ),
	'type' => 'textarea',
	'std'  => '',
	'id'   => 'header_code',
	'desc' => __( 'You can load Google fonts here.', 'k2t' ),
	'is_js_editor' => '1'
);

$of_options[] = array( 'name' => __( 'Footer Code', 'k2t' ),
	'type' => 'textarea',
	'std'  => '',
	'id'   => 'footer_code',
	'desc' => __( 'You can fill Google Analytics tracking code or something here.', 'k2t' ),
	'is_js_editor' => '1'
);

$of_options[] = array( 'name' => __( 'Custom CSS', 'k2t' ),
	'type' => 'textarea',
	'std'  => '',
	'id'   => 'custom_css',
	'desc' => __( 'If you know a little about CSS, you can write your custom CSS here. Do not edit CSS files (it will be lost when you update this theme).', 'k2t' ),
	'is_css_editor' => '1'
);

/* Icons */
$of_options[] = array( 'name' => __( 'Icons', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Icons', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Favicon', 'k2t' ),
	'type' => 'media',
	'id'   => 'favicon',
	'std'  => get_template_directory_uri() . '/assets/img/icons/favicon.png',
	'desc' => __( 'Favicon is a small icon image at the topbar of your browser. Should be 16x16px or 32x32px image (png, ico...)', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'IPhone icon (57x57px)', 'k2t' ),
	'type' => 'media',
	'id'   => 'apple-iphone-icon',
	'std'  => get_template_directory_uri() . '/assets/img/icons/iphone.png',
	'desc' => __( 'Similar to the Favicon, the <strong> iPhone icon</strong> is a file used for a web page icon on the  iPhone. When someone bookmarks your web page or adds your web page to their home screen, this icon is used. If this file is not found, these  products will use the screen shot of the web page, which often looks like no more than a white square.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'IPhone retina icon (114x114px)', 'k2t' ),
	'type' => 'media',
	'id'   => 'apple-iphone-retina-icon',
	'std'  => get_template_directory_uri() . '/assets/img/icons/iphone@2x.png',
	'desc' => __( 'The same as  iPhone icon but for Retina iPhone.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'IPad icon (72x72px)', 'k2t' ),
	'type' => 'media',
	'id'   => 'apple-ipad-icon',
	'std'  => get_template_directory_uri() . '/assets/img/icons/ipad.png',
	'desc' => __( 'The same as  iPhone icon but for iPad.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'IPad Retina icon (144x144px)', 'k2t' ),
	'type' => 'media',
	'id'   => 'apple-ipad-retina-icon',
	'std'  => get_template_directory_uri() . '/assets/img/icons/ipad@2x.png',
	'desc' => __( 'The same as  iPhone icon but for Retina iPad.', 'k2t' ),
);

/*-----------------------------------------------------------------------------------*/
/* Header
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Header', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-border-top"></i>'
);
/* Header */
$of_options[] = array( 'name' => __( 'Header Backup Options', 'k2t' ),
	'type' => 'advance_importer',
	'std'  => __( 'Header Backup Options', 'k2t' ),
	'desc' => 'Import or Export Header layouts for all Header sections',
	'id' => 'header-advance-import',
	'advance_importer' => array( 'sticky-menu' , 'vertical-menu', 'fixed-header' , 'full-header' , 'use-top-header' , 'header_section_1' , 'use-mid-header' , 'header_section_2' , 'use-bot-header' , 'header_section_3' )
);
/* Header */
$of_options[] = array( 'name' => __( 'Header Settings', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Header Settings', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Sticky menu?', 'k2t' ),
	'type' => 'select',
	'options' => array(
		''        => __( 'None', 'k2t' ),
		'sticky_top' => __( 'Sticky menu on top header', 'k2t' ),
		'sticky_mid' => __( 'Sticky menu on middle header', 'k2t' ),
		'sticky_bot' => __( 'Sticky menu on bottom header', 'k2t' ),
	),
	'std'  => '',
	'id'   => 'sticky-menu',
	'desc' => __( 'Enable this setting so that the header section and menus inlcuded in the header are sticky', 'k2t' ),

);		

$of_options[] = array(  'name' => __( 'Smart sticky menu', 'k2t' ),
	'type' => 'switch',
	'std'  => false,
	'id'   => 'smart-sticky',
	'desc' => __( 'Turn ON to enable sticky menu, it will always stay in your page when scrolling to top and disappear when scrolling down.', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Header Layouts', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Header Layouts', 'k2t' ),
);

$of_options[] = array(  'name' => __( 'Fullwidth header layout', 'k2t' ),
	'type' => 'switch',
	'std'  => false,
	'id'   => 'full-header',
	'desc' => __( 'Turn it ON if you want to set full width header.', 'k2t' ),
);
/* Visual Header */
$of_options[] = array( 'name' => __( 'Top Header Section', 'k2t' ),
	'type' => 'switch',
	'std'  => false,
	'id'   => 'use-top-header',
	'desc' => __( 'Show or hide top header layout.', 'k2t' ),
	'k2t_logictic' => array(
		'0' => array( ),
		'1' => array( 'header_section_1' ),
	),			
);

$of_options[] = array(
	'type' => 'k2t_header_option',
	'std'  => '',
	'id'   => 'header_section_1',
	'desc' => '',
	
);

$of_options[] = array( 'name' => __( 'Middle Header Section', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'use-mid-header',
	'desc' => __( 'Show or hide middle header layout.', 'k2t' ),
	'k2t_logictic' => array(
		'0' => array( ),
		'1' => array( 'header_section_2' ),

	),		
);

$of_options[] = array(
	'type' => 'k2t_header_option',
	'std'  => '{"name":"header_section_2","setting":{"bg_image":"","bg_color":"","opacity":"","fixed_abs":"fixed","custom_css":""},"columns_num":2,"htmlData":"","columns":[{"id":1,"percent":"2","value":[{"id":"1425696862388","type":"logo","value":{"custom_class":"","custom_id":""}}]},{"id":2,"value":[{"id":"1434273437540","type":"custom_menu","value":{"menu_id":"QWxsIFBhZ2Vz","custom_class":"","custom_id":""}}],"percent":"10"}]}',
	'id'   => 'header_section_2',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Bottom Header Section', 'k2t' ),
	'type' => 'switch',
	'std'  => false,
	'id'   => 'use-bot-header',
	'desc' => __( 'Show or hide middle header layout.', 'k2t' ),
	'k2t_logictic' => array(
		'0' => array( ),
		'1' => array( 'header_section_3' ),
	),		
);

$of_options[] = array(
	'type' => 'k2t_header_option',
	'std'  => '',
	'id'   => 'header_section_3',
	'desc' => '',
);

/* Logo */
$of_options[] = array( 'name' => __( 'Logo', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Logo', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Use text logo', 'k2t' ),
	'type' => 'switch',
	'std'  => false,
	'id'   => 'use-text-logo',
	'desc' => __( 'Turn it ON if you want to use text logo instead of image logo.', 'k2t' ),
	'logicstic' => true,
);

$of_options[] = array( 'name' => __( 'Text logo', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'text-logo',
	'desc' => '',
	'conditional_logic' => array(
		'field'    => 'use-text-logo',
		'value'    => 'switch-1',
	),
);

$of_options[] = array( 'name' => __( 'Link HomePage', 'k2t' ),
	'type' => 'text',
	'id'   => 'link_homepage',	
	'desc' => __( 'Redirect to specific page from clicking Logo', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Logo', 'k2t' ),
	'type' => 'media',
	'id'   => 'logo',
	'std'  => get_template_directory_uri() . '/assets/img/logo.png',
	'desc' => __( 'The logo size in our demo is 116x33px. Please use jpg, jpeg, png or gif image for best performance.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Retina logo', 'k2t' ),
	'type' => 'media',
	'id'   => 'retina-logo',
	'std'  => get_template_directory_uri() . '/assets/img/logo@2x.png',
	'desc' => __( '2x times your logo dimension.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Logo margin top (px)', 'k2t' ),
	'type' => 'sliderui',
	'id'   => 'logo-margin-top',
	'min'  => 0,
	'max'  => 200,
	'step' => 1,
	'std'  => 25,
);

$of_options[] = array( 'name' => __( 'Logo margin right (px)', 'k2t' ),
	'type' => 'sliderui',
	'id'   => 'logo-margin-right',
	'min'  => 0,
	'max'  => 200,
	'step' => 1,
	'std'  => 0,
);

$of_options[] = array( 'name' => __( 'Logo margin bottom (px)', 'k2t' ),
	'type' => 'sliderui',
	'id'   => 'logo-margin-bottom',
	'min'  => 0,
	'max'  => 200,
	'step' => 1,
	'std'  => 25,
);

$of_options[] = array( 'name' => __( 'Logo margin left (px)', 'k2t' ),
	'type' => 'sliderui',
	'id'   => 'logo-margin-left',
	'min'  => 0,
	'max'  => 200,
	'step' => 1,
	'std'  => 0,
);

/*-----------------------------------------------------------------------------------*/
/* Footer
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Footer', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-border-bottom"></i>'
);

$of_options[] = array( 'name'   => __( 'Show/Hide "Go to top"', 'k2t' ),
	'id'   => 'footer-gototop',
	'type' => 'switch',
	'std'  => true,
);

/* Widget area */
$of_options[] = array( 'name' => __( 'Widget area', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Main Footer', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Sidebars layout', 'k2t' ),
	'type' => 'select',
	'id'   => 'bottom-sidebars-layout',
	'options' => array(
		'layout-1' => __( '1/4 1/4 1/4 1/4', 'k2t' ),
		'layout-2' => __( '1/3 1/3 1/3', 'k2t' ),
		'layout-3' => __( '1/2 1/4 1/4', 'k2t' ),
		'layout-4' => __( '1/4 1/2 1/4', 'k2t' ),
		'layout-5' => __( '1/4 1/4 1/2', 'k2t' ),
		'layout-6' => __( '1/2 1/2', 'k2t' ),
		'layout-7' => __( '1', 'k2t' ),
	),
	'std'  => 'layout-2',
	'desc' => __( 'Select sidebars layout', 'k2t' ),
);

$of_options[] = array( 'name'   => __( 'Background color', 'k2t' ),
	'id'   => 'bottom-background-color',
	'type' => 'color',
	'std'  => '',
);

$of_options[] = array( 'name'   => __( 'Background image', 'k2t' ),
	'id'   => 'bottom-background-image',
	'type' => 'upload',
	'std'  => '',
);

$of_options[] = array( 'name' => __( 'Background position?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		''    => __( 'None', 'k2t' ),
		'left top'      => __( 'Left Top', 'k2t' ),
		'left center'   => __( 'Left Center', 'k2t' ),
		'left bottom'   => __( 'Left Bottom', 'k2t' ),
		'right top'     => __( 'Right Top', 'k2t' ),
		'right center'  => __( 'Right Center', 'k2t' ),
		'right bottom'  => __( 'Right Bottom', 'k2t' ),
		'center top'    => __( 'Center Top', 'k2t' ),
		'center center' => __( 'Center Center', 'k2t' ),
		'center bottom' => __( 'Center Bottom', 'k2t' ),
	),
	'std'  => '',
	'id'   => 'bottom-background-position',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Background repeat?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		''    => __( 'None', 'k2t' ),
		'no-repeat' => __( 'No repeat', 'k2t' ),
		'repeat'    => __( 'Repeat', 'k2t' ),
		'repeat-x'  => __( 'Repeat X', 'k2t' ),
		'repeat-y'  => __( 'Repeat Y', 'k2t' ),
	),
	'std'  => '',
	'id'  => 'bottom-background-repeat',
	'desc'  => '',
);

$of_options[] = array( 'name' => __( 'Background size?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		''        => __( 'None', 'k2t' ),
		'auto'    => __( 'Auto', 'k2t' ),
		'cover'   => __( 'Cover', 'k2t' ),
		'contain' => __( 'Contain', 'k2t' ),
	),
	'std'  => '',
	'id'   => 'bottom-background-size',
	'desc' => '',
);

/* Footer bottom */
$of_options[] = array( 'name' => __( 'Footer', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Bottom Footer', 'k2t' ),
);

$of_options[] = array( 'name'   => __( 'Background color', 'k2t' ),
	'id'   => 'footer-background-color',
	'type' => 'color',
	'std'  => '',
);

$of_options[] = array( 'name'   => __( 'Background image', 'k2t' ),
	'id'   => 'footer-background-image',
	'type' => 'upload',
	'std'  => '',
);

$of_options[] = array( 'name' => __( 'Background position?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		''    => __( 'None', 'k2t' ),
		'left top'      => __( 'Left Top', 'k2t' ),
		'left center'   => __( 'Left Center', 'k2t' ),
		'left bottom'   => __( 'Left Bottom', 'k2t' ),
		'right top'     => __( 'Right Top', 'k2t' ),
		'right center'  => __( 'Right Center', 'k2t' ),
		'right bottom'  => __( 'Right Bottom', 'k2t' ),
		'center top'    => __( 'Center Top', 'k2t' ),
		'center center' => __( 'Center Center', 'k2t' ),
		'center bottom' => __( 'Center Bottom', 'k2t' ),
	),
	'std'  => '',
	'id'   => 'footer-background-position',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Background repeat?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		''    => __( 'None', 'k2t' ),
		'no-repeat' => __( 'No repeat', 'k2t' ),
		'repeat'    => __( 'Repeat', 'k2t' ),
		'repeat-x'  => __( 'Repeat X', 'k2t' ),
		'repeat-y'  => __( 'Repeat Y', 'k2t' ),
	),
	'std'  => '',
	'id'  => 'footer-background-repeat',
	'desc'  => '',
);

$of_options[] = array( 'name' => __( 'Background size?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		''        => __( 'None', 'k2t' ),
		'auto'    => __( 'Auto', 'k2t' ),
		'cover'   => __( 'Cover', 'k2t' ),
		'contain' => __( 'Contain', 'k2t' ),
	),
	'std'  => '',
	'id'   => 'footer-background-size',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Footer copyright text', 'k2t' ),
	'type' => 'textarea',
	'id'   => 'footer-copyright-text',
	'std'  => __( '© Copyright 2015. Powered by WordPress. Lincoln Theme by LUNARTHEME.', 'k2t' ),
	'desc' => __( 'HTML and shortcodes are allowed.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Show/Hide Footer Bottom Menu', 'k2t' ),
	'id'   => 'footer-bottom-menu',
	'type' => 'switch',
	'std'  => true,
);

/*-----------------------------------------------------------------------------------*/
/* Offcanvas sidebar
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Offcanvas sidebar', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-border-right"></i>'
);

$of_options[] = array( 'name'   => __( 'Show/Hide Offcanvas sidebar', 'k2t' ),
	'id'   => 'offcanvas-turnon',
	'type' => 'switch',
	'std'  => true,
);

$of_options[] = array( 'name' => __( 'Offcanvas sidebar position', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		'right'    => __( 'Right', 'k2t' ),
		'left'      => __( 'Left', 'k2t' ),
	),
	'std'  => '',
	'id'   => 'offcanvas-sidebar-position',
	'desc' => '',
);

// Get all sidebar
$sidebars = array();
$widget_list = wp_get_sidebars_widgets();
if ( count( $widget_list ) > 0 ){
	foreach ( $widget_list as $sidebar => $val ) {
		$sidebars[$sidebar] = $sidebar;
	}
}
$of_options[] = array( 'name' => __( 'Shown sidebar?', 'k2t' ),
	'type' => 'select',
	'options' => $sidebars,
	'id' => 'offcanvas-sidebar',
);

$of_options[] = array( 'name' => __( 'Background setting', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Background setting', 'k2t' ),
);

$of_options[] = array( 'name'   => __( 'Offcanvas sidebar background image', 'k2t' ),
	'id'   => 'offcanvas-sidebar-background-image',
	'type' => 'upload',
	'std'  => '',
);

$of_options[] = array( 'name' => __( 'Offcanvas sidebar background position?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		''    => __( 'None', 'k2t' ),
		'left top'      => __( 'Left Top', 'k2t' ),
		'left center'   => __( 'Left Center', 'k2t' ),
		'left bottom'   => __( 'Left Bottom', 'k2t' ),
		'right top'     => __( 'Right Top', 'k2t' ),
		'right center'  => __( 'Right Center', 'k2t' ),
		'right bottom'  => __( 'Right Bottom', 'k2t' ),
		'center top'    => __( 'Center Top', 'k2t' ),
		'center center' => __( 'Center Center', 'k2t' ),
		'center bottom' => __( 'Center Bottom', 'k2t' ),
	),
	'std'  => '',
	'id'   => 'offcanvas-sidebar-background-position',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Offcanvas sidebar background repeat?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		''    => __( 'None', 'k2t' ),
		'no-repeat' => __( 'No repeat', 'k2t' ),
		'repeat'    => __( 'Repeat', 'k2t' ),
		'repeat-x'  => __( 'Repeat X', 'k2t' ),
		'repeat-y'  => __( 'Repeat Y', 'k2t' ),
	),
	'std'  => '',
	'id'  => 'offcanvas-sidebar-background-repeat',
	'desc'  => '',
);

$of_options[] = array( 'name' => __( 'Offcanvas sidebar background size?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		''        => __( 'None', 'k2t' ),
		'auto'    => __( 'Auto', 'k2t' ),
		'cover'   => __( 'Cover', 'k2t' ),
		'contain' => __( 'Contain', 'k2t' ),
	),
	'std'  => '',
	'id'   => 'offcanvas-sidebar-background-size',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Offcanvas sidebar background color', 'k2t' ),
	'type' => 'color',
	'id' => 'offcanvas-sidebar-background-color',
);

$of_options[] = array( 'name' => __( 'Offcanvas sidebar text color', 'k2t' ),
	'type' => 'color',
	'id' => 'offcanvas-sidebar-text-color',
);

$of_options[] = array( 'name' => __( 'Offcanvas sidebar custom css', 'k2t' ),
	'type' => 'textarea',
	'std'  => '',
	'id'   => 'offcanvas-sidebar-custom-css',
);

/*-----------------------------------------------------------------------------------*/
/* Layout
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Layout', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-view-module"></i>'
);
/* Layout */
$of_options[] = array( 'name' => __( 'Layout', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Layout', 'k2t' ),
);
// On-Off boxed
$of_options[] = array(  'name' => __( 'Enable Boxed Layout', 'k2t' ),
	'type' => 'switch',
	'std'  => false,
	'id'   => 'boxed-layout',
);

$of_options[] = array( 'name' => __( 'Content Width (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 1170,
	'min'  => 940,
	'max'  => 1300,
	'step' => 10,
	'id'   => 'use-content-width',
	'desc' => __( 'You can choose content width in the range from 940px to 1300px.', 'k2t' ),
);

$of_options = k2t_render_titlebar_options( 'page', $of_options );

/*-----------------------------------------------------------------------------------*/
/* Styling
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Style', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-view-module"></i>'
);

$of_options[] = array( 'name' => __( 'Primary Color', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Primary Color', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Primary color', 'k2t' ),
	'type' => 'select',
	'id'   => 'theme-primary-color',
	'std'  => 'light',
	'options' => array (
		'default'   => __( 'Default', 'k2t' ),
		'blue' 		=> __( 'Blue', 'k2t' ),
		'green' 	=> __( 'Green', 'k2t' ),
		'red' 		=> __( 'Red', 'k2t' ),
		'orange' 	=> __( 'Orange', 'k2t' ),
		'brown' 	=> __( 'Brown', 'k2t' ),
		'custom' 	=> __( 'Custom', 'k2t' ),
	),
	'k2t_logictic' => array(
		'default' 	=> array( ),
		'blue' 		=> array( ),
		'green' 	=> array( ),
		'red' 		=> array( ),
		'orange' 	=> array( ),
		'brown' 	=> array( ),
		'custom' 	=> array( 'primary-color' ),
	),
);

$of_options[] = array( 'name' => __( 'Primary Color Custom', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'primary-color',
	'desc' => __( 'Primary color is the main color of site.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Body color', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'body_color',
	'desc' => __( 'Body color is the main color of site.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Heading color', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'heading-color',
	'desc' => __( 'Heading color', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Text color', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'text-color',
	'desc' => __( 'Text color', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Links', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Links', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Link color', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'link-color',
);

$of_options[] = array( 'name' => __( 'Link hover color', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'link-hover-color',
);

$of_options[] = array( 'name' => __( 'Footer color', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'footer-color',
);

$of_options[] = array( 'name' => __( 'Footer link color', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'footer-link-color',
);

$of_options[] = array( 'name' => __( 'Menu colors', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Menu colors', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Main menu color', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'main-menu-color',
);

$of_options[] = array( 'name' => __( 'Sub menu color', 'k2t' ),
	'type' => 'color',
	'std'  => '',
	'id'   => 'sub-menu-color',
);


/*-----------------------------------------------------------------------------------*/
/* Typography
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Typography', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-format-color-text"></i>'
);

$of_options[] = array( 'name' => __( 'Font family', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Font family', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Body font', 'k2t' ),
	'desc' => __( 'You can choose a normal font or Google font.', 'k2t' ),
	'id'   => 'body-font',
	'std'  => 'Roboto',
	'type' => 'select_google_font',
	'preview'  => array(
		'text' => 'This is the preview!', //this is the text from preview box
		'size' => '30px' //this is the text size from preview box
	),
	'options' => k2t_fonts_array(),
);

$of_options[] = array( 'name' => __( 'Heading font', 'k2t' ),
	'desc' => __( 'You can choose a normal font or Google font', 'k2t' ),
	'id'   => 'heading-font',
	'std'  => 'Roboto',
	'type' => 'select_google_font',
	'preview' => array(
		'text' => 'This is the preview!', //this is the text from preview box
		'size' => '30px' //this is the text size from preview box
	),
	'options' => k2t_fonts_array(),
);

$of_options[] = array( 'name' => __( 'Navigation font', 'k2t' ),
	'desc' => __( 'You can choose a normal font or Google font', 'k2t' ),
	'id'   => 'mainnav-font',
	'std'  => 'Roboto',
	'type' => 'select_google_font',
	'preview' => array(
		'text' => 'This is the preview!', //this is the text from preview box
		'size' => '30px' //this is the text size from preview box
	),
	'options' => k2t_fonts_array(),
);

$of_options[] = array( 'name' => __( 'General font size', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'General font size', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Body font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 14,
	'min'  => 8,
	'max'  => 28,
	'step' => 1,
	'id'   => 'body-size',
);

$of_options[] = array( 'name' => __( 'Main navigation font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 16,
	'min'  => 9,
	'max'  => 24,
	'step' => 1,
	'id'   => 'mainnav-size',
);

$of_options[] = array( 'name' => __( 'Submenu of Main navigation font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 16,
	'min'  => 9,
	'max'  => 24,
	'step' => 1,
	'id'   => 'submenu-mainnav-size',
);

$of_options[] = array( 'name' => __( 'Titlebar title font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 30,
	'min'  => 14,
	'max'  => 120,
	'step' => 1,
	'id'   => 'titlebar_font_size',
);

$of_options[] = array( 'name' => __( 'Headings font size', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Headings font size', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'H1 font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 45,
	'min'  => 20,
	'max'  => 80,
	'step' => 1,
	'id'   => 'h1-size',
);

$of_options[] = array( 'name' => __( 'H2 font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 40,
	'min'  => 16,
	'max'  => 64,
	'step' => 1,
	'id'   => 'h2-size',
);

$of_options[] = array( 'name' => __( 'H3 font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 28,
	'min'  => 12,
	'max'  => 48,
	'step' => 1,
	'id'   => 'h3-size',
);

$of_options[] = array( 'name' => __( 'H4 font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 24,
	'min'  => 8,
	'max'  => 32,
	'step' => 1,
	'id'   => 'h4-size',
);

$of_options[] = array( 'name' => __( 'H5 font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 20,
	'min'  => 8,
	'max'  => 30,
	'step' => 1,
	'id'   => 'h5-size',
);

$of_options[] = array( 'name' => __( 'H6 font size (px)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 14,
	'min'  => 8,
	'max'  => 30,
	'step' => 1,
	'id'   => 'h6-size',
);

$of_options[] = array( 'name' => __( 'Font type', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Font type', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Navigation text transform', 'k2t' ),
	'desc' => __( 'Select navigation text transform.', 'k2t' ),
	'type' => 'select',
	'id'   => 'mainnav-text-transform',
	'std'  => 'uppercase',
	'options' => array (
		'none'       => __( 'None', 'k2t' ),
		'capitalize' => __( 'Capitalize', 'k2t' ),
		'uppercase'  => __( 'Uppercase', 'k2t' ),
		'lowercase'  => __( 'Lowercase', 'k2t' ),
		'inherit'    => __( 'Inherit', 'k2t' ),
	),
);

$of_options[] = array( 'name' => __( 'Navigation font weight', 'k2t' ),
	'desc' => __( 'Select navigation font weight.', 'k2t' ),
	'type' => 'select',
	'id'   => 'mainnav-font-weight',
	'std'  => '300',
	'options' => array (
		'100' => __( '100', 'k2t' ),
		'200' => __( '200', 'k2t' ),
		'300' => __( '300', 'k2t' ),
		'400' => __( '400', 'k2t' ),
		'500' => __( '500', 'k2t' ),
		'600' => __( '600', 'k2t' ),
		'700' => __( '700', 'k2t' ),
		'800' => __( '800', 'k2t' ),
		'900' => __( '900', 'k2t' ),
	),
);

/*-----------------------------------------------------------------------------------*/
/* LearnDash
/*-----------------------------------------------------------------------------------*/
if ( !function_exists('is_plugin_active') )
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
if ( function_exists('is_plugin_active') && is_plugin_active( 'sfwd-lms/sfwd_lms.php') ) :
	$of_options[] = array( 'name' => __( 'LearnDash', 'k2t' ),
		'type' => 'heading',
		'icon' => '<i class="zmdi zmdi-comment-text"></i>'
	);

	$of_options[] = array( 'name' => __( 'LearnDash Meta', 'k2t' ),
		'type' => 'info',
		'std'  => __( 'LearnDash Meta', 'k2t' ),
	);
	$of_options[] = array(  'name' => __( 'Show/Hide Footer Navigation', 'k2t' ),
		'type' => 'switch',
		'id'   => 'ld-footer-nav',
		'std'  => true
	);

	$of_options[] = array( 'name' => __( 'Show/Hide post date', 'k2t' ),
		'type' => 'switch',
		'std'  => true,
		'id'   => 'ld-post-date',
	);
	$of_options[] = array( 'name' => __( 'Show/Hide comment form', 'k2t' ),
		'type' => 'switch',
		'std'  => true,
		'id'   => 'ld-comment',
	);
	$of_options[] = array( 'name' => __( 'Show/Hide the number of comments', 'k2t' ),
		'type' => 'switch',
		'std'  => true,
		'id'   => 'ld-show-number-comment',
	);

	$of_options[] = array( 'name' => __( 'Show/Hide Tags', 'k2t' ),
		'type' => 'switch',
		'std'  => true,
		'id'   => 'ld-tags',
	);

	$of_options[] = array( 'name' => __( 'Show/Hide author', 'k2t' ),
		'type' => 'switch',
		'std'  => true,
		'id'   => 'ld-author',
	);
endif;

/*-----------------------------------------------------------------------------------*/
/* Blog
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Blog', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-format-align-left"></i>'
);

$of_options[] = array( 'name' => __( 'Blog layout', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Blog layout', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Blog layout', 'k2t' ),
	'type' => 'select',
	'id'   => 'blog-layout',
	'options' => array (
		'right_sidebar' => __( 'Right Sidebar (default)', 'k2t' ),
		'left_sidebar'  => __( 'Left Sidebar', 'k2t' ),
		'no_sidebar'    => __( 'No Sidebar', 'k2t' ) ),
	'std'  => 'right_sidebar',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Blog sidebar', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'blog-custom-sidebar',
	'desc'   => '',
);

$of_options[] = array( 'name' => __( 'Blog style', 'k2t' ),
	'type' => 'select',
	'id'   => 'blog-style',
	'options' => array (
		'large'    => __( 'Large', 'k2t' ),
		'grid'     => __( 'Grid', 'k2t' ),
		'medium'   => __( 'Medium', 'k2t' ),
		'masonry'  => __( 'Masonry', 'k2t' ),
	),
	'std'       => 'large',
	'desc'      => __( 'Select blog style.', 'k2t' ),
	'logicstic' => true,
);

$of_options[] = array(  'name' => __( 'Columns', 'k2t' ),
	'type'    => 'select',
	'id'      => 'blog-masonry-column',
	'options' => array (
		'column-2' => __( '2 Columns', 'k2t' ),
		'column-3' => __( '3 Columns', 'k2t' ),
		'column-4' => __( '4 Columns', 'k2t' ),
		'column-5' => __( '5 Columns', 'k2t' )
	),
	'std'  => 'column-3',
	'desc' => __( 'Select column for layout masonry.', 'k2t' ),
	'conditional_logic' => array(
		'field'    => 'blog-style',
		'value'    => 'masonry',
	),
);
$of_options[] = array(  'name' => __( 'Columns', 'k2t' ),
	'type'    => 'select',
	'id'      => 'blog-grid-column',
	'options' => array (
		'column-2' => __( '2 Columns', 'k2t' ),
		'column-3' => __( '3 Columns', 'k2t' ),
	),
	'std'  => 'column-2',
	'desc' => __( 'Select column for layout grid.', 'k2t' ),
	'conditional_logic' => array(
		'field'    => 'blog-style',
		'value'    => 'grid',
	),
);
$of_options[] = array(  'name' => __( 'Full width', 'k2t' ),
	'type' => 'switch',
	'std'  => false,
	'id'   => 'blog-masonry-full-width',
	'desc' => __( 'Enable full width layout for masonry blog.', 'k2t' ),
	'conditional_logic' => array(
		'field'    => 'blog-style',
		'value'    => 'masonry',
	),
);

$of_options[] = array( 'name' => __( 'Blog Options', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Blog Options', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Content or excerpt', 'k2t' ),
	'type'    => 'select',
	'id'      => 'blog-display',
	'options' => array (
		'excerpts' => __( 'Excerpt', 'k2t' ),
		'contents' => __( 'Content', 'k2t' ) ),
	'std'  => 'excerpt',
	'desc' => __( 'Select display post content or excerpt on the blog.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Excerpt length (words)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 25,
	'step' => 1,
	'min'  => 10,
	'max'  => 80,
	'id'   => 'excerpt-length',
);

$of_options[] = array(  'name' => __( 'Infinite Scroll', 'k2t' ),
	'type'    => 'select',
	'id'      => 'pagination-type',
	'options' => array (
		'pagination_number' => __( 'Pagination Number', 'k2t' ),
		'pagination_lite'   => __( 'Pagination Lite', 'k2t' ),
		'pagination_ajax'   => __( 'Pagination Ajax', 'k2t' ),
	),
	'std' => 'pagination_number'
);

$of_options[] = array( 'name' => __( 'Show/Hide title link?', 'k2t' ),
	'type' => 'switch',
	'id'   => 'blog-post-link',
	'std'  => true
);

$of_options[] = array( 'name' => __( 'Show/Hide post date', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-date',
);

$of_options[] = array( 'name' => __( 'Show/Hide the number of comments', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-number-comment',
);

$of_options[] = array( 'name' => __( 'Show/Hide Categories Icons', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-categories-icons',
);

$of_options[] = array( 'name' => __( 'Show/Hide author', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-author',
);

$of_options[] = array( 'name' => __( 'Show/Hide "Reamore" link', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-readmore',
);

$of_options = k2t_render_titlebar_options( 'blog', $of_options );

/* Social Impact */
$of_options[] = array( 'name' => __( 'Social', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Social', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Show/Hide social buttons', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-social',
	'desc' => __( 'Turn it OFF if you do not want to display social buttons', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Facebook?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-social-facebook',
);

$of_options[] = array( 'name' => __( 'Twitter?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-social-twitter',
);

$of_options[] = array( 'name' => __( 'Google+?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-social-google-plus',
);

$of_options[] = array( 'name' => __( 'Linkedin?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-social-linkedin',
);

$of_options[] = array( 'name' => __( 'Tumblr?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-social-tumblr',
);

$of_options[] = array( 'name' => __( 'Email?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'blog-social-email',
);

/*-----------------------------------------------------------------------------------*/
/* Single
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Single', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-receipt"></i>'
);

/* Featured Image */
$of_options[] = array( 'name' => __( 'Single Post Layout', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Single Post Layout', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Single post layout', 'k2t' ),
	'type' => 'select',
	'id'   => 'single-layout',
	'options' => array (
		'right-sidebar' => __( 'Right Sidebar (default)', 'k2t' ),
		'left-sidebar'  => __( 'Left Sidebar', 'k2t' ),
		'no-sidebar'    => __( 'No Sidebar', 'k2t' ) ),
	'std'  => 'right-sidebar',
	'desc' => '',
);

$of_options[] = array( 'name' => __( 'Single custom sidebar', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'single-custom-sidebar',
	'desc'   => '',
);

/* Meta */
$of_options[] = array( 'name' => __( 'Meta', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Meta', 'k2t' ),
);

$of_options = k2t_social_share_options( 'single', $of_options );

$of_options[] = array( 'name' => __( 'Show/Hide Tags', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'single-tags',
	'desc' => __( 'Turn OFF if you don\'t want to display tags on single post', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Show/Hide Comment Number', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'single-comments',
	'desc' => __( 'Turn OFF if you don\'t want to display comment number on single post', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Show/Hide Next / Previous links?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'single-nav',
	'desc' => __( 'Turn OFF if you don\'t want to display post navigation links on single post', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Show/Hide authorbox', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'single-authorbox',
	'desc' => __( 'Turn OFF if you don\'t want to display author box on single post', 'k2t' ),
);

$of_options[] = array(  'name' => __( 'Show/Hide related post', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'single-related-post',
	'desc' => __( 'Turn OFF if you don\'t want to display related post on single post', 'k2t' ),
);

$of_options[] = array(  'name' => __( 'Related post title', 'k2t' ),
	'type' => 'text',
	'std'  => 'You may also like',
	'id'   => 'single-related-post-title',
	'desc' => '',
);
$of_options[] = array( 'name' => __( 'Number of related post', 'k2t' ),
	'type' => 'text',
	'std'  => 3,
	'id'   => 'single-related-post-number',
	'desc' => __( 'Fill out -1 if you want to display ALL related post.', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Show/Hide comment form', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'single-commnet-form',
	'desc' => __( 'Turn OFF if you don\'t want to display comment form on single post', 'k2t' ),
);

$of_options = k2t_render_titlebar_options( 'single', $of_options );


/*-----------------------------------------------------------------------------------*/
/* Project option
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Project', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-markunread-mailbox"></i>'
);
$of_options[] = array( 'name' => __( 'Project Category', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Project Category', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Project Category Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'project-category-slug',
);
$of_options = k2t_render_titlebar_options( 'project-category', $of_options );
/* Project Single */
$of_options[] = array( 'name' => __( 'Single Project', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-comment-alt"></i>'
);
$of_options[] = array( 'name' => __( 'Project Single', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Project Single', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Project Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'project-slug',
);
$of_options[] = array( 'name' => __( 'Show/Hide project Related', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'project-related',
	'desc' => __( 'Turn OFF if you don\'t want to display project related on single Project', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Project Related Title', 'k2t' ),
	'type' => 'text',
	'std'  => 'Related Projects',
	'id'   => 'project-related-post-title',
);
$of_options[] = array( 'name' => __( 'Show/Hide Navigation', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'project-related-navigation',
);
$of_options[] = array( 'name' => __( 'Show/Hide Pagination', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'project-related-pagination',
);
$of_options = k2t_social_share_options( 'project', $of_options );

$of_options = k2t_render_titlebar_options( 'project', $of_options );

/*-----------------------------------------------------------------------------------*/
/* Gallery
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Gallery', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-picture-in-picture"></i>'
);

$of_options[] = array( 'name' => __( 'Gallery Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'gallery-slug',
);

/*-----------------------------------------------------------------------------------*/
/* Event
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Event', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-case"></i>'
);

/* Event Category */
$of_options[] = array( 'name' => __( 'Event Category', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Event Category', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Event Category Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'k2t-event-category-slug',
);
$of_options[] = array( 'name' => __( 'Event Tag Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'k2t-event-tag-slug',
);
$of_options[] = array( 'name' => __( 'Layout', 'k2t' ),
	'type' => 'select',
	'options' => array(
		'right_sidebar' => __( 'Right Sidebar', 'k2t' ),
		'left_sidebar'  => __( 'Left Sidebar', 'k2t' ),
		'no_sidebar'    => __( 'Fullwidth', 'k2t' ),
		'full_width'    => __( '100% Width', 'k2t' ),
	),
	'std' => 'right_sidebar',
	'id'  => 'event-category-layout',
);

$of_options[] = array(  'name' => __( 'Sidebar name', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'event-category-custom-sidebar',
);

$of_options[] = array(  'name' => __( 'Event List Page Pagination', 'k2t' ),
	'type'    => 'select',
	'id'      => 'event-pagination-type',
	'options' => array (
		'pagination_number' => __( 'Pagination Number', 'k2t' ),
		'pagination_lite'   => __( 'Pagination Lite', 'k2t' ),
	),
	'std' => 'pagination_lite'
);


$of_options[] = array(  'name' => __( 'Display Event Filter?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'event-display-filter',
);

$of_options[] = array(  'name' => __( 'Style', 'k2t' ),
	'type' => 'select',
	'options' => array(
		'style-3' => __( 'Grid', 'k2t' ),
		'style-4' => __( 'Classic', 'k2t' ),
		'style-5' => __( 'Carousel', 'k2t' ),
	),
	'std' => 'style-3',
	'id'  => 'event-category-style',
);

$of_options[] = array(  'name' => __( 'Child Style', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		'none'                       => __( 'None', 'k2t' ),
		'gallery_masonry_free_style' => __( 'Gallery masonry free style', 'k2t' ),
		'gallery_grid_no_padding'    => __( 'Gallery grid no padding', 'k2t' ),
	),
	'std' => 'none',
	'id'  => 'event-category-child-style',
);

$of_options[] = array( 'name' => __( 'Column?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		'2_columns'  => __( '2 columns', 'k2t' ),
		'3_columns'  => __( '3 columns', 'k2t' ),
		'4_columns'  => __( '4 columns', 'k2t' ),
		'5_columns'  => __( '5 columns', 'k2t' ),
	),
	'std' => '3_columns',
	'id'  => 'event-category-column',
);

$of_options[] = array( 'name' => __( 'Number of events per page', 'k2t' ),
	'type' => 'text',
	'std'  => 5,
	'id'   => 'event-category-number',
	'desc' => __( 'Fill out -1 if you want to display ALL projects.', 'k2t' ),
);

$of_options = k2t_render_titlebar_options( 'event-category', $of_options );

/* Single Event */

$of_options[] = array( 'name' => __( 'Single Event', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-case"></i>'
);

$of_options[] = array( 'name' => __( 'Single Event', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Single Event', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Event Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'k2t-event-slug',
);

$of_options[] = array( 'name' => __( 'Layout', 'k2t' ),
	'type' => 'select',
	'options' => array(
		'right_sidebar' => __( 'Right Sidebar', 'k2t' ),
		'left_sidebar'  => __( 'Left Sidebar', 'k2t' ),
		'no_sidebar'    => __( 'No Sidebar', 'k2t' ),
	),
	'std' => 'right_sidebar',
	'id'  => 'event-layout',
);

$of_options[] = array( 'name' => __( 'Single Event custom sidebar', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'event-custom-sidebar',
	'desc'   => '',
);

$of_options[] = array( 'name' => __( 'Show/Hide Related Events', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'event-related',
	'desc' => __( 'Turn OFF if you don\'t want to display Related Events on single Event', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Related Events Title', 'k2t' ),
	'type' => 'text',
	'std'  => 'Related Events',
	'id'   => 'event-related-title',
);

$of_options[] = array( 'name' => __( 'Number of Related Events', 'k2t' ),
	'type' => 'text',
	'std'  => 2,
	'id'   => 'event-related-number',
	'desc' => __( 'Fill out -1 if you want to display ALL Event.', 'k2t' ),
);

$of_options = k2t_social_share_options( 'event', $of_options );

$of_options = k2t_render_titlebar_options( 'event', $of_options );


/*-----------------------------------------------------------------------------------*/
/* Teacher
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Teacher', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-account"></i>'
);
$of_options[] = array( 'name' => __( 'Teacher Listing', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Teacher Listing', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Teacher Single Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'k2t-teacher-slug',
);
$of_options[] = array( 'name' => __( 'Column?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		'columns-2'  => __( '2 columns', 'k2t' ),
		'columns-3'  => __( '3 columns', 'k2t' ),
		'columns-4'  => __( '4 columns', 'k2t' ),
	),
	'std' => 'columns-3',
	'id'  => 'teacher-listing-column',
);
$of_options[] = array(  'name' => __( 'Excerpt length', 'k2t' ),
	'type' => 'text',
	'std'  => 20,
	'id'   => 'teacher-excerpt-length',
);
$of_options[] = array( 'name' => __( 'Teacher Single', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Teacher Single', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Layout', 'k2t' ),
	'type' => 'select',
	'options' => array(
		'right_sidebar' => __( 'Right Sidebar', 'k2t' ),
		'left_sidebar'  => __( 'Left Sidebar', 'k2t' ),
		'no_sidebar'    => __( 'No Sidebar', 'k2t' ),
	),
	'std' => 'right_sidebar',
	'id'  => 'teacher-layout',
);
$of_options[] = array( 'name' => __( 'Single Teacher custom sidebar', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'teacher-custom-sidebar',
	'desc'   => '',
);
$of_options = k2t_render_titlebar_options( 'teacher', $of_options );

/*-----------------------------------------------------------------------------------*/
/* Course
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Course', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-accounts-alt"></i>'
);

/* Course Category */
$of_options[] = array( 'name' => __( 'Course Category', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Course Category', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Course category Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'k2t-course-category-slug',
);
$of_options[] = array( 'name' => __( 'Course Tag Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'k2t-course-tag-slug',
);
$of_options[] = array( 'name' => __( 'Layout', 'k2t' ),
	'type' => 'select',
	'options' => array(
		'right_sidebar' => __( 'Right Sidebar', 'k2t' ),
		'left_sidebar'  => __( 'Left Sidebar', 'k2t' ),
		'no_sidebar'    => __( 'No Sidebar', 'k2t' ),
	),
	'std' => 'right_sidebar',
	'id'  => 'course-category-layout',
);

$of_options[] = array(  'name' => __( 'Sidebar name', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'course-category-custom-sidebar',
);

$of_options[] = array(  'name' => __( 'Course List Page Pagination', 'k2t' ),
	'type'    => 'select',
	'id'      => 'course-pagination-type',
	'options' => array (
		'pagination_number' => __( 'Pagination Number', 'k2t' ),
		'pagination_lite'   => __( 'Pagination Lite', 'k2t' ),
	),
	'std' => 'pagination_lite'
);

$of_options[] = array(  'name' => __( 'Style', 'k2t' ),
	'type' => 'select',
	'options' => array(
		'style-1' 			=> __('Classic', 'k2t'),
		'style-2'			=> __('Grid', 'k2t'),
	),
	'std' => 'style-1',
	'id'  => 'course-category-style',
	'logicstic' => true,
);

$of_options[] = array( 'name' => __( 'Column?', 'k2t' ),
	'type'    => 'select',
	'options' => array(
		'2_columns'  => __( '2 columns', 'k2t' ),
		'3_columns'  => __( '3 columns', 'k2t' ),
		'4_columns'  => __( '4 columns', 'k2t' ),
		'5_columns'  => __( '5 columns', 'k2t' ),
	),
	'std' => '3_columns',
	'id'  => 'course-category-column',
	'conditional_logic' => array(
		'field' => 'course-category-style',
		'value' => 'style-2',
	),
);

$of_options[] = array( 'name' => __( 'Number of course per page', 'k2t' ),
	'type' => 'text',
	'std'  => 9,
	'id'   => 'course-category-number',
	'desc' => __( 'Fill out -1 if you want to display ALL course.', 'k2t' ),
);

$of_options = k2t_render_titlebar_options( 'course-category', $of_options );

/* Single Course */

$of_options[] = array( 'name' => __( 'Single Course', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-account-add"></i>'
);

$of_options[] = array( 'name' => __( 'Single Course', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Single Course', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Course Slug', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'k2t-course-slug',
);

$of_options[] = array( 'name' => __( 'Layout', 'k2t' ),
	'type' => 'select',
	'options' => array(
		'right_sidebar' => __( 'Right Sidebar', 'k2t' ),
		'left_sidebar'  => __( 'Left Sidebar', 'k2t' ),
		'no_sidebar'    => __( 'No Sidebar', 'k2t' ),
	),
	'std' => 'right_sidebar',
	'id'  => 'course-layout',
);

$of_options[] = array( 'name' => __( 'Single course custom sidebar', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'course-custom-sidebar',
	'desc'   => '',
);

$of_options[] = array( 'name' => __( 'Show/Hide Related Course', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'course-related',
	'desc' => __( 'Turn OFF if you don\'t want to display related course on single Course', 'k2t' ),
);
$of_options[] = array( 'name' => __( 'Related Course Title', 'k2t' ),
	'type' => 'text',
	'std'  => 'Related Course',
	'id'   => 'course-related-title',
);

$of_options = k2t_social_share_options( 'course', $of_options );

$of_options = k2t_render_titlebar_options( 'course', $of_options );

/*-----------------------------------------------------------------------------------*/
/* WooCommerce
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'WooCommerce', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-shopping-basket"></i>'
);

/* Shop Archive Page */
$of_options[] = array( 'name' => __( 'Shop Archive', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Shop Archive', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Shop Layout', 'k2t' ),
	'type' => 'select',
	'std'  => 'right_sidebar',
	'options' => array(
		'right_sidebar' => __( 'Right Sidebar', 'k2t' ),
		'left_sidebar'  => __( 'Left Sidebar', 'k2t' ),
		'no_sidebar'    => __( 'No Sidebar', 'k2t' ),
	),
	'id' => 'shop-layout',
);
$of_options[] = array( 'name' => __( 'Show "sorting"?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'shop-display-sorting',
);

$of_options[] = array(  'name' => __( 'Show "result count"?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'shop-display-result-count',
);

$of_options[] = array( 'name' => __( 'Number of columns (default)', 'k2t' ),
	'type' => 'sliderui',
	'std'  => 4,
	'min'  => 3,
	'max'  => 4,
	'id'   => 'shop-column',
);

$of_options[] = array( 'name' => __( 'Number of products per page', 'k2t' ),
	'type' => 'text',
	'std'  => '',
	'id'   => 'shop-products-per-page',
	'desc' => __( 'Fill it -1 if you want to display all products.', 'k2t' ),
);

$of_options = k2t_render_titlebar_options( 'shop', $of_options );

/* Single Product */
$of_options[] = array( 'name' => __( 'Single Product', 'k2t' ),
	'type' => 'info',
	'std'  => __( 'Single Product', 'k2t' ),
);

$of_options[] = array(  'name' => __( 'Layout', 'k2t' ),
	'type' => 'select',
	'std'  => 'right_sidebar',
	'options' => array(
		'right_sidebar' => __( 'Right Sidebar', 'k2t' ),
		'left_sidebar'  => __( 'Left Sidebar', 'k2t' ),
		'no_sidebar'    => __( 'No Sidebar', 'k2t' ),
	),
	'id' => 'product-layout',
);

$of_options[] = array( 'name' => __( 'Show/Hide related products?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'product-single-display-related-products',
	'logicstic' => true,
);

$of_options[] = array( 'name' => __( 'Column of related products', 'k2t' ),
	'type' => 'sliderui',
	'min'  => 2,
	'max'  => 4,
	'std'  => 3,
	'step' => 1,
	'id'   => 'product-related-products-column',
	'conditional_logic' => array(
		'field' => 'product-single-display-related-products',
		'value' => 'switch-1',
	),
);

$of_options = k2t_render_titlebar_options( 'product', $of_options );

/*-----------------------------------------------------------------------------------*/
/* 404 Page
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( '404 Page', 'k2t' ),
	'type' => 'heading',
	'icon' => '<i class="zmdi zmdi-alert-triangle"></i>'
);

$of_options[] = array( 'name' => __( '404 page', 'k2t' ),
	'type' => 'info',
	'std'  => __( '404 page', 'k2t' ),
);

$of_options[] = array( 'name' => __( '404 Title', 'k2t' ),
	'type' => 'text',
	'std'  => 'Oops! Looks like something was broken.',
	'id'   => '404-title',
	'desc' => '',
);

$of_options[] = array( 'name' => __( '404 Image', 'k2t' ),
	'type' => 'media',
	'std'  => get_template_directory_uri() . '/assets/img/icons/404.png',
	'id'   => '404-image',
	'desc' => '',
);

$of_options[] = array( 'name' => __( '404 Custom Text', 'k2t' ),
	'type' => 'textarea',
	'id'   => '404-text',
);

/*-----------------------------------------------------------------------------------*/
/* Social Icons
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 'name' => __( 'Social', 'k2t' ),
	'type'  => 'heading',
	'icon'  => '<i class="zmdi zmdi-accounts"></i>'
);

$of_options[] = array( 'name' => __( 'Target', 'k2t' ),
	'type' => 'select',
	'std'  => '_blank',
	'options' => array(
		'_self'  => __( 'Same tab', 'k2t' ),
		'_blank' => __( 'New tab', 'k2t' ),
	),
	'id' => 'social-target',
);

$of_options[] = array( 'name' => __( 'Twitter username?', 'k2t' ),
	'type' => 'text',
	'std'  => 'themelead',
	'id'   => 'twitter-username',
	'desc' => __( 'Twitter username used for tweet share buttons.', 'k2t' ),
);

$of_options[] = array( 'name' => __( 'Icon title?', 'k2t' ),
	'type' => 'switch',
	'std'  => true,
	'id'   => 'social-title',
	'desc' => __( 'Turn it ON if you want to display social icon titles like Facebook, Google+, Twitter... when hover icons.', 'k2t' ),
);


foreach ( k2t_social_array() as $s => $c ):

	$of_options[] = array( 'name' => $c,
		'type' => 'text',
		'std'  => '',
		'id'   => 'social-' . $s,
	);

endforeach;

/*-----------------------------------------------------------------------------------*/
/* One Click Install */
/*-----------------------------------------------------------------------------------*/
 $of_options[] = array( 'name'   => __( 'One Click Install', 'k2t' ),
 	'type'  => 'heading',
 	'icon'  => '<i class="zmdi zmdi-time"></i>'
 );
 $of_options[] = array( 'name'   => __( 'Transfer Theme Options Data', 'k2t' ),
 	'id'   => 'k2t_advance_backup',
 	'std'  => '',
 	'type' => 'k2t_advance_backup',
 );