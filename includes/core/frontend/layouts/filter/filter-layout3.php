<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$filter_css = "";

echo '<style id="'.$handle_filter.'">'.$filter_css.'</style>';

?>


<div id="<?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<?php do_action("ymc_before_filter_layout_".$id.'_'.$c_target); ?>

	<?php if( is_array($terms_selected) ) :

		$all_terms = implode(',', $terms_selected);
    ?>

    <div class="filter-entry" data-terms="<?php echo esc_attr($all_terms); ?>">

		<?php

		$type_multiple = ( (bool) $ymc_multiple_filter ) ? 'multiple' : '';

		if( $ymc_sort_terms !== 'manual' ) {
			( $ymc_sort_terms === 'asc' ) ? asort($terms_selected) : arsort($terms_selected);
		}

		?>

        <?php

            $arr_taxonomies = [];

            foreach ($terms_selected as $term) {

                $arr_taxonomies[] = get_term( $term )->taxonomy;
            }
            $arr_taxonomies = array_unique($arr_taxonomies);

            $show_all = apply_filters('ymc_button_show_all_'.$id.'_'.$c_target, __('All','ymc-smart-filter'));

            echo '<a class="btn-all" href="#" data-selected="all" data-terms="' . esc_attr($all_terms) . '">'. esc_html($show_all) .'</a>';

            if( !is_null($tax_sort) && is_array($tax_sort) ) {
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

	            $select_term = apply_filters('ymc_select_term_dropdown', $tax);
	            $tax_name = apply_filters('ymc_tax_name_'.$id.'_'.$c_target.'_'.$tax, get_taxonomy( $select_term )->label);

                echo '<div class="dropdown-filter">';
                echo '<div class="menu-active">';
                echo '<span>' . $tax_name .'</span> <i class="arrow down"></i>';
                echo '</div>';
                echo '<div class="menu-passive">';
                echo '<i class="btn-close">x</i>';

	            $terms_icons = null;
	            $class_terms_align = null;
	            $bg_term = null;
	            $color_term = null;
	            $class_term = null;
	            $color_icon = null;

                foreach ($terms_selected as $term) {

                    if( $tax === get_term( $term )->taxonomy ) {

                     $is_disabled = ( get_term( $term )->count === 0 ) ? 'isDisabled' : '';

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
				                    if ( $key === 'coloricon' ) {
					                    $color_icon = $val;
				                    }
			                    }

			                    if( $flag_terms_align ) {
				                    break;
			                    }
		                    }
	                    }

					    // Set options term
	                    if( !empty($ymc_terms_options) ) {

		                    $flag_terms_option = false;

		                    foreach ( $ymc_terms_options as $terms_opt ) {

			                    foreach ( $terms_opt as $key => $val) {

				                    if ( $key === 'termid' && (int) $term === (int) $val ) {
					                    $flag_terms_option = true;
				                    }
				                    if ( $key === 'bg' && $flag_terms_option ) {
					                    $bg_term = $val;
				                    }
				                    if ( $key === 'color' && $flag_terms_option ) {
					                    $color_term = $val;
				                    }
				                    if ( $key === 'class' && $flag_terms_option ) {
					                    $class_term = $val;
				                    }
			                    }

			                    if( $flag_terms_option ) break;
		                    }
	                    }

	                    // Choose icons
	                    if( !empty($ymc_terms_icons) ) {

		                    foreach ( $ymc_terms_icons as $key => $val ) {

			                    if( (int) $term === (int) $key ) {

				                    $colorIconTerm = ( !empty($color_icon) ) ? 'color:'.$color_icon.';' : '';
				                    $terms_icons = '<i class="'. $val .'" style="'.$colorIconTerm.'"></i>';
				                    break;
			                    }
		                    }
	                    }

	                    $bg_term = ( !empty($bg_term) ) ? 'background-color:'.$bg_term.';' : '';
	                    $color_term = ( !empty($color_term) ) ? 'color:'.$color_term.';' : '';

                        echo '<div class="menu-passive__item item-'. esc_attr(get_term( $term )->slug) .' '.esc_attr($class_terms_align).'">
							  '. $terms_icons .'
                              <a class="menu-link '.
                              esc_attr($is_disabled) .' '.
                              esc_attr($type_multiple) .' '.
                              esc_attr($class_term) .'" style="'.esc_attr($bg_term) . esc_attr($color_term).'" 
                              href="#" data-selected="'. esc_attr(get_term( $term )->slug) .'" data-termid="' . esc_attr($term) . '" data-name="'.esc_attr(get_term( $term )->name).'">'.
                              esc_html(get_term( $term )->name) . ' <span class="count">'. esc_html(get_term( $term )->count) .'</span></a></div>';
                    }

	                $terms_icons = null;
                }

                echo '</div>';
                echo '</div>';
            }

            unset($result_tax);

        ?>

        <div class="selected-items"></div>

	</div>

    <div class="posts-found"></div>

    <?php endif; ?>

	<?php do_action("ymc_after_filter_layout_".$id.'_'.$c_target); ?>

</div>
