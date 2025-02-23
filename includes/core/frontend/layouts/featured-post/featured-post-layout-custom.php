<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$arrOptions = [];
$arrOptions['class_popup'] = ( $ymc_popup_status === 'off' ) ? '' : 'ymc-popup';
$arrOptions['terms_settings'] = arrayToObject( generalArrayMerging($ymc_terms_options, $ymc_terms_align ));
$args = [
	'post_type' => explode(',',$ymc_cpt_value),
	'post__in' => $ymc_featured_posts,
	'orderby' => 'post__in',
	'posts_per_page' => -1
];

$query = new \WP_query($args);

if ( $query->have_posts() ) : ?>

	<div class="featured-posts">

		<div class="featured-posts__wrapper location_<?php echo esc_attr($ymc_location_featured_posts); ?>">

	        <?php while ($query->have_posts()) : $query->the_post();

		        $layout = '';

		        echo '<article class="ymc-'.esc_attr($ymc_featured_post_layout).' post-'.esc_attr(get_the_id()).' post-item '.esc_attr($ymc_post_animation).'">';

		        $layout .= '<header class="head-post">'.esc_html__('Add Custom Featured Layout.','ymc-smart-filter').'</header>';
		        $layout .= '<div class="inform">'.esc_html__('Use a filter:','ymc-smart-filter').' 
                 <span class="doc-text">ymc_featured_post_custom_layout_'.$id.'</span> OR
                 <span class="doc-text">ymc_featured_post_custom_layout_'.$id.'_'.$c_target.'</span> 
                 '.esc_html__('to override post template.','ymc-smart-filter').' <br>'.esc_html__('Example:','ymc-smart-filter').'
                 <span class="doc-text">add_filter("ymc_featured_post_custom_layout_'.$id.'_'.$c_target.'", "callback_function", 10, 4);</span>
                 <a target="_blank" href="https://github.com/YMC-22/smart-filter">'.esc_html__('See documentation.','ymc-smart-filter').'</a>
                 </div>';

		        /**
		         * Creating a featured custom post template
		         * @param {string} layout - HTML markup
		         * @param {int} post_id - Post ID
		         * @param {int} filter_id - Filter ID
		         * @param {array} arrOptions - array of additional post parameters. It includes:
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

		        // phpcs:ignore WordPress
		        $layout = apply_filters('ymc_featured_post_custom_layout_'. esc_attr($id),
                    $layout,
                    get_the_ID(),
                    $id,
                    $arrOptions);

		        $layout = apply_filters('ymc_featured_post_custom_layout_'. esc_attr($id).'_'. esc_attr($c_target),
			        $layout,
			        get_the_ID(),
			        $id,
			        $arrOptions);
		        // phpcs:ignore WordPress
		        echo $layout;

		        $layout = null;

                echo '</article>';

            endwhile; ?>

		</div>

	</div>

<?php endif; ?>


