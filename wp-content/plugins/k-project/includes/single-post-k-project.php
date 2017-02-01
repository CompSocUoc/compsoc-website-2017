<?php global $smof_data, $wp_embed; ?>
<?php get_header();?>

<?php if ( have_posts() ): while( have_posts() ): the_post(); ?>

<?php
	
	wp_enqueue_script('k2t-owlcarousel');
	wp_enqueue_script('k-project');

	$post_format = get_post_format(get_the_ID());
	// Load metadata in project
	$project_client = (function_exists('get_field')) ? get_field('project_client', get_the_ID()) : ''; $project_client = empty($project_client) ? '' : $project_client;
	$project_work = (function_exists('get_field')) ? get_field('project_work', get_the_ID()) : ''; $project_work = empty($project_work) ? '' : $project_work;
	$project_start_date = (function_exists('get_field')) ? get_field('project_start_date', get_the_ID()) : ''; $project_start_date = empty($project_start_date) ? '' : $project_start_date;
	$project_end_date = (function_exists('get_field')) ? get_field('project_end_date', get_the_ID()) : ''; $project_end_date = empty($project_end_date) ? '' : $project_end_date;
	$project_website = (function_exists('get_field')) ? get_field('project_website', get_the_ID()) : ''; $project_website = empty($project_website) ? '' : $project_website;
	$project_website_link = (function_exists('get_field')) ? get_field('project_website_link', get_the_ID()) : ''; $project_website_link = empty($project_website_link) ? '' : $project_website_link;
	$project_website_link = 'https://' . str_replace( 'https://', '', $project_website_link );

	$project_text_link = (function_exists('get_field')) ? get_field('project_text_link', get_the_ID()) : ''; $project_text_link = empty($project_text_link) ? '' : $project_text_link;
	$project_link = (function_exists('get_field')) ? get_field('project_link', get_the_ID()) : ''; $project_link = empty($project_link) ? '' : $project_link;
	
	
	$single_display_meta = (function_exists('get_field')) ? get_field('single_display_meta', get_the_ID()) : ''; $single_display_meta = empty($single_display_meta) ? 'show' : $single_display_meta;
	
	
	$project_sidebar_text = (function_exists('get_field')) ? get_field('project_sidebar_text', get_the_ID()) : ''; $project_sidebar_text = empty($project_sidebar_text) ? '' : $project_sidebar_text;
	$display_sticky_sidebar = (function_exists('get_field')) ? get_field('display_sticky_sidebar', get_the_ID(), true) : ''; $display_sticky_sidebar = empty($display_sticky_sidebar) ? 'show' : $display_sticky_sidebar;
	$project_sidebar_content = (function_exists('get_field')) ? get_field('project_sidebar_content', get_the_ID(), true) : ''; $project_sidebar_content = empty($project_sidebar_content) ? 'show' : $project_sidebar_content;

	$project_member = (function_exists('get_field')) ? get_field('project_member', get_the_ID()) : ''; $project_member = empty($project_member) ? '' : $project_member;

?>

<?php

 	$single_layout_class = '';
	if($project_sidebar_content != 'show'){
		$single_layout_class = 'sidebar-right fullwidth';
	}else{
		$single_layout_class = 'sidebar-right has-sidebar';
	}
	
	if($display_sticky_sidebar == 'show') $single_layout_class .= ' has-sticky-sidebar';

	// $single_layout_class .= ' single-project-' . $project_style;
	
?>

<article <?php echo post_class('single-project '.$single_layout_class);?>>

<div id="k2t-content" class="k2t-content">

	<?php include ( 'single-project-classic.php' ); ?>
	<div class="container">
		<?php if ($smof_data['project-related'] ) include ( 'project-related.php' ); ?>
	</div>
</div><!-- #k2t-content -->

</article>

<?php endwhile; endif;?>

<?php get_footer();?>