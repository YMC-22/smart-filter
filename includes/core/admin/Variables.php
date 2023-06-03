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

	public $tax_sel = array('category');

	public $terms_sel = array();

	public $tax_rel = 'AND';

	public $tax_sort = null;

	public $term_sort = null;

	public $choices_posts = null;

	public $ymc_exclude_posts = 'off';

	public $ymc_terms_icons = null;

	public $ymc_terms_align = null;


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


	/**
	 * Advanced tab used default variables
	 */
	public $ymc_special_post_class = '';

	public $ymc_preloader_icon = 'preloader';


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


}