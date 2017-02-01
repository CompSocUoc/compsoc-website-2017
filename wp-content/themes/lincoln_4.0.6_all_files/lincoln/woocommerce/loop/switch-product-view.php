<?php
global $smof_data;
?>
<div class="pageview pull-right col-xs-12 col-sm-3">
    <?php _e('View as: ', 'k2t');
    if (!isset($_COOKIE['product-view'])): ?>
        <span data-view="grid" class="pageviewitem <?php echo ($smof_data['product-view'] == 'grid') ? esc_attr('active') : '';?>">
                <i class="fa fa-th"></i>
            </span>
        <span data-view="list" class="pageviewitem  <?php echo ($smof_data['product-view'] == 'list') ? esc_attr('active') : '';?>">
                <i class="fa fa-list"></i>
            </span>
    <?php else: ?>
        <span data-view="grid" class="pageviewitem <?php echo ($_COOKIE['product-view'] == 'grid') ? esc_attr('active') : '';?>">
                <i class="fa fa-th"></i>
            </span>
        <span data-view="list" class="pageviewitem  <?php echo ($_COOKIE['product-view'] != 'grid') ? esc_attr('active') : '';?>">
                <i class="fa fa-list"></i>
            </span>
    <?php endif; ?>
</div>