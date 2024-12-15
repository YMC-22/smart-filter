<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$ymc_post_text_color = !empty($ymc_post_text_color) ? "color:".$ymc_post_text_color.";" : '';
$ymc_post_bg_color   = !empty($ymc_post_bg_color) ? "background-color:".$ymc_post_bg_color.";" : '';
$ymc_post_active_color = !empty($ymc_post_active_color) ? "color:".$ymc_post_active_color.";" : '';
$ymc_post_font = !empty($ymc_post_font) ? "font-family:".$ymc_post_font.";" : '';


$post_css = "
#ymc-smart-filter-container-".$c_target." .container-posts .post-entry {".$ymc_post_text_color."}
#ymc-smart-filter-container-".$c_target." .container-posts .post-entry .ymc-post-layout3 {".$ymc_post_bg_color."}
#ymc-smart-filter-container-".$c_target." .container-posts .post-entry .ymc-post-layout3 .read-more .btn {".$ymc_post_active_color."}
#ymc-smart-filter-container-".$c_target." .ymc-pagination li a {".$ymc_post_text_color . $ymc_post_bg_color."}
#ymc-smart-filter-container-".$c_target." .container-posts .post-entry.post-layout3 {".$ymc_post_font."}";

echo '<style id="'.esc_attr($handle_post).'">'. esc_html(preg_replace('|\s+|', ' ', $post_css)) .'</style>';



