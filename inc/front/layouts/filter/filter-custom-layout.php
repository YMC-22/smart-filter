<?php
// Custom Filter Layout
?>


<div id="<?php echo $ymc_filter_layout . $c_target; ?>" class="filter-layout <?php echo $ymc_filter_layout; ?>">

	<?php do_action("ymc_before_filter_layout"); ?>

	<?php

			if ( is_array($terms_selected) && is_array($tax_selected) ) {

				/**
				 * Layout: $layouts (String)
                 * Selected Terms: $terms_selected (Array)
                 * Taxonomies: $tax_selected (Array)
                 * Multiply Filter: $ymc_multiple_filter (Int) 0 / 1
                 * Target (String)
				 */


                $target = 'data-target-ymc'.$c_target;

                $layouts  = '<div class="cf-wrp"><header class="head-filter">'.esc_html__('Add custom filter layout.','ymc-smart-filter').'</header>';
				$layouts .= '<div class="inform">'.esc_html__('Use a filter:','ymc-smart-filter').' 
                             <span class="doc-text">ymc_filter_custom_layout</span> 
                             '.esc_html__('Example:','ymc-smart-filter').' 
                             <span class="doc-text">add_filter("ymc_filter_custom_layout", "func_custom_layout", 10, 5);</span>
                             <a target="_blank" href="https://github.com/YMC-22/smart-filter">'.esc_html__('See documentation.','ymc-smart-filter').'</a></div></div>';

				$filter_layout = apply_filters('ymc_filter_custom_layout',
                                     $layouts,
                                     $terms_selected,
					                 $tax_selected,
                                     $ymc_multiple_filter,
                                     $target);

				echo $filter_layout;

			}

		?>

	<?php do_action("ymc_after_filter_layout"); ?>

</div>
