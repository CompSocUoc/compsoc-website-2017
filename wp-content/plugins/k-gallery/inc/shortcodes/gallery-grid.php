<?php
	global $wp_embed, $blog_arr;
	
	// Check post thumb
	$thumbnail = (has_post_thumbnail(get_the_ID())) ? true : false;
	
	// Get category of post
	$categories = get_the_terms(get_the_ID(), 'gallery-category');
	
	// Get HTML 
	$title 				= get_the_title();
	$post_link 			= get_permalink( get_the_ID() );
	$date 				= get_the_date();
	$post_thumb_size 	= 'thumb_600x600';
	$post_thumb 		= get_the_post_thumbnail( get_the_ID(), $post_thumb_size, array( 'alt' => trim( get_the_title() ) ) );
	$post_thumb_url 	= wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
	
	// Post Class
	$post_classes = array('article','post','project','isotope-selector');	
	if($thumbnail) $post_classes[] = 'has-post-thumbnail'; else $post_classes[] = 'no-post-thumbnail';
	$post_classes[] = 'has-hover';
	//
	if(count($categories) > 0 && is_array($categories)){
		foreach ($categories as $key => $category) {
			$post_classes[] = 'k2t-cat-'.$category->slug;
		}
	}
	$post_classes = implode(' ',$post_classes);
	
?>

<article class="<?php echo esc_attr( $post_classes ) ;?>"><div class="article-inner">
<div class="view view-first">
    <?php if ( $thumbnail ): echo ( $post_thumb ); else:?>
        <img src="<?php echo K2T_FRAMEWORK_URL . 'extensions/plugins/k2t-portfolio/assets/images/thumb-500x500.png' ?>" alt="<?php the_title();?>" />
    <?php endif;?>
    <div class="mask">
        <div class="pf-lightbox"><a href="<?php echo esc_url( $post_thumb_url );?>" class="k2t-popup-link"><?php _e( '+', 'k2t' ); ?></a></div>
    </div>
</div>
</div></article><!-- .article -->