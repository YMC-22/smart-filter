<?php

/*
 * Function array merging terms options
 * @return Array
 */
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


/*
 * Function recursively converts an array to an object
 * @return Object
 */
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


/*
 * Function create object stdClass
 */
function arrayToObject( $array ) {

	if( is_array($array) ) {

		$object = new stdClass();

		return arrayConvertObject($array,$object);
	}
	return [];
}

