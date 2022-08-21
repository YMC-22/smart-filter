<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pagin = new YMC_post_pagination();

switch ( $type_pagination ) :

	case 'numeric' :
			$pagin = $pagin->number($query, $paged, $type_pagination, $filter_id, $target_id);
		break;

	case 'load-more' :
			$pagin = $pagin->load_more($query, $paged, $type_pagination, $filter_id, $target_id);
		break;

	//  case 'scroll-infinity' :
	//  $pagin = $pagin->scroll_infinity($query, $paged, $type_pagination, $filter_id);
	//	break;

endswitch;
