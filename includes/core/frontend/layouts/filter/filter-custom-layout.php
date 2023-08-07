<?php // Custom Filter Layout

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Function array merging options
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

// Function recursively converts an array to an object
function arrayConvertObject( $array, &$obj ) {

	foreach ($array as $key => $value) {

		if ( is_array($value) )  {

			$obj->$key = new stdClass();
			arrayConvertObject($value, $obj->$key);
		}
		else  {
			$obj->$key = $value;
		}
	}
	return $obj;
}

// Create object stdClass
function arrayToObject( $array ) {

	if( is_array($array) ) {

		$object = new stdClass();

		return arrayConvertObject($array,$object);
	}
	return false;
}

$arraySettings = generalArrayMerging( $ymc_terms_options, $ymc_terms_align );

$options_terms = ( arrayToObject( $arraySettings ) ) ? arrayToObject( $arraySettings ) : [];

?>

<div id="<?php echo esc_attr($ymc_filter_layout) . esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo $c_target; ?> ">

	<?php

        do_action("ymc_before_filter_layout_".$id.'_'.$c_target."");

        if ( is_array($terms_selected) && is_array($tax_selected) ) {

				/**
				 * Creating a custom filter template
				 * @param {string} layout - HTML markup
				 * @param {array} terms - list ids terms
				 * @param {array} tax - list sorted slugs taxonomies
				 * @param {int} multiple - multiple or single selection of posts (0/1)
                 * @param {string} target - name class target element
                 * @param {array} optionsTerms - array of objects of term settings:
					 - optionsTerms['termid'] - term ID
					 - optionsTerms['bg'] - background term. Hex Color Codes (ex: #dd3333)
					 - optionsTerms['color'] - color term. Hex Color Codes (ex: #dd3333)
					 - optionsTerms['class'] - custom name class of the term
					 - optionsTerms['alignterm'] - align icon in term (left, right)
					 - optionsTerms['coloricon'] - color icon
					 - optionsTerms['classicon'] - name class icon (Font Awesome Icons)
					 - optionsTerms['status'] - term status (selected or not)
				 * @returns {string} HTML markup filter bar
				 */


                $target = '.data-target-ymc'.$c_target;
	            $multiple = (int) $ymc_multiple_filter;

                if( !is_null($tax_sort)) {
                    $result_tax = [];
                    foreach($tax_sort as $val) {
                        if(array_search($val, $tax_selected) !== false) {
                            $result_tax[array_search($val, $tax_selected)] = $val;
                        }
                    }
                }
                else {
                    $result_tax = $tax_selected;
                }


		        if( !is_null($term_sort) && $ymc_sort_terms === 'manual' )  {
			        $result_terms = [];
			        foreach( $terms_selected as $termID ) {
				        $key = array_search($termID, $term_sort);
				        $result_terms[$key] = $termID;
			        }
			        ksort($result_terms);
		        }
		        else {
			        ( $ymc_sort_terms === 'asc' ) ? asort($terms_selected) : arsort($terms_selected);
			        $result_terms = $terms_selected;
		        }

                $layout  = '<div class="cf-wrp"><header class="head-filter">'.esc_html__('Add custom filter layout.','ymc-smart-filter').'</header>';
				$layout .= '<div class="inform">'. esc_html__('Use a filter:','ymc-smart-filter') .' 
                            <span class="doc-text">ymc_filter_custom_layout_'.$id.'_'.$c_target.'</span> 
                            '. esc_html__('Example:','ymc-smart-filter') .' 
                            <span class="doc-text">add_filter("ymc_filter_custom_layout_"'.$id.'_'.$c_target.', "func_custom_layout", 10, 5);</span>
                            <a target="_blank" href="https://github.com/YMC-22/smart-filter">'.esc_html__('See documentation.','ymc-smart-filter').'</a></div></div>';



				$filter_layout = apply_filters('ymc_filter_custom_layout_'.$id.'_'.$c_target,
                                     $layout,
									 $result_terms,
					                 $result_tax,
					                 $multiple,
                                     $target,
									 $options_terms
									);

				echo $filter_layout;

			}

		do_action("ymc_after_filter_layout_".$id.'_'.$c_target."");

   ?>

</div>
