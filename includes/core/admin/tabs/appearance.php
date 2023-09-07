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
$ymc_meta_key = $variable->get_ymc_meta_key( $post->ID );
$ymc_meta_value = $variable->get_ymc_meta_value( $post->ID );
$ymc_multiple_sort = $variable->get_ymc_multiple_sort( $post->ID );
$ymc_post_status = $variable->get_ymc_post_status( $post->ID );
$ymc_post_animation  = $variable->get_ymc_post_animation( $post->ID );
$ymc_popup_status  = $variable->get_ymc_popup_status( $post->ID );

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
			        <?php echo esc_html__('Sort Terms', 'ymc-smart-filter');?>
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
                    <?php echo esc_html__('Enable / Disable Sorting', 'ymc-smart-filter'); ?>
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

                    $order_post_by = null;

                    $order_post_by = apply_filters('ymc_order_post_by', $order_post_by);

                    if( !empty($order_post_by) ) :

                    foreach ($order_post_by as $key => $value) {

                        if ($ymc_order_post_by === $key) {

                            $selected = 'selected';
                        }
                        else {
                            $selected = '';
                        }
                        echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_html($value) . '</option>';
                    }

                    endif;
                ?>
                </select>
            </div>

            <div class="from-element from-element--meta-sort  <?php echo ( $ymc_order_post_by !== 'meta_key') ? 'ymc_hidden' : ''; ?>">

                <label class="form-label">
                    <?php echo esc_html__('Sorting by custom (meta) field', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php echo esc_html__('Set value of meta_key parameter (field data key)', 'ymc-smart-filter');?>
                    </span>
                </label>

                <input class="input-field" type="text" placeholder="meta_key" name="ymc-meta-key"
                       value="<?php echo ( !empty($ymc_meta_key) ) ? $ymc_meta_key : ''?>">

                <label class="form-label">
                    <span class="information">
                    <?php echo esc_html__('Set options: meta_value or meta_value_num (for numbers) to sort by meta field', 'ymc-smart-filter');?>
                    </span>
                </label>

                <input class="input-field" type="text" placeholder="meta_value or meta_value_num" name="ymc-meta-value"
                       value="<?php echo ( !empty($ymc_meta_value) ) ? $ymc_meta_value : ''?>">

            </div>

            <div class="from-element from-element--order-sort <?php echo ( $ymc_order_post_by === 'multiple_fields' || $ymc_order_post_by === 'multiple_meta_fields' ) ? 'ymc_hidden' : ''; ?>">
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

            <div class="from-element from-element--multiple-sort <?php echo ( $ymc_order_post_by === 'multiple_fields' || $ymc_order_post_by === 'multiple_meta_fields' ) ? '' : 'ymc_hidden'; ?>">

                <?php

                    if( $ymc_multiple_sort ) : $i = 0;

                        foreach ($ymc_multiple_sort as $item) : ?>

                            <div class="rows-options">
                                <fieldset class="rows-options__col">
                                    <legend><?php echo esc_html__('Field name', 'ymc-smart-filter'); ?></legend>
                                    <select class="form-select ymc-multiple-orderby"  name="ymc-multiple-sort[<?php echo $i; ?>][orderby]">
                                        <option value="title" <?php if ( in_array('title', $item) ) { echo "selected"; } ?>>
                                            <?php echo esc_html__('Title', 'ymc-smart-filter'); ?>
                                        </option>
                                        <option value="name" <?php if ( in_array('name', $item) ) { echo "selected"; } ?>>
                                            <?php echo esc_html__('Name', 'ymc-smart-filter'); ?>
                                        </option>
                                        <option value="date" <?php if ( in_array('date', $item) ) { echo "selected"; } ?>>
                                            <?php echo esc_html__('Date', 'ymc-smart-filter'); ?>
                                        </option>
                                        <option value="ID" <?php if ( in_array('ID', $item) ) { echo "selected"; } ?>>
                                            <?php echo esc_html__('ID', 'ymc-smart-filter'); ?>
                                        </option>
                                        <option value="author" <?php if ( in_array('author', $item) ) { echo "selected"; } ?>>
                                            <?php echo esc_html__('Author', 'ymc-smart-filter'); ?>
                                        </option>
                                        <option value="modified" <?php if ( in_array('modified', $item) ) { echo "selected"; } ?>>
                                            <?php echo esc_html__('Modified', 'ymc-smart-filter'); ?>
                                        </option>
                                        <option value="type" <?php if ( in_array('type', $item) ) { echo "selected"; } ?>>
                                            <?php echo esc_html__('Type ', 'ymc-smart-filter'); ?>
                                        </option>
                                        <option value="parent" <?php if ( in_array('parent', $item) ) { echo "selected"; } ?>>
                                            <?php echo esc_html__('Parent ', 'ymc-smart-filter'); ?>
                                        </option>
                                        <option value="rand" <?php if ( in_array('rand', $item) ) { echo "selected"; } ?>>
                                            <?php echo esc_html__('Rand ', 'ymc-smart-filter'); ?>
                                        </option>
                                    </select>
                                </fieldset>
                                <fieldset class="rows-options__col">
                                    <legend><?php echo esc_html__('Post Order Type', 'ymc-smart-filter'); ?></legend>
                                    <select class="form-select ymc-multiple-order"  name="ymc-multiple-sort[<?php echo $i; ?>][order]">
                                        <option value="asc" <?php if ( in_array('asc', $item) ) { echo "selected"; } ?>>
                                        <?php echo esc_html__('Asc', 'ymc-smart-filter'); ?>
                                        </option>
                                        <option value="desc" <?php if ( in_array('desc', $item) ) { echo "selected"; } ?>>
                                        <?php echo esc_html__('Desc', 'ymc-smart-filter'); ?>
                                        </option>
                                    </select>
                                </fieldset>
                           </div>

                        <?php $i++; endforeach;

                    else : ?>

                        <div class="rows-options">
                            <fieldset class="rows-options__col">
                                <legend><?php echo esc_html__('Field name', 'ymc-smart-filter'); ?></legend>
                                <select class="form-select ymc-multiple-orderby"  name="ymc-multiple-sort[0][orderby]">
                                    <option value="title">
                                        <?php echo esc_html__('Title', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="name">
                                        <?php echo esc_html__('Name', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="date">
                                        <?php echo esc_html__('Date', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="ID">
                                        <?php echo esc_html__('ID', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="author">
                                        <?php echo esc_html__('Author', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="modified">
                                        <?php echo esc_html__('Modified', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="type">
                                        <?php echo esc_html__('Type ', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="parent">
                                        <?php echo esc_html__('Parent ', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="rand">
                                    <?php echo esc_html__('Rand ', 'ymc-smart-filter'); ?>
                                    </option>
                                </select>
                            </fieldset>
                            <fieldset class="rows-options__col">
                                <legend><?php echo esc_html__('Post Order Type', 'ymc-smart-filter'); ?></legend>
                                <select class="form-select ymc-multiple-order"  name="ymc-multiple-sort[0][order]">
                                    <option value="asc">
                                        <?php echo esc_html__('Asc', 'ymc-smart-filter'); ?>
                                    </option>
                                    <option value="desc">
                                        <?php echo esc_html__('Desc', 'ymc-smart-filter'); ?>
                                    </option>
                                </select>
                            </fieldset>
                        </div>

                <?php  endif;  ?>

                <div class="ymc-btn">
                    <span class="ymc-btn__inner btnAddMultipleSort" title="Add new option">+</span>
                    <span class="ymc-btn__inner btnRemoveMultipleSort" title="Remove option">-</span>
                </div>

            </div>

            <div class="from-element">
                <label class="form-label">
                    <?php echo esc_html__('Status Options', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php echo esc_html__('Set posts with the specified status.', 'ymc-smart-filter');?>
                </span>
                </label>
                <select class="form-select"  id="ymc-post-status" name="ymc-post-status">
                    <option value="publish" <?php if ($ymc_post_status === 'publish') {echo "selected";} ?>>
                        <?php echo esc_html__('publish', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="pending" <?php if ($ymc_post_status === 'pending') {echo "selected";} ?>>
                        <?php echo esc_html__('Pending', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="draft" <?php if ($ymc_post_status === 'draft') {echo "selected";} ?>>
                        <?php echo esc_html__('Draft', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="future" <?php if ($ymc_post_status === 'future') {echo "selected";} ?>>
                        <?php echo esc_html__('Future', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="private" <?php if ($ymc_post_status === 'private') {echo "selected";} ?>>
                        <?php echo esc_html__('Private', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="inherit" <?php if ($ymc_post_status === 'inherit') {echo "selected";} ?>>
                        <?php echo esc_html__('Inherit', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="trash" <?php if ($ymc_post_status === 'trash') {echo "selected";} ?>>
                        <?php echo esc_html__('Trash', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="any" <?php if ($ymc_post_status === 'any') {echo "selected";} ?>>
                        <?php echo esc_html__('Any', 'ymc-smart-filter'); ?>
                    </option>
                </select>
            </div>

            <div class="from-element">

                <label class="form-label">
                    <?php echo esc_html__('Post Animation', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php echo esc_html__('Set animation for posts. Animations are not applied to post Masonry Layouts', 'ymc-smart-filter');?>
                    </span>
                </label>

                <select class="form-select"  id="ymc-post-animation" name="ymc-post-animation">
                    <option value="" <?php echo ( $ymc_post_animation === '') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('None', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="bounce" <?php echo ( $ymc_post_animation === 'bounce') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Bounce', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="bounce-in" <?php echo ( $ymc_post_animation === 'bounce-in') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Bounce in', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="fade-in" <?php echo ( $ymc_post_animation === 'fade-in') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Fade in', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="fade-in-down" <?php echo ( $ymc_post_animation === 'fade-in-down') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Fade in down', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="grow" <?php echo ( $ymc_post_animation === 'grow') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Grow', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="hithere" <?php echo ( $ymc_post_animation === 'hithere') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Hithere', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="swing" <?php echo ( $ymc_post_animation === 'swing') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Swing', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="shake" <?php echo ( $ymc_post_animation === 'shake') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Shake', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="wobble" <?php echo ( $ymc_post_animation === 'wobble') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Wobble', 'ymc-smart-filter'); ?>
                    </option>
                    <option value="zoom-in-out" <?php echo ( $ymc_post_animation === 'zoom-in-out') ? 'selected' : ''; ?>>
                        <?php echo esc_html__('Zoom', 'ymc-smart-filter'); ?>
                    </option>
                </select>

            </div>

            <header class="sub-header">
                <i class="fas fa-window-restore"></i>
                <?php echo esc_html__('Popup', 'ymc-smart-filter'); ?>
            </header>

            <div class="from-element">
                <label class="form-label">
                    <?php echo esc_html__('Enable / Disable Popup', 'ymc-smart-filter'); ?>
                    <span class="information">
                    <?php echo esc_html__('Enable popup in frontend. 
                    The content of the post will be displayed inside the popup.', 'ymc-smart-filter'); ?>
                </span>
                </label>

                <div class="ymc-toggle-group">
                    <label class="switch">
                        <input type="checkbox" <?php echo ($ymc_popup_status === "off") ? "checked" : ""; ?>>
                        <input type="hidden" name="ymc-popup-status" value='<?php echo esc_attr($ymc_popup_status); ?>'>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <header class="sub-header">
                <i class="fas fa-sort-numeric-down-alt"></i>
		        <?php echo esc_html__('Pagination', 'ymc-smart-filter'); ?>
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
		            <?php echo esc_html__('Hide Pagination', 'ymc-smart-filter');?>
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
