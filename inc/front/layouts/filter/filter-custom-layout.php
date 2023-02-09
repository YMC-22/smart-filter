<?php // Custom Filter Layout

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="<?php echo esc_attr($ymc_filter_layout) . esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?>">

	<?php

        do_action("ymc_before_filter_layout_".$c_target."");

        if ( is_array($terms_selected) && is_array($tax_selected) ) {

				/**
				 * Creating a custom filter template
				 * @param {string} layout - HTML markup
				 * @param {array} terms_selected - list ids terms
				 * @param {array} result_tax - list sorted slugs taxonomies
				 * @param {int} ymc_multiple_filter - multiple or single selection of posts (0/1)
                 * @param {string} target - name class target element
				 * @returns {string} HTML markup filter bar
				 */


                $target = '.data-target-ymc'.$c_target;
	            $multiple = (int) $ymc_multiple_filter;

                if( !is_null($tax_sort)) {
                    $result_tax = [];
                    foreach($tax_sort as $val) {
                        if(array_search($val, $tax_selected) !== false) {
                            $result_tax[array_search($val, $tax_selected)] = $val;
                        }
                    }
                }
                else {
                    $result_tax = $tax_selected;
                }

                $layout  = '<div class="cf-wrp"><header class="head-filter">'.esc_html__('Add custom filter layout.','ymc-smart-filter').'</header>';
				$layout .= '<div class="inform">'. esc_html__('Use a filter:','ymc-smart-filter') .' 
                            <span class="doc-text">ymc_filter_custom_layout</span> 
                            '. esc_html__('Example:','ymc-smart-filter') .' 
                            <span class="doc-text">add_filter("ymc_filter_custom_layout", "func_custom_layout", 10, 5);</span>
                            <a target="_blank" href="https://github.com/YMC-22/smart-filter">'.esc_html__('See documentation.','ymc-smart-filter').'</a></div></div>';

				$filter_layout = apply_filters('ymc_filter_custom_layout_'.$c_target,
                                     $layout,
                                     $terms_selected,
					                 $result_tax,
					                 $multiple,
                                     $target);

				echo $filter_layout;

			}

		 do_action("ymc_after_filter_layout_".$c_target."");

   ?>

</div>
