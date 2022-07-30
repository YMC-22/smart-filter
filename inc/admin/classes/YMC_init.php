<?php

class YMC_init {

	const post_type = 'ymc_filters';

	public function __construct() {
		add_action( 'init', array( $this, 'register_ymc_post_type' ), 0 );
	}

	public function register_ymc_post_type() {

		register_post_type( self::post_type,
			array(
				'labels'              => array(
					'name'          => __( 'YMC Smart Filter', 'ymc-smart-filter' ),
					'singular_name' => __( 'YMC Smart Filter', 'ymc-smart-filter' ),
				),
				'public'              => false,
				'hierarchical'        => false,
				'exclude_from_search' => true,
				'show_ui'             => current_user_can( 'manage_options' ) ? true : false,
				'show_in_admin_bar'   => false,
				'menu_position'       => 7,
				'menu_icon'           => 'dashicons-schedule',
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array(
					'title',
				),
			) );
	}

}

new YMC_init();