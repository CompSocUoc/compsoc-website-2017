<?php
/**
 * Recent post widget.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link http://www.lunartheme.com
 */

add_action( 'widgets_init', 'k2t_recent_post_load_widgets' );
function k2t_recent_post_load_widgets() {
	register_widget( 'k2t_Widget_Recent_Post' );
}
class k2t_Widget_Recent_Post extends WP_Widget {

	function __construct() {
		$widget_ops  = array( 'classname' => 'k2t_widget_latest_posts', 'description' => '' );
		$control_ops = array( 'width' => 250, 'height' => 350 );
		parent::__construct( 'k2t_recent_post', __( 'Lincoln - Recent Post', 'k2t' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		global $post;
		echo ( $before_widget );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if ( ! empty( $title ) ) {
			echo ( $before_title );
			echo esc_html($title) ;
			echo ( $after_title );
		}

		// Load parameter
		$limit         = isset( $instance['limit'] ) ? $instance['limit'] : '';
		$order         = isset( $instance['order'] ) ? $instance['order'] : '';
		$orderby       = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
		$display_thumb = isset( $instance['display_thumb'] ) ? $instance['display_thumb'] : '';
		$display_date  = isset( $instance['display_date'] ) ? $instance['display_date'] : '';

		// Load data
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
		);
		if ( ! empty( $limit ) ) $args['posts_per_page'] = $limit;
		if ( ! empty( $order ) ) $args['order'] = $order;
		if ( ! empty( $orderby ) ) $args['orderby'] = $orderby;

		$recent_posts = get_posts( $args );
		$html = '';
		if ( count( $recent_posts ) > 0 ) {
			$html .= '<div class="posts-list">';
			foreach ( $recent_posts as $post ) {
				setup_postdata( $post );
				$thumbnail_link = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
				$image = aq_resize( $thumbnail_link, 80, 80, true );

				if ( has_post_thumbnail( get_the_ID() ) ) {
					$thumb = '<img src="' . $image . '" width="80" height="80" alt="' . trim( get_the_title() ) . '" />';
				} else {
					$thumb = '<img src="' . get_template_directory_uri() . '/assets/img/placeholder/80x80.png" alt="' . trim( get_the_title() ) . '" />';
				}
				$thumb_html = '';
				if ( $display_thumb == 'show' ) {
					$thumb_html = '
						<div class="post-thumb">
							<a href="' . get_permalink( get_the_ID() ) . '" title="' . get_the_title() . '">' . $thumb . '</a>
						</div>
					';
				}
				if ( $display_date == 'show' ) {

					$date_html = '
						<div class="post-meta">
							<i class="zmdi zmdi-calendar-note"></i>
							<em>' . get_the_date( 'F d, Y' ) . '</em>
						</div>
					';
				}
				$html .= '
					<article class="post-item">
						' . $thumb_html . '
						<div class="post-text">
							<h4><a href="' . get_permalink( get_the_ID() ) . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h4>
							' . $date_html . '
						</div>
					</article>
				';
			}
			$html .= '</div>';
		}
		echo ( $html );
		echo ( $after_widget );
		wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		return $new_instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __( 'Recent Post', 'k2t' ), 'limit' => 5, 'order' => 'desc', 'orderby' => 'title', 'display_thumb' => 'show', 'display_date' => 'show' );
		$instance = wp_parse_args( (array) $instance, $defaults );?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Limit:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['limit'] ); ?>" />
		</p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Order:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
                <option <?php selected( $instance['order'], 'desc' ) ?> value="desc"><?php _e( 'DESC', 'k2t' );?></option>
                <option <?php selected( $instance['order'], 'asc' ) ?> value="asc"><?php _e( 'ASC', 'k2t' );?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Orderby:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
                <option <?php selected( $instance['orderby'], 'title' ) ?> value="title"><?php _e( 'Title', 'k2t' );?></option>
                <option <?php selected( $instance['orderby'], 'post_date' ) ?> value="post_date"><?php _e( 'Date', 'k2t' );?></option>
                <option <?php selected( $instance['orderby'], 'rand' ) ?> value="rand"><?php _e( 'Random', 'k2t' );?></option>
            </select>
        </p>
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'display_thumb' ) ); ?>"><?php _e( 'Display Thumbnail:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_thumb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_thumb' ) ); ?>">
                <option <?php selected( $instance['display_thumb'], 'show' ) ?> value="show"><?php _e( 'Show', 'k2t' );?></option>
                <option <?php selected( $instance['display_thumb'], 'hided' ) ?> value="hided"><?php _e( 'Hide', 'k2t' );?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>"><?php _e( 'Display Date:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_date' ) ); ?>">
                <option <?php selected( $instance['display_date'], 'show' ) ?> value="show"><?php _e( 'Show', 'k2t' );?></option>
                <option <?php selected( $instance['display_date'], 'hided' ) ?> value="hided"><?php _e( 'Hide', 'k2t' );?></option>
            </select>
        </p>
		<?php
	}
}
?>
