<?php 
	if ( count( $arr_term ) > 0 ){
		$categories = $arr_term;
	?>
		
	<?php
	}else{
		$categories = get_categories(array('taxonomy' => 'gallery-category'));
		if( count( $categories ) > 0 ):
	?>
		<ul class="k2t-isotope-filter filter-list">
			<li class="*"><?php _e( 'All', 'k2t' );?></li>
			<?php foreach($categories as $category):?>
			<li class=".k2t-cat-<?php echo $category->slug; ?>">
				<?php echo $category->name; ?></li>
			<?php endforeach;?>
		</ul>
	<?php endif; ?>
<?php }?>