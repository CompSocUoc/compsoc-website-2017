<?php 
    if ( count( $arr_term ) > 0 ){
        $categories = $arr_term;
    ?>
        <div class="k2t-page-top-menu">
            <div class="k2t-cats k2t-isotope-filter k2t-cats-filter k2t-page-topnav <?php echo esc_attr( $filter_align );?>">
                <ul class="menu">
                    <li class="active"><a href="#" data-filter="*"><span><?php _e('All', 'k2t');?></span></a></li>
                    <?php foreach($categories as $category): ?>
                        <li><a href="#" data-filter=".k2t-cat-<?php echo $category->slug; ?>"><span><?php echo $category->name; ?></span></a></li>
                    <?php endforeach;?>
                </ul>  
            </div><!-- .k2t-cats -->
        </div><!-- .k2t-page-top-menu -->   
    <?php
    }else{
        $categories = get_categories(array('taxonomy' => 'k-project-category'));
    	if( count( $categories ) > 0 ):
    ?>
    	<div class="k2t-page-top-menu">
    		<div class="k2t-cats k2t-isotope-filter k2t-cats-filter k2t-page-topnav <?php echo esc_attr( $filter_align );?>">
				<ul class="menu">
                    <li class="active"><a href="#" data-filter="*"><span><?php _e('All', 'k2t');?></span></a></li>
					<?php foreach($categories as $category):  if($category->category_parent == 0):?>
                        <li><a href="#" data-filter=".k2t-cat-<?php echo $category->slug; ?>"><span><?php echo $category->name; ?></span></a>
                        <?php $child_categories = get_categories('taxonomy=k-project-category&child_of='.$category->term_id);?>
                        <?php if(count($child_categories) > 0):?>
                            <ul>
                                <?php foreach($child_categories as $category):?>
                                	<li><a href="#" data-filter=".k2t-cat-<?php echo $category->slug; ?>"><span><?php echo $category->name; ?></span></a>
                                <?php endforeach;?>
                            </ul>
                        <?php endif;?>
                        </li>
                    <?php endif; endforeach;?>
				</ul>
    		</div><!-- .k2t-cats -->
    	</div><!-- .k2t-page-top-menu -->	
    <?php endif; ?>
<?php }?>