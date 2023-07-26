<?php

namespace YMC_Smart_Filters\Core\Admin;

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

		wp_enqueue_style( 'smart-filter-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/css/admin.css', array(), YMC_SMART_FILTER_VERSION);
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script( 'smart-filter-'.$this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/admin.min.js', array( 'jquery' ), YMC_SMART_FILTER_VERSION, true );
		wp_localize_script( 'smart-filter-'.$this->generate_handle(), '_smart_filter_object',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce'    => wp_create_nonce('custom_ajax_nonce'),
				'current_page' => 1,
				'path' => YMC_SMART_FILTER_URL
			));
	}

	// Frontend enqueue scripts & style.
	public function frontend_embed_scripts() {

		wp_enqueue_script( 'smart-filter-masonry-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/masonry.js', array('jquery'), YMC_SMART_FILTER_VERSION, true);
		wp_enqueue_script( 'smart-filter-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/js/script.min.js', array('jquery', 'wp-hooks'), YMC_SMART_FILTER_VERSION, true);
		wp_localize_script( 'smart-filter-' . $this->generate_handle(), '_smart_filter_object',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce'    => wp_create_nonce('custom_ajax_nonce'),
				'current_page' => 1,
				'path' => YMC_SMART_FILTER_URL
			));

	}


	public function frontend_embed_css() {
		wp_enqueue_style( 'smart-filter-' . $this->generate_handle(), YMC_SMART_FILTER_URL . 'includes/assets/css/style.css', array(), YMC_SMART_FILTER_VERSION);
	}


	// Generate handle
	public function generate_handle() {
		return wp_create_nonce('smart-filter');
	}
}