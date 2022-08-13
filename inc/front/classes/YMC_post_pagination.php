<?php


class YMC_post_pagination {

	public function __construct() {}

	public function number($query, $paged, $type_pagination, $filter_id, $target_id) {

		if ( ! $query ) return;

		$output = '';

		$prev_text = __('Prev','ymc-smart-filter');
		$next_text = __('Next','ymc-smart-filter');
		$prev_text = apply_filters('ymc_pagination_prev_text_'.$target_id, $prev_text);
		$next_text = apply_filters('ymc_pagination_next_text_'.$target_id, $next_text);

		$paginate = paginate_links([
			'base' => '%_%',
			'type' => 'array',
			'total' => $query->max_num_pages,
			'format' => '#page=%#%',
			'current' => max(1, $paged),
			'prev_text' => $prev_text,
			'next_text' => $next_text,
		]);

		if ($query->max_num_pages > 1):
			$output .= "<ul id='ymc-layout-pagination' class='ymc-pagination pagination-" . esc_attr($type_pagination) ."'>";
			foreach ($paginate as $page):
				$output .= "<li>" . $page ."</li>";
			endforeach;
			$output .= "</ul>";
		endif;

		return $output;
	}

	public function load_more($query, $paged, $type_pagination, $filter_id, $target_id) {

		if ( ! $query ) return;

		$output = '';

		$load_more = apply_filters('ymc_pagination_load_more_'.$target_id, __('Load More','ymc-smart-filter'));

		if( $query->max_num_pages > 1 ) :
			$output .= "<div id='ymc-layout-pagination' class='ymc-pagination pagination-" . esc_attr($type_pagination) ."'>";
			$output .= "<a class='btn-load' href='#'>". esc_html($load_more) ."</a>";
			$output .= "</div>";
		endif;

		return $output;
	}

	//public function scroll_infinity($query, $paged, $type_pagination, $filter_id) {}

}


