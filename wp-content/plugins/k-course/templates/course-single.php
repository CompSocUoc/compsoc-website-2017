<?php global $smof_data, $wp_embed;
get_header();

// Register variables
$classes 						= array();
$single_pre 					= 'course_';
$course_id = (function_exists('get_field')) ? get_field('course_id', get_the_ID()) : ''; 
$course_id = empty($course_id) ? '' : $course_id;
// Get metadata of course in single
$arr_course_meta_val  	= array();
$arr_course_meta 		= array( 
	// Layout
	'layout'						=> 'right_sidebar', 
	'custom_sidebar' 				=> '',

	// Infomation
	'start_date'					=> '',
	'id'							=> '', 
	'product'						=> '', 
	'address'						=> '', 
	'duration'						=> '', 
	'who_is_speakers'				=> '', 
	'teacher'						=> '', 
	'speakers'						=> '',
	'subscribe_url'					=> '', 
	'subscribe_button_text'			=> '',
	'download'						=> '',
);

foreach ( $arr_course_meta as $meta => $val ) {
	if ( function_exists( 'get_field' ) ) {
		if ( get_field( $single_pre . $meta, $id ) ) {
			$arr_course_meta_val[$meta] = get_field( $single_pre . $meta, $id );
		}
	}
}
extract( shortcode_atts( $arr_course_meta, $arr_course_meta_val ) );

wp_enqueue_script( 'k-course' );
wp_enqueue_script( 'k-countdown' );
wp_enqueue_script( 'k-lodash' );

// Layout of single course
if ( ( empty( $layout ) || $layout == 'default' ) && ! empty( $smof_data['course-layout'] ) ) {
	if( isset( $smof_data['rtl_lang'] ) && $smof_data['rtl_lang'] == '1' ){
		$layout = 'left_sidebar';
	}
	else
		$layout = $smof_data['course-layout'];
} else if ( empty( $smof_data['course-layout'] ) ) {
	$layout = 'right_sidebar';
}
if ( 'right_sidebar' == $layout ){	
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'no_sidebar' == $layout ) {
	$classes[] = 'no-sidebar';
}

// Get category by course id 
$categories = get_the_terms( get_the_ID(), 'k-course-category' );
$start_date = strtotime( $start_date );

?>
	<div class="k2t-content <?php echo implode( ' ', $classes ) ?>">
		<div class="k2t-wrap">
			<main class="k2t-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<div id="main-col" <?php post_class(); ?>>

						<div class="k2t-row">
							<div class="course-entry-meta col-4">
								<div class="k2t-element-hover">
									<?php if(has_post_thumbnail(get_the_ID())):?>
										<div class="course-thumbnail">
											<?php 
												echo get_the_post_thumbnail(get_the_ID(), 'thumb_600x600', array('alt'   => get_the_title()));
											?>
										</div>
									<?php endif;?>
									<div class="entry-meta-inner">
										<?php if ( ! empty( $start_date ) ) : ?>
											<div class="meta-item">
												<label><?php _e( 'START:', 'k2t' );?></label>
												<span><?php echo esc_html( date_i18n( 'F d, Y', $start_date ) );?></span>
											</div>
										<?php endif; ?>

										<?php if ( ! empty( $duration ) ) : ?>
											<div class="meta-item">
												<label><?php _e( 'DURATION:', 'k2t' );?></label>
												<span><?php echo esc_html( $duration );?></span>
											</div>
										<?php endif; ?>

										<?php if( ! empty( $course_id ) ){ ?>
											<div class="meta-item">
												<label><?php _e( 'Course ID:', 'k2t' );?></label>
												<span><?php echo esc_html( $course_id );?></span>
											</div>
										<?php } if( ! empty( $id ) && empty( $course_id ) ): ?>
											<div class="meta-item">
												<label><?php _e( 'ID:', 'k2t' );?></label>
												<span><?php echo esc_html( $id );?></span>
											</div>
										<?php endif; ?>
										<?php 
											$product = (function_exists('get_field')) ? get_field('course_product', get_the_ID()) : ''; $product = empty($product) ? '' : $product;
											$product = isset($product[0]) ? $product[0] : null;
											if ( !empty( $product ) && class_exists( 'WOO' ) ):
										?>
											<div class="meta-item">
												<label><?php _e( 'PRICE:', 'k2t' );?></label>
												<span class="price">
													<?php 
														$product_course = new WC_Product( $product->ID );
														$price_course = $product_course->get_price_html();
														echo ($price_course);
													?>
												</span>
											</div>
										<?php endif; ?>
										
									</div><!--entry-meta-inner-->
								</div>
								<?php if ( ! empty( $download ) ) : ?>
									<div class="course-download">
										<h6><i class="zmdi zmdi-download"></i> <?php _e( 'Download:', 'k2t' );?></h6>
									<?php
										echo '<ul>';
										foreach ( $download as $key => $down ) {
											echo '<li><a target="_blank" href="'. esc_url( $down['course_download_link'] ) .'">'. esc_html( $down['course_download_text'] ) .'</a></li>';
										}
										echo '</ul>';
									?>
									</div>
								<?php endif;?>
							</div>
							<div class="entry-content col-8">

								<!-- Speakers -->
								<?php if ( $who_is_speakers == 'out_school' ) : ?>
									<?php if ( is_array( $speakers ) && count( $speakers ) > 0 ) : ?>
										<div class="entry-speakers">
											<h3 class="h"><i class="zmdi zmdi-mic"></i><span><?php _e( 'Instructors', 'k2t' )?></span></h3>
											<div class="k2t-row">
											<?php foreach ( $speakers as $key => $speaker ) : ?>
												<div class="col-6">
													<!-- Avatar of Speaker -->
													<?php if ( ! empty( $speaker['course_speaker_avatar'] ) ) : ?>
														<div class="speaker-avatar k2t-element-hover">
															<img src="<?php echo esc_url( $speaker['course_speaker_avatar'] )?>" alt="<?php echo esc_attr( $speaker['course_speaker_name'] ); ?>" />
														</div>
													<?php endif;?>

													<!-- Name and Role of Speaker -->
													<?php if ( ! empty( $speaker['course_speaker_name'] ) ) : ?>
													<h4 class="name"><?php echo esc_html( $speaker['course_speaker_name'] ); ?></h4>
													<?php endif;?>
													<?php if ( ! empty( $speaker['course_speaker_role'] ) ) : ?>
													<span class="role"><?php echo esc_html( $speaker['course_speaker_role'] ); ?></span>
													<?php endif;?>
												</div>
											<?php endforeach;?>
											</div>
										</div>
									<?php endif;?>
								<?php elseif ( is_array( $teacher ) && count( $teacher ) > 0 ) : ?>
									<div class="entry-speakers">
										<h3 class="h"><i class="zmdi zmdi-mic"></i><span><?php _e( 'Instructors', 'k2t' )?></span></h3>
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
												<h4 class="name"><?php echo '<a href="'. esc_url( get_permalink( $teach->ID ) ) .'" target="_blank" title="'. esc_attr( get_the_title( $teach->ID ) ) .'">' . esc_html( $teach->post_title ) . '</a>'; ?></h4>
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
									<!-- Address -->
									<?php if ( ! empty( $address ) ) : ?>
										<div class="col-6 course-address">
											<h3 class="h"><i class="zmdi zmdi-pin"></i><span><?php _e( 'Address', 'k2t' )?></span></h3>
											<div><?php echo esc_html( $address ); ?></div>
										</div>
									<?php endif;?>
									<!-- END Address -->

									<!-- Category -->
									<?php if ( count( $categories ) > 0 ) : ?>
										<div class="col-6 course-time">
											<h3 class="h"><span><?php _e( 'Categories', 'k2t' )?></span></h3>
											<?php 
											if (is_array($categories)) {
												foreach ( $categories as $key => $category ) {
													if ( $key == count( $categories ) - 1 ) {
														echo '<a href="'. esc_url( get_term_link( $category->term_id, 'k-course-category' ) ) .'" title="'. esc_attr( $category->name ) .'">'. esc_html( $category->name ) .'</a>';
													} else {
														echo '<a href="'. esc_url( get_term_link( $category->term_id, 'k-course-category' ) ) .'" title="'. esc_attr( $category->name ) .'">'. esc_html( $category->name ) .'</a>, ';
													}
												}
											}
											?>
										</div>
									<?php endif;?>
									<!-- END Time -->
								</div>

								<!-- Course line --><hr/>

								<!-- Description -->
								<div class="course-description">
									<h3 class="h"><i class="zmdi zmdi-dot-circle"></i><span><?php _e( 'Description', 'k2t' )?></span></h3>
									<div class="content">
										<?php the_content();?>
									</div>
								</div>

								<?php if ( function_exists( 'k2t_social_share' ) ) { k2t_social_share(); }?>

		                            <a href="<?php echo esc_url($subscribe_url) ? esc_url($subscribe_url) : get_post_permalink( $product->ID ) ;?>" target="_self" class="course-link btn-ripple k2t-element-hover" ><?php echo !empty( $subscribe_button_text ) ? $subscribe_button_text : __( 'Launch Course', 'k2t' ); ?></a>

								<?php if ( $smof_data['course-related'] ) k_course_include_template( 'course-related.php' ); ?>

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