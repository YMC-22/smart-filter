<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>


<div class="header">
	<?php echo esc_html__('Search', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <header class="sub-header" data-class-name="search-settings">
        <i class="far fa-search"></i>
		<?php echo esc_html__('Post Search', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper search-settings">

        <div class="form-group wrapper-search">

            <label for="ymc-filter-layout" class="form-label">
                <?php echo esc_html__('Enable / Disable Search', 'ymc-smart-filter');?>
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
                        <?php echo esc_html__('Placeholder Field', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Change placeholder field.', 'ymc-smart-filter');?>
                    </span>
                    </label>

                    <input class="input-field" type="text" name="ymc-search-placeholder" value="<?php echo esc_attr($ymc_search_placeholder); ?>">

                </div>

                <div class="from-element">

                    <label class="form-label">
                        <?php echo esc_html__('Button Text', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Change name of Button Text.', 'ymc-smart-filter');?>
                    </span>
                    </label>

                    <input class="input-field" type="text" name="ymc-search-text-button" value="<?php echo esc_attr($ymc_search_text_button); ?>">

                </div>

                <div class="from-element">

                    <?php $ymc_exact_phrase_sel = ( $ymc_exact_phrase ) ? 'checked' : '';  ?>

                    <label class="form-label">
                        <?php echo esc_html__('Exact Phrase', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Find a post in the title/content/description of which contains exactly the specified phrase and nothing else.', 'ymc-smart-filter');?>
                    </span>
                    </label>

                    <div class="group-elements">
                        <input type="hidden" name="ymc-exact-phrase" value="0">
                        <input class="input-field" type="checkbox" id="ymc-exact-phrase" name="ymc-exact-phrase" value="1"
                            <?php echo esc_attr($ymc_exact_phrase_sel); ?>>
                        <label for="ymc-exact-phrase"><?php echo esc_html__('Enable','ymc-smart-filter'); ?></label>
                    </div>

                </div>

                <div class="from-element">

                    <label class="form-label">
                        <?php echo esc_html__('Autocomplete', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Disable autocomplete for posts search.', 'ymc-smart-filter');?>
                    </span>
                    </label>

                    <div class="group-elements">
                        <?php $checked_autocomplete_state =  ( (int) $ymc_autocomplete_state === 1 ) ? 'checked' : '';  ?>
                        <input type="hidden" name="ymc-autocomplete-state" value="0">
                        <input class="ymc-autocomplete-state" type="checkbox" value="1" name="ymc-autocomplete-state" id="ymc-autocomplete-state"
                            <?php echo esc_attr($checked_autocomplete_state); ?>>
                        <label for="ymc-autocomplete-state"><?php echo esc_html__('Disable','ymc-smart-filter'); ?></label>
                    </div>

                </div>

                <div class="from-element">

                    <label class="form-label">
                        <?php echo esc_html__('Search by Filtered Posts', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Allows to search through already filtered posts (only for standard filter layouts).', 'ymc-smart-filter');?>
                    </span>
                    </label>

                    <div class="group-elements">
                        <?php $search_filtered_posts_state =  ( (int) $ymc_search_filtered_posts === 1 ) ? 'checked' : '';  ?>
                        <input type="hidden" name="ymc-search-filtered-posts" value="0">
                        <input class="ymc-search-filtered-posts" type="checkbox" value="1" name="ymc-search-filtered-posts" id="ymc-search-filtered-posts"
                            <?php echo esc_attr($search_filtered_posts_state); ?>>
                        <label for="ymc-search-filtered-posts"><?php echo esc_html__('Enable','ymc-smart-filter'); ?></label>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
