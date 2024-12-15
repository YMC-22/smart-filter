<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$filter_css = "";

if( !empty($ymc_filter_text_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link, 
    #ymc-extra-filter-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link,
    #ymc-smart-filter-container-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link:before, 
    #ymc-extra-filter-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link:before,
    #ymc-smart-filter-container-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link:after, 
    #ymc-extra-filter-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link:after {color:". $ymc_filter_text_color."; border-color:". $ymc_filter_text_color."}";
}
if( !empty($ymc_filter_bg_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link, 
    #ymc-extra-filter-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link  {background-color:". $ymc_filter_bg_color."}";
}
if( !empty($ymc_filter_active_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link.active,
    #ymc-extra-filter-".$c_target." .filter-layout5 .filter-entry .menu-passive .menu-link.active {color:".$ymc_filter_active_color."}";
}
if( $ymc_filter_font !== 'inherit' ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout5 .filter-entry,
    #ymc-extra-filter-".$c_target." .filter-layout5 .filter-entry {font-family:".$ymc_filter_font."}";
}

echo '<style id="'.esc_attr($handle_filter).'">'. esc_html(preg_replace('|\s+|', ' ', $filter_css)) .'</style>';

?>


<div id="<?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<?php do_action("ymc_before_filter_layout_".$id.'_'.$c_target); ?>

    <?php if( is_array($terms_selected) ) :

		$all_terms = implode(',', $terms_selected);

	    $text_all = apply_filters('ymc_placeholder_dropdown_'.$id.'_'.$c_target, $ymc_post_elements['button_text_all']);
    ?>

    <div class="filter-entry" data-terms="<?php echo esc_attr($all_terms); ?>" data-text-all="<?php echo esc_attr($text_all); ?>">

		<?php

			$type_multiple = ( (bool) $ymc_multiple_filter ) ? 'multiple' : '';

			if( $ymc_sort_terms !== 'manual' ) {
				//( $ymc_sort_terms === 'asc' ) ? asort($terms_selected) : arsort($terms_selected);
				( $ymc_sort_terms === 'asc' ) ? sortTaxTerms($terms_selected, 'asc') :
					sortTaxTerms($terms_selected, 'desc');
			}

            $arr_taxonomies = [];
            $terms_categories = '';

            foreach ($terms_selected as $term) {

	            $arr_taxonomies[] = ( ! is_wp_error( get_term( $term ) ) && ! is_null( get_term( $term ) ) ) ? get_term( $term )->taxonomy : null;
            }

            $arr_taxonomies = array_unique($arr_taxonomies);

            if( ! is_null($tax_sort) && is_array($tax_sort) ) {
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

            foreach ( $result_tax as $tax )
			{
				$arr_terms_categories = get_terms(['taxonomy' => $tax, 'hide_empty' => false]);

                if( $arr_terms_categories && ! is_wp_error( $arr_terms_categories ) ) {
	                foreach( $arr_terms_categories as $term ) {
						if( in_array($term->term_id, $terms_selected) ) {
							$terms_categories .= $term->term_id . ',';
						}
	                }
                }

				// Options Taxonomy
				$tacBg = '';
				$taxColor = '';
				$taxName = '';

				if( !empty($ymc_taxonomy_options) )
				{
					$taxonomyStylesArray = taxonomyStylesConfig($tax, $ymc_taxonomy_options);

					if( !empty($taxonomyStylesArray) )
					{
						$tacBg = $taxonomyStylesArray['bg'];
						$taxColor = $taxonomyStylesArray['color'];
						$taxName = $taxonomyStylesArray['name'];
					}
				}

				$style_tax_bg = !empty( $tacBg ) ? 'background-color:'.$tacBg.';' : '';
				$style_tax_color = !empty($taxColor) ? 'color:'.$taxColor.';' : '';
				$tax_name = !empty($taxName) ? $taxName : get_taxonomy( $tax )->label;

	            $select_term = apply_filters('ymc_select_term_dropdown', $tax);
	            $tax_name = apply_filters('ymc_tax_name_'.$id.'_'.$c_target.'_'.$tax, $tax_name);

				$text_all = apply_filters('ymc_placeholder_dropdown_'.$id.'_'.$c_target.'_'.$tax, $text_all);

				if( ! empty($default_terms) && empty($type_multiple) )
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

                echo '<div class="dropdown-filter tax-'.esc_attr($tax).'">';
                echo '<div class="name-category">' . esc_html($tax_name) .'</div>';
                echo '<div class="menu-active" style="'.esc_attr($style_tax_bg).esc_attr($style_tax_color).'">';
                echo '<span class="text-cat">'. esc_html($text_all) .'</span> <i class="arrow down"></i>';
                echo '</div>';
                echo '<div class="menu-passive">';
                echo '<i class="btn-close">x</i>';
				echo '<div class="menu-passive__item item-all">
                    <a class="menu-link all '. esc_attr($type_multiple) .' active" href="#" data-name="'.esc_attr($text_all).'" data-termid="'. esc_attr(rtrim($terms_categories, ',')) .'">'.
                     esc_html__('All','ymc-smart-filter'). '</a></div>';

				echo '<div class="menu-passive__inner-items">';

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

				$terms_categories = '';

				$terms_selected = array_diff($terms_selected, getHiddenTerms($ymc_terms_options));

                foreach ( $terms_selected as $term )
				{
					$object_term = get_term( $term );

					if( is_wp_error( $object_term ) || is_null( $object_term ) ) continue;

                    if( $tax === $object_term->taxonomy )
					{
                        $is_disabled = ( $object_term->count === 0 ) ? 'isDisabled' : '';

						// Set Options for Icon
						setOptionsIcon( $ymc_terms_align, $term, $class_terms_align, $color_icon );

						// Set Options for Term
						setOptionsTerm(
								$ymc_terms_options,
								$term,
							   $bg_term,
							   $color_term,
							   $class_term,
							   $default_term_active,
							   $name_term );

						// Selected Icon for Term
						setSelectedIcon( $ymc_terms_icons, $term, $terms_icons, $color_icon );

	                    $bg_term = ( !empty($bg_term) ) ? 'background-color:'.$bg_term.';' : '';
	                    $color_term = ( !empty($color_term) ) ? 'color:'.$color_term.';' : '';
	                    $default_term_active = ( $default_term_active === 'checked' ) ? 'active': '';
						$name_term = ( !empty($name_term) ) ? $name_term : $object_term->name;

                        echo '<div class="menu-passive__item item-'. esc_attr($object_term->slug) .' '.esc_attr($class_terms_align).'">
							  '. wp_kses_post($terms_icons) .'
                              <a class="menu-link '.
                              esc_attr($is_disabled) .' '.
                              esc_attr($type_multiple) .' '.
                              esc_attr($class_term) . " ". esc_attr($default_term_active) .'" style="'.esc_attr($bg_term) . esc_attr($color_term).'" 
                              href="#" data-selected="'. esc_attr($object_term->slug) .'" data-termid="' . esc_attr($term) . '" data-name="'.esc_attr($object_term->name).'">'.
                              esc_html($name_term) . ' <span class="count">'. esc_html($object_term->count) .'</span></a></div>';
                    }

	                $terms_icons = null;
					$name_term = '';
                }

                echo '</div>';
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


