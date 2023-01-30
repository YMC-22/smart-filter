<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class YMC_front_filters {

	public function __construct() {

		//add_filter('ymc_pagination_prev_text', array($this, 'ymc_pagination_prev_text'), 3, 1);
		//add_filter('ymc_pagination_next_text', array($this, 'ymc_pagination_next_text'), 3, 1);
		//add_filter('ymc_pagination_load_more', array($this, 'ymc_pagination_load_more'), 3, 1);
		//add_filter('ymc_post_date_format', array($this, 'ymc_post_date_format'), 3, 1);
		//add_filter('ymc_post_excerpt_length', array($this, 'ymc_post_excerpt_length'), 3, 1);
		//add_filter('ymc_post_read_more', array($this, 'ymc_post_read_more'), 3, 1);
		//add_filter('ymc_button_show_all', array($this, 'ymc_button_show_all'), 3, 1);

	}


	// Text prev button pagination
	//public function ymc_pagination_prev_text($button) {
	//	$button = 'Prev';
	//	return $button;
	//}

	// Text next button pagination
	//public function ymc_pagination_next_text($button) {
	//	$button = 'Next';
	//	return $button;
	//}

	// Text load more button pagination
	//public function ymc_pagination_load_more($button) {
	//	$button = 'Load More';
	//	return $button;
	//}

	// Date publish post
	//public function ymc_post_date_format($default) {
	//	return 'd, M Y';
	//}

	// Date excerpt post
	//public function ymc_post_excerpt_length($text) {
	//	return 30;
	//}

	// Button Read More
	//public function ymc_post_read_more($text) {
	//	return 'Read More';
	//}

	// Button Show All
	//public function ymc_button_show_all($text) {
	//	return 'All';
	//}

}

