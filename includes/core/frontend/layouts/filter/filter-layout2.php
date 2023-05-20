<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$ymc_filter_text_color = !empty($ymc_filter_text_color) ? "color:".$ymc_filter_text_color.";" : '';
$ymc_filter_bg_color   = !empty($ymc_filter_bg_color) ? "background-color:".$ymc_filter_bg_color.";" : '';
$ymc_filter_active_color = !empty($ymc_filter_active_color) ? "color:".$ymc_filter_active_color.";" : '';
$ymc_filter_font = !empty($ymc_filter_font) ? "font-family:".$ymc_filter_font.";" : '';

$filter_css = "#ymc-smart-filter-container-".$c_target." .filter-layout.filter-layout2 .filter-entry .filter-item .filter-link {". $ymc_filter_text_color . $ymc_filter_bg_color."}
               #ymc-smart-filter-container-".$c_target." .filter-layout.filter-layout2 .filter-entry .filter-item .filter-link.active {".$ymc_filter_active_color."}
               #ymc-smart-filter-container-".$c_target." .filter-layout.filter-layout2 .filter-entry .filter-item .filter-link {".$ymc_filter_font."}";

echo '<style id="'.$handle_filter.'">'.$filter_css.'</style>';

?>


<div id="<?php echo  esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo  esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<?php do_action("ymc_before_filter_layout_".$id.'_'.$c_target); ?>

	<ul class="filter-entry">

		<?php

            $type_multiple = ( (bool) $ymc_multiple_filter ) ? 'multiple' : '';

            if ( is_array($terms_selected) ) {

				if( $ymc_sort_terms !== 'manual' ) {
					( $ymc_sort_terms === 'asc' ) ? asort($terms_selected) : arsort($terms_selected);
				}

	            $show_all = apply_filters('ymc_button_show_all_'.$id.'_'.$c_target, __('All','ymc-smart-filter'));

                echo '<li class="filter-item"><a class="filter-link all active" href="#" data-selected="all" data-termid="' . esc_attr($ymc_terms) . '">'. esc_html__($show_all) .'</a></li>';

                $arr_taxonomies = [];
                foreach ($terms_selected as $term) {
                    $arr_taxonomies[] = get_term( $term )->taxonomy;
                }
                $arr_taxonomies = array_unique($arr_taxonomies);

                if( !is_null($tax_sort)) {
	                $result_tax = [];
	                foreach($tax_sort as $val) {
                        if(array_search($val, $arr_taxonomies) !== false) {
	                        $result_tax[array_search($val, $arr_taxonomies)] = $val;
                        }
	                }
                }
                else {
	                $result_tax = $arr_taxonomies;
                }

                foreach ($result_tax as $tax) {

                    echo '<li class="group-filters">
                          <header class="name-tax">'. esc_html(get_taxonomy( $tax )->label) .'</header>
                          <ul class="sub-filters">';

	                $terms_icons = null;
	                $class_terms_align = null;

                    foreach ($terms_selected as $term) {

                        if( $tax === get_term( $term )->taxonomy ) {

	                        // Choose icons
	                        if( !empty($ymc_terms_icons) ) {

		                        foreach ( $ymc_terms_icons as $key => $val ) {

			                        if( (int) $term === (int) $key ) {
				                        $terms_icons = '<i class="'. $val .'"></i>';
				                        break;
			                        }
		                        }
	                        }

	                        // Set align icons
	                        if( !empty($ymc_terms_align) ) {

		                        $flag_terms_align = false;

		                        foreach ( $ymc_terms_align as $sub_terms_align ) {

			                        foreach ( $sub_terms_align as $key => $val) {

				                        if ( $key === 'termid' && (int) $term === (int) $val ) {
					                        $flag_terms_align = true;
				                        }
				                        if ( $key === 'alignterm' ) {
					                        $class_terms_align = $val;
				                        }
			                        }

			                        if( $flag_terms_align ) {
				                        break;
			                        }
		                        }
	                        }

                            echo  "<li class='filter-item'>
                            <a class='filter-link ". esc_attr($type_multiple) ." ". esc_attr($class_terms_align) ."' href='#' data-selected='" . esc_attr(get_term( $term )->slug) . "' data-termid='" . esc_attr($term) . "'>" . $terms_icons . '<span class="link-inner">'.esc_html(get_term( $term )->name) .'</span>'."</a></li>";
                        }

	                    $terms_icons = null;
	                    $class_terms_align = null;
                    }

                    echo '</ul></li>';
                }

	            unset($result_tax);
            }
		?>

	</ul>

    <div class="posts-found"></div>

	<?php do_action("ymc_after_filter_layout_".$id.'_'.$c_target); ?>

</div>
