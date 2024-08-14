<?php

namespace YMC_Smart_Filters\Core\Frontend;

use YMC_Smart_Filters\Plugin;
use YMC_Smart_Filters\Core\Admin\Filters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Get_Posts {

	/**
	 * Constructor for initializing the Get_Posts class.
	 *
	 * This constructor sets up the necessary actions for AJAX endpoints.
	 */
	public function __construct() {

		add_action('wp_ajax_ymc_get_posts', array($this, 'get_filter_posts'));
		add_action('wp_ajax_nopriv_ymc_get_posts', array($this, 'get_filter_posts'));

		add_action('wp_ajax_ymc_autocomplete_search', array($this, 'autocomplete_search'));
		add_action('wp_ajax_nopriv_ymc_autocomplete_search', array($this, 'autocomplete_search'));

		add_action('wp_ajax_get_post_popup', array($this, 'get_post_popup'));
		add_action('wp_ajax_nopriv_get_post_popup', array($this, 'get_post_popup'));
	}


	/**
	 * Processing all ajax filter requests.
	 * @return void
	 */
	public function get_filter_posts() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], Plugin::$instance->token_f) ) exit;

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
		$filter_date = $clean_data['filter_date'];
		$target_id   = $clean_data['target_id'];
		$choices_posts = $clean_data['choices_posts'];
		$exclude_posts = $clean_data['exclude_posts'];
		$meta_key = $clean_data['meta_key'];
		$class_animation = $clean_data['post_animation'];
		$letter = $clean_data['letter'];
		$custom_args = null;

		$paged = (int) $_POST['paged'];
		$id = (int) $filter_id;
		$tax_qry = null;

		// Set variables & helpers
		require YMC_SMART_FILTER_DIR . '/includes/core/util/variables.php';
		require YMC_SMART_FILTER_DIR . '/includes/core/util/helper.php';

		$post_types = ! empty( $post_type ) ? explode(',', $post_type) : 'post';

		$per_page = ( $post_layout === 'post-carousel-layout' ) ? -1 : $per_page;

		$args = [
			'post_type' => $post_types,
			'post_status' => $ymc_post_status,
			'posts_per_page' => $per_page,
			'paged' => $paged,
			'orderby' => $ymc_order_post_by,
			'order' => $ymc_order_post_type,
		];

		// Convert Taxonomy & Terms to Array
		$taxonomy = ! empty( $taxonomy ) ? explode(',', $taxonomy) : false;
		$terms    = ! empty( $terms )    ? explode(',', $terms)    : false;

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

			foreach( $ymc_multiple_sort as $item ) {

				foreach( $item as $key => $val ) {

					if( $key === 'orderby' ) {
						$multiple_orderby = $val;
					}
					if( $key === 'order' ) {
						$multiple_order = $val;
					}
					$arr_multiple_sort[$multiple_orderby] = $multiple_order;
				}
			}

			$args['orderby']  = $arr_multiple_sort;
			unset($args['order']);
		}

		// Search Posts
		if( !empty($keyword) ) {

			add_filter( 'posts_join', array($this,'search_join') );
			add_filter( 'posts_where',  array($this,'search_where') );
			add_filter( 'posts_distinct', array($this,'search_distinct') );

			$args['sentence'] = true;

			$args['exact'] = $ymc_exact_phrase;

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

		// Filter Date
		if( !empty($filter_date) ) {

			// Array Date Params
			// 0 - Action
			// 1 - From Date
			// 2 - To Date
			$dataDateParams = explode(',', $filter_date);

			switch ( $dataDateParams[0] ) {

				case 'today':
					$today = getdate();
					$date_query[] = [
						'year'     => $today['year'],
						'monthnum' => $today['mon'],
						'day'      => $today['mday']
					];
					break;

				case 'yesterday':
					$today = getdate();
					$date_query[] = [
						'year'     => $today['year'],
						'monthnum' => $today['mon'],
						'day'      => $today['mday'] - 1
					];
					break;

				case '3_days':
					$date_query[] = [
						'after'     => '3 days ago',
						'inclusive' => true,
					];
					break;

				case 'week':
					$date_query[] = [
						'after'     => '7 days ago',
						'inclusive' => true,
					];
					break;

				case 'month':
					$date_query[] = [
						'after'     => '30 days ago',
						'inclusive' => true,
					];
					break;

				case 'year':
					$date_query[] = [
						'after' => '1 year ago',
						'inclusive' => true,
					];
					break;

				case 'other':

					$date_query[] = [
						'before' => [
							'year'  => date('Y', $dataDateParams[2]),
							'month' => date('m', $dataDateParams[2]),
							'day'   => date('d', $dataDateParams[2]),
						],
						'after'  => [
							'year'  => date('Y', $dataDateParams[1]),
							'month' => date('m', $dataDateParams[1]),
							'day'   => date('d', $dataDateParams[1]),
						],
						'inclusive' => true
					];
					break;

				default :
					$date_query = [];
					break;
			}

			$args['date_query'] = $date_query;
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

		// Suppress Filters
		if( (int) $ymc_suppress_filters === 1 ) {
			$args['suppress_filters'] = true;
		}

		// Alphabetical Filter
		if( !empty($letter) && $letter !== 'all' ) {
			$args['starts_with'] = $letter;
			add_filter( 'posts_where',  array($this,'alphabetical_where'),10,2 );
		}


		// Custom WP Query
		if( $ymc_advanced_query_status === 'on' )
		{
			if( $ymc_query_type === 'query_custom' )
			{
				if( !empty($ymc_query_type_custom) )
				{
					$args = null;

					$str_args = sanitize_text_field(urldecode($ymc_query_type_custom));

					parse_str($str_args, $output_array);

					$custom_args = $output_array;

					$args = $output_array;

					$args['paged'] = $paged;
				}
				else {
					$custom_args = 'Arguments not exist';
				}
			}

			if( $ymc_query_type === 'query_callback' )
			{
				if( function_exists(''. $ymc_query_type_callback .'' ) )
				{
					$atts = [ 'cpt' => $post_types, 'tax' => $taxonomy, 'term' => $terms ];

					$custom_args =  $ymc_query_type_callback( $atts );

					if( is_array( $custom_args ) )
					{
						$intersect_keys_array = array_intersect_key($custom_args, $args); // Intersection of array keys

						$diff_keys_array = array_diff_key($custom_args, $args); // Difference between array keys

						foreach ( $intersect_keys_array as $key => $val )
						{
							$args[$key] = $val;
						}

						foreach ( $diff_keys_array as $key => $val )
						{
							$args[$key] = $val;
						}
					}
					else {
						$custom_args = 'Function \'' . $ymc_query_type_callback . '\' returns an invalid value. Must be an array.';
					}

					$args['paged'] = $paged;
				}
				else
				{
					$custom_args = 'Function \'' . $ymc_query_type_callback . '\' not exist';
				}
			}
		}

		$query = new \WP_query($args);

		ob_start();

		if ( $query->have_posts() ) :

			$file_layout = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/post/" . $post_layout . ".php";

			// Post Layout
			if ( file_exists($file_layout) && in_array($post_layout, $this->whitelist_post_layouts($post_layout)) ) :
				include_once $file_layout;
				$message = 'Post Layout is available';
			else :
				echo "<div class='ymc-error'>" . esc_html__('Post Layout is not available.', 'ymc-smart-filter') . "</div>";
				$message = 'Post Layout is not available';
			endif;

			// Pagination
			if( $ymc_pagination_hide === "off" ) :

				switch ( $type_pagination ) :

					case 'load-more' :
						$pagin = Plugin::instance()->pagination->load_more( $query, $paged, $type_pagination, $filter_id, $target_id, $ymc_pagination_elements );
						break;

					default :
						$pagin = Plugin::instance()->pagination->number( $query, $paged, 'numeric', $filter_id, $target_id, $ymc_pagination_elements );

				endswitch;

			endif;

		else :
			echo "<div class='ymc-notification'>" . esc_html($ymc_empty_post_result, 'ymc-smart-filter') . "</div>";
			$message = esc_html__('No posts found','ymc-smart-filter');
		endif;

		$output .= ob_get_contents();
		ob_end_clean();

		$posts_selected = "{$query->found_posts} posts selected";
		$posts_found = $query->found_posts;
		$default_posts_selected = apply_filters('ymc_posts_selected_'.$filter_id.'_'.$target_id, $posts_selected, $posts_found);

		$data = [
			'data' => $output,
			'posts_selected' => $default_posts_selected,
			'found' => $query->found_posts,
			'max_num_pages' => $query->max_num_pages,
			'post_count' => $query->post_count,
			'get_current_posts' => ($query->found_posts - $paged * $per_page),
			'pagin' => $pagin,
			'paged' => $paged
		];

		if( (int) $ymc_debug_code === 1 )
		{
			$data = array_merge(
				$data, [
				'debug' => [
					'post_type' => $post_type,
					'tax' => $taxonomy,
					'term' => $tax_qry,
					'meta_query' => $meta_params,
					'date_query' => $date_params,
					'wp_query_custom' => $custom_args,
					'wp_query' => $args,
					'message' => $message,
					'all_incoming_data' => $clean_data
				]
			]);
		}

		wp_send_json($data);
	}

	/**
	 * Whitelist post layouts based on the given post layout.
	 *
	 * @param string $post_layout The post layout to be whitelisted.
	 * @return array The whitelisted post layouts.
	 */
	public function whitelist_post_layouts($post_layout) {

		$filters = new Filters();

		return array_keys( $filters->ymc_post_layouts($post_layout) );
	}

	/**
	 * Modify the SQL JOIN statement to include the postmeta table for custom meta data retrieval.
	 *
	 * @param string $join The existing SQL JOIN statement.
	 * @return string The modified SQL JOIN statement.
	 */
	public function search_join( $join ) {

		global $wpdb;

		$join .= " LEFT JOIN $wpdb->postmeta AS pm ON ID = pm.post_id ";

		return $join;
	}

	/**
	 * Modify the WHERE clause of the SQL query to include postmeta table for custom meta data search.
	 *
	 * @param string $where The existing WHERE clause of the SQL query.
	 * @return string The modified WHERE clause including the postmeta table search condition.
	 */
	public function search_where( $where ) {

		global $wpdb;

		$where = preg_replace(
			"/\(\s*$wpdb->posts.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"($wpdb->posts.post_title LIKE $1) OR (pm.meta_value LIKE $1)", $where );

		return $where;
	}

	/**
	 * Returns the DISTINCT keyword used in SQL queries.
	 *
	 * @param array $where An array of conditions for the query
	 * @return string The DISTINCT keyword
	 */
	public function search_distinct( $where ) {

		return  'DISTINCT' ;
	}

	/**
	 * Perform autocomplete search based on user input.
	 *
	 * This function retrieves search results based on the provided search phrase, chosen posts, and excluded posts.
	 * It also takes into account selected taxonomy and terms for filtering.
	 * The search results are formatted with highlighted matching phrases.
	 *
	 * @return void Outputs JSON response with search results
	 */
	public function autocomplete_search() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], Plugin::$instance->token_f) ) exit;

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
			'exact' => $ymc_exact_phrase,
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

				if( empty($term_ids) ) :

					$term_ids = $terms_selected;

				endif;

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

			while ($query->have_posts()) : $query->the_post();

				$title = mb_strtolower(strip_tags(get_the_title(get_the_ID())));
				$content = mb_strtolower(strip_tags(get_the_content(get_the_ID())));

				$content = preg_replace('/\[.*?\]/', '', $content);
				$content = preg_replace('/&lt;.*?&gt;/', '', $content);

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

				$output  .= '<li class="result is-result">
					         <a href="#" data-clue="'. $phrase .'">' . $markedText . '</a></li>';

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

	/**
	 * Add condition to filter posts alphabetically based on starting letter of post title.
	 *
	 * @param string $where The WHERE clause of the query.
	 * @param WP_Query $query The WP_Query object.
	 * @return string The modified WHERE clause.
	 */
	public function alphabetical_where( $where, $query ) {

		global $wpdb;

		$starts_with = $query->get( 'starts_with' );

	    if ( $starts_with ) {
		    $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( $wpdb->esc_like( $starts_with ) ) . '%\'';
	    }
	    return $where;
	}

	/**
	 * Retrieves and displays the content for a popup based on the provided post ID, filter ID, and target ID.
	 */
	public function get_post_popup() {

		if ( ! isset($_POST['nonce_code']) || ! wp_verify_nonce($_POST['nonce_code'], Plugin::$instance->token_f) ) exit;

		$output = '';
		$post_id = (int) $_POST['post_id'];
		$filter_id = $_POST['filter_id'];
		$target_id = $_POST['target_id'];

		$title = get_the_title($post_id);

		$post = get_post( $post_id );
		$content = apply_filters('the_content', $post->post_content);

		$output .= '<article class="popup-content">';

		if( has_post_thumbnail($post_id) ) :
			$output .=  '<figure class="image-inner"><img src="'. get_the_post_thumbnail_url( $post_id, 'full' ) .'"></figure>';
		endif;

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

