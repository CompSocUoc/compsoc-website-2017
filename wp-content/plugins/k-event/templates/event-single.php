<?php global $smof_data, $wp_embed;
get_header();

// Register variables
$classes 						= array();
$single_pre 					= 'event_';

// Get metadata of event in single
$arr_event_meta_val  	= array();
$arr_event_meta 		= array( 
	// Layout
	'layout'						=> 'right_sidebar', 
	'custom_sidebar' 				=> '',

	// Infomation
	'start_date'					=> '',
	'end_date'						=> '', 
	'event_id'						=> '', 
	'product'						=> '', 
	'who_is_speakers'				=> '', 
	'teacher'						=> '',
	'speakers'						=> '',
	'subscribe_url'					=> '', 
	'subscribe_button_text'			=> '',
	'show_hide_button_join'			=> '',
	'show_hide_number_tickets'		=> '',
	'show_hide_countdown' 			=> 'show',
	'format_date_time'				=> 'F d, Y',
	
	// Location
	'address'						=> '', 
	'phone'							=> '', 
	'website'						=> '', 
	'email'							=> '',
);

foreach ( $arr_event_meta as $meta => $val ) {
	if ( function_exists( 'get_field' ) ) {
		if ( get_field( $single_pre . $meta, $id ) ) {
			$arr_event_meta_val[$meta] = get_field( $single_pre . $meta, $id );
		}
	}
}
extract( shortcode_atts( $arr_event_meta, $arr_event_meta_val ) );

$event_info = array();

$new_date = strtotime( $start_date );
$new_date = date_i18n('Y-m-d H:i', $new_date); 
$event_info['start_date'] = $new_date;

wp_enqueue_script( 'k-event' );
wp_localize_script( 'k-event', 'event_info', $event_info );
wp_enqueue_script( 'k-countdown' );
wp_enqueue_script( 'k-lodash' );

// Layout of single event
if ( ( empty( $layout ) || $layout == 'default' ) && ! empty( $smof_data['event-layout'] ) ) {
	if( isset( $smof_data['rtl_lang'] ) && $smof_data['rtl_lang'] == '1' ){
		$layout = 'left_sidebar';
	}
	else
		$layout = $smof_data['event-layout'];
} else if ( empty( $smof_data['event-layout'] ) ) {
	$layout = 'right_sidebar';
}
if ( 'right_sidebar' == $layout ){	
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'no_sidebar' == $layout ) {
	$classes[] = 'no-sidebar';
}

?>

	<div class="k2t-content <?php echo implode( ' ', $classes ) ?>">
		<div class="k2t-wrap">
			<main class="k2t-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<div id="main-col" <?php post_class(); ?>>

						<div class="k2t-row">
							<div class="event-entry-meta col-4">
								<div class="k2t-element-hover">
									<?php if(has_post_thumbnail(get_the_ID())):?>
										<div class="event-thumbnail">
											<?php 
												echo get_the_post_thumbnail(get_the_ID(), 'thumb_600x600', array('alt'   => get_the_title()));
											?>
										</div>
									<?php endif;?>
									<div class="entry-meta-inner">
										<div class="product-price">
											<?php 
												$product = (function_exists('get_field')) ? get_field('event_product', get_the_ID()) : ''; $product = empty($product) ? '' : $product;
												if ( !empty( $product ) && class_exists( 'WOO' ) ):
											?>
												<h4><?php _e( 'Price', 'k2t' )?></h4>
												<span class="price">
													<?php 
														$product = new WC_Product( $product->ID );
														$price = $product->get_price_html();
														echo ($price);
													?>
												</span>
											<?php endif;?>
										</div>
										<?php if( isset( $show_hide_number_tickets) && $show_hide_number_tickets == 'show' ): ?>
											<div class="event-ticket">
												<h4><?php _e( 'Number of Tickets:', 'k2t' )?></h4>
												<div class="ticket-input">
			        								<input type="text" name="ticket" value="1">
			        								<span class="inc button"><i class="zmdi zmdi-caret-up"></i></span>
			        								<span class="dec button"><i class="zmdi zmdi-caret-down"></i></span>
			        							</div>
											</div>
										<?php endif; ?>
										<?php if( isset( $show_hide_button_join ) && $show_hide_button_join == 'show' ): ?>
											<?php $product = (function_exists('get_field')) ? get_field('event_product', get_the_ID()) : ''; $product = empty($product) ? '' : $product;
												if(!empty($product)):
											?>
												<a href="<?php echo get_post_permalink($product->ID); ?>" target="_self" class="event-link btn-ripple" ><?php echo !empty($subscribe_button_text) ? $subscribe_button_text : __('Launch Event', 'k2t'); ?></a>
											<?php else :?>
					                            <a href="<?php echo esc_url($subscribe_url);?>" target="_self" class="event-link btn-ripple" ><?php echo !empty($subscribe_button_text) ? $subscribe_button_text : __('Launch Event', 'k2t'); ?></a>
					                        <?php endif;?>
				                    	<?php endif; ?>
									</div><!--entry-meta-inner-->
									
								</div>
								<?php 

								if( isset( $show_hide_countdown ) && $show_hide_countdown == 'show' ): ?>
									<div class="event-countdown-container">
										<div class="countdown-container"></div>
									</div>
									<div class="event-countdown-template">
										<<?php echo 'scr'.'ipt';?> type="text/template" class="countdown-template" data-startdate="<?php echo esc_attr($new_date)?>">
											<div class="time <%= label %>">
											  <span class="count curr top"><%= curr %></span>
											  <span class="count next top"><%= next %></span>
											  <span class="count next bottom"><%= next %></span>
											  <span class="count curr bottom"><%= curr %></span>
											  <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
											</div>
										</<?php echo 'scr'.'ipt';?>>
									</div>
								<?php endif; ?>
							</div>
							<div class="entry-content col-8">

								<!-- Speakers -->
								<?php if ( $who_is_speakers == 'out_school' ) : ?>
									<?php if ( is_array( $speakers ) && count( $speakers ) > 0 ) : ?>
										<div class="entry-speakers">
											<h3 class="h"><i class="zmdi zmdi-mic"></i><span><?php _e( 'Speakers', 'k2t' )?></span></h3>
											<div class="k2t-row">
											<?php foreach ( $speakers as $key => $speaker ) : //var_dump($speaker);?>
												<div class="col-6">
													<!-- Avatar of Speaker -->
													<?php if ( ! empty( $speaker['event_speaker_avatar'] ) ) : ?>
														<div class="speaker-avatar k2t-element-hover">
															<img src="<?php echo esc_url( $speaker['event_speaker_avatar'] )?>" alt="<?php echo esc_attr( $speaker['event_speaker_name'] ); ?>" />
														</div>
													<?php endif;?>

													<!-- Name and Role of Speaker -->
													<?php if ( ! empty( $speaker['event_speaker_name'] ) ) : ?>
													<h4 class="name"><?php echo esc_html( $speaker['event_speaker_name'] ); ?></h4>
													<?php endif;?>
													<?php if ( ! empty( $speaker['event_speaker_role'] ) ) : ?>
													<span class="role"><?php echo esc_html( $speaker['event_speaker_role'] ); ?></span>
													<?php endif;?>
												</div>
											<?php endforeach;?>
											</div>
										</div>
									<?php endif;?>
								<?php elseif ( is_array( $teacher ) && count( $teacher ) > 0 ) : ?>
									<div class="entry-speakers">
										<h3 class="h"><i class="zmdi zmdi-mic"></i><span><?php _e( 'Speakers', 'k2t' )?></span></h3>
										<div class="k2t-row">
										<?php foreach ( $teacher as $key => $teach ) : ?>
											<div class="col-6">
												<!-- Avatar of Speaker -->
												<?php if ( has_post_thumbnail( $teach->ID ) ) : ?>
													<div class="speaker-avatar k2t-element-hover">
														<?php echo '<a href="'. esc_url( get_permalink( $teach->ID ) ) .'" target="_blank" title="'. esc_attr( get_the_title( $teach->ID ) ) .'">' . get_the_post_thumbnail( $teach->ID, 'thumb_130x130' ) . '</a>';?>
													</div>
												<?php endif;?>

												<!-- Name and Role of Speaker -->
												<h4 class="name"><?php echo '<a href="'. esc_url( get_permalink( $teach->ID ) ) .'" target="_blank" title="'. esc_attr( get_the_title( $teach->ID ) ) .'">' . esc_html( $teach->post_title ) . '</a>';?></h4>
												<?php $position = get_field(  'teacher_position', $teach->ID );?>
												<?php if ( ! empty( $position ) ) : ?>
												<span class="role"><?php echo esc_html( $position ); ?></span>
												<?php endif;?>
											</div>
										<?php endforeach;?>
										</div>
									</div>
								<?php endif;?>
								<!-- END Speakers -->

								<div class="k2t-row">
									<!-- Time -->
									<?php if ( ! empty( $start_date ) && ! empty( $end_date ) ) : $start_date = strtotime( $start_date ); $end_date = strtotime( $end_date ); ?>
										<div class="col-6 event-time">
											<h3 class="h"><i class="zmdi zmdi-time"></i><span><?php _e( 'Time', 'k2t' )?></span></h3>
											<?php if(!empty($start_date)) : ?>
												<div class="start-event">
													<span><?php _e( 'Start:', 'k2t' ); ?></span>
													<time data-time="<?php echo esc_attr( date( 'Y-m-d\TH:i:s+00:00', $start_date ) ); ?>" class="entry-date"><?php echo esc_html( date_i18n( $format_date_time . ' - H:i', $start_date ) ); ?></time>
												</div>
											<?php endif; ?>
											<?php if(!empty($end_date)) : ?>
												<div class="end-event">
													<span><?php _e( 'End:', 'k2t' ); ?></span>
													<time data-time="<?php echo esc_attr( date( 'Y-m-d\TH:i:s+00:00', $end_date ) ); ?>" class="entry-date"><?php echo esc_html( date_i18n( $format_date_time . ' - H:i', $end_date ) ); ?></time>
												</div>
											<?php endif; ?>
										</div>
									<?php endif;?>
									<!-- END Time -->

									<!-- Address -->
									<?php if ( ! empty( $address ) ) : ?>
										<div class="col-6 event-address">
											<h3 class="h"><i class="zmdi zmdi-pin"></i><span><?php _e( 'Address', 'k2t' )?></span></h3>
											<div><?php echo esc_html( $address ); ?></div>
										</div>
									<?php endif;?>
									<!-- END Address -->
								</div>

								<!-- Event line --><hr/>

								<!-- Description -->
								<div class="event-description">
									<h3 class="h"><i class="zmdi zmdi-dot-circle"></i><span><?php _e( 'Description', 'k2t' )?></span></h3>
									<div class="content">
										<?php the_content();?>
									</div>
								</div>

								<!-- Event Calendar Import -->
								<div class="calendar-export clearfix">
									<?php if ( !empty( $start_date ) && ! empty( $end_date ) ) : ?>
										<?php 
											$startdate_cal 		= gmdate( "Ymd\THis\Z", $start_date );
											$enddate_cal 		= gmdate( "Ymd\THis\Z", $end_date );
										?>
										<a class="k2t-element-hover" href="https://www.google.com/calendar/render?dates=<?php echo esc_attr( $startdate_cal );?>/<?php echo esc_attr( $enddate_cal ); ?>&action=TEMPLATE&text=<?php echo get_the_title( get_the_ID() );?>&location=<?php echo esc_attr( $address );?>&details=<?php echo get_the_excerpt();?>"><?php _e( 'Google Calendar', 'k2t' ); ?><i class="zmdi zmdi-plus"></i></a>
									<?php endif;?>
									<a class="k2t-element-hover" href="<?php echo home_url().'?ical_id='.get_the_ID(); ?>"><?php _e( 'Ical Export', 'k2t' );?><i class="zmdi zmdi-plus"></i></a>
									<?php // tf_events_ical();?>
								</div>

								<?php if (function_exists( 'k2t_social_share' ) ) {k2t_social_share();}?>

	                            <a href="<?php echo esc_url($subscribe_url) ? esc_url($subscribe_url) : get_post_permalink( $product->ID ) ;?>" target="_self" class="event-link btn-ripple k2t-element-hover" ><?php echo !empty($subscribe_button_text) ? $subscribe_button_text : __('Launch Event', 'k2t'); ?></a>

		                        <?php if ($smof_data['event-related'] ) include( 'event-related.php' ); ?>


							</div>
						</div>
						
					</div><!-- #main-col -->

				<?php endwhile; ?>
				
				<div class="clear"></div>
				
				<?php if ( comments_open() ) :
						comments_template( '', false );
					endif;
				?>
			</main><!-- .k2t-blog -->

			<?php
				if ( 'right_sidebar' == $layout || 'left_sidebar' == $layout ) {
					get_sidebar();	
				}
			?>

		</div><!-- .k2t-wrap -->
	</div><!-- .k2t-content -->

<?php get_footer(); ?>