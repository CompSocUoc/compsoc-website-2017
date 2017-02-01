<?php
/**
 * Facebook widget.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link http://www.lunartheme.com
 */

add_action( 'widgets_init', 'k2t_social_widgets' );
function k2t_social_widgets() {
	register_widget( 'k2t_Widget_Social' );
}
class k2t_Widget_Social extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'social-widget', 'description' => __( 'Social Widget', 'k2t' ) );
		$control_ops = array();
		parent::__construct( 'k2t_social', __( 'Lincoln - social', 'k2t' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$url_twitter = isset ( $instance['twitter_link'] ) ? $instance['twitter_link'] : '';
		$url_facebook = isset ( $instance['facebook_link'] ) ? $instance['facebook_link'] : '';
		$url_instagram = isset ( $instance['instagram_link'] ) ? $instance['instagram_link'] : '';
		$url_google_plus = isset ( $instance['google_plus_link'] ) ? $instance['google_plus_link'] : '';
		$url_pinterest = isset ( $instance['pinterest_link'] ) ? $instance['pinterest_link'] : '';
		$url_linkedin = isset ( $instance['linkedin_link'] ) ? $instance['linkedin_link'] : '';
		$url_youtube = isset ( $instance['youtube_link'] ) ? $instance['youtube_link'] : '';
		$url_vk = isset ( $instance['vk_link'] ) ? $instance['vk_link'] : '';
		echo ( $before_widget );
		$social_html = '';
		if(!empty($url_twitter)) {
			// $url_twitter = 'https://' . str_replace( 'https://', '', $url_twitter );
			$social_html .= "<li class='twitter'><a target='_blank' href=\"$url_twitter\"><i class='fa fa-twitter'></i></a></li>";
		}
		if(!empty($url_facebook)) {
			// $url_facebook = 'https://' . str_replace( 'https://', '', $url_facebook );
			$social_html .= "<li class='facebook'><a target='_blank' href=\"$url_facebook\"><i class='fa fa-facebook'></i></a></li>";
		}
		if(!empty($url_instagram)) {
			// $url_instagram = 'https://' . str_replace( 'https://', '', $url_instagram );
			$social_html .= "<li class='instagram'><a target='_blank' href=\"$url_instagram\"><i class='fa fa-instagram'></i></a></li>";
		}
		if(!empty($url_google_plus)) {
			// $url_google_plus = 'https://' . str_replace( 'https://', '', $url_google_plus );
			$social_html .= "<li class='google'><a target='_blank' href=\"$url_google_plus\"><i class='fa fa-google-plus'></i></a></li>";
		}
		if(!empty($url_pinterest)) {
			// $url_pinterest = 'https://' . str_replace( 'https://', '', $url_pinterest );
			$social_html .= "<li class='pinterest'><a target='_blank' href=\"$url_pinterest\"><i class='fa fa-pinterest'></i></a></li>";
		}
		if(!empty($url_linkedin)) {
			// $url_linkedin = 'https://' . str_replace( 'https://', '', $url_linkedin );
			$social_html .= "<li class='linkedin'><a target='_blank' href=\"$url_linkedin\"><i class='fa fa-linkedin'></i></a></li>";
		}
		if(!empty($url_youtube)) {
			// $url_youtube = 'https://' . str_replace( 'https://', '', $url_youtube );
			$social_html .= "<li class='youtube'><a target='_blank' href=\"$url_youtube\"><i class='fa fa-youtube-play'></i></a></li>";
		}
		if(!empty($url_vk)) {
			// $url_vk = 'https://' . str_replace( 'https://', '', $url_vk );
			$social_html .= "<li class='vk'><a target='_blank' href=\"$url_vk\"><i class='fa fa-youtube-play'></i></a></li>";
		}
		
		echo '<ul>' . $social_html . '</ul>';
		echo ( $after_widget );
	}

	/**
	 * Saves the widgets settings.
	 *
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['twitter_link'] = $new_instance['twitter_link'];
		$instance['facebook_link'] = $new_instance['facebook_link'];
		$instance['instagram_link'] = $new_instance['instagram_link'];
		$instance['google_plus_link'] = $new_instance['google_plus_link'];
		$instance['pinterest_link'] = $new_instance['pinterest_link'];
		$instance['linkedin_link'] = $new_instance['linkedin_link'];
		$instance['youtube_link'] = $new_instance['youtube_link'];
		$instance['vk_link'] = $new_instance['vk_link'];
		return $instance;
	}

	/**
	 * Creates the edit form for the widget.
	 *
	 */
	function form( $instance ) {
		$defaults = array(
			'twitter_link'      => '',
			'facebook_link'     => '',
			'instagram_link'    => '',
			'google_plus_link'  => '',
			'pinterest_link'    => '',
			'linkedin_link'		=> '',
			'youtube_link'		=> '',
			'vk_link'			=> '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		extract( $instance );
?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter_link' ) ); ?>"><?php _e( 'Twitter URL:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_link' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter_link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'facebook_link' ) ); ?>"><?php _e( 'Facebook URL:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook_link' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook_link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'instagram_link' ) ); ?>"><?php _e( 'Instagram URL:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram_link' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram_link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'google_plus_link' ) ); ?>"><?php _e( 'Google Plus URL:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'google_plus_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'google_plus_link' ) ); ?>" type="text" value="<?php echo esc_attr( $google_plus_link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'pinterest_link' ) ); ?>"><?php _e( 'Pinterest URL:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest_link' ) ); ?>" type="text" value="<?php echo esc_attr( $pinterest_link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'linkedin_link' ) ); ?>"><?php _e( 'LinkedIn URL:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin_link' ) ); ?>" type="text" value="<?php echo esc_attr( $linkedin_link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'youtube_link' ) ); ?>"><?php _e( 'Youtube URL:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube_link' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube_link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vk_link' ) ); ?>"><?php _e( 'VK URL:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vk_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vk_link' ) ); ?>" type="text" value="<?php echo esc_attr( $vk_link ); ?>" />
		</p>

		<?php
	} //end of form

} // end class


