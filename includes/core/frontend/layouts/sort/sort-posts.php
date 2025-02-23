<?php

$sort_text = __('Sort','ymc-smart-filter');
$sort_text = apply_filters('ymc_sort_text_'.$id, $sort_text);
$sort_text = apply_filters('ymc_sort_text_'.$id.'_'.$c_target, $sort_text);

echo '<div class="sort-container">';
echo '<div class="dropdown-filter">';
echo '<div class="menu-active">';
echo '<span class="name-sort">'. esc_html($sort_text) .'</span> <b class="arrow-orderby"></b> <i class="arrow down"></i>';
echo '</div>';
echo '<div class="menu-passive">';
echo '<i class="btn-close">x</i>';
$criteria_sort_post =  '<div class="menu-passive__item"><a class="menu-link" data-order="'.esc_attr('desc').'" data-orderby="'.esc_attr('title').'" href="#">'.esc_html__('Sort by title', 'ymc-smart-filter').'</a></div>';
$criteria_sort_post .= '<div class="menu-passive__item"><a class="menu-link" data-order="'.esc_attr('desc').'" data-orderby="'.esc_attr('date').'" href="#">'.esc_html__('Sort by publication date', 'ymc-smart-filter').'</a></div>';
// phpcs:ignore WordPress
$criteria_sort_post = apply_filters('ymc_sort_posts_by_'.esc_attr($id), $criteria_sort_post);
$criteria_sort_post = apply_filters('ymc_sort_posts_by_'.esc_attr($id).'_'.esc_attr($c_target), $criteria_sort_post);
// phpcs:ignore WordPress
echo $criteria_sort_post;
echo '</div>';
echo '</div>';
echo '</div>';



