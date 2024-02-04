<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Set variables
$ymc_filter_status = $variable->get_filter_status( $post->ID );
$ymc_sort_status   = $variable->get_sort_status( $post->ID );
$ymc_filter_layout = $variable->get_filter_layout( $post->ID );
$ymc_filter_text_color = $variable->get_filter_text_color( $post->ID );
$ymc_filter_bg_color = $variable->get_filter_bg_color( $post->ID );
$ymc_filter_active_color = $variable->get_filter_active_color( $post->ID );
$ymc_multiple_filter = $variable->get_multiple_filter( $post->ID );
$ymc_post_layout = $variable->get_post_layout( $post->ID );
$ymc_post_text_color = $variable->get_post_text_color( $post->ID );
$ymc_post_bg_color = $variable->get_post_bg_color( $post->ID );
$ymc_post_active_color = $variable->get_post_active_color( $post->ID );
$ymc_desktop_xxl = $variable->get_post_desktop_xxl( $post->ID );
$ymc_desktop_xl = $variable->get_post_desktop_xl( $post->ID );
$ymc_desktop_lg = $variable->get_post_desktop_lg( $post->ID );
$ymc_tablet_md = $variable->get_post_tablet_md( $post->ID );
$ymc_tablet_sm = $variable->get_post_tablet_sm( $post->ID );
$ymc_mobile_xs = $variable->get_post_mobile_xs( $post->ID );

?>

<div class="header">
	<?php echo esc_html__('Layouts', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <div class="form-group wrapper-layout">

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
                <header class="sub-header">
                    <i class="far fa-filter"></i>
                    <?php echo esc_html__('Filter layout', 'ymc-smart-filter'); ?>
                </header>
            </div>

            <div class="manage-filters__section">
                <label for="ymc-filter-layout" class="form-label">
		            <?php echo esc_html__('Select Filter Layout', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Select design layout of filters.', 'ymc-smart-filter');?>
                </span>
                </label>
                <select class="form-select" id="ymc-filter-layout" name="ymc-filter-layout">
		            <?php
                        $filter_layouts = apply_filters('ymc_filter_layouts', $layouts=[]);
                        if( $filter_layouts ) :
                            foreach ($filter_layouts as $key => $layout) :

                                $selected = ( $ymc_filter_layout === $key ) ? 'selected' : '';

                                echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_html__($layout, 'ymc-smart-filter') . '</option>';

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
		            <?php echo esc_html__('Multiple Taxonomy Filter', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Multiple filter of posts.', 'ymc-smart-filter');?>
                    </span>
                </label>

                <div class="group-elements">
                    <?php  $check_multiple =  ( (int) $ymc_multiple_filter === 1 ) ? 'checked' : '';  ?>
                    <input type="hidden" name='ymc-multiple-filter' value="0">
                    <input class="ymc-multiple-filter" type="checkbox" value="1"  name='ymc-multiple-filter' id="ymc-multiple-filter" <?php echo esc_attr($check_multiple); ?>/>
                    <label for="ymc-multiple-filter"><?php echo esc_html__('Set Multiple Taxonomy Filter','ymc-smart-filter'); ?></label>
                </div>

            </div>

        </div>

        <div class="manage-post">

            <div class="manage-filters__section">
                <header class="sub-header">
                    <i class="far fa-address-card"></i>
                    <?php echo esc_html__('Post Layout', 'ymc-smart-filter'); ?>
                </header>
            </div>

            <div class="manage-filters__section">
                <label for="ymc-filter-layout" class="form-label">
			        <?php echo esc_html__('Select Post Layout', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Select style design layout for posts.', 'ymc-smart-filter');?>
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

            <?php if( $ymc_post_layout !== 'post-layout3' && $ymc_post_layout !== 'post-masonry' && $ymc_post_layout !== 'post-custom-masonry' ) : ?>
            <div class="manage-filters__section column-layout__section">
                <label for="ymc-filter-layout" class="form-label">
                    <?php echo esc_html__('Select Column Layout', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Select column layout of posts for different screens.', 'ymc-smart-filter');?>
                </span>
                </label>
                <div class="row">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-desktop"></i></span>
                        </div>
                        <input type="number" class="form-control"  placeholder="4" min="1" max="12" name="ymc_desktop_xxl" value="<?php echo $ymc_desktop_xxl; ?>" title="≥1400px">
                   </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-desktop"></i></span>
                        </div>
                        <input type="number" class="form-control"  placeholder="4" min="1" max="12" name="ymc_desktop_xl" value="<?php echo $ymc_desktop_xl; ?>" title="≥1200px">
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-tablet"></i></span>
                        </div>
                        <input type="number" class="form-control"  placeholder="4" min="1" max="12" name="ymc_desktop_lg" value="<?php echo $ymc_desktop_lg; ?>" title="≥992px">
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-tablet"></i></span>
                        </div>
                        <input type="number" class="form-control"  placeholder="3" min="1" max="6" name="ymc_tablet_md" value="<?php echo $ymc_tablet_md; ?>" title="≥768px">
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                        </div>
                        <input type="number" class="form-control"  placeholder="2" min="1" max="4" name="ymc_tablet_sm" value="<?php echo $ymc_tablet_sm; ?>" title="≥576px">
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                        </div>
                        <input type="number" class="form-control"  placeholder="1" min="1" max="4" name="ymc_mobile_xs" value="<?php echo $ymc_mobile_xs; ?>" title="<576px">
                    </div>
                </div>
            </div>
            <?php endif; ?>

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



