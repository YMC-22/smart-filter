<?php

global $post;
$args = array( 'public' => true,  );
$output = 'names';

$cpost_types = get_post_types( $args, $output );
$pos = array_search('attachment', $cpost_types);
unset($cpost_types[$pos]);
$pos = array_search('popup', $cpost_types);
unset($cpost_types[$pos]);
$pos = array_search('post', $cpost_types);
unset($cpost_types[$pos]);
$pos = array_search('product', $cpost_types);
unset($cpost_types[$pos]);
ksort( $cpost_types, SORT_ASC );

// GENERAL TAB USED DEFAULT VARIABLES
$cpt = 'post';
$tax = 'category';
$tax_sel = array('category');
$terms_sel = array();
$tax_rel = 'AND';
$tax_sort = null;

// LAYOUT TAB USED DEFAULT VARIABLES
$ymc_filter_status = 'on';
$ymc_filter_layout = 'filter-layout1';
$ymc_filter_text_color = '';
$ymc_filter_bg_color = '';
$ymc_filter_active_color = '';

$ymc_post_layout = 'post-layout1';
$ymc_post_text_color = '';
$ymc_post_bg_color = '';
$ymc_post_active_color = '';

$ymc_empty_post_result = "No posts found.";
$ymc_link_target = "_blank";
$ymc_per_page = 4;
$ymc_pagination_type = 'numeric';
$ymc_sort_terms = 'asc';
$ymc_order_post_by = 'title';
$ymc_order_post_type = 'asc';
$ymc_special_post_class = '';
$ymc_filter_font = 'inherit';
$ymc_post_font = 'inherit';
$ymc_multiple_filter = 0;

$ymc_filter_search_status = 'off';
$ymc_search_text_button = 'Search';
$ymc_search_placeholder = 'Search posts...';


// GENERAL TAB SUBMITTED VARIABLE VALUES
if( get_post_meta($post->ID, 'ymc_cpt_value') ) {
	$cpt = get_post_meta($post->ID, 'ymc_cpt_value', true);
}
if( get_post_meta($post->ID, 'ymc_taxonomy') ) {
	$tax_sel = get_post_meta($post->ID, 'ymc_taxonomy', true);
}
if( get_post_meta($post->ID, 'ymc_terms') ) {
	$terms_sel = get_post_meta($post->ID, 'ymc_terms', true);
}
if( get_post_meta($post->ID, 'ymc_tax_relation') ) {
	$tax_rel = get_post_meta($post->ID, 'ymc_tax_relation', true);
}
if( get_post_meta($post->ID, 'ymc_tax_sort', true) ) {
	$tax_sort = get_post_meta($post->ID, 'ymc_tax_sort', true);
}

// LAYOUTS TAB SUBMITTED VARIABLE VALUES
if( get_post_meta($post->ID, 'ymc_filter_status') ) {
	$ymc_filter_status = get_post_meta($post->ID, 'ymc_filter_status', true);
}
if( get_post_meta($post->ID, 'ymc_filter_layout') ) {
	$ymc_filter_layout = get_post_meta($post->ID, 'ymc_filter_layout', true);
}
if( get_post_meta($post->ID, 'ymc_filter_text_color', true) ) {
	$ymc_filter_text_color = get_post_meta($post->ID, 'ymc_filter_text_color', true);
}
if( get_post_meta($post->ID, 'ymc_filter_bg_color', true) ) {
	$ymc_filter_bg_color = get_post_meta($post->ID, 'ymc_filter_bg_color', true);
}
if( get_post_meta($post->ID, 'ymc_filter_active_color', true) ) {
	$ymc_filter_active_color = get_post_meta($post->ID, 'ymc_filter_active_color', true);
}
if( get_post_meta($post->ID, 'ymc_multiple_filter') ) {
	$ymc_multiple_filter = get_post_meta($post->ID, 'ymc_multiple_filter', true);
}

if( get_post_meta($post->ID, 'ymc_post_layout') ) {
	$ymc_post_layout = get_post_meta($post->ID, 'ymc_post_layout', true);
}

if( get_post_meta($post->ID, 'ymc_post_text_color') ) {
	$ymc_post_text_color = get_post_meta($post->ID, 'ymc_post_text_color', true);
}
if( get_post_meta($post->ID, 'ymc_post_bg_color') ) {
	$ymc_post_bg_color = get_post_meta($post->ID, 'ymc_post_bg_color', true);
}
if( get_post_meta($post->ID, 'ymc_post_active_color') ) {
	$ymc_post_active_color = get_post_meta($post->ID, 'ymc_post_active_color', true);
}
if( get_post_meta($post->ID, 'ymc_empty_post_result') ) {
	$ymc_empty_post_result = get_post_meta($post->ID, 'ymc_empty_post_result', true);
}
if (get_post_meta($post->ID, 'ymc_link_target')) {
	$ymc_link_target = get_post_meta($post->ID, 'ymc_link_target', true);
}
if (get_post_meta($post->ID, 'ymc_per_page')) {
	$ymc_per_page = get_post_meta($post->ID, 'ymc_per_page', true);
}
if (get_post_meta($post->ID, 'ymc_pagination_type')) {
	$ymc_pagination_type = get_post_meta($post->ID, 'ymc_pagination_type', true);
}
if (get_post_meta($post->ID, 'ymc_sort_terms')) {
	$ymc_sort_terms = get_post_meta($post->ID, 'ymc_sort_terms', true);
}
if (get_post_meta($post->ID, 'ymc_order_post_by')) {
	$ymc_order_post_by = get_post_meta($post->ID, 'ymc_order_post_by', true);
}
if (get_post_meta($post->ID, 'ymc_order_post_type')) {
	$ymc_order_post_type = get_post_meta($post->ID, 'ymc_order_post_type', true);
}
if (get_post_meta($post->ID, 'ymc_special_post_class')) {
	$ymc_special_post_class = get_post_meta($post->ID, 'ymc_special_post_class', true);
}
if (get_post_meta($post->ID, 'ymc_filter_font')) {
	$ymc_filter_font = get_post_meta($post->ID, 'ymc_filter_font', true);
}
if (get_post_meta($post->ID, 'ymc_post_font')) {
	$ymc_post_font = get_post_meta($post->ID, 'ymc_post_font', true);
}
if( get_post_meta($post->ID, 'ymc_filter_search_status') ) {
	$ymc_filter_search_status = get_post_meta($post->ID, 'ymc_filter_search_status', true);
}
if( get_post_meta($post->ID, 'ymc_search_text_button') ) {
	$ymc_search_text_button = get_post_meta($post->ID, 'ymc_search_text_button', true);
}
if( get_post_meta($post->ID, 'ymc_search_placeholder') ) {
	$ymc_search_placeholder = get_post_meta($post->ID, 'ymc_search_placeholder', true);
}

