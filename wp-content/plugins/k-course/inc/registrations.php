<?php
// Include register factory
include_once dirname( __FILE__) . '/class.register_factory.php';

if( empty($k2t_register) || !$k2t_register instanceof K2T_Course_Register ){
	$k2t_register = new K2T_Course_Register();
}
// Register course post type
$slug = ( get_option( 'k2t_course_slug' ) != '' ) ?  get_option( 'k2t_course_slug' ) : esc_html__( 'k-course', 'k2t' );
$slug_cat = ( get_option( 'k2t_course_category_slug' ) != '' ) ?  get_option( 'k2t_course_category_slug' ) : esc_html__( 'k-course-category', 'k2t' );
$slug_tag = ( get_option( 'k2t_course_tag_slug' ) != '' ) ?  get_option( 'k2t_course_tag_slug' ) : esc_html__( 'k-course-tag', 'k2t' );

$k2t_register->register_post_type(array(
	array(
		'post-type' => 'post-k-course',
		'args' => array(
			'labels' => array(
				'name' => __('K-Course', 'k2t'),  
				'singular_name' => __('K-Course', 'k2t'),  
				'add_new' => __('Add New Course', 'k2t'),  
				'add_new_item' => __('Add New Course', 'k2t'),  
				'edit_item' => __('Edit Course', 'k2t'),  
				'new_item' => __('New Course', 'k2t'),  
				'view_item' => __('View Course', 'k2t'),  
				'all_items' => __('All Courses', 'k2t'),
				'search_items' => __('Search Course', 'k2t'),  
				'not_found' =>  __('No Course found', 'k2t'),  
				'not_found_in_trash' => __('No Course found in Trash', 'k2t'),  
				'parent_item_colon' => ''
			),
			'rewrite' => array( 'slug' => $slug, 'with_front' => FALSE )
		)
	)
));

// Register course category taxonomy
$k2t_register->register_taxonomy(array(
	array(
		'taxonomy' => 'k-course-category',
		'args' => array(
			'labels' => array(
				'name'                => _x( 'Course Categories', 'taxonomy general name','k2t'),
				'singular_name'       => _x( 'K-Course Category', 'taxonomy singular name','k2t'),
				'search_items'        => __( 'Search K-Course Categories','k2t'),
				'all_items'           => __( 'All K-Course Categories','k2t'),
				'parent_item'         => __( 'Parent K-Course Category','k2t'),
				'parent_item_colon'   => __( 'Parent K-Course Category:','k2t'),
				'edit_item'           => __( 'Edit K-Course Category','k2t'), 
				'update_item'         => __( 'Update K-Course Category','k2t'),
				'add_new_item'        => __( 'Add New K-Course Category','k2t'),
				'new_item_name'       => __( 'New K-Course Category Name','k2t'),
				'menu_name'           => __( 'K-Course Categories','k2t')
			),
			'rewrite' => array('slug' => $slug_cat ),
			'post-type' => 'post-k-course'
		)
	),
	array(
		'taxonomy' => 'k-course-tag',
		'args' => array(
			'labels' => array(
				'name'                => _x( 'K-Course Tags', 'taxonomy general name','k2t'),
				'singular_name'       => _x( 'K-Course Tag', 'taxonomy singular name','k2t'),
				'search_items'        => __( 'Search K-Course Tags','k2t'),
				'all_items'           => __( 'All K-Course Tags','k2t'),
				'parent_item'         => __( 'Parent K-Course Tag','k2t'),
				'parent_item_colon'   => __( 'Parent K-Course Tag:','k2t'),
				'edit_item'           => __( 'Edit K-Course Tag','k2t'), 
				'update_item'         => __( 'Update K-Course Tag','k2t'),
				'add_new_item'        => __( 'Add New K-Course Tag','k2t'),
				'new_item_name'       => __( 'New K-Course Tag Name','k2t'),
				'menu_name'           => __( 'K-Course Tags','k2t')
			),
			'rewrite' => array('slug' => $slug_tag ),
			'post-type' => 'post-k-course'
		)
	)
));
