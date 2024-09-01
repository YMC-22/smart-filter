<?php if ( ! defined( 'ABSPATH' ) ) exit;

?>


<div class="header">
	<?php echo esc_html__('Appearance', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <div class="form-group wrapper-layout">

        <div class="appearance-section">

            <header class="sub-header" data-class-name="filter-settings">
                <i class="far fa-filter"></i>
		        <?php echo esc_html__('Filter Settings', 'ymc-smart-filter'); ?>
                <i class="fas fa-chevron-down form-arrow"></i>
            </header>

            <div class="form-wrapper filter-settings">

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
                            <?php echo esc_html__('Manual', 'ymc-smart-filter'); ?>
                        </option>
                    </select>
                </div>

                <div class="from-element">
                    <label class="form-label">
                        <?php echo esc_html__('Button Text ALL', 'ymc-smart-filter'); ?>
                        <span class="information">
                        <?php echo esc_html__('Change the text of the ALL button on filter bar.', 'ymc-smart-filter');?>
                        </span>
                    </label>
                    <input class="input-field" type="text" name="ymc-post-elements[button_text_all]"
                           value="<?php echo !empty($ymc_post_elements['button_text_all']) ? esc_attr($ymc_post_elements['button_text_all']) : 'All'; ?>">
                </div>

            </div>

            <header class="sub-header" data-class-name="post-settings">
                <i class="far fa-address-card"></i>
			    <?php echo esc_html__('Post Settings', 'ymc-smart-filter'); ?>
                <i class="fas fa-chevron-down form-arrow"></i>
            </header>

            <div class="form-wrapper post-settings">

                <div class="from-element">
                    <label class="form-label">
                        <?php echo esc_html__('Meta Info', 'ymc-smart-filter'); ?>
                        <span class="information">
                        <?php echo esc_html__('Show / Hide post elements: Author, Date, Tags, Title, Image, Excerpt, Button. 
                             For each post layout there will be a different number of elements.', 'ymc-smart-filter'); ?>
                        </span>
                    </label>
                    <fieldset class="form-fieldset">
                        <legend class="form-legend"><?php echo esc_html__('Post Elements', 'ymc-smart-filter'); ?></legend>
                        <div class="meta-info">
                            <div class="col post-author">
                                <label><?php echo esc_html__('Author', 'ymc-smart-filter'); ?></label>
                                <select class="form-select" name="ymc-post-elements[author]">
                                    <option value="show" <?php echo ( $ymc_post_elements['author'] === 'show' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Show', 'ymc-smart-filter'); ?></option>
                                    <option value="hide" <?php echo ( $ymc_post_elements['author'] === 'hide' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Hide', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>

                            <div class="col post-date">
                                <label><?php echo esc_html__('Date', 'ymc-smart-filter'); ?></label>
                                <select class="form-select" name="ymc-post-elements[date]">
                                    <option value="show" <?php echo ( $ymc_post_elements['date'] === 'show' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Show', 'ymc-smart-filter'); ?></option>
                                    <option value="hide" <?php echo ( $ymc_post_elements['date'] === 'hide' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Hide', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>

                            <div class="col post-tags">
                                <label><?php echo esc_html__('Tags', 'ymc-smart-filter'); ?></label>
                                <select class="form-select"  name="ymc-post-elements[tag]">
                                    <option value="show" <?php echo ( $ymc_post_elements['tag'] === 'show' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Show', 'ymc-smart-filter'); ?></option>
                                    <option value="hide" <?php echo ( $ymc_post_elements['tag'] === 'hide' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Hide', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>

                            <div class="col post-title">
                                <label><?php echo esc_html__('Title', 'ymc-smart-filter'); ?></label>
                                <select class="form-select" name="ymc-post-elements[title]">
                                    <option value="show" <?php echo ( $ymc_post_elements['title'] === 'show' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Show', 'ymc-smart-filter'); ?></option>
                                    <option value="hide" <?php echo ( $ymc_post_elements['title'] === 'hide' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Hide', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>

                            <div class="col post-image">
                                <label><?php echo esc_html__('Image', 'ymc-smart-filter'); ?></label>
                                <select class="form-select" name="ymc-post-elements[image]">
                                    <option value="show" <?php echo ( $ymc_post_elements['image'] === 'show' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Show', 'ymc-smart-filter'); ?></option>
                                    <option value="hide" <?php echo ( $ymc_post_elements['image'] === 'hide' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Hide', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>

                            <div class="col post-excerpt">
                                <label><?php echo esc_html__('Excerpt', 'ymc-smart-filter'); ?></label>
                                <select class="form-select" name="ymc-post-elements[excerpt]">
                                    <option value="show" <?php echo ( $ymc_post_elements['excerpt'] === 'show' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Show', 'ymc-smart-filter'); ?></option>
                                    <option value="hide" <?php echo ( $ymc_post_elements['excerpt'] === 'hide' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Hide', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>

                            <div class="col post-button">
                                <label><?php echo esc_html__('Button', 'ymc-smart-filter'); ?></label>
                                <select class="form-select" name="ymc-post-elements[button]">
                                    <option value="show" <?php echo ( $ymc_post_elements['button'] === 'show' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Show', 'ymc-smart-filter'); ?></option>
                                    <option value="hide" <?php echo ( $ymc_post_elements['button'] === 'hide' ) ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Hide', 'ymc-smart-filter'); ?></option>
                                </select>
                            </div>

                        </div>
                    </fieldset>
                </div>

                <div class="from-element">
                    <label class="form-label">
                        <?php echo esc_html__('Button Text', 'ymc-smart-filter'); ?>
                        <span class="information">
                        <?php echo esc_html__('Change the text of the Read More button.', 'ymc-smart-filter');?>
                        </span>
                    </label>
                    <input class="input-field" type="text" name="ymc-post-elements[button_text]"
                           value="<?php echo !empty($ymc_post_elements['button_text']) ? esc_attr($ymc_post_elements['button_text']) : 'Read More'; ?>">
                </div>

                <div class="from-element">
                    <label class="form-label">
                        <?php echo esc_html__('Length Excerpt ', 'ymc-smart-filter'); ?>
                        <span class="information">
                        <?php echo esc_html__('Set the excerpt length of the post. By default 30 words.', 'ymc-smart-filter');?>
                        </span>
                    </label>
                    <input class="input-field" type="text" name="ymc-post-elements[length_excerpt]"
                           value="<?php echo !empty($ymc_post_elements['length_excerpt']) ? esc_attr($ymc_post_elements['length_excerpt']) : 30; ?>">
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
                        <?php echo esc_html__('Post Status', 'ymc-smart-filter'); ?>
                        <span class="information">
                        <?php echo esc_html__('Set posts with specified status.', 'ymc-smart-filter');?>
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
                        <?php echo esc_html__('Animation Type', 'ymc-smart-filter'); ?>
                        <span class="information">
                        <?php echo esc_html__('Select an animation type for your post. Animations are not applied to post Masonry Layouts', 'ymc-smart-filter');?>
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

            </div>

            <header class="sub-header" data-class-name="popup-settings">
                <i class="fas fa-window-restore"></i>
                <?php echo esc_html__('Popup', 'ymc-smart-filter'); ?>
                <i class="fas fa-chevron-down form-arrow"></i>
            </header>

            <div class="form-wrapper popup-settings">

                <div class="from-element">
                    <label class="form-label">
                        <?php echo esc_html__('Enable / Disable Popup', 'ymc-smart-filter'); ?>
                        <span class="information">
                    <?php echo esc_html__('Enable popup in frontend. 
                    Content of a post will be displayed inside popup.', 'ymc-smart-filter'); ?>
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

                <?php $ymc_hide = ($ymc_popup_status === 'on') ? '' : 'ymc_hidden'; ?>

                <div class="manage-filters <?php echo esc_attr($ymc_hide); ?>">

                    <div class="from-element">
                        <label class="form-label">
                            <?php echo esc_html__('Animation Type', 'ymc-smart-filter'); ?>
                            <span class="information">
                        <?php echo esc_html__('Select an animation type for your popup.', 'ymc-smart-filter');?>
                        </span>
                        </label>

                        <select class="form-select"  id="ymc-popup-animation" name="ymc-popup-animation">
                            <option value="normal" <?php echo ( $ymc_popup_animation === 'normal') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('None', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="fade-in" <?php echo ( $ymc_popup_animation === 'fade-in') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Fade in', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="rotate" <?php echo ( $ymc_popup_animation === 'rotate') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Rotate', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="zoom-in" <?php echo ( $ymc_popup_animation === 'zoom-in') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Zoom', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="slide" <?php echo ( $ymc_popup_animation === 'slide') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Slide', 'ymc-smart-filter'); ?>
                            </option>
                        </select>
                    </div>

                    <div class="from-element">
                        <label class="form-label">
                            <?php echo esc_html__('Location', 'ymc-smart-filter'); ?>
                            <span class="information">
                        <?php echo esc_html__('Choose where the popup will be displayed.', 'ymc-smart-filter');?>
                        </span>
                        </label>

                        <select class="form-select" name="ymc_popup_settings[custom_location]">
                            <option value="center" <?php echo ( $ymc_popup_settings['custom_location'] === 'center') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Middle Center', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="left center" <?php echo ( $ymc_popup_settings['custom_location'] === 'left center') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Middle Left', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="right center" <?php echo ( $ymc_popup_settings['custom_location'] === 'right center') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Middle Right', 'ymc-smart-filter'); ?>
                            </option>
                        </select>

                    </div>

                    <div class="from-element">
                        <label class="form-label">
                            <?php echo esc_html__('Animation Origin', 'ymc-smart-filter'); ?>
                            <span class="information">
                        <?php echo esc_html__('Set the animation speed for the popup.', 'ymc-smart-filter');?>
                        </span>
                        </label>

                        <select class="form-select"  id="ymc-popup-animation-origin" name="ymc-popup-animation-origin">
                            <option value="top" <?php echo ( $ymc_popup_animation_origin === 'top') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Top', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="left" <?php echo ( $ymc_popup_animation_origin === 'left') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Left', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="bottom" <?php echo ( $ymc_popup_animation_origin === 'bottom') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Bottom', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="right" <?php echo ( $ymc_popup_animation_origin === 'right') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Right', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="left top" <?php echo ( $ymc_popup_animation_origin === 'left top') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Top Left', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="center top" <?php echo ( $ymc_popup_animation_origin === 'center top') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Top Center', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="right top" <?php echo ( $ymc_popup_animation_origin === 'right top') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Top Right', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="left center" <?php echo ( $ymc_popup_animation_origin === 'left center') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Middle Left', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="center center" <?php echo ( $ymc_popup_animation_origin === 'center center') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Middle Center', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="right center" <?php echo ( $ymc_popup_animation_origin === 'right center') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Middle Right', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="left bottom" <?php echo ( $ymc_popup_animation_origin === 'left bottom') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Bottom Left', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="center bottom" <?php echo ( $ymc_popup_animation_origin === 'center bottom') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Bottom Center', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="right bottom" <?php echo ( $ymc_popup_animation_origin === 'right bottom') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('Bottom Right', 'ymc-smart-filter'); ?>
                            </option>
                        </select>
                    </div>

                    <div class="from-element">
                        <label class="form-label">
                            <?php echo esc_html__('Width', 'ymc-smart-filter'); ?>
                            <span class="information">
                        <?php echo esc_html__('Set a custom width for the popup.', 'ymc-smart-filter');?>
                        </span>
                        </label>

                        <input class="input-field w-20" type="number" name="ymc_popup_settings[custom_width]" value="<?php echo esc_attr($ymc_popup_settings['custom_width']); ?>" size="5">

                        <select class="form-select w-10" name="ymc_popup_settings[custom_width_unit]">
                            <option value="px" <?php echo ( $ymc_popup_settings['custom_width_unit'] === 'px') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('px', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="%" <?php echo ( $ymc_popup_settings['custom_width_unit'] === '%') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('%', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="em" <?php echo ( $ymc_popup_settings['custom_width_unit'] === 'em') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('em', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="rem" <?php echo ( $ymc_popup_settings['custom_width_unit'] === 'rem') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('rem', 'ymc-smart-filter'); ?>
                            </option>
                        </select>
                    </div>

                    <div class="from-element">
                        <label class="form-label">
                            <?php echo esc_html__('Height', 'ymc-smart-filter'); ?>
                            <span class="information">
                        <?php echo esc_html__('Set a custom height for the popup.', 'ymc-smart-filter');?>
                        </span>
                        </label>

                        <input class="input-field w-20" type="number" name="ymc_popup_settings[custom_height]" value="<?php echo esc_attr($ymc_popup_settings['custom_height']); ?>" size="5">

                        <select class="form-select w-10" name="ymc_popup_settings[custom_height_unit]">
                            <option value="px" <?php echo ( $ymc_popup_settings['custom_height_unit'] === 'px') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('px', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="%" <?php echo ( $ymc_popup_settings['custom_height_unit'] === '%') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('%', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="em" <?php echo ( $ymc_popup_settings['custom_height_unit'] === 'em') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('em', 'ymc-smart-filter'); ?>
                            </option>
                            <option value="rem" <?php echo ( $ymc_popup_settings['custom_height_unit'] === 'rem') ? 'selected' : ''; ?>>
                                <?php echo esc_html__('rem', 'ymc-smart-filter'); ?>
                            </option>
                        </select>
                    </div>

                    <div class="from-element">
                        <label class="form-label">
                            <?php echo esc_html__('Background Overlay', 'ymc-smart-filter'); ?>
                            <span class="information">
                        <?php echo __('Set a custom background overlay for the popup. Use <a target="_blank" href="https://rgbacolorpicker.com/rgba-to-hex">RGBA to Hex Converter</a>', 'ymc-smart-filter');?>
                        </span>
                        </label>

                        <input class="ymc-custom-color" type="text" name="ymc_popup_settings[custom_bg_overlay]" value="<?php echo esc_attr($ymc_popup_settings['custom_bg_overlay']); ?>" />

                    </div>

                </div>

            </div>

            <header class="sub-header" data-class-name="pagination-settings">
                <i class="fas fa-sort-numeric-down-alt"></i>
		        <?php echo esc_html__('Pagination', 'ymc-smart-filter'); ?>
                <i class="fas fa-chevron-down form-arrow"></i>
            </header>

            <div class="form-wrapper pagination-settings">

                <div class="from-element">
                    <label class="form-label">
                        <?php echo esc_html__('Prevision Button Text', 'ymc-smart-filter'); ?>
                        <span class="information">
                    <?php echo esc_html__('Prev button will show in Pagination.', 'ymc-smart-filter');?>
                    </span>
                    </label>
                    <input class="input-field" type="text" name="ymc-pagination-elements[prev_btn_text]"
                           value="<?php echo !empty($ymc_pagination_elements['prev_btn_text']) ? esc_attr($ymc_pagination_elements['prev_btn_text']) : 'Prev'; ?>">
                </div>

                <div class="from-element">
                    <label class="form-label">
                        <?php echo esc_html__('Next Button Text', 'ymc-smart-filter'); ?>
                        <span class="information">
                    <?php echo esc_html__('Next button will show in Pagination.', 'ymc-smart-filter');?>
                    </span>
                    </label>
                    <input class="input-field" type="text" name="ymc-pagination-elements[next_btn_text]"
                           value="<?php echo !empty($ymc_pagination_elements['next_btn_text']) ? esc_attr($ymc_pagination_elements['next_btn_text']) : 'Next'; ?>">
                </div>

                <div class="from-element">
                    <label class="form-label">
                        <?php echo esc_html__('Load More Button Text', 'ymc-smart-filter'); ?>
                        <span class="information">
                    <?php echo esc_html__('Load more button will show in pagination.', 'ymc-smart-filter');?>
                    </span>
                    </label>
                    <input class="input-field" type="text" name="ymc-pagination-elements[load_btn_text]"
                           value="<?php echo !empty($ymc_pagination_elements['load_btn_text']) ? esc_attr($ymc_pagination_elements['load_btn_text']) : 'Load More'; ?>">
                </div>

                <div class="from-element">
                    <label class="form-label">
                        <?php echo esc_html__('Posts Per Page', 'ymc-smart-filter');?>
                        <span class="information">
                    <?php echo esc_html__('Select posts per page. Use -1 for all posts.', 'ymc-smart-filter');?>
                </span>
                    </label>
                    <input class="input-field" type="text" name="ymc-per-page" value="<?php echo esc_attr($ymc_per_page); ?>">
                </div>

                <div class="from-element">

                    <label class="form-label">
                        <?php echo esc_html__('Type', 'ymc-smart-filter');?>
                        <span class="information">
                    <?php echo esc_html__('Select pagination type.', 'ymc-smart-filter');?>
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
                        <?php echo esc_html__('Hide', 'ymc-smart-filter');?>
                        <span class="information">
                    <?php echo esc_html__('Hide pagination.', 'ymc-smart-filter');?>
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

</div>
