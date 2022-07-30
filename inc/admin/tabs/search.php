
<div class="header">
	<?php echo esc_html__('Search Options', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <header class="sub-header">
        <i class="far fa-search"></i>
		<?php echo esc_html__('Post Search', 'ymc-smart-filter'); ?>
    </header>

    <div class="form-group wrapper-search">

        <label for="ymc-filter-layout" class="form-label">
		    <?php echo esc_html__('Enable / Disable Post Search', 'ymc-smart-filter');?>
            <span class="information">
                <?php echo esc_html__('Enable / Disable Panel Search.', 'ymc-smart-filter'); ?>
            </span>
        </label>

        <div class="ymc-toggle-group">
            <label class="switch">
                <input type="checkbox" <?php echo ($ymc_filter_search_status === "off") ? "checked" : ""; ?>>
                <input type="hidden" name="ymc-filter-search-status" value='<?php echo esc_attr($ymc_filter_search_status); ?>'>
                <span class="slider slider"></span>
            </label>
        </div>

	    <?php $ymc_hide = ($ymc_filter_search_status === 'on') ? '' : 'ymc_hidden'; ?>

        <div class="manage-filters <?php echo esc_attr($ymc_hide); ?>">

            <div class="from-element">

                <label class="form-label">
			        <?php echo esc_html__('Text Button Search', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Change name of Search button.', 'ymc-smart-filter');?>
                    </span>
                </label>

                <input class="input-field" type="text" name="ymc-search-text-button" value="<?php echo esc_attr($ymc_search_text_button); ?>">

            </div>

        </div>

    </div>

</div>
