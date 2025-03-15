<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$post_css = "";

if(!empty($ymc_post_text_color)) :
	$post_css .= "#ymc-smart-filter-container-".$c_target." .container-posts .post-entry {color:".$ymc_post_text_color."}";
endif;

if(!empty($ymc_post_bg_color)) :
	$post_css .= "#ymc-smart-filter-container-".$c_target." .container-posts .post-entry .ymc-post-layout1 {background-color:".$ymc_post_bg_color."}";
endif;

if(!empty($ymc_post_active_color)) :
	$post_css .= "#ymc-smart-filter-container-".$c_target." .container-posts .post-entry .ymc-post-layout1 .read-more .btn {color:".$ymc_post_active_color."}";
endif;

if(!empty($ymc_post_text_color)) :
	$post_css .= "#ymc-smart-filter-container-".$c_target." .ymc-pagination li a {color:".$ymc_post_text_color."}";
endif;

if(!empty($ymc_post_bg_color)) :
	$post_css .= "#ymc-smart-filter-container-".$c_target." .ymc-pagination li a {background-color:". $ymc_post_bg_color."}";
endif;

if($ymc_post_font !== 'inherit') :
	$post_css .= "#ymc-smart-filter-container-".$c_target." .container-posts .post-entry.post-layout1 {font-family:".$ymc_post_font."}";
endif;

if(!empty($post_css)) :
	echo '<style id="'.esc_attr($handle_post).'">'. esc_html(preg_replace('|\s+|', ' ', $post_css)) .'</style>';
endif;


