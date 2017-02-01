<?php
/* ------------------------------------------------------- */
/* Portfolio
/* ------------------------------------------------------- */
if ( ! function_exists( 'k2t_gallery_shortcode' ) ) {
	function k2t_gallery_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title'			=>	'',
			'categories'	=>  '',
			'number'		=>	'-1',
			'column'		=> 	'5',
			'filter'		=>	'true',
			'filter_style'  =>	'dropdown',
			'text_align'	=>	'left',
		), $atts ) );
		// Enqueue script
		wp_enqueue_script( 'jquery-isotope' );
		wp_enqueue_script( 'jquery-imagesloaded' );
		wp_enqueue_script( 'cd-dropdown' );
		wp_enqueue_script( 'magnific-popup' );
		wp_enqueue_script( 'k2t-portfolio' );
		wp_enqueue_script( 'k2t-ajax' );
		wp_enqueue_script( 'modernizr' );

		$number = empty( $number ) ? -1 : $number;
		$arr_term_id = $arr_term = array();
		if ( !empty( $categories ) ){
			$arr_categories = explode( ',', $categories );
			foreach ( $arr_categories as $category_id ){
				$category_id = trim( $category_id );
				if ( !empty( $category_id ) ){
					if ( is_numeric( $category_id ) ){
						$term = get_term_by( 'id', $category_id, 'gallery-category' );
					}else{
						$term = get_term_by( 'slug', $category_id, 'gallery-category' );
					}
					if ( $term ){
						$arr_term[] = $term;
						$arr_term_id[] = $term->term_id;
					}	
				}
			}
		}
		
		
		if ( !in_array( $column, array( '2','3','4','5', '6' ) ) ) $column = 3;

		ob_start();
		$portfolio_class = '';
		

		?>
	<div class="k2t-gallery-shortcode filter-style-<?php echo esc_attr( $filter_style );?> text-align-<?php echo esc_attr( $text_align );?>">
		<div class=" portfolio-grid isotope-fullwidth isotope-<?php echo esc_attr( $column );?> pf-<?php echo esc_attr( $column );?>col">
		
			<div class="k2t-isotope-wrapper <?php echo esc_attr( $portfolio_class ); ?> isotope-<?php echo esc_attr( $column );?>-columns isotope-gallery isotope-grid">
				<?php 
					if(!function_exists("isMobile")){
						function isMobile() {
						    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
						}
					}
				?>
				<?php if ( !empty( $title ) || $filter == 'true' ): ?>
					<div class="container">
						<div class="k2t-gallery-heading">
							<?php if ( !empty( $title ) ) : ?><h2 class="gallery-title"><?php esc_html_e( $title );?></h2><?php endif;?>

							<?php if(isMobile()) : ?>
								<?php if ( $filter == 'true' ) include( 'gallery-cat.php' );?>
							<?php else: ?>
								<?php if($filter_style=='dropdown') : ?>
									<?php if ( $filter == 'true' ) include( 'gallery-cat.php' );?>
								<?php endif;?>
								<?php if($filter_style=='list') : ?>
									<?php if ( $filter == 'true' ) include( 'gallery-cat-list.php' );?>
								<?php endif;?>
							<?php endif;?>
						</div>
					</div>
				<?php endif;?>
			
				<div class="article-loop k2t-isotope-container">
					<div class="gutter-sizer"></div>
					<?php 
						// Get data from database
						$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );	
						$arr = array(
							'post_type' 		=> 'post-gallery',
							'posts_per_page' 	=> (int)$number,
							'order'				=> 'DESC',
							'post_status'		=> 'publish',
							'paged'				=> $paged,
							'orderby'			=> 'date',
						);
						if ( count( $arr_term_id ) > 0 ){
							$arr['tax_query'] = array(
								array(
									'taxonomy' => 'gallery-category',
									'field'    => 'term_id',
									'terms'    => $arr_term_id,
								)
							);
						}
						
						$query = new WP_Query( $arr );
						$i = $j = 0;
						if( count( $query->posts ) > 0 ):
							while( $query->have_posts() ) : $query->the_post();
								include( 'gallery-grid.php' );
								$i++;
							endwhile;
						endif;
					?>

					<div class="bubblingG">
						<span id="bubblingG_1"></span>
						<span id="bubblingG_2"></span>
						<span id="bubblingG_3"></span>
					</div>
				</div><!-- .article-loop -->
			</div><!-- .k2t-isotope-wrapper -->
		</div><!-- .portfolio-grid -->
	</div><!-- .k2t-gallery-shortcode -->
		
	<?php
		$return = ob_get_clean();
		wp_reset_postdata();
		$return = apply_filters( 'k2t_gallery_return', $return );
		return $return;
	}
}
add_shortcode( 'k2t-gallery', 'k2t_gallery_shortcode' );
?>