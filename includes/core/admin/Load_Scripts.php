<?php

namespace YMC_Smart_Filters\Core\Admin;

use YMC_Smart_Filters\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Load_Scripts {

	/**
	 * Init.
	 *
	 * Initialize Scripts CSS & JS.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	public function __construct() {

		add_action( 'admin_enqueue_scripts', [ $this, 'backend_embed_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_embed_css' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_embed_scripts' ],999999 );
	}

	// Backend enqueue scripts & style.
	public function backend_embed_scripts() {

		wp_enqueue_style( 'codemirror-css-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/css/codemirror/codemirror.css', array(), YMC_SMART_FILTER_VERSION);
		wp_enqueue_style( 'codemirror-theme-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/css/codemirror/eclipse.css', array(), YMC_SMART_FILTER_VERSION);
		wp_enqueue_style( 'codemirror-hint-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/css/codemirror/show-hint.css', array(), YMC_SMART_FILTER_VERSION);

		wp_enqueue_style( 'filter-grids-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/css/admin.css', array(), YMC_SMART_FILTER_VERSION);
		wp_enqueue_style('thickbox');

		wp_enqueue_script('thickbox');
		wp_enqueue_script( 'wp-color-picker');

		wp_enqueue_script( 'codemirror-js'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/codemirror/codemirror.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_enqueue_script( 'codemirror-css-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/codemirror/codemirror-css.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_enqueue_script( 'codemirror-show-hint-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/codemirror/show-hint.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_enqueue_script( 'codemirror-css-hint-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/codemirror/css-hint.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_enqueue_script( 'codemirror-autorefresh-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/codemirror/autorefresh.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_enqueue_script( 'codemirror-placeholder-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/codemirror/placeholder.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_enqueue_script( 'codemirror-javascript-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/codemirror/javascript.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_enqueue_script( 'codemirror-javascript-hint-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/codemirror/javascript-hint.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );

		wp_enqueue_script( 'clipboard-js-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/clipboard.min.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_enqueue_script( 'filter-grids-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/admin.min.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_localize_script( 'filter-grids-'.$this->generate_handle(), '_smart_filter_object',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce'    => wp_create_nonce(Plugin::$instance->token_b),
				'current_page' => 1,
				'path' => YMC_SMART_FILTER_URL
			));
	}

	// Frontend enqueue scripts & style.
	public function frontend_embed_scripts() {

		wp_enqueue_script( 'filter-grids-masonry-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/masonry.js', array('jquery'), YMC_SMART_FILTER_VERSION, true);
		wp_enqueue_script( 'filter-grids-swiper-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/swiper.min.js', array('jquery'), YMC_SMART_FILTER_VERSION, true);
		wp_enqueue_script( 'jquery-ui-datepicker');
		wp_enqueue_script( 'filter-grids-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/script.min.js', array('jquery', 'wp-hooks'), YMC_SMART_FILTER_VERSION, true);
		wp_localize_script( 'filter-grids-' . $this->generate_handle(), '_smart_filter_object',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce'    => wp_create_nonce(Plugin::$instance->token_f),
				'current_page' => 1,
				'path' => YMC_SMART_FILTER_URL
			));

	}


	public function frontend_embed_css() {
		wp_enqueue_style( 'filter-datepicker-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/css/datepicker.css', array(), YMC_SMART_FILTER_VERSION);
		wp_enqueue_style( 'filter-swiper-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/css/swiper.min.css', array(), YMC_SMART_FILTER_VERSION);
		wp_enqueue_style( 'filter-grids-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/css/style.css', array(), YMC_SMART_FILTER_VERSION);
	}


	// Generate handle
	public function generate_handle() {
		return wp_create_nonce('filter-grids');
	}
}