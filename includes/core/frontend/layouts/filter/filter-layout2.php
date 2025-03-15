<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>


<div id="<?php echo  esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo  esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<?php
        do_action("ymc_before_filter_layout_".$id);
        do_action("ymc_before_filter_layout_".$id.'_'.$c_target);
	?>


	<ul class="filter-entry">

		<?php

            if ( is_array($terms_selected) )
			{
				$type_multiple = ( (bool) $ymc_multiple_filter ) ? 'multiple' : '';

	            // Options Term
	            $bg_term             = null;
	            $color_term          = null;
	            $class_term          = null;
	            $default_term_active = null;
	            $name_term           = null;

	            // Options Icon
	            $class_terms_align   = null;
	            $color_icon          = null;

	            // Set Selected Icon
	            $terms_icons         = null;


				if( $ymc_sort_terms !== 'manual' && ( $ymc_display_terms === 'selected_terms' || $ymc_display_terms  === 'hide_empty_terms' ) )
                {
	                sortTaxTerms($terms_selected, $ymc_sort_terms);
					//( $ymc_sort_terms === 'asc' ) ? sortTaxTerms($terms_selected, 'asc') : sortTaxTerms($terms_selected, 'desc');
				}

				$show_all = $ymc_post_elements['button_text_all'];
				$show_all = apply_filters('ymc_button_show_all_'.$id, $show_all);
				$show_all = apply_filters('ymc_button_show_all_'.$id.'_'.$c_target, $show_all);

	            $all_class_active = ( empty($default_terms) ) ? 'active' : '';

				echo '<li class="filter-item"><'.esc_attr($ymc_html_tag_button).' class="filter-link all '. esc_attr($all_class_active) .'" aria-label="'. esc_html($show_all) .'" role="button" data-selected="all" data-termid="' . esc_attr($ymc_terms) . '">'. esc_html($show_all) .'</'.esc_attr($ymc_html_tag_button).'></li>';

                $arr_taxonomies = [];
                foreach ($terms_selected as $term) {

                    $arr_taxonomies[] = ( ! is_wp_error( get_term( $term ) ) && ! is_null( get_term( $term ) ) ) ? get_term( $term )->taxonomy : null;
                }
                $arr_taxonomies = array_unique($arr_taxonomies);

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

	                $tax_name = apply_filters('ymc_tax_name_'.$id.'_'.$tax, $tax_name);
	                $tax_name = apply_filters('ymc_tax_name_'.$id.'_'.$c_target.'_'.$tax, $tax_name);

                    echo '<li class="group-filters tax-'.esc_attr($tax).'" style="'.esc_attr($style_tax_bg).esc_attr($style_tax_color).'">
                          <header class="name-tax">'. esc_html($tax_name) .'</header>
                          <ul class="sub-filters">';

					$terms_selected = array_diff($terms_selected, getHiddenTerms($ymc_terms_options));

					foreach ($terms_selected as $term)
					{
						$object_term = get_term( $term );

						if( is_wp_error( $object_term ) || is_null( $object_term ) ) continue;

                        if( $tax === $object_term->taxonomy )
						{
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

							$is_disabled = ( $object_term->count === 0 ) ? 'isDisabled' : '';

                            echo  "<li class='filter-item'>
                                   <".esc_attr($ymc_html_tag_button)." class='filter-link ".
                                   esc_attr($type_multiple) ." ".
                                   esc_attr($class_terms_align) ." ".
                                   esc_attr($is_disabled) ." ".
                                   esc_attr($class_term) . " ". esc_attr($default_term_active) . "' style='".
                                   esc_attr($bg_term) . esc_attr($color_term) ."' aria-label='". esc_html($name_term) ."' role='button' data-selected='" .
                                   esc_attr($object_term->slug) . "' data-termid='" .
                                   esc_attr($term) . "'>" . wp_kses_post($terms_icons) .
                                   '<span class="link-inner">'.esc_html($name_term) .'</span>'."</".esc_attr($ymc_html_tag_button)."></li>";
                        }

	                    $terms_icons = null;
						$name_term = '';
                    }

                    echo '</ul></li>';
                }

	            unset($result_tax);
            }
		?>

	</ul>

    <div class="posts-found"></div>

	<?php
        do_action("ymc_after_filter_layout_".$id);
        do_action("ymc_after_filter_layout_".$id.'_'.$c_target);
	?>

</div>


