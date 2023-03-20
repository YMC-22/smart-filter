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

?>

<div class="header">
	<?php echo esc_html__('Layouts Options', 'ymc-smart-filter'); ?>
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
                        $filter_layouts = apply_filters('ymc_filter_layouts', $layouts);
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
                    <?php echo esc_html__('Select design layout for posts.', 'ymc-smart-filter');?>
                </span>
                </label>
                <select class="form-select" id="ymc-filter-layout" name="ymc-post-layout">
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



