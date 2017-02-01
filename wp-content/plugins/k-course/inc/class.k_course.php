<?php
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	Class K_Course{

		static function K_Render_course_listing_default ( $post_per_page, $course_pagination, $course_date = 'show' , $arr_term_id = '', $taxonomy = 'k-course-category' ) {

			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );	
			$arr = array(
				'post_type' 		=> 'post-k-course',
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

			<div class="course-listing-classic">
				<?php
				
				if( count( $query->posts ) > 0 ):
					while( $query->have_posts() ) : $query->the_post();

					$thumbnail = (has_post_thumbnail(get_the_ID())) ? true : false;
					$categories = get_the_terms(get_the_ID(), 'k-course-category');
					$start_date = (function_exists('get_field')) ? get_field('course_start_date', get_the_ID()) : '';
					$title = get_the_title();
				    $content = get_the_content();
					$post_link = get_permalink(get_the_ID());
					$post_thumb_size = 'thumb_600x600';
					$post_thumb = '<a href="'. esc_url( $post_link ) .'" title="'. esc_attr( $title ) .'">' . get_the_post_thumbnail(get_the_ID(), $post_thumb_size, array('alt' => trim(get_the_title()))) . '</a>';
					$post_thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				?>
					<article class="course-classic-item k2t-element-hover">
						<?php if ( ! empty( $post_thumb ) ) { echo ( $post_thumb ); } ?>
						<span class="entry-date"><i class="zmdi zmdi-calendar-note"></i>
							<?php echo get_the_date( 'F d, Y' ); ?>
						</span>
						<?php if( ! empty( $title ) ) : ?>
			                <h3 class="title">
			                    <a href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>">
			                        <?php echo esc_html( $title );?>
			                    </a>
			                </h3>
			            <?php endif; ?>
		                <div class="course-excerpt">
		                	<?php the_excerpt();?>
		                </div>
		                <a class="more-link btn-ripple" href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>"><?php _e('Apply', 'k2t');?><i class="zmdi zmdi-chevron-right"></i></a>
		                
	        		</article>
	            <?php
					endwhile;
				endif; ?>
				<?php if ( $course_pagination == 'show' ) {
					$GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
					include('navigation.php');
				}
				?>
			</div>
			<?php 
			$course_listing_html = ob_get_clean();
			wp_reset_postdata();
			return $course_listing_html;
		}
		
		static function K_Render_course_listing_carousel( $course_carousel_navi, $post_per_page, $masonry_column, $course_pagination, $course_date = 'show', $course_price = 'text', $arr_term_id = '', $taxonomy = 'k-course-category' ) {

			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );	
			$arr = array(
				'post_type' 		=> 'post-k-course',
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
			<div class="course-listing-masonry-wrapper">
				<div class="course-listing-masonry course-listing-carousel owl-carousel owl-stretch"
				data-items="<?php echo esc_attr( str_replace( 'columns-', '', $masonry_column ) ); ?>" data-autoPlay="true" data-margin="30" data-nav="<?php echo ( $course_carousel_navi == 'show' ? 'true' : 'false' );?>"
				data-dots="<?php echo ( $course_pagination == 'show' ? 'true' : 'false' );?>" data-mobile="1" data-tablet="2" data-desktop="3">
					<?php
					
					if( count( $query->posts ) > 0 ):
						while( $query->have_posts() ) : $query->the_post();
							self::grid_render_course_content( $course_price );
						endwhile;
					endif; ?>
				</div>
			</div><!--/wrapper-->
			<?php 
			$course_listing_html = ob_get_clean();
			wp_reset_postdata();
			return $course_listing_html;
		}
		
		
		/* ================================== end ============================ */

		static function K_Render_course_listing_masonry ( $post_per_page, $masonry_column, $course_masonry_filter, $course_pagination, $course_date = 'show', $course_price = 'text', $arr_term_id = '', $taxonomy = 'k-course-category' ) {
			wp_enqueue_script( 'k-course' );
			wp_enqueue_script( 'jquery-isotope' );
			wp_enqueue_script( 'jquery-imagesloaded' );
			wp_enqueue_script( 'cd-dropdown' );
			wp_enqueue_script( 'modernizr' );

			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );	
			$arr = array(
				'post_type' 		=> 'post-k-course',
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
			<div class="course-listing-masonry-wrapper">
				<?php if ( $course_masonry_filter == 'show' ): ?>
					<?php 
						if(!function_exists("isMobile")){
							function isMobile() {
							    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
							}
						}
						if ( count( $arr_term_id ) > 0 && !empty( $arr_term_id ) ){
							foreach( array( $arr_term_id ) as $term_id ) {
								$categories[] = get_term( $term_id, 'k-course-category' );
							}
						} else{
							$categories = get_categories(array('taxonomy' => 'k-course-category'));
							if( count( $categories ) > 0 ):
						?>
							<?php if(isMobile()) : ?>
								<select id="cd-dropdown" class="cd-select k2t-isotope-filter">
									<option value="-1" selected><?php _e( 'Sort Course', 'k2t' );?></option>
									<option class="*"><?php _e( 'All', 'k2t' );?></option>
									<?php foreach($categories as $category):?>
									<option class=".course-<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
									<?php endforeach;?>
								</select>
							<?php else: ?>
								<ul class="course-isotope-filter filter-list">
									<li class="*"><?php _e( 'All', 'k2t' );?></li>
									<?php foreach($categories as $category):?>
									<li class=".course-<?php echo $category->term_id; ?>">
										<?php echo $category->name; ?></li>
									<?php endforeach;?>
								</ul>
							<?php endif;?>
						<?php endif; ?>
					<?php }?>
				<?php endif; ?>

				<div class="course-listing-masonry <?php echo esc_html($masonry_column); ?>">
					<?php
					
					if( count( $query->posts ) > 0 ):
						while( $query->have_posts() ) : $query->the_post();
							self::grid_render_course_content( $course_price );
						endwhile;
					endif; ?>
				</div>
			</div><!--/wrapper-->
			<?php if ( $course_pagination == 'show' ) {
				$GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
				include('navigation.php');
			}?>
			<?php 
			$course_listing_html = ob_get_clean();
			wp_reset_postdata();
			return $course_listing_html;
		}

		// grid course content
		static function grid_render_course_content ( $course_price ){
			$product = (function_exists('get_field')) ? get_field('course_product', get_the_ID()) : ''; 
			$product = empty($product) ? '' : $product;
			$product = isset($product[0]) ? $product[0] : null;
			if ( !empty( $product ) && class_exists( 'WOO' ) ):
				$product_course = new WC_Product( $product->ID );
				$price_course = $product_course->get_price_html();
				$price_course = ( $product_course->get_price() == '0' ) ? 'Free' : $price_course; 
				$rating = $product_course->get_average_rating();
			else: 
				$price_course = "Free";
				$rating = '';
			endif;
			$course_address = (function_exists('get_field')) ? get_field('course_address', get_the_ID()) : ''; $course_address = empty($course_address) ? '' : $course_address;
			$thumbnail = (has_post_thumbnail(get_the_ID())) ? true : false;
			$categories = get_the_terms(get_the_ID(), 'k-course-category');
			$title = get_the_title();
		    $content = get_the_content();
		    $start_date = (function_exists('get_field')) ? get_field('course_start_date', get_the_ID()) : '';
			$post_link = get_permalink(get_the_ID());
			$post_thumb_size = 'thumb_600x340';

			$post_thumb = '<a href="'. esc_url( $post_link ) .'" title="'. esc_attr( $title ) .'">' . get_the_post_thumbnail(get_the_ID(), $post_thumb_size, array('alt' => trim(get_the_title()))) . '</a>';
			$post_thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );

			$post_classes = array();	
			if(count($categories) > 0 && is_array($categories)){
				foreach ($categories as $key => $category) {
					$post_classes[] = 'course-'.$category->term_id;
				}
			}
			$post_classes = implode(' ',$post_classes);
		?>
			<article class="masonry-item <?php echo ($post_classes) ;?>">
				<div class="inner k2t-element-hover">
					<?php if (!empty($post_thumb)) {
						echo ($post_thumb);
					} ?>
					<div class="info">
						<div class="course-meta">
							<?php if ( $course_date != 'hide' ) : ?>
		                	<span class="date">
		                		<i class="zmdi zmdi-calendar-note"></i>
		                		<?php echo get_the_date( 'F d, Y' ); ?>
		                	</span>
		                	<?php endif;?>
		                </div>

						<?php if(!empty($title)) : ?>
			                <h3 class="title">
			                    <a href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>">
			                        <?php echo esc_html($title);?>
			                    </a>
			                </h3>
			            <?php endif; ?>
			             <div class="course-excerpt">
		                	<?php the_excerpt();?>
		                </div>
		                <?php if ( $course_price == 'text' ) :?>
		                	<a class="more-link" href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>"><?php _e('Apply', 'k2t');?><i class="zmdi zmdi-chevron-right"></i></a>
		            	<?php else: ?>
		            		<p class="price-rating">
		            		<a class="more-link" href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>"><?php echo $price_course;?></a>
		            		<span class="c-rating">
		            			<?php 
		            				if ( isset($rating) && !empty( $rating) ) :
		            					echo $rating;?>
		            				<i class="zmdi zmdi-star"></i>
		            			<?php endif;?>
		            		</span>
		            	<?php endif;?>
		                
		            </div>
	            </div>
    		</article>
		    <?php
			wp_reset_postdata();
		}
		/*============ end ================ */
		
	}