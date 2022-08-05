<?php
defined('ABSPATH') or exit;

// Add Style
$ymc_filter_text_color = !empty($ymc_filter_text_color) ? "color:".$ymc_filter_text_color.";" : '';
$ymc_filter_bg_color   = !empty($ymc_filter_bg_color) ? "background-color:".$ymc_filter_bg_color.";" : '';
$ymc_filter_active_color = !empty($ymc_filter_active_color) ? "color:".$ymc_filter_active_color.";" : '';
$ymc_filter_font = !empty($ymc_filter_font) ? "font-family:".$ymc_filter_font.";" : '';

$filter_css = "#ymc-smart-filter-container-".$c_target." .filter-layout.filter-layout2 .filter-entry .filter-item .filter-link {". $ymc_filter_text_color . $ymc_filter_bg_color."}
               #ymc-smart-filter-container-".$c_target." .filter-layout.filter-layout2 .filter-entry .filter-item .filter-link.active {".$ymc_filter_active_color."}
               #ymc-smart-filter-container-".$c_target." .filter-layout.filter-layout2 .filter-entry .filter-item .filter-link {".$ymc_filter_font."}";
wp_add_inline_style($handle, $filter_css);
?>


<div id="<?php echo $ymc_filter_layout; ?>" class="filter-layout <?php echo $ymc_filter_layout; ?>">

	<?php do_action("ymc_before_filter_layout"); ?>

	<ul class="filter-entry">

		<?php
            $type_multiple = ( (bool) $ymc_multiple_filter ) ? 'multiple' : '';

            if ( is_array($terms_selected) ) {

                ( $ymc_sort_terms === 'asc' ) ? asort($terms_selected) : arsort($terms_selected);

                echo '<li class="filter-item"><a class="filter-link all active" href="#" data-selected="all" data-termid="' . esc_attr($ymc_terms) . '">' . esc_html__("All",'ymc-smart-filter') . '</a></li>';

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
                          <header class="name-tax">'. get_taxonomy( $tax )->label .'</header>
                          <ul class="sub-filters">';

                    foreach ($terms_selected as $term) {

                        if( $tax === get_term( $term )->taxonomy ) {
                            echo  "<li class='filter-item'>
                            <a class='filter-link ". $type_multiple ."' href='#' data-selected='" . esc_attr(get_term( $term )->slug) . "' data-termid='" . esc_attr($term) . "'>" . esc_html(get_term( $term )->name) . "</a></li>";
                        }
                    }

                    echo '</ul></li>';
                }

	            unset($result_tax);
            }
		?>

	</ul>

    <div class="posts-found"></div>

	<?php do_action("ymc_after_filter_layout"); ?>

</div>
