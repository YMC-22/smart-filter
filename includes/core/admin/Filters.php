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
			"filter-layout1" => __('Default Filter','ymc-smart-filter'),
			"filter-layout2" => __('Grouped Filter','ymc-smart-filter'),
			"filter-layout3" => __('Dropdown Filter','ymc-smart-filter'),
			"filter-layout4" => __('Sidebar Filter','ymc-smart-filter'),
			"alphabetical-layout" => __('Alphabetical Navigation','ymc-smart-filter'),
			"filter-custom-layout" => __('Custom Filter Layout','ymc-smart-filter')
		];

		return $layout;
	}

	public function ymc_post_layouts($layout) {

		$layout = [
			"post-layout1" => __('Simple Layout','ymc-smart-filter'),
			"post-layout2" => __('Simple Layout 2','ymc-smart-filter'),
			"post-masonry" => __('Masonry Layout','ymc-smart-filter'),
			"post-layout3" => __('Full Width','ymc-smart-filter'),
			"post-custom-layout"  => 'Custom Layout',
			"post-custom-masonry" => 'Custom Masonry Layout'
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
			"PlayfairDisplay" =>  'Playfair Display'
		];

		return $font;
	}

}