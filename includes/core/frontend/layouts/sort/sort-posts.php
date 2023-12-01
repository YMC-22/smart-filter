<?php

$sort_text = apply_filters('ymc_sort_text_'.$id.'_'.$c_target, __('Sort','ymc-smart-filter'));

echo '<div class="sort-container">';
echo '<div class="dropdown-filter">';
echo '<div class="menu-active">';
echo '<span class="name-sort">'.esc_html__($sort_text, 'ymc-smart-filter').'</span> <b class="arrow-orderby"></b> <i class="arrow down"></i>';
echo '</div>';
echo '<div class="menu-passive">';
echo '<i class="btn-close">x</i>';
$criteria_sort_post =  '<div class="menu-passive__item"><a class="menu-link" data-order="'.esc_attr('desc').'" data-orderby="'.esc_attr('title').'" href="#">'.esc_html__('Sort by title', 'ymc-smart-filter').'</a></div>';
$criteria_sort_post .= '<div class="menu-passive__item"><a class="menu-link" data-order="'.esc_attr('desc').'" data-orderby="'.esc_attr('date').'" href="#">'.esc_html__('Sort by publication date', 'ymc-smart-filter').'</a></div>';
echo apply_filters('ymc_sort_posts_by_'.$id.'_'.$c_target, $criteria_sort_post);
echo '</div>';
echo '</div>';
echo '</div>';



