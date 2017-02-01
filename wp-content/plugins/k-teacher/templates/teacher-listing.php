<?php
wp_enqueue_script( 'isotope-js');
wp_enqueue_script( 'teacher-js');
wp_enqueue_script( 'jquery-imagesloaded' );


$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
$arr = array(
    'post_type' 		=> 'post-k-teacher',
    'posts_per_page' 	=> (int)$teacher_per_page,
    'order'				=> 'DESC',
    'post_status'		=> 'publish',
    'paged'				=> $paged,
    'orderby'			=> 'date',
);
if ( !empty( $params['cat'] ) ) :
    $arr['tax_query'] = array(
                            array(
                                'taxonomy' => 'k-teacher-category',
                                'field'    => 'id',
                                'terms'    => explode(',', $params['cat']),
                            )
                        );
endif;

$query = new WP_Query( $arr );
?>
    <div class="teacher-listing <?php echo ($style=='style-classic') ? 'classic' : 'boxed'; ?> <?php echo esc_html($column);?>">
        <?php

        if( count( $query->posts ) > 0 ):
            while( $query->have_posts() ) : $query->the_post();

                $teacher_position = (function_exists('get_field')) ? get_field('teacher_position', get_the_ID()) : ''; $teacher_position = empty($teacher_position) ? '' : $teacher_position;
                $teacher_facebook = (function_exists('get_field')) ? get_field('teacher_facebook', get_the_ID()) : ''; $teacher_facebook = empty($teacher_facebook) ? '' : $teacher_facebook;
                $teacher_instagram = (function_exists('get_field')) ? get_field('teacher_instagram', get_the_ID()) : ''; $teacher_instagram = empty($teacher_instagram) ? '' : $teacher_instagram;
                $teacher_email = (function_exists('get_field')) ? get_field('teacher_email', get_the_ID()) : ''; $teacher_email = empty($teacher_email) ? '' : $teacher_email;
                $teacher_twitter = (function_exists('get_field')) ? get_field('teacher_twitter', get_the_ID()) : ''; $teacher_twitter = empty($teacher_twitter) ? '' : $teacher_twitter;
                $teacher_linkedin = (function_exists('get_field')) ? get_field('teacher_linkedin', get_the_ID()) : ''; $teacher_linkedin = empty($teacher_linkedin) ? '' : $teacher_linkedin;
                $teacher_tumblr = (function_exists('get_field')) ? get_field('teacher_tumblr', get_the_ID()) : ''; $teacher_tumblr = empty($teacher_tumblr) ? '' : $teacher_tumblr;
                $teacher_google_plus = (function_exists('get_field')) ? get_field('teacher_google_plus', get_the_ID()) : ''; $teacher_google_plus = empty($teacher_google_plus) ? '' : $teacher_google_plus;
                $teacher_pinterest = (function_exists('get_field')) ? get_field('teacher_pinterest', get_the_ID()) : ''; $teacher_pinterest = empty($teacher_pinterest) ? '' : $teacher_pinterest;
                $teacher_youtube = (function_exists('get_field')) ? get_field('teacher_youtube', get_the_ID()) : ''; $teacher_youtube = empty($teacher_youtube) ? '' : $teacher_youtube;
                $teacher_flickr = (function_exists('get_field')) ? get_field('teacher_flickr', get_the_ID()) : ''; $teacher_flickr = empty($teacher_flickr) ? '' : $teacher_flickr;
                $teacher_github = (function_exists('get_field')) ? get_field('teacher_github', get_the_ID()) : ''; $teacher_github = empty($teacher_github) ? '' : $teacher_github;
                $teacher_dribbble = (function_exists('get_field')) ? get_field('teacher_dribbble', get_the_ID()) : ''; $teacher_dribbble = empty($teacher_dribbble) ? '' : $teacher_dribbble;
                $teacher_vk = (function_exists('get_field')) ? get_field('teacher_vk', get_the_ID()) : ''; $teacher_vk = empty($teacher_vk) ? '' : $teacher_vk;


                $thumbnail = (has_post_thumbnail(get_the_ID())) ? true : false;
                //$categories = get_the_terms( get_the_ID(), 'k-teacher-category' );
                $title = get_the_title();
                $content = get_the_content();
                $post_link = get_permalink(get_the_ID());
                $post_thumb_size = 'thumb_500x500';
                $post_thumb = get_the_post_thumbnail(get_the_ID(), $post_thumb_size, array('alt' => trim(get_the_title())));
                $post_thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                ?>
				
                <article class="teacher-classic-item filter-char-<?php echo mb_substr($title, 0, 1)?>">
                    <?php if($style=='style-shadow-box') : ?>
                    <div class="inner k2t-element-hover">
                        <?php endif?>
                        <?php if (!empty($post_thumb)) {
                            echo '<a href="'. esc_url( $post_link ) .'" title="'. esc_attr( $title ) .'">' . $post_thumb . '</a>';
                        } ?>
                        <?php if(!empty($title)) : ?>
                            <h4 class="title">
                                <a href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr($title);?>">
                                    <?php echo esc_html($title);?>
                                </a>
                            </h4>
                        <?php endif; ?>

                        <?php if(!empty($teacher_position)) : ?>
                            <span class="position">
		                		<?php echo esc_html($teacher_position); ?>
		                	</span>
                        <?php endif; ?>
                        <?php
                        if ($excerpt == 'show') {
                            echo '<p class="excerpt">' . wp_trim_words( get_the_excerpt(), $excerpt_length ) . '</p>';
                        }
                        ?>
                        <div class="social">
                            <?php if(!empty($teacher_facebook)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_facebook);?>"><i class='fa fa-facebook'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_instagram)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_instagram);?>"><i class='fa fa-instagram'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_email)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_email);?>"><i class="fa fa-envelope"></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_twitter)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_twitter);?>"><i class='fa fa-twitter'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_linkedin)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_linkedin);?>"><i class='fa fa-linkedin'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_tumblr)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_tumblr);?>"><i class='fa fa-tumblr'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_google_plus)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_google_plus);?>"><i class='fa fa-google-plus'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_pinterest)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_pinterest);?>"><i class='fa fa-pinterest'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_youtube)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_youtube);?>"><i class='fa fa-youtube'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_flickr)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_flickr);?>"><i class='fa fa-flickr'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_github)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_github);?>"><i class='fa fa-github'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_dribbble)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_dribbble);?>"><i class='fa fa-dribbble'></i></a>
                            <?php endif; ?>
                            <?php if(!empty($teacher_vk)) : ?>
                                <a target='_blank' href="<?php echo esc_url($teacher_vk);?>"><i class='fa fa-vk'></i></a>
                            <?php endif; ?>
                        </div>
                        <?php if($style=='style-shadow-box') : ?>
                    </div>
                <?php endif?>
                </article>
            <?php
            endwhile;
        endif; ?>
    </div>