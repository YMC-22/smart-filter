<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

	$html_timeline_track = '<div class="timeline-track"><div class="thumb"></div></div>';

	if ( $paged === 1 && ( $type_pagination === 'load-more' || $type_pagination === 'scroll-infinity') )
	{
		echo $html_timeline_track;
	}
	if ( $type_pagination === 'numeric' )
	{
		echo $html_timeline_track;
	}


    while ($query->have_posts()) : $query->the_post();

        global $post;

        $post_id = get_the_ID();
        $title   = get_the_title($post_id);
        $link    = get_the_permalink($post_id);
	    $class_popup = ( $ymc_popup_status === 'off' ) ? '' : 'ymc-popup';
        $post_date_format = apply_filters('ymc_post_date_format_'.$filter_id.'_'.$target_id, 'F Y');
	    $image_post = null;

	    if( has_post_thumbnail($post_id) ) {
		    $image_post = get_the_post_thumbnail($post_id, 'full');
	    }

	    $content = ! empty( $post->post_excerpt ) ? $post->post_excerpt : $post->post_content;

        $content  = preg_replace('#\[[^\]]+\]#', '', $content);
        $c_length = apply_filters('ymc_post_excerpt_length_'.$filter_id.'_'.$target_id, 30);
        $content  = wp_trim_words($content, $c_length);

        $read_more = apply_filters('ymc_post_read_more_'.$filter_id.'_'.$target_id, __('Read More','ymc-smart-filter'));
        $target = "target=" . $ymc_link_target . "";

        echo '<article class="ymc-'.esc_attr($post_layout).' post-'.get_the_id().' post-item '.esc_attr($class_animation).'">';

        echo '<div class="col col-1">';
	    echo '<div class="col-inner"><span class="date">'. esc_html(get_the_date($post_date_format)) .'</span></div>';
        echo '</div>';
	    echo '<div class="col col-2">';
	    echo '<div class="col-inner">';
		if( !empty($image_post) ) :
	    echo '<figure class="media">'. wp_kses_post($image_post) .'</figure>';
		endif;
	    echo '<header class="title">'. esc_html($title) .'</header>';
	    echo '<div class="excerpt">'. wp_kses_post($content) .'</div>';
	    echo '<div class="read-more"><a class="btn btn-read-more '.esc_attr($class_popup).'" '. esc_attr($target) .' data-postid="'.esc_attr($post_id).'" href="'. esc_url($link) .'">'. esc_html($read_more) .'</a></div>';
	    echo '</div>';
	    echo '</div>';

		echo '</article>';

    endwhile;


