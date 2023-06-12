<?php

namespace YMC_Smart_Filters\Core\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Filters {

	public function __construct() {

		add_filter('ymc_filter_layouts',array($this, 'ymc_filter_layouts'), 3, 1);
		add_filter('ymc_post_layouts', array($this, 'ymc_post_layouts'), 3, 1);
		add_filter('ymc_pagination_type', array($this, 'ymc_pagination_type'), 3, 1);
		add_filter('ymc_order_post_by', array($this, 'ymc_order_post_by'), 3, 1);
		add_filter('ymc_filter_font', array($this, 'ymc_filter_font'), 3, 1);
		add_filter('ymc_post_font', array($this, 'ymc_post_font'), 3, 1);

	}

	public function ymc_filter_layouts($layout) {

		$layout = [
			"filter-layout1" => 'Simple Posts Filter (merged taxonomies)',
			"filter-layout2" => 'Grouped Taxonomies Filter',
			"filter-layout3" => 'Dropdown Filter',
			"filter-custom-layout" => 'Custom Filter Layout',
		];

		return $layout;
	}

	public function ymc_post_layouts($layout) {

		$layout = [
			"post-layout1" => 'Style Layout 1',
			"post-layout2" => 'Style Layout 2',
			"post-layout3" => 'Style Layout 3',
			"post-custom-layout"  => 'Custom Post Layout'
		];

		return $layout;
	}

	public function ymc_pagination_type($type) {
		$type = [
			"numeric" => 'Numeric',
			"load-more" => 'Load more',
			"scroll-infinity" => 'Scroll infinity'
		];

		return $type;
	}

	public function ymc_order_post_by($order) {
		$order = [
			"title" => 'Title',
			"name" =>  'Name',
			"date" =>  'Date',
			"ID" =>    'ID',
			"author" => 'Author',
			"modified" => 'Modified',
			"type" => 'Type',
			"parent" => 'Parent',
			"rand" => 'Rand',
			"menu_order" => 'Menu Order',
			"meta_key" => "Meta Key",
			"multiple_fields" => "Multiple sort"
			//"multiple_meta_fields" => "Multiple Metafields Sort"
		];

		return $order;
	}

	public function ymc_filter_font($font) {
		$font = [
			"inherit" => 'Default',
			"OpenSans" =>  'OpenSans',
			"Roboto" =>  'Roboto',
			"PlayfairDisplay" =>    'Playfair Display'
		];

		return $font;
	}

	public function ymc_post_font($font) {
		$font = [
			"inherit" => 'Default',
			"OpenSans" =>  'OpenSans',
			"Roboto" =>  'Roboto',
			"PlayfairDisplay" =>    'Playfair Display'
		];

		return $font;
	}

}