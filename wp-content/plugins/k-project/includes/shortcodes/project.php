<?php
/* ------------------------------------------------------- */
/* project
/* ------------------------------------------------------- */
if (!function_exists('k2t_project_shortcode')){
	function k2t_project_shortcode($atts,$content){
		extract(shortcode_atts(array(
			'title'			=> '',
			'filter_align'  => 'center',
			'categories'	=> '',
			'taxonomy'		=> 'k-project-category',
			'number'		=> '-1',
			'column'		=> '3',
			'padding'		=> 'true',
			'filter'		=> 'true',
			'text_align'	=> 'left',
			'style'			=> 'text-grid',
			'child_style'	=> 'none',

		), $atts));

		$number = empty( $number ) ? -1 : $number;
		$filter_style = 1;
		$arr_term_id = $arr_term = array();
		if ( !empty( $categories ) ){
			$arr_categories = explode( ',', $categories );
			foreach ( $arr_categories as $category_id ){
				$category_id = trim( $category_id );
				if ( !empty( $category_id ) ){
					if ( is_numeric( $category_id ) ){
						$term = get_term_by( 'id', $category_id, $taxonomy );
					}else{
						$term = get_term_by( 'slug', $category_id, $taxonomy );
					}
					if ( $term ){
						$arr_term[] = $term;
						$arr_term_id[] = $term->term_id;
					}	
				}
			}
		}
		
		wp_enqueue_script('jquery-isotope');
		wp_enqueue_script('k2t-owlcarousel');
		wp_enqueue_script('k2t-inview');
		wp_enqueue_script('jquery-imagesloaded');
		wp_enqueue_script('k-project');
		wp_enqueue_script('k2t-stickyMojo');
		wp_enqueue_script('modernizr');
		wp_enqueue_script('expandable');
		wp_enqueue_script('k2t-ajax');
		wp_enqueue_script('magnific-popup');
		wp_enqueue_script( 'cd-dropdown' );
		if ( !in_array( $column, array( '2','3','4','5' ) ) ) $column = 3;
		if ( !in_array( $style, array( 'text-grid', 'text-masonry' ) ) ) $style = 'text-grid';
		$style2 = $style;
		$style = explode( '-', $style );
		if ( $filter_style != '2' ) $filter_style = 1;

		ob_start();
		$project_class = '';
		if ($padding == 'false') {
			$project_class .= ' isotope-no-padding';
		}
		if ( $child_style == 'masonry_free_style' && $style2 == 'text-masonry' ) {
			$project_class .= ' isotope-free';
		}

		?>
	<div class="k2t-project-shortcode filter-style-<?php echo esc_attr( $filter_style );?> text-align-<?php echo esc_attr( $text_align );?>">
		<div class="project-<?php echo esc_attr( $style[0] );?> project-<?php echo esc_attr( $style[1] );?> isotope-fullwidth isotope-<?php echo esc_attr( $column );?>">
		
			<div class="k2t-isotope-wrapper <?php echo esc_attr( $project_class ); ?> isotope-<?php echo esc_attr( $column );?>-columns isotope-<?php echo esc_attr( $style[0] );?> isotope-<?php echo esc_attr($style[1]);?>">
				<div class="k2t-project-heading clearfix">
					<?php 
						if(!function_exists("isMobile")){
							function isMobile() {
							    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
							}
						}
					?>
					<?php if ( !empty( $title ) ) : ?><h2 class="project-title"><?php esc_html_e( $title );?></h2><?php endif;?>

					<?php if(isMobile()) : ?>
						<?php if ( $filter == 'true' ) include( 'project-cat-dropdown.php' );?>
					<?php else: ?>
						<?php if ( $filter == 'true' ) include( 'project-cat.php' );?>
					<?php endif;?>
				</div>
			
				<div class="article-loop k2t-isotope-container">
				
					<div class="gutter-sizer"></div>
		
					<?php 
						$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );	
						$arr = array(
							'post_type' 		=> 'post-k-project',
							'posts_per_page' 	=> (int)$number,
							'order'				=> 'DESC',
							'post_status'		=> 'publish',
							'paged'				=> $paged,
							'orderby'			=> 'date',
						);
						if ( count( $arr_term_id ) > 0 ){
							$arr['tax_query'] = array(
								array(
									'taxonomy' => $taxonomy,
									'field'    => 'id',
									'terms'    => $arr_term_id,
								)
							);
						}
						
						$query = new WP_Query( $arr );
						
						$i = $j = 0;
						if( count( $query->posts ) > 0 ):
							while( $query->have_posts() ) : $query->the_post();
								if ( $child_style == 'masonry_free_style' && $style2 == 'text-masonry' ) {
									include( 'masonry-free.php' );
								} else {
									include( $style[0] . '-' . $style[1] .'.php' );
								}
								if ( $column == 4 && $i == 2 ){
									$j++;
								}
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
		
		</div><!-- .project-grid -->
	</div><!-- .k2t-project-shortcode -->

	<?php //k2t_pagination( $query );?>
		
		<?php
		$return = ob_get_clean();
		wp_reset_postdata();
		$return = apply_filters( 'k2t_project_return', $return );
		return $return;

	}
}
add_shortcode('k2t-project','k2t_project_shortcode');

?>