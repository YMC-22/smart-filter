<?php

namespace YMC_Smart_Filters\Core\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pagination {

	public function __construct() {}

	/**
	 * Generate pagination output based on the provided query and parameters.
	 *
	 * @param WP_Query $query The WordPress query object.
	 * @param int $paged The current page number.
	 * @param string $type_pagination The type of pagination.
	 * @param int $filter_id The filter ID.
	 * @param int $target_id The target ID.
	 * @param array $pagination_elements Additional pagination elements.
	 * @return string The generated pagination output.
	 */
	public function number( $query, $paged, $type_pagination, $filter_id, $target_id, $pagination_elements = [] )
	{
		if ( ! $query ) return;

		$output = '';

		$prev_text = __( !empty($pagination_elements['prev_btn_text']) ? $pagination_elements['prev_btn_text'] : 'Prev'  ,'ymc-smart-filter');
		$next_text = __( !empty($pagination_elements['next_btn_text']) ?  $pagination_elements['next_btn_text'] : 'Next' ,'ymc-smart-filter');
		$prev_text = apply_filters('ymc_pagination_prev_text_'.$filter_id.'_'.$target_id, $prev_text);
		$next_text = apply_filters('ymc_pagination_next_text_'.$filter_id.'_'.$target_id, $next_text);

		$paginate = paginate_links([
			'base' => '%_%',
			'type' => 'array',
			'total' => $query->max_num_pages,
			'format' => '#page=%#%',
			'current' => max(1, $paged),
			'prev_text' => $prev_text,
			'next_text' => $next_text,
		]);

		if ( $query->max_num_pages > 1 ) :

			$output .= "<ul id='ymc-layout-pagination' class='ymc-pagination pagination-" . esc_attr($type_pagination) ."'>";

			foreach ( $paginate as $page ) :

				if( preg_match('/<span[^>]*>(.*)<\/span>/', $page, $matches) ) {
					$output .= "<li class='list-item current-item'>" . $page ."</li>";
				}
				elseif( preg_match('/<[^>]*class="[^"]*\bprev\b[^"]*"[^>]*>/i', $page, $matches) )
				{
					$output .= "<li class='list-item prev-item'>" . $page ."</li>";
				}
				elseif( preg_match('/<[^>]*class="[^"]*\bnext\b[^"]*"[^>]*>/i', $page, $matches) )
				{
					$output .= "<li class='list-item next-item'>" . $page ."</li>";
				}
				else {
					$output .= "<li class='list-item'>" . $page ."</li>";
				}

			endforeach;

			$output .= "</ul>";

		endif;

		return $output;
	}

	/**
	 * Load more pagination elements based on the provided query and parameters.
	 *
	 * @param object $query The WP_Query object containing the query results.
	 * @param int $paged The current page number.
	 * @param string $type_pagination The type of pagination.
	 * @param string $filter_id The filter ID for the pagination.
	 * @param string $target_id The target ID for the pagination.
	 * @param array $pagination_elements An array of elements for pagination customization.
	 * @return string HTML output for the load more pagination.
	 */
	public function load_more( $query, $paged, $type_pagination, $filter_id, $target_id, $pagination_elements = [] )
	{

		if ( ! $query ) return;

		$output = '';

		$load_more_text = !empty($pagination_elements['load_btn_text']) ? $pagination_elements['load_btn_text'] : 'Load More';
		$load_more = apply_filters('ymc_pagination_load_more_'.$filter_id.'_'.$target_id, __($load_more_text,'ymc-smart-filter'));

		if( $query->max_num_pages > 1 ) :
			$output .= "<div id='ymc-layout-pagination' class='ymc-pagination pagination-" . esc_attr($type_pagination) ."'>";
			$output .= "<a class='btn-load' href='#'>". esc_html($load_more) ."</a>";
			$output .= "</div>";
		endif;

		return $output;
	}

}