<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$filter_css = "";
if( !empty($ymc_filter_text_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link, 
               #ymc-extra-filter-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link  { color:".$ymc_filter_text_color." }
               
               #ymc-smart-filter-container-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link:before, 
               #ymc-extra-filter-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link:before,
               #ymc-smart-filter-container-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link:after, 
               #ymc-extra-filter-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link:after  { border-color:".$ymc_filter_text_color." }";
}
if( !empty($ymc_filter_bg_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link, 
               #ymc-extra-filter-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link  { background-color:".$ymc_filter_bg_color." }";
}
if( !empty($ymc_filter_active_color) ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link.active,
               #ymc-extra-filter-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link.active { color:".$ymc_filter_active_color."}
               #ymc-smart-filter-container-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link.active:before, 
               #ymc-extra-filter-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link:before,
               #ymc-smart-filter-container-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link.active:after, 
               #ymc-extra-filter-".$c_target." .filter-layout3 .filter-entry .menu-passive .menu-link:after  { border-color:".$ymc_filter_active_color." }";
}
if( $ymc_filter_font !== 'inherit' ) {
	$filter_css .= "#ymc-smart-filter-container-".$c_target." .filter-layout3 .filter-entry,               
               #ymc-extra-filter-".$c_target." .filter-layout3 .filter-entry { font-family:".$ymc_filter_font."}";
}

echo '<style id="'.esc_attr($handle_filter).'">'. esc_html(preg_replace('|\s+|', ' ', $filter_css)) .'</style>';



