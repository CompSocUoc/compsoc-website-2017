<?php
/**
 * The template for displaying post formats.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

// Get theme options
global $smof_data, $post, $blog_style;
$post_categories = wp_get_post_categories( get_the_ID() );
// Get blog style
$blog_style = ( empty( $blog_style ) || ! isset( $blog_style ) ) ? $smof_data['blog-style'] : $blog_style;

// Get post format
$post_format = get_post_format();

// Post format video
$video_source       = ( function_exists( 'get_field' ) ) ? get_field( 'video_format_source', get_the_ID() ) : '';
$video_source_link  = ( function_exists( 'get_field' ) ) ? get_field( 'video_url', get_the_ID() ) : '';
$video_source_embed = ( function_exists( 'get_field' ) ) ? get_field( 'video_code', get_the_ID() ) : '';
$video_source_local = ( function_exists( 'get_field' ) ) ? get_field( 'video_local', get_the_ID() ) : '';

// Post format audio
$audio_source       = ( function_exists( 'get_field' ) ) ? get_field( 'audio_format_source', get_the_ID() ) : '';
$audio_source_link  = ( function_exists( 'get_field' ) ) ? get_field( 'audio_url', get_the_ID() ) : '';
$audio_source_local = ( function_exists( 'get_field' ) ) ? get_field( 'audio_local', get_the_ID() ) : '';

// Post format gallery
$post_gallery = ( function_exists( 'get_field' ) ) ? get_field( 'post_gallery', get_the_ID() ) : array();
$auto_play    = ( function_exists( 'get_field' ) ) ? get_field( 'gallery_auto', get_the_ID() ) : '';
$duration     = ( function_exists( 'get_field' ) ) ? get_field( 'gallery_auto_time_wait', get_the_ID() ) : '';
$speed        = ( function_exists( 'get_field' ) ) ? get_field( 'gallery_speed', get_the_ID() ) : '';
$pagination   = ( function_exists( 'get_field' ) ) ? get_field( 'gallery_pagination', get_the_ID() ) : '';
$navigation   = ( function_exists( 'get_field' ) ) ? get_field( 'gallery_navigation', get_the_ID() ) : '';
$mouse        = ( function_exists( 'get_field' ) ) ? get_field( 'gallery_mousewheel', get_the_ID() ) : '';

// Post format quote
$quote_author  = ( function_exists( 'get_field' ) ) ? get_field( 'quote_author', get_the_ID() ) : '';
$quote_link    = ( function_exists( 'get_field' ) ) ? get_field( 'author_quote_url', get_the_ID() ) : '';
$quote_content = ( function_exists( 'get_field' ) ) ? get_field( 'quote_content', get_the_ID() ) : '';

$image_size = 'thumb_1200x675';
if ( $blog_style == 'medium' ){
	$image_size = 'thumb_500x500';
}
if ( $blog_style == 'grid' ){
	$image_size = 'thumb_500x500';
}
if ( $blog_style == 'masonry' ){
	$image_size = 'thumb_500x9999';
}
?>

<?php if ( $post_format != 'quote' ) :?><div class="flx-entry-thumb"><?php endif;?>
 <?php
	switch ( $post_format ) :
		case 'video':
				if ( 'link' == $video_source ) :
					echo do_shortcode( '[vc_video link="' . esc_url( $video_source_link ) . '"/]' );
				elseif ( 'embed' == $video_source ) :
					echo ( $video_source_embed );
				elseif ( 'local' == $video_source ) :
					echo do_shortcode('[video src="' . esc_url( $video_source_local['url'] ) . '"/]');
				endif;
			break;
		case 'audio':
				if ( 'link' == $audio_source ) :
					global $wp_embed;
						$media_result = $wp_embed->run_shortcode( '[embed]' . esc_url( $audio_source_link ) . '[/embed]' );
					echo ( $media_result );
				elseif ( 'local' == $audio_source ) :
					echo do_shortcode('[audio src="' . esc_url( $audio_source_local['url'] ) . '"/]');
				endif;
			break;
		case 'gallery':
				if ( count( $post_gallery ) > 0 && is_array( $post_gallery ) ) :
					echo '<div class="owl-carousel" 
						data-items="1" data-autoPlay="false" data-margin="0" data-loop="true" data-nav="'. esc_attr( $navigation ) .'"
						data-dots="'. esc_attr( $pagination ) .'" data-mobile="1" data-tablet="1" data-desktop="1">';
						foreach ( $post_gallery as $slide ):

							if ( is_array( $slide ) && ! empty( $slide['ID'] ) ) : $image = wp_get_attachment_image( $slide['ID'], $image_size ); ?>
								<div class="item"> 
									<?php echo ( $image ); ?>
								</div>

							<?php elseif ( ! empty( $slide ) ) : $image = wp_get_attachment_image( $slide, $image_size ); ?>
								<div class="item"> 
									<?php echo ( $image ); ?>
								</div>
							<?php endif;

						endforeach;
					echo '</div>';
				else :
					the_post_thumbnail( $image_size );
				endif;
			break;
		case 'quote':
			echo '
                <div class="quote-wrapper">
                	<div class="quote-inner">
                    	
                        	<div class="quote-content">
	                    		<div class="quote"><a href="#">'. $quote_content .'</a></div>
	                            <p class="author"><a href="'. esc_url($quote_link) .'">'. esc_html( $quote_author ) .'</a></p>
	                    	</div><!--end:quote-content-->
                                                           	
                    </div><!--end:quote-inner-->
                </div><!--end:quote-wrapper-->
			';
			break;
		default:
			if ( is_single() ) {
				if ( has_post_thumbnail() && get_post_type() != 'sfwd-quiz' ) :
					echo get_the_post_thumbnail( get_the_ID(), 'full' );
				elseif ( isset( $smof_data['place_holder'] ) && $smof_data['place_holder'] != '0' && get_post_type() != 'sfwd-quiz' && ( get_post_type() != 'sfwd-certificates' )  ) :
					echo '<img src="' . get_template_directory_uri() . '/assets/img/placeholder/1000x500.png" alt="' . get_the_title() . '" />';
				endif;
			} else {
				if ( has_post_thumbnail() ) :
					echo '<a href="'. esc_url( get_permalink() ) .'">'. get_the_post_thumbnail( get_the_ID(), $image_size ) .'</a>';
				elseif ( isset( $smof_data['place_holder'] ) && $smof_data['place_holder'] != '0' ) :
					echo '<a href="'. esc_url( get_permalink() ) .'"><img src="' . get_template_directory_uri() . '/assets/img/placeholder/'. str_replace( 'thumb_', '', $image_size ) .'.png" alt="' . get_the_title() . '" /></a>';
				endif;
			}
	endswitch;
?>	
<?php if ( $post_format != 'quote' ) :?></div><!--end:flx-entry-thumb--><?php endif;?>