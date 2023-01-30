<?php

echo '<div class="sort-container">';
echo '<div class="dropdown-filter">';
echo '<div class="menu-active">';
echo '<span class="name-sort">'.esc_html__('Sort', 'ymc-smart-filter').'</span> <b class="arrow-orderby"></b> <i class="arrow down"></i>';
echo '</div>';
echo '<div class="menu-passive">';
echo '<i class="btn-close">x</i>';
echo '<div class="menu-passive__item"><a class="menu-link" data-order="'.esc_attr('desc').'" data-orderby="'.esc_attr('title').'" href="#">'.esc_html__('Sort by title', 'ymc-smart-filter').'</a></div>';
echo '<div class="menu-passive__item"><a class="menu-link" data-order="'.esc_attr('desc').'" data-orderby="'.esc_attr('date').'" href="#">'.esc_html__('Sort by publication date', 'ymc-smart-filter').'</a></div>';
echo '</div>';
echo '</div>';
echo '</div>';
