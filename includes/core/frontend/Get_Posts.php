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

		add_action('wp_ajax_get_post_popup', array($this, 'get_post_popup'));
		add_action('wp_ajax_nopriv_get_post_popup', array($this, 'get_post_popup'));

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
		$sort_order  = $clean_data['sort_order'];
		$sort_orderby = $clean_data['sort_orderby'];
		$meta_params = $clean_data['meta_query'];
		$date_params = $clean_data['date_query'];
		$target_id   = $clean_data['target_id'];
		$choices_posts = $clean_data['choices_posts'];
		$exclude_posts = $clean_data['exclude_posts'];
		$meta_key = $clean_data['meta_key'];
		$class_animation = $clean_data['post_animation'];
		$letter = $clean_data['letter'];

		$paged = (int) $_POST['paged'];
		$id = (int) $filter_id;

		// Set variables & helpers
		require YMC_SMART_FILTER_DIR . '/includes/core/util/variables.php';
		require YMC_SMART_FILTER_DIR . '/includes/core/util/helper.php';

		$args = [
			'post_type' => $post_type,
			'post_status' => $ymc_post_status,
			'posts_per_page' => $per_page,
			'paged' => $paged,
			'orderby' => $ymc_order_post_by,
			'order' => $ymc_order_post_type,
		];


		// Convert Taxonomy & Terms to Array
		$taxonomy = !empty( $taxonomy ) ? explode(',', $taxonomy) : false;
		$terms    = !empty( $terms )    ? explode(',', $terms)    : false;


		if ( is_array($taxonomy) && is_array($terms) ) :

			$tax_qry = [ 'relation' => $tax_rel, ];

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

			$args['tax_query'] = $tax_qry;

		endif;


		// Meta Kye Sort Posts
		if( $ymc_order_post_by === 'meta_key' && !empty($ymc_meta_key) && !empty($ymc_meta_value) ) {
			$args['meta_key'] = $ymc_meta_key;
			$args['orderby']  = $ymc_meta_value;
		}

		// Multiple Sort Posts
		if( $ymc_order_post_by === 'multiple_fields' ) {

			$multiple_orderby = '';
			$multiple_order = '';
			$arr_multiple_sort = [];

			foreach($ymc_multiple_sort as $item) {

				foreach( $item as $key => $val ) {

					if($key === 'orderby') {
						$multiple_orderby = $val;
					}
					if($key === 'order') {
						$multiple_order = $val;
					}
					$arr_multiple_sort[$multiple_orderby] = $multiple_order;
				}
			}

			$args['orderby']  = $arr_multiple_sort;
			unset($args['order']);
		}

		if( !empty($keyword) ) {

			add_filter( 'posts_join', array($this,'search_join') );
			add_filter( 'posts_where',  array($this,'search_where') );
			add_filter( 'posts_distinct', array($this,'search_distinct') );

			$args['sentence'] = true;
			$args['s'] = trim($keyword);
		}

		// Choices Posts
		if( !empty($choices_posts) ) {

			if( $exclude_posts === 'off' ) {
				$args['post__in'] = explode(',', $choices_posts);
				$args['orderby'] = 'post__in';
			}
			else {
				$args['post__not_in'] = explode(',', $choices_posts);
			}
		}

		// API Sort Posts
		if( !empty($sort_order) && !empty($sort_orderby) ) :

			$args['orderby']  = $sort_orderby;
			$args['order']    = $sort_order;

			if( !empty($meta_key) ) {
				$args['meta_key'] = $meta_key;
			}
			else {
				unset($args['meta_key']);
			}

		endif;

		// API Meta Query
		if( !empty($meta_params) && is_array($meta_params) ) {

			$meta_query = [];

			foreach ( $meta_params as $array ) {

				if( array_key_exists('relation', $array) ) {
					$meta_query['relation'] = $array['relation'];
				}

				$meta_query[] = [
					'key' => $array['key'], // string
					'value' => $array['value'], // string / array
					'compare' => array_key_exists('compare', $array) ? $array['compare'] : 'IN',
					'type' => array_key_exists('type', $array) ? $array['type'] : 'CHAR'
				];
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

		// Alphabetical Filter
		if( !empty($letter) && $letter !== 'all' ) {
			$args['starts_with'] = $letter;
			add_filter( 'posts_where',  array($this,'alphabetical_where'),10,2 );
		}

		$query = new \WP_query($args);

		ob_start();

		if ( $query->have_posts() ) :

			$file_layout = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/post/" . $post_layout . ".php";

			// Layouts Posts
			if ( file_exists($file_layout) ) :
				include_once $file_layout;
				$message = 'Layout is OK';
			else :
				echo "<div class='ymc-error'>" . esc_html('Filter layout is not available.', 'ymc-smart-filter') . "</div>";
				$message = 'Filter layout is not available';
			endif;

			// Pagination
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
			$message = esc_html('No posts found','ymc-smart-filter');
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
			'paged' => $paged,
			'meta_query' => $meta_params,
			'date_query' => $date_params
		);

		wp_send_json($data);
	}

	public function search_join( $join ) {

		global $wpdb;

		$join .= " LEFT JOIN $wpdb->postmeta AS pm ON ID = pm.post_id ";

		return $join;
	}

	public function search_where( $where ) {

		global $wpdb;

		$where = preg_replace(
			"/\(\s*$wpdb->posts.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"($wpdb->posts.post_title LIKE $1) OR (pm.meta_value LIKE $1)", $where );

		return $where;
	}

	public function search_distinct( $where ) {

		return  'DISTINCT' ;
	}

	public function autocomplete_search() {

		if ( !wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce') ) exit;

		$output  = '';
		$phrase = trim(mb_strtolower(sanitize_text_field($_POST['phrase'])));
		$choices_posts = sanitize_text_field($_POST['choices_posts']);
		$exclude_posts = sanitize_text_field($_POST['exclude_posts']);
		$id = (int) $_POST['post_id'];
		$term_ids = !empty($_POST['terms_ids']) ? explode(',', sanitize_text_field($_POST['terms_ids'])) : "";

		$per_page  = -1;
		$total = 0;

		// Set variables
		require YMC_SMART_FILTER_DIR . '/includes/core/util/variables.php';

		add_filter( 'posts_join', array($this,'search_join') );
		add_filter( 'posts_where',  array($this,'search_where') );
		add_filter( 'posts_distinct', array($this,'search_distinct') );

		$args = [
			'post_type' => $ymc_cpt_value,
			'post_status' => 'publish',
			'posts_per_page' => $per_page,
			'orderby' => 'title',
			'order' => 'asc',
			'sentence' => true,
			's' => $phrase
		];

		// Taxonomy + Terms
		if ( is_array($tax_selected) && is_array($terms_selected) && $ymc_search_filtered_posts === "0" ) :

			$tax_qry = [ 'relation' => $tax_rel, ];

			foreach ($tax_selected as $tax) :

				foreach ($terms_selected as $term) :

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

			$args['tax_query'] = $tax_qry;

		endif;

		// Taxonomy + Selected Terms + Search Filtered by Posts
		if( is_array($tax_selected) && is_array($term_ids) && $ymc_search_filtered_posts === "1" ) :

			$tax_qry = [ 'relation' => $tax_rel, ];

			foreach ($tax_selected as $tax) :

				foreach ($term_ids as $term) :

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

			$args['tax_query'] = $tax_qry;

		endif;

		// Choices posts
		if( !empty($choices_posts) ) {

			if( $exclude_posts === 'off' ) {
				$args['post__in'] = explode(',', $choices_posts);
			}
			else {
				$args['post__not_in'] = explode(',', $choices_posts);
			}
		}

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
					         <a href="#" data-clue="'.strip_tags($markedText).'">' . $markedText . '...</a></li>';

				$title = null;
				$content = null;

			endwhile;

			$total = $query->found_posts;

		endif;

		$data = array(
			'data'   => $output,
			'total'  => $total,
			'disableAutocomplete' => (int) $ymc_autocomplete_state
		);

		wp_send_json($data);

	}

	public function alphabetical_where( $where, $query ) {

		global $wpdb;

		$starts_with = $query->get( 'starts_with' );

	    if ( $starts_with ) {
		    $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( $wpdb->esc_like( $starts_with ) ) . '%\'';
	    }
	    return $where;
	}

	public function get_post_popup() {

		if (!wp_verify_nonce($_POST['nonce_code'], 'custom_ajax_nonce')) exit;

		$output = '';
		$post_id = (int) $_POST['post_id'];
		$filter_id = $_POST['filter_id'];
		$target_id = $_POST['target_id'];

		$thumb_url = get_the_post_thumbnail_url( $post_id, 'full' );
		$title = get_the_title($post_id);

		$post = get_post( $post_id );
		$content = apply_filters('the_content', $post->post_content);

		$output .= '<article class="popup-content">';
		$output .=  '<img src="'.$thumb_url.'">';
		$output .= '<header class="title">'.$title.'</header>';
		$output .= '<div class="content">'.$content.'</div>';
		$output .= '</article>';

		$output = apply_filters('ymc_popup_custom_layout_'.$filter_id.'_'.$target_id, $output, $post_id);

		$data = array(
			'data'   => $output
		);

		wp_send_json($data);
	}

}

