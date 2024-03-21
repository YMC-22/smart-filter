<?php

namespace YMC_Smart_Filters\Core\Admin;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cpt {

	const post_type = 'ymc_filters';

	public function __construct() {
		add_action( 'init', array( $this, 'register_ymc_post_type' ), 0 );
	}

	public function register_ymc_post_type() {

		register_post_type( self::post_type,
			array(
				'labels'              => array(
					'name'          => __( 'Filter & Grids', 'ymc-smart-filter' ),
					'singular_name' => __( 'Filter & Grids', 'ymc-smart-filter' ),
				),
				'public'              => false,
				'hierarchical'        => false,
				'exclude_from_search' => true,
				'show_ui'             => current_user_can( 'manage_options' ) ? true : false,
				'show_in_admin_bar'   => false,
				'menu_position'       => 7,
				'menu_icon'           => 'dashicons-layout',
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array(
					'title',
				),
			) );

		remove_post_type_support('ymc_filters', 'thumbnail');

		add_filter( 'manage_edit-ymc_filters_columns', function ( $columns ) {

			$columns = array(
				'cb' => '&lt;input type="checkbox" />',
				'title' => __( 'Title','ymc-smart-filter' ),
				'shortcode' => __( 'Shortcode Grid Posts', 'ymc-smart-filter' ),
				//'extra_filter' => __( 'Shortcode Extra Filter', 'ymc-smart-filter' ),
				//'extra_search' => __( 'Shortcode Extra Search', 'ymc-smart-filter' ),
				//'extra_sort' => __( 'Shortcode Extra Sort', 'ymc-smart-filter' ),
				'id' => __( 'ID', 'ymc-smart-filter' ),
				'date' => __( 'Date', 'ymc-smart-filter' )
			);

			return $columns;
		});

		add_action( 'manage_ymc_filters_posts_custom_column', function ($column, $post_id) {

			switch( $column ) {

				case 'shortcode' :
					echo '<input type="text" onclick="this.select();" value="[ymc_filter id=&quot;'.$post_id.'&quot;]" readonly="">';
					break;

				case 'extra_filter' :
					echo '<input type="text" onclick="this.select();" value="[ymc_extra_filter id=&quot;'.$post_id.'&quot;]" readonly="">';
					break;

				case 'extra_search' :
					echo '<input type="text" onclick="this.select();" value="[ymc_extra_search id=&quot;'.$post_id.'&quot;]" readonly="">';
					break;

				case 'extra_sort' :
					echo '<input type="text" onclick="this.select();" value="[ymc_extra_sort id=&quot;'.$post_id.'&quot;]" readonly="">';
					break;

				case 'id' :
					echo $post_id;
					break;

				default :
					break;
			}

		}, 10, 2);
	}

}