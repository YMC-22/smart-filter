<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Style
$ymc_post_text_color = !empty($ymc_post_text_color) ? "color:".$ymc_post_text_color.";" : '';
$ymc_post_bg_color   = !empty($ymc_post_bg_color) ? "background-color:".$ymc_post_bg_color.";" : '';
$ymc_post_active_color = !empty($ymc_post_active_color) ? "color:".$ymc_post_active_color.";" : '';
$ymc_post_font = !empty($ymc_post_font) ? "font-family:".$ymc_post_font.";" : '';


$post_css = ".data-target-ymc".$c_target." .container-posts .post-entry {".$ymc_post_text_color."}
.data-target-ymc".$c_target." .container-posts .post-entry .ymc-post-layout2 {".$ymc_post_bg_color."}
.data-target-ymc".$c_target." .container-posts .post-entry.post-layout2 .ymc-post-layout2 .read-more .btn {".$ymc_post_active_color."}
.data-target-ymc".$c_target." .ymc-pagination li a {".$ymc_post_text_color . $ymc_post_bg_color."}
.data-target-ymc".$c_target." .container-posts .post-entry.post-layout2 {".$ymc_post_font."}";

wp_add_inline_style($handle, $post_css);



