<?php

class YMC_get_filter_posts {

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
		$post_type = $clean_data['cpt'];
		$taxonomy  = $clean_data['tax'];
		$terms     = $clean_data['terms'];
		$per_page  = $clean_data['per_page'];
		$post_layout = $clean_data['post_layout'];
		$filter_id = $clean_data['filter_id'];
		$type_pagination = $clean_data['type_pg'];
		$keyword = $clean_data['search'];
		$post_sel = $clean_data['post_sel'];

		$paged = (int) $_POST['paged'];

		$id = $filter_id;

		require_once YMC_SMART_FILTER_DIR . '/front/classes/YMC_front_filters.php';
		require_once YMC_SMART_FILTER_DIR . '/front/front-variables.php';

		$default_order_by = apply_filters('ymc_filter_posts_order_by', $ymc_order_post_by);
		$default_order    = apply_filters('ymc_filter_posts_order', $ymc_order_post_type);

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

				if( count($term_id) > 0 ) :

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

		$query = new WP_Query($args);

		ob_start();

		if ( $query->have_posts() ) :

			$file_layout = YMC_SMART_FILTER_DIR . "/front/layouts/post/" . $post_layout . ".php";
			require_once YMC_SMART_FILTER_DIR . "/front/classes/YMC_post_pagination.php";


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
			require_once YMC_SMART_FILTER_DIR . "/front/pagination/pagination.php";

		else :

			echo "<div class='ymc-notification'>" . esc_html($ymc_empty_post_result, 'ymc-smart-filter') . "</div>";
			$message = 'No posts found';

		endif;

		$output .= ob_get_contents();
		ob_end_clean();


		$data = array(
			'data' => $output,
			'found' => $query->found_posts,
			'message' => $message,
			'post_type' => $post_type,
			'tax' => $taxonomy,
			'term' => $tax_qry,
			'max_num_pages' => $query->max_num_pages,
			'get_current_posts' => ($query->found_posts - $paged * $per_page),
			'pagin' => !empty($pagin) ? $pagin : ''
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
		$phrase = trim(mb_strtolower(strip_tags($_POST['phrase'])));
		$post_type = $_POST['cpt'];
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


		$query = new WP_Query($args);

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

new YMC_get_filter_posts();