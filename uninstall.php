<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Uninstall plugin
 * Trigger Uninstall process only if WP_UNINSTALL_PLUGIN is defined
 */

if( ! defined('WP_UNINSTALL_PLUGIN') ) exit;

global $wpdb;

$wpdb->get_results('DELETE FROM wp_postmeta WHERE meta_key IN (
                                  "ymc_cpt_value", 
                                  "ymc_taxonomy", 
                                  "ymc_terms", 
                                  "ymc_choices_posts", 
                                  "ymc_exclude_posts",
                                  "ymc_terms_align",
                                  "ymc_preloader_icon",
                                  "ymc_tax_relation", 
                                  "ymc_tax_sort", 
                                  "ymc_filter_status", 
                                  "ymc_filter_layout",
                                  "ymc_filter_text_color",
                                  "ymc_filter_bg_color",
                                  "ymc_filter_active_color",
                                  "ymc_post_layout",
                                  "ymc_post_text_color",
                                  "ymc_post_bg_color",
                                  "ymc_post_active_color",
                                  "ymc_multiple_filter",
                                  "ymc_empty_post_result",
                                  "ymc_link_target",
                                  "ymc_per_page",
                                  "ymc_pagination_type",
                                  "ymc_pagination_hide",         
                                  "ymc_sort_terms",
                                  "ymc_order_post_by",
                                  "ymc_meta_key",
                                  "ymc_meta_value",
                                  "ymc_order_post_type",
                                  "ymc_post_status",
                                  "ymc_special_post_class",
                                  "ymc_filter_font",
                                  "ymc_post_font",
                                  "ymc_filter_search_status",  
                                  "ymc_search_text_button",
                                  "ymc_search_placeholder",
                                  "ymc_autocomplete_state",
                                  "ymc_scroll_page",
                                  "ymc_preloader_filters",
                                  "ymc_preloader_filters_rate",
                                  "ymc_preloader_filters_custom",
                                  "ymc_terms_options",
                                  "ymc_post_animation",
                                  "ymc_terms_icons",
                                  "ymc_popup_status",                                                                        
                                  "ymc_popup_animation",                                                                        
                                  "ymc_popup_animation_origin",                                                                        
                                  "ymc_popup_settings",                                                                        
                                  "ymc_search_filtered_posts", 
                                  "ymc_advanced_query_status",
                                  "ymc_query_type",
                                  "ymc_query_type_custom",
                                  "ymc_query_type_callback",
                                  "ymc_desktop_xxl",
                                  "ymc_desktop_xl",
                                  "ymc_desktop_lg",
                                  "ymc_tablet_md",
                                  "ymc_tablet_sm",
                                  "ymc_mobile_xs",                                           
                                  "ymc_suppress_filters",                                         
                                  "ymc_filter_extra_layout",
                                  "ymc_post_elements",
                                  "ymc_pagination_elements",
                                  "ymc_exact_phrase",
                                  "ymc_debug_code",
                                  "ymc_custom_css",
                                  "ymc_custom_after_js",
                                  "ymc_carousel_params",
                                  "ymc_hierarchy_terms",
                                  "ymc_taxonomy_options"
                                )');


$wpdb->get_results('DELETE FROM wp_posts WHERE post_type IN ("ymc_filters")');













