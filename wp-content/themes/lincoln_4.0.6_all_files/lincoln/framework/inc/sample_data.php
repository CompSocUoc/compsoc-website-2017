<?php

add_filter( 'wp_get_attachment_url'      , 'lincoln_get_attachment_url'       , 10, 2 );
add_filter( 'wp_get_attachment_thumb_url', 'lincoln_get_attachment_url'       , 10, 2 );
add_filter( 'wp_get_attachment_image_src', 'lincoln_get_attachment_image_src' , 10, 4 );
add_filter( 'wp_calculate_image_srcset'  , 'lincoln_calculate_image_srcset'   , 10, 5 );
add_filter( 'post_thumbnail_html'        , 'lincoln_post_thumbnail_html'      , 10, 5 );

/**
 * Get remote URL for demo image.
 *
 * @param   string  $url      URL for the given attachment.
 * @param   int     $post_id  Attachment ID.
 *
 * @return  string
 */
function lincoln_get_attachment_url( $url, $post_id ) {
	$demo_site_pattern  = 'https?(%3A|:)[%2F\\\\/]+(demo|back|host)\.lunartheme\.com';
	$demo_image_pattern = '(%2F|\\\\*/)([^\s\'"]*)wp-content[%2F\\\\/]+uploads([^\s\'"]+)';
	// Check if attachment file exists.
	$upload = wp_upload_dir();
	$file   = str_replace( $upload['baseurl'], $upload['basedir'], $url );

	if ( $attachment = get_post( $post_id ) ) {
		if ( preg_match( '#' . $demo_site_pattern . $demo_image_pattern . '#i', $attachment->guid ) ) {
			// Get base local and remote URL.
			$remote_base = current( explode( '/wp-content/uploads/', $attachment->guid ) ) . '/wp-content/uploads';

			// Replace local base with remote base.
			$url = str_replace( $upload['baseurl'], $remote_base, $url );
		}
	}
	return $url;
}

/**
 * Get remote source for demo image.
 *
 * @param   array|false   $image          Either array with src, width & height, icon src, or false.
 * @param   int           $attachment_id  Image attachment ID.
 * @param   string|array  $size           Size of image. Image size or array of width and height values (in that order). Default 'thumbnail'.
 * @param   bool          $icon           Whether the image should be treated as an icon. Default false.
 *
 * @return  array|false
 */
function lincoln_get_attachment_image_src( $image, $attachment_id, $size, $icon ) {

	$demo_site_pattern  = 'https?(%3A|:)[%2F\\\\/]+(demo|back|host)\.lunartheme\.com';
	$demo_image_pattern = '(%2F|\\\\*/)([^\s\'"]*)wp-content[%2F\\\\/]+uploads([^\s\'"]+)';

	// Check if attachment file exists.
	$upload = wp_upload_dir();
	$file   = str_replace( $upload['baseurl'], $upload['basedir'], $image[0] );

	if ( $attachment = get_post( $attachment_id ) ) {
		if ( preg_match( '#' . $demo_site_pattern . $demo_image_pattern . '#i', $attachment->guid ) ) {
			// Get base local and remote URL.
			$remote_base = current( explode( '/wp-content/uploads/', $attachment->guid ) ) . '/wp-content/uploads';

			// Replace local base with remote base.
			$image[0] = str_replace( $upload['baseurl'], $remote_base, $image[0] );
		}
	}

	return $image;
}

/**
 * Calculate remote source set for demo image.
 *
 * @param   array  $sources  {
 *     One or more arrays of source data to include in the 'srcset'.
 *
 *     @type array $width {
 *         @type string $url        The URL of an image source.
 *         @type string $descriptor The descriptor type used in the image candidate string,
 *                                  either 'w' or 'x'.
 *         @type int    $value      The source width if paired with a 'w' descriptor, or a
 *                                  pixel density value if paired with an 'x' descriptor.
 *     }
 * }
 * @param   array   $size_array     Array of width and height values in pixels (in that order).
 * @param   string  $image_src      The 'src' of the image.
 * @param   array   $image_meta     The image meta data as returned by 'wp_get_attachment_metadata()'.
	 * @param   int     $attachment_id  Image attachment ID or 0.
 *
 * @return  string|false
 */
function lincoln_calculate_image_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {

	$demo_site_pattern  = 'https?(%3A|:)[%2F\\\\/]+(demo|back|host)\.lunartheme\.com';
	$demo_image_pattern = '(%2F|\\\\*/)([^\s\'"]*)wp-content[%2F\\\\/]+uploads([^\s\'"]+)';

	foreach ( $sources as $width => $define ) {
		// Check if attachment file exists.
		$upload = isset( $upload ) ? $upload : wp_upload_dir();
		$file   = str_replace( $upload['baseurl'], $upload['basedir'], $define['url'] );

		if ( true ) {
			if ( preg_match( '#' . $demo_site_pattern . $demo_image_pattern . '#i', $image_src ) ) {
				$remote_src = $image_src;
			} elseif ( $attachment = get_post( $attachment_id ) ) {
				if ( preg_match( '#' . $demo_site_pattern . $demo_image_pattern . '#i', $attachment->guid ) ) {
					$remote_src = $attachment->guid;
				}
			}

			if ( isset( $remote_src ) ) {
				// Get base local and remote URL.
				$remote_base = current( explode( '/wp-content/uploads/', $remote_src ) ) . '/wp-content/uploads';

				// Replace local base with remote base.
				$sources[ $width ]['url'] = str_replace( $upload['baseurl'], $remote_base, $define['url'] );
			}
		}
	}

	return $sources;
}

/**
 * Prepare HTML for post thumbnail.
 *
 * @param   string        $html               The post thumbnail HTML.
 * @param   int           $post_id            The post ID.
 * @param   string        $post_thumbnail_id  The post thumbnail ID.
 * @param   string|array  $size               The post thumbnail size. Image size or array of width and height
 *                                            values (in that order). Default 'post-thumbnail'.
 * @param   string        $attr               Query string of attributes.
 *
 * @return  string
 */
function lincoln_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	$demo_site_pattern  = 'https?(%3A|:)[%2F\\\\/]+(demo|back|host)\.lunartheme\.com';
	$demo_image_pattern = '(%2F|\\\\*/)([^\s\'"]*)wp-content[%2F\\\\/]+uploads([^\s\'"]+)';

	$upload = wp_upload_dir();

	if ( $attachment = get_post( $post_thumbnail_id ) ) {
		$demo_site_pattern  = 'https?(%3A|:)[%2F\\\\/]+(demo|back|host)\.lunartheme\.com';
		$demo_image_pattern = '(%2F|\\\\*/)([^\s\'"]*)wp-content[%2F\\\\/]+uploads([^\s\'"]+)';

		if ( preg_match( '#' . $demo_site_pattern . $demo_image_pattern . '#i', $attachment->guid ) ) {
			// Get base remote URL.
			$remote_base = current( explode( '/wp-content/uploads/', $attachment->guid ) ) . '/wp-content/uploads';

			// Replace local base with remote base.
			$html = str_replace( $upload['baseurl'], $remote_base, $html );
		}
	}

	return $html;
}