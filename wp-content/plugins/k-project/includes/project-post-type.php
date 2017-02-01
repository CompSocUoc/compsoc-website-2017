<?php
// Register custom post type "Page Section"
add_action('init', 'k2t_register_project'); 
function k2t_register_project()  { 
  global $smof_data;
  $project_slug = $smof_data['project-slug'];
  
  $labels = array(  
    'name' => __('K-Project', 'ruby'),  
    'singular_name' => __('All Project', 'ruby'),  
    'add_new' => __('Add New project', 'ruby'),  
    'add_new_item' => __('Add New project', 'ruby'),  
    'edit_item' => __('Edit project', 'ruby'),  
    'new_item' => __('New project', 'ruby'),  
    'view_item' => __('View project', 'ruby'),  
    'search_items' => __('Search project', 'ruby'),  
    'not_found' =>  __('No project found', 'ruby'),  
    'not_found_in_trash' => __('No project found in Trash', 'ruby'),  
    'parent_item_colon' => '' 
  );  
  
  $args = array(  
    'labels' 				=> $labels,  
    'menu_position' 		=> 5, 
	'public' 				=> true,
	'publicly_queryable' 	=> true,
	'has_archive' 			=> true,
	'hierarchical' 			=> false,
	'supports' 				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
  );
  if(!empty($project_slug)){
  	$args['rewrite'] = array('slug' => $project_slug);
  }else{
	$args['rewrite'] = array('slug' => 'project');
  }
  register_post_type('post-k-project',$args);
}

/* --------------------------------------------------- */
/* Register project Category
/* --------------------------------------------------- */
add_action( 'init', 'k2t_register_project_category', 0 );

if ( !function_exists('k2t_register_project_category') ) {
function k2t_register_project_category(){
	global $smof_data;
  	$project_category_slug = $smof_data['project-category-slug'];
	$labels = array(
		'name'                => _x( 'Project Categories', 'taxonomy general name','ruby'),
		'singular_name'       => _x( 'Project Category', 'taxonomy singular name','ruby'),
		'search_items'        => __( 'Search Project Categories','ruby'),
		'all_items'           => __( 'All Project Categories','ruby'),
		'parent_item'         => __( 'Parent Project Category','ruby'),
		'parent_item_colon'   => __( 'Parent Project Category:','ruby'),
		'edit_item'           => __( 'Edit Project Category','ruby'), 
		'update_item'         => __( 'Update Project Category','ruby'),
		'add_new_item'        => __( 'Add New Project Category','ruby'),
		'new_item_name'       => __( 'New Project Category Name','ruby'),
		'menu_name'           => __( 'Project Category','ruby')
	);
	
	$args = array(
		'hierarchical'        => true,
		'labels'              => $labels,
		'show_ui'             => true,
		'show_admin_column'   => true,
		'query_var'           => true,
	);
	
	if(!empty($project_category_slug)){
		$args['rewrite'] = array('slug' => $project_category_slug);
	}else{
		$args['rewrite'] = array('slug' => 'project-k-category');
	}
	
	register_taxonomy( 'k-project-category', array('post-k-project'), $args );

	$labels = array(
		'name'                => _x( 'Project Tags', 'taxonomy general name','ruby'),
		'singular_name'       => _x( 'Project Tag', 'taxonomy singular name','ruby'),
		'search_items'        => __( 'Search Project Tags','ruby'),
		'all_items'           => __( 'All Project Tags','ruby'),
		'parent_item'         => __( 'Parent Project Tag','ruby'),
		'parent_item_colon'   => __( 'Parent Project Tag:','ruby'),
		'edit_item'           => __( 'Edit Project Tag','ruby'), 
		'update_item'         => __( 'Update Project Tag','ruby'),
		'add_new_item'        => __( 'Add New Project Tag','ruby'),
		'new_item_name'       => __( 'New Project Tag Name','ruby'),
		'menu_name'           => __( 'Project Tag','ruby')
	);
	
	$args = array(
		'hierarchical'        => true,
		'labels'              => $labels,
		'show_ui'             => true,
		'show_admin_column'   => true,
		'query_var'           => true,
		'rewrite'			  => array('slug' => 'project-k-tag'),
	);
	// $args['rewrite'] = array('slug' => 'project-k-tag');
	
	register_taxonomy( 'k-project-tag', array('post-k-project'), $args );
}

}

?>