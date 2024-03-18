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

            foreach ($result_tax as $tax)
			{

	            $select_term = apply_filters('ymc_select_term_dropdown', $tax);
	            $tax_name = apply_filters('ymc_tax_name_'.$id.'_'.$c_target.'_'.$tax, get_taxonomy( $select_term )->label);

				if( !empty($default_terms) && empty($type_multiple) )
				{
					$arr_default_term_ids = explode(',', $default_terms);
					foreach ( $arr_default_term_ids as $term_id )
					{
						if( get_term( $term_id )->taxonomy ===  get_taxonomy( $select_term )->name )
						{
							$tax_name = get_term( $term_id )->name;
						}
					}
				}

                echo '<div class="dropdown-filter tax-'.$tax.'">';
                echo '<div class="menu-active">';
                echo '<span>' . $tax_name .'</span> <i class="arrow down"></i>';
                echo '</div>';
                echo '<div class="menu-passive">';
                echo '<i class="btn-close">x</i>';

				// Variables: Options Term
				$bg_term             = null;
				$color_term          = null;
				$class_term          = null;
				$default_term_active = null;
				$name_term           = null;

				// Variables: Options Icon
				$class_terms_align   = null;
				$color_icon          = null;

				// Variables: Set Selected Icon
				$terms_icons         = null;


                foreach ($terms_selected as $term)
				{
                    if( $tax === get_term( $term )->taxonomy )
					{

                     $is_disabled = ( get_term( $term )->count === 0 ) ? 'isDisabled' : '';

						// Set Options for Icon
						setOptionsIcon($ymc_terms_align, $term, $class_terms_align, $color_icon);

						// Set Options for Term
						setOptionsTerm($ymc_terms_options,
									   $term,
							        $bg_term,
							        $color_term,
									$class_term,
									$default_term_active,
									$name_term);

						// Selected Icon for Term
						setSelectedIcon( $ymc_terms_icons, $term, $terms_icons, $color_icon );

	                    $bg_term = ( !empty($bg_term) ) ? 'background-color:'.$bg_term.';' : '';
	                    $color_term = ( !empty($color_term) ) ? 'color:'.$color_term.';' : '';
	                    $default_term_active = ( $default_term_active === 'checked' ) ? 'active': '';
						$name_term = ( !empty($name_term) ) ? $name_term : get_term( $term )->name;

                        echo '<div class="menu-passive__item item-'. esc_attr(get_term( $term )->slug) .' '.esc_attr($class_terms_align).'">
							  '. $terms_icons .'
                              <a class="menu-link '.
                              esc_attr($is_disabled) .' '.
                              esc_attr($type_multiple) .' '.
                              esc_attr($class_term) . " ". esc_attr($default_term_active) .'" style="'.esc_attr($bg_term) . esc_attr($color_term).'" 
                              href="#" data-selected="'. esc_attr(get_term( $term )->slug) .'" data-termid="' . esc_attr($term) . '" data-name="'.esc_attr(get_term( $term )->name).'">'.
                              esc_html($name_term) . ' <span class="count">'. esc_html(get_term( $term )->count) .'</span></a></div>';
                    }

	                $terms_icons = null;
					$name_term = '';
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
