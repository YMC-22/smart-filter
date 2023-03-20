<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Set variables
$ymc_special_post_class = $variable->get_special_post_class( $post->ID );

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
