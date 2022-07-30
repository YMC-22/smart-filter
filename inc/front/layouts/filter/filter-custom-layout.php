<?php
/**
 * Template Custom Layout Filter
 */
?>


<div id="<?php echo $ymc_filter_layout; ?>" class="filter-layout <?php echo $ymc_filter_layout; ?>">

	<?php do_action("ymc_before_filter_layout"); ?>

	<div class="filter-custom-entry">

		<?php

			if ( is_array($terms_selected) && !empty($tax) ) {

				/**
				 * Layout: $layouts
                 * Selected Terms: $terms_selected
                 * Taxonomies: $tax
                 * Multiply Filter: $ymc_multiple_filter
                 * Target
                 * Type Pagination
				 */



                $target = 'data-target-ymc'.$c_target;

				$filter_layout = apply_filters('ymc_filter_custom_layout',
                                     $layouts,
                                     $terms_selected,
                                     $tax,
                                     $ymc_multiple_filter,
                                     $target,
                                     $ymc_pagination_type );

				echo $filter_layout;

			}

		?>

	</div>

	<?php do_action("ymc_after_filter_layout"); ?>

</div>
