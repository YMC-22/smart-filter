
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
			<?php echo esc_html__('Add CSS Class', 'ymc-smart-filter');?>
            <span class="information">
                    <?php echo esc_html__('This class will add to every post.', 'ymc-smart-filter');?>
                </span>
        </label>
        <input class="input-field" type="text" name="ymc-special-post-class" value="<?php echo esc_attr($ymc_special_post_class); ?>">
    </div>

</div>
