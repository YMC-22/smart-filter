<?php

namespace YMCSFilters;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Plugin
 * Main Plugin class
 */

class YMC_Plugin {

	/**
	 * Instance
	 *
	 * @access private
	 * @static
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @access public
	 *
	 * @return YMC_Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {

		require_once YMC_SMART_FILTER_DIR . '/admin/classes/YMC_init.php';
		require_once YMC_SMART_FILTER_DIR . '/admin/classes/YMC_admin_load_scripts.php';
		require_once YMC_SMART_FILTER_DIR . '/admin/classes/YMC_meta_boxes.php';
		require_once YMC_SMART_FILTER_DIR . '/admin/classes/YMC_admin_ajax.php';

		require_once YMC_SMART_FILTER_DIR . '/front/classes/YMC_shortcode.php';
		require_once YMC_SMART_FILTER_DIR . '/front/classes/YMC_get_filter_posts.php';

	}

}

YMC_Plugin::instance();