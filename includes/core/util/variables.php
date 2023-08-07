<?php if ( ! defined( 'ABSPATH' ) ) exit;

use YMC_Smart_Filters\Plugin;

// Set variables
$variable = Plugin::instance()->variables;

$ymc_cpt_value     = $variable->get_cpt( $id );
$ymc_tax           = $variable->tax;
$ymc_terms         = '';
$ymc_post_layout   = $variable->get_post_layout( $id );
$ymc_filter_layout = $variable->get_filter_layout( $id );
$tax_selected      = $variable->get_tax_sel( $id );
$terms_selected    = $variable->get_terms_sel( $id );
$ymc_exclude_posts = $variable->get_exclude_posts( $id );
$ymc_choices_posts = $variable->get_choices_posts( $id );
$ymc_terms_icons   = $variable->get_terms_icons( $id );
$ymc_terms_align   = $variable->get_terms_align( $id );
$tax_rel           = $variable->get_tax_rel( $id );
$tax_sort          = $variable->get_tax_sort( $id );
$term_sort         = $variable->get_term_sort( $id );
$ymc_pagination_hide = $variable->get_pagination_hide( $id );
$ymc_filter_status = $variable->get_filter_status( $id );
$ymc_sort_status   = $variable->get_sort_status( $id );
$ymc_filter_text_color = $variable->get_filter_text_color( $id );
$ymc_filter_bg_color = $variable->get_filter_bg_color( $id );
$ymc_filter_active_color = $variable->get_filter_active_color( $id );
$ymc_post_text_color = $variable->get_post_text_color( $id );
$ymc_post_bg_color  = $variable->get_post_bg_color( $id );
$ymc_post_active_color  = $variable->get_post_active_color( $id );
$ymc_multiple_filter  = $variable->get_multiple_filter( $id );
$ymc_empty_post_result  = $variable->get_empty_post_result( $id );
$ymc_link_target  = $variable->get_link_target( $id );
$ymc_per_page     = $variable->get_per_page( $id );
$ymc_pagination_type = $variable->get_pagination_type( $id );
$ymc_sort_terms   = $variable->get_sort_terms( $id );
$ymc_order_post_by = $variable->get_order_post_by( $id );
$ymc_order_post_type = $variable->get_order_post_type( $id );
$ymc_meta_key = $variable->get_ymc_meta_key( $id );
$ymc_meta_value = $variable->get_ymc_meta_value( $id );
$ymc_special_post_class = $variable->get_special_post_class( $id );
$ymc_preloader_icon = $variable->get_ymc_preloader_icon( $id );
$ymc_filter_font = $variable->get_filter_font( $id );
$ymc_post_font = $variable->get_post_font( $id );
$ymc_filter_search_status = $variable->get_filter_search_status( $id );
$ymc_search_text_button = $variable->get_search_text_button( $id );
$ymc_search_placeholder = $variable->get_ymc_search_placeholder( $id );
$ymc_autocomplete_state = $variable->get_ymc_autocomplete_state( $id );
$ymc_scroll_page = $variable->get_ymc_scroll_page( $id );
$ymc_multiple_sort = $variable->get_ymc_multiple_sort( $id );
$ymc_post_status = $variable->get_ymc_post_status( $id );
$ymc_preloader_filters = $variable->get_ymc_preloader_filters( $id );
$ymc_preloader_filters_rate = $variable->get_ymc_preloader_filters_rate( $id );
$ymc_preloader_filters_custom = $variable->get_ymc_preloader_filters_custom( $id );
$ymc_terms_options   = $variable->get_terms_options( $id );


