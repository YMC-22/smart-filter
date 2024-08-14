<?php if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="header">
	<?php echo esc_html__('Advanced', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <header class="sub-header" data-class-name="advanced-query-settings">
        <i class="far fa-database"></i>
        <?php echo esc_html__('Advanced Query', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper advanced-query-settings">

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

        <div class="form-group">
            <label class="form-label">
                <?php echo esc_html__('Filters Parameters', 'ymc-smart-filter');?>
                <span class="information">
                    <?php echo esc_html__('Disable Filters ( suppress_filters ) in the WP_Query. Important: Enabling this option will change how some of the plugin filters work.', 'ymc-smart-filter');?>
                </span>
            </label>

            <div class="group-elements">
                <?php $checked_suppress_filters =  ( (int) $ymc_suppress_filters === 1 ) ? 'checked' : '';  ?>
                <input type="hidden" name="ymc-suppress-filters" value="0">
                <input class="ymc-suppress-filters" id="ymc-suppress-filters" type="checkbox" value="1" name="ymc-suppress-filters"
                    <?php echo esc_attr($checked_suppress_filters); ?>>
                <label for="ymc-suppress-filters"><?php echo esc_html__('Disable','ymc-smart-filter'); ?></label>
            </div>

        </div>

    </div>

    <header class="sub-header" data-class-name="sort-settings">
        <span class="dashicons dashicons-excerpt-view"></span>
        <?php echo esc_html__('Sorting', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper sort-settings">

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

    </div>

    <header class="sub-header" data-class-name="extra-filter">
        <span class="dashicons dashicons-layout"></span>
        <?php echo esc_html__('Extra Filter Layout', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper extra-filter">

        <div class="from-element">

            <label class="form-label">
                <?php echo esc_html__('Extra Filter Layout', 'ymc-smart-filter');?>
                <span class="information">
                    <?php _e('Select extra layout of filters. 
                    This filter will be located outside the current post grid filter anywhere on the page
                    <a href="https://github.com/YMC-22/smart-filter#shortcodes" target="_blank">
                    view docs <img draggable="false" role="img" class="emoji" alt="↗" src="https://s.w.org/images/core/emoji/14.0.0/svg/2197.svg"></a>
                    ', 'ymc-smart-filter');?>
                </span>
            </label>

            <select class="form-select" id="ymc-filter-extra-layout" name="ymc-filter-extra-layout">

                <?php
                $filter_layouts = apply_filters('ymc_filter_layouts', $layouts=[]);

                if( $filter_layouts ) :

                    foreach ($filter_layouts as $key => $layout) :

                        if( $key !== 'filter-custom-layout' )
                        {
                            $selected = ( $ymc_filter_extra_layout === $key ) ? 'selected' : '';

                            echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_html__($layout, 'ymc-smart-filter') . '</option>';
                        }

                    endforeach;

                endif;
                ?>

            </select>

        </div>

    </div>

    <header class="sub-header" data-class-name="extra-class">
        <i class="far fa-plus-circle"></i>
        <?php echo esc_html__('Extra Class', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper extra-class">

        <div class="from-element">
            <label class="form-label">
                <?php echo esc_html__('Custom Class', 'ymc-smart-filter');?>
                <span class="information">
                    <?php echo esc_html__('This class will be added to the filter container.', 'ymc-smart-filter');?>
                </span>
            </label>
            <input class="input-field" type="text" name="ymc-special-post-class" value="<?php echo esc_attr($ymc_special_post_class); ?>">
        </div>

    </div>

    <header class="sub-header" data-class-name="custom-css">
        <i class="far fa-edit"></i>
        <?php echo esc_html__('Custom CSS', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper custom-css">

        <div class="from-element">
            <label class="form-label">
                <?php echo esc_html__('Custom CSS', 'ymc-smart-filter'); ?>
                <span class="information">
                    <?php _e('Add your custom CSS. Use the parent container ID named: <b>"#ymc-smart-filter-container-{ID}"</b> 
                    if you want to override the base filter styles. Example: <b>#ymc-smart-filter-container-1</b>. Press Ctrl + Space to get a hint inside the editor.', 'ymc-smart-filter');?>
                </span>
            </label>
            <hr/>
            <textarea class="form-textarea" name="ymc-custom-css" id="ymc-custom-css">
                <?php echo esc_textarea($ymc_custom_css); ?>
            </textarea>
            <hr/>
        </div>

    </div>

    <header class="sub-header" data-class-name="custom-js">
        <i class="far fa-edit"></i>
        <?php echo esc_html__('Custom Actions', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper custom-js">
        <div class="from-element">
            <label class="form-label">
                <?php echo esc_html__('Code', 'ymc-smart-filter'); ?>
                <span class="information">
                    <?php  _e('Add your custom JS. Press Ctrl + Space to get a hint inside the editor.  
                        <a class="button-hints" href="#">See docs</a>',
                        'ymc-smart-filter'); ?>
                </span>
            </label>
            <hr/>
            <textarea class="form-textarea" name="ymc-custom-after-js" id="ymc-custom-after-js">
                <?php echo esc_textarea($ymc_custom_after_js); ?>
            </textarea>
            <hr/>
            <div class="popup-hints">
                <div class="popup-hints--inner">
                    <span class="popup-hints--btn-close" title="Close"></span>
                    <h2 class="popup-hints--header"><?php _e('Methods and Hooks JS', 'ymc-smart-filter'); ?></h2>
                    <p class="popup-hints--note">
                        <?php _e('<u><b>Note:</b></u> The call to the global <b>YMCTools</b> object should be used
                        when the document is fully loaded, for example using the notation:: <b>$(document).on("ready", function () { ... });</b> or inside a hook callback function. <br>
                        If there is only one filter on the page, then the object property: <b>"target"</b> can be skipped for calling methods.', 'ymc-smart-filter'); ?>
                    </p>
                    <hr/>
                    <ul class="popup-hints--wrp">
                        <li class="subHeader"><?php _e('Methods', 'ymc-smart-filter'); ?></li>
                        <li>
                            <span class="line-hint" data-method="apiTermUpdate" title="This method allows to get posts by ID terms of different taxonomies.">
                                apiTermUpdate;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiMetaUpdate" title="This method allows to get posts by meta fields.">
                                apiMetaUpdate;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiDateUpdate" title="This method allows to get posts by date.">
                                apiDateUpdate;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiSearchPosts" title="This method allows to search for posts by keyword.">
                                apiSearchPosts;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiChoicesPosts" title="This method allows Include / Exclude posts in the post grid.">
                                apiChoicesPosts;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiSortPosts" title="This method allows to sort posts by different criteria.">
                                apiSortPosts;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiTermClear" title="This method allows to clear query parameters in the filter by terms.">
                                apiTermClear;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiMetaClear" title="This method allows to clear query parameters in the filter by meta fields.">
                                apiMetaClear;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiDateClear" title="This method allows to clear query parameters in the filter by date.">
                                apiDateClear;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiSortClear" title="This method allows to clear sort parameters in the filter by sort posts.">
                                apiSortClear;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiLetterAlphabetClear" title="This method allows you to clear the query parameters in the filter by the first letter of the alphabet.">
                                apiLetterAlphabetClear;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiGetPosts" title="This method allows you to make a request to receive posts by previously specified parameters.">
                                apiGetPosts;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiPageUpdated" title="This method allows you to move to a specific page of posts in grid.">
                                apiPageUpdated;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiPopup" title="This method allows you to open a popup post and load content into it.">
                                apiPopup;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="apiMultiplePosts" title="This method allows you to display different post types with their different taxonomies in a grid.">
                                apiMultiplePosts;
                            </span>
                        </li>
                        <li class="subHeader"><?php _e('Hooks', 'ymc-smart-filter'); ?></li>
                        <li>
                            <span class="line-hint" data-method="ymc_stop_loading_data" title="Stop loading posts on page load.">
                                ymc_stop_loading_data;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="ymc_before_loaded_data" title="Before loaded all posts.">
                                ymc_before_loaded_data;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="ymc_after_loaded_data" title="After loaded all posts.">
                                ymc_after_loaded_data;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="ymc_complete_loaded_data" title="Complete loaded all data.">
                                ymc_complete_loaded_data;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="ymc_before_popup_open" title="Calling a script point before / after opening a popup and loading content into it.">
                                ymc_before_popup_open;
                            </span>
                        </li>
                        <li>
                            <span class="line-hint" data-method="ymc_after_popup_open" title="Calling a script point before / after opening a popup and loading content into it.">
                                ymc_after_popup_open;
                            </span>
                        </li>
                    </ul>
                    <div class="popup-hints--description">
                        <span class="btn-close" title="Close"></span>
                        <div class="info-hint">
                           <div class="method-section apiTermUpdate">
                               <h2>[ apiTermUpdate ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: ".data-target-ymcFilterID-LayoutID", terms: "termID"}).apiTermUpdate( option );</pre>
                                </div>
                                <hr/>
                                <div class="info-code">This method allows to get posts by ID terms of different taxonomies.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.</li>
                                    <li>termID - ID term (String). It is a string data type and is enclosed in quotes.
                                        Can set several ID terms separated by commas, for example: "11,35,47"</li>
                                </ul>
                                <h5>Optional params:</h5>
                                <ul>
                                    <li>taxRel - define the interaction between different taxonomies in the query. The default is
                                        "AND". If set "all" will match the relation "OR". Installed in the admin panel Filter -> Tab Ganeral -> Taxonomy Relation.</li>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true.</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiTermUpdateHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiTermUpdateHint">YMCTools({ target: '.data-target-ymc545-1', terms: '7,9,11' }).apiTermUpdate();</pre>
                                </div>
                            </div>
                           <div class="method-section apiMetaUpdate">
                               <h2>[ apiMetaUpdate ]</h2>
                               <div class="method-name">
                                   <pre>YMCTools({target: ".data-target-ymcFilterID-LayoutID", meta: [params]}).apiMetaUpdate( option );</pre>
                               </div>
                               <hr/>
                               <div class="info-code">This method allows to get posts by meta fields.</div>
                               <h5>Required params:</h5>
                               <ul>
                                   <li>.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.</li>
                                   <li>meta - (Array) is an array of objects that include in the request settings. All objects must be in josn data format.</li>
                               </ul>
                               <h5>Optional params:</h5>
                               <ul>
                                   <li>relation - defines a logical relationship between nested arrays. Default is "AND".</li>
                                   <li>option - (bool) true / false - parameter allows to control sending of request. Default is true.</li>
                               </ul>
                               <h5>Usage example:</h5>
                               <div class="code-hint">
                                   <div class="clipboard-container">
                                       <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiMetaUpdateHint">
                                           <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                       </svg>
                                       <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                           <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                       </svg>
                                       <span class="js-clipboard-tip">Copied!</span>
                                   </div>
                                   <pre id="apiMetaUpdateHint">
                                   YMCTools({ target: '.data-target-ymc545-1', meta : [
                                       { "relation" : "OR" },
                                       { "key" : "color", "value" : "blue" },
                                       { "key" : "price", "value" : "10", "compare": "LIKE" },
                                       { "key" : "grant_value", "value" : ["100", "200"], "compare": "BETWEEN", "type" : "NUMERIC" }
                                       ]
                                   }).apiMetaUpdate( option );
                                   </pre>
                               </div>
                           </div>
                           <div class="method-section apiDateUpdate">
                               <h2>[ apiDateUpdate ]</h2>
                               <div class="method-name">
                                   <pre>YMCTools({target: ".data-target-ymcFilterID-LayoutID", date: [params]}).apiDateUpdate( option );</pre>
                               </div>
                               <hr/>
                               <div class="info-code">This method allows to get posts by date.</div>
                               <h5>Required params:</h5>
                               <ul>
                                   <li>.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.</li>
                                   <li>date - (Array) is an array of objects that include in the request settings.
                                       All objects must be in json data format.</li>
                               </ul>
                               <h5>Optional params:</h5>
                               <ul>
                                   <li>option - (bool) true / false - parameter allows to control sending of request. Default is true.</li>
                               </ul>
                               <h5>Usage example:</h5>
                               <div class="code-hint">
                                   <div class="clipboard-container">
                                       <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiDateUpdateHint">
                                           <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                       </svg>
                                       <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                           <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                       </svg>
                                       <span class="js-clipboard-tip">Copied!</span>
                                   </div>
                                 <pre id="apiDateUpdateHint">
                                    YMCTools({ target: '.data-target-ymc545-1', date : [
                                       { "monthnum" : "1", "compare" : "=" },
                                       { "year" : "2023", "compare" : "=" },
                                       { "day" : "10", "compare" : ">=" }
                                     ] }).apiDateUpdate();
                                  </pre>
                               </div>
                           </div>
                           <div class="method-section apiSearchPosts">
                                <h2>[ apiSearchPosts ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: ".data-target-ymcFilterID-LayoutID", search: 'keyword'}).apiSearchPosts( option, terms );</pre>
                                </div>
                                <hr/>
                                <div class="info-code">This method allows to search for posts by keyword.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.</li>
                                    <li>search - (String) Phrase for which posts are searched.</li>
                                </ul>
                                <h5>Optional params:</h5>
                                <ul>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true.</li>
                                    <li>terms - (array)  list ids terms. Default is empty</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiSearchPostsHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiSearchPostsHint">YMCTools({ target: '.data-target-ymc545-1', search: 'keyword' }).apiSearchPosts( true, [7,11,15] );</pre>
                                </div>
                            </div>
                           <div class="method-section apiChoicesPosts">
                               <h2>[ apiChoicesPosts ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: ".data-target-ymcFilterID-LayoutID", choicesPosts: 'termIDs', excludePosts: 'off'}).apiChoicesPosts( option );</pre>
                                </div>
                               <hr/>
                               <div class="info-code">This method allows Include / Exclude posts in the post grid.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.</li>
                                    <li>choicesPosts - (String) ID posts.</li>
                                    <li>excludePosts - (String) on / off. By default excludePosts is "off"".</li>
                                </ul>
                                <h5>Optional params:</h5>
                                <ul>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true.</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiChoicesPostsHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiChoicesPostsHint">YMCTools({ target: '.data-target-ymc545-1', choicesPosts: '7,9,11', excludePosts: 'off' }).apiChoicesPosts();</pre>
                                </div>
                            </div>
                           <div class="method-section apiSortPosts">
                               <h2>[ apiSortPosts ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: ".data-target-ymcFilterID-LayoutID", sortOrder: 'asc', sortOrderBy: 'title'}).apiSortPosts( option );</pre>
                                </div>
                                <hr/>
                                <div class="info-code">This method allows to sort posts by different criteria.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.</li>
                                    <li>sortOrder - (String) asc / desc.</li>
                                    <li>sortOrderBy - (String) List of fields for sorting posts:
                                        ID, author, title, name, date, modified, type, parent, rand, comment_count.
                                        If set meta key set options: meta_value or meta_value_num (for numbers) to sort by meta field</li>
                                </ul>
                                <h5>Optional params:</h5>
                                <ul>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true.</li>
                                    <li>metaKey - (String) Value of meta_key parameter (field data key).</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiSortPostsHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiSortPostsHint">YMCTools({ target: '.data-target-ymc545-1', sortOrder: 'desc', sortOrderBy: 'meta_value_num', metaKey: 'amount' }).apiSortPosts();</pre>
                                </div>
                            </div>
                           <div class="method-section apiTermClear">
                                <h2>[ apiTermClear ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiTermClear( option );</pre>
                                </div>
                                <hr/>
                                <div class="info-code">This method allows to clear query parameters in the filter by terms.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiTermClearHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiTermClearHint">YMCTools({ target: '.data-target-ymc545-1' }).apiTermClear();</pre>
                                </div>
                            </div>
                           <div class="method-section apiMetaClear">
                               <h2>[ apiMetaClear ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiMetaClear( option );</pre>
                                </div>
                               <hr/>
                               <div class="info-code">This method allows to clear query parameters in the filter by meta fields.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiMetaClearHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiMetaClearHint">YMCTools({ target: '.data-target-ymc545-1' }).apiMetaClear();</pre>
                                </div>
                            </div>
                           <div class="method-section apiDateClear">
                               <h2>[ apiDateClear ]</h2>
                               <div class="method-name">
                                    <pre>YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiDateClear( option );</pre>
                                </div>
                               <hr/>
                               <div class="info-code">This method allows to clear query parameters in the filter by date.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiDateClearHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiDateClearHint">YMCTools({ target: '.data-target-ymc545-1' }).apiDateClear();</pre>
                                </div>
                            </div>
                           <div class="method-section apiSortClear">
                               <h2>[ apiSortClear ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiSortClear( option );</pre>
                                </div>
                               <hr/>
                               <div class="info-code">This method allows to clear sort parameters in the filter by sort posts.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiSortClearHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiSortClearHint">YMCTools({ target: '.data-target-ymc545-1' }).apiSortClear();</pre>
                                </div>
                            </div>
                           <div class="method-section apiLetterAlphabetClear">
                               <h2>[ apiLetterAlphabetClear ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiLetterAlphabetClear( option );</pre>
                                </div>
                               <hr/>
                               <div class="info-code">This method allows you to clear the query parameters in the filter by the first letter of the alphabet.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiLetterAlphabetClearHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiLetterAlphabetClearHint">YMCTools({ target: '.data-target-ymc545-1' }).apiLetterAlphabetClear();</pre>
                                </div>
                            </div>
                           <div class="method-section apiGetPosts">
                               <h2>[ apiGetPosts ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiGetPosts();</pre>
                                </div>
                                <hr/>
                                <div class="info-code">This method allows you to make a request to receive posts by previously specified parameters.</div>
                                <h5>Usage example: First we change the request parameters, and then we send the data. You should pass the value false to the methods parameters.</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiGetPostsHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                <pre id="apiGetPostsHint">
                                    YMCTools({ target: '.data-target-ymc545-1', terms: '5,7,9' }).apiTermUpdate(false);
                                    YMCTools({ target: '.data-target-ymc545-1',  meta : [ { "key" : "amount", "value" : "100" } ] }).apiMetaUpdate(false);
                                    YMCTools({target: '.data-target-ymc545-1'}).apiGetPosts();
                                </pre>
                                </div>
                            </div>
                           <div class="method-section apiPageUpdated">
                                <h2>[ apiPageUpdated ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiPageUpdated( page );</pre>
                                </div>
                                <hr/>
                                <div class="info-code">This method allows you to move to a specific page of posts in grid.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>page - (Number) - page number in the grid Default is 1.</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiPageUpdatedHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiPageUpdatedHint">YMCTools({ target: '.data-target-ymc545-1'}).apiPageUpdated(3);</pre>
                                </div>
                            </div>
                           <div class="method-section apiPopup">
                                <h2>[ apiPopup ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({ target: '.data-target-ymcFilterID-LayoutID' }).apiPopup( postID );</pre>
                                </div>
                                <hr/>
                                <div class="info-code">This method allows you to open a popup post and load content into it.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>postID - (Number) - post ID</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiPopupHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiPopupHint">YMCTools({ target: '.data-target-ymc545-1'}).apiPopup(15);</pre>
                                </div>
                            </div>
                           <div class="method-section apiMultiplePosts">
                                <h2>[ apiMultiplePosts ]</h2>
                                <div class="method-name">
                                    <pre>YMCTools({ target: '.data-target-ymcFilterID-LayoutID' }).apiMultiplePosts( option, cpt = '', tax = '', terms = '' );</pre>
                                </div>
                                <hr/>
                                <div class="info-code">This method allows you to display different post types with their different taxonomies in a grid.</div>
                                <h5>Required params:</h5>
                                <ul>
                                    <li>option - (bool) true / false - parameter allows to control sending of request. Default is true.</li>
                                    <li>cpt - name of post types (String). Can set several post types separated by commas, for example: "blogs,books"</li>
                                    <li>tax - name of taxonomies (String). Can set several taxonomies separated by commas, for example: "people,science"</li>
                                    <li>terms - ID terms (String). Create a list of all terms related to all specified taxonomies, separated by commas, for example: “11,35,47,55,77,95”.</li>
                                    <li>IMPORTANT! Define the relationship between different taxonomies in a query. The default is "AND". Set the option to "OR" to display all posts in the grid. This can be configured in the admin panel Filter -> General Tab -> Taxonomy.</li>
                                </ul>
                                <h5>Usage example: Let's override the global filter settings. To do this, stop loading posts and run the filter with new updated parameters:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#apiMultiplePostsHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="apiMultiplePostsHint">
                                    wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', function(el) {
                                        if( el.classList.contains('data-target-ymc545-1') ) {
                                            el.dataset.loading = 'false';

                                            YMCTools( { target: '.data-target-ymc545-1' }).apiMultiplePosts(
                                            true, cpt = 'post,books', tax = 'category,people,science', terms = '5,6,19,15,20,7,55' ); }
                                    });
                                    </pre>
                                </div>
                            </div>
                           <div class="method-section ymc_stop_loading_data">
                                <h2>[ ymc_stop_loading_data ]</h2>
                                <div class="method-name">
                                    <pre>wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', 'callback(elem)');</pre>
                                </div>
                                <hr/>
                                <div class="info-code">Stop loading posts on page load. Set the selected filter's data-loading attribute to false ( data-loading="false" )</div>
                                <h5>Params function callback:</h5>
                                <ul>
                                    <li>elem - DOM container filter.</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#ymcStopLoadingDataHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="ymcStopLoadingDataHint">
                                        wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', function(elem) {
                                            if( elem.classList.contains('data-target-ymc545-1') ) {
                                            elem.dataset.loading = 'false'; }
                                        });
                                   </pre>
                                </div>
                            </div>
                           <div class="method-section ymc_before_loaded_data">
                                <h2>[ ymc_before_loaded_data ]</h2>
                                <div class="method-name">
                                    <pre>
                                        wp.hooks.addAction('ymc_before_loaded_data', 'smartfilter', 'callback(class_name)');
                                        wp.hooks.addAction('ymc_before_loaded_data_FilterID', 'smartfilter', 'callback(class_name)');
                                        wp.hooks.addAction('ymc_before_loaded_data_FilterID_LayoutID', 'smartfilter', 'callback(class_name)');
                                    </pre>
                                </div>
                                <hr/>
                                <div class="info-code">Note: this hook only works when the page is loaded. By default,
                                 it stops all posts from loading. Therefore, inside this hook, you must specify the class
                                 of the selected filter.</div>
                                <h5>Params function callback:</h5>
                                <ul>
                                    <li>class_name - is the name of the filter container class.</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#ymcBeforeLoadedDataHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="ymcBeforeLoadedDataHint">
                                        wp.hooks.addAction('ymc_before_loaded_data_545_1', 'smartfilter', function(class_name) {
                                            console.log('Before loading all posts: ' + class_name);
                                        });
                                   </pre>
                                </div>
                            </div>
                           <div class="method-section ymc_after_loaded_data">
                                <h2>[ ymc_after_loaded_data ]</h2>
                                <div class="method-name">
                                    <pre>
                                        wp.hooks.addAction('ymc_after_loaded_data', 'smartfilter', 'callback(class_name, response)');
                                        wp.hooks.addAction('ymc_after_loaded_data_FilterID', 'smartfilter', 'callback(class_name, response)');
                                        wp.hooks.addAction('ymc_after_loaded_data_FilterID_LayoutID', 'smartfilter', 'callback(class_name, response)');
                                    </pre>
                                </div>
                                <hr/>
                                <div class="info-code">Hook works after loading all posts.</div>
                                <h5>Params function callback:</h5>
                                <ul>
                                    <li>class_name - is the name of the filter container class.</li>
                                    <li>response - returned data object, includes the following properties:
                                    <ul>
                                        <li>post_count - number of displayed posts per page;</li>
                                        <li>max_num_pages - maximum number of pages;</li>
                                        <li>found - number of found posts;</li>
                                        <li>post_type - post type name;</li>
                                    </ul>
                                    </li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#ymcAfterLoadedDataHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="ymcAfterLoadedDataHint">
                                        wp.hooks.addAction('ymc_after_loaded_data_545_1', 'smartfilter', function(class_name, response) {
                                            console.log('Container class: ' + class_name);
                                            console.log('Post count: ' + response.post_count);
                                            console.log('Number of found posts: ' + response.found);
                                        });
                                    </pre>
                                </div>
                            </div>
                           <div class="method-section ymc_complete_loaded_data">
                                <h2>[ ymc_complete_loaded_data ]</h2>
                                <div class="method-name">
                                    <pre>
                                        wp.hooks.addAction('ymc_complete_loaded_data', 'smartfilter', 'callback(class_name, status)');
                                        wp.hooks.addAction('ymc_complete_loaded_data_FilterID', 'smartfilter', 'callback(class_name, status)');
                                        wp.hooks.addAction('ymc_complete_loaded_data_FilterID_LayoutID', 'smartfilter', 'callback(class_name, status)');
                                    </pre>
                                </div>
                                <hr/>
                                <div class="info-code">This hook is called regardless of if the request was successful, or not.
                                              You will always receive a complete callback, even for synchronous requests.</div>
                                <h5>Params function callback:</h5>
                                <ul>
                                    <li>class_name - is the name of the filter container class.</li>
                                    <li>status - a string categorizing the status of the request ("success", "notmodified",
                                        "nocontent", "error", "timeout", "abort", or "parsererror").</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#ymcCompleteLoadedDataHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="ymcCompleteLoadedDataHint">
                                        wp.hooks.addAction('ymc_complete_loaded_data_545_1', 'smartfilter', function(class_name, status) {
                                            console.log('Complete loaded all data:' + class_name + ' status:' + status);
                                        });
                                    </pre>
                                </div>
                            </div>
                           <div class="method-section ymc_before_popup_open">
                                <h2>[ ymc_before_popup_open ]</h2>
                                <div class="method-name">
                                    <pre>
                                        wp.hooks.addAction('ymc_before_popup_open', 'smartfilter', 'callback');
                                        wp.hooks.addAction('ymc_before_popup_open_FilterID', 'smartfilter', 'callback');
                                        wp.hooks.addAction('ymc_before_popup_open_FilterID_LayoutID', 'smartfilter', 'callback');
                                    </pre>
                                </div>
                                <hr/>
                                <div class="info-code">This hook allows you to run any desired script before opening a popup for each post.</div>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#ymcBeforePopupOpenHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="ymcBeforePopupOpenHint">
                                        wp.hooks.addAction('ymc_before_popup_open_545_1', 'smartfilter', function(data) {
                                            console.log('Run custom script...');
                                        });
                                    </pre>
                                </div>
                            </div>
                           <div class="method-section ymc_after_popup_open">
                                <h2>[ ymc_after_popup_open ]</h2>
                                <div class="method-name">
                                    <pre>
                                        wp.hooks.addAction('ymc_after_popup_open', 'smartfilter', 'callback');
                                        wp.hooks.addAction('ymc_after_popup_open_FilterID', 'smartfilter', 'callback');
                                        wp.hooks.addAction('ymc_after_popup_open_FilterID_LayoutID', 'smartfilter', 'callback');
                                    </pre>
                                </div>
                                <hr/>
                                <div class="info-code">This hook allows you to run any desired script after opening a popup for each post.</div>
                                <h5>Params function callback:</h5>
                                <ul>
                                    <li>data - data that is loaded into the popup container.</li>
                                </ul>
                                <h5>Usage example:</h5>
                                <div class="code-hint">
                                    <div class="clipboard-container">
                                        <svg class="js-clipboard-copy" height="16" viewBox="0 0 16 16" width="16" data-clipboard-target="#ymcAfterPopupOpenHint">
                                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path><path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                                        </svg>
                                        <svg class="js-clipboard-check" height="16" viewBox="0 0 16 16" width="16">
                                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                                        </svg>
                                        <span class="js-clipboard-tip">Copied!</span>
                                    </div>
                                    <pre id="ymcAfterPopupOpenHint">
                                        wp.hooks.addAction('ymc_after_popup_open_545_1', 'smartfilter', function(data){
                                            console.log('Loaded data: '  + data);
                                        });
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header class="sub-header" data-class-name="preloader-settings">
        <i class="far fa-id-badge"></i>
        <?php echo esc_html__('Preloader', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper preloader-settings">

        <div class="form-group">

            <label class="form-label">
                <?php esc_html_e('Icon for Preloader', 'ymc-smart-filter'); ?>
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
                <?php esc_html_e('Filter CSS for Preloader Icon', 'ymc-smart-filter'); ?>
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

    <header class="sub-header" data-class-name="scroll-pagination">
        <i class="fas fa-scroll"></i>
        <?php echo esc_html__('Scroll Pagination', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper scroll-pagination">

        <div class="form-group">

            <label class="form-label">
                <?php esc_html_e('Page Scroll to Top', 'ymc-smart-filter'); ?>
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

    <header class="sub-header" data-class-name="debug-code">
        <i class="fas fa-code"></i>
        <?php echo esc_html__('Debug', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper debug-code">

        <div class="form-group">

            <label class="form-label">
                <?php esc_html_e('Response Parameters', 'ymc-smart-filter'); ?>
                <span class="information"><?php esc_html_e('Use Chrome DevTools or other tools in other browsers to 
                analyze and view the response from the server when sending requests. To do this, select the Network tab, 
                then select the current request and in the Preview tab you will see additional response parameters. 
                The response will display a Debug section with additional information. This is useful for debugging requests 
                using the JS-hooks plugin and development of custom scripts. For production, disable this option for security!', 'ymc-smart-filter'); ?></span>
            </label>

            <div class="group-elements">
                <?php $checked_debug_code =  ( (int) $ymc_debug_code === 1 ) ? 'checked' : ''; ?>
                <input type="hidden" name="ymc-debug-code" value="0">
                <input class="ymc-debug-code" type="checkbox" value="1" name="ymc-debug-code" id="ymc-debug-code"
                    <?php echo esc_attr($checked_debug_code); ?>>
                <label for="ymc-debug-code"><?php echo esc_html__('Enable','ymc-smart-filter'); ?></label>
            </div>

        </div>

    </div>

</div>