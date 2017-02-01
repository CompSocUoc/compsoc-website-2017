<?php
if( !function_exists('k_teacher_filter_bar_shortcode') ) {
    function k_teacher_filter_bar_shortcode($atts)
    {
        $attr = shortcode_atts( array(
            'list' => '',
        ), $atts );

        if($attr['list'] == ''){
            $attr['list'] = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
			$attr_split = explode(',', $attr['list']);
        }

        return k2t_get_template_part('teacher', 'filter-bar', array('list' => $attr_split ));

    }

    add_shortcode('k_teacher_filter_bar', 'k_teacher_filter_bar_shortcode');
}