<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Set variables
$ymc_special_post_class = $variable->get_special_post_class( $post->ID );
$ymc_preloader_icon = $variable->get_ymc_preloader_icon( $post->ID );
$ymc_scroll_page = $variable->get_ymc_scroll_page( $post->ID );

?>

<div class="header">
	<?php echo esc_html__('Advanced Options', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <header class="sub-header">
        <i class="far fa-plus-circle"></i>
		<?php echo esc_html__('Add Extra Classes', 'ymc-smart-filter'); ?>
    </header>

    <div class="from-element">
        <label class="form-label">
			<?php echo esc_html__('Add Custom Class', 'ymc-smart-filter');?>
            <span class="information">
                    <?php echo esc_html__('This class will be added to the filter container.', 'ymc-smart-filter');?>
                </span>
        </label>
        <input class="input-field" type="text" name="ymc-special-post-class" value="<?php echo esc_attr($ymc_special_post_class); ?>">
    </div>

</div>

<div class="content" style="margin-top: 40px;">

    <header class="sub-header">
        <i class="far fa-id-badge"></i>
        <?php echo esc_html__('Icon for Preloader', 'ymc-smart-filter'); ?>
    </header>

    <div class="from-element">

        <label class="form-label">
            <?php esc_html_e('Choose Icon for Preloader', 'ymc-smart-filter'); ?>
            <span class="information"><?php esc_html_e('Set icon for preloader while loading posts.', 'ymc-smart-filter'); ?></span>
        </label>

        <select class="form-select ymc-preloader-icon" id="ymc-preloader-icon" name="ymc-preloader-icon">
        <?php
                $selected_preloader = '';
                for ( $i=1 ; $i<=11; $i++ ) {
                    if( $ymc_preloader_icon === 'preloader_'.$i ) {
                        $selected_preloader = 'selected="selected"';
                    }
                    if( $i === 11 ) {
                        echo '<option value="preloader_'.$i.'" '. $selected_preloader .'>'. esc_html('None', 'ymc-smart-filter') .'</option>';
                    }
                    else {
                        echo '<option value="preloader_'.$i.'" '. $selected_preloader .'>'. esc_html('Preloader '.$i, 'ymc-smart-filter') .'</option>';
                    }
                   $selected_preloader = '';
                }
            ?>
        </select>

        <div class="preview-preloader">
             <img src="<?php echo YMC_SMART_FILTER_URL; ?>/includes/assets/images/<?php echo $ymc_preloader_icon; ?>.svg">
        </div>

    </div>

</div>


<div class="content" style="margin-top: 40px;">

    <header class="sub-header">
        <i class="fas fa-scroll"></i>
        <?php echo esc_html__('Scroll Top Page on Pagination', 'ymc-smart-filter'); ?>
    </header>

    <div class="from-element">

        <label class="form-label">
            <?php esc_html_e('Disable Page Scroll to Top', 'ymc-smart-filter'); ?>
            <span class="information"><?php esc_html_e('When you click on numeric pagination, page scroll to top.', 'ymc-smart-filter'); ?></span>
        </label>

        <div class="group-elements">
            <?php $checked_scroll_page =  ( (int) $ymc_scroll_page === 0 ) ? 'checked' : '';  ?>
            <input type="hidden" name="ymc-scroll-page" value="1">
            <input class="ymc-scroll-page" type="checkbox" value="0" name="ymc-scroll-page" id="ymc-scroll-page"
                <?php echo esc_attr($checked_scroll_page); ?>>
            <label for="ymc-scroll-page"><?php echo esc_html__('Disable','ymc-smart-filter'); ?></label>
        </div>

    </div>

</div>