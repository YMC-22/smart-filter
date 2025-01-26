<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="header">
	<?php echo esc_html__('Layouts', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <div class="form-group wrapper-layout">

        <header class="sub-header" data-class-name="filter-layout-settings">
            <span class="dashicons dashicons-layout"></span>
            <?php echo esc_html__('Filter layout', 'ymc-smart-filter'); ?>
            <i class="fas fa-chevron-down form-arrow"></i>
        </header>

        <div class="form-wrapper filter-layout-settings">

            <div class="switch-wrapper">

                <label for="ymc-filter-layout" class="form-label">
                    <?php echo esc_html__('Enable / Disable Filter', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Enable / Disable filter.', 'ymc-smart-filter'); ?>
                    </span>
                </label>

                <div class="ymc-toggle-group">
                    <label class="switch">
                        <input type="checkbox" <?php echo ($ymc_filter_status === "off") ? "checked" : ""; ?>>
                        <input type="hidden" name="ymc-filter-status" value='<?php echo esc_attr($ymc_filter_status); ?>'>
                        <span class="slider"></span>
                    </label>
                </div>

            </div>

            <?php $ymc_hide = ($ymc_filter_status === 'on') ? '' : 'ymc_hidden'; ?>

            <div class="manage-filters <?php echo esc_attr($ymc_hide); ?>">

                <div class="manage-filters__section">
                    <label for="ymc-filter-layout" class="form-label">
                        <?php echo esc_html__('Filter Layout', 'ymc-smart-filter');?>
                        <span class="information">
                    <?php echo esc_html__('Select layout of filter.', 'ymc-smart-filter');?>
                </span>
                    </label>
                    <select class="form-select" id="ymc-filter-layout" name="ymc-filter-layout">
                        <?php
                        $filter_layouts = apply_filters('ymc_filter_layouts', $layouts=[]);

                        if( $filter_layouts ) :

                            foreach ($filter_layouts as $key => $layout) :

                                if( $key !== 'filter-custom-extra-layout' )
                                {
                                    $selected = ( $ymc_filter_layout === $key ) ? 'selected' : '';

                                    echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' .esc_html($layout) . '</option>';
                                }

                            endforeach;

                        endif;
                        ?>
                    </select>
                </div>

                <div class="manage-filters__section color-setting">

                    <div class="col">
                        <label for="ymc-filter-layout" class="form-label">
                            <?php echo esc_html__('Text Color', 'ymc-smart-filter');?>
                            <span class="information">
                            <?php echo esc_html__('Select text colors for filter layout.', 'ymc-smart-filter');?>
                        </span>
                        </label>
                        <input class="ymc-custom-color" type="text" value="<?php echo esc_attr($ymc_filter_text_color); ?>"  name='ymc-filter-text-color'/>
                    </div>

                    <div class="col">
                        <label for="ymc-filter-layout" class="form-label">
                            <?php echo esc_html__('Background Color', 'ymc-smart-filter');?>
                            <span class="information">
                    <?php echo esc_html__('Select background for filter layout.', 'ymc-smart-filter');?>
                </span>
                        </label>
                        <input class="ymc-custom-color" type="text" value="<?php echo esc_attr($ymc_filter_bg_color); ?>"  name='ymc-filter-bg-color'/>
                    </div>

                    <div class="col">
                        <label for="ymc-filter-layout" class="form-label">
                            <?php echo esc_html__('Active Color', 'ymc-smart-filter');?>
                            <span class="information">
                            <?php echo esc_html__('Select active color for filter layout.', 'ymc-smart-filter');?>
                        </span>
                        </label>
                        <input class="ymc-custom-color" type="text" value="<?php echo esc_attr($ymc_filter_active_color); ?>"  name='ymc-filter-active-color'/>
                    </div>

                </div>

                <div class="manage-filters__section multiple-section">

                    <label  class="form-label">
                        <?php echo esc_html__('Multiple Taxonomy', 'ymc-smart-filter');?>
                        <span class="information">
                    <?php echo esc_html__('Set Multiple Filter of Posts.', 'ymc-smart-filter');?>
                    </span>
                    </label>

                    <div class="group-elements">
                        <?php  $check_multiple =  ( (int) $ymc_multiple_filter === 1 ) ? 'checked' : '';  ?>
                        <input type="hidden" name='ymc-multiple-filter' value="0">
                        <input class="ymc-multiple-filter" type="checkbox" value="1"  name='ymc-multiple-filter' id="ymc-multiple-filter" <?php echo esc_attr($check_multiple); ?>/>
                        <label for="ymc-multiple-filter"><?php echo esc_html__('Enable','ymc-smart-filter'); ?></label>
                    </div>

                </div>

            </div>

        </div>

        <header class="sub-header" data-class-name="post-layout-settings">
            <i class="far fa-address-card"></i>
            <?php echo esc_html__('Post Layout', 'ymc-smart-filter'); ?>
            <i class="fas fa-chevron-down form-arrow"></i>
        </header>

        <div class="form-wrapper post-layout-settings">

            <div class="manage-post">

                <div class="manage-filters__section">
                    <label for="ymc-filter-layout" class="form-label">
                        <?php echo esc_html__('Post Layout', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Select layout for posts.', 'ymc-smart-filter');?>
                        </span>
                    </label>
                    <select class="form-select" id="ymc-post-layout" name="ymc-post-layout">
                        <?php
                        $post_layouts = apply_filters('ymc_post_layouts', $layouts);

                        if($post_layouts) :

                            foreach ($post_layouts as $key => $layout) :

                                $selected = ( $ymc_post_layout === $key ) ? 'selected' : '';

                                echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_attr($layout) . '</option>';

                            endforeach;

                        endif;
                        ?>
                    </select>
                </div>

                <?php
                // Array Post Layouts for Breakpoints
                $layouts_breakpoints = [
                    'post-layout1',
                    'post-layout2',
                    'post-custom-layout'
                ];
                $col_layout_hide = ( in_array($ymc_post_layout, $layouts_breakpoints) ) ? '' : 'ymc_hidden';

                // Show / Hide Carousel Settings
                $carousel_layout_hide = ( $ymc_post_layout === 'post-carousel-layout' ) ? '' : 'ymc_hidden';

                ?>

                <div class="manage-filters__section column-layout__section <?php echo esc_attr($col_layout_hide); ?>">
                    <label for="ymc-filter-layout" class="form-label">
                        <?php echo esc_html__('Column Layout', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Select column layout of posts for different screens.', 'ymc-smart-filter');?>
                        </span>
                    </label>
                    <div class="row">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="≥1400px"><i class="fa fa-desktop"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="4" min="1" max="12" name="ymc_desktop_xxl" value="<?php echo esc_html($ymc_desktop_xxl); ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="≥1200px"><i class="fa fa-desktop"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="4" min="1" max="12" name="ymc_desktop_xl" value="<?php echo esc_html($ymc_desktop_xl); ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="≥992px"><i class="fa fa-tablet"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="4" min="1" max="12" name="ymc_desktop_lg" value="<?php echo esc_html($ymc_desktop_lg); ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="≥768px"><i class="fa fa-tablet"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="3" min="1" max="6" name="ymc_tablet_md" value="<?php echo esc_html($ymc_tablet_md); ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="≥576px"><i class="fa fa-mobile"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="2" min="1" max="4" name="ymc_tablet_sm" value="<?php echo esc_html($ymc_tablet_sm); ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="<576px"><i class="fa fa-mobile"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="1" min="1" max="4" name="ymc_mobile_xs" value="<?php echo esc_html($ymc_mobile_xs); ?>">
                        </div>
                    </div>
                </div>

                <!-- Manage Carousel -->
                <div class="manage-filters__section carousel-settings <?php echo esc_attr($carousel_layout_hide); ?>">

                    <label class="form-label" style="margin-bottom:10px;">
                        <?php echo esc_html__('Carousel Posts', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Set carousel settings.', 'ymc-smart-filter'); ?>
                        </span>
                    </label>

                    <fieldset class="form-fieldset" style="margin-bottom:15px;">
                        <legend class="form-legend"><?php echo esc_html__('General', 'ymc-smart-filter');?></legend>
                        <div class="meta-info">
                            <div class="col">
                                <label><?php echo esc_html__('Auto Height', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Set to true and slider wrapper will adapt its height to the height of the currently active slide."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][autoHeight]">
                                    <option value="false" <?php echo ( $ymc_carousel_params['parameters']['autoHeight'] === 'false') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('False', 'ymc-smart-filter'); ?>
                                    <option value="true" <?php echo ( $ymc_carousel_params['parameters']['autoHeight'] === 'true') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('True', 'ymc-smart-filter'); ?></option>
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Autoplay', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Autoplay slides. Default delay is 3000 ms."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][autoPlay]">
                                    <option value="false" <?php echo ( $ymc_carousel_params['parameters']['autoPlay'] === 'false') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('False', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="true" <?php echo ( $ymc_carousel_params['parameters']['autoPlay'] === 'true') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('True', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Delay', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Delay in autoplay of slides (ms)."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][delay]">
                                    <option value="500" <?php echo ( $ymc_carousel_params['parameters']['delay'] === '500') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('500', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="1000" <?php echo ( $ymc_carousel_params['parameters']['delay'] === '1000') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('1000', 'ymc-smart-filter'); ?></option>
                                    <option value="1500" <?php echo ( $ymc_carousel_params['parameters']['delay'] === '1500') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('1500', 'ymc-smart-filter'); ?></option>
                                    <option value="2000" <?php echo ( $ymc_carousel_params['parameters']['delay'] === '2000') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('2000', 'ymc-smart-filter'); ?></option>
                                    <option value="2500" <?php echo ( $ymc_carousel_params['parameters']['delay'] === '2500') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('2500', 'ymc-smart-filter'); ?></option>
                                    <option value="3000" <?php echo ( $ymc_carousel_params['parameters']['delay'] === '3000') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('3000', 'ymc-smart-filter'); ?></option>
                                    <option value="3500" <?php echo ( $ymc_carousel_params['parameters']['delay'] === '3500') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('3500', 'ymc-smart-filter'); ?></option>
                                    <option value="4000" <?php echo ( $ymc_carousel_params['parameters']['delay'] === '4000') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('4000', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Loop', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Set to true to enable continuous loop mode."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][loop]">
                                    <option value="false" <?php echo ( $ymc_carousel_params['parameters']['loop'] === 'false') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('False', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="true" <?php echo ( $ymc_carousel_params['parameters']['loop'] === 'true') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('True', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Centered', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Active slide will be centered, not always on the left side."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][centeredSlides]">
                                    <option value="false" <?php echo ( $ymc_carousel_params['parameters']['centeredSlides'] === 'false') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('False', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="true" <?php echo ( $ymc_carousel_params['parameters']['centeredSlides'] === 'true') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('True', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Per View', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Number of slides per view."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][slidesPerView]">
                                    <option value="1" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '1') ? 'selected' : ''; ?>>
                                        1</option>
                                    <option value="1.5" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '1.5') ? 'selected' : ''; ?>>
                                        1.5</option>
                                    <option value="2" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '2') ? 'selected' : ''; ?>>
                                        2</option>
                                    <option value="2.5" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '2.5') ? 'selected' : ''; ?>>
                                        2.5</option>
                                    <option value="3" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '3') ? 'selected' : ''; ?>>
                                        3</option>
                                    <option value="3.5" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '3.5') ? 'selected' : ''; ?>>
                                        3.5</option>
                                    <option value="4" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '4') ? 'selected' : ''; ?>>
                                        4</option>
                                    <option value="4.5" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '4.5') ? 'selected' : ''; ?>>
                                        4.5</option>
                                    <option value="5" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '5') ? 'selected' : ''; ?>>
                                        5</option>
                                    <option value="5.5" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '5.5') ? 'selected' : ''; ?>>
                                        5.5</option>
                                    <option value="6" <?php echo ( $ymc_carousel_params['parameters']['slidesPerView'] === '6') ? 'selected' : ''; ?>>
                                        6</option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Space', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Distance between slides in px."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][spaceBetween]">
                                    <option value="0" <?php echo ( $ymc_carousel_params['parameters']['spaceBetween'] === '0') ? 'selected' : ''; ?>>
                                        0</option>
                                    <option value="20" <?php echo ( $ymc_carousel_params['parameters']['spaceBetween'] === '20') ? 'selected' : ''; ?>>
                                        20</option>
                                    <option value="40" <?php echo ( $ymc_carousel_params['parameters']['spaceBetween'] === '40') ? 'selected' : ''; ?>>
                                        40</option>
                                    <option value="60" <?php echo ( $ymc_carousel_params['parameters']['spaceBetween'] === '60') ? 'selected' : ''; ?>>
                                        60</option>
                                    <option value="80" <?php echo ( $ymc_carousel_params['parameters']['spaceBetween'] === '80') ? 'selected' : ''; ?>>
                                        80</option>
                                    <option value="100" <?php echo ( $ymc_carousel_params['parameters']['spaceBetween'] === '100') ? 'selected' : ''; ?>>
                                        100</option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Mouse Wheel', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Enables navigation through slides using mouse wheel."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][mousewheel]">
                                    <option value="false" <?php echo ( $ymc_carousel_params['parameters']['mousewheel'] === 'false') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('False', 'ymc-smart-filter'); ?></option>
                                    <option value="true" <?php echo ( $ymc_carousel_params['parameters']['mousewheel'] === 'true') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('True', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Speed', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Duration of transition between slides (in ms)."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][speed]">
                                    <option value="300" <?php echo ( $ymc_carousel_params['parameters']['speed'] === '300') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('300', 'ymc-smart-filter'); ?></option>
                                    <option value="700" <?php echo ( $ymc_carousel_params['parameters']['speed'] === '700') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('700', 'ymc-smart-filter'); ?></option>
                                    <option value="1000" <?php echo ( $ymc_carousel_params['parameters']['speed'] === '1000') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('1000', 'ymc-smart-filter'); ?></option>
                                    <option value="1500" <?php echo ( $ymc_carousel_params['parameters']['speed'] === '1500') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('1500', 'ymc-smart-filter'); ?></option>
                                    <option value="2000" <?php echo ( $ymc_carousel_params['parameters']['speed'] === '2000') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('2000', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Effect', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Transition effect."></i></label>
                                <select class="form-select" name="ymc_carousel_params[parameters][effect]">
                                    <option value="slide" <?php echo ( $ymc_carousel_params['parameters']['effect'] === 'slide') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Slide', 'ymc-smart-filter'); ?></option>
                                    <option value="fade" <?php echo ( $ymc_carousel_params['parameters']['effect'] === 'fade') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Fade', 'ymc-smart-filter'); ?></option>
                                    <option value="flip" <?php echo ( $ymc_carousel_params['parameters']['effect'] === 'flip') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Flip', 'ymc-smart-filter'); ?></option>
                                    <option value="coverflow" <?php echo ( $ymc_carousel_params['parameters']['effect'] === 'coverflow') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Coverflow', 'ymc-smart-filter'); ?></option>
                                    <option value="cube" <?php echo ( $ymc_carousel_params['parameters']['effect'] === 'cube') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Cube', 'ymc-smart-filter'); ?></option>
                                    <option value="cards" <?php echo ( $ymc_carousel_params['parameters']['effect'] === 'cards') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Cards', 'ymc-smart-filter'); ?></option>
                                    <option value="creative" <?php echo ( $ymc_carousel_params['parameters']['effect'] === 'creative') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Creative', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-fieldset" style="margin-bottom:15px;">
                        <legend class="form-legend"><?php echo esc_html__('Pagination', 'ymc-smart-filter');?></legend>
                        <div class="meta-info">
                            <div class="col">
                                <label><?php echo esc_html__('Visibility', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Pagination visibility."></i></label>
                                <select class="form-select" name="ymc_carousel_params[pagination][visibility]">
                                    <option value="true" <?php echo ( $ymc_carousel_params['pagination']['visibility'] === 'true') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('True', 'ymc-smart-filter'); ?></option>
                                    </option>
                                    <option value="false" <?php echo ( $ymc_carousel_params['pagination']['visibility'] === 'false') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('False', 'ymc-smart-filter'); ?>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Dynamic Bullets', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Good to enable if you use bullets pagination with a lot of slides."></i></label>
                                <select class="form-select" name="ymc_carousel_params[pagination][dynamicBullets]">
                                    <option value="false" <?php echo ( $ymc_carousel_params['pagination']['dynamicBullets'] === 'false') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('False', 'ymc-smart-filter'); ?>
                                    <option value="true" <?php echo ( $ymc_carousel_params['pagination']['dynamicBullets'] === 'true') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('True', 'ymc-smart-filter'); ?></option>
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <label><?php echo esc_html__('Type', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Type of pagination."></i></label>
                                <select class="form-select" name="ymc_carousel_params[pagination][type]">
                                    <option value="bullets" <?php echo ( $ymc_carousel_params['pagination']['type'] === 'bullets') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Bullets', 'ymc-smart-filter'); ?>
                                    <option value="fraction" <?php echo ( $ymc_carousel_params['pagination']['type'] === 'fraction') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Fraction', 'ymc-smart-filter'); ?></option>
                                    </option>
                                    <option value="progressbar" <?php echo ( $ymc_carousel_params['pagination']['type'] === 'progressbar') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('Progressbar', 'ymc-smart-filter'); ?></option>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-fieldset" style="margin-bottom:15px;">
                        <legend class="form-legend"><?php echo esc_html__('Navigation', 'ymc-smart-filter');?></legend>
                        <div class="meta-info">
                            <div class="col">
                                <label><?php echo esc_html__('Visibility', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Navigation visibility."></i></label>
                                <select class="form-select" name="ymc_carousel_params[navigation][visibility]">
                                    <option value="true" <?php echo ( $ymc_carousel_params['navigation']['visibility'] === 'true') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('True', 'ymc-smart-filter'); ?></option>
                                    </option>
                                    <option value="false" <?php echo ( $ymc_carousel_params['navigation']['visibility'] === 'false') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('False', 'ymc-smart-filter'); ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-fieldset" style="margin-bottom:15px;">
                        <legend class="form-legend"><?php echo esc_html__('Scrollbar', 'ymc-smart-filter');?></legend>
                        <div class="meta-info">
                            <div class="col">
                                <label><?php echo esc_html__('Visibility', 'ymc-smart-filter');?>
                                    <i class="fas fa-info-circle" title="Scrollbar visibility."></i></label>
                                <select class="form-select" name="ymc_carousel_params[scroll][visibility]">
                                    <option value="false" <?php echo ( $ymc_carousel_params['scroll']['visibility'] === 'false') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('False', 'ymc-smart-filter'); ?>
                                    <option value="true" <?php echo ( $ymc_carousel_params['scroll']['visibility'] === 'true') ? 'selected' : ''; ?>>
                                        <?php echo esc_html__('True', 'ymc-smart-filter'); ?></option>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <div class="from-element">
                        <label class="form-label"><?php echo esc_html__('Custom Carousel', 'ymc-smart-filter');?>
                            <span class="information">
                                <?php echo wp_kses_post('Deactivate the carousel. Override your custom carousel settings in your JS file. 
                                Use plugin hooks to initialize the carousel asynchronously. 
                                The carousel is implemented using the <a href="https://swiperjs.com/swiper-api#parameters" target="_blank">Swiper API</a>.'); ?>
                                <span class="tooltip-link">Usage example.
                                    <span class="tooltip-text">
                                        wp.hooks.addAction('ymc_complete_loaded_data_545', 'smartfilter', function(class_name, status) {<br>
                                        &nbsp;&nbsp;&nbsp;new Swiper('.swiper-545', {<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; speed: 400,<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; spaceBetween: 100,<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // do something...<br>
                                        &nbsp;&nbsp;&nbsp;});<br>
                                        });<br>
                                    </span>
                                </span>
                            </span>
                        </label>
                        <div class="group-elements">
                            <?php  $carousel_enabled = ( $ymc_carousel_params['parameters']['disabled'] === 'false' ) ? 'checked' : '';  ?>
                            <input type="hidden" name="ymc_carousel_params[parameters][disabled]" value="true">
                            <input id="ymc_carousel_params_custom" class="ymc-pagination-hide" type="checkbox" value="false" name="ymc_carousel_params[parameters][disabled]"
                                <?php echo esc_attr($carousel_enabled); ?>>
                            <label for="ymc_carousel_params_custom"><?php echo esc_html__('Disable', 'ymc-smart-filter');?></label>
                        </div>
                    </div>

                    <hr>

                </div>

                <div class="manage-filters__section">

                    <div class="manage-filters__section color-setting">

                        <div class="col">
                            <label for="ymc-filter-layout" class="form-label">
                                <?php echo esc_html__('Text Color', 'ymc-smart-filter');?>
                                <span class="information">
                            <?php echo esc_html__('Select text colors for post layout.', 'ymc-smart-filter');?>
                        </span>
                            </label>
                            <input class="ymc-custom-color" type="text" value="<?php echo esc_attr($ymc_post_text_color); ?>"  name='ymc-post-text-color'/>
                        </div>

                        <div class="col">
                            <label for="ymc-filter-layout" class="form-label">
                                <?php echo esc_html__('Background Color', 'ymc-smart-filter');?>
                                <span class="information">
                    <?php echo esc_html__('Select background for post layout.', 'ymc-smart-filter');?>
                </span>
                            </label>
                            <input class="ymc-custom-color" type="text" value="<?php echo esc_attr($ymc_post_bg_color); ?>"  name='ymc-post-bg-color'/>
                        </div>

                        <div class="col">
                            <label for="ymc-filter-layout" class="form-label">
                                <?php echo esc_html__('Active Color', 'ymc-smart-filter');?>
                                <span class="information">
                            <?php echo esc_html__('Select active color for links.', 'ymc-smart-filter');?>
                        </span>
                            </label>
                            <input class="ymc-custom-color" type="text" value="<?php echo esc_attr($ymc_post_active_color); ?>"  name='ymc-post-active-color'/>
                        </div>

                    </div>

                </div>

            </div>

	        <?php $ymc_hide = ($ymc_featured_post_status === 'on') ? '' : 'ymc_hidden'; ?>

            <div class="manage-post featured-posts-wrp <?php echo esc_attr($ymc_hide); ?>">

                <hr>

                <div class="manage-filters__section">

                    <label for="ymc-filter-layout" class="form-label">
		                <?php echo esc_html__('Featured Post Layout', 'ymc-smart-filter');?>
                        <span class="information">
                        <?php echo esc_html__('Select layout for featured posts.', 'ymc-smart-filter');?>
                        </span>
                    </label>

                    <select class="form-select" id="ymc_featured_post_layout" name="ymc_featured_post_layout">
	                <?php
	                    $featured_post_layouts = apply_filters('ymc_featured_post_layout', $layouts);

	                    if( $featured_post_layouts ) :

		                    foreach ( $featured_post_layouts as $key => $layout ) :

			                    $selected = ( $ymc_featured_post_layout === $key ) ? 'selected' : '';

			                    echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_attr($layout) . '</option>';

		                    endforeach;

	                    endif;
	                ?>
                    </select>

                </div>

            </div>

        </div>

    </div>

</div>



