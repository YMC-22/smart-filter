<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$filter_css = "";
if( !empty($ymc_filter_text_color) ) {
	$filter_css .= "#ymc-smart-filter-container-" . $c_target . " .filter-range .filter-entry,
	#ymc-extra-filter-" . $c_target . " .filter-range .filter-entry {color:" . $ymc_filter_text_color . "}";

	$filter_css .= "#ymc-smart-filter-container-" . $c_target . " .filter-range .filter-entry .range__component,
	#ymc-extra-filter-" . $c_target . " .filter-range .filter-entry .range__component {color:" . $ymc_filter_text_color . "}";
}
if( !empty($ymc_filter_bg_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-range .filter-entry .range__component:not(.tax-label):not(.apply-button),	
	#ymc-extra-filter-".$c_target." .filter-range .filter-entry .range__component:not(.tax-label):not(.apply-button) {background-color:".$ymc_filter_bg_color."}";

	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-range .filter-entry .tag-values:before,	
	#ymc-extra-filter-".$c_target." .filter-range .filter-entry .tag-values:before {border-top: 12px solid ".$ymc_filter_bg_color."}";
}
if( $ymc_filter_font !== 'inherit' ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-range .filter-entry,               
    #ymc-extra-filter-".$c_target." .filter-range .filter-entry {font-family:".$ymc_filter_font."}";
}

if(!empty($filter_css)) :
	echo '<style id="'.esc_attr($handle_filter).'">'. esc_html(preg_replace('|\s+|', ' ', $filter_css)) .'</style>';
endif;

