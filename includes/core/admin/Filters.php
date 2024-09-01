<?php

namespace YMC_Smart_Filters\Core\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Filters {

	/**
	 * Constructor for initializing filters.
	 */
	public function __construct() {

		add_filter('ymc_filter_layouts',array($this, 'ymc_filter_layouts'), 3, 1);
		add_filter('ymc_post_layouts', array($this, 'ymc_post_layouts'), 3, 1);
		add_filter('ymc_pagination_type', array($this, 'ymc_pagination_type'), 3, 1);
		add_filter('ymc_order_post_by', array($this, 'ymc_order_post_by'), 3, 1);
		add_filter('ymc_filter_font', array($this, 'ymc_filter_font'), 3, 1);
		add_filter('ymc_post_font', array($this, 'ymc_post_font'), 3, 1);

	}

	/**
	 * Filters and returns an array of different layouts with their corresponding labels.
	 *
	 * @return array Associative array of layout keys and their labels
	 */
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


	/**
	 * Filters and returns an array of different post layouts with their corresponding labels.
	 *
	 * @param array $layout The existing layout array.
	 * @return array Associative array of post layout keys and their labels
	 */
	public function ymc_post_layouts($layout) {

		$layout = [
			"post-layout1" => __('Grid Layout Standard','ymc-smart-filter'),
			"post-layout2" => __('Grid Layout Mini','ymc-smart-filter'),
			"post-masonry" => __('Masonry Layout','ymc-smart-filter'),
			"post-layout3" => __('Full Width','ymc-smart-filter'),
			"post-carousel-layout" => __('Carousel Layout','ymc-smart-filter'),
			"post-vi-timeline" => __('Vertical Timeline','ymc-smart-filter'),
			"post-custom-layout"  =>  __('Custom Layout','ymc-smart-filter'),
			"post-custom-masonry" => __('Custom Masonry Layout','ymc-smart-filter')
		];

		return $layout;
	}


	/**
	 * Get an array of pagination types with their corresponding labels.
	 *
	 * @return array
	 */
	public function ymc_pagination_type($type) {
		$type = [
			"numeric" => __('Numeric', 'ymc-smart-filter'),
			"load-more" => __('Load more', 'ymc-smart-filter'),
			"scroll-infinity" => __('Scroll infinity', 'ymc-smart-filter')
		];

		return $type;
	}


	/**
	 * Generates an array of order options with their corresponding translated labels.
	 *
	 * @return array The array of order options with translated labels
	 */
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


	/**
	 * Filter and return an array of fonts with their respective labels.
	 *
	 * @param string $font The font to be filtered.
	 * @return array An array of fonts with their respective labels.
	 */
	public function ymc_filter_font($font) {
		$font = [
			"inherit" => __('Inherit','ymc-smart-filter'),
			"OpenSans" =>  __('OpenSans','ymc-smart-filter'),
			"Roboto" =>  __('Roboto','ymc-smart-filter'),
			"PlayfairDisplay" =>  __('Playfair Display','ymc-smart-filter')
		];

		return $font;
	}


	/**
	 * Returns an array of available fonts with their corresponding localized names.
	 *
	 * @return array Array of fonts with localized names
	 */
	public function ymc_post_font($font) {
		$font = [
			"inherit" => __('Inherit','ymc-smart-filter'),
			"OpenSans" =>  __('OpenSans', 'ymc-smart-filter'),
			"Roboto" =>  __('Roboto', 'ymc-smart-filter'),
			"PlayfairDisplay" =>  __('Playfair Display', 'ymc-smart-filter')
		];

		return $font;
	}

}