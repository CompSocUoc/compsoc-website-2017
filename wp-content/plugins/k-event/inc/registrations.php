<?php
// Include register factory
include_once dirname( __FILE__) . '/class.register_factory.php';

if( empty($k2t_register) || !$k2t_register instanceof K2T_Register ){
	$k2t_register = new K2T_Register();
}
// Register event post type
$slug = ( get_option( 'k2t-event-slug' ) != '' ) ?  get_option( 'k2t-event-slug' ) : esc_html__( 'k-event', 'k2t' );

$slug_cat = ( get_option( 'k2t_event_category_slug' ) != '' ) ?  get_option( 'k2t_event_category_slug' ) : esc_html__( 'k-event-category', 'k2t' );
$slug_tag = ( get_option( 'k2t_event_tag_slug' ) != '' ) ?  get_option( 'k2t_event_tag_slug' ) : esc_html__( 'k-event-tag', 'k2t' );
$k2t_register->register_post_type(array(
	array(
		'post-type' => 'post-k-event',
		'args' => array(
			'labels' => array(
				'name' => __('K-Event', 'k2t'),  
				'singular_name' => __('K-Event', 'k2t'),  
				'add_new' => __('Add New Event', 'k2t'),  
				'add_new_item' => __('Add New Event', 'k2t'),  
				'edit_item' => __('Edit Event', 'k2t'),  
				'new_item' => __('New Event', 'k2t'),  
				'view_item' => __('View Event', 'k2t'),  
				'all_items' => __('All Events', 'k2t'),
				'search_items' => __('Search Event', 'k2t'),  
				'not_found' =>  __('No Event found', 'k2t'),  
				'not_found_in_trash' => __('No Event found in Trash', 'k2t'),  
				'parent_item_colon' => ''
			),
			'rewrite' => array( 'slug' => $slug, 'with_front' => FALSE )
		)
	)
));

// Register event category taxonomy
$k2t_register->register_taxonomy(array(
	array(
		'taxonomy' => 'k-event-category',
		'args' => array(
			'labels' => array(
				'name'                => _x( 'Event Categories', 'taxonomy general name','k2t'),
				'singular_name'       => _x( 'K-Event Category', 'taxonomy singular name','k2t'),
				'search_items'        => __( 'Search K-Event Categories','k2t'),
				'all_items'           => __( 'All K-Event Categories','k2t'),
				'parent_item'         => __( 'Parent K-Event Category','k2t'),
				'parent_item_colon'   => __( 'Parent K-Event Category:','k2t'),
				'edit_item'           => __( 'Edit K-Event Category','k2t'), 
				'update_item'         => __( 'Update K-Event Category','k2t'),
				'add_new_item'        => __( 'Add New K-Event Category','k2t'),
				'new_item_name'       => __( 'New K-Event Category Name','k2t'),
				'menu_name'           => __( 'K-Event Categories','k2t')
			),
			'rewrite' => array('slug' => $slug_cat ),
			'post-type' => 'post-k-event'
		)
	),
	array(
		'taxonomy' => 'k-event-tag',
		'args' => array(
			'labels' => array(
				'name'                => _x( 'K-Event Tags', 'taxonomy general name','k2t'),
				'singular_name'       => _x( 'K-Event Tag', 'taxonomy singular name','k2t'),
				'search_items'        => __( 'Search K-Event Tags','k2t'),
				'all_items'           => __( 'All K-Event Tags','k2t'),
				'parent_item'         => __( 'Parent K-Event Tag','k2t'),
				'parent_item_colon'   => __( 'Parent K-Event Tag:','k2t'),
				'edit_item'           => __( 'Edit K-Event Tag','k2t'), 
				'update_item'         => __( 'Update K-Event Tag','k2t'),
				'add_new_item'        => __( 'Add New K-Event Tag','k2t'),
				'new_item_name'       => __( 'New K-Event Tag Name','k2t'),
				'menu_name'           => __( 'K-Event Tags','k2t')
			),
			'rewrite' => array('slug' => $slug_tag ),
			'post-type' => 'post-k-event'
		)
	)
));
