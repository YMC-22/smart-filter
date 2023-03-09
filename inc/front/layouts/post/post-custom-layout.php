<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Custom Post Layout

$layouts = '';
$arrOptions = [];
$increment_post = ( $paged === 1 ) ? 1 : ($per_page * ( $paged - 1)) + 1;
$arrOptions['paged'] = $paged;
$arrOptions['per_page'] = $per_page;
$arrOptions['total'] = $query->found_posts;


while ($query->have_posts()) : $query->the_post();

	do_action( "ymc_before_custom_layout_".$filter_id.'_'.$target_id, $increment_post, $arrOptions );

	echo '<article class="ymc-'.esc_attr($post_layout).' post-'.get_the_id().' post-item '.esc_attr($css_special).'">';

	$layouts .= '<header class="head-post">'.esc_html__('Add your custom post layout.','ymc-smart-filter').'</header>';
	$layouts .= '<div class="inform">'.esc_html__('Use a filter:','ymc-smart-filter').' 
                 <span class="doc-text">ymc_post_custom_layout_'.$filter_id.'_ID</span> 
                 '.esc_html__('to override post template.','ymc-smart-filter').' <br>'.esc_html__('Example:','ymc-smart-filter').'
                 <span class="doc-text">add_filter("ymc_post_custom_layout_'.$filter_id.'_ID", "func_custom_layout", 10, 5);</span>
                 <a target="_blank" href="https://github.com/YMC-22/smart-filter">'.esc_html__('See documentation.','ymc-smart-filter').'</a>
                 </div>';


	echo apply_filters('ymc_post_custom_layout_'.$filter_id.'_'.$target_id, $layouts, get_the_ID(), $filter_id, $increment_post, $arrOptions );

	$layouts = null;

	echo '</article>';

	do_action( "ymc_after_custom_layout_".$filter_id.'_'.$target_id, $increment_post, $arrOptions );

	$increment_post++;

endwhile;




