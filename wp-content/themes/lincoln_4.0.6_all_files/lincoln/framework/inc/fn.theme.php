<?php
/**
 * Main functions for theme.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Lincoln 1.0
	 */
	function k2t_setup() {
		global $smof_data, $content_width;
		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on grid, use a find and replace
		 * to change 'k2t' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'k2t', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );
		
		/**
		 * Add custom header default
		 */
		add_theme_support( 'custom-header' );		
		
		/**
		 * Add custom background default
		 */
		add_theme_support( "custom-background" );
	
		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array( 'video', 'audio', 'gallery', 'link', 'quote', 'image' ) );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		// Add images size
		add_image_size( 'thumb_500x500', 500, 500, true );
		add_image_size( 'thumb_600x600', 600, 600, true );
		add_image_size( 'thumb_500x9999', 700, 9999, false );
		add_image_size( 'thumb_1000x500', 1000, 500, true );
		add_image_size( 'thumb_1200x675', 1200, 675, true );

		add_image_size( 'thumb_55x55', 55, 55, true ); // For speaker on single course and single event
		add_image_size( 'thumb_80x80', 80, 80, true ); // For LearnDash widget

		add_image_size( 'thumb_555x311', 555, 311, true ); // For Blog post style 2
		

		/**
		 * Add default woocommerce plugin.
		 */
		add_theme_support( 'woocommerce' );	

		/**
		 * Add support title-tag
		 */
		add_theme_support( 'title-tag' );		
		
		/**
		 * This theme uses wp_nav_menu() in one location.
		 *
		 * @link http://codex.wordpress.org/Post_Formats
		 */
		register_nav_menus(
			array(
				'mobile'  => __( 'Mobile Menu', 'k2t' ),
				'primary' => __( 'Main Menu', 'k2t' ),
			)
		);
		
		/**
		 * Set the content width based on the theme's design and stylesheet.
		 */
		if ( ! isset( $content_width ) ) {
			$content_width = isset( $smof_data['content-width'] ) ? $smof_data['content-width'] : 1100;
		}
		
	}
	add_action( 'after_setup_theme', 'k2t_setup' );
}

/**
 * Adds sticky menu classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
if ( ! function_exists( 'k2t_add_body_class' ) ) {
	function k2t_add_body_class( $classes ) {
		global $smof_data;
		if ( ! empty( $smof_data['vertical-menu'] ) ) {
			$classes[] = 'vertical';
		}

		if ( ! empty( $smof_data['boxed-layout'] ) ) {
			$classes[] = 'boxed';
		}

		return $classes;
	}
	add_filter( 'body_class', 'k2t_add_body_class' );
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	function k2t_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'k2t' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'k2t_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function k2t_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'k2t_render_title' );
endif;

/**
 * Register required plugins.
 *
 * @return  void
 */
if ( ! function_exists( 'k2t_register_theme_dependency' ) ) {
	function k2t_register_theme_dependency() {
		$theme = wp_get_theme();
		$version = $theme->version;
		$plugins = array(
			array(
				'name'     => 'WooCommerce',
				'slug'     => 'woocommerce',
				'required' => false,
			),
			array(
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => false,
			),
			array(
				'name'     => 'Visual composer',
				'slug'     => 'js_composer',
				'source'   => K2T_FRAMEWORK_PATH . 'extensions/plugins/js_composer.zip',
				'required' => true,
			),
			array(
				'name'     => 'Advanced Custom Fields Pro',
				'slug'     => 'advanced-custom-fields-pro',
				'source'   => K2T_FRAMEWORK_PATH . 'extensions/plugins/advanced-custom-fields-pro.zip',
				'required' => true,
			),
			array(
				'name'     => 'Revolution Slider',
				'slug'     => 'revslider',
				'source'   => K2T_FRAMEWORK_PATH . 'extensions/plugins/revslider.zip',
				'required' => false,
			),
			array(
				'name'     => 'Envato Market',
				'slug'     => 'envato-market',
				'source'   => K2T_FRAMEWORK_PATH . 'extensions/plugins/envato-market.zip',
				'required' => false,
			),
			array(
				'name'               => 'K Shortcodes',
				'slug'               => 'k-shortcodes',
				'source'             => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-shortcodes.zip',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
				'version'			 => $version,
				'message'			 => 'Important update',
			),
			array(
				'name'     => 'K Courses',
				'slug'     => 'k-course',
				'source'   => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-course.zip',
				'required' => false,
				'version'  => $version,
			),
			array(
				'name'     => 'K Event',
				'slug'     => 'k-event',
				'source'   => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-event.zip',
				'required' => false,
				'version'  => $version,
			),
			array(
				'name'     => 'K Gallery',
				'slug'     => 'k-gallery',
				'source'   => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-gallery.zip',
				'required' => false,
				'version'  => $version,
			),
			array(
				'name'     => 'K Project',
				'slug'     => 'k-project',
				'source'   => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-project.zip',
				'required' => false,
				'version'  => $version,
			),
			array(
				'name'     => 'K Teacher',
				'slug'     => 'k-teacher',
				'source'   => K2T_FRAMEWORK_PATH . 'extensions/plugins/k-teacher.zip',
				'required' => false,
				'version'  => $version,
			),
			array(
				'name'     => 'Instagram Feed',
				'slug'     => 'instagram-feed',
				'required' => false,
			),
			array(
				'name'     => 'YITH WooCommerce Wishlist',
				'slug'     => 'yith-woocommerce-wishlist',
				'required' => false,
			),
		);

		tgmpa( $plugins );
	}
	add_action( 'tgmpa_register', 'k2t_register_theme_dependency' );
}

/**
 * Print custom code at the end of head section.
 *
 * @package Lincoln
 */
if ( ! function_exists( 'k2t_add_head_code' ) ) {
	function k2t_add_head_code() {
		global $smof_data;
		if ( isset ( $smof_data['header_code'] ) && $smof_data['header_code'] ) {
			echo ( $smof_data['header_code'] );
		}
	}
	add_action( 'wp_head', 'k2t_add_head_code' );
}

/**
 * Print custom code at the end of body section.
 *
 * @package Lincoln
 */
if ( ! function_exists( 'k2t_add_footer_code' ) ) {
	function k2t_add_footer_code() {
		global $smof_data;
		if ( isset ( $smof_data['footer_code'] ) && $smof_data['footer_code'] ) {
			echo ( $smof_data['footer_code'] );
		}
	}
	add_action( 'wp_footer', 'k2t_add_footer_code' );
}

/**
 * Change favicon option
 *
 * @package Lincoln
 */
if ( ! function_exists( 'k2t_extra_icons' ) ) {
	function k2t_extra_icons() {
		global $smof_data;
		if ( isset ( $smof_data['favicon'] ) && $smof_data['favicon'] ) {
			echo '<link sizes="16x16" href="'. esc_url( $smof_data['favicon'] ) .'" rel="icon" />';
		}
		if ( isset ( $smof_data['apple-iphone-icon'] ) && $smof_data['apple-iphone-icon'] ) {
			echo '<link rel="icon" sizes="57x57" href="' . esc_url( $smof_data["apple-iphone-icon"] ) . '" />';
		}
		if ( isset ( $smof_data['apple-iphone-retina-icon'] ) && $smof_data['apple-iphone-retina-icon'] ) {
			echo '<link rel="icon" sizes="114x114" href="' . esc_url( $smof_data["apple-iphone-retina-icon"] ) . '" />';
		}
		if ( isset ( $smof_data['apple-ipad-icon'] ) && $smof_data['apple-ipad-icon'] ) {
			echo '<link rel="icon" sizes="72x72" href="' . esc_url( $smof_data["apple-ipad-icon"] ) . '" />';
		}
		if ( isset ( $smof_data['apple-ipad-retina-icon'] ) && $smof_data['apple-ipad-retina-icon'] ) {
			echo '<link rel="icon" sizes="144x144" href="' . esc_url( $smof_data["apple-ipad-retina-icon"] ) . '" />';
		}
	}
	add_action( 'wp_head', 'k2t_extra_icons', 1 );
}

/**
 * Add a thumbnail column in edit.php
 * Source: http://wordpress.org/support/topic/adding-custum-post-type-thumbnail-to-the-edit-screen
 */
if ( ! function_exists( 'k2t_columns_filter' ) ) {
	function k2t_columns_filter( $columns ) {
		$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'k2t' ) );
		$columns = array_slice( $columns, 0, 1, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
		return $columns;
	}
	add_filter( 'manage_edit-post_columns', 'k2t_columns_filter', 10, 1 );
}
if ( ! function_exists( 'k2t_add_thumbnail_value_editscreen' ) ) {
	function k2t_add_thumbnail_value_editscreen( $column_name, $post_id ) {

		$width  = (int) 50;
		$height = (int) 50;

		if ( 'thumbnail' == $column_name ) {
			// thumbnail of WP 2.9
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
			// image from gallery
			$attachments = get_children( array( 'post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image' ) );
			if ( $thumbnail_id )
				$thumb = wp_get_attachment_image( $thumbnail_id, array( $width, $height ), true );
			elseif ( $attachments ) {
				foreach ( $attachments as $attachment_id => $attachment ) {
					$thumb = wp_get_attachment_image( $attachment_id, array( $width, $height ), true );
				}
			}
			if ( isset( $thumb ) && $thumb ) {
				echo ( $thumb );
			} else {
				echo '<em>' . __( 'None', 'k2t' ) . '</em>';
			}
		}
	}
	add_action( 'manage_posts_custom_column', 'k2t_add_thumbnail_value_editscreen', 10, 2 );
}

/* =========== Retina Logo ================ */
if ( !function_exists( 'k2t_replace_retina_logo' ) ) {
    function k2t_replace_retina_logo() {
        global $smof_data;
        $logo = isset( $smof_data['logo'] ) ? $smof_data['logo'] : get_template_directory_uri() . '/assets/img/logo.png';
        $logo_s = ( isset( $logo ) && file_exists( $logo ) ) ? getimagesize( $logo ) : array();
        echo "<sc"."ript>";?>
        jQuery(document).ready(function(){
            var retina = window.devicePixelRatio > 1 ? true : false;
            <?php if ( isset( $smof_data['retina-logo'] ) && $smof_data['retina-logo'] ): ?>
            if(retina) {
                jQuery('.k2t-logo img').attr('src', '<?php echo $smof_data["retina-logo"]; ?>');
                <?php if ( isset( $logo_s[0] ) && !empty( $logo_s[0] ) ):?>
                jQuery('.k2t-logo img').attr('width', '<?php echo $logo_s[0]; ?>');
                <?php endif;?>
                <?php if ( isset( $logo_s[1] ) && !empty( $logo_s[1] ) ):?>
                jQuery('.k2t-logo img').attr('height', '<?php echo $logo_s[1]; ?>');
                <?php endif;?>
            }
            <?php endif; ?>
        });
        <?php echo "</sc"."ript>";
    }
    add_action( 'wp_head', 'k2t_replace_retina_logo' );
}

// Parallax
if( function_exists( 'k2t_parallax_trigger_script' ) ):

	function k2t_parallax_trigger_script(){
		echo '
		<scr' . 'ipt>
			(function($) {
				"use strict";

				$(document).ready(function() {
					$.stellar({
						horizontalScrolling: false,
						verticalOffset: 40
					});
				});
			})(jQuery);
		</scr' . 'ipt>';
	}
	add_action( 'wp_footer', 'k2t_parallax_trigger_script' );

endif;


/**
 * Custom function to use to open and display each comment.
 *
 * @since 1.0
 */
if ( ! function_exists( 'k2t_comments' ) ) :
	function k2t_comments( $comment, $args, $depth ) {
	// Globalize comment object
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) :

			case 'pingback'  :
			case 'trackback' :
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p>
						<?php
						_e( 'Pingback:', 'k2t' );
						comment_author_link();
						edit_comment_link( __( 'Edit', 'k2t' ), '<span class="edit-link">', '</span>' );
						?>
					</p>
				<?php
			break;

			default :
				global $post;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment-body">
						<?php
						echo get_avatar( $comment, 70 );
						
						if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'k2t' ); ?></p>
						<?php endif; ?>			

						<section class="comment-content comment">
							<header class="comment-meta">
								<?php
								printf(
									'<cite class="comment-author">%1$s</cite>',
									'<span>' . get_comment_author_link() . '</span>',
									( $comment->user_id == $post->post_author ) ? '<span class="author-post">' . __( 'Post author', 'k2t' ) . '</span>' : ''
								);

								?>
							</header>
							<?php comment_text(); ?>
							<footer>
								<div class="action-link">
									<?php
									edit_comment_link( __( '<span><i class="zmdi zmdi-edit"></i>Edit</span>', 'k2t' ) );
									comment_reply_link(
										array_merge(
											$args,
											array(
												'reply_text' => __( '<span><i class="zmdi zmdi-mail-reply"></i>Reply</span>', 'k2t' ),
												'depth'      => $depth,
												'max_depth'  => $args['max_depth'],
											)
										)
									);
									?>
								</div><!-- .action-link -->
							</footer>
						</section><!-- .comment-content -->						
					</article><!-- #comment- -->
				<?php
			break;

		endswitch;
	}
endif;

/**
 * Add social network.
 *
 * @since 1.0
 */
if ( ! function_exists( 'k2t_social_array' ) ) {
	function k2t_social_array() {
		return array(
			'facebook'		=>	__( ' Facebook', 'k2t' ),
			'twitter'		=>	__( ' Twitter', 'k2t' ),
			'google-plus'	=>	__( ' Google+', 'k2t' ),
			'linkedin'	 	=>	__( ' LinkedIn', 'k2t' ),
			'tumblr'	 	=>	__( ' Tumblr', 'k2t' ),
			'pinterest'	 	=>	__( ' Pinterest', 'k2t' ),
			'youtube'	 	=>	__( ' YouTube', 'k2t' ),
			'skype'	 		=>	__( ' Skype', 'k2t' ),
			'instagram'	 	=>	__( ' Instagram', 'k2t' ),
			'delicious'	 	=>	__( ' Delicious', 'k2t' ),
			'reddit'		=>	__( ' Reddit', 'k2t' ),
			'stumbleupon'	=>	__( ' StumbleUpon', 'k2t' ),
			'wordpress'	 	=>	__( ' WordPress', 'k2t' ),
			'joomla'		=>	__( ' Joomla', 'k2t' ),
			'blogger'	 	=>	__( ' Blogger', 'k2t' ),
			'vimeo'	 		=>	__( ' Vimeo', 'k2t' ),
			'yahoo'	 		=>	__( ' Yahoo!', 'k2t' ),
			'flickr'	 	=>	__( ' Flickr', 'k2t' ),
			'picasa'	 	=>	__( ' Picasa', 'k2t' ),
			'deviantart'	=>	__( ' DeviantArt', 'k2t' ),
			'github'	 	=>	__( ' GitHub', 'k2t' ),
			'stackoverflow'	=>	__( ' StackOverFlow', 'k2t' ),
			'xing'	 		=>	__( ' Xing', 'k2t' ),
			'flattr'	 	=>	__( ' Flattr', 'k2t' ),
			'foursquare'	=>	__( ' Foursquare', 'k2t' ),
			'paypal'	 	=>	__( ' Paypal', 'k2t' ),
			'yelp'	 		=>	__( ' Yelp', 'k2t' ),
			'soundcloud'	=>	__( ' SoundCloud', 'k2t' ),
			'lastfm'	 	=>	__( ' Last.fm', 'k2t' ),
			'lanyrd'	 	=>	__( ' Lanyrd', 'k2t' ),
			'dribbble'	 	=>	__( ' Dribbble', 'k2t' ),
			'forrst'	 	=>	__( ' Forrst', 'k2t' ),
			'steam'	 		=>	__( ' Steam', 'k2t' ),
			'behance'		=>	__( ' Behance', 'k2t' ),
			'mixi'			=>	__( ' Mixi', 'k2t' ),
			'weibo'			=>	__( ' Weibo', 'k2t' ),
			'renren'		=>	__( ' Renren', 'k2t' ),
			'evernote'		=>	__( ' Evernote', 'k2t' ),
			'dropbox'		=>	__( ' Dropbox', 'k2t' ),
			'bitbucket'		=>	__( ' Bitbucket', 'k2t' ),
			'trello'		=>	__( ' Trello', 'k2t' ),
			'vk'			=>	__( ' VKontakte', 'k2t' ),
			'home'			=>	__( ' Homepage', 'k2t' ),
			'envelope-alt'	=>	__( ' Email', 'k2t' ),
			'rss'			=>	__( ' RSS', 'k2t' ),
		);
	}
}

/**
 * Pagination render.
 *
 * @since 1.0
 */
if ( ! function_exists( 'k2t_get_pagination' ) ) {
	function k2t_get_pagination( $custom_query = false ) {
		global $wp_query;

		if ( ! $custom_query ) $custom_query = $wp_query;

		$big = 999999999; // need an unlikely integer
		$pagination = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total' => $custom_query->max_num_pages,
			'type'   => 'list',
			'prev_text'    => sprintf( __( '%s &larr; Previous', 'k2t' ), '<i class="icon-angle-left"></i>' ),
			'next_text'    => sprintf( __( 'Next &rarr; %s', 'k2t' ), '<i class="icon-angle-right"></i>' ),
		) );

		if ( $pagination ) {
			return '<div class="srol-pagination">'. $pagination . '<div class="clearfix"></div></div>';
		} else return;
	}
}

/**
 * Social share.
 *
 * @since 1.0
 */
if ( ! function_exists( 'k2t_social_share' ) ) {
	function k2t_social_share() {
		global $smof_data, $post;
		$twitter_username = isset ( $smof_data['twitter-username'] ) ? trim( $smof_data['twitter-username'] ) : '';
		$pre = '';
		if ( is_single() ) {
			if ( is_singular( 'post-project' ) ) {
				$pre = 'project-';
			} else if ( is_singular( 'post-k-event' ) ) {
				$pre = 'event-';
			} else if ( is_singular( 'post-k-course' ) ) {
				$pre = 'course-';
			} else {
				$pre = 'single-';	
			}
		} elseif ( is_category() ) {
			$pre = 'blog-';
		}

		// Get post thumbnail
		$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), false, '' ); ?>

		<div class="k2t-social-share">
			<ul class="social">
				<?php if ( isset ( $smof_data[$pre . 'social-share-facebook'] ) && $smof_data[$pre . 'social-share-facebook'] ):?>
					<li>
						<a class="facebook" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
							<i class="fa fa-facebook"></i>
							<span><?php _e( 'Facebook', 'k2t' ); ?></span>
						</a>
					</li>
				<?php endif;?>

				<?php if ( isset ( $smof_data[$pre . 'social-share-twitter'] ) && $smof_data[$pre . 'social-share-twitter'] ):?>
					<li>
						<a class="twitter" href="https://twitter.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
							<i class="fa fa-twitter"></i>
							<span><?php _e( 'Twitter', 'k2t' ); ?></span>
						</a>
					</li>
				<?php endif;?>

				<?php if ( isset ( $smof_data[$pre . 'social-share-google'] ) && $smof_data[$pre . 'social-share-google'] ):?>
					<li>
						<a class="googleplus" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
							<i class="fa fa-google-plus"></i>
							<span><?php _e( 'Google Plus', 'k2t' ); ?></span>
						</a>
					</li>
				<?php endif;?>

				<?php if ( isset ( $smof_data[$pre . 'social-share-linkedin'] ) && $smof_data[$pre . 'social-share-linkedin'] ):?>
					<li>
						<a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_permalink() );?>&title=<?php echo urlencode( get_the_title() );?>" title="<?php _e( 'LinkedIn', 'k2t' );?>">
							<i class="fa fa-linkedin"></i>
							<span><?php _e( 'Linkedin', 'k2t' ); ?></span>
						</a>
					</li>
				<?php endif;?>

				<?php if ( isset ( $smof_data[$pre . 'social-share-tumblr'] ) && $smof_data[$pre . 'social-share-tumblr'] ):?>
					<li>
						<a class="tumblr" href="https://www.tumblr.com/share/link?url=<?php echo urlencode( get_permalink() );?>&name=<?php echo urlencode( get_the_title() );?>" title="<?php _e( 'Tumblr', 'k2t' );?>">
							<i class="fa fa-tumblr"></i>
							<span><?php _e( 'Tumblr', 'k2t' ); ?></span>
						</a>
					</li>
				<?php endif;?>

				<?php if ( isset ( $smof_data[$pre . 'social-share-email'] ) && $smof_data[$pre . 'social-share-email'] ):?>
					<li>
						<a class="em" href="mailto:?subject=<?php the_title(); ?>&body=<?php echo strip_tags( apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ); ?> <?php the_permalink(); ?>">
							<i class="fa fa-envelope"></i>
							<span><?php _e( 'Email', 'k2t' ); ?></span>
						</a>
					</li>
				<?php endif;?>
			</ul><!-- .social -->
		</div><!-- .social-share -->
	<?php
	}
}

/**
 * Get related post
 *
 * @link http://wordpress.org/support/topic/custom-query-related-posts-by-common-tag-amount
 * @link http://pastebin.com/NnDzdSLd
 */
if ( ! function_exists( 'get_related_tag_posts_ids' ) ) {
	function get_related_tag_posts_ids( $post_id, $number = 5, $taxonomy = 'post_tag', $post_type = 'post' ) {

		$related_ids = false;

		$post_ids = array();
		// get tag ids belonging to $post_id
		$tag_ids = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );
		if ( $tag_ids ) {
			// get all posts that have the same tags
			$tag_posts = get_posts(
				array(
					'post_type'   => $post_type,
					'posts_per_page' => -1, // return all posts
					'no_found_rows'  => true, // no need for pagination
					'fields'         => 'ids', // only return ids
					'post__not_in'   => array( $post_id ), // exclude $post_id from results
					'tax_query'      => array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'id',
							'terms'    => $tag_ids,
							'operator' => 'IN'
						)
					)
				)
			);

			// loop through posts with the same tags
			if ( $tag_posts ) {
				$score = array();
				$i = 0;
				foreach ( $tag_posts as $tag_post ) {
					// get tags for related post
					$terms = wp_get_post_terms( $tag_post, $taxonomy, array( 'fields' => 'ids' ) );
					$total_score = 0;

					foreach ( $terms as $term ) {
						if ( in_array( $term, $tag_ids ) ) {
							++$total_score;
						}
					}

					if ( $total_score > 0 ) {
						$score[$i]['ID'] = $tag_post;
						// add number $i for sorting
						$score[$i]['score'] = array( $total_score, $i );
					}
					++$i;
				}

				// sort the related posts from high score to low score
				uasort( $score, 'sort_tag_score' );
				// get sorted related post ids
				$related_ids = wp_list_pluck( $score, 'ID' );
				// limit ids
				$related_ids = array_slice( $related_ids, 0, (int) $number );
			}
		}
		return $related_ids;
	}
}
if ( ! function_exists( 'sort_tag_score' ) ) {
	function sort_tag_score( $item1, $item2 ) {
		if ( $item1['score'][0] != $item2['score'][0] ) {
			return $item1['score'][0] < $item2['score'][0] ? 1 : -1;
		} else {
			return $item1['score'][1] < $item2['score'][1] ? -1 : 1; // ASC
		}
	}
}

/**
 * Add field to custom user profile
 *
 * @since 1.0
 */
if ( ! function_exists( 'k2t_add_custom_user_profile' ) ) {
	function k2t_add_custom_user_profile( $user ) {
		?>
		<table class="form-table">
			<tr>
				<th><label for="user-location"><?php _e( 'User Location', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="user-location" id="user-location" value="<?php echo esc_attr( get_the_author_meta( 'user-location', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="facebook-text"><?php _e( 'Facebook Text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="facebook-text" id="facebook-text" value="<?php echo esc_attr( get_the_author_meta( 'facebook-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="facebook"><?php _e( 'Facebook Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="twitter-text"><?php _e( 'twitter text ', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="twitter-text" id="twitter-text" value="<?php echo esc_attr( get_the_author_meta( 'twitter-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="twitter"><?php _e( 'Twitter Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="google-plus-text"><?php _e( 'Google+ text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="google-plus-text" id="google-plus-text" value="<?php echo esc_attr( get_the_author_meta( 'google-plus-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="google-plus"><?php _e( 'Google+ Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="google-plus" id="google-plus" value="<?php echo esc_attr( get_the_author_meta( 'google-plus', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="pinterest-text"><?php _e( 'pinterest-text text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="pinterest-text" id="pinterest-text" value="<?php echo esc_attr( get_the_author_meta( 'pinterest-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="pinterest"><?php _e( 'Pinterest Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="pinterest" id="pinterest" value="<?php echo esc_attr( get_the_author_meta( 'pinterest', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="k2t-youtube-text"><?php _e( 'Youtube Text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="k2t-youtube-text" id="k2t-youtube-text" value="<?php echo esc_attr( get_the_author_meta( 'k2t-youtube-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="k2t-youtube"><?php _e( 'Youtube Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="k2t-youtube" id="k2t-youtube" value="<?php echo esc_attr( get_the_author_meta( 'k2t-youtube', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="vimeo-text"><?php _e( 'Vimeo Text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="vimeo-text" id="vimeo-text" value="<?php echo esc_attr( get_the_author_meta( 'vimeo-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="vimeo"><?php _e( 'Vimeo Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="vimeo" id="vimeo" value="<?php echo esc_attr( get_the_author_meta( 'vimeo', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="linkedin-text"><?php _e( 'Linkedin Text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="linkedin-text" id="linkedin-text" value="<?php echo esc_attr( get_the_author_meta( 'linkedin-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="linkedin"><?php _e( 'Linkedin Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="tumblr-text"><?php _e( 'Tumblr Text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="tumblr-text" id="tumblr-text" value="<?php echo esc_attr( get_the_author_meta( 'tumblr-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="tumblr"><?php _e( 'Tumblr Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="tumblr" id="tumblr" value="<?php echo esc_attr( get_the_author_meta( 'tumblr', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="custom_email-text"><?php _e( 'Email Text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="custom_email-text" id="custom_email-text" value="<?php echo esc_attr( get_the_author_meta( 'custom_email-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="custom_email"><?php _e( 'Email Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="custom_email" id="custom_email" value="<?php echo esc_attr( get_the_author_meta( 'custom_email', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="flickr-text"><?php _e( 'flickr text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="flickr-text" id="flickr-text" value="<?php echo esc_attr( get_the_author_meta( 'flickr-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="flickr"><?php _e( 'Flickr Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="flickr" id="flickr" value="<?php echo esc_attr( get_the_author_meta( 'flickr', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="behance-text"><?php _e( 'Behance Text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="behance-text" id="behance-text" value="<?php echo esc_attr( get_the_author_meta( 'behance-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="behance"><?php _e( 'Behance Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="behance" id="behance" value="<?php echo esc_attr( get_the_author_meta( 'behance', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="dribbble-text"><?php _e( 'dribbble Text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="dribbble-text" id="dribbble-text" value="<?php echo esc_attr( get_the_author_meta( 'dribbble-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="dribbble"><?php _e( 'Dribbble Link', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="dribbble" id="dribbble" value="<?php echo esc_attr( get_the_author_meta( 'dribbble', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="skype-text"><?php _e( 'Skype Text', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="skype-text" id="skype-text" value="<?php echo esc_attr( get_the_author_meta( 'skype-text', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th><label for="skype"><?php _e( 'Skype ID', 'k2t' ); ?></label></th>
				<td>
					<input type="text" name="skype" id="skype" value="<?php echo esc_attr( get_the_author_meta( 'skype', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"></span>
				</td>
			</tr>
		</table>
	<?php
	}
}

/**
 * Save custom user profile.
 *
 * @since 1.0
 */
if ( ! function_exists( 'k2t_save_custom_user_profile' ) ) {
	function k2t_save_custom_user_profile( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) )
			return FALSE;
		update_user_meta( $user_id, 'user-location', $_POST['user-location'] );
		update_user_meta( $user_id, 'facebook-text', $_POST['facebook-text'] );
		update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
		update_user_meta( $user_id, 'twitter-text', $_POST['twitter-text'] );
		update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
		update_user_meta( $user_id, 'google-plus-text', $_POST['google-plus-text'] );
		update_user_meta( $user_id, 'google-plus', $_POST['google-plus'] );
		update_user_meta( $user_id, 'pinterest-text', $_POST['pinterest-text'] );
		update_user_meta( $user_id, 'pinterest', $_POST['pinterest'] );
		update_user_meta( $user_id, 'k2t-youtube-text', $_POST['k2t-youtube-text'] );
		update_user_meta( $user_id, 'k2t-youtube', $_POST['k2t-youtube'] );
		update_user_meta( $user_id, 'vimeo-text', $_POST['vimeo-text'] );
		update_user_meta( $user_id, 'vimeo', $_POST['vimeo'] );
		update_user_meta( $user_id, 'linkedin-text', $_POST['linkedin-text'] );
		update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
		update_user_meta( $user_id, 'tumblr-text', $_POST['tumblr-text'] );
		update_user_meta( $user_id, 'tumblr', $_POST['tumblr'] );
		update_user_meta( $user_id, 'custom_email-text', $_POST['custom_email-text'] );
		update_user_meta( $user_id, 'custom_email', $_POST['custom_email'] );
		update_user_meta( $user_id, 'flickr-text', $_POST['flickr-text'] );
		update_user_meta( $user_id, 'flickr', $_POST['flickr'] );
		update_user_meta( $user_id, 'behance-text', $_POST['behance-text'] );
		update_user_meta( $user_id, 'behance', $_POST['behance'] );
		update_user_meta( $user_id, 'dribbble-text', $_POST['dribbble-text'] );
		update_user_meta( $user_id, 'dribbble', $_POST['dribbble'] );
		update_user_meta( $user_id, 'skype-text', $_POST['skype-text'] );
		update_user_meta( $user_id, 'skype', $_POST['skype'] );
	}
}
add_action( 'show_user_profile', 'k2t_add_custom_user_profile' );
add_action( 'edit_user_profile', 'k2t_add_custom_user_profile' );
add_action( 'personal_options_update', 'k2t_save_custom_user_profile' );
add_action( 'edit_user_profile_update', 'k2t_save_custom_user_profile' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @since 1.0
 */
if ( ! function_exists( 'k2t_widgets_init' ) ) {
	function k2t_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Primary Sidebar', 'k2t' ),
			'id'            => 'primary_sidebar',
			'description'   => __( 'The primary sidebar of your site, appears on the right or left of post/page content.', 'k2t' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => __( 'LearnDash Sidebar', 'k2t' ),
			'id'            => 'learndash_sidebar',
			'description'   => __( 'LearnDash sidebar', 'k2t' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => __( 'Secondary Sidebar', 'k2t' ),
			'id'            => 'secondary_sidebar',
			'description'   => __( 'The secondary sidebar of your site, appears on the right or left of post/page content.', 'k2t' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer 1', 'k2t' ),
			'id'            => 'footer-1',
			'description'   => __( 'Footer sidebar number 1, used in the footer area.', 'k2t' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer 2', 'k2t' ),
			'id'            => 'footer-2',
			'description'   => __( 'Footer sidebar number 2, used in the footer area.', 'k2t' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer 3', 'k2t' ),
			'id'            => 'footer-3',
			'description'   => __( 'Footer sidebar number 3, used in the footer area.', 'k2t' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer 4', 'k2t' ),
			'id'            => 'footer-4',
			'description'   => __( 'Footer sidebar number 4, used in the footer area.', 'k2t' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer bottom', 'k2t' ),
			'id'            => 'footer-bottom',
			'description'   => __( 'Footer sidebar bottom, used in the bottom footer area.', 'k2t' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );

	}
	add_action( 'widgets_init', 'k2t_widgets_init' );
}

/**
 * Change default wordpress menu class.
 *
 * @since 1.0
 */
if ( ! function_exists( 'k2t_change_menu_class' ) ) {
	function k2t_change_menu_class( $classes, $item ) {
		if ( in_array( 'current-menu-item', $classes ) ) {
			$classes[] = 'active';
		}
		if ( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'children';
		}
		return $classes;
	}
	add_filter( 'nav_menu_css_class' , 'k2t_change_menu_class' , 10 , 2);
}

/**
 * Add span tag to categories post count.
 *
 * @since 1.0
 */
if ( ! function_exists( 'k2t_cat_postcount' ) ) {
	function k2t_cat_postcount( $html ) {
		$html = str_replace('</a> (', '</a> <span class="count">(', $html );
		$html = str_replace(')', ')</span>', $html );

		return $html;
	}
	add_filter( 'wp_list_categories', 'k2t_cat_postcount' );
}
if ( ! function_exists( 'k2t_archive_postcount' ) ) {
	function k2t_archive_postcount( $html ) {
		$html = str_replace( '</a>&nbsp;(', '</a><span class="count">(', $html );
		$html = str_replace( ')', ')</span>', $html );
		
		return $html;
	}
	add_filter( 'get_archives_link', 'k2t_archive_postcount' );
}

/**
 * Custom breadcrumbs.
 *
 * @since 1.0
 */
if ( ! function_exists( 'k2t_breadcrumbs' ) ) {
	function k2t_breadcrumbs(){
		$text['home']     = __( 'Home', 'k2t' ); // text for the 'Home' link
		$text['blog']     = __( 'Blog', 'k2t' ); // text for the 'Blog' link
		$text['category'] = __( 'Archive by Category "%s"', 'k2t' ); // text for a category page
		$text['tax'] 	  = __( '%s', 'k2t' ); // text for a taxonomy page
		$text['search']   = __( 'Search Results for "%s"', 'k2t' ); // text for a search results page
		$text['tag']      = __( 'Posts Tagged "%s"', 'k2t' ); // text for a tag page
		$text['author']   = __( 'Articles Posted by %s', 'k2t' ); // text for an author page
		$text['404']      = __( 'Error 404', 'k2t' ); // text for the 404 page
		$text['shop']     = __( 'Lincoln Store', 'k2t' ); // text for the 404 page

		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$delimiter   = ''; // delimiter between crumbs
		$before      = '<li class="current">'; // tag before the current crumb
		$after       = '</li>'; // tag after the current crumb

		global $post;
		$homeLink   = home_url();
		$linkBefore = '<li typeof="v:Breadcrumb">';
		$linkAfter  = '</li>';
		$linkAttr   = ' rel="v:url" property="v:title"';
		$link       = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

		if ( is_front_page() ) {
			echo '<ul class="k2t-breadcrumbs"><a href="' . esc_url( $homeLink ) . '">' . esc_html( $text['home'] ) . '</a></ul>';
		} elseif ( is_home() ) {
			echo '<ul class="k2t-breadcrumbs"><a href="' . esc_url( $homeLink ) . '">' . esc_html( $text['blog'] ) . '</a></ul>';
		} else {

			echo '<ul class="k2t-breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf( $link, esc_url( $homeLink ), esc_html( $text['home'] ) ) . $delimiter;
			
			if ( is_category() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );
				if ( $thisCat->parent != 0 ) {
					$cats = get_category_parents( $thisCat->parent, TRUE, $delimiter );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo ( $cats );
				}
				echo ( $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after );

			} elseif ( is_tax() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );
				if ( $thisCat ) {
					if ( ! empty( $thisCat->parent ) ) {
						$cats = get_category_parents( $thisCat->parent, TRUE, $delimiter );
						$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
						$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats);
						echo ( $cats );
					}
					echo ( $before . sprintf( $text['tax'], single_cat_title( '', false ) ) . $after );
				}
			}elseif ( is_search() ) {
				echo ( $before . sprintf( $text['search'], get_search_query() ) . $after );
			} elseif ( is_day() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo sprintf( $link, get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
				echo ( $before . get_the_time( 'd' ) . $after );
			} elseif ( is_month() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo ( $before . get_the_time( 'F' ) . $after );
			} elseif ( is_year() ) {
				echo ( $before . get_the_time( 'Y' ) . $after );
			} elseif ( function_exists( 'is_product' ) && is_product() ) {
				$id = get_the_ID();
				$product_cat = wp_get_post_terms( $id, 'product_cat' );
				$title = $slug = array();
				if ( $product_cat ) {
					foreach ( $product_cat as $category ) {
						$title[] = "{$category->name}";
						$slug[]  = "{$category->slug}";
					}
					echo '<li class="current"><a href="' . get_term_link( $slug[0], 'product_cat' ) . '">' . esc_html( $title[0] ) . '</a></li>';
				}
				
			} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
				echo '<li class="current">' . $text['shop'] . '</li>';
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf( $link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );
					if ( $showCurrent == 1 ) echo ( $delimiter . $before . get_the_title() . $after );
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents( $cat, TRUE, $delimiter );
					if ( $showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats);
					echo ( $cats );
					if ( $showCurrent == 1 ) echo ( $before . get_the_title() . $after );
				}

			} elseif ( ! is_single() && !is_page() && get_post_type() != 'post' && ! is_404() ) {
				$post_type = get_post_type_object(get_post_type() );
				echo ( $before . $post_type->labels->singular_name . $after );

			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat = get_the_category( $parent->ID );
				$cat = $cat[0];
				$cats = get_category_parents( $cat, TRUE, $delimiter );
				$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
				$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
				echo ( $cats );
				printf( $link, get_permalink( $parent ), $parent->post_title );
				if ( $showCurrent == 1 ) echo ( $delimiter . $before . get_the_title() . $after );

			} elseif ( is_page() && !$post->post_parent ) {
				if ( $showCurrent == 1 ) echo ( $before . get_the_title() . $after );

			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id) {
					$page = get_page( $parent_id );
					$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID ) );
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo ( $breadcrumbs[$i] );
					if ( $i != count( $breadcrumbs)-1) echo ( $delimiter );
				}
				if ( $showCurrent == 1 ) echo ( $delimiter . $before . get_the_title() . $after );

			} elseif ( is_tag() ) {
				echo ( $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after );

			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo ( $before . sprintf( $text['author'], $userdata->display_name ) . $after );

			} elseif ( is_404() ) {
				echo ( $before . $text['404'] . $after );
			} elseif ( is_post_type_archive() ) {
				echo '' . $current_before;
					post_type_archive_title();
				echo '' . $current_after;
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '(';
				echo __( 'Page', 'k2t' ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}

			echo '</ul>';

		}
	}
}

/**
 * Control excerpt length & more.
 *
 * @since 1.0
 */
function k2t_excerpt_length( $length ) {
	return 20;
}
function k2t_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_length', 'k2t_excerpt_length', 999 );
add_filter( 'excerpt_more', 'k2t_excerpt_more' );

/**
 * WP Editor.
 *
 * @since  1.0
 * @return void
 */
if ( ! function_exists( 'k2t_wp_editor' ) ) {
	function k2t_wp_editor( $id_col, $id_element, $section ) {
		global $smof_data;

		// Get all data of top header
		$data = json_decode ( $smof_data[ $section ], true );

		// Get content
		$content = k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['value'] );

		// Get custom class
		$custom_class = k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_class'] );

		// Get custom id
		$custom_id = k2t_decode(  $data['columns'][$id_col]['value'][$id_element]['value']['custom_id'] );

		$custom_id    = ( $custom_id != '' ) ? ' id="' . esc_attr( $custom_id ) . '"' : '';

		// Output to frontend
		echo '<div class="h-element element-editor ' . esc_attr( $custom_class ) . '" ' . $custom_id . '>';
			echo do_shortcode( $content );
		echo '</div>';
	}
}

/**
 * Search box.
 *
 * @since  1.0
 * @return void
 */
if ( ! function_exists( 'k2t_search_box' ) ) {
	function k2t_search_box( $id_col, $id_element, $section ) {
		global $smof_data;

		// Get all data of top header
		$data = json_decode ( $smof_data[ $section ], true );

		// Get custom class
		$custom_class =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_class'] );

		// Get custom id
		$custom_id =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_id'] );
		$custom_id    = ( $custom_id != '' ) ? ' id="' . esc_attr( $custom_id ) . '"' : '';

		// Output to frontend
		echo '
		<div ' . $custom_id . ' class="h-element search-box ' . esc_attr( $custom_class ) . '">
			<i class="zmdi zmdi-search"></i>
		</div>
		';
	}
}

/**
 * Social network.
 *
 * @since  1.0
 * @return void
 */
if ( ! function_exists( 'k2t_social' ) ) {
	function k2t_social( $id_col, $id_element, $section ) {
		global $smof_data;

		$html = $list = $link = '';

		// Get all data of top header
		$data = json_decode ( $smof_data[ $section ], true );

		// Get custom class
		$custom_class =  k2t_decode(  $data['columns'][$id_col]['value'][$id_element]['value']['custom_class'] );

		// Get custom id
		$custom_id =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_id'] );
		$custom_id = ( $custom_id != '' ) ? ' id="' . $custom_id . '"' : '';

		// Get social list
		$social = $data['columns'][$id_col]['value'][$id_element]['value']['value'];

		// Link target
		$target = isset ( $smof_data['social-target'] ) ? $smof_data['social-target'] : '_blank';

		// Get social list
		foreach ( $social as $key => $value ) {
			$link =  $smof_data['social-' . $value ];
			$list .= '<li class="' . $value . '"><a target="' . $target . '" href="' . $link . '"><i class="fa fa-' . $value . '"></i></a></li>';
		}
		
		if ( $list ) {
			$html .= '<ul ' . $custom_id . ' class="h-element social ' . $custom_class . '">';
			$html .= $list;
			$html .= '</ul>';
		}
		echo ( $html );
	}
}

/**
 * Custom menu.
 *
 * @since  1.0
 * @return void
 */
if ( ! function_exists( 'k2t_custom_menu' ) ) {
	function k2t_custom_menu( $id_col, $id_element, $section ) {
		global $smof_data;

		// Get all data of top header
		$data = json_decode ( $smof_data[ $section ], true );

		// Get menu name
		$menu =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['menu_id'] ) ;

		// Get custom class
		$custom_class =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_class'] );

		// Get custom id
		$custom_id =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_id'] );

		if ( isset( $menu ) && ! empty( $menu ) && $menu != 'All Pages' ) {
			wp_nav_menu(
				array(
					'menu'        => $menu,
					'container'   => false,
					'menu_id'     => $custom_id,
					'menu_class'  => 'h-element k2t-menu ' . $custom_class,
					'fallback_cb' => '',
					'walker'      => new K2TCoreFrontendWalker()
				)
			);
		} else {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'   => false,
					'menu_id'     => $custom_id,
					'menu_class'  => 'h-element k2t-menu ' . $custom_class,
					'fallback_cb' => '',
					'walker'      => new K2TCoreFrontendWalker()
				)
			);
		}
	}
}

/**
 * Woocommerce cart.
 *
 * @since  1.0
 * @return void
 */
if ( ! function_exists( 'k2t_cart' ) ) {
	function k2t_cart( $id_col, $id_element, $section ) {
		global $smof_data;

		// Get all data of top header
		$data = json_decode ( $smof_data[ $section ], true );

		// Get custom class
		$custom_class =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_class'] );

		// Get custom id
		$custom_id =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_id'] );
		$custom_id    = ( $custom_id != '' ) ? ' id="' . $custom_id . '"' : '';

		// Output to frontend
		echo '<div ' . $custom_id . ' class="h-element ' . $custom_class . '">';
		if ( class_exists( 'k2t_template_woo' ) ) :
			k2t_template_woo::k2t_shoping_cart();
		endif;
		echo '</div>';
	}
}

/**
 * Widgets in header.
 *
 * @since  1.0
 * @return void
 */
if ( ! function_exists( 'k2t_widget' ) ) {
	function k2t_widget( $id_col, $id_element, $section ) {
		global $smof_data;

		// Get all data of top header
		$data = json_decode ( $smof_data[ $section ], true );

		// Get sidebar id
		$sidebar =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['widget_id'] );

		// Get custom class
		$custom_class =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_class'] );

		// Get custom id
		$custom_id =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_id'] );
		$custom_id    = ( $custom_id != '' ) ? ' id="' . $custom_id . '"' : '';

		// Output to frontend
		echo '<div ' . $custom_id . ' class="h-element ' . $custom_class . '">';
		if ( is_active_sidebar( $sidebar ) ) :
			dynamic_sidebar( $sidebar );
		endif;
		echo '</div>';
	}
}

/**
 * Logo in header.
 *
 * @since  1.0
 * @return void
 */
if ( ! function_exists( 'k2t_logo' ) ) {
	function k2t_logo( $id_col, $id_element, $section ) {
		global $smof_data;

		// Get all data of top header
		$data = json_decode ( $smof_data[ $section ], true );

		// Get custom class
		$custom_class =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_class'] );

		// Get custom id
		$custom_id =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_id'] );
		$custom_id    = ( $custom_id != '' ) ? ' id="' . esc_attr( $custom_id ) . '"' : '';

		echo '<div ' . $custom_id . ' class="h-element ' . esc_attr( $custom_class ) . '">';
		?>
		<a class="k2t-logo" rel="home" href="<?php echo $smof_data['link_homepage'] ? $smof_data['link_homepage'] : esc_url( home_url( "/" ) ); ?>">
			<?php
			$logo = isset ( $smof_data['logo'] ) ? trim( $smof_data['logo'] ) : '';
			if ( $logo == '' || ( isset( $smof_data['text-logo'] ) && $smof_data['use-text-logo'] ) ) :
				echo '<h1 class="logo-text">';
					if ( ! $smof_data['text-logo'] ) {
						echo esc_html( bloginfo( 'name' ) );
					} else {
						echo esc_html( $smof_data['text-logo'] );
					}
				echo '</h1>';
			else: ?>
				<img src="<?php echo esc_url( $logo );?>" alt="<?php esc_attr( bloginfo( 'name' ) );?>" />
			<?php endif; ?>	
		</a>
		<?php
		echo '</div>';
	}
}

/**
 * Canvas sidebar.
 *
 * @since  1.0
 * @return void
 */
if ( ! function_exists( 'k2t_canvas_sidebar' ) ) {
	function k2t_canvas_sidebar_body_class( $classes ) {
		global $smof_data;

		// Get canvas sidebar class
		$classes[] = 'offcanvas-type-default';
		if ( $smof_data['offcanvas-sidebar-position'] ) {
			$classes[] = ' offcanvas-' . $smof_data['offcanvas-sidebar-position'];
		}else{
			$classes[] = ' offcanvas-left';
		}
		return $classes;
	}
	add_filter( 'body_class', 'k2t_canvas_sidebar_body_class' );

	function k2t_canvas_sidebar( $id_col, $id_element, $section ) {
		global $smof_data;

		// Get all data of top header
		$data = json_decode ( $smof_data[ $section ], true );

		// Get custom class
		$custom_class =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_class'] );

		// Get custom id
		$custom_id =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_id'] );
		$custom_id    = ( $custom_id != '' ) ? ' id="' . esc_attr( $custom_id ) . '"' : '';

		// Output to frontend
		echo '<div ' . $custom_id . ' class="h-element ' . esc_attr( $custom_class ) . '">';
		echo '<a onclick="javascript:return false;" class="open-sidebar" href="#"><span class="inner"></span></a>';
		echo '</div>';
		return;
	}
}

/**
 * Login.
 *
 * @since  1.0
 * @return void
 */
if ( ! function_exists( 'k2t_login' ) ) {
	function k2t_login( $id_col, $id_element, $section ) {
		global $smof_data;
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 

		// Get all data of top header
		$data = json_decode ( $smof_data[ $section ], true );

		// Get custom class
		$custom_class =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_class'] );

		// Get custom id
		$custom_id =  k2t_decode( $data['columns'][$id_col]['value'][$id_element]['value']['custom_id'] );
		$custom_id    = ( $custom_id != '' ) ? ' id="' . esc_attr( $custom_id ) . '"' : '';

		// Output to frontend
		echo '<div ' . $custom_id . ' class="h-element custom-login' . esc_attr( $custom_class ) . '">';
		if ( is_user_logged_in() ) :
			$current_user = wp_get_current_user();
        	echo __('Hello','k2t') . ' <a href="' . get_site_url() . '/author/' . $current_user->user_login . '/">' . $current_user->user_login . '! ';
        	echo '<a href="' . wp_logout_url( get_home_url() ) . '"> '. __( 'Logout', 'k2t') . '</a>  <i class="zmdi zmdi-square-right"></i>';
		else: 
			echo '<a href="'. esc_url( wp_login_url( get_permalink() ) ) .'" title="'. __( 'Login', 'k2t' ) .'">'. __( 'Login', 'k2t' ) .'</a>  /  <a href="'. esc_url( site_url( '/wp-login.php?action=register&redirect_to=' . get_permalink() ) ) .'" title="'. __( 'Sign Up', 'k2t' ) .'">'. __( 'Sign Up', 'k2t' ) .'</a>';
		endif;
		echo '</div>';
		return;
	}
}

/**
 * Header visual layout generate.
 *
 * @since  1.0
 * @return void
 */
function k2t_data( $id, $i, $section ) {
	global  $smof_data;

	// Get all data of section
	$data = json_decode ( $smof_data[ $section ], true );

	// Get element type
	$type = $data['columns'][$id]['value'][$i]['type'];
	switch ( $type ) {
		case 'wp_editor' :
			k2t_wp_editor( $id, $i, $section );
			break;
		case 'search_box' :
			k2t_search_box( $id, $i, $section );
			break;
		case 'social' :
			k2t_social( $id, $i, $section );
			break;
		case 'custom_menu' :
			k2t_custom_menu( $id, $i, $section );
			break;
		case 'widget' :
			k2t_widget( $id, $i, $section );
			break;
		case 'cart' :
			k2t_cart( $id, $i, $section );
			break;
		case 'logo' :
			k2t_logo( $id, $i, $section );
			break;
		case 'canvas_sidebar' :
			k2t_canvas_sidebar( $id, $i, $section );
			break;
		case 'login' :
			k2t_login( $id, $i, $section );
			break;
	}
}

/**
 * Convert Hex Color to RGB
 *
 * @since  1.0
 * @return array
 */
function k2t_hex2rgb( $hex ) {
	$hex = str_replace( "#", "", $hex );

	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ).substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ).substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ).substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	$rgb = array( $r, $g, $b );
	
	// returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
}

/**
 * Add advanced restore theme options.
 *
 * @since  1.0
 * @return void
 */
function k2t_add_advance_option() {
	$add_data = array();
	
	$backup_restore = get_option( 'grid_theme_options_advance_backup_restore' );

	if ( isset( $backup_restore ) && $backup_restore == '' ) {
		/* Add Data Theme Options */
		$backup_id                  = $_POST['advance_id'];
		$add_data[0]['advance_id']  = $backup_id;
		$add_data[0]['backup_id']   = $backup_id . '_' . time();
		$backup_name                = $_POST['backup_name'];
		$add_data[0]['backup_name'] = $backup_name;
		$add_data[0]['time']        = date('D M j G:i Y');
		$backup_data                = $_POST['data'];
		$add_data[0]['data']        = $backup_data;
		add_option( 'grid_theme_options_advance_backup_restore', json_encode( $add_data ) );
	} else {
		$current_backup_data     = array();
		$backup_id               = $_POST['advance_id'];
		$add_data['advance_id']  = $backup_id;
		$add_data['backup_id']   = $backup_id . '_' . time();
		$backup_name             = $_POST['backup_name'];
		$add_data['backup_name'] = $backup_name;
		$add_data['time']        = date('D M j G:i Y');
		$backup_data             = $_POST['data'];
		$add_data['data']        = $backup_data;
		$current_backup_data     = ( array )json_decode( $backup_restore ) ;
		array_push( $current_backup_data, $add_data );
		update_option( 'grid_theme_options_advance_backup_restore', json_encode( $current_backup_data ) );
	}
	die();
}
add_action( 'wp_ajax_k2t_add_advance_option', 'k2t_add_advance_option' );
add_action( 'wp_ajax_nopriv_k2t_add_advance_option', 'k2t_add_advance_option' );

/**
 * Load advanced restore theme options.
 *
 * @since  1.0
 * @return void
 */
function k2t_load_advance_option() {
	$id                  = $_POST['advance_id'];
	$backup_restore      = get_option( 'grid_theme_options_advance_backup_restore' );
	$current_backup_data = ( array )json_decode( $backup_restore );
	
	$output = '<div onload="">';
	foreach( $current_backup_data as $da ) {
		if( $da->advance_id == $id ) {
			$output .= '
			<li backup-id=' . $da->backup_id . ' for=' . $id . ' data="' . $da->data . '">
				<input for="' . $id . '" for-name="' . $da->backup_name . '" id="input_downloadify' . $da->backup_id . '" type="hidden" value="' . $id . '|' . $da->backup_id . '|' . $da->backup_name . '|' . $da->data . '" />
				<div id="download_backup" class="download_backup download_backup' . $da->backup_id . '">Open Text Field</div>
				<div class="dashicons_item dashicons dashicons-trash"></div>' . $da->backup_name . '
			</li>';
			
		}
		$output .= '
			<scr' . 'ipt>
				opensave.make({ 					
					width: 		20,
					height: 	20,
					filename: 	"Data.txt", 
					buttonDiv: 	"download_backup",
					dataID: 	"input_downloadify' . $da->backup_id . '",
					image_up:   "' . K2T_FRAMEWORK_URL . 'assets/images/download.png",
					image_down: "' . K2T_FRAMEWORK_URL . 'assets/images/download-hover.png",
					image_over: "' . K2T_FRAMEWORK_URL . 'assets/images/download-hover.png",
					label:""
				});
			</scr' . 'ipt>';
	}
	$output .= '</div>';
	
	echo ( $output );
	die();
}
add_action( 'wp_ajax_k2t_load_advance_option', 'k2t_load_advance_option' );
add_action( 'wp_ajax_nopriv_k2t_load_advance_option', 'k2t_load_advance_option' );

/**
 * Backup advanced restore theme options.
 *
 * @since  1.0
 * @return void
 */
function k2t_backup_advance_option() {
	global $smof_data, $options_machine, $of_options;
	$id      = $_POST['advance_id'];
	$data    = $_POST['data'];
	$restore =  json_decode( k2t_decode( $data ) );
	foreach( $restore as $rk=>$aid ) {
		foreach ( $smof_data as $k=>$v ) {
			if ( $k == $rk && $k != '0' ) {
				if ( $smof_data[$k] != $aid ) { 
					set_theme_mod( $k, $aid );
				} else if ( is_array( $v ) ) {
					foreach ( $aid as $key=>$val ) {
						if ( $key != $k && $v[$key] == $val ) {
							set_theme_mod( $k, $aid );
							break;
						}
					}
				}			
			}
		}
	}
	die();
}
add_action( 'wp_ajax_k2t_backup_advance_option', 'k2t_backup_advance_option' );
add_action( 'wp_ajax_nopriv_k2t_backup_advance_option', 'k2t_backup_advance_option' );

/**
 * Delete backup.
 *
 * @since  1.0
 * @return void
 */
function k2t_delete_advance_option() {
	global $smof_data, $options_machine, $of_options;
	$id                  = $_POST['advance_id'];
	$backup_id           = $_POST['backup_id'];
	$data                = $_POST['data'];
	$backup_restore      = get_option( 'grid_theme_options_advance_backup_restore' );
	$current_backup_data = ( array )json_decode( $backup_restore );
	$output              = '';
	$i = 0;
	$template = array();
	foreach( $current_backup_data as $da ) {
		if ( $da->backup_id != $backup_id ) {
			$template[] = $da;
		}
		$i++;
	}
	update_option( 'grid_theme_options_advance_backup_restore', json_encode( $template ) );
	die();
}
add_action( 'wp_ajax_k2t_delete_advance_option', 'k2t_delete_advance_option' );
add_action( 'wp_ajax_nopriv_k2t_delete_advance_option', 'k2t_delete_advance_option' );

/**
 * Upload backup.
 *
 * @since  1.0
 * @return void
 */
function k2t_backup_from_file() {
	global $smof_data, $options_machine, $of_options;

	$data_backup         = $_POST['data_backup'];
	$backup_type         = $_POST['backup_type'];
	$backup_restore      = get_option( 'grid_theme_options_advance_backup_restore' );
	$current_backup_data = ( array ) json_decode( $backup_restore );
	$validate_data       = '0';
	$notice              = '';
	$backup_data         = explode( '|',$data_backup );
	$data_import         = array();
	// Validate Struct 
	if ( count( $backup_data ) != 4 ) {
		$validate_data = 0;
		$notice = __( 'Data Struct False', 'k2t' );
	} else {
		// Validate check exitst type
		foreach ( $of_options as $of ) {
			if ( isset( $of['id'] ) && $of['id'] == $backup_data[0] ) {
				$validate_data = '1';
			};
		}
		if ( $validate_data == '0' ) {
			$notice = __( 'Sorry, This Backup False! Not found name of advance on db', 'k2t' );
		} else {
			// Check isset in database
			foreach ( $current_backup_data as $da ) {
				if ( $da->backup_id == $backup_data[1] ) {
					$validate_data = '1';
					$notice        = __( 'This backup really exists!! It will move to top of list backup, and restore data for you!', 'k2t' );
				}
			}
		}
		
	}
	// Check jsonstring of DATA
	if ( $data_import = json_decode(  k2t_decode( $backup_data[3], true ) ) ) {
		if ( $backup_type == 'save_to_back_up_list' ) {
			/* Save to backup list */
			$backup_id               = $backup_data[0];
			$add_data['advance_id']  = $backup_id;
			$add_data['backup_id']   = $backup_id . '_' . time();
			$backup_name             = $backup_data[2];
			$add_data['backup_name'] = $backup_name;
			$add_data['time']        = date('D M j G:i Y');
			$backup_data             = $backup_data[3];
			$add_data['data']        = $backup_data;
			array_push( $current_backup_data, $add_data );
			update_option( 'grid_theme_options_advance_backup_restore', json_encode( $current_backup_data ) );
			$notice = __( 'Added To Backup List', 'k2t' );


		} else if ( $backup_type == 'restore' ) {
			/* Restore */
			global $smof_data, $options_machine, $of_options;
			$backup_id = $backup_data[0];
			$id        = $backup_data[1];
			$data      = $backup_data[3];
			$restore   =  json_decode( k2t_decode( $data ) );
			foreach ( $restore as $rk=>$aid ) {
				foreach ( $smof_data as $k=>$v ) {
					if ( $k == $rk && $k != '0' ) {
						if ( $smof_data[$k] != $aid ) { 
							set_theme_mod( $k, $aid );
						} else if ( is_array( $v ) ) {
							foreach ( $aid as $key=>$val ) {
								if ( $key != $k && $v[$key] == $val ) {
									set_theme_mod( $k, $aid );
									break;
								}
							}
						}			
					}
				}
			}
			$notice = __( 'Restored!', 'k2t' );

		} else if ( $backup_type == 'restore_and_save_to_backup_list' ) {
			global $smof_data, $options_machine, $of_options;
			/* Restore And Save To Backup List */
			/* Save to backup list */
			$backup_id               = $backup_data[0];
			$add_data['advance_id']  = $backup_id;
			$add_data['backup_id']   = $backup_id . '_' . time();
			$backup_name             = $backup_data[2];
			$add_data['backup_name'] = $backup_name;
			$add_data['time']        = date( 'D M j G:i Y' );
			$backup_data             = $backup_data[3];
			$add_data['data']        = $backup_data;
			array_push( $current_backup_data, $add_data );
			update_option( 'grid_theme_options_advance_backup_restore', json_encode( $current_backup_data ) );
			$notice = __( 'Added To Backup List!', 'k2t' );


			/* Restore */
			$backup_id = $backup_data[0];
			$id        = $backup_data[1];
			$data      = $backup_data[3];
			$restore   =  json_decode( k2t_decode( $data ) );
			foreach ( $restore as $rk=>$aid ) {
				foreach ( $smof_data as $k=>$v ) {
					if( $k == $rk && $k != '0' ) {
						if ( $smof_data[$k] != $aid ) { 
							set_theme_mod( $k, $aid );
						} else if ( is_array( $v ) ) {
							foreach ( $aid as $key=>$val ) {
								if ( $key != $k && $v[$key] == $val ) {
									set_theme_mod( $k, $aid );
									break;
								}
							}
						}			
					}
				}
			}
			$notice = __( 'Restored!', 'k2t' );
		}
		
	} else {
		// not valid
		$notice = __( 'We can\'t Read Data backup. Have an other change for backup file!', 'k2t' );
	}
	
	print_r( $notice );

	die();
}
add_action( 'wp_ajax_k2t_backup_from_file', 'k2t_backup_from_file' );
add_action( 'wp_ajax_nopriv_k2t_backup_from_file', 'k2t_backup_from_file' );

/**
 * Save a backup.
 *
 * @since  1.0
 * @return void
 */
function k2t_save_advance_option(){
	header('Content-type: text/plain');
	header('Content-disposition: attachment; filename="data.txt"');
}
add_action( 'wp_ajax_k2t_save_advance_option', 'k2t_save_advance_option' );
add_action( 'wp_ajax_nopriv_k2t_save_advance_option', 'k2t_save_advance_option' );

/**
 * Integration google fonts.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link	http://www.lunartheme.com
 */

if ( !function_exists( 'k2t_google_fonts' ) ) {
	function k2t_google_fonts() {
		$fonts = 'ABeeZee, Abel, Abril Fatface, Aclonica, Acme, Actor, Adamina, Advent Pro, Aguafina Script, Akronim, Aladin, Aldrich, Alef, Alegreya, Alegreya SC, Alegreya Sans, Alegreya Sans SC, Alex Brush, Alfa Slab One, Alice, Alike, Alike Angular, Allan, Allerta, Allerta Stencil, Allura, Almendra, Almendra Display, Almendra SC, Amarante, Amaranth, Amatic SC, Amethysta, Amiri, Amita, Anaheim, Andada, Andika, Angkor, Annie Use Your Telescope, Anonymous Pro, Antic, Antic Didone, Antic Slab, Anton, Arapey, Arbutus, Arbutus Slab, Architects Daughter, Archivo Black, Archivo Narrow, Arimo, Arizonia, Armata, Artifika, Arvo, Arya, Asap, Asset, Astloch, Asul, Atomic Age, Aubrey, Audiowide, Autour One, Average, Average Sans, Averia Gruesa Libre, Averia Libre, Averia Sans Libre, Averia Serif Libre, Bad Script, Balthazar, Bangers, Basic, Battambang, Baumans, Bayon, Belgrano, Belleza, BenchNine, Bentham, Berkshire Swash, Bevan, Bigelow Rules, Bigshot One, Bilbo, Bilbo Swash Caps, Biryani, Bitter, Black Ops One, Bokor, Bonbon, Boogaloo, Bowlby One, Bowlby One SC, Brawler, Bree Serif, Bubblegum Sans, Bubbler One, Buda, Buenard, Butcherman, Butterfly Kids, Cabin, Cabin Condensed, Cabin Sketch, Caesar Dressing, Cagliostro, Calligraffitti, Cambay, Cambo, Candal, Cantarell, Cantata One, Cantora One, Capriola, Cardo, Carme, Carrois Gothic, Carrois Gothic SC, Carter One, Caudex, Cedarville Cursive, Ceviche One, Changa One, Chango, Chau Philomene One, Chela One, Chelsea Market, Chenla, Cherry Cream Soda, Cherry Swash, Chewy, Chicle, Chivo, Cinzel, Cinzel Decorative, Clicker Script, Coda, Coda Caption, Codystar, Combo, Comfortaa, Coming Soon, Concert One, Condiment, Content, Contrail One, Convergence, Cookie, Copse, Corben, Courgette, Cousine, Coustard, Covered By Your Grace, Crafty Girls, Creepster, Crete Round, Crimson Text, Croissant One, Crushed, Cuprum, Cutive, Cutive Mono, Damion, Dancing Script, Dangrek, Dawning of a New Day, Days One, Dekko, Delius, Delius Swash Caps, Delius Unicase, Della Respira, Denk One, Devonshire, Dhurjati, Didact Gothic, Diplomata, Diplomata SC, Domine, Donegal One, Doppio One, Dorsa, Dosis, Dr Sugiyama, Droid Sans, Droid Sans Mono, Droid Serif, Duru Sans, Dynalight, EB Garamond, Eagle Lake, Eater, Economica, Eczar, Ek Mukta, Electrolize, Elsie, Elsie Swash Caps, Emblema One, Emilys Candy, Engagement, Englebert, Enriqueta, Erica One, Esteban, Euphoria Script, Ewert, Exo, Exo 2, Expletus Sans, Fanwood Text, Fascinate, Fascinate Inline, Faster One, Fasthand, Fauna One, Federant, Federo, Felipa, Fenix, Finger Paint, Fira Mono, Fira Sans, Fjalla One, Fjord One, Flamenco, Flavors, Fondamento, Fontdiner Swanky, Forum, Francois One, Freckle Face, Fredericka the Great, Fredoka One, Freehand, Fresca, Frijole, Fruktur, Fugaz One, GFS Didot, GFS Neohellenic, Gabriela, Gafata, Galdeano, Galindo, Gentium Basic, Gentium Book Basic, Geo, Geostar, Geostar Fill, Germania One, Gidugu, Gilda Display, Give You Glory, Glass Antiqua, Glegoo, Gloria Hallelujah, Goblin One, Gochi Hand, Gorditas, Goudy Bookletter 1911, Graduate, Grand Hotel, Gravitas One, Great Vibes, Griffy, Gruppo, Gudea, Gurajada, Habibi, Halant, Hammersmith One, Hanalei, Hanalei Fill, Handlee, Hanuman, Happy Monkey, Headland One, Henny Penny, Herr Von Muellerhoff, Hind, Holtwood One SC, Homemade Apple, Homenaje, IM Fell DW Pica, IM Fell DW Pica SC, IM Fell Double Pica, IM Fell Double Pica SC, IM Fell English, IM Fell English SC, IM Fell French Canon, IM Fell French Canon SC, IM Fell Great Primer, IM Fell Great Primer SC, Iceberg, Iceland, Imprima, Inconsolata, Inder, Indie Flower, Inika, Irish Grover, Istok Web, Italiana, Italianno, Jacques Francois, Jacques Francois Shadow, Jaldi, Jim Nightshade, Jockey One, Jolly Lodger, Josefin Sans, Josefin Slab, Joti One, Judson, Julee, Julius Sans One, Junge, Jura, Just Another Hand, Just Me Again Down Here, Kalam, Kameron, Kantumruy, Karla, Karma, Kaushan Script, Kavoon, Kdam Thmor, Keania One, Kelly Slab, Kenia, Khand, Khmer, Khula, Kite One, Knewave, Kotta One, Koulen, Kranky, Kreon, Kristi, Krona One, Kurale, La Belle Aurore, Laila, Lakki Reddy, Lancelot, Lateef, Lato, League Script, Leckerli One, Ledger, Lekton, Lemon, Libre Baskerville, Life Savers, Lilita One, Lily Script One, Limelight, Linden Hill, Lobster, Lobster Two, Londrina Outline, Londrina Shadow, Londrina Sketch, Londrina Solid, Lora, Love Ya Like A Sister, Loved by the King, Lovers Quarrel, Luckiest Guy, Lusitana, Lustria, Macondo, Macondo Swash Caps, Magra, Maiden Orange, Mako, Mallanna, Mandali, Marcellus, Marcellus SC, Marck Script, Margarine, Marko One, Marmelad, Martel, Martel Sans, Marvel, Mate, Mate SC, Maven Pro, McLaren, Meddon, MedievalSharp, Medula One, Megrim, Meie Script, Merienda, Merienda One, Merriweather, Merriweather Sans, Metal, Metal Mania, Metamorphous, Metrophobic, Michroma, Milonga, Miltonian, Miltonian Tattoo, Miniver, Miss Fajardose, Modak, Modern Antiqua, Molengo, Molle, Monda, Monofett, Monoton, Monsieur La Doulaise, Montaga, Montez, Montserrat, Montserrat Alternates, Montserrat Subrayada, Moul, Moulpali, Mountains of Christmas, Mouse Memoirs, Mr Bedfort, Mr Dafoe, Mr De Haviland, Mrs Saint Delafield, Mrs Sheppards, Muli, Mystery Quest, NTR, Neucha, Neuton, New Rocker, News Cycle, Niconne, Nixie One, Nobile, Nokora, Norican, Nosifer, Nothing You Could Do, Noticia Text, Noto Sans, Noto Serif, Nova Cut, Nova Flat, Nova Mono, Nova Oval, Nova Round, Nova Script, Nova Slim, Nova Square, Numans, Nunito, Odor Mean Chey, Offside, Old Standard TT, Oldenburg, Oleo Script, Oleo Script Swash Caps, Open Sans, Open Sans Condensed, Oranienbaum, Orbitron, Oregano, Orienta, Original Surfer, Oswald, Over the Rainbow, Overlock, Overlock SC, Ovo, Oxygen, Oxygen Mono, PT Mono, PT Sans, PT Sans Caption, PT Sans Narrow, PT Serif, PT Serif Caption, Pacifico, Palanquin, Palanquin Dark, Paprika, Parisienne, Passero One, Passion One, Pathway Gothic One, Patrick Hand, Patrick Hand SC, Patua One, Paytone One, Peddana, Peralta, Permanent Marker, Petit Formal Script, Petrona, Philosopher, Piedra, Pinyon Script, Pirata One, Plaster, Play, Playball, Playfair Display, Playfair Display SC, Podkova, Poiret One, Poller One, Poly, Pompiere, Pontano Sans, Poppins, Port Lligat Sans, Port Lligat Slab, Pragati Narrow, Prata, Preahvihear, Press Start 2P, Princess Sofia, Prociono, Prosto One, Puritan, Purple Purse, Quando, Quantico, Quattrocento, Quattrocento Sans, Questrial, Quicksand, Quintessential, Qwigley, Racing Sans One, Radley, Rajdhani, Raleway, Raleway Dots, Ramabhadra, Ramaraja, Rambla, Rammetto One, Ranchers, Rancho, Ranga, Rationale, Ravi Prakash, Redressed, Reenie Beanie, Revalia, Rhodium Libre, Ribeye, Ribeye Marrow, Righteous, Risque, Roboto, Roboto Condensed, Roboto Mono, Roboto Slab, Rochester, Rock Salt, Rokkitt, Romanesco, Ropa Sans, Rosario, Rosarivo, Rouge Script, Rozha One, Rubik Mono One, Rubik One, Ruda, Rufina, Ruge Boogie, Ruluko, Rum Raisin, Ruslan Display, Russo One, Ruthie, Rye, Sacramento, Sail, Salsa, Sanchez, Sancreek, Sansita One, Sarina, Sarpanch, Satisfy, Scada, Scheherazade, Schoolbell, Seaweed Script, Sevillana, Seymour One, Shadows Into Light, Shadows Into Light Two, Shanti, Share, Share Tech, Share Tech Mono, Shojumaru, Short Stack, Siemreap, Sigmar One, Signika, Signika Negative, Simonetta, Sintony, Sirin Stencil, Six Caps, Skranji, Slabo 13px, Slabo 27px, Slackey, Smokum, Smythe, Sniglet, Snippet, Snowburst One, Sofadi One, Sofia, Sonsie One, Sorts Mill Goudy, Source Code Pro, Source Sans Pro, Source Serif Pro, Special Elite, Spicy Rice, Spinnaker, Spirax, Squada One, Sree Krushnadevaraya, Stalemate, Stalinist One, Stardos Stencil, Stint Ultra Condensed, Stint Ultra Expanded, Stoke, Strait, Sue Ellen Francisco, Sumana, Sunshiney, Supermercado One, Suranna, Suravaram, Suwannaphum, Swanky and Moo Moo, Syncopate, Tangerine, Taprom, Tauri, Teko, Telex, Tenali Ramakrishna, Tenor Sans, Text Me One, The Girl Next Door, Tienne, Tillana, Timmana, Tinos, Titan One, Titillium Web, Trade Winds, Trocchi, Trochut, Trykker, Tulpen One, Ubuntu, Ubuntu Condensed, Ubuntu Mono, Ultra, Uncial Antiqua, Underdog, Unica One, UnifrakturCook, UnifrakturMaguntia, Unkempt, Unlock, Unna, VT323, Vampiro One, Varela, Varela Round, Vast Shadow, Vesper Libre, Vibur, Vidaloka, Viga, Voces, Volkhov, Vollkorn, Voltaire, Waiting for the Sunrise, Wallpoet, Walter Turncoat, Warnes, Wellfleet, Wendy One, Wire One, Yanone Kaffeesatz, Yantramanav, Yellowtail, Yeseva One, Yesteryear, Zeyada';

		$font_array = explode( ',', $fonts );
		foreach ( $font_array as $font ) {
			$font = trim( $font );
			$google_fonts_array[$font] = $font;
		}
		return $google_fonts_array;
	}
}

if ( !function_exists( 'k2t_fonts_array' ) ) {
	function k2t_fonts_array() {
		return k2t_google_fonts();
	}
}
