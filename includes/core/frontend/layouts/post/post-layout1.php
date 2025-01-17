<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	// Layout: Grid Layout 1
    while ($query->have_posts()) : $query->the_post();

        // Get data
	    $post_id = get_the_ID();
	    $title   = get_the_title($post_id);
	    $link    = ( $ymc_popup_status === 'off' ) ? get_the_permalink($post_id) : '#';
	    $length_excerpt = !empty($ymc_post_elements['length_excerpt']) ? esc_attr($ymc_post_elements['length_excerpt']) : 30;
		$button_text = !empty($ymc_post_elements['button_text']) ? $ymc_post_elements['button_text'] : __('Read More', 'ymc-smart-filter');
		$class_popup = ( $ymc_popup_status === 'off' ) ? '' : 'ymc-popup';
	    $post_date_format = apply_filters('ymc_post_date_format_'.$filter_id.'_'.$target_id, 'd, M Y');
		$image_post = null;

	    if( has_post_thumbnail($post_id) ) {

			switch ($ymc_post_image_size) {
				case 'full': $image_post = get_the_post_thumbnail($post_id, 'full'); break;
				case 'medium': $image_post = get_the_post_thumbnail($post_id, 'medium'); break;
				case 'thumbnail': $image_post = get_the_post_thumbnail($post_id, 'thumbnail'); break;
				case 'large': $image_post = get_the_post_thumbnail($post_id, 'large'); break;
			}
        }

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
				$content  = wp_strip_all_tags($matches[0][0]);
				$c_length = strlen($content);
				$content  = wp_trim_words($content, $c_length);
				break;
			case 'excerpt_line_break' :
				preg_match('/>([^<]+).*(?:$|<br)/m', $content, $matches);
				$content = $matches[1];
				break;
		endswitch;

	    $read_more = apply_filters('ymc_post_read_more_'.$filter_id.'_'.$target_id, $button_text);
	    $target = "target=" . $ymc_link_target . "";

	    $list_categories = '';

	    if( is_array($taxonomy) && count($taxonomy) > 0 ) {

		    foreach ( $taxonomy as $tax ) {

			    $term_list = get_the_terms($post_id, $tax);

			    if($term_list && ! is_wp_error($term_list)) {
				    foreach($term_list as $term_single) {
					    $list_categories .= '<span class="cat-inner '.esc_attr($term_single->slug).'">'. esc_html($term_single->name) .'</span>';
				    }
			    }
		    }
	    }

        echo '<article class="ymc-'.esc_attr($post_layout).' post-'.esc_attr($post_id).' post-item '.esc_attr($class_animation).'">';

	    if( !empty($image_post) && $ymc_post_elements['image'] === 'show' ) :
		echo '<figure class="media">'. wp_kses_post($image_post);
			if( $ymc_image_clickable === 'on' ) :
			echo '<a class="media-link '.esc_attr($class_popup).'" data-postid="'.esc_attr($post_id).'" '. esc_attr($target) .' href="'. esc_url($link) .'"></a>';
			endif;
		echo '</figure>';
		endif;

		if( !empty($list_categories) && $ymc_post_elements['tag'] === 'show' ) :
		echo '<div class="category">'. wp_kses_post($list_categories) .'</div>';
		endif;

	    if( $ymc_post_elements['title'] === 'show' ) :
        echo '<header class="title">';
		echo '<a class="media-link '.esc_attr($class_popup).'" data-postid="'.esc_attr($post_id).'" '. esc_attr($target) .' href="'. esc_url($link) .'">';
        echo  esc_html($title);
		echo '</a>';
        echo '</header>';
	    endif;

	    if( $ymc_post_elements['date'] === 'show' ) :
        echo '<span class="date"><i class="far fa-calendar-alt"></i> '. get_the_date($post_date_format) . '</span>';
	    endif;

	    if( $ymc_post_elements['author'] === 'show' ) :
        echo '<span class="author"><i class="far fa-user"></i> '. get_the_author() . '</span>';
	    endif;

	    if( $ymc_post_elements['excerpt'] === 'show' ) :
        echo '<div class="excerpt">'. wp_kses_post($content) .'</div>';
	    endif;

	    if( $ymc_post_elements['button'] === 'show' ) :
        echo '<div class="read-more"><a class="btn btn-read-more '.esc_attr($class_popup).'" data-postid="'.esc_attr($post_id).'" '. esc_attr($target) .' href="'. esc_url($link) .'">'. esc_html($read_more) .'</a></div>';
	    endif;

		echo '</article>';

    endwhile;



