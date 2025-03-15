<?php if ( ! defined( 'ABSPATH' ) ) exit;



	// Array letters
    $letters = [
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
    ]

?>


<div id="<?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<?php do_action("ymc_before_filter_layout_".$id.'_'.$c_target); ?>

	<ul class="filter-entry">

		<li class="filter-item">
			<<?php echo esc_attr($ymc_html_tag_button); ?>
            class="filter-link active"
            aria-label="<?php echo esc_html($ymc_post_elements['button_text_all']); ?>"
            role="button"
            data-letter="all">
            <?php echo esc_html($ymc_post_elements['button_text_all']); ?>
            </<?php echo esc_attr($ymc_html_tag_button); ?>>
		</li>

		<?php
			foreach ( $letters as $letter) {
				echo '<li class="filter-item">';
				echo '<'.esc_attr($ymc_html_tag_button).' 
				        class="filter-link" 
				        aria-label="'.esc_html($letter).'" 
				        role="button" data-letter="'.esc_attr($letter).'">'.
                        esc_html($letter) .'</'.esc_attr($ymc_html_tag_button).'>';
				echo '</li>';
			}
		?>

	</ul>

	<div class="posts-found"></div>

	<?php do_action("ymc_after_filter_layout_".$id.'_'.$c_target); ?>

</div>