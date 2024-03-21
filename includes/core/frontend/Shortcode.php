<?php

namespace YMC_Smart_Filters\Core\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Shortcode
 * @package YMC_Smart_Filters\Core\Frontend
 * Shortcode
 */

class Shortcode {

	public function __construct()
	{
		add_shortcode("ymc_filter", array($this, "ymc_filter_apply"));
		add_shortcode("ymc_extra_filter", array($this, "ymc_extra_filter"));
		add_shortcode("ymc_extra_search", array($this, "ymc_extra_search"));
		add_shortcode("ymc_extra_sort", array($this, "ymc_extra_sort"));
	}

	/**
	 * @param $atts
	 * Display Grid Posts with Filter
	 *
	 * @return string
	 */
	public function ymc_filter_apply( $atts )
	{

		ob_start();

		$atts = shortcode_atts( [
			'id' => '',
		], $atts );

		$id = $atts['id'];

		static $c_target = 1;

		$post_status = get_post_status($id);

		$ymc_post_type = get_post_type($id);

		$handle_filter = 'filter-inline-css-' . $c_target;
		$handle_post   = 'post-inline-css-' .  $c_target;

		// List classes for breakpoints
		$breakpoints_classes = '';

		// Array Post Layouts for Breakpoints
		$arr_layouts_posts = [
			'post-layout1',
			'post-layout2',
			'post-custom-layout'
		];

		// Default Terms
		$default_terms = '';

		// Output HTML
		$output = '';

		require YMC_SMART_FILTER_DIR . '/includes/core/util/variables.php';
		require YMC_SMART_FILTER_DIR . '/includes/core/util/helper.php';


		if ( !empty($id) && $ymc_post_type === 'ymc_filters' && $post_status === 'publish' )
		{

			if ( is_array($tax_selected) ) {
				$ymc_tax = implode(",", $tax_selected);
			}

			if ( is_array($terms_selected) ) {
				$ymc_terms = implode(',', $terms_selected);
			}

			if ( is_array($ymc_choices_posts) ) {
				$ymc_choices_posts = implode(',', $ymc_choices_posts);
			}

			if( is_array($ymc_terms_options) &&
			    !empty($ymc_terms_options) &&
			    $ymc_filter_layout !== 'alphabetical-layout' )
			{
				$arr_default_terms = array_column($ymc_terms_options, 'default', 'termid');

				if( !empty($arr_default_terms) )
				{
					foreach ( $arr_default_terms as $k => $v )
					{
						if( !empty($v) && in_array($k, $terms_selected) )
						{
							$default_terms .= $k .',';
						}
					}
					$default_terms = rtrim($default_terms, ',');
				}
			}

			$css_special = !empty($ymc_special_post_class) ? $ymc_special_post_class : '';

			$ymc_filter_layout = ( $ymc_filter_status === 'on' ) ? $ymc_filter_layout : 'no-filter-layout';

			echo '<div id="ymc-smart-filter-container-'. esc_attr($c_target) .'" 
				  class="ymc-smart-filter-container ymc-filter-'. esc_attr($id) .' ymc-loaded-filter ymc-'. esc_attr($ymc_filter_layout) .' ymc-'. esc_attr($ymc_post_layout) .' ymc-pagination-'. esc_attr($ymc_pagination_type) .' data-target-ymc'.esc_attr($id).'-'.esc_attr($c_target).' data-target-ymc'. esc_attr($c_target) .' '. $css_special .'" data-loading="true"
				  data-params=\'{"cpt":"'.esc_attr($ymc_cpt_value).'","tax":"'.esc_attr($ymc_tax).'","terms":"'.esc_attr($ymc_terms).'","default_terms":"'.esc_attr($default_terms).'","exclude_posts":"'.esc_attr($ymc_exclude_posts).'","choices_posts":"'.esc_attr($ymc_choices_posts).'","posts_selected":"all","preloader_icon":"'.esc_attr($ymc_preloader_icon).'","type_pg":"'.esc_attr($ymc_pagination_type).'","per_page":"'.esc_attr($ymc_per_page).'","page":"1","page_scroll":"'.esc_attr($ymc_scroll_page).'","preloader_filters":"'.esc_attr($ymc_preloader_filters).'","preloader_filters_rate":"'.esc_attr($ymc_preloader_filters_rate).'","preloader_filters_custom":"'.esc_attr($ymc_preloader_filters_custom).'","post_animation":"'.esc_attr($ymc_post_animation).'","popup_animation":"'.esc_attr($ymc_popup_animation).'","letter":"","post_layout":"'.esc_attr($ymc_post_layout).'","filter_layout":"'.esc_attr($ymc_filter_layout).'","filter_id":"'.esc_attr($id).'","search":"","search_filtered_posts":"'.esc_attr($ymc_search_filtered_posts).'","sort_order":"","sort_orderby":"","meta_key":"","meta_query":"","date_query":"","data_target":"data-target-ymc'.esc_attr($c_target).'","target_id":"'.esc_attr($c_target).'"}\'>';


			if ( $ymc_filter_search_status === 'on' )
			{
				$filepath_search = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/search/search-layout.php";

				if ( file_exists($filepath_search) ) {
					require $filepath_search;
				}
			}

			if ( $ymc_filter_status === 'on' )
			{
				if ( $ymc_filter_layout )
				{
					$filepath_filter = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/filter/" . $ymc_filter_layout . ".php";

					if ( file_exists($filepath_filter) )
					{
						require $filepath_filter;
					}
				}
			}

			if ( $ymc_sort_status === 'on' )
			{
				$filepath_sort = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/sort/sort-posts.php";

				if ( file_exists($filepath_sort) ) {
					require $filepath_sort;
				}
			}

			if ( $ymc_post_layout !== 'post-custom-layout')
			{
				$filepath_post_css = YMC_SMART_FILTER_DIR . '/includes/core/frontend/layouts/post-css/'. $ymc_post_layout .'-css.php';

				if ( file_exists($filepath_post_css) ) {
					require $filepath_post_css;
				}
			}

			if ( in_array($ymc_post_layout, $arr_layouts_posts) )
			{
				$breakpoints_classes = 'ymc-xs-col-'.esc_attr($ymc_mobile_xs).' ymc-sm-col-'.esc_attr($ymc_tablet_sm).' ymc-md-col-'.esc_attr($ymc_tablet_md).' ymc-lg-col-'.esc_attr($ymc_desktop_lg).' ymc-xl-col-'.esc_attr($ymc_desktop_xl).' ymc-xxl-col-'.esc_attr($ymc_desktop_xxl);
			}

			echo '<div class="container-posts container-'. esc_attr($ymc_post_layout) .'"><div class="post-entry '. $breakpoints_classes .' '. esc_attr($ymc_post_layout) .' '. esc_attr($ymc_post_layout) .'-'.$id.' '.esc_attr($ymc_post_layout).'-'.$id.'-'.$c_target.'"></div></div>';

			if ( $ymc_popup_status === 'on' )
			{
				$filepath_popup = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/popup/popup-layout.php";

				if ( file_exists($filepath_popup) ) {
					require $filepath_popup;
				}
			}

			echo '</div>';
		}
		else {
			echo "<div class='ymc-smart-filter-container'>
				  <div class='notice'>" . esc_html__('ID parameter is missing or invalid.', 'ymc-smart-filter') ."</div></div>";
		}


		$output .= ob_get_contents();
		ob_end_clean();

		$c_target++;

		return $output;

	}

	/**
	 * @param $atts
	 * Display Extra Filter Layout in external place page
	 *
	 * @return string
	 */
	public function ymc_extra_filter( $atts )
	{

		$atts = shortcode_atts( [
			'id' => '',
		], $atts );

		$output = '';

		$id = $atts['id'];

		static $c_target = 1;

		$post_status = get_post_status($id);

		$ymc_post_type = get_post_type($id);

		$handle_filter = 'filter-inline-css-' . $c_target;
		$handle_post   = 'post-inline-css-' .  $c_target;

		require YMC_SMART_FILTER_DIR . '/includes/core/util/variables.php';
		require YMC_SMART_FILTER_DIR . '/includes/core/util/helper.php';

		if ( !empty($id) && $ymc_post_type === 'ymc_filters' && $post_status === 'publish' )
		{
			ob_start();

			// Replace Layout
			$ymc_filter_layout = $ymc_filter_extra_layout;

			echo '<div id="ymc-extra-filter-'. esc_attr($c_target) .'" data-extra-filter-id="'. esc_attr($id) .'" class="ymc-extra-filter ymc-'. esc_attr($ymc_filter_layout) .' ymc-'. esc_attr($ymc_filter_layout) .'-'.esc_attr($id).' ymc-'. esc_attr($ymc_filter_layout) .'-'.esc_attr($id).'-'.esc_attr($c_target).'">';

			if ( $ymc_filter_layout )
			{
				$filepath_filter = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/filter/" . $ymc_filter_layout . ".php";

				if ( file_exists($filepath_filter) )
				{
					require $filepath_filter;
				}
			}

			echo "</div>";

			$output .= ob_get_contents();
			ob_end_clean();
		}
		else
		{
			echo '<div class="ymc-extra-filter">
				  <div class="notice">' . esc_html__('ID parameter is missing or invalid.', 'ymc-smart-filter') .'</div></div>';
		}

		$c_target++;

		return $output;

	}


	/**
	 * @param $atts
	 * Display Extra Search in external place page
	 *
	 * @return string
	 */
	public function ymc_extra_search( $atts )
	{
		$atts = shortcode_atts( [
			'id' => '',
		], $atts );

		$output = '';

		$id = $atts['id'];

		static $c_target = 1;

		$post_status = get_post_status($id);

		$ymc_post_type = get_post_type($id);

		require YMC_SMART_FILTER_DIR . '/includes/core/util/variables.php';
		require YMC_SMART_FILTER_DIR . '/includes/core/util/helper.php';

		if ( !empty($id) && $ymc_post_type === 'ymc_filters' && $post_status === 'publish' )
		{
			ob_start();

			echo '<div id="ymc-extra-search-'. esc_attr($c_target) .'" data-extra-search-id="'. esc_attr($id) .'" class="ymc-extra-search ymc-extra-search-'. esc_attr($id) .'  ymc-extra-search-'. esc_attr($id) .'-'. esc_attr($c_target).'">';

			$filepath_search = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/search/search-layout.php";

			if ( file_exists($filepath_search) )
			{
				require $filepath_search;
			}

			echo "</div>";

			$output .= ob_get_contents();
			ob_end_clean();

		}
		else
		{
			echo '<div class="ymc-extra-filter">
				  <div class="notice">' . esc_html__('ID parameter is missing or invalid.', 'ymc-smart-filter') .'</div></div>';
		}

		$c_target++;

		return $output;
	}

	/**
	 * @param $atts
	 * Display Extra Sort in external place page
	 *
	 * @return string
	 */

	public function ymc_extra_sort( $atts )
	{

		$atts = shortcode_atts( [
			'id' => '',
		], $atts );

		$output = '';

		$id = $atts['id'];

		static $c_target = 1;

		$post_status = get_post_status($id);

		$ymc_post_type = get_post_type($id);

		require YMC_SMART_FILTER_DIR . '/includes/core/util/variables.php';
		require YMC_SMART_FILTER_DIR . '/includes/core/util/helper.php';

		if ( !empty($id) && $ymc_post_type === 'ymc_filters' && $post_status === 'publish' )
		{
			ob_start();

			echo '<div id="ymc-extra-sort-'. esc_attr($c_target) .'" data-extra-sort-id="'. esc_attr($id) .'" class="ymc-extra-sort ymc-extra-sort-'. esc_attr($id) .' ymc-extra-sort-'. esc_attr($id) .'-'. esc_attr($c_target).'">';

			$filepath_sort = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/sort/sort-posts.php";

			if ( file_exists($filepath_sort) )
			{
				require $filepath_sort;
			}

			echo "</div>";

			$output .= ob_get_contents();
			ob_end_clean();
		}
		else
		{
			echo '<div class="ymc-extra-filter">
				  <div class="notice">' . esc_html__('ID parameter is missing or invalid.', 'ymc-smart-filter') .'</div></div>';
		}

		$c_target++;

		return $output;

	}

}
