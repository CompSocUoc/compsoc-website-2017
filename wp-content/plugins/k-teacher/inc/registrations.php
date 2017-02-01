<?php
// Include register factory
include_once dirname( __FILE__) . '/class.register_factory.php';

if( empty($k2t_register) || !$k2t_register instanceof K2T_Teacher_Register ){
	$k2t_register = new K2T_Teacher_Register();
}
$slug = ( get_option( 'k2t_teacher_slug' ) != '' ) ?  get_option( 'k2t_teacher_slug' ) : esc_html__( 'k-Teacher', 'k2t' );
$slug_cat = ( get_option( 'k2t_tag_category_slug' ) != '' ) ?  get_option( 'k2t_tag_category_slug' ) : esc_html__( 'k-tag-category', 'k2t' );

// Register teacher post type
$k2t_register->register_post_type(array(
	array(
		'post-type' => 'post-k-teacher',
		'args' => array(
			'labels' => array(
				'name' => __('K-Teacher', 'k2t'),  
				'singular_name' => __('K-Teacher', 'k2t'),  
				'add_new' => __('Add New Teacher', 'k2t'),  
				'add_new_item' => __('Add New Teacher', 'k2t'),  
				'edit_item' => __('Edit Teacher', 'k2t'),  
				'new_item' => __('New Teacher', 'k2t'),  
				'view_item' => __('View Teacher', 'k2t'),  
				'all_items' => __('All Teachers', 'k2t'),
				'search_items' => __('Search Teacher', 'k2t'),  
				'not_found' =>  __('No Teacher found', 'k2t'),  
				'not_found_in_trash' => __('No Teacher found in Trash', 'k2t'),  
				'parent_item_colon' => ''
			),
			'rewrite' => array( 'slug' => $slug, 'with_front' => FALSE )
		)
	)
));
// Register Teacher category taxonomy
$k2t_register->register_taxonomy(array(
	array(
		'taxonomy' => 'k-teacher-category',
		'args' => array(
			'labels' => array(
				'name'                => _x( 'Teacher Categories', 'taxonomy general name','k2t'),
				'singular_name'       => _x( 'K-Teacher Category', 'taxonomy singular name','k2t'),
				'search_items'        => __( 'Search K-Teacher Categories','k2t'),
				'all_items'           => __( 'All K-Teacher Categories','k2t'),
				'parent_item'         => __( 'Parent K-Teacher Category','k2t'),
				'parent_item_colon'   => __( 'Parent K-Teacher Category:','k2t'),
				'edit_item'           => __( 'Edit K-Teacher Category','k2t'), 
				'update_item'         => __( 'Update K-Teacher Category','k2t'),
				'add_new_item'        => __( 'Add New K-Teacher Category','k2t'),
				'new_item_name'       => __( 'New K-Teacher Category Name','k2t'),
				'menu_name'           => __( 'K-Teacher Categories','k2t')
			),
			'rewrite' => array('slug' => $slug_cat ),
			'post-type' => 'post-k-teacher'
		)
	),
));