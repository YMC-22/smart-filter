<?php

namespace YMC_Smart_Filters;

use YMC_Smart_Filters\Core\Admin\Ajax;
use YMC_Smart_Filters\Core\Admin\Cpt;
use YMC_Smart_Filters\Core\Admin\Filters;
use YMC_Smart_Filters\Core\Admin\Load_Scripts;
use YMC_Smart_Filters\Core\Admin\Meta_Boxes;
use YMC_Smart_Filters\Core\Admin\Variables;
use YMC_Smart_Filters\Core\Frontend\Get_Posts;
use YMC_Smart_Filters\Core\Frontend\Pagination;
use YMC_Smart_Filters\Core\Frontend\Shortcode;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Plugin {

	/**
	 * Instance
	 *
	 * @access public
	 * @static
	 */
	public static $instance = null;

	/**
	 * Ajax.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Ajax
	 */
	public $ajax;


	/**
	 * Assets loader.
	 *
	 * Holds the plugin assets loader responsible for conditionally enqueuing
	 * styles and script assets that were pre-enabled.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Load_Scripts
	 */
	public $assets_loader;

	/**
	 * Custom Post Type.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Cpt
	 */
	public $cpt;


	/**
	 * Meta Boxes.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Meta_Boxes
	 */
	public $meta_boxes;


	/**
	 * Admin Variables.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Variables
	 */
	public $variables;

	/**
	 * Shortcode.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Shortcode
	 */
	public $shortcode;


	/**
	 * Filters.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Filters
	 */
	public $filters;


	/**
	 * Posts.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Get_Posts
	 */
	public $get_posts;


	/**
	 * Pagination.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Pagination
	 */
	public $pagination;


	/**
	 * Token Frontend
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var $token_f
	 */
	public $token_f = 'fdd791b3fe1c045fceb0015140b2b70d';


	/**
	 * Token Backend
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var $token_b
	 */
	public  $token_b = '95f8938d2aed81d36fae20a754711c99';



	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @access public
	 *
	 * @return Plugin Filter An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function __construct() {

		// Init Plugin
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Initialize the plugin
	 *
	 * Fired by plugins_loaded action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		$this->register_autoloader();
		$this->init_components();
	}

	/**
	 * Register YmcCrossword_Autoloader
	 *
	 * Autoloader loads all the classes needed to run the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function register_autoloader() {
		require_once YMC_SMART_FILTER_DIR . 'includes/Autoloader.php';
		Autoloader::run();
	}


	/**
	 * Init components.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function init_components() {

		$this->cpt = new Cpt();
		$this->ajax = new Ajax();
		$this->variables = new Variables();
		$this->filters = new Filters();
		$this->assets_loader = new Load_Scripts();
		$this->meta_boxes = new Meta_Boxes();
		$this->shortcode = new Shortcode();
		$this->get_posts = new Get_Posts();
		$this->pagination = new Pagination();
	}

}

Plugin::instance();