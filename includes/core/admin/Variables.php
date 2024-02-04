<?php

namespace YMC_Smart_Filters\Core\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Variables
 * @package YMC_Smart_Filters\Core\Admin
 * Variables
 */
class Variables {


	/**
	 * General tab used default variables
	 */

	public $output = 'names';

	public $cpt = 'post';

	public $tax = 'category';

	public $tax_sel = array();

	public $terms_sel = array();

	public $tax_rel = 'AND';

	public $tax_sort = null;

	public $term_sort = null;

	public $choices_posts = null;

	public $ymc_exclude_posts = 'off';

	public $ymc_terms_icons = null;

	public $ymc_terms_align = null;

	public $ymc_terms_options = null;


	/**
	 * Layouts tab used default variables
	 */

	public $filter_status = 'on';

	public $sort_status = 'off';

	public $filter_layout = 'filter-layout1';

	public $filter_text_color = '';

	public $filter_bg_color = '';

	public $filter_active_color = '';

	public $ymc_post_layout = 'post-layout1';

	public $ymc_post_text_color = '';

	public $ymc_post_bg_color = '';

	public $ymc_post_active_color = '';

	public $ymc_multiple_filter = 0;

	public $ymc_post_status = 'publish';

	public $ymc_desktop_xxl = 4;

	public $ymc_desktop_xl = 4;

	public $ymc_desktop_lg = 4;

	public $ymc_tablet_md = 3;

	public $ymc_tablet_sm = 2;

	public $ymc_mobile_xs = 1;



	/**
	 * Appearance tab used default variables
	 */

	public $ymc_empty_post_result = "No posts found.";

	public $ymc_link_target = "_blank";

	public $ymc_per_page = 4;

	public $ymc_pagination_type = 'numeric';

	public $ymc_pagination_hide = 'off';

	public $ymc_sort_terms = 'asc';

	public $ymc_order_post_by = 'title';

	public $ymc_order_post_type = 'asc';

	public $ymc_meta_key = null;

	public $ymc_meta_value = null;

	public $ymc_multiple_sort = null;

	public $ymc_post_animation = null;


	public $ymc_popup_status = 'off';

	public $ymc_popup_animation = null;

	public $ymc_popup_animation_origin = 'center center';

	public $ymc_popup_settings = [
		"custom_width" => "50",
		"custom_width_unit" => "%",
		"custom_height" => "550",
		"custom_height_unit" => "px",
		"custom_location" => "center",
		"custom_bg_overlay" => "#14151899"
	];


	/**
	 * Advanced tab used default variables
	 */
	public $ymc_special_post_class = '';

	public $ymc_preloader_icon = 'preloader';

	public $ymc_preloader_filters = 'none';

	public $ymc_preloader_filters_rate = '0.5';

	public $ymc_preloader_filters_custom = '';

	public $ymc_advanced_query_status = 'off';

	public $ymc_query_type = 'query_custom';

	public $ymc_query_type_custom = '';

	public $ymc_query_type_callback = '';


	/**
	 * Typography tab used default variables
	 */
	public $ymc_filter_font = 'inherit';

	public $ymc_post_font = 'inherit';


	/**
	 * Search tab used default variables
	 */
	public $ymc_filter_search_status = 'off';

	public $ymc_search_text_button = 'Search';

	public $ymc_search_placeholder = 'Search posts...';

	public $ymc_autocomplete_state = 0;

	public $ymc_scroll_page = 1;

	public $ymc_search_filtered_posts  = 0;




	/**
	 * General tab General
	 */

	public function display_cpt( $exclude_arr ) {

		$cpost_types = get_post_types( [ 'public' => true ], 'names' );

		if( is_array( $exclude_arr ) && count( $exclude_arr ) > 0 ) {

			foreach ( $exclude_arr as $value ) {
				$pos = array_search( $value, $cpost_types );
				unset($cpost_types[$pos]);
			}
		}

		ksort( $cpost_types, SORT_ASC );

		return $cpost_types;
	}


	public function get_cpt( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_cpt_value' ) ) {
			return get_post_meta( $post_id, 'ymc_cpt_value', true );
		}
		return $this->cpt;
	}


	public function get_tax_sel( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_taxonomy' ) ) {
			return get_post_meta( $post_id, 'ymc_taxonomy', true );
		}
		return $this->tax_sel;
	}


	public function get_terms_sel( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_terms' ) ) {
			return get_post_meta( $post_id, 'ymc_terms', true );
		}
		return $this->terms_sel;
	}


	public function get_tax_rel( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_tax_relation' ) ) {
			return get_post_meta( $post_id, 'ymc_tax_relation', true );
		}
		return $this->tax_rel;
	}


	public function get_tax_sort( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_tax_sort' ) ) {
			return get_post_meta( $post_id, 'ymc_tax_sort', true );
		}
		return $this->tax_sort;
	}


	public function get_term_sort( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_term_sort' ) ) {
			return get_post_meta( $post_id, 'ymc_term_sort', true );
		}
		return $this->term_sort;
	}


	public function get_choices_posts( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_choices_posts' ) ) {
			return get_post_meta( $post_id, 'ymc_choices_posts', true );
		}
		return $this->choices_posts;
	}

	public function get_exclude_posts( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_exclude_posts' ) ) {
			return get_post_meta( $post_id, 'ymc_exclude_posts', true );
		}
		return $this->ymc_exclude_posts;
	}


	public function get_terms_icons( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_terms_icons' ) ) {
			return get_post_meta( $post_id, 'ymc_terms_icons', true );
		}
		return $this->ymc_terms_icons;
	}


	public function get_terms_align( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_terms_align' ) ) {
			return get_post_meta( $post_id, 'ymc_terms_align', true );
		}
		return $this->ymc_terms_align;
	}


	public function get_terms_options( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_terms_options' ) ) {
			return get_post_meta( $post_id, 'ymc_terms_options', true );
		}
		return $this->ymc_terms_options;
	}


	/**
	 * Layouts tab Layouts
	 */
	public function get_filter_status( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_filter_status' ) ) {
			return get_post_meta( $post_id, 'ymc_filter_status', true );
		}
		return $this->filter_status;
	}


	public function get_sort_status( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_sort_status' ) ) {
			return get_post_meta( $post_id, 'ymc_sort_status', true );
		}
		return $this->sort_status;
	}


	public function get_filter_layout( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_filter_layout' ) ) {
			return get_post_meta( $post_id, 'ymc_filter_layout', true );
		}
		return $this->filter_layout;
	}


	public function get_filter_text_color( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_filter_text_color' ) ) {
			return get_post_meta( $post_id, 'ymc_filter_text_color', true );
		}
		return $this->filter_text_color;
	}


	public function get_filter_bg_color( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_filter_bg_color' ) ) {
			return get_post_meta( $post_id, 'ymc_filter_bg_color', true );
		}
		return $this->filter_bg_color;
	}


	public function get_filter_active_color( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_filter_active_color' ) ) {
			return get_post_meta( $post_id, 'ymc_filter_active_color', true );
		}
		return $this->filter_active_color;
	}


	public function get_multiple_filter( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_multiple_filter' ) ) {
			return get_post_meta( $post_id, 'ymc_multiple_filter', true );
		}
		return $this->ymc_multiple_filter;
	}


	public function get_post_layout( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_post_layout' ) ) {
			return get_post_meta( $post_id, 'ymc_post_layout', true );
		}
		return $this->ymc_post_layout;
	}


	public function get_post_text_color( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_post_text_color' ) ) {
			return get_post_meta( $post_id, 'ymc_post_text_color', true );
		}
		return $this->ymc_post_text_color;
	}


	public function get_post_bg_color( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_post_bg_color' ) ) {
			return get_post_meta( $post_id, 'ymc_post_bg_color', true );
		}
		return $this->ymc_post_bg_color;
	}


	public function get_post_active_color( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_post_active_color' ) ) {
			return get_post_meta( $post_id, 'ymc_post_active_color', true );
		}
		return $this->ymc_post_active_color;
	}

	public function get_post_desktop_xxl( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_desktop_xxl' ) ) {
			return get_post_meta( $post_id, 'ymc_desktop_xxl', true );
		}
		return $this->ymc_desktop_xxl;
	}

	public function get_post_desktop_xl( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_desktop_xl' ) ) {
			return get_post_meta( $post_id, 'ymc_desktop_xl', true );
		}
		return $this->ymc_desktop_xl;
	}

	public function get_post_desktop_lg( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_desktop_lg' ) ) {
			return get_post_meta( $post_id, 'ymc_desktop_lg', true );
		}
		return $this->ymc_desktop_lg;
	}

	public function get_post_tablet_md( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_tablet_md' ) ) {
			return get_post_meta( $post_id, 'ymc_tablet_md', true );
		}
		return $this->ymc_tablet_md;
	}

	public function get_post_tablet_sm( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_tablet_sm' ) ) {
			return get_post_meta( $post_id, 'ymc_tablet_sm', true );
		}
		return $this->ymc_tablet_sm;
	}

	public function get_post_mobile_xs( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_mobile_xs' ) ) {
			return get_post_meta( $post_id, 'ymc_mobile_xs', true );
		}
		return $this->ymc_mobile_xs;
	}


	/**
	 * Layouts tab Appearance
	 */
	public function get_empty_post_result( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_empty_post_result' ) ) {
			return get_post_meta( $post_id, 'ymc_empty_post_result', true );
		}
		return $this->ymc_empty_post_result;
	}


	public function get_link_target( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_link_target' ) ) {
			return get_post_meta( $post_id, 'ymc_link_target', true );
		}
		return $this->ymc_link_target;
	}


	public function get_per_page( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_per_page' ) ) {
			return get_post_meta( $post_id, 'ymc_per_page', true );
		}
		return $this->ymc_per_page;
	}


	public function get_pagination_type( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_pagination_type' ) ) {
			return get_post_meta( $post_id, 'ymc_pagination_type', true );
		}
		return $this->ymc_pagination_type;
	}


	public function get_pagination_hide( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_pagination_hide' ) ) {
			return get_post_meta( $post_id, 'ymc_pagination_hide', true );
		}
		return $this->ymc_pagination_hide;
	}


	public function get_sort_terms( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_sort_terms' ) ) {
			return get_post_meta( $post_id, 'ymc_sort_terms', true );
		}
		return $this->ymc_sort_terms;
	}


	public function get_order_post_by( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_order_post_by' ) ) {
			return get_post_meta( $post_id, 'ymc_order_post_by', true );
		}
		return $this->ymc_order_post_by;
	}


	public function get_order_post_type( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_order_post_type' ) ) {
			return get_post_meta( $post_id, 'ymc_order_post_type', true );
		}
		return $this->ymc_order_post_type;
	}


	public function get_ymc_meta_key( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_meta_key' ) ) {
			return get_post_meta( $post_id, 'ymc_meta_key', true );
		}
		return $this->ymc_meta_key;
	}


	public function get_ymc_meta_value( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_meta_value' ) ) {
			return get_post_meta( $post_id, 'ymc_meta_value', true );
		}
		return $this->ymc_meta_value;
	}


	public function get_ymc_multiple_sort( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_multiple_sort' ) ) {
			return get_post_meta( $post_id, 'ymc_multiple_sort', true );
		}
		return $this->ymc_multiple_sort;
	}


	public function get_ymc_post_status( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_post_status' ) ) {
			return get_post_meta( $post_id, 'ymc_post_status', true );
		}
		return $this->ymc_post_status;
	}


	public function get_ymc_post_animation( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_post_animation' ) ) {
			return get_post_meta( $post_id, 'ymc_post_animation', true );
		}
		return $this->ymc_post_animation;
	}


	public function get_ymc_popup_status( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_popup_status' ) ) {
			return get_post_meta( $post_id, 'ymc_popup_status', true );
		}
		return $this->ymc_popup_status;
	}

	public function get_ymc_popup_animation( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_popup_animation' ) ) {
			return get_post_meta( $post_id, 'ymc_popup_animation', true );
		}
		return $this->ymc_popup_animation;
	}

	public function get_ymc_popup_animation_origin( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_popup_animation_origin' ) ) {
			return get_post_meta( $post_id, 'ymc_popup_animation_origin', true );
		}
		return $this->ymc_popup_animation_origin;
	}

	public function get_ymc_popup_settings( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_popup_settings' ) ) {
			return get_post_meta( $post_id, 'ymc_popup_settings', true );
		}
		return $this->ymc_popup_settings;
	}


	/**
	 * Layouts tab Advanced
	 */
	public function get_special_post_class( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_special_post_class' ) ) {
			return get_post_meta( $post_id, 'ymc_special_post_class', true );
		}
		return $this->ymc_special_post_class;
	}

	public function get_ymc_preloader_icon( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_preloader_icon' ) ) {
			return get_post_meta( $post_id, 'ymc_preloader_icon', true );
		}
		return $this->ymc_preloader_icon;
	}

	public function get_ymc_preloader_filters( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_preloader_filters' ) ) {
			return get_post_meta( $post_id, 'ymc_preloader_filters', true );
		}
		return $this->ymc_preloader_filters;
	}

	public function get_ymc_preloader_filters_rate( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_preloader_filters_rate' ) ) {
			return get_post_meta( $post_id, 'ymc_preloader_filters_rate', true );
		}
		return $this->ymc_preloader_filters_rate;
	}

	public function get_ymc_preloader_filters_custom( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_preloader_filters_custom' ) ) {
			return get_post_meta( $post_id, 'ymc_preloader_filters_custom', true );
		}
		return $this->ymc_preloader_filters_custom;
	}

	public function get_ymc_scroll_page( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_scroll_page' ) ) {
			return get_post_meta( $post_id, 'ymc_scroll_page', true );
		}
		return $this->ymc_scroll_page;
	}

	public function get_ymc_advanced_query_status( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_advanced_query_status' ) ) {
			return get_post_meta( $post_id, 'ymc_advanced_query_status', true );
		}
		return $this->ymc_advanced_query_status;
	}

	public function get_ymc_query_type( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_query_type' ) ) {
			return get_post_meta( $post_id, 'ymc_query_type', true );
		}
		return $this->ymc_query_type;
	}

	public function get_ymc_query_type_custom( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_query_type_custom' ) ) {
			return get_post_meta( $post_id, 'ymc_query_type_custom', true );
		}
		return $this->ymc_query_type_custom;
	}

	public function get_ymc_query_type_callback( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_query_type_callback' ) ) {
			return get_post_meta( $post_id, 'ymc_query_type_callback', true );
		}
		return $this->ymc_query_type_callback;
	}


	/**
	 * Typography tab used default variables
	 */
	public function get_filter_font( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_filter_font' ) ) {
			return get_post_meta( $post_id, 'ymc_filter_font', true );
		}
		return $this->ymc_filter_font;
	}


	public function get_post_font( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_post_font' ) ) {
			return get_post_meta( $post_id, 'ymc_post_font', true );
		}
		return $this->ymc_post_font;
	}


	/**
	 * Search tab used default variables
	 */
	public function get_filter_search_status( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_filter_search_status' ) ) {
			return get_post_meta( $post_id, 'ymc_filter_search_status', true );
		}
		return $this->ymc_filter_search_status;
	}


	public function get_search_text_button( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_search_text_button' ) ) {
			return get_post_meta( $post_id, 'ymc_search_text_button', true );
		}
		return $this->ymc_search_text_button;
	}


	public function get_ymc_search_placeholder( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_search_placeholder' ) ) {
			return get_post_meta( $post_id, 'ymc_search_placeholder', true );
		}
		return $this->ymc_search_placeholder;
	}


	public function get_ymc_autocomplete_state( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_autocomplete_state' ) ) {
			return get_post_meta( $post_id, 'ymc_autocomplete_state', true );
		}
		return $this->ymc_autocomplete_state;
	}


	public function get_search_filtered_posts( $post_id ) {

		if( get_post_meta( $post_id, 'ymc_search_filtered_posts' ) ) {
			return get_post_meta( $post_id, 'ymc_search_filtered_posts', true );
		}
		return $this->ymc_search_filtered_posts;
	}

}