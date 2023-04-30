<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$ymc_filter_text_color = !empty($ymc_filter_text_color) ? "color:".$ymc_filter_text_color.";" : '';
$ymc_filter_bg_color   = !empty($ymc_filter_bg_color) ? "background-color:".$ymc_filter_bg_color.";" : '';
$ymc_filter_active_color = !empty($ymc_filter_active_color) ? "color:".$ymc_filter_active_color.";" : '';
$ymc_filter_font = !empty($ymc_filter_font) ? "font-family:".$ymc_filter_font.";" : '';

$filter_css = "#ymc-smart-filter-container-".$c_target." .filter-layout.filter-layout1 .filter-entry .filter-item .filter-link {". $ymc_filter_text_color . $ymc_filter_bg_color."}
               #ymc-smart-filter-container-".$c_target." .filter-layout.filter-layout1 .filter-entry .filter-item .filter-link.active {".$ymc_filter_active_color."}
               #ymc-smart-filter-container-".$c_target." .filter-layout.filter-layout1 .filter-entry .filter-item .filter-link {".$ymc_filter_font."}";

echo '<style id="'.$handle_filter.'">'.$filter_css.'</style>';

?>

<div id="<?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<?php do_action("ymc_before_filter_layout_".$id.'_'.$c_target); ?>

    <ul class="filter-entry">

		<?php

            $type_multiple = ( (bool) $ymc_multiple_filter ) ? 'multiple' : '';

            if ( is_array($terms_selected) ) {

				if( $ymc_sort_terms !== 'manual' ) {
					( $ymc_sort_terms === 'asc' ) ? asort($terms_selected) : arsort($terms_selected);
				}

	            $show_all = apply_filters('ymc_button_show_all_'.$id.'_'.$c_target, __('All','ymc-smart-filter'));

                echo '<li class="filter-item">
                      <a class="filter-link all active" href="#" data-selected="all" data-termid="'. esc_attr($ymc_terms) .'">'. esc_html__($show_all) .'</a></li>';

                foreach ($terms_selected as $term) {

                    echo "<li class='filter-item'><a class='filter-link ". esc_attr($type_multiple) ."' href='#' data-selected='" . esc_attr(get_term( $term )->slug) . "' data-termid='" . esc_attr($term) . "'>" . esc_html(get_term( $term )->name) . "</a></li>";
                }
            }
		?>

	</ul>

    <div class="posts-found"></div>

    <?php do_action("ymc_after_filter_layout_".$id.'_'.$c_target); ?>

</div>









