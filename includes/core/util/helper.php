<?php

/**
 * Merges arrays based on termid match
 *
 * @param array $arr1 The first array to compare
 * @param array $arr2 The second array to compare
 * @return array|bool Merged array if terms match, false otherwise
 */
if( !function_exists('generalArrayMerging') )
{
	function generalArrayMerging( $arr1, $arr2 ) {

		$result = [];

		if( is_array($arr1) && is_array($arr2) ) {

			foreach ( $arr1 as $val1 ) {

				foreach ( $arr2 as $val2 ) {

					if( (int) $val1['termid'] === (int) $val2['termid'] ) {

						$result[] = array_merge($val1, $val2);

						break;
					}
				}
			}
			return $result;
		}

		return false;
	}
}


/**
 * Recursively converts an array to an object.
 *
 * @param array $array The array to convert
 * @param object $obj The object to store the converted values
 * @return object The object with converted values
 */
if( !function_exists('arrayConvertObject') )
{
	function arrayConvertObject( $array, &$obj ) {

		foreach ($array as $key => $term) {

			if ( is_array($term) )  {

				$obj->$key = new stdClass();
				arrayConvertObject($term, $obj->$key);
			}
			else  {
				$obj->$key = $term;
			}
		}
		return $obj;
	}
}


/**
 * Convert an array to an object recursively.
 *
 * @param array $array The array to convert to an object.
 * @return stdClass The object representation of the input array.
 */
if( !function_exists('arrayToObject') )
{
	function arrayToObject( $array ) {

		if( is_array($array) ) {

			$object = new stdClass();

			return arrayConvertObject($array,$object);
		}
		return [];
	}
}


/**
 * Set options for a specific term based on provided settings.
 *
 * @param array $termSettings The settings for the term.
 * @param int $termID The ID of the term to set options for.
 * @param string $bg_term The background color of the term.
 * @param string $color_term The text color of the term.
 * @param string $class_term The CSS class for styling the term.
 * @param bool $default_term_active The default state of the term.
 * @param string $counterame_term The name of the term.
 */
if( !function_exists('setOptionsTerm') )
{
	function setOptionsTerm( $termSettings, $termID, &$bg_term, &$color_term, &$class_term, &$default_term_active, &$counterame_term, &$hide_term='' )
	{
		$flag_terms_option = false;

		if( is_array($termSettings) && !empty($termSettings) )
		{
			foreach ( $termSettings as $term )
			{
				foreach ( $term as $key => $val)
				{
					if ( $key === 'termid' && (int) $termID === (int) $val )
					{
						$flag_terms_option = true;
					}
					if ( $key === 'bg' && $flag_terms_option )
					{
						$bg_term = $val;
					}
					if ( $key === 'color' && $flag_terms_option )
					{
						$color_term = $val;
					}
					if ( $key === 'class' && $flag_terms_option )
					{
						$class_term = $val;
					}
					if ( $key === 'default' && $flag_terms_option )
					{
						$default_term_active = $val;
					}
					if ( $key === 'name' && $flag_terms_option ) {
						$counterame_term = $val;
					}
					if ( $key === 'hide' && $flag_terms_option ) {
						$hide_term = $val;
					}
				}

				if( $flag_terms_option ) break;
			}
		}
	}
}

/**
 * Set options for icon based on icon settings and term ID.
 *
 * @param array $iconSettings The settings for the icon.
 * @param int $termID The ID of the term.
 * @param string $class_terms_align The class for alignment.
 * @param string $color_icon The color of the icon.
 * @return void
 */
if( !function_exists('setOptionsIcon') )
{
	function setOptionsIcon( $iconSettings, $termID, &$class_terms_align, &$color_icon )
	{
		$flag_terms_align = false;

		if( is_array($iconSettings) && !empty($iconSettings) )
		{
			foreach ( $iconSettings as $sub_terms_align )
			{
				foreach ( $sub_terms_align as $key => $val)
				{
					if ( $key === 'termid' && (int) $termID === (int) $val )
					{
						$flag_terms_align = true;
					}
					if ( $key === 'alignterm' )
					{
						$class_terms_align = $val;
					}
					if ( $key === 'coloricon' )
					{
						$color_icon = $val;
					}
				}

				if( $flag_terms_align ) break;
			}
		}
	}
}

/**
 * Sets the selected icon based on the term ID from the given class icon array.
 *
 * @param array $classIcon An array of class icons.
 * @param int $termID The term ID to match against the keys in the classIcon array.
 * @param string $term_icon The variable to store the selected icon HTML.
 * @param string $color_icon The color to apply to the selected icon.
 */
if( !function_exists('setSelectedIcon') )
{
	function setSelectedIcon( $classIcon, $termID, &$term_icon, &$color_icon )
	{
		if( is_array($classIcon) && !empty($classIcon) )
		{
			foreach ( $classIcon as $key => $val )
			{
				if( (int) $termID === (int) $key )
				{
					$term_icon = '<i class="'. $val .'" style="color: '. $color_icon .';"></i>';
					break;
				}
			}
		}
	}
}


/**
 * Sorts the given terms based on the provided direction.
 *
 * @param array $termsSelect The array of terms to be sorted.
 * @param string $dir The sorting direction, either 'asc' for ascending or 'desc' for descending.
 */
if( !function_exists('sortTaxTerms') )
{
	function sortTaxTerms( &$termsSelect, $dir ) {

		$tempArray = array();
		$tempArrayResult = array();

		foreach ( $termsSelect as $term )
		{
			$tempArray[get_term( $term )->term_id] = get_term( $term )->name;
		}

		( $dir === 'asc' ) ? asort($tempArray) : arsort($tempArray);

		foreach ( $tempArray as $key => $term )
		{
			$tempArrayResult[] = $key;
		}

		$termsSelect = $tempArrayResult;
	}
}


/**
 * Outputs debug information in a formatted manner.
 *
 * @param mixed $data The data to be debugged.
 * @param bool $flag Optional. Whether to use var_dump instead of print_r. Default false.
 */
/*
if( !function_exists('debugEntries') )
{
	function debugEntries( $data, $flag=false )
	{
		if( !$flag ) {
			echo '<pre class="debugCode">';
			print_r($data);
			echo '</pre>';
		}
		else {
			echo '<pre class="debugCode">';
			var_dump($data);
			echo '</pre>';
		}
		?>
	    <script>
            window.addEventListener("load", () => {
                if ( !window.debug_entries_moved ) {
                    window.debug_entries_moved = true;

                    const $container = document.createElement(`div`);
                    const $debugEntry = document.createElement(`div`);
                    const $button = document.createElement(`div`);
                    $container.classList.add(`ymc__debugger`);
                    $debugEntry.classList.add(`debug-entry`);
                    $button.classList.add(`control-button`);

                    $button.insertAdjacentHTML('afterBegin',`<i class="fas fa-minus" onclick="this.closest(\'.control-button\').nextElementSibling.classList.toggle(\'hideContent\');this.closest(\'.ymc__debugger\').classList.toggle(\'minified\')"></i>`);

                    $container.appendChild($button);

                    [...document.querySelectorAll(`.debugCode`)].forEach(($entry) => {
                        $debugEntry.appendChild($entry);
                    });

                    $container.appendChild($debugEntry);
                    document.body.appendChild($container);
                }
            });

	    </script>
        <?php
	}
}
*/


/**
 * Retrieves taxonomy styles configuration based on the provided taxonomy slug and settings.
 *
 * @param string $tax_slug The taxonomy slug to retrieve styles for.
 * @param array $settings The array of settings containing styles for different taxonomies.
 * @return array An array containing the background color, text color, and name of the taxonomy styles.
 */
if( !function_exists('taxonomyStylesConfig') ) :
	function taxonomyStylesConfig($tax_slug, $settings) {

		// Set Options Taxonomy
		if( !empty($settings) ) {

			$flag_tax_option = false;
			$taxArray = [];

			foreach ( $settings as $tax_opt ) {

				foreach ( $tax_opt as $key => $val) {

					if ( $key === 'slug' && $tax_slug === $val ) {
						$flag_tax_option = true;
					}
					if ( $key === 'bg' && $flag_tax_option ) {
						$taxArray['bg'] = $val;
					}
					if ( $key === 'color' && $flag_tax_option ) {
						$taxArray['color'] = $val;
					}
					if ( $key === 'name' && $flag_tax_option ) {
						$taxArray['name'] = $val;
					}
				}

				if( $flag_tax_option ) {break;}
			}

			return $taxArray;
		}

		return [];
	}

endif;


/**
 * Retrieves the term IDs of the hidden terms from the given options array.
 *
 * @param array $terms_options An array of term options.
 * @return array An array containing the term IDs of the hidden terms.
 */
if( !function_exists('getHiddenTerms') ) :
	function getHiddenTerms($terms_options) {
		if( !empty( $terms_options ) ) {
			$termArray = [];
			foreach ( $terms_options as $terms_opt ) {
				if( array_search('enabled', $terms_opt) !== false ) {
					$termArray[] = $terms_opt['termid'];
				}
			}
			return $termArray;
		}
		return [];
	}

endif;


/**
 * Retrieves the styles configuration for a specific term.
 *
 * @param int $term_id The ID of the term.
 * @param array $settings The settings array containing term styles.
 * @return array An array containing the term styles configuration.
 */
if( !function_exists('termStylesConfig') ) :
	function termStylesConfig($term_id, $settings) {

		// Set Options Term
		if( !empty($settings) ) {

			$flag_terms_option = false;
			$termArray = [];

			foreach ( $settings as $terms_opt ) {

				foreach ( $terms_opt as $key => $val) {

					if ( $key === 'termid' && $term_id === (int) $val ) {
						$flag_terms_option = true;
					}
					if ( $key === 'bg' && $flag_terms_option ) {
						$termArray['bg_term'] = $val;
					}
					if ( $key === 'color' && $flag_terms_option ) {
						$termArray['color_term'] = $val;
					}
					if ( $key === 'class' && $flag_terms_option ) {
						$termArray['class_term'] = $val;
					}
					if ( $key === 'default' && $flag_terms_option ) {
						$termArray['default_term'] = $val;
					}
					if ( $key === 'name' && $flag_terms_option ) {
						$termArray['name_term'] = $val;
					}
					if ( $key === 'hide' && $flag_terms_option ) {
						$termArray['hide_term'] = $val;
					}
				}

				if( $flag_terms_option ) {break;}
			}

			return $termArray;
		}

		return [];
	}

endif;


/**
 * Configures icon styles based on the provided term ID and settings.
 *
 * @param int $term_id The ID of the term to configure icon styles for.
 * @param array $settings The settings array containing icon style configurations.
 * @return array An array containing the configured icon styles.
 */
if( !function_exists('iconStylesConfig') ) :

	function iconStylesConfig($term_id, $settings) {

		// Set Options Term
		if( !empty($settings) ) {

			$flag_terms_align = false;
			$termArray = [];

			foreach ( $settings as $sub_terms_align ) {

				foreach ( $sub_terms_align as $key => $val) {

					if ( $key === 'termid' && $term_id === (int) $val ) {
						$flag_terms_align = true;
					}
					if ( $key === 'alignterm' && $flag_terms_align ) {
						$termArray['class_terms_align'] = $val;
					}
					if ( $key === 'coloricon' && $flag_terms_align ) {
						$termArray['color_icon'] = $val;
					}
					if ( $key === 'classicon' && $flag_terms_align ) {
						$termArray['class_icon'] = $val;
					}
				}

				if( $flag_terms_align ) {break;}
			}

			return $termArray;
		}

		return [];
	}

endif;


/**
 * Renders a hierarchical list of terms based on the provided term ID and taxonomy.
 *
 * @param int $termID The ID of the term.
 * @param string $taxonomy The taxonomy of the terms.
 * @param int $counter The current depth level of the hierarchy.
 * @param array $arrayTermsOptions An array containing additional options for the terms.
 * @param string $order The order in which the terms should be retrieved.
 * @return string The HTML output of the hierarchical list of terms.
 */
if( !function_exists('hierarchyTermsOutput') )
{
	function  hierarchyTermsOutput($termID, $taxonomy, $counter = 0, $arrayTermsOptions = [])
	{
		/**
		 * Description variable $arrayTermsOptions:
		 *
		 * ['style_icon'] => Array of icon styles
		 * ['selected_icon'] => Array icons selected
		 * ['style_term'] => Array of terms styles
		 * ['selected_terms'] => Array of selected terms
		 * ['order_terms'] => (String) Term sorting type (ASC or DESC or Manual)
		 * ['manual_sort'] => Array of terms to be sorted
		 *
		 */

		++$counter;

		$list = get_categories_tree($termID, $taxonomy, $arrayTermsOptions['order_terms'], $arrayTermsOptions['manual_sort']);

		if( !empty($list) )
		{

			$output = '<ul class="sub_item sub_item_'.$counter.'">';

			foreach ( $list as $term )
			{

				// Options Term
				$bg_term          = '';
				$color_term       = '';
				$class_term       = '';
				$default_term     = '';
				$name_term        = '';

				// Options Icon
				$color_icon   = '';
				$class_icon   = '';

				// Set Selected Icon
				$terms_icons  = '';

				// Set Selected Terms
				$sl1 = '';

				$termStylesArray = termStylesConfig($term->term_id, $arrayTermsOptions['style_term']);

				$iconStylesArray = iconStylesConfig($term->term_id, $arrayTermsOptions['style_icon']);

				$terms_sel = $arrayTermsOptions['selected_terms'];

				if( is_array($terms_sel) && count($terms_sel) > 0 ) {

					if ( in_array($term->term_id, $terms_sel) ) {
						$sl1 = 'checked';
					}
					else{ $sl1 = ''; }
				}

				// Set Options Term
				if( !empty($termStylesArray) )
				{
					$bg_term = $termStylesArray['bg_term'];
					$color_term = $termStylesArray['color_term'];
					$class_term = $termStylesArray['class_term'];
					$name_term = $termStylesArray['name_term'];
					$hide_term = !empty($termStylesArray['hide_term']) ? $termStylesArray['hide_term'] : '';
					$default_term = $termStylesArray['default_term'];
				}

				// Set Options Icon
				if( !empty($iconStylesArray) )
				{
					$class_terms_align = $iconStylesArray['class_terms_align'];
					$color_icon = $iconStylesArray['color_icon'];
					$class_icon = $iconStylesArray['class_icon'];
				}

				// Set Selected Icon
				if( !empty($arrayTermsOptions['selected_icon']) )
				{
					foreach ( $arrayTermsOptions['selected_icon'] as $key => $val )
					{
						if( $term->term_id === (int) $key )
						{
							$style_color_icon = ( !empty($color_icon) ) ? 'style="color: '.$color_icon.'"' : '';
							$terms_icons = '<i class="'. $val .'" '. $style_color_icon .'"></i>
											<input name="ymc-terms-icons['. $key .']" type="hidden" value="'. $val .'">';
							break;
						}
					}
				}

				$class_terms_align = ( !empty($class_terms_align ) ) ? $class_terms_align : 'left-icon';

				$style_bg_term = ( !empty($bg_term) ) ? 'background-color:'.$bg_term.';' : '';
				$style_color_term = ( !empty($color_term) ) ? 'color:'.$color_term.';' : '';
				$name_term = ( !empty($name_term) ) ? $name_term : $term->name;


				$output .= '<li class="sub_item_'.$counter.'__elem">';

				$output .= '<div class="item-inner" style="'. esc_attr($style_bg_term) . esc_attr($style_color_term) .'"				
							data-termid="'. esc_attr($term->term_id) .'" 
			                data-alignterm="'. esc_attr($class_terms_align) .'" 
			                data-bg-term="'. esc_attr($bg_term) .'" 
			                data-color-term="'. esc_attr($color_term) .'" 
			                data-custom-class="'. esc_attr($class_term) .'" 
			                data-color-icon="'. esc_attr($color_icon) .'"
			                data-class-icon="'. esc_attr($class_icon) .'"
			                data-status-term="'. esc_attr($sl1) .'"  
			                data-name-term="'. esc_attr($name_term) .'"
			                data-hide-term="'. esc_attr($hide_term) .'"
			                data-default-term="'. esc_attr($default_term) .'">';

				$output .= '<i class="fas fa-grip-vertical handle_nested"></i>';

				$output .= '<input name="ymc-terms[]" class="category-list" id="category-id-'. esc_attr($term->term_id) .'" type="checkbox" value="'. esc_attr($term->term_id) .'" '. esc_attr($sl1) .'>';

				$output .= '<label for="category-id-'. esc_attr($term->term_id) .'" class="category-list-label">';

				$output .= '<span class="name-term">' . esc_html($name_term) .'</span>'. ' ['. esc_html($term->count) .']</label>';

				$output .= '<i class="far fa-ellipsis-v choice-icon" title="Tag settings"></i><span class="indicator-icon">'. $terms_icons .'</span></div>';

				// Depth 3
				if( $counter <= 2 ) {
					$output .= hierarchyTermsOutput($term->term_id, $taxonomy, $counter, $arrayTermsOptions);
				}

				$output .= '</li>';
			}

			$output .= '</ul>';

			return $output;
		}

		return '';
	}
}


/**
 * Retrieve the hierarchical tree of categories based on the parent category ID.
 *
 * @param int $parent The ID of the parent category.
 * @param string $taxonomy The taxonomy to retrieve categories from (default is 'category').
 * @param string $order The order of the categories ('asc' for ascending, 'desc' for descending, 'manual' for manual sort).
 * @param array $manual_sort An array of term IDs to specify manual sorting order.
 * @return array An array of category objects representing the hierarchical tree of categories.
 */
if( !function_exists('get_categories_tree') ) :
	function get_categories_tree( $parent, $taxonomy = 'category', $order = 'asc', $manual_sort = [] )
	{
		$terms = get_terms([
			'taxonomy' => $taxonomy,
			'parent' => $parent,
			'hide_empty' => false,
			'order' => ( $order === 'manual' ) ? 'asc' : $order
		]);

		if (empty($terms) || $terms instanceof WP_Error) {
			return [];
		}

		// Manual Sort Terms
		if( is_array($manual_sort) && !empty($manual_sort) && $order === 'manual' )
		{
			$temp_array = [];
			$temp_no_exist = [];
			foreach( $terms as $term )
			{
				$key = array_search($term->term_id, $manual_sort);
				if( $key !== false )
				{
					$temp_array[$key] = $term;
				}
				else {
					$temp_no_exist[] = $term;
				}
			}
			if( count($temp_no_exist) > 0 ) {
				foreach ($temp_no_exist as $term) {
					array_push($temp_array, $term);
				}
			}
			ksort($temp_array);
			$terms = $temp_array;
		}

		$categories = [];

		foreach ($terms as $term)
		{
			$categories[] = (object) [
				'term_id' => $term->term_id,
				'name' => $term->name,
				'slug' => $term->slug,
				'count' => $term->count,
				'parent' => $term->parent,
				'children' => get_children_categories($term->term_id),
			];
		}

		return $categories;
	}

endif;


/**
 * Retrieves the children categories of a given parent term ID.
 *
 * @param int $parent_term_id The ID of the parent term.
 * @return array An array of objects representing the children categories.
 */
if( !function_exists('get_children_categories') ) :
	function get_children_categories($parent_term_id)
	{

		$child_terms = get_terms([
			'taxonomy' => 'category',
			'parent' => $parent_term_id,
			'hide_empty' => false
		]);

		$children = [];

		foreach ($child_terms as $child_term) {
			$child = (object) [
				'term_id' => $child_term->term_id,
				'name' => $child_term->name,
				'value' => $child_term->term_id,
			];

			$grandchildren = get_children_categories($child_term->term_id);
			if (!empty($grandchildren)) {
				$child->children = $grandchildren;
			}

			$children[] = $child;
		}

		return $children;
	}

endif;


/**
 * Recursively generates a hierarchical terms layout based on the provided term ID and taxonomy.
 *
 * @param int $termID The ID of the term to start the hierarchy from.
 * @param string $taxonomy The taxonomy of the terms.
 * @param int $counter The current depth level of the hierarchy.
 * @param array $arrayTermsOptions Additional options for terms and icons.
 *
 * @return string The HTML representation of the hierarchical terms layout.
 */
if( !function_exists('hierarchyTermsLayout') ) :
	function hierarchyTermsLayout($termID, $taxonomy, $counter = 0, $arrayTermsOptions = [])
	{

		/**
		 * Description variable $arrayTermsOptions:
		 * ['multiple']
		 * ['terms_align']
		 * ['terms_options']
		 * ['terms_icons']
		 * ['terms_selected']
		 * ['terms_order']
		 * ['filter_layout']
		 */

		++$counter;

		$list = get_categories_tree($termID, $taxonomy, $arrayTermsOptions['terms_order'], $arrayTermsOptions['terms_selected']);

		if( !empty($list) )
		{
			$output = '<ul class="sub_item sub_item_'.$counter.'">';

			foreach ($list as $term)
			{
				// Options Term
				$bg_term = '';
				$color_term = '';
				$class_term = '';
				$default_term_active = '';
				$name_term = '';
				$hide_term = '';

				// Options Icon
				$class_terms_align = '';
				$color_icon = '';

				// Set Selected Icon
				$terms_icons = '';

				// Hierarchy Terms
				$class_hierarchy = '';
				$arrow = '';
				$listDropdownLayouts = ['filter-layout3', 'filter-layout4'];

				// Set Options for Icon
				setOptionsIcon( $arrayTermsOptions['terms_align'], $term->term_id, $class_terms_align, $color_icon );

				// Set Options Term
				setOptionsTerm( $arrayTermsOptions['terms_options'],
					$term->term_id,
					$bg_term,
					$color_term,
					$class_term,
					$default_term_active,
					$name_term,
					$hide_term );

				// Hide term ( exclude term )
				if($hide_term === 'enabled') continue;

				// Selected Icon for Term
				setSelectedIcon( $arrayTermsOptions['terms_icons'], $term->term_id, $terms_icons, $color_icon );

				$bg_term = ( !empty($bg_term) ) ? 'background-color:'.$bg_term.';' : '';
				$color_term = ( !empty($color_term) ) ? 'color:'.$color_term.';' : '';
				$default_term_active = ( $default_term_active === 'checked' ) ? 'active': '';
				$name_term = ( !empty($name_term) ) ? $name_term : $term->name;

				if( !empty($term->children) && $counter <= 2 ) {
					$class_hierarchy = 'item-has-children';
					$arrow = '<span class="fas fa-chevron-down isArrow"></span>';
				}

				$is_disabled = ( $term->count === 0 ) ? 'isDisabled' : '';

				$output .= '<li class="filter-item '.$class_hierarchy.'">';
				$output .= '<a class="filter-link menu-link '.
				            esc_attr($arrayTermsOptions['multiple']).' '.
				            esc_attr($class_terms_align).' '.
				            esc_attr($class_term).' '.
				            esc_attr($is_disabled).' '.
				            esc_attr($default_term_active) .'"
				            style="'.esc_attr($bg_term).esc_attr($color_term).'" 
							href="#" data-selected="'.esc_attr($term->slug).'" data-termid="'.esc_attr($term->term_id).'" data-name="'.esc_attr($name_term).'">'.
				            $terms_icons . '<span class="link-inner">'. esc_html($name_term) . '</span></a>';

				$output .= ( in_array($arrayTermsOptions['filter_layout'], $listDropdownLayouts) ) ? $arrow : '';

				// Depth 3
				if( $counter <= 2 ) {
					$output .= hierarchyTermsLayout($term->term_id, $taxonomy, $counter, $arrayTermsOptions);
				}
				$output .= '</li>';
			}

			$output .= '</ul>';

			return $output;
		}

		return '';
	}

endif;


/**
 * Debug in Console
 */
if ( !function_exists( 'js_console_log' ) ) {
	function js_console_log( $x, $as_text = true ) {
		$str = '<div class="php-to-js-console-log" style="display: none !important;" data-as-text="' . esc_attr( (bool) $as_text ) .
		       '" data-variable="' . htmlspecialchars( wp_json_encode( $x ) ) . '">' . htmlspecialchars( var_export( $x, true ) ) . '</div>';
		echo wp_kses($str, ['div' => ['class' => true, 'style' => true, 'data-as-text' => true, 'data-variable' => true]]);
	}
	
	if ( function_exists( 'js_console_log' ) ) {
		add_action( 'wp_footer', function () {
			echo '<script type="text/javascript">jQuery(document).ready(function ($) { 
    		$(".php-to-js-console-log").each(function (i, el) { let $e = $(el); console.log("PHP debug is below:"); 
            (!$e.attr("data-as-text")) ? console.log(JSON.parse($e.attr("data-variable"))) : console.log($e.text()); }); });</script>';
		}, 99999 );
	}
}


/**
 * Hide Empty Term
 * @param $termID ID Term
 * @return mixed
 */
if ( !function_exists( 'hideEmptyTerm' ) ) :
	function hideEmptyTerm($termID) {

		if( empty($termID) ) return;

		$objectTerm = get_term($termID);

		if( !is_wp_error($objectTerm) && !is_null($objectTerm) && $objectTerm->count !== 0 ) return $termID;
	}

endif;

/**
 * Auto Populate All Terms
 * @param array $taxonomy List taxonomies.
 * @param bool $hide_empty Hide empty terms.
 * @param string $orderby Order by.
 * @param string $order Order.
 * @return array Return array iDs terms or empty array
 * @return array|WP_Error Array of terms, or WP_Error if any of the taxonomies do not exist.
 *
 */
if ( !function_exists( 'autoPopulateAllTerms' ) ) :
	function autoPopulateAllTerms($taxonomy, $hide_empty = true, $orderby = 'name', $order = 'ASC') {

		if( !is_array($taxonomy) ) return;

		$all_terms = [];

		$terms = get_terms([
			'taxonomy'   => $taxonomy,
			'hide_empty' => $hide_empty,
			'orderby' => $orderby,
			'order' => $order
		]);

		if( $terms && ! is_wp_error( $terms ) ) {
			foreach($terms as $term) {
				$all_terms[] = $term->term_id;
			}
		}

		return $all_terms;
	}

endif;

