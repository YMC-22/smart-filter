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
			"filter-layout5" => __('Dropdown Filter Compact','ymc-smart-filter'),
			"filter-date" => __('Filter Date','ymc-smart-filter'),
			"alphabetical-layout" => __('Alphabetical Navigation','ymc-smart-filter'),
			"filter-custom-layout" => __('Custom Filter Layout','ymc-smart-filter'),
			"filter-custom-extra-layout" => __('Custom Filter Extra Layout','ymc-smart-filter')
		];

		return $layout;
	}

	public function ymc_post_layouts($layout) {

		$layout = [
			"post-layout1" => __('Grid Layout Standard','ymc-smart-filter'),
			"post-layout2" => __('Grid Layout Mini','ymc-smart-filter'),
			"post-masonry" => __('Masonry Layout','ymc-smart-filter'),
			"post-layout3" => __('Full Width','ymc-smart-filter'),
			"post-vi-timeline" => __('Vertical Timeline','ymc-smart-filter'),
			"post-custom-layout"  =>  __('Custom Layout','ymc-smart-filter'),
			"post-custom-masonry" => __('Custom Masonry Layout','ymc-smart-filter')
		];

		return $layout;
	}

	public function ymc_pagination_type($type) {
		$type = [
			"numeric" => __('Numeric', 'ymc-smart-filter'),
			"load-more" => __('Load more', 'ymc-smart-filter'),
			"scroll-infinity" => __('Scroll infinity', 'ymc-smart-filter')
		];

		return $type;
	}

	public function ymc_order_post_by($order) {
		$order = [
			"title" => __('Title', 'ymc-smart-filter'),
			"name" =>  __('Name', 'ymc-smart-filter'),
			"date" =>  __('Date', 'ymc-smart-filter'),
			"ID" =>    __('ID', 'ymc-smart-filter'),
			"author" => __('Author', 'ymc-smart-filter'),
			"modified" => __('Modified', 'ymc-smart-filter'),
			"type" => __('Type','ymc-smart-filter'),
			"parent" => __('Parent','ymc-smart-filter'),
			"rand" => __('Rand','ymc-smart-filter'),
			"menu_order" => __('Menu Order','ymc-smart-filter'),
			"meta_key" => __("Meta Key",'ymc-smart-filter'),
			"multiple_fields" => __("Multiple sort",'ymc-smart-filter'),
			//"multiple_meta_fields" => "Multiple Metafields Sort"
		];

		return $order;
	}

	public function ymc_filter_font($font) {
		$font = [
			"inherit" => __('Default','ymc-smart-filter'),
			"OpenSans" =>  __('OpenSans','ymc-smart-filter'),
			"Roboto" =>  __('Roboto','ymc-smart-filter'),
			"PlayfairDisplay" =>  __('Playfair Display','ymc-smart-filter')
		];

		return $font;
	}

	public function ymc_post_font($font) {
		$font = [
			"inherit" => __('Default','ymc-smart-filter'),
			"OpenSans" =>  __('OpenSans', 'ymc-smart-filter'),
			"Roboto" =>  __('Roboto', 'ymc-smart-filter'),
			"PlayfairDisplay" =>  __('Playfair Display', 'ymc-smart-filter')
		];

		return $font;
	}

}