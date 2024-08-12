<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Custom Post Layout
$arrOptions['total'] = $query->found_posts;
$arrOptions['class_popup'] = ( $ymc_popup_status === 'off' ) ? '' : 'ymc-popup';
$arrOptions['terms_settings'] = arrayToObject( generalArrayMerging( $ymc_terms_options, $ymc_terms_align ) );

?>

<div class="carousel-container swiper swiper-<?php echo esc_attr($filter_id ); ?> swiper-<?php echo esc_attr($filter_id ).'-'. esc_attr($target_id); ?>">

	<div class="swiper-wrapper">

	<?php

	// Loop posts
	while ( $query->have_posts() ) :

		$query->the_post();

		global $post;

		// Get post data
		$post_id          = get_the_ID();
		$all_terms        = '';
		$layout           = '';
		$title            = get_the_title($post_id);
		$link             = ( $ymc_popup_status === 'off' ) ? get_the_permalink($post_id) : '#';
		$length_excerpt   = !empty($ymc_post_elements['length_excerpt']) ? esc_attr($ymc_post_elements['length_excerpt']) : 30;
		$button_text      = !empty($ymc_post_elements['button_text']) ? $ymc_post_elements['button_text'] : 'Read More';
		$class_popup      = ( $ymc_popup_status === 'off' ) ? '' : 'ymc-popup';
		$post_date_format = apply_filters('ymc_post_date_format_'.$filter_id.'_'.$target_id, 'd, M Y');
		$image_post       = ( has_post_thumbnail($post_id) ) ? get_the_post_thumbnail($post_id, 'full') :
				            '<img src="'. YMC_SMART_FILTER_URL .'includes/assets/images/dummy-Image.svg">';
		$c_length         = apply_filters('ymc_post_excerpt_length_'.$filter_id.'_'.$target_id, $length_excerpt);

		$content          = ( empty($post->post_excerpt) ) ? $post->post_content : $post->post_excerpt;
		$content          = preg_replace('#\[[^\]]+\]#', '', $content);
		$content          = wp_trim_words($content, $c_length);

		$read_more        = apply_filters('ymc_post_read_more_'.$filter_id.'_'.$target_id, __($button_text,'ymc-smart-filter'));
		$target           = "target=" . $ymc_link_target . "";

		if( is_array($taxonomy) && count($taxonomy) > 0 ) {

			foreach ( $taxonomy as $tax ) {

				$terms_list = get_the_terms($post_id, $tax);

				if( is_array($terms_list ) && count($terms_list) > 0 ) {

					foreach($terms_list as $term) {

						$all_terms .= '<span class="category__item">'. esc_html($term->name) .'</span>';
					}
				}
			}
		}

		// Display Post
		echo '<div class="swiper-slide">';

		echo '<article class="'.esc_attr($post_layout).' post-'.$post_id.' post-item">';

		$layout .= '<div class="row">';

			$layout .= '<div class="col col-image">';

			if( $ymc_post_elements['image'] === 'show' ) :
				$layout .= '<div class="image">'. wp_kses_post($image_post) .'</div>';
			endif;

			$layout .= '</div>';

			$layout .= '<div class="col col-text">';

				if( $ymc_post_elements['title'] === 'show' ) :
					$layout .= '<header class="title">'. esc_html($title) .'</header>';
				endif;

				if( !empty($all_terms) && $ymc_post_elements['tag'] === 'show' ) :
					$layout .= '<div class="category">'. wp_kses_post($all_terms) .'</div>';
				endif;

				$layout .= '<div class="date_author">';

				if( $ymc_post_elements['date'] === 'show' ) :
					$layout .= '<span class="date_author__item"><i class="far fa-calendar-alt"></i> '. get_the_date($post_date_format) . '</span>';
				endif;

				if( $ymc_post_elements['author'] === 'show' ) :
					$layout .= '<span class="date_author__item"><i class="far fa-user"></i> '. get_the_author() . '</span>';
				endif;

				$layout .= '</div>';

				if( $ymc_post_elements['excerpt'] === 'show' ) :
					$layout .= '<div class="excerpt">'. wp_kses_post($content) .'</div>';
				endif;

				if( $ymc_post_elements['button'] === 'show' ) :
					$layout .= '<div class="btn-read"><a class="btn-read__link '.esc_attr($class_popup).'" data-postid="'.esc_attr($post_id).'" '. esc_attr($target) .' href="'. esc_url($link) .'">'. esc_html($read_more) .'</a></div>';
				endif;

			$layout .= '</div>'; // end row


		$layout .= '</div>';

		// Custom layout
		echo apply_filters('ymc_post_carousel_custom_layout_'.esc_attr($filter_id).'_'.esc_attr($target_id),
			$layout,
			$post_id,
			$filter_id,
			$arrOptions
		);

		echo '</article>';

		echo '</div>';

	endwhile;

	?>

	</div>

	<!-- pagination -->
	<div class="swiper-pagination"></div>

	<!-- navigation buttons -->
	<div class="swiper-button-prev"></div>
	<div class="swiper-button-next"></div>

	<!-- scrollbar -->
	<div class="swiper-scrollbar"></div>

</div>










