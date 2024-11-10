<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

	// Layout: Grid Layout 2
    while ($query->have_posts()) : $query->the_post();

        // Get data
        $post_id = get_the_ID();
        $title   = get_the_title($post_id);
        $link    = get_the_permalink($post_id);
	    $length_excerpt = !empty($ymc_post_elements['length_excerpt']) ? esc_attr($ymc_post_elements['length_excerpt']) : 30;
	    $button_text = !empty($ymc_post_elements['button_text']) ? $ymc_post_elements['button_text'] : 'Read More';
	    $class_popup = ( $ymc_popup_status === 'off' ) ? '' : 'ymc-popup';
        $post_date_format = apply_filters('ymc_post_date_format_'.$filter_id.'_'.$target_id, 'd, M Y');

	    if( has_excerpt($post_id) ) {
		    $content = get_the_excerpt($post_id);
	    } else {
		    $content = apply_filters( 'the_content', get_the_content($post_id) );
	    }

        $content  = preg_replace('#\[[^\]]+\]#', '', $content);
	    $c_length = apply_filters('ymc_post_excerpt_length_'.$filter_id.'_'.$target_id, $length_excerpt);

	    switch ($ymc_excerpt_truncate_method) :
		    case 'excerpt_truncated_text' :
			    $content  = wp_trim_words($content, $c_length);
			    break;
		    case 'excerpt_first_block' :
			    preg_match_all("/(<p>|<h1>|<h2>|<h3>|<h4>|<h5>|<h6>)(.*)(<\/p>|<\/h1>|<\/h2>|<\/h3>|<\/h4>|<\/h5>|<\/h6>)/U", $content, $matches);
			    $content = strip_tags($matches[0][0]);
			    $c_length = strlen($content);
			    $content  = wp_trim_words($content, $c_length);
			    break;
		    case 'excerpt_line_break' :
			    preg_match('/>([^<]+).*(?:$|<br)/m', $content, $matches);
			    $content = $matches[1];
			    break;
	    endswitch;

        $read_more = apply_filters('ymc_post_read_more_'.$filter_id.'_'.$target_id, __($button_text,'ymc-smart-filter'));
        $target = "target=" . $ymc_link_target . "";

        echo '<article class="ymc-'.esc_attr($post_layout).' post-'.get_the_id().' post-item '.esc_attr($class_animation).'">';

	    if( $ymc_post_elements['title'] === 'show' ) :
		    echo '<header class="title">';
		    echo '<a class="media-link '.esc_attr($class_popup).'" data-postid="'.esc_attr($post_id).'" '. esc_attr($target) .' href="'. esc_url($link) .'">';
		    echo  esc_html($title);
		    echo '</a>';
		    echo '</header>';
		endif;

	    if( $ymc_post_elements['excerpt'] === 'show' ) :
        echo '<div class="excerpt">'. wp_kses_post($content) .'</div>';
		endif;

	    if( $ymc_post_elements['button'] === 'show' ) :
        echo '<div class="read-more"><a class="btn btn-read-more '.esc_attr($class_popup).'" '. esc_attr($target) .' data-postid="'.esc_attr($post_id).'" href="'. esc_url($link) .'">'. esc_html($read_more) .'</a></div>';
	    endif;

		echo '</article>';

    endwhile;


