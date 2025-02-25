<?php

namespace YMC_Smart_Filters\Core\Frontend;

use YMC_Smart_Filters\Plugin;

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

		$id = (int) $atts['id'];

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

			if ( is_array($terms_selected) &&
			     ( $ymc_display_terms === 'selected_terms' ||
			       $ymc_display_terms === 'hide_empty_terms') )
			{
				// Remove empty terms
				if( $ymc_display_terms === 'hide_empty_terms' ) {
					$terms_selected = array_filter($terms_selected, 'hideEmptyTerm');
				}
				$ymc_terms = implode(',', $terms_selected);
			}

			if( !$ymc_hierarchy_terms &&
			    ($ymc_display_terms === 'auto_populate_all' ||
			     $ymc_display_terms === 'auto_populate_all_empty') )
			{
				if( $ymc_display_terms === 'auto_populate_all' ) {
					// Auto populate all terms
					$terms_selected = autoPopulateAllTerms($tax_selected, false, $ymc_order_term_by, $ymc_sort_terms);
				} else {
					// Auto populate all without empty
					$terms_selected = autoPopulateAllTerms($tax_selected,true, $ymc_order_term_by, $ymc_sort_terms);
				}
				$ymc_terms = implode(',', $terms_selected);
			}

			if ( is_array($ymc_choices_posts) ) {
				$ymc_choices_posts = implode(',', $ymc_choices_posts);
			}

			if( is_array($ymc_terms_options) &&
			    ! empty($ymc_terms_options) &&
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

			$ymc_carousel_params = ( $ymc_post_layout === 'post-carousel-layout' ) ? wp_json_encode($ymc_carousel_params) : '""';

			if( ! empty($ymc_custom_css) ) :
				// phpcs:ignore WordPress
				echo '<style id="filter-grids-css-'.esc_attr($id) .'-'. esc_attr($c_target).'">'. wp_strip_all_tags($ymc_custom_css) .'</style>';
			endif;

			// Include JSON
			require YMC_SMART_FILTER_DIR . '/includes/core/util/json.php';

			echo '<div id="ymc-smart-filter-container-'. esc_attr($c_target) .'" 
				  class="ymc-smart-filter-container ymc-filter-'. esc_attr($id) .' ymc-loaded-filter ymc-'. esc_attr($ymc_filter_layout) .' ymc-'. esc_attr($ymc_post_layout) .' ymc-pagination-'. esc_attr($ymc_pagination_type) .' data-target-ymc'.esc_attr($id).'-'.esc_attr($c_target).' data-target-ymc'. esc_attr($c_target) .' '. esc_attr($css_special) .'" data-loading="true"
				  data-params=\''. wp_kses_post(str_replace(array("\r","\n","\t"," "), '', $json)) .'\'>';


			if ( $ymc_filter_search_status === 'on' )
			{
				$filepath_search = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/search/search-layout.php";

				if ( file_exists($filepath_search) ) {
					require $filepath_search;
				}
			}

			// Before Filter insert Featured Posts
			if ( $ymc_featured_post_status === 'on' &&
			     $ymc_location_featured_posts === 'top_before' &&
			     !empty($ymc_featured_posts) )
			{
				$filepath_featured_post = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/featured-post/" . $ymc_featured_post_layout . ".php";

				if ( file_exists($filepath_featured_post) )
				{
					require $filepath_featured_post;
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

			// After Filter insert Featured Posts
			if ( $ymc_featured_post_status === 'on' &&
			     $ymc_location_featured_posts === 'top_after' &&
			     !empty($ymc_featured_posts) )
			{
				$filepath_featured_post = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/featured-post/" . $ymc_featured_post_layout . ".php";

				if ( file_exists($filepath_featured_post) )
				{
					require $filepath_featured_post;
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

			echo '<div class="container-posts container-'. esc_attr($ymc_post_layout) .'">';

			do_action("ymc_before_post_layout_".$id);
			do_action("ymc_before_post_layout_".$id.'_'.$c_target);

			echo '<div class="post-entry '. esc_attr($breakpoints_classes) .' '. esc_attr($ymc_post_layout) .' '. esc_attr($ymc_post_layout) .'-'.esc_attr($id).' '.esc_attr($ymc_post_layout).'-'.esc_attr($id).'-'.esc_attr($c_target).'"></div>';

			do_action("ymc_after_post_layout_".$id);
			do_action("ymc_after_post_layout_".$id.'_'.$c_target);

			echo '</div>';

			// Bottom Grid insert Featured Posts
			if ( $ymc_featured_post_status === 'on' &&
			     $ymc_location_featured_posts === 'bottom' &&
			     !empty($ymc_featured_posts) )
			{
				$filepath_featured_post = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/featured-post/" . $ymc_featured_post_layout . ".php";

				if ( file_exists($filepath_featured_post) )
				{
					require $filepath_featured_post;
				}
			}

			if ( $ymc_popup_status === 'on' )
			{
				$filepath_popup = YMC_SMART_FILTER_DIR . "/includes/core/frontend/layouts/popup/popup-layout.php";

				if ( file_exists($filepath_popup) ) {
					require $filepath_popup;
				}
			}

			echo '</div>';

			if( $ymc_post_layout === 'post-carousel-layout' ) {
				wp_enqueue_style( 'filter-grids-swiper-css', YMC_SMART_FILTER_URL . 'includes/assets/css/swiper.min.css', array(), YMC_SMART_FILTER_VERSION);
				wp_enqueue_script( 'filter-grids-swiper-js', YMC_SMART_FILTER_URL . 'includes/assets/js/swiper.min.js', array(), YMC_SMART_FILTER_VERSION, true);
			}

			// Custom JS
			if(  wp_script_is( 'filter-grids-' . wp_create_nonce('filter-grids'), 'enqueued' ) &&
			     ! empty(Plugin::$instance->variables->get_ymc_custom_after_js($id)) )
			{
					wp_add_inline_script( 'filter-grids-' . wp_create_nonce('filter-grids'),"	
				
					(function($) {
	                    'use strict'                    
	                    ". Plugin::$instance->variables->get_ymc_custom_after_js($id) ." 				
					}(jQuery)); <!-- End Custom JS -->					
													
				    ", 'after' );
			}
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

		$id = (int) $atts['id'];

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

			echo '<div id="ymc-extra-filter-'. esc_attr($c_target) .'" data-extra-filter-id="'. esc_attr($id) .'"  data-extra-filter-counter="'. esc_attr($c_target) .'" class="ymc-extra-filter ymc-extra-filter-'.esc_attr($c_target).'">';

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

		$id = (int) $atts['id'];

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

		$id = (int) $atts['id'];

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
