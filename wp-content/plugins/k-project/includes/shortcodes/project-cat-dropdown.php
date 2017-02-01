<?php 
    if ( count( $arr_term ) > 0 ){
        $categories = $arr_term;
    ?>
        <select id="cd-dropdown" class="cd-select k2t-isotope-filter">
            <option value="-1" selected><?php _e( 'Sort Project', 'k2t' );?></option>
            <option value="*" class="*"><?php _e( 'All', 'k2t' );?></option>
            <?php foreach($categories as $category): ?>
            <option value=".k2t-cat-<?php echo $category->slug; ?>" class=".k2t-cat-<?php echo $category->slug; ?>"><?php echo $category->name; ?></a></option>
            <?php endforeach;?>
        </select> 
    <?php
    }else{
        $categories = get_categories(array('taxonomy' => 'k-project-category'));
        if( count( $categories ) > 0 ):
    ?>
        <select id="cd-dropdown" class="cd-select k2t-isotope-filter">
            <option value="-1" selected><?php _e( 'Sort Project', 'k2t' );?></option>
            <option value="*" class="*"><?php _e( 'All', 'k2t' );?></option>
            <?php foreach($categories as $category):?>
            <option value=".k2t-cat-<?php echo $category->slug; ?>" class=".k2t-cat-<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
            <?php endforeach;?>
        </select>
    <?php endif; ?>
<?php }?>