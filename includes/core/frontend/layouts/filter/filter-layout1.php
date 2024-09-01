<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$filter_css = "";
if( !empty($ymc_filter_text_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout1 .filter-entry .filter-link, 
                    #ymc-extra-filter-".$c_target." .filter-layout1 .filter-entry .filter-link { color:".$ymc_filter_text_color.";}";
}
if( !empty($ymc_filter_bg_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout1 .filter-entry .filter-link, 
                    #ymc-extra-filter-".$c_target." .filter-layout1 .filter-entry .filter-link { background-color:".$ymc_filter_bg_color.";}";
}
if( !empty($ymc_filter_active_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout1 .filter-entry .filter-link.active, 
                    #ymc-extra-filter-".$c_target." .filter-layout1 .filter-entry .filter-link.active { color:".$ymc_filter_active_color.";}";
}
if( $ymc_filter_font !== 'inherit' ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout1 .filter-entry .filter-link, 
                    #ymc-extra-filter-".$c_target." .filter-layout1 .filter-entry .filter-link { font-family:".$ymc_filter_font.";}";
}

echo '<style id="'.$handle_filter.'">'. preg_replace('|\s+|', ' ', $filter_css) .'</style>';

?>

<div id="<?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<?php do_action("ymc_before_filter_layout_".$id.'_'.$c_target); ?>

    <ul class="filter-entry">

		<?php

            if ( is_array($terms_selected) )
			{

				$type_multiple = ( (bool) $ymc_multiple_filter ) ? 'multiple' : '';

				// Check Hierarchy of terms
				$ymc_hierarchy_terms = (bool) $ymc_hierarchy_terms;

	            if( $ymc_sort_terms !== 'manual' ) {
					( $ymc_sort_terms === 'asc' ) ? sortTaxTerms($terms_selected, 'asc') :
						sortTaxTerms($terms_selected, 'desc');
				}

	            $show_all = apply_filters('ymc_button_show_all_'.$id.'_'.$c_target, __($ymc_post_elements['button_text_all'],'ymc-smart-filter'));

                $all_class_active = ( empty($default_terms) ) ? 'active' : '';

				echo '<li class="filter-item">
                      <a class="filter-link all '. $all_class_active .'" href="#" data-selected="all" data-termid="'. esc_attr($ymc_terms) .'">'. esc_html__($show_all) .'</a></li>';


				foreach ($terms_selected as $term_id)
				{
					$object_term = get_term( $term_id );

					if( is_wp_error( $object_term ) || is_null( $object_term ) ||
					    ( $object_term->parent !== 0 && $ymc_hierarchy_terms) ) continue;

					// Options Term
					$bg_term = '';
					$color_term = '';
					$class_term = '';
					$default_term_active = '';
					$name_term = '';

					// Options Icon
					$class_terms_align = '';
					$color_icon = '';

					// Set Selected Icon
					$terms_icons = '';

					// Hierarchy Terms
					$class_hierarchy = '';
					$tree_output = '';

					// Set Options for Icon
					setOptionsIcon( $ymc_terms_align, $term_id, $class_terms_align, $color_icon );

					// Set Options Term
					setOptionsTerm( $ymc_terms_options,
						$term_id,
						$bg_term,
						$color_term,
						$class_term,
						$default_term_active,
						$name_term );

					// Selected Icon for Term
					setSelectedIcon( $ymc_terms_icons, $term_id, $terms_icons, $color_icon );

					$bg_term = ( !empty($bg_term) ) ? 'background-color:'.$bg_term.';' : '';
					$color_term = ( !empty($color_term) ) ? 'color:'.$color_term.';' : '';
					$default_term_active = ( $default_term_active === 'checked' ) ? 'active': '';
					$name_term = ( !empty($name_term) ) ? $name_term : $object_term->name;

					$is_disabled = ( $object_term->count === 0 ) ? 'isDisabled' : '';

					// Set Hierarchy Terms
					if( $ymc_hierarchy_terms )
					{
						$arrayTermsOptions = [
							'multiple' => $type_multiple,
							'terms_align' => $ymc_terms_align,
							'terms_options' => $ymc_terms_options,
							'terms_icons' => $ymc_terms_icons,
							'terms_selected' => $terms_selected,
							'terms_order' => $ymc_sort_terms,
							'filter_layout' => $ymc_filter_layout
						];

						// Get Hierarchy Terms
						$tree_output = hierarchyTermsLayout($object_term->term_id, $object_term->taxonomy, 0, $arrayTermsOptions);
						if( !empty($tree_output) ) {
							$class_hierarchy = 'item-has-children';
						}
					}


					echo "<li class='filter-item ". esc_attr($class_hierarchy) ."'>
					     <a class='filter-link ".
					     esc_attr($type_multiple) ." ".
					     esc_attr($class_terms_align) ." ".
					     esc_attr($is_disabled) ." ".
					     esc_attr($class_term) . " ". esc_attr($default_term_active) ."' style='".
					     esc_attr($bg_term) .
					     esc_attr($color_term) ."' href='#' data-selected='" .
					     esc_attr($object_term->slug) . "' data-termid='". esc_attr($term_id) ."'>" . $terms_icons .
					     '<span class="link-inner">'. esc_html($name_term) . '</span>'."</a>";

					// Insert Hierarchy Terms Tree
					echo $tree_output;

					echo '</li>';

				}
            }
		?>

	</ul>

    <div class="posts-found"></div>

    <?php do_action("ymc_after_filter_layout_".$id.'_'.$c_target); ?>

</div>



