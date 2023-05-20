<?php

namespace YMC_Smart_Filters\Core\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ajax {

	public function __construct() {

		add_action('wp_ajax_ymc_get_taxonomy',array($this,'ymc_get_taxonomy'));
		add_action("wp_ajax_nopriv_ymc_get_taxonomy",array($this,"ymc_get_taxonomy"));

		add_action('wp_ajax_ymc_get_terms',array($this,'ymc_get_terms'));
		add_action("wp_ajax_nopriv_ymc_get_terms", array($this,"ymc_get_terms"));

		add_action('wp_ajax_ymc_tax_sort',array($this,'ymc_tax_sort'));
		add_action("wp_ajax_nopriv_ymc_tax_sort", array($this,"ymc_tax_sort"));

		add_action('wp_ajax_ymc_term_sort',array($this,'ymc_term_sort'));
		add_action("wp_ajax_nopriv_ymc_term_sort", array($this,"ymc_term_sort"));

		add_action('wp_ajax_ymc_delete_choices_posts',array($this,'ymc_delete_choices_posts'));
		add_action("wp_ajax_nopriv_ymc_delete_choices_posts", array($this,"ymc_delete_choices_posts"));

		add_action('wp_ajax_ymc_delete_choices_icons',array($this,'ymc_delete_choices_icons'));
		add_action("wp_ajax_nopriv_ymc_delete_choices_icons", array($this,"ymc_delete_choices_icons"));

		add_action('wp_ajax_ymc_terms_align',array($this,'ymc_terms_align'));
		add_action("wp_ajax_nopriv_ymc_terms_align", array($this,"ymc_terms_align"));

	}

	public function ymc_get_taxonomy() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		if(isset($_POST["cpt"])) {
			$cpt = sanitize_text_field($_POST["cpt"]);
		}
		if(isset($_POST["post_id"])) {
			update_post_meta( (int) $_POST["post_id"], 'ymc_taxonomy', '' );
			update_post_meta( (int) $_POST["post_id"], 'ymc_terms', '' );
		}

		$data_slugs  = get_object_taxonomies($cpt);
		$data_object = get_object_taxonomies($cpt, $output = 'objects');

		$arr_result = [];
		// Exclude Taxonomies WooCommerce
		$arr_exclude_slugs = ['product_type','product_visibility','product_shipping_class'];

		foreach ($data_object as $val) {
			if(array_search($val->name, $arr_exclude_slugs) === false ) {
				$arr_result[$val->name] = $val->label;
			}
		}

		update_post_meta( (int) $_POST["post_id"], 'ymc_tax_sort', $data_slugs );
		delete_post_meta( (int) $_POST["post_id"], 'ymc_term_sort' );
		delete_post_meta( (int) $_POST["post_id"], 'ymc_choices_posts' );

		// Get posts
		$query = new \WP_query([
			'post_type' => $cpt,
			'orderby' => 'title',
			'order' => 'ASC'
		]);

		$arr_posts = [];

		if ( $query->have_posts() ) {

			while ($query->have_posts()) {
				$query->the_post();
				$arr_posts[] = '<li><span class="ymc-rel-item ymc-rel-item-add" data-id="'.get_the_ID().'">'.get_the_title(get_the_ID()).'</span></li>';
			}
			wp_reset_query();
		}

		$data = array(
			'data' => json_encode($arr_result),
			'lists_posts' => json_encode($arr_posts)
		);

		wp_send_json($data);

	}

	public function ymc_get_terms() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		if(isset($_POST["taxonomy"])) {
			$taxonomy = sanitize_text_field($_POST["taxonomy"]);
		}
		if($taxonomy) {
			$terms = get_terms([
				'taxonomy' => $taxonomy,
				'hide_empty' => false,
			]);
			$data['terms'] = $terms;
		}

		$data = array(
			'data' => $data
		);

		wp_send_json($data);

	}

	public function ymc_tax_sort() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		if(isset($_POST["tax_sort"])) {

			$temp_data = str_replace("\\", "", sanitize_text_field($_POST["tax_sort"]));
			$clean_data = json_decode($temp_data, true);
			$post_id = (int) sanitize_text_field($_POST["post_id"]);

			$id = update_post_meta( $post_id, 'ymc_tax_sort', $clean_data );
		}

		$data = array(
			'updated' => $id
		);

		wp_send_json($data);

	}

	public function ymc_term_sort() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		if(isset($_POST["term_sort"])) {

			$temp_data = str_replace("\\", "", sanitize_text_field($_POST["term_sort"]));
			$clean_data = json_decode($temp_data, true);
			$post_id = (int) sanitize_text_field($_POST["post_id"]);

			$id = update_post_meta( $post_id, 'ymc_term_sort', $clean_data );
		}

		$data = array(
			'updated' => $id
		);

		wp_send_json($data);

	}

	public function ymc_delete_choices_posts() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		if(isset($_POST["post_id"])) {
			$id = delete_post_meta( (int) $_POST["post_id"], 'ymc_choices_posts' );
		}

		$data = array(
			'delete' => $id
		);

		wp_send_json($data);

	}

	public function ymc_delete_choices_icons() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		if(isset($_POST["post_id"])) {
			$id = delete_post_meta( (int) $_POST["post_id"], 'ymc_terms_icons' );
		}

		$data = array(
			'delete' => $id
		);

		wp_send_json($data);

	}

	public function ymc_terms_align() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		$postedData = $_POST['params'];
		$tempData   = str_replace("\\", "",$postedData);
		$cleanData  = json_decode($tempData, true);

		if(isset($_POST["post_id"])) {
			$id = update_post_meta( (int) $_POST["post_id"], 'ymc_terms_align', $cleanData);
		}

		$data = array(
			'update' => $id
		);

		wp_send_json($data);
	}



}