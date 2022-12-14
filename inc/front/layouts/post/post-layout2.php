<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

    while ($query->have_posts()) : $query->the_post();

        global $post;

        // Get data
        $post_id = get_the_ID();
        $title   = wp_trim_words(get_the_title($post_id), 15, '...');
        $link    = get_the_permalink($post_id);
        $post_date_format = apply_filters('ymc_post_date_format_'.$target_id, 'd, M Y');

        $content = $post->post_excerpt;
        if( empty($content) ) {
            $content = $post->post_content;
        }

        $content  = preg_replace('#\[[^\]]+\]#', '', $content);
        $c_length = apply_filters('ymc_post_excerpt_length_'.$target_id, 30);
        $content  = wp_trim_words($content, $c_length);

        $read_more = apply_filters('ymc_post_read_more_'.$target_id, __('Read More','ymc-smart-filter'));
        $target = "target='" . $ymc_link_target . "'";

        $term_list = get_the_terms($post_id, $taxonomy);
        $list_categories = '';
        foreach($term_list as $term_single) {
            $list_categories .= '<span class="cat-inner">'. esc_html($term_single->name) .'</span>';
        }
        $css_special =  !empty($ymc_special_post_class) ? $ymc_special_post_class : '';


        echo '<article class="ymc-'.esc_attr($post_layout).' post-'.get_the_id().' post-item '.esc_attr($css_special).'">';
        echo '<div class="category">'. wp_kses_post($list_categories) .'</div>';
        echo '<header class="title">'. esc_html($title) .'</header>';
        echo '<div class="date"><i class="far fa-calendar-alt"></i> '. get_the_date($post_date_format) . '</div>';
        echo '<div class="excerpt">'. wp_kses_post($content) .'</div>';
        echo '<div class="read-more"><a class="btn btn-read-more" '. esc_attr($target) .' href="'. esc_url($link) .'">'. esc_html($read_more) .'</a></div>';
        echo '</article>';

    endwhile;

?>


