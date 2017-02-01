<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
Class K_Event {
	static function K_Render_event_listing_calendar ( $style ) {
		$cat = $tag ='';
		$date = date('Y-m-d');
		wp_enqueue_script( 'calendar' );
		wp_enqueue_script( 'jquery-formatDateTime' );
		wp_enqueue_script( 'underscore' );
		wp_enqueue_script( 'jquery-migrate' );
		$calendar_params = array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
		$calendar_params['m0'] = __('January','k2t');
		$calendar_params['m1'] = __('February','k2t');
		$calendar_params['m2'] = __('March','k2t');
		$calendar_params['m3'] = __('April','k2t');
		$calendar_params['m4'] = __('May','k2t');
		$calendar_params['m5'] = __('June','k2t');
		$calendar_params['m6'] = __('July','k2t');
		$calendar_params['m7'] = __('August','k2t');
		$calendar_params['m8'] = __('September','k2t');
		$calendar_params['m9'] = __('October','k2t');
		$calendar_params['m10'] = __('November','k2t');
		$calendar_params['m11'] = __('December','k2t');

		$calendar_params['ms0'] = __('Jan','k2t');
		$calendar_params['ms1'] = __('Feb','k2t');
		$calendar_params['ms2'] = __('Mar','k2t');
		$calendar_params['ms3'] = __('Apr','k2t');
		$calendar_params['ms4'] = __('May','k2t');
		$calendar_params['ms5'] = __('Jun','k2t');
		$calendar_params['ms6'] = __('Jul','k2t');
		$calendar_params['ms7'] = __('Aug','k2t');
		$calendar_params['ms8'] = __('Sep','k2t');
		$calendar_params['ms9'] = __('Oct','k2t');
		$calendar_params['ms10'] = __('Nov','k2t');
		$calendar_params['ms11'] = __('Dec','k2t');

		$calendar_params['d0'] = __('Sun','k2t');
		$calendar_params['d1'] = __('Mon','k2t');
		$calendar_params['d2'] = __('Tue','k2t');
		$calendar_params['d3'] = __('Wed','k2t');
		$calendar_params['d4'] = __('Thu','k2t');
		$calendar_params['d5'] = __('Fri','k2t');
		$calendar_params['d6'] = __('Sat','k2t');

		$calendar_params['buy_text'] = __('BUY TICKET ','k2t');
		$calendar_params['st_text'] = __('Start: ','k2t');
		$calendar_params['en_text'] = __('End: ','k2t');
		$calendar_params['loca_text'] = __('Location: ','k2t');

		wp_localize_script( 'calendar', 'calendar_date_trans', $calendar_params  );
		wp_localize_script( 'jquery-formatDateTime', 'calendar_date_trans', $calendar_params  );

		ob_start();
		?>
		
		<div class="header-content">
			<button class="btn btn-primary" data-calendar-nav="prev"><i class="zmdi zmdi-chevron-left"></i></button>
			<h3></h3>          
			<button class="btn btn-primary" data-calendar-nav="next"><i class="zmdi zmdi-chevron-right"></i></button>
		</div>
		<div id="stm-calendar-id"></div>
		<input type="hidden" id="check-monthdata" value="<?php echo esc_html( $date );?>">
		<input type="hidden" id="month-url" value="<?php echo plugins_url('/monthview/', __FILE__); ?>"> 	
		<input type="hidden" id="check-jsondata" value="<?php echo admin_url( 'admin-ajax.php' )?>">
		<input type="hidden" id="action_data" value="1">
		<input type="hidden" id="action_post_type" value="post-k-event">
		<input type="hidden" id="action_cat" value="<?php echo $cat;?>">
		<input type="hidden" id="calendar_style" value="<?php echo esc_attr( $style );?>">

		<div id="calendar-loading">
			<div class="windows8">
				<div class="wBall" id="wBall_1">
					<div class="wInnerBall"></div>
				</div>
				<div class="wBall" id="wBall_2">
					<div class="wInnerBall"></div>
				</div>
				<div class="wBall" id="wBall_3">
					<div class="wInnerBall"></div>
				</div>
				<div class="wBall" id="wBall_4">
					<div class="wInnerBall"></div>
				</div>
				<div class="wBall" id="wBall_5">
					<div class="wInnerBall"></div>
				</div>
			</div>
		</div>

		<?php
		$event_listing_html = ob_get_clean();
		return $event_listing_html;
	}

	static function K_Render_event_listing_default ( $post_per_page, $event_pagination, $arr_term_id = '', $taxonomy = 'k-event-category' ) {
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );	
		$arr = array(
			'post_type' 		=> 'post-k-event',
			'posts_per_page' 	=> (int)$post_per_page,
			'order'				=> 'DESC',
			'post_status'		=> 'publish',
			'paged'				=> $paged,
			'orderby'			=> 'date',
		);
		if ( count( $arr_term_id ) > 0 && !empty( $arr_term_id ) ){
			$arr['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => explode( ',', $arr_term_id ),
				)
			);
		}
		
		ob_start();
		$query = new WP_Query( $arr );
		?>
		<div class="event-listing-classic">
			<?php
			
			if( count( $query->posts ) > 0 ):
				while( $query->have_posts() ) : $query->the_post();

				$event_address = (function_exists('get_field')) ? get_field('event_address', get_the_ID()) : ''; $event_address = empty($event_address) ? '' : $event_address;
				$thumbnail = (has_post_thumbnail(get_the_ID())) ? true : false;
				$categories = get_the_terms(get_the_ID(), 'k-event-category');
				$title = get_the_title();
				$content = get_the_content();
				$post_link = get_permalink(get_the_ID());
				$post_thumb_size = 'thumb_600x600';
				$post_thumb = '<a href="'. esc_url( $post_link ) .'" title="'. esc_attr( $title ) .'">' . get_the_post_thumbnail(get_the_ID(), $post_thumb_size, array('alt' => trim(get_the_title()))) . '</a>';
				$post_thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				$start_date = ( function_exists('get_field')) ? get_field( 'event_start_date', get_the_ID() ) : '';
				if ( ! empty( $start_date ) ) $start_date = strtotime($start_date);
			?>
				<article class="event-classic-item k2t-element-hover">
					<?php if (!empty($post_thumb)) {
						echo ($post_thumb);
					} ?>
					<?php if(!empty($title)) : ?>
						<h3 class="title">
							<a href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>">
								<?php echo esc_html($title);?>
							</a>
						</h3>
					<?php endif; ?>
					<div class="event-meta">
						<span class="date">
							<i class="zmdi zmdi-calendar-note"></i>
							<?php if ( !empty( $start_date ) ) :?>
							<time data-time="<?php echo esc_attr( date_i18n( 'Y-m-d\TH:i:s+00:00', $start_date ) ); ?>" class="entry-date"><?php echo esc_html( date_i18n( 'F d, Y - H:i', $start_date ) ); ?></time>
							<?php endif;?>
						</span>
						<?php if(!empty($event_address)) : ?>
							<span class="location">
								<i class="zmdi zmdi-pin"></i>
								<?php echo esc_html($event_address); ?>
							</span>
						<?php endif; ?>
					</div>
					<a class="more-link btn-ripple" href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>"><?php _e('Join', 'k2t');?><i class="zmdi zmdi-chevron-right"></i></a>
				</article>
			<?php
				endwhile;
			endif; ?>
			<?php if ( $event_pagination == 'show' ) {
				$GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
				k_event_include_template( 'navigation.php' );
			}
			?>
		</div>
		<?php 
		$event_listing_html = ob_get_clean();
		wp_reset_postdata();
		return $event_listing_html;
	}

	static function K_Render_event_listing_masonry ( $masonry_column, $post_per_page, $event_pagination, $event_masonry_filter, $arr_term_id = '', $taxonomy = 'k-event-category' ) {
		wp_enqueue_script( 'k-event' );
		wp_enqueue_script( 'jquery-isotope' );
		wp_enqueue_script( 'jquery-imagesloaded' );
		wp_enqueue_script( 'cd-dropdown' );
		wp_enqueue_script( 'modernizr' );
		
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );	
		$arr = array(
			'post_type' 		=> 'post-k-event',
			'posts_per_page' 	=> (int)$post_per_page,
			'order'				=> 'DESC',
			'post_status'		=> 'publish',
			'paged'				=> $paged,
			'orderby'			=> 'date',
		);
		if ( count( $arr_term_id ) > 0 && !empty( $arr_term_id ) ){
			$arr['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => explode( ',', $arr_term_id ),
				)
			);
		}
		
		ob_start();
		$query = new WP_Query( $arr );
		?>
		<div class="event-listing-masonry-wrapper">
			<?php if ( $event_masonry_filter == 'show' ): ?>
				<?php 
					if(!function_exists("isMobile")){
						function isMobile() {
						    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
						}
					}
					$categories = get_categories(array('taxonomy' => 'k-event-category'));
					if( count( $categories ) > 0 ):
				?>
					<?php if(isMobile()) : ?>
						<select id="cd-dropdown" class="cd-select k2t-isotope-filter">
							<option value="-1" selected><?php _e( 'Sort Event', 'k2t' );?></option>
							<option class="*"><?php _e( 'All', 'k2t' );?></option>
							<?php foreach($categories as $category):?>
							<option class=".event-<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
							<?php endforeach;?>
						</select>
					<?php else: ?>
						<ul class="event-isotope-filter filter-list">
							<li class="*"><?php _e( 'All', 'k2t' );?></li>
							<?php foreach($categories as $category):?>
							<li class=".event-<?php echo $category->term_id; ?>">
								<?php echo $category->name; ?></li>
							<?php endforeach;?>
						</ul>
					<?php endif;?>
				<?php endif; ?>
			<?php endif; ?>

			<div class="event-listing-masonry <?php echo esc_html($masonry_column); ?>">
				<?php
				
				if( count( $query->posts ) > 0 ):
					while( $query->have_posts() ) : $query->the_post();
						self::grid_render_content();
					endwhile;
				endif; ?>
			</div><!--event-listing-masonry-->
			<?php if ( $event_pagination == 'show' ) {
				$GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
				k_event_include_template( 'navigation.php' );
			}
			?>
		</div><!--/event-listing-masonry-wrapper-->
		<?php 
		$event_listing_html = ob_get_clean();
		wp_reset_postdata();
		return $event_listing_html;
	}

	static function K_Render_event_listing_carousel ( $masonry_column, $number_post_show, $event_pagination, $event_navigation, $arr_term_id = '', $taxonomy = 'k-event-category' ) {
		$arr = array(
			'post_type' 		=> 'post-k-event',
			'posts_per_page' 	=> (int)$number_post_show,
			'order'				=> 'DESC',
			'post_status'		=> 'publish',
			'orderby'			=> 'date',
		);
		if ( count( $arr_term_id ) > 0 && !empty( $arr_term_id ) ){
			$arr['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => explode( ',', $arr_term_id ),
				)
			);
		}
		
		ob_start();
		$query = new WP_Query( $arr );
		?>
		<div class="event-listing-masonry-wrapper">

			<div class="event-listing-masonry event-listing-carousel owl-carousel owl-stretch"
				data-items="<?php echo esc_attr( str_replace( 'columns-', '', $masonry_column ) ); ?>" data-autoPlay="false" data-margin="30" data-nav="<?php echo ( $event_navigation == 'show' ? 'true' : 'false' );?>"
				data-dots="<?php echo ( $event_pagination == 'show' ? 'true' : 'false' );?>" data-mobile="1" data-tablet="2" data-desktop="<?php echo esc_attr( str_replace( 'columns-', '', $masonry_column ) ); ?>">
				<?php
				
				if( count( $query->posts ) > 0 ):
					while( $query->have_posts() ) : $query->the_post();
						self::grid_render_content();
					endwhile;
				endif; ?>
			</div><!--event-listing-masonry-->
		</div><!--/event-listing-masonry-wrapper-->
		<?php 
		$event_listing_html = ob_get_clean();
		wp_reset_postdata();
		return $event_listing_html;
	}

	static function grid_render_content () {
		$event_address = (function_exists('get_field')) ? get_field('event_address', get_the_ID()) : ''; $event_address = empty($event_address) ? '' : $event_address;
		$thumbnail = (has_post_thumbnail(get_the_ID())) ? true : false;
		$categories = get_the_terms(get_the_ID(), 'k-event-category');
		$title = get_the_title();
		$content = get_the_content();
		$post_link = get_permalink(get_the_ID());
		$post_thumb_size = 'thumb_600x600';
		$post_thumb = '<a href="'. esc_url( $post_link ) .'" title="'. esc_attr( $title ) .'">' . get_the_post_thumbnail(get_the_ID(), $post_thumb_size, array('alt' => trim(get_the_title()))) . '</a>';
		$post_thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
		$start_date = ( function_exists('get_field')) ? get_field( 'event_start_date', get_the_ID() ) : '';
		if ( ! empty( $start_date ) ) $start_date = strtotime($start_date);
		$post_classes = array();	
		if(count($categories) > 0 && is_array($categories)){
			foreach ($categories as $key => $category) {
				$post_classes[] = 'event-'.$category->term_id;
			}
		}
		$post_classes = implode(' ',$post_classes);
	?>
		<article class="masonry-item masonry-it <?php echo ($post_classes) ;?>">
			<div class="inner k2t-element-hover">
				<?php if (!empty($post_thumb)) {
					echo ($post_thumb);
				} ?>
				<div class="info">
					<a class="read-more" href="<?php echo esc_url($post_link);?>" title="<?php echo esc_attr( $title );?>"><i class="zmdi zmdi-plus"></i></a>
					<?php if(!empty($title)) : ?>
						<h3 class="title">
							<a href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>">
								<?php echo esc_html($title);?>
							</a>
						</h3>
					<?php endif; ?>
					<div class="event-meta">
						<span class="date">
							<i class="zmdi zmdi-calendar-note"></i>
							<?php if ( !empty( $start_date ) ) :?>
							<time data-time="<?php echo esc_attr( date_i18n( 'Y-m-d\TH:i:s+00:00', $start_date ) ); ?>" class="entry-date"><?php echo esc_html( date_i18n( 'F d, Y - H:i', $start_date ) ); ?></time>
							<?php endif;?>
						</span>
						<?php if(!empty($event_address)) : ?>
							<span class="location">
								<i class="zmdi zmdi-pin"></i>
								<?php echo esc_html($event_address); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</article>
	<?php
		wp_reset_postdata();
	}
}

/**
 * Download event ICAL
 */
if ( ! function_exists( 'k2t_events_ical' ) ) {
	function k2t_events_ical() {
		if(isset($_GET['ical_id'])&& $_GET['ical_id']>0){
			// - start collecting output -
			ob_start();
			
			// - file header -
			header('Content-type: text/calendar');
			header('Content-Disposition: attachment; filename="uni ical.ics"');
			global $post;
			// - content header -
			?>
			<?php
			$content = "BEGIN:VCALENDAR\r\n";
			$content .= "VERSION:2.0\r\n";
			$content .= 'PRODID:-//'.get_bloginfo( 'name' )."\r\n";
			$content .= "CALSCALE:GREGORIAN\r\n";
			$content .= "METHOD:PUBLISH\r\n";
			$content .= 'X-WR-CALNAME:'.get_bloginfo( 'name' )."\r\n";
			$content .= 'X-ORIGINAL-URL:'.get_permalink( $_GET['ical_id'] )."\r\n";
			$content .= 'X-WR-CALDESC:'.get_the_title( $_GET['ical_id'] )."\r\n";
			?>
			<?php
			
			$date_format 		= get_option( 'date_format' );
			$hour_format 		= get_option( 'time_format' );
			$startdate 			= get_field( $_GET['ical_id'], 'event_start_date' );
			if ( $startdate ) {
				$startdate = gmdate( "Ymd\THis", $startdate );// convert date ux
			}
			$enddate 			= get_field( $_GET['ical_id'], 'event_end_date' );
			if( $enddate ){
				$enddate = gmdate( "Ymd\THis", $enddate );
			}
			
			//// - grab gmt for start -
			$gmts = get_gmt_from_date( $startdate ); // this function requires Y-m-d H:i:s, hence the back & forth.
			$gmts = strtotime($gmts);
			
			// - grab gmt for end -
			$gmte = get_gmt_from_date( $enddate ); // this function requires Y-m-d H:i:s, hence the back & forth.
			$gmte = strtotime( $gmte );
			
			// - Set to UTC ICAL FORMAT -
			$stime = date( 'Ymd\THis', $gmts );
			$etime = date( 'Ymd\THis', $gmte );
			
			// - item output -
			?>
			<?php
			$content .= "BEGIN:VEVENT\r\n";
			$content .= 'DTSTART:'.$startdate."\r\n";
			$content .= 'DTEND:'.$enddate."\r\n";
			$content .= 'SUMMARY:'.get_the_title( $_GET['ical_id'] )."\r\n";
			$content .= 'DESCRIPTION:'.get_post( $_GET['ical_id'] )->post_excerpt."\r\n";
			$content .= 'LOCATION:'.get_field( $_GET['ical_id'],'event_address' )."\r\n";
			$content .= "END:VEVENT\r\n";
			$content .= "END:VCALENDAR\r\n";
			// - full output -
			$tfeventsical = ob_get_contents();
			ob_end_clean();
			echo $content;
			exit;
		}
	}
	add_action('init','k2t_events_ical');
}

/**
 * Load event ajax with calendar
 */
if ( ! function_exists( 'k2t_calendar_data_json' ) ) {
	function k2t_calendar_data_json() {	
		if( isset( $_GET['cal_json'] ) && $_GET['cal_json']==1 ) {
			$post_type 					= 'post-k-event';
			$UTCConverGet 				= $_GET['nTimeOffsetToUTC'];
			$cat 						= $_GET['cat'];
			$style 						= $_GET['style'];
			$args 						= array(
				'post_type' 					=> $post_type,
				'posts_per_page' 				=> -1,
				'post_status' 					=> 'publish',
				'ignore_sticky_posts' 			=> 1,
			);

			if( ! is_array( $cat ) && $cat != '' ) {
				$cats 				= explode(",",$cat);
				if( is_numeric( $cats[0] ) ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'k-event-category',
							'field'    => 'id',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				} else {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'k-event-category',
							'field'    => 'slug',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}
			} elseif ( count( $cat ) > 0 && $cat != '' ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'k-event-category',
						'field'    => 'id',
						'terms'    => $cat,
						'operator' => 'IN',
					)
				);
			}

			$the_query 				= new WP_Query( $args );
			$data_rs 				= $rs = array();
			$success 				= 1;
			if( $the_query->have_posts() ) {
				$date_format 		= get_option('date_format');
				$hour_format 		= get_option('time_format');
				while( $the_query->have_posts() ){ 
					$the_query->the_post();

					// Get metadata of event in single
					$single_pre 			= 'event_';
					$arr_event_meta_val  	= array();
					$arr_event_meta 		= array(
						// Infomation
						'start_date'					=> '',
						'end_date'						=> '', 
						'color'							=> '',
					);

					foreach ( $arr_event_meta as $meta => $val ) {
						if ( function_exists( 'get_field' ) ) {
							if ( get_field( $single_pre . $meta, $id ) ) {
								$arr_event_meta_val[$meta] = get_field( $single_pre . $meta, $id );
							}
						}
					}
					extract( shortcode_atts( $arr_event_meta, $arr_event_meta_val ) );

					$color_event = get_post_meta(get_the_ID(),'color_event', true );
					$ar_rs = array(
						'style'					=> $style,
						'id' 					=> get_the_ID(),
						'title' 				=> get_the_title(),
						'posttype' 				=> $post_type,
						'url' 					=> get_permalink(),
						'class' 				=> $color,
						'start'					=> strtotime( $start_date ) * 1000 + ( $UTCConverGet*60*60*1000 ),
						'end'					=> strtotime( $start_date ) * 1000 + ( $UTCConverGet*60*60*1000 ),
						'startDate'				=> date( 'h:i', strtotime($start_date) ), //date_i18n( get_option('date_format'), strtotime($start_date)),
						'endDate'				=> date_i18n( get_option('date_format'), strtotime($end_date)),
					);
					$rs[] = $ar_rs;
				}
			}
			$data_rs = array(
				'success' 		=> $success,
				'result' 		=> $rs,
			);
			echo str_replace('\/', '/', json_encode($data_rs));
			exit;
		}
			
	}
	add_action( 'wp_ajax_k2t_calendar_data', 'k2t_calendar_data_json' );
	add_action( 'wp_ajax_nopriv_k2t_calendar_data', 'k2t_calendar_data_json' );
}