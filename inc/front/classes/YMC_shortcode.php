<?php

require_once YMC_SMART_FILTER_DIR . '/front/classes/YMC_front_filters.php';


class YMC_shortcode {

	public function __construct() {

		add_shortcode("ymc_filter", array($this, "ymc_filter_apply"));

		new YMC_front_filters();
	}

	public function ymc_filter_apply( $atts ) {

		ob_start();

		$atts = shortcode_atts( [
				'id' => '',
			], $atts );

		$id = $atts['id'];

		static $c_target = 1;

		$output = '';

		include YMC_SMART_FILTER_DIR . '/front/front-variables.php';

		$handle = "ymc-smartf-style-" . $c_target;

		wp_enqueue_style($handle, YMC_SMART_FILTER_URL . '/front/assets/css/style.css', array(), YMC_SMART_FILTER_VERSION);
		wp_enqueue_script('ymc-smart-frontend-scripts', YMC_SMART_FILTER_URL . '/front/assets/js/script.js', array('jquery'), YMC_SMART_FILTER_VERSION);
		wp_localize_script( 'ymc-smart-frontend-scripts', '_global_object',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce'    => wp_create_nonce('custom_ajax_nonce'),
				'current_page' => 1,
				'path' => YMC_SMART_FILTER_URL
			));

		$ymc_post_type = get_post_type($id);

		if ( !empty($id) && $ymc_post_type === 'ymc_filters' ) {

			if (is_array($tax_selected)) {
				$ymc_tax = implode(",", $tax_selected);
			}

			if(is_array($terms_selected)) {
				$ymc_terms = implode(',', $terms_selected);
			}

			echo '<div id="ymc-smart-filter-container-'.$c_target.'" 
				  class="ymc-smart-filter-container ymc-'.$ymc_filter_layout.' ymc-'. $ymc_post_layout.' ymc-pagination-'.$ymc_pagination_type.' data-target-ymc'.$c_target.'"
				  data-params=\'{"cpt":"'.$ymc_cpt_value.'","tax":"'.$ymc_tax.'","terms":"'.$ymc_terms.'","type_pg":"'.$ymc_pagination_type.'","per_page":"'.$ymc_per_page.'","page":"1","post_layout":"'.$ymc_post_layout.'","filter_layout":"'.$ymc_filter_layout.'","filter_id":"'.$id.'","post_sel":"all","search":"","data_target":"data-target-ymc'.$c_target.'"}\'>';


			if ( $ymc_filter_search_status === 'on' ) {

				$filepath_search = YMC_SMART_FILTER_DIR . "/front/layouts/search/search-layout.php";

				if ( file_exists($filepath_search) ) {
					include $filepath_search;
				}
			}

			if ( $ymc_filter_status === 'on' ) {

				if ( $ymc_filter_layout ) {

					$filepath_filter = YMC_SMART_FILTER_DIR . "/front/layouts/filter/" . $ymc_filter_layout . ".php";

					if ( file_exists($filepath_filter) ) {
						include $filepath_filter;
					}
				}
			}

			if( $ymc_post_layout !== 'post-custom-layout') :

				$filepath_post_css = YMC_SMART_FILTER_DIR . '/front/layouts/post-css/'. $ymc_post_layout .'-css.php';

				if ( file_exists($filepath_post_css) ) {
					include $filepath_post_css;
				}

			endif;

			echo '<div class="container-posts container-'. $ymc_post_layout .'"><div class="post-entry '. $ymc_post_layout .'"></div></div>';

			echo '</div>';
		}
		else {
			echo "<div class='ymc-smart-filter-container'><div class='notice'>" . esc_html__('ID parameter is missing or invalid.', 'ymc-smart-filter') ."</div></div>";
		}


		$output .= ob_get_contents();
		ob_end_clean();

		$c_target++;

		return $output;

	}

}

new YMC_shortcode();