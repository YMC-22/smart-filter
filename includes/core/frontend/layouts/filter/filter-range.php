<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$filter_css = "";
if( !empty($ymc_filter_text_color) ) {
	$filter_css .= "#ymc-smart-filter-container-" . $c_target . " .filter-range .filter-entry,
	#ymc-extra-filter-" . $c_target . " .filter-range .filter-entry {color:" . $ymc_filter_text_color . "}";

	$filter_css .= "#ymc-smart-filter-container-" . $c_target . " .filter-range .filter-entry .range__component,
	#ymc-extra-filter-" . $c_target . " .filter-range .filter-entry .range__component {color:" . $ymc_filter_text_color . "}";
}
if( !empty($ymc_filter_bg_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-range .filter-entry .range__component:not(.tax-label):not(.apply-button),	
	#ymc-extra-filter-".$c_target." .filter-range .filter-entry .range__component:not(.tax-label):not(.apply-button) {background-color:".$ymc_filter_bg_color."}";

	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-range .filter-entry .tag-values:before,	
	#ymc-extra-filter-".$c_target." .filter-range .filter-entry .tag-values:before {border-top: 12px solid ".$ymc_filter_bg_color."}";
}
if( $ymc_filter_font !== 'inherit' ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-range .filter-entry,               
    #ymc-extra-filter-".$c_target." .filter-range .filter-entry {font-family:".$ymc_filter_font."}";
}

echo '<style id="'.esc_attr($handle_filter).'">'. esc_html(preg_replace('|\s+|', ' ', $filter_css)) .'</style>';

?>

<div id="<?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<?php
        do_action("ymc_before_filter_layout_".$id);
        do_action("ymc_before_filter_layout_".$id.'_'.$c_target);
	?>

	<?php

	if( !empty($tax_selected) ) : ?>

        <div class="filter-entry">

            <div class="clear-wrapper">
                <button class="clear-button" type="button"><?php esc_html_e('Clear','ymc-smart-filter'); ?></button>
            </div>

            <div class="posts-found"></div>

            <div class="filter-items">

			<?php foreach ($tax_selected as $tax) :

				$all_tags = [];
                $dataArray = [];
                $tagArrayIDs = [];

				$terms = get_terms(array(
					'taxonomy'   => $tax,
					'hide_empty' => false
				));

                if( $terms && ! is_wp_error( $terms ) )
                {
                    foreach ( $terms as $term ) {
                        $all_tags[] = $term->term_id;
                    }
                    if( !empty($terms_selected) ) {
	                    $result = array_intersect($all_tags, $terms_selected);
	                    $end_tags = array_diff($result, getHiddenTerms($ymc_terms_options));

	                    foreach ( $end_tags as $value ) {
		                    $term = get_term($value);
		                    $dataArray[$term->term_id] = $term->name;
		                    $tagArrayIDs[] = $term->term_id;
	                    }
                    }
                }

				$json_data = !empty($dataArray) ? wp_json_encode($dataArray) : '';
                $tagsIDs = !empty($tagArrayIDs) ? implode(',', $tagArrayIDs) : '';

				?>
                <div class="range-wrapper tax-<?php echo esc_attr($tax); ?>">
                    <div class="range__component tax-label"><?php echo esc_html(get_taxonomy($tax)->labels->name); ?></div>
                    <div class="range__component tag-values" data-tags='<?php echo esc_attr($json_data); ?>' data-selected-tags='<?php echo esc_attr($tagsIDs); ?>'>
                        <span class="range1"></span>
                        <span> <?php echo !empty($dataArray) ? '&dash;' : esc_html__('No tags','ymc-smart-filter'); ?></span>
                        <span class="range2"></span>
                    </div>
                    <?php if( !empty($json_data) ) : ?>
                    <div class="range__component range-container">
                        <div class="slider-track"></div>
                        <input class="slider-1" type="range" min="0" max="" value="0" >
                        <input class="slider-2" type="range" min="0" max="" value="" >
                    </div>
                    <div class="range__component apply-button">
                        <button class="apply-button__inner"><?php esc_html_e('Apply','ymc-smart-filter'); ?></button>
                    </div>
                    <?php endif; ?>
                </div>

			<?php

			endforeach; ?>

            </div>

        </div>

	<?php endif;  ?>

	<?php
        do_action("ymc_after_filter_layout_".$id);
        do_action("ymc_after_filter_layout_".$id.'_'.$c_target);
	?>

</div>
