<?php
/**
 * Recent Event widget.
 *
 * @package Lincoln
 * @author  LunarTheme
 * @link http://www.lunartheme.com
 */

add_action( 'widgets_init', 'k2t_recent_event_load_widgets' );
function k2t_recent_event_load_widgets() {
	register_widget( 'k2t_Widget_Recent_Event' );
}
class k2t_Widget_Recent_Event extends WP_Widget {

	function __construct() {
		$widget_ops  = array( 'classname' => 'k2t_widget_recent_event', 'description' => '' );
		$control_ops = array( 'width' => 250, 'height' => 350 );
		parent::__construct( 'k2t_recent_event', __( 'Lincoln - Recent Event', 'k2t' ), $widget_ops, $control_ops );
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
		$order         = isset( $instance['order'] ) ? $instance['order'] : '';
		$display_date  = isset( $instance['display_date'] ) ? $instance['display_date'] : '';
		$display_location  = isset( $instance['display_location'] ) ? $instance['display_location'] : '';
		$display_button  = isset( $instance['display_button'] ) ? $instance['display_button'] : '';



		// Enqueue
		wp_enqueue_script( 'k-event' );
		wp_enqueue_script( 'k-countdown' );
		wp_enqueue_script( 'k-lodash' );
		// Load data
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'post_type'   => 'post-k-event',
			'orderby'     => 'post_date',
			'posts_per_page' => 1,
		);

		$recent_posts = get_posts( $args );
		if ( count( $recent_posts ) > 0 ) {
			echo '<div class="recent-event">';
			foreach ( $recent_posts as $post ) {
				$event_start_date = (function_exists('get_field')) ? get_field('event_start_date', get_the_ID()) : ''; $event_start_date = empty($event_start_date) ? '' : $event_start_date;
				$event_address = (function_exists('get_field')) ? get_field('event_address', get_the_ID()) : ''; $event_address = empty($event_address) ? '' : $event_address;
				$event_info = array();
				$new_date = strtotime($event_start_date);
				$new_date = date_i18n('Y-m-d H:i', $new_date); 
				$event_info['start_date'] = $new_date;

				setup_postdata( $post );
				
				?>	<div class="event-countdown-container">
						<div class="countdown-container recent-event-countdown"></div>
					</div>
					<article class="event-item recent-event-item">
						<<?php echo 'scr'.'ipt';?> type="text/template" class="countdown-template" data-startdate="<?php echo esc_attr($new_date)?>">
							<div class="time <%= label %>">
							  <span class="count curr top"><%= curr %></span>
							  <span class="count next top"><%= next %></span>
							  <span class="count next bottom"><%= next %></span>
							  <span class="count curr bottom"><%= curr %></span>
							  <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
							</div>
						</<?php echo 'scr'.'ipt';?>>
						
						
						<h4 class="event-title"><a href="<?php echo get_permalink( get_the_ID() ); ?>" title="<?php echo get_the_title() ?>"><?php echo get_the_title(); ?></a></h4>
						<div class="post-meta">
							<?php if ( $display_date == 'show' && !empty($event_start_date)) : ?>
								<span><i class="zmdi zmdi-calendar-note"></i><?= esc_html( date_i18n( 'F d, Y - H:i', strtotime( $event_start_date ) ) ); ?> </span>
							<?php endif;?>
							<?php if ( $display_location == 'show' && !empty($event_address) ) : ?>
								<span><i class="zmdi zmdi-pin"></i><?php echo esc_html($event_address) ?></span>
							<?php endif;?>
						</div>
						<?php if ( $display_button == 'show' ) : ?>
							<a class="join-event k2t-element-hover btn-ripple" href="<?php echo get_permalink( get_the_ID() ); ?>" title="<?php echo get_the_title() ?>"><?php  _e( 'Join This Event', 'k2t'); ?></a>
						<?php endif;?>

					</article>
				<?php
			}
			echo '</div>';
		}
		echo ( $after_widget );
		wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		return $new_instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __( 'Recent Event', 'k2t' ), 'order' => 'desc', 'display_date' => 'show' );
		$instance = wp_parse_args( (array) $instance, $defaults );?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
    
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>"><?php _e( 'Display Date:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_date' ) ); ?>">
                <option <?php selected( $instance['display_date'], 'show' ) ?> value="show"><?php _e( 'Show', 'k2t' );?></option>
                <option <?php selected( $instance['display_date'], 'hided' ) ?> value="hided"><?php _e( 'Hide', 'k2t' );?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'display_location' ) ); ?>"><?php _e( 'Display Location:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_location' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_location' ) ); ?>">
                <option <?php selected( $instance['display_location'], 'show' ) ?> value="show"><?php _e( 'Show', 'k2t' );?></option>
                <option <?php selected( $instance['display_location'], 'hided' ) ?> value="hided"><?php _e( 'Hide', 'k2t' );?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'display_button' ) ); ?>"><?php _e( 'Display Button:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_button' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_button' ) ); ?>">
                <option <?php selected( $instance['display_button'], 'show' ) ?> value="show"><?php _e( 'Show', 'k2t' );?></option>
                <option <?php selected( $instance['display_button'], 'hided' ) ?> value="hided"><?php _e( 'Hide', 'k2t' );?></option>
            </select>
        </p>
		<?php
	}
}
?>
