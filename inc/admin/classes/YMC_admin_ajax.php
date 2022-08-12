<?php

class YMC_admin_ajax {

	public function __construct() {

		add_action('wp_ajax_ymc_get_taxonomy',array($this,'ymc_get_taxonomy'));
		add_action("wp_ajax_nopriv_ymc_get_taxonomy",array($this,"ymc_get_taxonomy"));

		add_action('wp_ajax_ymc_get_terms',array($this,'ymc_get_terms'));
		add_action("wp_ajax_nopriv_ymc_get_terms", array($this,"ymc_get_terms"));

		add_action('wp_ajax_ymc_tax_sort',array($this,'ymc_tax_sort'));
		add_action("wp_ajax_nopriv_ymc_tax_sort", array($this,"ymc_tax_sort"));

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
		foreach ($data_object as $val) {
			$arr_result[$val->name] = $val->label;
		}

		update_post_meta( (int) $_POST["post_id"], 'ymc_tax_sort', $data_slugs );

		$data = array(
			'data' => json_encode($arr_result)
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

			$id = update_post_meta( (int) $_POST["post_id"], 'ymc_tax_sort', $clean_data );
		}

		$data = array(
			'updated' => $id
		);

		wp_send_json($data);

	}

}

new YMC_admin_ajax();