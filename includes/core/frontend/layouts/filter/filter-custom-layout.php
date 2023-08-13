<?php // Custom Filter Layout

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$term_settings = arrayToObject( generalArrayMerging( $ymc_terms_options, $ymc_terms_align ) );

?>

<div id="<?php echo esc_attr($ymc_filter_layout) . esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo $c_target; ?> ">

	<?php

        do_action("ymc_before_filter_layout_".$id.'_'.$c_target."");

        if ( is_array($terms_selected) && is_array($tax_selected) ) {

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

	        if( !is_null($term_sort) && $ymc_sort_terms === 'manual' )  {
		        $result_terms = [];
		        foreach( $terms_selected as $termID ) {
			        $key = array_search($termID, $term_sort);
			        $result_terms[$key] = $termID;
		        }
		        ksort($result_terms);
	        }
	        else {
		        ( $ymc_sort_terms === 'asc' ) ? asort($terms_selected) : arsort($terms_selected);
		        $result_terms = $terms_selected;
	        }

            $layout  = '<div class="cf-wrp"><header class="head-filter">'.esc_html__('Add custom filter layout.','ymc-smart-filter').'</header>';
			$layout .= '<div class="inform">'. esc_html__('Use a filter:','ymc-smart-filter') .' 
                        <span class="doc-text">ymc_filter_custom_layout_'.$id.'_'.$c_target.'</span> 
                        '. esc_html__('Example:','ymc-smart-filter') .' 
                        <span class="doc-text">add_filter("ymc_filter_custom_layout_"'.$id.'_'.$c_target.', "func_custom_layout", 10, 6);</span>
                        <a target="_blank" href="https://github.com/YMC-22/smart-filter">'.esc_html__('See documentation.','ymc-smart-filter').'</a></div></div>';


	        /**
	         * Creating a custom filter template
	         * @param {string} layout - HTML markup
	         * @param {array} terms - list ids terms
	         * @param {array} tax - list sorted slugs taxonomies
	         * @param {int} multiple - multiple or single selection of posts (0/1)
	         * @param {string} target - name class target element
	         * @param {array} optionsTerms - array of objects of term settings. Default empty array.
		        - optionsTerms['termid'] - term ID
		        - termid - ID term
		        - bg - background term. Hex Color Codes (ex: #dd3333)
		        - color - color term. Hex Color Codes (ex: #dd3333)
		        - class - custom name class of the term
		        - status - checked term
		        - alignterm - align icon in term
		        - coloricon - color icon
		        - classicon - name class icon (Font Awesome Icons. ex. far fa-arrow-alt-circle-down)
		        - status - term status (checked)
	         * @returns {string} HTML markup filter bar
	         */

			$filter_layout = apply_filters('ymc_filter_custom_layout_'.$id.'_'.$c_target,
                                 $layout,
								 $result_terms,
				                 $result_tax,
				                 $multiple,
                                 $target,
								 $term_settings
								);

			echo $filter_layout;

		}

		do_action("ymc_after_filter_layout_".$id.'_'.$c_target."");

   ?>

</div>
