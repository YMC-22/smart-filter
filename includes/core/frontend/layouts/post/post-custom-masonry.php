<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Masonry Custom Post Layout

$layouts = '';
$arrOptions = [];
$increment_post = ( $paged === 1 ) ? 1 : ($per_page * ( $paged - 1)) + 1;
$arrOptions['paged'] = $paged;
$arrOptions['per_page'] = $per_page;
$arrOptions['total'] = $query->found_posts;
$arrOptions['class_popup'] = ( $ymc_popup_status === 'off' ) ? '' : 'ymc-popup';
$arrOptions['terms_settings'] = arrayToObject( generalArrayMerging( $ymc_terms_options, $ymc_terms_align ) );


while ($query->have_posts()) : $query->the_post();

	do_action( "ymc_before_custom_layout_".$filter_id.'_'.$target_id, $increment_post, $arrOptions );

	echo '<article class="ymc-'.esc_attr($post_layout).' post-'.get_the_id().' post-item fade-in">';

	$layouts .= '<header class="head-post">'.esc_html__('Add Custom Masonry Layout.','ymc-smart-filter').'</header>';
	$layouts .= '<div class="inform">'.esc_html__('Use a filter:','ymc-smart-filter').' 
                 <span class="doc-text">ymc_post_custom_layout_'.$filter_id.'_'.$target_id.'</span> 
                 '.esc_html__('to override post template.','ymc-smart-filter').' <br>'.esc_html__('Example:','ymc-smart-filter').'
                 <span class="doc-text">add_filter("ymc_post_custom_layout_'.$filter_id.'_'.$target_id.'", "callback_function", 10, 5);</span>
                 <a target="_blank" href="https://github.com/YMC-22/smart-filter">'.esc_html__('See documentation.','ymc-smart-filter').'</a>
                 </div>';



	/**
	 * Creating a custom post template
	 * @param {string} layout - HTML markup
	 * @param {int} post_id - Post ID
	 * @param {int} filter_id - Filter ID
	 * @param {int} increment_post - post counter
	 * @param {array} arrOptions - array of additional post parameters. It includes:
	- arrOptions['paged'] - page number
	- arrOptions['per_page'] - number of posts per page
	- arrOptions['total'] - number of all posts
	- arrOptions['class_popup'] - string class btn popup
	- arrOptions['terms_settings'] - (array) array terms settings. Default empty array. List of object properties:
	- termid - ID term
	- bg - background term. Hex Color Codes (ex: #dd3333)
	- color - color term. Hex Color Codes (ex: #dd3333)
	- class - custom name class of the term
	- status - checked term
	- alignterm - align icon in term
	- coloricon - color icon
	- classicon - name class icon (Font Awesome Icons. ex. far fa-arrow-alt-circle-down)
	- status - term status (checked)
	- default - (string) default term (checked)
	- name - (string) custom term name
	 * @returns {string} HTML markup card post
	 */

	echo apply_filters('ymc_post_custom_layout_'.$filter_id.'_'.$target_id,
		$layouts,
		get_the_ID(),
		$filter_id,
		$increment_post,
		$arrOptions
	);

	$layouts = null;

	echo '</article>';

	do_action( "ymc_after_custom_layout_".$filter_id.'_'.$target_id, $increment_post, $arrOptions );

	$increment_post++;

endwhile;

