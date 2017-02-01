<?php
	global $wp_embed, $blog_arr;

	// Check post thumb
	$thumbnail = ( has_post_thumbnail( get_the_ID() ) ) ? true : false;

	// Get category of post
	$categories = get_the_terms( get_the_ID(), 'k-project-category' );

	// Get post format
	$format = get_post_format( get_the_ID() ); $format = empty( $format ) ? 'standard' : $format;

	// Load metadata in project
	$project_client = ( function_exists( 'get_field' ) ) ? get_field( 'project_client', get_the_ID() ) : ''; $project_client = empty( $project_client ) ? '' : $project_client;
	$project_location = ( function_exists( 'get_field' ) ) ? get_field( 'project_location', get_the_ID() ) : ''; $project_location = empty( $project_location ) ? '' : $project_location;
	$project_period = ( function_exists( 'get_field' ) ) ? get_field( 'project_period', get_the_ID() ) : ''; $project_period = empty( $project_period ) ? '' : $project_period;
	$project_sub_title = ( function_exists( 'get_field' ) ) ? get_field( 'project_sub_title', get_the_ID() ) : ''; $project_sub_title = empty( $project_sub_title ) ? '' : $project_sub_title;
	$hover_link = ( function_exists( 'get_field' ) ) ? get_field( 'hover_link', get_the_ID() ) : ''; $hover_link = empty( $hover_link ) ? '' : $hover_link;
	$project_video_format_url = ( function_exists( 'get_field' ) ) ? get_field( 'project_video_format_url', get_the_ID() ) : ''; $project_video_format_url = empty( $project_video_format_url ) ? '' : $project_video_format_url;
	$project_video_code = ( function_exists( 'get_field' ) ) ? get_field( 'project_video_code', get_the_ID() ) : ''; $project_video_code = empty( $project_video_code ) ? '' : $project_video_code;
	$project_audio_format_url = ( function_exists( 'get_field' ) ) ? get_field( 'project_audio_format_url', get_the_ID() ) : ''; $project_audio_format_url = empty( $project_audio_format_url ) ? '' : $project_audio_format_url;
	$project_media_file = ( function_exists( 'get_field' ) ) ? get_field( 'project_media_file', get_the_ID() ) : array(); $project_media_file = empty( $project_media_file ) ? array() : $project_media_file;
	$project_gallery = ( function_exists( 'get_field' ) ) ? get_field( 'project_gallery', get_the_ID() ) : array(); $project_gallery = empty( $project_gallery ) ? array() : $project_gallery;
	$project_display_info = ( function_exists( 'get_field' ) ) ? get_field( 'project_display_info', get_the_ID() ) : ''; $project_display_info = empty( $project_display_info ) ? 'excerpt' : $project_display_info;


    $project_member = (function_exists('get_field')) ? get_field('project_member', get_the_ID()) : ''; $project_member = empty($project_member) ? '' : $project_member;


	// Get HTML
	$title = get_the_title();
    $content = get_the_content();
    $post_link = get_permalink(get_the_ID());
    $date = get_the_date();
	$post_thumb_size = 'thumb_500x9999';
    $post_thumb = '<a href="'. esc_url( $post_link ) .'" title="'. esc_attr( $title ) .'">' . get_the_post_thumbnail(get_the_ID(), $post_thumb_size, array('alt' => trim(get_the_title()))) . '</a>';
	$post_thumb_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

	$media_html = '';
    if ( $format == 'video' ) {
        if ( !empty( $project_video_code ) ) {
            $media_html = $project_video_code;
        }elseif ( !empty( $project_video_format_url ) ) {
            $media_html = $wp_embed->run_shortcode( '[embed]' . $project_video_format_url . '[/embed]' );
        }elseif ( count( $project_media_file ) > 0 ) {
            $media_html = do_shortcode( '[video src="'.$project_media_file['url'].'"/]' );
        }
    }elseif ( $format == 'audio' ) {
        if ( count( $project_media_file ) > 0 ) {
            $media_html = do_shortcode( '[audio src="'.$project_media_file['url'].'"/]' );
        }else {
            $media_html = $wp_embed->run_shortcode( '[embed]' . $project_audio_format_url . '[/embed]' );
        }
    }

	// Post Class
	$post_classes = array( 'article', 'post', 'project', 'isotope-selector' );
	$post_classes[] = 'format-'. $format;
	if ( $thumbnail ) $post_classes[] = 'has-post-thumbnail'; else $post_classes[] = 'no-post-thumbnail';
	$post_classes[] = 'has-hover';
	//
	if ( count( $categories ) > 0 && is_array( $categories ) ) {
		foreach ( $categories as $key => $category ) {
			$post_classes[] = 'k2t-cat-'.$category->slug;
		}
	}
	$post_classes = implode( ' ', $post_classes );

?>

<article class="<?php echo esc_attr( $post_classes );?>"><div class="article-inner">

	<?php if( ( $format == 'audio' ) && !empty( $media_html ) && count($project_media_file) == 0 ):?>
        <?php $id = 'audio-' . rand(); ?>
        <div id="<?php echo esc_attr( $id );?>" class="white-popup">
            <?php echo esc_html( $media_html );?>
        </div>
    <?php elseif( ( $format == 'audio' || $format == 'video' ) && !empty( $media_html ) && count($project_media_file) > 0 ):?>
        <?php $id = 'audio-' . rand(); ?>
        <div id="<?php echo esc_attr( $id );?>" class="white-popup format-media-selfhost">
            <?php echo esc_html( $media_html );?>
        </div>
    <?php endif;?>

    <?php if ( $link_detail == 'ajax' ) :?>
        <?php $obj_id = 'obj-' . rand(); ?>
        <div id="<?php echo ( $obj_id );?>" class="white-popup k2t-single-project-ajax-parent">
            <div class="k2t-single-project-ajax">
                <div class="surface">
                    <div class="project-loading"><span></span></div>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if ( $format == 'gallery' && count( $project_gallery ) > 0 && is_array( $project_gallery ) ):?>

    <?php else :?>
        <div class="post-thumbnail thumbnail-image <?php if($format=='gallery') echo 'k2t-popup-gallery'?>">

            <div class="layer-table">
                <h2 class="title">
                    <a href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>">
                        <?php echo esc_html($title);?>
                    </a>
                </h2>
                <span class="category">
                    <?php
                        $cat_name = $categories[0]->name;
                        echo esc_html($cat_name);
                    ?>
                </span>
                <p class="content">
                    <?php 
                        $short_content = substr($content,0,50).'...';
                        echo ($short_content );
                    ?>
                </p>   
            </div><!-- .layer-table -->

            <?php if ( is_array( $project_member ) && count( $project_member ) > 0 ) : ?>
                <div class="teacher-avatar">
                    <?php foreach ( $project_member as $key => $teach ) : ?>
                            <!-- Avatar of Speaker -->
                            <?php if ( has_post_thumbnail( $teach->ID ) ) : ?>
                                <div class="k2t-element-hover">
                                    <a href="<?php echo get_the_permalink($teach->ID);?>" title="<?php echo get_the_title($teach->ID)?>"><?php echo get_the_post_thumbnail( $teach->ID, 'thumb_50x50' );?></a>
                                </div>
                            <?php endif;?>
                    <?php endforeach;?>
                </div>
            <?php endif;?>

            
            <?php if ( $thumbnail ): echo ( $post_thumb ); else:?>
            <img src="<?php echo plugin_dir_url( __FILE__ );?>../images/thumb-500x333.png" alt="<?php the_title();?>" />
            <?php endif;?>
            
                
            <?php if($format=='gallery'):?>
            <?php if(count($project_gallery) > 0 && is_array($project_gallery)):?>
                <?php foreach ( $project_gallery as $image ): ?>
                        
                    <?php if(is_array($image) && !empty($image['ID'])):?>
                    <a href="<?php echo ( $image['url'] );?>" style="display:none;"></a>
                    <?php elseif(!empty($image)):?>
                    <?php $img = wp_get_attachment_url($image);?>
                    <a href="<?php echo ( $image ); ?>" style="display:none;"></a>
                    <?php endif;?>
                
                <?php endforeach; ?>
            <?php endif;?>
            <?php endif;?>
                
        </div><!-- .post-thumbnail -->

    <?php endif; ?>


</div></article><!-- .article -->
