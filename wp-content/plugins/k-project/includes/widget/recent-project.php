<?php
/**
 * Recetn Post
 */
add_action( 'widgets_init', 'k2t_recent_project_load_widgets' );
function k2t_recent_project_load_widgets() {
	register_widget( 'k2t_Widget_Recent_project' );
}
class k2t_Widget_Recent_project extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'k2t_widget_latest_posts', 'description' => '' );
		$control_ops = array( 'width' => 250, 'height' => 350 );
		parent::__construct( 'k2t_recent_project', __( 'K2t:Recent Project', 'k2t' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		global $post;
		echo $before_widget;
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if ( !empty( $title ) ) {
			echo $before_title;
			echo esc_html( $title );
			echo $after_title;
		}

		// Load parameter
		$limit       = isset( $instance['limit'] ) ? $instance['limit'] : '';
		$order       = isset( $instance['order'] ) ? $instance['order'] : 'desc';
		$orderby      = isset( $instance['orderby'] ) ? $instance['orderby'] : 'title';
		$columns      = isset( $instance['columns'] ) ? $instance['columns'] : 3;


		// Load data
		$args = array(
			'post_type' => 'post-k-project',
			'post_status' => 'publish',
		);
		if ( !empty( $limit ) ) $args['posts_per_page'] = $limit;
		if ( !empty( $order ) ) $args['order'] = $order;
		if ( !empty( $orderby ) ) $args['orderby'] = $orderby;

		$recent_projects = get_posts( $args );
		$html = '';
		if ( count( $recent_projects ) > 0 ) {
			$columns_class = 'projects-'.$columns;
			$html .= '
				<div class="k2t-latest-projects-widget '.$columns_class.'">
					<ul>';
			foreach ( $recent_projects as $post ) {
				setup_postdata( $post );
				if ( has_post_thumbnail( get_the_ID() ) ) {
					$thumb = get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'alt' => trim( get_the_title() ) ) );
				}else {
					$thumb = '<img src="'.get_template_directory_uri().'/images/thumb-500x500.png" alt="'.trim( get_the_title() ).'" />';
				}
				$html .= '
					<li>
						<div class="project-item">
							<a href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'">'.$thumb.'</a>
						</div><!-- .proejct-item -->
					</li>
				';
			}
			$html .= '
					</ul>
				</div><!-- .recent-projects -->
			';
		}
		echo $html;
		echo $after_widget;
		wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		return $new_instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __( 'Recent Post', 'k2t' ), 'columns' => 3, 'limit' => 6, 'order' => 'desc', 'orderby' => 'title' );
		$instance = wp_parse_args( (array) $instance, $defaults );?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php _e( 'Columns:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'columns' ); ?>" name="<?php echo $this->get_field_name( 'columns' ); ?>">
                <option <?php selected( $instance['columns'], '3' );?> value="3"><?php _e( '3 columns', 'k2t' );?></option>
                <option <?php selected( $instance['columns'], '4' );?> value="4"><?php _e( '4 columns', 'k2t' );?></option>
                <option <?php selected( $instance['columns'], '5' );?> value="5"><?php _e( '5 columns', 'k2t' );?></option>
            </select>
        </p>
        <p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'k2t' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo $instance['limit']; ?>" />
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
                <option <?php selected( $instance['order'], 'desc' );?> value="desc"><?php _e( 'DESC', 'k2t' );?></option>
                <option <?php selected( $instance['order'], 'asc' );?> value="asc"><?php _e( 'ASC', 'k2t' );?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Orderby:', 'k2t' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                <option <?php selected( $instance['orderby'], 'title' );?> value="title"><?php _e( 'Title', 'k2t' );?></option>
                <option <?php selected( $instance['orderby'], 'post_date' );?> value="post_date"><?php _e( 'Date', 'k2t' );?></option>
                <option <?php selected( $instance['orderby'], 'rand' );?> value="rand"><?php _e( 'Random', 'k2t' );?></option>
            </select>
        </p>
		<?php
	}
}
?>
