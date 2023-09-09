<?php

$custom_width       = $ymc_popup_settings['custom_width'];
$custom_width_unit  = $ymc_popup_settings['custom_width_unit'];
$custom_height      = $ymc_popup_settings['custom_height'];
$custom_height_unit = $ymc_popup_settings['custom_height_unit'];
$custom_bg_overlay  = !empty($ymc_popup_settings['custom_bg_overlay']) ? $ymc_popup_settings['custom_bg_overlay'] : 'rgba(20, 21, 24, 0.6)';
$custom_location    = !empty($ymc_popup_settings['custom_location']) ? $ymc_popup_settings['custom_location'] : 'center';

$style_location = '';

if( $custom_location === 'right center' ) {
	$style_location = 'left: 100%;transform: translate(-100%, -50%);';
}
if( $custom_location === 'left center' ) {
	$style_location = 'left: 0;transform: translate(0%, -50%);';
}

$style_popup = 'style="transform-origin:'.esc_attr($ymc_popup_animation_origin).'; width:'.esc_attr($custom_width).esc_attr($custom_width_unit).';height:'.esc_attr($custom_height).esc_attr($custom_height_unit).';'.esc_attr($style_location).'"';

echo '<div class="ymc-popup-overlay" style="background: '.esc_attr($custom_bg_overlay).'">';
echo '<div class="ymc-popup-wrp popup-'. esc_attr($id).' popup-'. esc_attr($id).'-'.esc_attr($c_target).'" '.$style_popup.'>';

echo '<span class="btn-close" title="Close"><i class="fas fa-times"></i></span>';
echo '<hr/>';
echo '<div class="popup-entry"></div>';

echo '</div>';
echo '</div>';