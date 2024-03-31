<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>


<div class="header">
	<?php echo esc_html__('Typography', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <header class="sub-header" data-class-name="filter-typography-settings">
        <span class="dashicons dashicons-editor-spellcheck"></span>
		<?php echo esc_html__('Filter Typography', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper filter-typography-settings">

        <div class="from-element">
            <label class="form-label">
                <?php echo esc_html__('Filter Font', 'ymc-smart-filter');?>
                <span class="information">
                    <?php echo esc_html__('Select fonts for filter.', 'ymc-smart-filter');?>
                </span>
            </label>

            <?php $filter_font = apply_filters('ymc_filter_font', ['ymc_filter_font']); ?>

            <select class="form-select"  id="ymc-filter-font" name="ymc-filter-font">
                <?php
                foreach ($filter_font as $key => $font) {

                    if ($ymc_filter_font === $key) {

                        $selected = 'selected';
                    }
                    else {
                        $selected = '';
                    }
                    echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_html($font) . '</option>';
                }
                ?>
            </select>
        </div>

    </div>

    <header class="sub-header" data-class-name="post-typography-settings">
        <span class="dashicons dashicons-editor-spellcheck"></span>
        <?php echo esc_html__('Post Typography', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper post-typography-settings">

        <div class="from-element">
            <label class="form-label">
                <?php echo esc_html__('Post Font', 'ymc-smart-filter');?>
                <span class="information">
                <?php echo esc_html__('Select fonts for posts.', 'ymc-smart-filter');?>
            </span>
            </label>

            <?php $post_font = apply_filters('ymc_post_font', ['ymc_post_font']); ?>

            <select class="form-select"  id="ymc-post-font" name="ymc-post-font">
                <?php
                foreach ($post_font as $key => $font) {

                    if ($ymc_post_font === $key) {

                        $selected = 'selected';
                    }
                    else {
                        $selected = '';
                    }
                    echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_html($font) . '</option>';
                }
                ?>
            </select>

        </div>

    </div>

</div>
