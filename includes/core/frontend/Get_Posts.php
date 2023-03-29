<?php

namespace YMC_Smart_Filters\Core\Frontend;

use YMC_Smart_Filters\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Get_Posts {

	public function __construct() {
		add_action('wp_ajax_ymc_get_posts', array($this, 'get_filter_posts'));
		add_action('wp_ajax_nopriv_ymc_get_posts', array($this, 'get_filter_posts'));

		add_action('wp_ajax_ymc_autocomplete_search', array($this, 'autocomplete_search'));
		add_action('wp_ajax_nopriv_ymc_autocomplete_search', array($this, 'autocomplete_search'));
	}

	public function get_filter_posts() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		$output  = '';
		$message = '';

		$posted_data = $_POST['params'];
		$temp_data = str_replace("\\", "", $posted_data);
		$clean_data = json_decode($temp_data, true);

		// Get data from json
		$post_type   = $clean_data['cpt'];
		$taxonomy    = $clean_data['tax'];
		$terms       = $clean_data['terms'];
		$per_page    = $clean_data['per_page'];
		$post_layout = $clean_data['post_layout'];
		$filter_id   = $clean_data['filter_id'];
		$type_pagination = $clean_data['type_pg'];
		$keyword     = $clean_data['search'];
		$post_sel    = $clean_data['post_sel'];
		$sort_order  = $clean_data['sort_order'];
		$sort_orderby = $clean_data['sort_orderby'];
		$meta_params = $clean_data['meta_query'];
		$date_params = $clean_data['date_query'];
		$target_id   = $clean_data['target_id'];

		$paged = (int) $_POST['paged'];
		$id = $filter_id;

		// Set variables
		require YMC_SMART_FILTER_DIR . '/includes/core/util/variables.php';

		$default_order_by = apply_filters('ymc_filter_posts_order_by', $ymc_order_post_by);
		$default_order    = apply_filters('ymc_filter_posts_order', $ymc_order_post_type);

		if( !empty($sort_order) && !empty($sort_orderby) ) :
			$default_order_by = $sort_orderby;
			$default_order = $sort_order;
		endif;

		// Convert Taxonomy & Terms to Array
		$taxonomy = !empty( $taxonomy ) ? explode(',', $taxonomy) : false;
		$terms    = !empty( $terms )    ? explode(',', $terms)    : false;


		if ( is_array($taxonomy) && is_array($terms) ) :

			if( $post_sel === 'all' ) {
				$tax_qry = [ 'relation' => 'OR', ];
			}
			else {
				$tax_qry = [ 'relation' => $tax_rel, ];
			}

			foreach ($taxonomy as $tax) :

				foreach ($terms as $term) :

					if($tax === get_term( $term )->taxonomy) :
						$term_id[] = (int) $term;
					endif;

				endforeach;

				if( !empty($term_id) ) :

					$tax_qry[] = [
						'taxonomy' => $tax,
						'field' => 'term_id',
						'terms' => $term_id
					];

				endif;

				$term_id = [];

			endforeach;

		endif;


		$args = [
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => $per_page,
			'tax_query' => $tax_qry,
			'paged' => $paged,
			'orderby' => $default_order_by,
			'order' => $default_order,
		];

		if( !empty($keyword) ) {

			add_filter( 'posts_join', array($this,'search_join') );
			add_filter( 'posts_where',  array($this,'search_where') );
			add_filter( 'posts_distinct', array($this,'search_distinct') );

			$args['sentence'] = true;
			$args['s'] = trim($keyword);
		}

		// API Meta Query
		if( !empty($meta_params) && is_array($meta_params) ) {

			$meta_query = [];

			foreach ( $meta_params as $array ) {

				if( array_key_exists('relation', $array) ) {
					$meta_query['relation'] = $array['relation'];
				}
				else {
					$meta_query[] = [
						'key' => trim($array['key']),
						'value' => trim($array['value']),
						'compare' => array_key_exists('compare', $array) ? trim($array['compare']) : 'IN',
						'type' => array_key_exists('type', $array) ? trim($array['type']) : 'CHAR'
					];
				}
			}

			$args['meta_query'] = $meta_query;
		}

		// API Date Query
		if( !empty($date_params) && is_array($date_params) ) {

			$date_query = [];
			$sub_arr_date = [];

			foreach ( $date_params as $array ) {

				if( array_key_exists('relation', $array) ) {
					$date_query['relation'] = $array['relation'];
				}

				foreach ($array as $k => $v) {
					$sub_arr_date[$k] = $v;
				}

				$date_query[] = $sub_arr_date;
				$sub_arr_date = [];
			}

			$args['date_query'] = $date_query;
		}

		$query = new \WP_query($args);

		ob_start();

		if ( $query->have_posts() ) :

			$file_layout = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/post/" . $post_layout . ".php";

			// Add Layouts posts
			if ( file_exists($file_layout) ) :

				switch ( $post_layout ) :

					case  "post-layout1" :

						include_once $file_layout;

						break;

					case  "post-layout2" :

						include_once $file_layout;

						break;

					case  "post-layout3" :

						include_once $file_layout;

						break;

					case  "post-custom-layout" :

						include_once $file_layout;

						break;

				endswitch;

				$message = 'OK';

			else :

				echo "<div class='ymc-error'>" . esc_html('Filter layout is not available.', 'ymc-smart-filter') . "</div>";
				$message = 'Filter layout is not available';

			endif;

			// Add Pagination
			if( $ymc_pagination_hide === "off" ) :

				switch ( $type_pagination ) :

					case 'numeric' :
						$pagin = Plugin::instance()->pagination->number($query, $paged, $type_pagination, $filter_id, $target_id);
						break;

					case 'load-more' :
						$pagin = Plugin::instance()->pagination->load_more($query, $paged, $type_pagination, $filter_id, $target_id);
						break;

				endswitch;

			endif;

		else :

			echo "<div class='ymc-notification'>" . esc_html($ymc_empty_post_result, 'ymc-smart-filter') . "</div>";
			$message = 'No posts found';

		endif;

		$output .= ob_get_contents();
		ob_end_clean();

		$posts_selected = "{$query->found_posts} posts selected";
		$posts_found = $query->found_posts;
		$default_posts_selected = apply_filters('ymc_posts_selected_'.$filter_id.'_'.$target_id, $posts_selected, $posts_found);


		$data = array(
			'data' => $output,
			'posts_selected' => $default_posts_selected,
			'message' => $message,
			'post_type' => $post_type,
			'tax' => $taxonomy,
			'term' => $tax_qry,
			'found' => $query->found_posts,
			'max_num_pages' => $query->max_num_pages,
			'post_count' => $query->post_count,
			'get_current_posts' => ($query->found_posts - $paged * $per_page),
			'pagin' => !empty($pagin) ? $pagin : '',
			'meta_query' => $meta_params,
			'date_query' => $date_params
		);

		wp_send_json($data);
	}

	public function search_join( $join ) {

		global $wpdb;

		$join .= " LEFT JOIN $wpdb->postmeta ON ID = $wpdb->postmeta.post_id ";

		return $join;
	}

	public function search_where( $where ) {

		global $wpdb;

		$where = preg_replace(
			"/\(\s*$wpdb->posts.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"($wpdb->posts.post_title LIKE $1) OR ($wpdb->postmeta.meta_value LIKE $1)", $where );


		return $where;
	}

	public function search_distinct( $where ) {

		return  'DISTINCT' ;
	}

	public function autocomplete_search() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		$output  = '';
		$phrase = trim(mb_strtolower(sanitize_text_field($_POST['phrase'])));
		$post_type = sanitize_text_field($_POST['cpt']);
		$per_page  = -1;
		$total = 0;

		add_filter( 'posts_join', array($this,'search_join') );
		add_filter( 'posts_where',  array($this,'search_where') );
		add_filter( 'posts_distinct', array($this,'search_distinct') );

		$args = [
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => $per_page,
			'orderby' => 'title',
			'order' => 'asc',
			'sentence' => true,
			's' => $phrase
		];


		$query = new \WP_Query($args);

		if ( $query->have_posts() ) :

			$title   = '';
			$content = '';

			while ($query->have_posts()) : $query->the_post();

				$title .= mb_strtolower(strip_tags(get_the_title(get_the_ID())));
				$content .= mb_strtolower(strip_tags(get_the_content(get_the_ID())));

				$pos_title = mb_strpos($title, $phrase);
				$pos_content = mb_strpos($content, $phrase);

				if ($pos_title !== false) {
					$cut_text = mb_substr($title, $pos_title,  strlen($phrase) + 70);
				}
				else if($pos_content !== false) {
					$cut_text = mb_substr($content, $pos_content,  strlen($phrase) + 70);
				}
				else {
					$cut_text = mb_substr($title, $pos_title,  strlen($phrase) + 70);
				}



				$pattern = "/((?:^|>)[^<]*)(".preg_quote($phrase).")/is";
				$replace = '$1<b>$2</b>';
				$markedText = preg_replace($pattern, $replace, $cut_text);

				$output  .= '<li class="is-result">
					         <a target="_blank" href="'.get_the_permalink(get_the_ID()).'">' . $markedText . '...</a></li>';

				$title = null;
				$content = null;

			endwhile;

			$total = $query->found_posts;

		endif;


		$data = array(
			'data'   => $output,
			'total'  => $total
		);

		wp_send_json($data);

	}

}

