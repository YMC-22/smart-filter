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

	// Layout: Vertical Timeline
    while ($query->have_posts()) : $query->the_post();

        $post_id = get_the_ID();
        $title   = get_the_title($post_id);
        $link    = get_the_permalink($post_id);
	    $length_excerpt = !empty($ymc_post_elements['length_excerpt']) ? esc_attr($ymc_post_elements['length_excerpt']) : 30;
	    $button_text = !empty($ymc_post_elements['button_text']) ? $ymc_post_elements['button_text'] : 'Read More';
	    $class_popup = ( $ymc_popup_status === 'off' ) ? '' : 'ymc-popup';
        $post_date_format = apply_filters('ymc_post_date_format_'.$filter_id.'_'.$target_id, 'F Y');
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

	    $list_categories = '';

	    if( is_array($taxonomy) && count($taxonomy) > 0 ) {

		    foreach ( $taxonomy as $tax ) {

			    $term_list = get_the_terms($post_id, $tax);

			    if( $term_list ) {
				    foreach($term_list as $term_single) {
					    $list_categories .= '<span class="cat-inner">'. esc_html($term_single->name) .'</span>';
				    }
			    }
		    }
	    }

        echo '<article class="ymc-'.esc_attr($post_layout).' post-'.get_the_id().' post-item '.esc_attr($class_animation).'">';

        echo '<div class="col col-1">';
	    echo '<div class="col-inner"><span class="date">'. esc_html(get_the_date($post_date_format)) .'</span></div>';
        echo '</div>';
	    echo '<div class="col col-2">';
	    echo '<div class="col-inner">';

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

	    if( $ymc_post_elements['author'] === 'show' ) :
		    echo '<span class="author"><i class="far fa-user"></i> '. get_the_author() . '</span>';
	    endif;

	    if( $ymc_post_elements['excerpt'] === 'show' ) :
	    echo '<div class="excerpt">'. wp_kses_post($content) .'</div>';
		endif;

	    if( $ymc_post_elements['button'] === 'show' ) :
	    echo '<div class="read-more"><a class="btn btn-read-more '.esc_attr($class_popup).'" '. esc_attr($target) .' data-postid="'.esc_attr($post_id).'" href="'. esc_url($link) .'">'. esc_html($read_more) .'</a></div>';
		endif;

		echo '</div>';
	    echo '</div>';

		echo '</article>';

    endwhile;


