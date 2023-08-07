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

		add_action('wp_ajax_ymc_options_icons',array($this,'ymc_options_icons'));
		add_action("wp_ajax_nopriv_ymc_options_icons", array($this,"ymc_options_icons"));

		add_action('wp_ajax_ymc_updated_posts',array($this,'ymc_updated_posts'));
		add_action("wp_ajax_nopriv_ymc_updated_posts", array($this,"ymc_updated_posts"));

		add_action('wp_ajax_ymc_options_terms',array($this,'ymc_options_terms'));
		add_action("wp_ajax_nopriv_ymc_options_terms", array($this,"ymc_options_terms"));

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
		delete_post_meta( (int) $_POST["post_id"], 'ymc_terms_options' );
		delete_post_meta( (int) $_POST["post_id"], 'ymc_terms_icons' );
		delete_post_meta( (int) $_POST["post_id"], 'ymc_terms_align' );

		// Get posts
		$query = new \WP_query([
			'post_type' => $cpt,
			'orderby' => 'title',
			'order' => 'ASC',
			'posts_per_page' => -1
		]);

		$arr_posts = [];

		if ( $query->have_posts() ) {

			while ($query->have_posts()) {
				$query->the_post();
				$arr_posts[] = '<li><span class="ymc-rel-item ymc-rel-item-add" data-id="'.get_the_ID().'">ID: '.get_the_ID().'<br>'. get_the_title(get_the_ID()).'</span></li>';
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
			$idIcons = delete_post_meta( (int) $_POST["post_id"], 'ymc_terms_icons' );
			//$idAlign = delete_post_meta( (int) $_POST["post_id"], 'ymc_terms_align' );
		}

		$data = array(
			'deleteIcons' => $idIcons,
			'deleteAlign' => $idAlign
		);

		wp_send_json($data);

	}

	public function ymc_options_icons() {

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

	public function ymc_updated_posts() {

		$cpt = $_POST['cpt'];
		$tax = $_POST['tax'];
		$terms = $_POST['terms'];
		$output = '';

		$taxData   = str_replace("\\", "",$tax);
		$termsData   = str_replace("\\", "",$terms);

		$taxChecked  = json_decode($taxData, true);
		$termsChecked  = json_decode($termsData, true);

		$arg = [
			'post_type' => $cpt,
			'orderby' => 'title',
			'order' => 'ASC',
			'posts_per_page' => -1
		];

		if ( is_array($taxChecked) && is_array($termsChecked) && count($termsChecked) > 0 ) {

			$params_choices = [
				'relation' => 'OR'
			];

			foreach ( $taxChecked as $tax ) {

				$terms = get_terms([
					'taxonomy' => $tax,
					'hide_empty' => false
				]);

				if( $terms ) {

					$arr_terms_ids = [];

					foreach( $terms as $term ) {

						if( in_array($term->term_id, $termsChecked) ) {
							array_push($arr_terms_ids, $term->term_id);
						}
					}

					$params_choices[] = [
						'taxonomy' => $tax,
						'field'    => 'id',
						'terms'    => $arr_terms_ids
					];

					$arr_terms_ids = null;
				}
			}

			$arg['tax_query'] = $params_choices;
		}

		$query = new \WP_query($arg);

		if ( $query->have_posts() ) {

			while ($query->have_posts()) {

				$query->the_post();

				$output .= '<li><span class="ymc-rel-item ymc-rel-item-add" data-id="'.get_the_ID().'">ID: '.get_the_ID().'<br>'.get_the_title(get_the_ID()).'</span></li>';
			}
		}

		$data = array(
			'output' => $output,
			'found' => $query->found_posts
		);

		wp_send_json($data);

	}

	public function ymc_options_terms() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		$postedData = $_POST['params'];
		$tempData   = str_replace("\\", "",$postedData);
		$cleanData  = json_decode($tempData, true);

		if(isset($_POST["post_id"])) {
			$id = update_post_meta( (int) $_POST["post_id"], 'ymc_terms_options', $cleanData);
		}

		$data = array(
			'update' => $id
		);

		wp_send_json($data);

	}


}