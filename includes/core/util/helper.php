<?php

/*
 * Function array merging terms options
 * @return Array
 */

if( !function_exists('generalArrayMerging') ) {
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


/*
 * Function recursively converts an array to an object
 * @return Object
 */
if( !function_exists('arrayConvertObject') ) {
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
}


/*
 * Function create object stdClass
 */
if( !function_exists('arrayToObject') ) {
	function arrayToObject( $array ) {

		if( is_array($array) ) {

			$object = new stdClass();

			return arrayConvertObject($array,$object);
		}
		return [];
	}
}


/*
 * Set Options Term
 * @param {array} $termSettings - Array Settings Term
 * @param {string} $termID - Term ID
 * @param {string} $bg_term - Background Term
 * @param {string} $color_term - Color Term
 * @param {string} $class_term - Class Term
 * @param {string} $name_term - Custom Name Term
 * @param {string} $default_term_active - Default Selected Term
 */
if( !function_exists('setOptionsTerm') )
{
	function setOptionsTerm( $termSettings, $termID, &$bg_term, &$color_term, &$class_term, &$default_term_active, &$name_term )
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
						$name_term = $val;
					}
				}

				if( $flag_terms_option ) break;
			}
		}
	}
}

/*
 * Set Options Icon
 * @param {array} $iconSettings - Array Settings Term
 * @param {string} $termID - Term ID
 * @param {string} $class_terms_align - Class Align Icon
 * @param {string} $color_icon - Color Icon
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

/*
 * Set Selected Icon & Color Term
 * @param {array} $classIcon - Class Icon
 * @param {string} $termID - Term ID
 * @param {string} $term_icon - HTML Icon
 * @param {string} $color_icon - Color Icon
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
if( !function_exists('sortTaxTerms') ) {
	function sortTaxTerms( &$termsSelect, $dir ) {

		$tempArray = array();
		$tempArrayResult = array();

		foreach ( $termsSelect as $term )
		{
			$tempArray[get_term( $term )->term_id] = get_term( $term )->name;
		}

		( $dir === 'asc' ) ? asort($tempArray) : arsort($tempArray);

		foreach ( $tempArray as $key => $value )
		{
			$tempArrayResult[] = $key;
		}

		$termsSelect = $tempArrayResult;
	}
}


