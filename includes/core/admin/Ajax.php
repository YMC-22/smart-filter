<?php

namespace YMC_Smart_Filters\Core\Admin;

use YMC_Smart_Filters\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ajax {

	/**
	 * @var string
	 */
	public $token;

	/**
	 * Constructor for initializing the Ajax class.
	 */
	public function __construct() {

		// Set the token property
		$this->token = Plugin::$instance->token_b;

		add_action('wp_ajax_ymc_get_taxonomy',array($this, 'ymc_get_taxonomy'));

		add_action('wp_ajax_ymc_get_terms',array($this, 'ymc_get_terms'));

		add_action('wp_ajax_ymc_tax_sort',array($this, 'ymc_tax_sort'));

		add_action('wp_ajax_ymc_term_sort',array($this, 'ymc_term_sort'));

		add_action('wp_ajax_ymc_delete_choices_posts',array($this, 'ymc_delete_choices_posts'));

		add_action('wp_ajax_ymc_delete_choices_icons',array($this, 'ymc_delete_choices_icons'));

		add_action('wp_ajax_ymc_options_icons',array($this, 'ymc_options_icons'));

		add_action('wp_ajax_ymc_updated_posts',array($this, 'ymc_updated_posts'));

		add_action('wp_ajax_ymc_options_terms',array($this, 'ymc_options_terms'));

		add_action( 'wp_ajax_ymc_export_settings', array( $this, 'ymc_export_settings'));

		add_action( 'wp_ajax_ymc_import_settings', array( $this, 'ymc_import_settings'));

		add_action( 'wp_ajax_ymc_updated_taxonomy', array( $this, 'ymc_updated_taxonomy'));
	}

	/**
	 * Retrieves taxonomy data based on custom post types and sends JSON response.
	 */
	public function ymc_get_taxonomy() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

		if(isset($_POST["cpt"])) {
			$post_types = sanitize_text_field($_POST["cpt"]);
			$cpts = !empty( $post_types ) ? explode(',', $post_types) : false;
		}
		if(isset($_POST["post_id"])) {
			update_post_meta( (int) $_POST["post_id"], 'ymc_taxonomy', '' );
			update_post_meta( (int) $_POST["post_id"], 'ymc_terms', '' );
		}

		if( is_array($cpts) ) {

			$arr_tax_result = [];

			foreach ( $cpts as $cpt ) {

				$data_object = get_object_taxonomies($cpt, $output = 'objects');

				foreach ($data_object as $val) {

					$arr_tax_result[$val->name] = $val->label;

				}
			}
		}

		update_post_meta( (int) $_POST["post_id"], 'ymc_tax_sort', '' );
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
				$arr_posts[] = '<li><span class="ymc-rel-item ymc-rel-item-add" data-id="'.get_the_ID().'">
				<span class="postID">ID: '.get_the_ID().'</span> <span class="postTitle">'. get_the_title(get_the_ID()).'</span></span></li>';
			}
			wp_reset_query();
		}

		$data = array(
			'data' => json_encode($arr_tax_result),
			'lists_posts' => json_encode($arr_posts),
			'found_posts' => $query->found_posts
		);

		wp_send_json($data);
	}

	/**
	 * Retrieves and returns terms based on the provided taxonomy.
	 *
	 * This function first checks the nonce code for security.
	 * Then, it retrieves terms based on the taxonomy and sends the data as a JSON response.
	 */
	public function ymc_get_terms() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

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

	/**
	 * Retrieves and updates taxonomy data based on custom post types and sends JSON response.
	 */
	public function ymc_updated_taxonomy() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

		$arr_tax_result = [];

		if( isset($_POST["cpt"]) ) {

			$post_types = sanitize_text_field($_POST["cpt"]);
			$cpts = !empty( $post_types ) ? explode(',', $post_types) : false;
		}

		if( is_array($cpts) ) {

			foreach ( $cpts as $cpt ) {

				$data_object = get_object_taxonomies($cpt, $output = 'objects');

				foreach ($data_object as $val) {

					$arr_tax_result[$val->name] = $val->label;
				}
			}

			update_post_meta( (int) $_POST["post_id"], 'ymc_tax_sort', '' );
		}

		$data = array(
			'data' => $arr_tax_result,
		);

		wp_send_json($data);
	}

	/**
	 * Sorts and updates taxonomy data based on the provided data and sends a JSON response.
	 */
	public function ymc_tax_sort() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

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

	/**
	 * Sorts and updates terms based on the provided data and sends a JSON response.
	 */
	public function ymc_term_sort() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

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

	/**
	 * Deletes choices posts based on the provided post ID and sends a JSON response.
	 */
	public function ymc_delete_choices_posts() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

		if(isset($_POST["post_id"])) {
			$id = delete_post_meta( (int) $_POST["post_id"], 'ymc_choices_posts' );
		}

		$data = array(
			'delete' => $id
		);

		wp_send_json($data);
	}

	/**
	 * Delete the choices icons associated with a post.
	 */
	public function ymc_delete_choices_icons() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

		if(isset($_POST["post_id"])) {
			$idIcons = delete_post_meta( (int) $_POST["post_id"], 'ymc_terms_icons' );
		}

		$data = array(
			'deleteIcons' => $idIcons
		);

		wp_send_json($data);
	}

	/**
	 * Updates the post meta with the provided data for terms alignment and sends a JSON response.
	 */
	public function ymc_options_icons() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

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

	/**
	 * Handle updating posts based on the received data.
	 */
	public function ymc_updated_posts() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

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

				$output .= '<li><span class="ymc-rel-item ymc-rel-item-add" data-id="'.get_the_ID().'">
				<span class="postID">ID: '.get_the_ID().'</span> <span class="postTitle">'.get_the_title(get_the_ID()).'</span></span></li>';
			}
		}

		$data = array(
			'output' => $output,
			'found' => $query->found_posts
		);

		wp_send_json($data);
	}

	/**
	 * Updates the post meta with the provided data for terms options and sends a JSON response.
	 */
	public function ymc_options_terms() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

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

	/**
	 * Export settings to a JSON object.
	 */
	public function ymc_export_settings() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

		$post_id = sanitize_text_field($_POST["post_id"]);

		$need_options = [];
		$options = get_post_meta( $post_id );

		if( is_array($options) && !empty($options) )
		{
			foreach ( $options as $key => $value )
			{
				if( substr($key, 0, 4) === 'ymc_' )
				{
					if( $key !== 'ymc_custom_after_js' && $key !== 'ymc_custom_css'  )
					{
						foreach ( $value as $item ) {
							$val = maybe_unserialize($item);
							$need_options[$key] = $val;
						}
					}
					else {
						$need_options[$key] = '';
					}
				}
			}
		}

		$json_data = json_encode($need_options);

		echo $json_data;
		exit;
	}

	/**
	 * Processes the import of settings data and sends a JSON response.
	 */
	public function ymc_import_settings() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], $this->token) ) exit;

		$post_id = sanitize_text_field($_POST["post_id"]);
		$posted_data = $_POST['params'];
		$temp_data = str_replace("\\", "", $posted_data);
		$clean_data = json_decode($temp_data, true);
		$status = 0;

		if( is_array($clean_data) && count($clean_data) > 0 )
		{
			foreach ( $clean_data as $meta_key => $meta_value )
			{
				update_post_meta( $post_id, $meta_key, $meta_value );
			}

			$mesg = __('Imported settings successfully','ymc-smart-filter');
			$status = 1;
		}
		else {
			$mesg = __('Import of settings unsuccessful. Try again.','ymc-smart-filter');
		}

		$data = array(
			'status' => $status,
			'mesg' => $mesg,
			'data' => $clean_data
		);

		wp_send_json($data);
	}

}