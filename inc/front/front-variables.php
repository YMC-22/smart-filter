<?php
// DEFAULT VALUES
$ymc_cpt_value = 'post';
$ymc_tax = 'category';
$ymc_terms = '';
$ymc_post_layout = 'post-layout1';
$ymc_filter_layout = 'filter-layout1';
$tax_selected = '';
$terms_selected = '';
$tax_rel = 'AND';


// APPEARANCE TAB SUBMITTED VARIABLE VALUES
if(get_post_meta($id, 'ymc_cpt_value', true)) {
	$ymc_cpt_value = get_post_meta($id,'ymc_cpt_value', true);
}
if (get_post_meta($id, 'ymc_taxonomy')) {
	$tax_selected = get_post_meta($id, 'ymc_taxonomy', true);
}
if (get_post_meta($id, 'ymc_terms')) {
	$terms_selected = get_post_meta($id, 'ymc_terms', true);
}
if( get_post_meta($id, 'ymc_tax_relation') ) {
	$tax_rel = get_post_meta($id, 'ymc_tax_relation', true);
}
if( get_post_meta($id, 'ymc_tax_sort', true) ) {
	$tax_sort = get_post_meta($id, 'ymc_tax_sort', true);
}
if (get_post_meta($id, 'ymc_filter_status', true)) {
	$ymc_filter_status = get_post_meta($id, 'ymc_filter_status', true);
}
if (get_post_meta($id, 'ymc_filter_layout', true)) {
	$ymc_filter_layout = get_post_meta($id, 'ymc_filter_layout', true);
}
if (get_post_meta($id, 'ymc_post_layout', true)) {
	$ymc_post_layout = get_post_meta($id, 'ymc_post_layout', true);
}
if (get_post_meta($id, 'ymc_filter_text_color', true)) {
	$ymc_filter_text_color = get_post_meta($id, 'ymc_filter_text_color', true);
}
if (get_post_meta($id, 'ymc_filter_bg_color', true)) {
	$ymc_filter_bg_color = get_post_meta($id, 'ymc_filter_bg_color', true);
}
if (get_post_meta($id, 'ymc_filter_active_color', true)) {
	$ymc_filter_active_color = get_post_meta($id, 'ymc_filter_active_color', true);
}
if( get_post_meta($id, 'ymc_post_text_color') ) {
	$ymc_post_text_color = get_post_meta($id, 'ymc_post_text_color', true);
}
if( get_post_meta($id, 'ymc_post_bg_color') ) {
	$ymc_post_bg_color = get_post_meta($id, 'ymc_post_bg_color', true);
}
if( get_post_meta($id, 'ymc_post_active_color') ) {
	$ymc_post_active_color = get_post_meta($id, 'ymc_post_active_color', true);
}
if( get_post_meta($id, 'ymc_multiple_filter') ) {
	$ymc_multiple_filter = get_post_meta($id, 'ymc_multiple_filter', true);
}
if( get_post_meta($id, 'ymc_empty_post_result') ) {
	$ymc_empty_post_result = get_post_meta($id, 'ymc_empty_post_result', true);
}
if (get_post_meta($id, 'ymc_link_target')) {
	$ymc_link_target = get_post_meta($id, 'ymc_link_target', true);
}
if (get_post_meta($id, 'ymc_per_page')) {
	$ymc_per_page = get_post_meta($id, 'ymc_per_page', true);
}
if (get_post_meta($id, 'ymc_pagination_type')) {
	$ymc_pagination_type = get_post_meta($id, 'ymc_pagination_type', true);
}
if (get_post_meta($id, 'ymc_sort_terms')) {
	$ymc_sort_terms = get_post_meta($id, 'ymc_sort_terms', true);
}
if (get_post_meta($id, 'ymc_order_post_by')) {
	$ymc_order_post_by = get_post_meta($id, 'ymc_order_post_by', true);
}
if (get_post_meta($id, 'ymc_order_post_type')) {
	$ymc_order_post_type = get_post_meta($id, 'ymc_order_post_type', true);
}
if (get_post_meta($id, 'ymc_special_post_class')) {
	$ymc_special_post_class = get_post_meta($id, 'ymc_special_post_class', true);
}
if (get_post_meta($id, 'ymc_filter_font')) {
	$ymc_filter_font = get_post_meta($id, 'ymc_filter_font', true);
}
if (get_post_meta($id, 'ymc_post_font')) {
	$ymc_post_font = get_post_meta($id, 'ymc_post_font', true);
}
if (get_post_meta($id, 'ymc_filter_search_status', true)) {
	$ymc_filter_search_status = get_post_meta($id, 'ymc_filter_search_status', true);
}
if (get_post_meta($id, 'ymc_search_text_button', true)) {
	$ymc_search_text_button = get_post_meta($id, 'ymc_search_text_button', true);
}
