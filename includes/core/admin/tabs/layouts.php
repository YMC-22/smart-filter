<?php if ( ! defined( 'ABSPATH' ) ) exit;

?>

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

                                    echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_html__($layout, 'ymc-smart-filter') . '</option>';
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
                $arr_layouts_posts = [
                    'post-layout1',
                    'post-layout2',
                    'post-custom-layout'
                ];
                $col_layout_hide = ( in_array($ymc_post_layout, $arr_layouts_posts) ) ? '' : 'ymc_hidden';
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
                            <input type="number" class="form-control"  placeholder="4" min="1" max="12" name="ymc_desktop_xxl" value="<?php echo $ymc_desktop_xxl; ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="≥1200px"><i class="fa fa-desktop"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="4" min="1" max="12" name="ymc_desktop_xl" value="<?php echo $ymc_desktop_xl; ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="≥992px"><i class="fa fa-tablet"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="4" min="1" max="12" name="ymc_desktop_lg" value="<?php echo $ymc_desktop_lg; ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="≥768px"><i class="fa fa-tablet"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="3" min="1" max="6" name="ymc_tablet_md" value="<?php echo $ymc_tablet_md; ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="≥576px"><i class="fa fa-mobile"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="2" min="1" max="4" name="ymc_tablet_sm" value="<?php echo $ymc_tablet_sm; ?>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" title="<576px"><i class="fa fa-mobile"></i></span>
                            </div>
                            <input type="number" class="form-control"  placeholder="1" min="1" max="4" name="ymc_mobile_xs" value="<?php echo $ymc_mobile_xs; ?>">
                        </div>
                    </div>
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
        </div>

    </div>

</div>



