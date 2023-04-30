<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Set variables
$ymc_empty_post_result = $variable->get_empty_post_result( $post->ID );
$ymc_link_target = $variable->get_link_target( $post->ID );
$ymc_per_page = $variable->get_per_page( $post->ID );
$ymc_pagination_type = $variable->get_pagination_type( $post->ID );
$ymc_pagination_hide = $variable->get_pagination_hide( $post->ID );
$ymc_sort_terms = $variable->get_sort_terms( $post->ID );
$ymc_order_post_by = $variable->get_order_post_by( $post->ID );
$ymc_order_post_type = $variable->get_order_post_type( $post->ID );

?>


<div class="header">
	<?php echo esc_html__('Appearance Options', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <div class="form-group wrapper-layout">

        <div class="appearance-section">

            <header class="sub-header">
                <i class="far fa-filter"></i>
		        <?php echo esc_html__('Filter Options', 'ymc-smart-filter'); ?>
            </header>

            <div class="from-element">
                <label class="form-label">
			        <?php echo esc_html__('Sort Filter Terms', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Set sorting by filter terms.', 'ymc-smart-filter');?>
                </span>
                </label>
                <select class="form-select"  id="ymc-sort-terms" name="ymc-sort-terms">
                    <option value="asc" <?php if ($ymc_sort_terms === 'asc') {echo "selected";} ?>>
			            <?php echo esc_html__('Asc', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="desc" <?php if ($ymc_sort_terms === 'desc') {echo "selected";} ?>>
			            <?php echo esc_html__('Desc', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="manual" <?php if ($ymc_sort_terms === 'manual') {echo "selected";} ?>>
                        <?php echo esc_html__('Manual sort', 'ymc-smart-filter'); ?>
                    </option>
                </select>
            </div>

            <header class="sub-header">
                <i class="far fa-address-card"></i>
			    <?php echo esc_html__('Post Options', 'ymc-smart-filter'); ?>
            </header>

            <div class="from-element">
                <label class="form-label">
		            <?php echo esc_html__('Empty Results', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Enter text to show while empty result posts.', 'ymc-smart-filter');?>
                </span>
                </label>
                <input class="input-field" type="text" name="ymc-empty-post-result" value="<?php echo esc_attr($ymc_empty_post_result); ?>">
            </div>

            <div class="from-element">
                <label class="form-label">
	                <?php echo esc_html__('Post Link', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php echo esc_html__('Select link target post.', 'ymc-smart-filter');?>
                </span>
                </label>
                <select class="form-select"  id="ymc-link-target" name="ymc-link-target">
                    <option value="_self" <?php if ($ymc_link_target === '_self') {echo "selected";} ?>>
                        <?php echo esc_html__('Same Tab', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="_blank" <?php if ($ymc_link_target === '_blank') {echo "selected";} ?>>
                        <?php echo esc_html__('New Tab', 'ymc-smart-filter'); ?>
                    </option>
                </select>
            </div>

            <div class="from-element">
                <label class="form-label">
			        <?php echo esc_html__('Post Order By', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php echo esc_html__('Set sort by posts by.', 'ymc-smart-filter');?>
                </span>
                </label>
                <select class="form-select"  id="ymc-order-post-by" name="ymc-order-post-by">
                <?php
                    $order_post_by = apply_filters('ymc_order_post_by', $order_post_by);

                    foreach ($order_post_by as $key => $value) {

                        if ($ymc_order_post_by === $key) {

                            $selected = 'selected';
                        }
                        else {
                            $selected = '';
                        }
                        echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_html($value) . '</option>';
                    }
                ?>
                </select>
            </div>

            <div class="from-element">
                <label class="form-label">
			        <?php echo esc_html__('Post Order Type', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php echo esc_html__('Set order post type.', 'ymc-smart-filter');?>
                </span>
                </label>
                <select class="form-select"  id="ymc-order-post-type" name="ymc-order-post-type">
                    <option value="asc" <?php if ($ymc_order_post_type === 'asc') {echo "selected";} ?>>
			            <?php echo esc_html__('Asc', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="desc" <?php if ($ymc_order_post_type === 'desc') {echo "selected";} ?>>
			            <?php echo esc_html__('Desc', 'ymc-smart-filter'); ?>
                    </option>
                </select>
            </div>

            <div class="from-element">
                <label class="form-label">
		            <?php echo esc_html__('Post Sorting', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php echo esc_html__('Enable sorting posts on frontend.', 'ymc-smart-filter');?>
                </span>
                </label>

                <div class="ymc-toggle-group">
                    <label class="switch">
                        <input type="checkbox" <?php echo ($ymc_sort_status === "off") ? "checked" : ""; ?>>
                        <input type="hidden" name="ymc-sort-status" value='<?php echo esc_attr($ymc_sort_status); ?>'>
                        <span class="slider"></span>
                    </label>
                </div>

            </div>

            <header class="sub-header">
                <i class="far fa-sort-numeric-asc left" aria-hidden="true"></i>
		        <?php echo esc_html__('Pagination Options', 'ymc-smart-filter'); ?>
            </header>

            <div class="from-element">
                <label class="form-label">
			        <?php echo esc_html__('Posts Per Page', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Select Posts Per Page. Use -1 for all posts.', 'ymc-smart-filter');?>
                </span>
                </label>
                <input class="input-field" type="text" name="ymc-per-page" value="<?php echo esc_attr($ymc_per_page); ?>">
            </div>

            <div class="from-element">

                <label class="form-label">
			        <?php echo esc_html__('Pagination Type', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Select type of pagination.', 'ymc-smart-filter');?>
                </span>
                </label>

	            <?php $pagination_type = apply_filters('ymc_pagination_type', ['ymc_pagination_type']); ?>

                <select class="form-select" id="ymc-pagination-type" name="ymc-pagination-type">
		            <?php
                        foreach ($pagination_type as $key => $ptype) {

                            if ($ymc_pagination_type === $key) {

                                $selected = 'selected';
                            }
                            else {
                                $selected = '';
                            }
                            echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_html($ptype) . '</option>';
                        }
		            ?>
                </select>

            </div>

            <div class="from-element">
                <label class="form-label">
		            <?php echo esc_html__('Disable pagination', 'ymc-smart-filter');?>
                    <span class="information">
                    <?php echo esc_html__('Hide pagination for filter.', 'ymc-smart-filter');?>
                </span>
                </label>

                <div class="group-elements">
		            <?php  $check_pagination_hide = ( $ymc_pagination_hide === 'on' ) ? 'checked' : '';  ?>
                    <input type="hidden" name='ymc-pagination-hide' value="off">
                    <input class="ymc-pagination-hide" type="checkbox" value="on"  name='ymc-pagination-hide' id="ymc-pagination-hide" <?php echo esc_attr($check_pagination_hide); ?>/>
                    <label for="ymc-pagination-hide"><?php echo esc_html__('Disable','ymc-smart-filter'); ?></label>
                </div>

            </div>

        </div>

    </div>

</div>
