<?php

namespace YMCSFilters;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**-------------------------------------------------------------------------------
 *    DEFINES
 * -------------------------------------------------------------------------------*/

if ( ! defined('YMC_SMART_FILTER_VERSION') ) {

	define( 'YMC_SMART_FILTER_VERSION', '1.2.4' );
}

if ( ! defined('YMC_SMART_FILTER_DIR') ) {

	define( 'YMC_SMART_FILTER_DIR', rtrim(__DIR__, ' /\\') );
}

if ( ! defined('YMC_SMART_FILTER_URL') ) {

	define( 'YMC_SMART_FILTER_URL', rtrim(plugin_dir_url( __FILE__ ), ' /\\') );
}


/**
 * Config YMC SMART FILTER
 */

final class YMC_smart_filters {

	/**
	 * Plugin Version
	 *
	 * @var string The plugin version.
	 */
	const VERSION = YMC_SMART_FILTER_VERSION;


	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}


	/**
	 * Initialize the plugin
	 *
	 * Validates that YMC_Smart_Filters is already loaded.
	 *
	 * Fired by plugins_loaded action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		require_once( YMC_SMART_FILTER_DIR . '/YMC_Plugin.php' );
	}
}

new YMC_smart_filters();











