<div class="k2t-wrapper-teacher-filter">
    <ul class="k2t-teacher-filter">
            <li class="active" data-id="all"><span><?php _e('All', 'k2t') ?></span></li>
            <?php  foreach($list as $char){ ?>
                <li data-id="<?php echo esc_attr($char)?>"><span><?php echo esc_html($char)?></span></li>
            <?php } ?>
    </ul>
</div>