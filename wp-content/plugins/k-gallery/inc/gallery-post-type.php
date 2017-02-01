<?php
// Register custom post type "Page Section"
add_action( 'init', 'k2t_register_gallery' ); 
function k2t_register_gallery ()  { 
	global $smof_data;
	$gallery_slug = $smof_data['gallery-slug'];

	$labels = array(  
		'name' => __('K-Gallery', 'k2t'),  
		'singular_name' => __('K-Gallery', 'k2t'),  
		'add_new' => __('Add New Gallery', 'k2t'),  
		'add_new_item' => __('Add New Gallery', 'k2t'),  
		'edit_item' => __('Edit Gallery', 'k2t'),  
		'new_item' => __('New Gallery', 'k2t'),  
		'view_item' => __('View Gallery', 'k2t'),  
		'search_items' => __('Search Gallery', 'k2t'),  
		'not_found' =>  __('No Gallery found', 'k2t'),  
		'not_found_in_trash' => __('No Gallery found in Trash', 'k2t'),  
		'parent_item_colon' => '' 
	);  

	$args = array(  
		'labels' 				=> $labels,  
		'menu_position' 		=> 5, 
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'has_archive' 			=> true,
		'hierarchical' 			=> false,
		'supports' 				=> array( 'title', 'author', 'thumbnail' )
	);
	if(!empty($gallery_slug)){
		$args['rewrite'] = array('slug' => $gallery_slug);
	} else{
		$args['rewrite'] = array('slug' => 'gallery');
	}
	register_post_type('post-gallery',$args);  
}

/* --------------------------------------------------- */
/* Register gallery Category
/* --------------------------------------------------- */

add_action( 'init', 'k2t_register_gallery_category', 0 );
if ( ! function_exists('k2t_register_gallery_category') ) {
	function k2t_register_gallery_category(){
		global $smof_data;
		$labels = array(
			'name'                => _x( 'K-Gallery Categories', 'taxonomy general name','k2t'),
			'singular_name'       => _x( 'K-Gallery Category', 'taxonomy singular name','k2t'),
			'search_items'        => __( 'Search K-Gallery Categories','k2t'),
			'all_items'           => __( 'All K-Gallery Categories','k2t'),
			'parent_item'         => __( 'Parent K-Gallery Category','k2t'),
			'parent_item_colon'   => __( 'Parent K-Gallery Category:','k2t'),
			'edit_item'           => __( 'Edit K-Gallery Category','k2t'), 
			'update_item'         => __( 'Update K-Gallery Category','k2t'),
			'add_new_item'        => __( 'Add New K-Gallery Category','k2t'),
			'new_item_name'       => __( 'New K-Gallery Category Name','k2t'),
			'menu_name'           => __( 'K-Gallery Category','k2t')
		); 	
		
		$args = array(
			'hierarchical'        => true,
			'labels'              => $labels,
			'show_ui'             => true,
			'show_admin_column'   => true,
			'query_var'           => true,
		);
		$args['rewrite'] = array('slug' => 'gallery-category');
		register_taxonomy( 'gallery-category', array('post-gallery'), $args );
	}
}
?>