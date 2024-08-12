<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Add Style
$ymc_filter_text_color = !empty($ymc_filter_text_color) ? "color:".$ymc_filter_text_color.";" : '';
$ymc_filter_bg_color   = !empty($ymc_filter_bg_color) ? "background-color:".$ymc_filter_bg_color.";" : '';
$ymc_filter_active_color = !empty($ymc_filter_active_color) ? "color:".$ymc_filter_active_color.";" : '';
$ymc_filter_font = "font-family:'".$ymc_filter_font."';";

$filter_css = "#ymc-smart-filter-container-".$c_target." .alphabetical-layout .filter-entry .filter-link,
			   #ymc-extra-filter-".$c_target." .alphabetical-layout .filter-entry .filter-link {". $ymc_filter_text_color . $ymc_filter_bg_color."}
               #ymc-smart-filter-container-".$c_target." .alphabetical-layout .filter-entry .filter-link.active, 
               #ymc-extra-filter-".$c_target." .alphabetical-layout .filter-entry .filter-link.active {".$ymc_filter_active_color."}
               #ymc-smart-filter-container-".$c_target." .alphabetical-layout .filter-entry, 
               #ymc-extra-filter-".$c_target." .alphabetical-layout .filter-entry {".$ymc_filter_font."}";

echo '<style id="'.$handle_filter.'">'. preg_replace('|\s+|', ' ', $filter_css) .'</style>';

	// Array letters
    $letters = [
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
    ]

?>


<div id="<?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<?php do_action("ymc_before_filter_layout_".$id.'_'.$c_target); ?>

	<ul class="filter-entry">

		<li class="filter-item">
			<a class="filter-link active" href="#" data-letter="all"><?php esc_html_e($ymc_post_elements['button_text_all'],'ymc-smart-filter'); ?></a>
		</li>

		<?php

			foreach ( $letters as $letter) {

				echo '<li class="filter-item">';
				echo '<a class="filter-link" href="#" data-letter="'.$letter.'">'. $letter .'</a>';
				echo '</li>';
			}

		?>

	</ul>

	<div class="posts-found"></div>

	<?php do_action("ymc_after_filter_layout_".$id.'_'.$c_target); ?>

</div>