<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Set variables
$ymc_special_post_class = $variable->get_special_post_class( $post->ID );
$ymc_preloader_icon = $variable->get_ymc_preloader_icon( $post->ID );
$ymc_scroll_page = $variable->get_ymc_scroll_page( $post->ID );
$ymc_preloader_filters = $variable->get_ymc_preloader_filters( $post->ID );
$ymc_preloader_filters_rate = $variable->get_ymc_preloader_filters_rate( $post->ID );
$ymc_preloader_filters_custom = $variable->get_ymc_preloader_filters_custom( $post->ID );
$ymc_advanced_query_status = $variable->get_ymc_advanced_query_status( $post->ID );
$ymc_query_type = $variable->get_ymc_query_type( $post->ID );
$ymc_query_type_custom = $variable->get_ymc_query_type_custom( $post->ID );
$ymc_query_type_callback = $variable->get_ymc_query_type_callback( $post->ID );

?>

<div class="header">
	<?php echo esc_html__('Advanced', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <header class="sub-header">
        <i class="far fa-database"></i>
        <?php echo esc_html__('Query', 'ymc-smart-filter'); ?>
    </header>

    <div class="form-group">

        <label class="form-label">
            <?php echo esc_html__('Advanced Query', 'ymc-smart-filter');?>
            <span class="information">
                    <?php echo esc_html__('Enable to build a custom query using your own parameters.', 'ymc-smart-filter');?>
                </span>
        </label>

        <div class="ymc-toggle-group">
            <label class="switch">
                <input type="checkbox" <?php echo ($ymc_advanced_query_status === "off") ? "checked" : ""; ?>>
                <input type="hidden" name="ymc-advanced-query-status" value='<?php echo esc_attr($ymc_advanced_query_status); ?>'>
                <span class="slider slider"></span>
            </label>
        </div>

        <?php $ymc_hide = ($ymc_advanced_query_status === 'on') ? '' : 'ymc_hidden'; ?>

        <div class="manage-filters <?php echo esc_attr($ymc_hide); ?>">

            <div class="type-query">

                <label class="form-label">
                    <?php echo esc_html__('Query Type', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php _e('Select the type of query construction', 'ymc-smart-filter'); ?>
                </span>
                </label>

                <select class="form-select ymc-query-type" name="ymc-query-type" id="ymc-query-type">
                    <option value="query_custom" <?php echo ( $ymc_query_type === 'query_custom') ? 'selected' : ''; ?>>
                        <?php _e('Advanced (custom arguments)','ymc-smart-filter'); ?></option>
                    <option value="query_callback" <?php echo ( $ymc_query_type === 'query_callback') ? 'selected' : ''; ?>>
                        <?php _e('Callback (theme function)','ymc-smart-filter'); ?></option>
                </select>
            </div>
            
            <div class="type-query-content query_custom <?php echo ( $ymc_query_type === 'query_callback') ? 'ymc_hidden' : ''; ?>">
                 <label class="form-label">
                    <?php echo esc_html__('Query Parameter String', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php _e('Build a query according to the WordPress Codex in string format or enter a 
                    custom callback function name that will return an array of query arguments.
                    <a href="https://developer.wordpress.org/reference/classes/wp_query/" target="_blank">
                    view docs <img draggable="false" role="img" class="emoji" alt="↗" src="https://s.w.org/images/core/emoji/14.0.0/svg/2197.svg"></a>
                    ', 'ymc-smart-filter'); ?>
                </span>
                </label>

                 <textarea class="form-textarea custom_query_args" name="ymc-query-type-custom" id="ymc-custom-query-args"
                 placeholder="posts_per_page=-1&post_type=portfolio&post_status=publish"><?php echo (!empty($ymc_query_type_custom)) ? $ymc_query_type_custom : ''; ?></textarea>
            </div>

            <div class="type-query-content query_callback <?php echo ( $ymc_query_type === 'query_custom') ? 'ymc_hidden' : ''; ?>">
                <label class="form-label">
                    <?php echo esc_html__('Callback Function Name', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php _e('Callback functions must be <a href="https://github.com/YMC-22/smart-filter?tab=readme-ov-file#callback-function" target="_blank">whitelisted</a> for security reasons 
                                  (<a href="https://github.com/YMC-22/smart-filter?tab=readme-ov-file#advanced-query" target="_blank">see docs</a>).', 'ymc-smart-filter'); ?>
                </span>
                </label>

                <select class="form-select ymc-query-type-callback" name="ymc-query-type-callback" id="ymc-query-type-callback">
                    <?php
                        if( defined( 'YMC_CALLBACK_FUNCTION_WHITELIST' ) && is_array( YMC_CALLBACK_FUNCTION_WHITELIST ))
                        {
                            foreach ( YMC_CALLBACK_FUNCTION_WHITELIST as $func_name ) : ?>
                                <option value="<?php echo $func_name; ?>" <?php echo ( $ymc_query_type_callback === $func_name) ? "selected" : ""; ?>><?php echo $func_name; ?></option>
                            <?php endforeach;
                        }
                        else {
                            echo '<option value="">'. __('No callback functions','ymc-smart-filter') .'</option>';
                        }
                    ?>
                </select>
            </div>

        </div>

    </div>

</div>

<div class="content" style="margin-bottom: 40px;">

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

<div class="content" style="margin-bottom: 40px;">

    <header class="sub-header">
        <i class="far fa-id-badge"></i>
        <?php echo esc_html__('Icon for Preloader', 'ymc-smart-filter'); ?>
    </header>

    <div class="form-group">

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
             <img src="<?php echo YMC_SMART_FILTER_URL; ?>/includes/assets/images/<?php echo $ymc_preloader_icon; ?>.svg"
                  style="<?php echo ( $ymc_preloader_filters !== 'none' ) ?
                      ( $ymc_preloader_filters !== 'custom_filters' ) ?
                        'filter:'.$ymc_preloader_filters.'('.$ymc_preloader_filters_rate.')' : $ymc_preloader_filters_custom : 'filter: none'; ?>">
        </div>
    </div>

    <div class="form-group filter-list">
        <label class="form-label">
            <?php esc_html_e('Apply a Filter CSS for Preloader Icon', 'ymc-smart-filter'); ?>
            <span class="information"><?php esc_html_e('Choose a filter CSS to change the color of the icon.', 'ymc-smart-filter'); ?></span>
        </label>
        <select class="form-select ymc-filter-preloader" id="ymc-filter-preloader" name="ymc-preloader-filters">
            <option value="none" <?php echo ( $ymc_preloader_filters === 'none') ? 'selected' : ''; ?>>
                <?php esc_html_e('Select a filter', 'ymc-smart-filter'); ?></option>
            <option value="brightness" <?php echo ( $ymc_preloader_filters === 'brightness') ? 'selected' : ''; ?>>
                <?php esc_html_e('Brightness', 'ymc-smart-filter'); ?></option>
            <option value="contrast" <?php echo ( $ymc_preloader_filters === 'contrast') ? 'selected' : ''; ?>>
                <?php esc_html_e('Contrast', 'ymc-smart-filter'); ?></option>
            <option value="grayscale" <?php echo ( $ymc_preloader_filters === 'grayscale') ? 'selected' : ''; ?>>
                <?php esc_html_e('Grayscale', 'ymc-smart-filter'); ?></option>
            <option value="invert" <?php echo ( $ymc_preloader_filters === 'invert') ? 'selected' : ''; ?>>
                <?php esc_html_e('Invert', 'ymc-smart-filter'); ?></option>
            <option value="opacity" <?php echo ( $ymc_preloader_filters === 'opacity') ? 'selected' : ''; ?>>
                <?php esc_html_e('Opacity', 'ymc-smart-filter'); ?></option>
            <option value="saturate" <?php echo ( $ymc_preloader_filters === 'saturate') ? 'selected' : ''; ?>>
                <?php esc_html_e('Saturate', 'ymc-smart-filter'); ?></option>
            <option value="sepia" <?php echo ( $ymc_preloader_filters === 'sepia') ? 'selected' : ''; ?>>
                <?php esc_html_e('Sepia', 'ymc-smart-filter'); ?></option>
            <option value="custom_filters" <?php echo ( $ymc_preloader_filters === 'custom_filters') ? 'selected' : ''; ?>>
                <?php esc_html_e('Custom Filters', 'ymc-smart-filter'); ?></option>
        </select>
    </div>

    <div class="form-group filter-rate <?php echo ( $ymc_preloader_filters !== 'custom_filters' && $ymc_preloader_filters !== 'none' ) ? '' : 'ymc_hidden'; ?>">
        <label class="form-label">
            <?php esc_html_e('Value a Filter CSS ', 'ymc-smart-filter'); ?>
            <span class="information"><?php esc_html_e('Set value from 0-1.', 'ymc-smart-filter'); ?></span>
        </label>
        <div class="range-wrapper">
            <span>0</span>
            <input type="range" id="ymc-filter-rate" name="ymc-preloader-filters-rate"
                   value="<?php echo $ymc_preloader_filters_rate; ?>" step="0.001" min="0" max="1" />
            <span>1</span>
        </div>
    </div>

    <div class="form-group filters-custom <?php echo ( $ymc_preloader_filters === 'custom_filters' ) ? '' : 'ymc_hidden'; ?>">
        <label class="form-label">
            <?php esc_html_e('Custom Filters CSS for Preloader Icon', 'ymc-smart-filter'); ?>
            <span class="information"><?php _e('Add a list of filters.  <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/CSS/filter">more detail</a>', 'ymc-smart-filter'); ?></span>
        </label>
        <input type="text" id="ymc-filters-custom" name="ymc-preloader-filters-custom" value="<?php echo $ymc_preloader_filters_custom; ?>" placeholder="filter: grayscale(0.5) brightness(0.7)" />
    </div>

</div>

<div class="content" style="margin-bottom: 40px;">

    <header class="sub-header">
        <i class="fas fa-scroll"></i>
        <?php echo esc_html__('Scroll Top Page on Pagination', 'ymc-smart-filter'); ?>
    </header>

    <div class="form-group">

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