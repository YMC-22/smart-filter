;
(function( $ ) {
    "use strict"

    if( 'undefined' === typeof jQuery.migrateMute ) {
        console.error('jQuery Migrate is not defined.');
    }

    $(document).on('ready', function () {

        /*** API YMCTools ***/

        /**
         * YMCTools constructor function.
         * @param {Object} settings - The settings object for configuring the YMCTools instance.
         */
        function YMCTools( settings ) {

            const _defaults = {
                target : '.data-target-ymc1',
                self   : null,
                terms  : null,
                taxRel : null,
                meta   : null,
                date   : null,
                search : null,
                choicesPosts : null,
                excludePosts : null,
                sortOrder    : null,
                sortOrderBy  : null,
                metaKey      : null
            }

            let properties = Object.assign({}, _defaults, settings);

            for (let key in properties) {
                this[key] = properties[key];
            }
            this.length = Object.keys(properties).length;
        }

        /**
         * Get information about the YMCTools object.
         * @returns {string} Information about the author and version.
         */
        YMCTools.prototype.getInfo = function () {
            return `Author: YMC. Version: 2.9.59`;
        }

        /**
         * Update parameters for custom filter layout.
         * This function updates parameters based on user interaction.
         */
        YMCTools.prototype.updateParams = function () {

            let container = document.querySelector(''+ this.target +'');

            if( ! container )  throw new Error("Filter not found");
            if( this.self === null )  throw new Error("Terms is not defined");

            let link  = $(this.self);
            let dataParams = JSON.parse(container.dataset.params);

            let termIds  = link.data('termid');

            if( link.hasClass('multiple') ) {
                link.toggleClass('active').closest('.filter-layout').find('.all').removeClass('active');
            }
            else {
                link.addClass('active').
                parent().
                siblings().find('[data-termid]').
                removeClass('active').closest('.filter-layout').find('.all').removeClass('active');
            }

            let listActiveItems = link.closest('.filter-layout').find('.active');

            if(listActiveItems.length > 0) {

                termIds = '';

                link.closest('.filter-layout').find('.active').each(function (){
                    termIds += $(this).data('termid')+',';
                });

                termIds = termIds.replace(/,\s*$/, "");
            }
            else {
                termIds = link.closest('.filter-layout').find('.all').data('termid');
            }

            if(link.hasClass('all')) {
                link.addClass('active').parent().siblings().find('[data-termid]').removeClass('active');
            }

            dataParams.terms = termIds;
            dataParams.page = 1;
            dataParams.search = '';

            container.dataset.params = JSON.stringify(dataParams);
        }

        /**
         * Executes the filter to retrieve posts.
         */
        YMCTools.prototype.getFilterPosts = function () {

            let container = document.querySelector(''+ this.target +'');

            if( ! container )  throw new Error("Dom element not found");

            let params      = JSON.parse(container.dataset.params);
            let data_target = params.data_target;
            let type_pg     = params.type_pg;

            getFilterPosts({
                'paged'     : 1,
                'toggle_pg' : 1,
                'target'    : data_target,
                'type_pg'   : type_pg
            });
        }

        /**
         * Retrieves the choices posts based on the provided options.
         * @param {boolean} option - Indicates whether to perform the operation. Default is true.
         */
        YMCTools.prototype.apiChoicesPosts = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiChoicesPosts: Filter not found");
            if( this.choicesPosts === null || typeof this.choicesPosts === 'number')  throw new Error("Choices Posts is not defined");

            let dataParams = JSON.parse(container.dataset.params);

            dataParams.page = 1;
            dataParams.search = "";
            dataParams.choices_posts = this.choicesPosts;

            if( this.excludePosts !== null || this.excludePosts === 'on') {
                dataParams.exclude_posts = this.excludePosts;
            }

            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Updates the terms in the filter based on user interaction.
         * @param {boolean} option - Indicates whether to perform the operation. Default is true.
         */
        YMCTools.prototype.apiTermUpdate = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiTermUpdate: Filter not found");
            if( this.terms === null || typeof this.terms === 'number')  throw new Error("Terms is not defined");

            let dataParams = JSON.parse(container.dataset.params);

            dataParams.page = 1;
            dataParams.search = "";
            dataParams.terms = this.terms.replace(/<[^>]+>/g, '');

            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Opens a popup for the given post ID.
         * @param {string} postID - The ID of the post.
         */
        YMCTools.prototype.apiPopup = function ( postID ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiPopup: Target not found");
            if( ! postID ) throw new Error("ApiPopup: Post ID not defined");

            const options = {
                'postid' : postID,
                'target' : this.target
            };
            popupApiPost( options );
        }

        /**
         * Updates the meta data based on the user's selection.
         * @param {boolean} [option=true] - Indicates whether to perform the update. Default is true.
         */
        YMCTools.prototype.apiMetaUpdate = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiMetaUpdate: Filter not found");

            let dataParams = JSON.parse(container.dataset.params);

            dataParams.page = 1;
            dataParams.search = "";
            dataParams.meta_query = ( this.meta !== null ) ? this.meta : '';

            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Updates the API date with the specified options.
         * @param {boolean} option - Determines if filter posts should be fetched after updating the date.
         */
        YMCTools.prototype.apiDateUpdate = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiDateUpdate: Filter not found");

            let dataParams = JSON.parse(container.dataset.params);

            dataParams.page = 1;
            dataParams.search = "";
            dataParams.date_query = ( this.date !== null ) ? this.date : '';

            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Clears the terms in the filter and updates the search value.
         * @param {boolean} [option=true] - Indicates whether to clear the terms. Default is true.
         */
        YMCTools.prototype.apiTermClear = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiTermClear: Filter not found");

            let dataParams = JSON.parse(container.dataset.params);
            dataParams.terms = "";
            dataParams.search = "";
            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Clears the API metadata in the specified container.
         * If the option is true, it also retrieves filter posts.
         * @param {boolean} option - Indicates whether to retrieve filter posts after clearing metadata.
         */
        YMCTools.prototype.apiMetaClear = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiMetaClear: Filter not found");

            let dataParams = JSON.parse(container.dataset.params);
            dataParams.meta_query = "";
            dataParams.search = "";
            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Clears the date in the API and updates the search value.
         * @param {boolean} [option=true] - Indicates whether to clear the date. Default is true.
         */
        YMCTools.prototype.apiDateClear = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiDateClear: Filter not found");

            let dataParams = JSON.parse(container.dataset.params);
            dataParams.date_query = "";
            dataParams.search = "";
            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Clears the sorting and search parameters in the API filter.
         * @param {boolean} [option=true] - Determines whether to fetch posts after clearing.
         */
        YMCTools.prototype.apiSortClear = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiSortClear: Filter not found");

            let dataParams = JSON.parse(container.dataset.params);

            dataParams.search = "";
            dataParams.sort_order = "";
            dataParams.sort_orderby = "";
            dataParams.meta_key = "";

            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Clears the search and letter filters in the alphabet container.
         * @param {boolean} [option=true] - Whether to get filter posts after clearing.
         */
        YMCTools.prototype.apiLetterAlphabetClear = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("apiLetterAlphabetClear: Filter not found");

            let dataParams = JSON.parse(container.dataset.params);
            dataParams.search = "";
            dataParams.letter = "";
            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Updates parameters for searching posts based on user input.
         * @param {boolean} [option=true] - Determines whether to fetch posts after searching.
         * @param {Array} [terms=[]] - The array of search terms.
         */
        YMCTools.prototype.apiSearchPosts = function ( option = true, terms = [] ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiSearchPosts: Filter not found");
            if( this.search === null || typeof this.terms === 'number')  throw new Error("Search is not defined");

            let dataParams = JSON.parse(container.dataset.params);

            dataParams.page = 1;
            dataParams.search = this.search;

            dataParams.terms = ( Array.isArray(terms) && terms.length > 0 ) ? terms.join(',') :
                ( dataParams.search_filtered_posts === "1" ) ? dataParams.terms : "";

            dataParams.meta_query = "";
            dataParams.date_query = "";

            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Sorts the posts based on specified criteria.
         * @param {boolean} option - Determines whether to fetch and display the filtered posts after sorting.
         */
        YMCTools.prototype.apiSortPosts = function ( option = true ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiSortPosts: Filter not found");
            if( this.sortOrder === null || typeof this.sortOrder === 'number')  throw new Error("Sort Order is not defined");
            if( this.sortOrderBy === null || typeof this.sortOrderBy === 'number')  throw new Error("Sort OrderBy is not defined");

            let dataParams = JSON.parse(container.dataset.params);

            dataParams.page = 1;
            dataParams.search = "";
            dataParams.sort_order = this.sortOrder;
            dataParams.sort_orderby = this.sortOrderBy;
            dataParams.meta_key = this.metaKey;

            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }

        /**
         * Update the API page with the specified page number.
         * @param {number} page - The page number to update to. Default is 1.
         */
        YMCTools.prototype.apiPageUpdated = function ( page = 1 ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("apiPageUpdated: Filter not found");

            let dataParams = JSON.parse(container.dataset.params);

            let data_target = dataParams.data_target;
            let type_pg     = dataParams.type_pg;

            getFilterPosts({
                'paged'     : page,
                'toggle_pg' : 1,
                'target'    : data_target,
                'type_pg'   : type_pg
            });
        }

        /**
         * Calls the function to fetch and display filtered posts.
         */
        YMCTools.prototype.apiGetPosts = function () {
            this.getFilterPosts();
        }

        /**
         * Updates the API page with the specified page number.
         * @param option
         * @param cpt
         * @param tax
         * @param terms
         */
        YMCTools.prototype.apiMultiplePosts = function ( option = true, cpt = '', tax = '', terms = '' ) {

            let container = document.querySelector(''+ this.target +'');
            if( ! container )  throw new Error("ApiMultiplePosts: Filter not found");

            let dataParams = JSON.parse(container.dataset.params);

            dataParams.page = 1;
            dataParams.search = "";

            dataParams.cpt = ( cpt !== '' ) ? cpt.replaceAll(' ', '') : dataParams.cpt;

            dataParams.tax = ( tax !== '' ) ? tax.replaceAll(' ', '') : dataParams.tax;

            dataParams.terms = ( terms !== '' ) ? terms.replaceAll(' ', '') : dataParams.terms;

            container.dataset.params = JSON.stringify(dataParams);

            if( option ) {
                this.getFilterPosts();
            }
        }
        
        /**
         * Function to create a new YMCTools instance based on the provided settings.
         * @param {Object} settings - The settings object for configuring the YMCTools instance.
         * @returns {YMCTools} - A new YMCTools instance.
         */
        const _FN = function ( settings ) {
            return new YMCTools( settings )
        };

        ( typeof window.YMCTools === 'undefined' ) ? window.YMCTools = _FN : console.error('YMCTools is existed');


        /*** CONSTANTS ***/

        /**
         * Preloader path
         * @type {string}
         */
        const pathPreloader = _smart_filter_object.path+"/includes/assets/images/preloader.svg";


        /**
         * Options for IntersectionObserver
         * @type {{root: null, rootMargin: string, threshold: number}}
         */
        const optionsInfinityScroll = {
            root: null,
            rootMargin: '0px',
            threshold: 0.8
        }


        /**
         * Observer for IntersectionObserver
         * @type {IntersectionObserver}
         */
        const postsObserver = new IntersectionObserver((entries, observer) => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {

                    let params =  JSON.parse(entry.target.closest('.ymc-smart-filter-container').dataset.params);
                    params.page++;
                    entry.target.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

                    getFilterPosts({
                        'paged'     : params.page,
                        'toggle_pg' : 0,
                        'target'    : params.data_target,
                        'type_pg'   : params.type_pg
                    });

                    observer.unobserve(entry.target);
                }
            });

        }, optionsInfinityScroll);


        /*** FUNCTIONS ***/


        /**
         * Filter preloader based on parameters
         *
         * @param {object} params - The parameters for filtering the preloader
         * @param {string} params.preloader_filters - The type of filter
         * @param {number} params.preloader_filters_rate - The rate for the filter
         * @param {string} params.preloader_filters_custom - The custom filter
         * @returns {string} - The filtered preloader output
         */
        function filterPreloader( params ) {

            let filter = params.preloader_filters;
            let rate   = params.preloader_filters_rate;
            let filterCustom = params.preloader_filters_custom;
            let output = '';

            if( filter !== 'custom_filters' && filter !== 'none' ) {
                output = `filter: ${filter}(${rate})`;
            }
            else if( filter === 'none' ) {
                output = `filter: none`;
            }
            else {
                output = `${filterCustom}`;
            }

            return output;
        }

        /**
         * Function to set up Masonry Grid layouts.
         *
         * @param {HTMLElement} el - The element to apply the masonry grid to.
         * @param {string} f - The value for f.
         * @param {string} c - The value for c.
         */
        function masonryGrid( el, f, c ) {

            if( el.classList.contains("ymc-post-masonry") || el.classList.contains("ymc-post-custom-masonry") ) {

                wp.hooks.addAction('ymc_after_loaded_data_'+f+'_'+c, 'smartfilter', function(class_name, response) {

                    // Default Parameters
                    let staticContent = false;
                    let gutter       = 15;
                    let maxColumns   = 5;
                    let useMin       = false;
                    let useTransform = true;
                    let animate      = false;
                    let center       = true;

                    staticContent = wp.hooks.applyFilters('ymc_magicGrid_staticContent', staticContent);
                    staticContent = wp.hooks.applyFilters('ymc_magicGrid_staticContent_'+ f+'', staticContent);
                    staticContent = wp.hooks.applyFilters('ymc_magicGrid_staticContent_'+ f+'_'+c, staticContent);

                    gutter = wp.hooks.applyFilters('ymc_magicGrid_gutter', gutter);
                    gutter = wp.hooks.applyFilters('ymc_magicGrid_gutter_'+ f+'', gutter);
                    gutter = wp.hooks.applyFilters('ymc_magicGrid_gutter_'+ f+'_'+c, gutter);

                    maxColumns = wp.hooks.applyFilters('ymc_magicGrid_maxColumns', maxColumns);
                    maxColumns = wp.hooks.applyFilters('ymc_magicGrid_maxColumns_'+ f+'', maxColumns);
                    maxColumns = wp.hooks.applyFilters('ymc_magicGrid_maxColumns_'+ f+'_'+c, maxColumns);

                    useMin = wp.hooks.applyFilters('ymc_magicGrid_useMin', useMin);
                    useMin = wp.hooks.applyFilters('ymc_magicGrid_useMin_'+ f+'', useMin);
                    useMin = wp.hooks.applyFilters('ymc_magicGrid_useMin_'+ f+'_'+c, useMin);

                    useTransform = wp.hooks.applyFilters('ymc_magicGrid_useTransform', useTransform);
                    useTransform = wp.hooks.applyFilters('ymc_magicGrid_useTransform_'+ f+'', useTransform);
                    useTransform = wp.hooks.applyFilters('ymc_magicGrid_useTransform_'+ f+'_'+c, useTransform);

                    animate = wp.hooks.applyFilters('ymc_magicGrid_animate', animate);
                    animate = wp.hooks.applyFilters('ymc_magicGrid_animate_'+ f+'', animate);
                    animate = wp.hooks.applyFilters('ymc_magicGrid_animate_'+ f+'_'+c, animate);

                    center = wp.hooks.applyFilters('ymc_magicGrid_center', center);
                    center = wp.hooks.applyFilters('ymc_magicGrid_center_'+ f+'', center);
                    center = wp.hooks.applyFilters('ymc_magicGrid_center_'+ f+'_'+c, center);

                    let magicGrid = new MagicGrid({
                        container: `.${class_name} .post-entry`,
                        static: staticContent,
                        items: response.post_count,
                        gutter: gutter,
                        maxColumns: maxColumns,
                        useMin: useMin,
                        useTransform: useTransform,
                        animate: animate,
                        center: center
                    });

                    magicGrid.onReady(() => {
                         wp.hooks.doAction('ymc_magicGrid_ready');
                         wp.hooks.doAction('ymc_magicGrid_ready_'+f);
                         wp.hooks.doAction('ymc_magicGrid_ready_'+f+'_'+c);
                    });

                    magicGrid.onPositionComplete(() => {
                        wp.hooks.doAction('ymc_magicGrid_position_complete');
                        wp.hooks.doAction('ymc_magicGrid_position_complete_'+f);
                        wp.hooks.doAction('ymc_magicGrid_position_complete_'+f+'_'+c);
                    });

                    magicGrid.listen();
                    magicGrid.positionItems();

                });
            }
        }

        /**
         * Function to handle the popup post.
         * @param {Event} e - The event triggering the popup.
         */
        function popupPost(e) {
            e.preventDefault();
            let _self = $(e.target);
            let postId = _self.closest('.ymc-popup').data('postid');
            let popupOverlay = _self.closest('.ymc-smart-filter-container').find('.ymc-popup-overlay');
            let popupContainer = _self.closest('.ymc-smart-filter-container').find('.popup-entry');
            let bodyHtml = $('body, html');
            let postContainer = _self.closest('.post-item');
            let target = e.target.closest('.ymc-smart-filter-container');
            let params = JSON.parse(target.dataset.params);
            let stylePreloader = _smart_filter_object.path+"/includes/assets/images/"+ params.preloader_icon +".svg";
            let preloaderFilter = filterPreloader( params );
            let classAnimation = params.popup_animation;

            stylePreloader = wp.hooks.applyFilters('ymc_custom_popup_preloader', stylePreloader);
            stylePreloader = wp.hooks.applyFilters('ymc_custom_popup_preloader_'+ params.filter_id, stylePreloader);
            stylePreloader = wp.hooks.applyFilters('ymc_custom_popup_preloader_'+ params.filter_id+'_'+params.target_id, stylePreloader);

            const data = {
                'action'     : 'get_post_popup',
                'nonce_code' : _smart_filter_object.nonce,
                'post_id'    : postId,
                'filter_id'  : params.filter_id,
                'target_id'  : params.target_id
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    postContainer.addClass('loading').
                    prepend(`<img class="preloader preloader--popup" src="${stylePreloader}" style="${preloaderFilter}">`);

                    // Add Hook: before open popup
                    wp.hooks.doAction('ymc_before_popup_open');
                    wp.hooks.doAction('ymc_before_popup_open_'+params.filter_id);
                    wp.hooks.doAction('ymc_before_popup_open_'+params.filter_id+'_'+params.target_id);
                },
                success: function (res) {
                    postContainer.
                    removeClass('loading').
                    find('.preloader').
                    remove();

                    if(res.data !== '') {
                        popupContainer.html(res.data);
                        popupOverlay.css({'display':'block','opacity':'1'});
                        bodyHtml.css({'overflow' : 'hidden'});
                        popupContainer.closest('.ymc-popup-wrp').addClass(classAnimation);
                    }

                    // Add Hook: after open popup
                    wp.hooks.doAction('ymc_after_popup_open', res.data);
                    wp.hooks.doAction('ymc_after_popup_open_'+params.filter_id, res.data);
                    wp.hooks.doAction('ymc_after_popup_open_'+params.filter_id+'_'+params.target_id, res.data);
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        }

        /**
         * Function to close the popup.
         * @param {Event} e - The event triggering the function.
         */
        function popupClose(e) {
            e.preventDefault();

            let popupOverlay = $(e.target).closest('.ymc-smart-filter-container').find('.ymc-popup-overlay');
            let bodyHtml = $('body, html');
            let target = e.target.closest('.ymc-smart-filter-container');
            let params = JSON.parse(target.dataset.params);
            let classAnimation = params.popup_animation;

            popupOverlay.css({'display':'none','opacity':'0'});
            popupOverlay.find('.ymc-popup-wrp').removeClass(classAnimation);
            bodyHtml.css({'overflow' : 'auto'});
        }

        /**
         * Function to handle the popup API.
         *
         * @param {Object} options - The options for the popup.
         * @param {string} options.postid - The post ID for the popup.
         * @param {string} options.target - The target element for the popup.
         */
        function popupApiPost( options ) {

            let postID = options.postid;
            let target = options.target;
            let bodyHtml = $('body, html');
            let popupContainer = $(target).find('.popup-entry');
            let popupOverlay = $(target).find('.ymc-popup-overlay');

            let params = JSON.parse(document.querySelector(target).dataset.params);
            let filterID = params.filter_id;
            let targetID = params.target_id;

            const data = {
                'action'     : 'get_post_popup',
                'nonce_code' : _smart_filter_object.nonce,
                'post_id'    : postID,
                'filter_id'  : filterID,
                'target_id'  : targetID
            };

            if ( popupContainer.length ) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: _smart_filter_object.ajax_url,
                    data: data,
                    beforeSend: function () {},
                    success: function (res) {
                        if(res.data !== '') {
                            popupContainer.html(res.data);
                            popupOverlay.css({'display':'block','opacity':'1'});
                            bodyHtml.css({'overflow' : 'hidden'});
                        }

                        // Add Hook: after open popup
                        wp.hooks.doAction('ymc_after_popup_open_'+params.filter_id+'_'+params.target_id, res.data);
                    },
                    error: function (obj, err) {
                        console.log( obj, err );
                    }
                });
            }
        }

        /**
         * This function initializes a Swiper carousel for posts if the given element has the specified class.
         * @param {Element} el - The element to check for the class.
         * @param {string} f - The value to use in the event hook.
         * @param {string} c - The value to use in the event hook.
         * @param {object} p - An object containing parameters for the Swiper carousel.
         */
        function carouselPosts( el,f,c,p ) {

            if( el.classList.contains("ymc-post-carousel-layout") ) {

                wp.hooks.addAction('ymc_complete_loaded_data_'+f+'_'+c, 'smartfilter', function(class_name, status) {
                    
                    if( 'success' === status ) {

                        // General Parameters
                        let disabledSwiper  = JSON.parse(p.parameters.disabled);
                        let autoHeight      = JSON.parse(p.parameters.autoHeight);
                        let autoPlay        = JSON.parse(p.parameters.autoPlay);
                        let delay           = JSON.parse(p.parameters.delay);
                        let loop            = JSON.parse(p.parameters.loop);
                        let centeredSlides  = JSON.parse(p.parameters.centeredSlides);
                        let slidesPerView   = JSON.parse(p.parameters.slidesPerView);
                        let spaceBetween    = JSON.parse(p.parameters.spaceBetween);
                        let mousewheel      = JSON.parse(p.parameters.mousewheel);
                        let speed           = JSON.parse(p.parameters.speed);
                        let effect          = p.parameters.effect;

                        // Pagination
                        let visibilityPagination  = JSON.parse(p.pagination.visibility);
                        let dynamicBullets = JSON.parse(p.pagination.dynamicBullets);
                        let typePagination  = p.pagination.type;

                        // Navigation
                        let visibilityNav = JSON.parse(p.navigation.visibility);

                        // Scrollbar
                        let visibilityScroll = JSON.parse(p.scroll.visibility);

                        // Add Class spaceBetweenSlide to container posts
                        ( visibilityNav ) ? $(el).find('.carousel-container .post-carousel-layout').addClass('spaceBetweenSlide') : '';

                        // Init Swiper
                        if( disabledSwiper ) {

                            new Swiper(`.swiper-${f}-${c}`, {
                                // Default parameters
                                grabCursor: true,
                                spaceBetween: spaceBetween,
                                centeredSlides: centeredSlides,

                                // General Parameters
                                autoHeight: autoHeight,
                                autoplay: ( autoPlay) ? { delay: delay } : false,
                                loop: loop,
                                slidesPerView: slidesPerView,
                                mousewheel: ( mousewheel ) ? { invert: true } : false,
                                speed: speed,
                                effect: effect,
                                fadeEffect: ( effect === 'fade' ) ? { crossFade: true } : '',
                                creativeEffect: ( effect === 'creative' ) ? {
                                    prev: { shadow: true, translate: [0, 0, -400] },
                                    next: { translate: ["100%", 0, 0] },
                                } : '',


                                // Pagination Dots
                                pagination: ( visibilityPagination ) ?  {
                                    el: '.swiper-pagination',
                                    clickable: true,
                                    dynamicBullets : dynamicBullets,
                                    type: typePagination,

                                } : false,

                                // Navigation Arrows
                                navigation:  {
                                    nextEl: '.swiper-button-next',
                                    prevEl: '.swiper-button-prev',
                                    enabled: visibilityNav
                                } ,

                                // Scrollbar
                                scrollbar:  {
                                    el: '.swiper-scrollbar',
                                        draggable: true,
                                        enabled: visibilityScroll
                                }
                            });
                        }
                    }
                    else {
                        console.error('Failed to load data');
                    }
                });
            }
        }

        function getRangeTerms(s,e,termsArray) {
            let terms = '';
            for(let i = s; i <= e; i++) {
                terms += termsArray[i][0] + ',';
            }
            return terms.replace(/,\s*$/, "");
        }

        function fillRangeColor(sliderOne,sliderTwo,sliderMaxValue,sliderTrack) {
            let percent1 = (sliderOne.value / sliderMaxValue) * 100;
            let percent2 = (sliderTwo.value / sliderMaxValue) * 100;
            sliderTrack.style.background = `linear-gradient(to right, #dadae5 ${percent1}% , rgb(9, 138, 184) ${percent1}% , rgb(9, 138, 184) ${percent2}%, #dadae5 ${percent2}%)`;
        }

        /**
         * Main Request function to get filter posts based on options provided.
         *
         * @param {Object} options - The options object containing paged, toggle_pg, target, and type_pg.
         */
        function getFilterPosts( options ) {

            let paged     = options.paged;
            let toggle_pg = options.toggle_pg; // if 1 use func: html() or 0 append(): use load-more && scroll-infinity
            let target    = options.target;
            let type_pg   = options.type_pg;  // pagination type

            let container = $("."+target+"");
            let params = JSON.parse(document.querySelector('.'+target+'').dataset.params);

            let stylePreloader = _smart_filter_object.path+"/includes/assets/images/"+ params.preloader_icon +".svg";
            let preloaderFilter = filterPreloader( params );

            let filterID = params.filter_id;
            let targetID = params.target_id;
            let pageScroll = params.page_scroll;
            let postLayout = params.post_layout;

            const data = {
                'action'     : 'ymc_get_posts',
                'nonce_code' : _smart_filter_object.nonce,
                'params'     : JSON.stringify(params),
                'paged'      : paged
            };

            stylePreloader = wp.hooks.applyFilters('ymc_custom_grid_preloader', stylePreloader);
            stylePreloader = wp.hooks.applyFilters('ymc_custom_grid_preloader_'+ params.filter_id, stylePreloader);
            stylePreloader = wp.hooks.applyFilters('ymc_custom_grid_preloader_'+ params.filter_id+'_'+params.target_id, stylePreloader);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    container.find('.container-posts').addClass('loading');
                    // Load more or Scroll infinity
                    if(toggle_pg === 0) {
                        container.find('.post-entry').
                        append(`<img class="preloader preloader--load" src="${stylePreloader}" style="${preloaderFilter}">`);
                    }
                    else {
                        container.find('.container-posts').
                        prepend(`<img class="preloader preloader--numeric" src="${stylePreloader}" style="${preloaderFilter}">`);
                    }

                    // Add Hook: before loaded posts
                    wp.hooks.doAction('ymc_before_loaded_data', target);
                    wp.hooks.doAction('ymc_before_loaded_data_'+filterID, target);
                    wp.hooks.doAction('ymc_before_loaded_data_'+filterID+'_'+targetID, target);
                },
                success: function (res, status, request) {

                    if( params.posts_selected !== 'all' || params.search !== '' ) {
                        container.find('.filter-layout .posts-found').html(`<span>${res.posts_selected}</span>`);
                    }
                    else {
                        container.find('.filter-layout .posts-found').empty();
                    }

                    switch ( type_pg )
                    {
                        case 'load-more' :

                            if(toggle_pg === 0) {
                                container.
                                find('.container-posts').
                                removeClass('loading').
                                find('.preloader').
                                remove().
                                end().
                                find('.post-entry').
                                append(res.data).
                                end().
                                find('.ymc-pagination').
                                remove().
                                end().
                                append(res.pagin);
                            }
                            else  {
                                container.
                                find('.container-posts').
                                removeClass('loading').
                                find('.preloader').
                                remove().
                                end().
                                find('.post-entry').
                                html(res.data).
                                end().
                                find('.ymc-pagination').
                                remove().
                                end().
                                append(res.pagin);
                            }

                            if(res.get_current_posts <= 0) {
                                container. find('.pagination-load-more').remove();
                            }

                            break;

                        case 'scroll-infinity' :

                            if(toggle_pg === 0) {
                                container.
                                find('.container-posts').
                                removeClass('loading').
                                find('.preloader').
                                remove().
                                end().
                                find('.post-entry').
                                append(res.data).
                                end().
                                append(res.pagin);
                            }
                            else  {
                                container.
                                find('.container-posts').
                                removeClass('loading').
                                find('.preloader').
                                remove().
                                end().
                                find('.post-entry').
                                html(res.data).
                                end().
                                append(res.pagin);
                            }

                            if(res.get_current_posts > 0 && postLayout !== 'post-carousel-layout') {
                                postsObserver.observe(document.querySelector('.'+target+' .post-entry .post-item:last-child'));
                            }

                            break;

                        case 'numeric' :
                            // Scroll top
                            if(!container.hasClass('ymc-loaded-filter') && toggle_pg === 1 && parseInt(pageScroll) === 1 ) {
                                //$('html, body').animate({scrollTop: container.offset().top}, 500);
                                document.querySelector('.'+target).scrollIntoView(
                                    {behavior: "smooth", block: "start", inline: "start"}
                                );
                            }

                            container.
                            find('.container-posts').
                            removeClass('loading').
                            find('.preloader').
                            remove().
                            end().
                            find('.post-entry').
                            html(res.data).
                            end().
                            find('.ymc-pagination').
                            remove().
                            end().
                            append(res.pagin);

                            break;
                    }

                    // Updated attr data-loading
                    document.querySelector('.'+target).dataset.loading = 'true';

                    // Add Hook: after loaded posts
                    wp.hooks.doAction('ymc_after_loaded_data', target, res);
                    wp.hooks.doAction('ymc_after_loaded_data_'+filterID, target, res);
                    wp.hooks.doAction('ymc_after_loaded_data_'+filterID+'_'+targetID, target, res);

                },
                complete: function (XHR, status) {
                    // Add Hook: called regardless of if the request was successful, or not
                    wp.hooks.doAction('ymc_complete_loaded_data', target, status);
                    wp.hooks.doAction('ymc_complete_loaded_data_'+filterID, target, status);
                    wp.hooks.doAction('ymc_complete_loaded_data_'+filterID+'_'+targetID, target, status);
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        }

        /**
         * Initialize Loading Filters & entry point
         * Add Hook: stop loading posts on page load
         */
        document.querySelectorAll('.ymc-smart-filter-container').forEach(function (el) {

            // Add Hook: stop loading posts on page load
            wp.hooks.doAction('ymc_stop_loading_data', el);

            if( undefined !== el.dataset.params )
            {
                let loadingPosts   = el.dataset.loading;
                let params      = JSON.parse(el.dataset.params);
                let data_target = params.data_target;
                let type_pg     = params.type_pg;
                let filter_id = params.filter_id;
                let target_id = params.target_id;
                let carousel_params = params.carousel_params;

                if( loadingPosts === 'true' )
                {
                    // Set Default Terms
                    if( params.default_terms !== '' )
                    {
                        params.terms = params.default_terms;
                        el.dataset.params = JSON.stringify(params);
                    }

                    // Init Load Posts
                    getFilterPosts({
                        'paged'     : 1,
                        'toggle_pg' : 1,
                        'target'    : data_target,
                        'type_pg'   : type_pg
                    });

                    // Run Masonry Grid
                    masonryGrid(el, filter_id, target_id);

                    // Carousel Posts
                    carouselPosts(el, filter_id, target_id, carousel_params);
                }
            }
        });


        /*** EVENTS ***/

        // Filter Posts Layout1
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout1 .filter-link, .ymc-extra-filter .filter-layout1 .filter-link', function (e) {
            e.preventDefault();

            let link = $(this);
            let term_id = link.data('termid');
            let posts_selected = link.data('selected');
            let filterContainer = this.closest('.ymc-smart-filter-container');

            if( !link.hasClass('isDisabled') )
            {
                if ( this.closest('.ymc-extra-filter') ) {
                    let extraFilterId = link.closest('.ymc-extra-filter').data('extraFilterId');
                    filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
                }

                if(link.hasClass('multiple')) {
                    link.toggleClass('active').closest('.filter-entry').find('.all').removeClass('active');
                }
                else {
                    link.closest('.filter-entry').find('.filter-item .filter-link').removeClass('active');
                    link.addClass('active');
                }

                let listActiveItems = link.closest('.filter-entry').find('.active');

                if(listActiveItems.length > 0) {

                    term_id = '';

                    link.closest('.filter-entry').find('.active').each(function (){
                        term_id += $(this).data('termid')+',';
                    });

                    term_id = term_id.replace(/,\s*$/, "");
                }
                else {
                    term_id = link.closest('.filter-entry').find('.all').data('termid');
                }

                if(link.hasClass('all')) {
                    link.addClass('active').closest('.filter-entry').find('.filter-link:not(.all)').removeClass('active');
                }

                if( filterContainer )
                {
                    let params = JSON.parse( filterContainer.dataset.params);
                    params.terms = term_id;
                    params.page = 1;
                    params.search = '';
                    params.posts_selected = posts_selected;
                    filterContainer.dataset.params = JSON.stringify(params);

                    getFilterPosts({
                        'paged'      : 1,
                        'toggle_pg'  : 1,
                        'target'     : params.data_target,
                        'type_pg'    : params.type_pg
                    });
                }

            }
        });

        // Submenu off-screen (Hierarchy Tree)
        $(document).on('mouseenter mouseleave', '.ymc-smart-filter-container .filter-layout1 .filter-entry .item-has-children, .ymc-extra-filter .filter-layout1 .filter-entry .item-has-children', function (e) {
            let elem = $('.sub_item', this);
            let offElem = elem.offset();
            let l = offElem.left;
            let w = elem.width();
            let filetr = $(document);
            let docW = filetr.width();
            let isEntirelyVisible = ( l + w + 50 <= docW );
            if ( !isEntirelyVisible ) {
                $(this).find('.sub_item').addClass('edge');
            }
            else {
                $(this).find('.sub_item').removeClass('edge');
            }
        });

        // Filter Posts Layout2
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout2 .filter-link, .ymc-extra-filter .filter-layout2 .filter-link', function (e) {
            e.preventDefault();

            let link = $(this);
            let term_id = link.data('termid');
            let posts_selected = link.data('selected');
            let filterContainer = this.closest('.ymc-smart-filter-container');

            if( !link.hasClass('isDisabled') )
            {
                if ( this.closest('.ymc-extra-filter') ) {
                    let extraFilterId   = link.closest('.ymc-extra-filter').data('extraFilterId');
                    filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
                }

                if(link.hasClass('multiple')) {
                    link.toggleClass('active').closest('.filter-entry').find('.all').removeClass('active');
                }
                else {
                    link.addClass('active').
                    closest('.filter-item').
                    siblings().find('.filter-link').
                    removeClass('active').
                    closest('.filter-entry').find('.all').removeClass('active');
                }

                let listActiveItems = link.closest('.filter-entry').find('.active');

                if(listActiveItems.length > 0) {

                    term_id = '';

                    link.closest('.filter-entry').find('.active').each(function (){
                        term_id += $(this).data('termid')+',';
                    });

                    term_id = term_id.replace(/,\s*$/, "");
                }
                else {
                    term_id = link.closest('.filter-entry').find('.all').data('termid');
                }

                if(link.hasClass('all')) {
                    link.addClass('active').closest('.filter-item').siblings().find('.filter-link').removeClass('active');
                }

                if( filterContainer )
                {
                    let params = JSON.parse( filterContainer.dataset.params);
                    params.terms = term_id;
                    params.page = 1;
                    params.search = '';
                    params.posts_selected = posts_selected;
                    filterContainer.dataset.params = JSON.stringify(params);

                    getFilterPosts({
                        'paged'     : 1,
                        'toggle_pg' : 1,
                        'target'    : params.data_target,
                        'type_pg'   : params.type_pg
                    });
                }
            }
        });

        // Filter Post Layout3
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .dropdown-filter .menu-active, .ymc-extra-filter .filter-layout3 .dropdown-filter .menu-active', function (e) {
            e.preventDefault();
            let $el = $(this);
            $el.find('.arrow').toggleClass('open').end().next().toggle();
            $el.closest('.dropdown-filter').siblings().find('.menu-passive').hide().end().find('.arrow').removeClass('open');
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .dropdown-filter .menu-passive .btn-close, .ymc-extra-filter .filter-layout3 .dropdown-filter .menu-passive .btn-close', function (e) {
            e.preventDefault();
            $(this).closest('.dropdown-filter').find('.down').removeClass('open').end().find('.menu-passive').hide();
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .dropdown-filter .menu-passive .menu-link, .ymc-extra-filter .filter-layout3 .dropdown-filter .menu-passive .menu-link', function (e) {
            e.preventDefault();
            let link = $(this);
            let term_id = '';
            let posts_selected = link.data('selected');
            let filterContainer = this.closest('.ymc-smart-filter-container');

            if( !link.hasClass('isDisabled') )
            {
                if ( this.closest('.ymc-extra-filter') ) {
                    let extraFilterId   = link.closest('.ymc-extra-filter').data('extraFilterId');
                    filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
                }

                // List items
                if( link.closest('.hierarchy-filter3').length === 0 ) {

                    link.toggleClass('active');

                    // Single selected terms
                    if( !link.hasClass('multiple') ) {

                        link.closest('.menu-passive__item').
                        siblings().find('.menu-link').
                        removeClass('active');

                        link.closest('.dropdown-filter').find('.menu-active span').html($(this).data('name'));
                    }

                    let listActiveItems = link.closest('.filter-entry').find('.active');

                    if(listActiveItems.length > 0) {

                        link.closest('.filter-entry').find('.active').each(function (){
                            term_id += $(this).data('termid')+',';
                        });

                        term_id = term_id.replace(/,\s*$/, "");

                        if( link.hasClass('multiple') ) {
                            // Add selected terms
                            let allLinks = $(link.closest('.filter-entry')).find('.dropdown-filter .menu-link');
                            let selItem = '';

                            term_id.split(',').forEach(function (el) {
                                allLinks.each(function () {
                                    if ($(this).data('termid') === parseInt(el)) {
                                        selItem += `<span data-trm="${el}" class="item">${$(this).data('name')} <small>x</small></span>`;
                                    }
                                });
                            });

                            $(link.closest('.filter-entry')).find('.selected-items').html(selItem);
                        }
                    }
                    else {
                        term_id = link.closest('.filter-entry').data('terms');
                        $(link.closest('.filter-entry')).find('.selected-items').empty();
                    }
                }
                // Hierarchy items
                else {

                    // Single selected terms
                    if( !link.hasClass('multiple') ) {
                        link.closest('.dropdown-filter').find('.menu-link').removeClass('active');
                        link.addClass('active');

                        link.closest('.dropdown-filter').find('.menu-active span').html(link.data('name'));
                    }
                    else {
                        link.toggleClass('active');
                    }

                    let listActiveItems = link.closest('.filter-entry').find('.active');

                    if(listActiveItems.length > 0) {

                        link.closest('.filter-entry').find('.active').each(function (){
                            term_id += $(this).data('termid')+',';
                        });

                        term_id = term_id.replace(/,\s*$/, "");

                        if( link.hasClass('multiple') ) {
                            // Add selected terms
                            let allLinks = link.closest('.filter-entry').find('.dropdown-filter .menu-link');
                            let selItem = '';

                            term_id.split(',').forEach(function (el) {
                                allLinks.each(function () {
                                    if ($(this).data('termid') === parseInt(el)) {
                                        selItem += `<span data-trm="${el}" class="item">${$(this).data('name')} <small>x</small></span>`;
                                    }
                                });
                            });

                            link.closest('.filter-entry').find('.selected-items').html(selItem);
                        }
                    }
                    else {
                        term_id = link.closest('.filter-entry').data('terms');
                        $(link.closest('.filter-entry')).find('.selected-items').empty();
                    }
                }

                if( filterContainer )
                {
                    // Update data params
                    let params = JSON.parse( filterContainer.dataset.params);
                    params.terms = term_id;
                    params.page = 1;
                    params.search = '';
                    params.posts_selected = posts_selected;
                    filterContainer.dataset.params = JSON.stringify(params);

                    getFilterPosts({
                        'paged'     : 1,
                        'toggle_pg' : 1,
                        'target'    : params.data_target,
                        'type_pg'   : params.type_pg
                    });
                }
            }
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .hierarchy-filter3 .item-has-children .isArrow, .ymc-extra-filter .hierarchy-filter3 .item-has-children .isArrow', function (e) {
            let arrow = $(e.target);
            // Open / Close sub items
            arrow.toggleClass('isOpen').next('.sub_item').length > 0 ?
                arrow.next('.sub_item').toggleClass('isActive').closest('.item-has-children').toggleClass('isActive') :
                arrow.closest('.link-inner').next('.sub_item').toggleClass('isActive').closest('.item-has-children').toggleClass('isActive');
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .filter-entry .selected-items small, .ymc-extra-filter .filter-layout3 .filter-entry .selected-items small', function (e) {
            e.preventDefault();

            let _self = $(this);

            let term_id = _self.closest('.item').data('trm');

            let isItems = _self.closest('.selected-items').find('.item').length - 1;

            let filterContainer = this.closest('.ymc-smart-filter-container');

            if ( this.closest('.ymc-extra-filter') ) {
                let extraFilterId   = _self.closest('.ymc-extra-filter').data('extraFilterId');
                filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
            }

            //let term_sel = (isItems > 0 ) ? isItems : 'all';

            if( filterContainer )
            {
                let params = JSON.parse( filterContainer.dataset.params);
                let arrTerms = params.terms.split(',');
                let newTerms = arrTerms.filter(function(f) { return parseInt(f) !== term_id });
                if(newTerms.length > 0) {
                    newTerms = newTerms.join(',');
                }
                else {
                    newTerms = _self.closest('.filter-entry').data('terms');
                }

                params.terms = newTerms;
                params.page = 1;
                params.search = '';

                filterContainer.dataset.params = JSON.stringify(params);

                _self.closest('.filter-entry').find('.active').each(function () {
                    if(parseInt($(this).data('termid')) === term_id) {
                        $(this).removeClass('active');
                    }
                });

                _self.closest('.item').remove();

                getFilterPosts({
                    'paged'     : 1,
                    'toggle_pg' : 1,
                    'target'    : params.data_target,
                    'type_pg'   : params.type_pg
                });
            }
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .filter-entry .btn-all, .ymc-extra-filter .filter-layout3 .filter-entry .btn-all', function (e) {
            e.preventDefault();

            let _self = $(this);
            let terms = _self.data('terms');
            let posts_selected = _self.data('selected');

            let filterContainer = this.closest('.ymc-smart-filter-container');

            if ( this.closest('.ymc-extra-filter') ) {
                let extraFilterId   = _self.closest('.ymc-extra-filter').data('extraFilterId');
                filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
            }

            if( filterContainer )
            {
                let params = JSON.parse( filterContainer.dataset.params);
                params.terms = terms;
                params.page = 1;
                params.search = '';
                params.posts_selected = posts_selected;
                filterContainer.dataset.params = JSON.stringify(params);

                _self.siblings('.selected-items').empty();
                _self.siblings('.dropdown-filter').find('.active').removeClass('active');
                _self.siblings('.dropdown-filter').find('.isActive, .isOpen').removeClass('isActive isOpen');
                _self.siblings('.dropdown-filter').find('.menu-passive').hide();
                _self.siblings('.dropdown-filter').find('.original-tax-name').each(function () {
                    $(this).text($(this).data('originalTaxName'));
                });

                getFilterPosts({
                    'paged'     : 1,
                    'toggle_pg' : 1,
                    'target'    : params.data_target,
                    'type_pg'   : params.type_pg
                });
            }
        });

        // Filter Posts Layout4
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout4 .name-tax, .ymc-extra-filter .filter-layout4 .name-tax', function (e) {
            let _self = $(this);
            _self.toggleClass('open').next().slideToggle(300);
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout4 .filter-link, .ymc-extra-filter .filter-layout4 .filter-link', function (e) {
            e.preventDefault();

            let link = $(this);
            let term_id = '';
            let posts_selected = link.data('selected');
            let filterContainer = this.closest('.ymc-smart-filter-container');

            if( !link.hasClass('isDisabled') )
            {
                if ( this.closest('.ymc-extra-filter') ) {
                    let extraFilterId   = link.closest('.ymc-extra-filter').data('extraFilterId');
                    filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
                }

                if(link.hasClass('multiple')) {
                    link.toggleClass('active').closest('.filter-entry').find('.all').removeClass('active');
                }
                else {
                    link.closest('.filter-entry').find('.active').removeClass('active').end().end().addClass('active');
                }

                let listActiveItems = link.closest('.filter-entry').find('.active');

                if( listActiveItems.length > 0 ) {

                    listActiveItems.each(function() {
                        term_id += $(this).data('termid')+',';
                    });

                    term_id = term_id.replace(/,\s*$/, "");
                }
                else {
                    term_id = link.closest('.filter-entry').find('.all').data('termid');
                }

                if(link.hasClass('all')) {
                    link.addClass('active').closest('.filter-entry').find('.group-filters .active, .group-filters .isActive, .group-filters .isOpen').removeClass('active isActive isOpen');
                }

                if( filterContainer )
                {
                    let params = JSON.parse( filterContainer.dataset.params);
                    params.terms = term_id;
                    params.page = 1;
                    params.search = '';
                    params.posts_selected = posts_selected;
                    filterContainer.dataset.params = JSON.stringify(params);

                    getFilterPosts({
                        'paged'     : 1,
                        'toggle_pg' : 1,
                        'target'    : params.data_target,
                        'type_pg'   : params.type_pg
                    });
                }
            }
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .hierarchy-filter4 .item-has-children .isArrow, .ymc-extra-filter .hierarchy-filter4 .item-has-children .isArrow', function (e) {
            let arrow = $(e.target);

            // Open / Close sub items
            arrow.toggleClass('isOpen').next('.sub_item').length > 0 ?
                arrow.next('.sub_item').toggleClass('isActive').closest('.item-has-children').toggleClass('isActive') :
                arrow.closest('.link-inner').next('.sub_item').toggleClass('isActive').closest('.item-has-children').toggleClass('isActive');
        });

        // Filter Post Layout5 (Dropdown Filter Compact)
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout5 .dropdown-filter .menu-active, .ymc-extra-filter .filter-layout5 .dropdown-filter .menu-active', function (e) {
            e.preventDefault();
            let $el = $(this);
            $el.find('.arrow').toggleClass('open').end().next().toggle();
            $el.closest('.dropdown-filter').siblings().find('.menu-passive').hide().end().find('.arrow').removeClass('open');
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout5 .dropdown-filter .menu-passive .btn-close, .ymc-extra-filter .filter-layout5 .dropdown-filter .menu-passive .btn-close', function (e) {
            e.preventDefault();
            $(this).closest('.dropdown-filter').find('.down').removeClass('open').end().find('.menu-passive').hide();
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout5 .dropdown-filter .menu-passive .menu-link, .ymc-extra-filter .filter-layout5 .dropdown-filter .menu-passive .menu-link', function (e) {
            e.preventDefault();
            let link = $(this);
            let term_id = '';
            let posts_selected = link.data('selected');
            let filterContainer = this.closest('.ymc-smart-filter-container');
            let textAll = link.closest('.filter-entry').data('textAll');

            if( !link.hasClass('isDisabled') )
            {
                link.toggleClass('active');

                if ( this.closest('.ymc-extra-filter') ) {
                    let extraFilterId   = link.closest('.ymc-extra-filter').data('extraFilterId');
                    filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
                }

                let listActiveItems = link.closest('.filter-entry').find('.active');

                if( link.hasClass('all') ) {
                    link.closest('.menu-passive__item').
                    next().find('.menu-link').
                    removeClass('active');
                }
                else {
                    link.closest('.menu-passive__inner-items').
                    prev().find('.all').
                    removeClass('active');
                }

                // Not Multiple Taxonomy
                if( listActiveItems.length > 0 && ! link.hasClass('multiple') ) {

                    link.closest('.menu-passive__item').siblings().find('.menu-link').removeClass('active');

                    link.closest('.dropdown-filter').find('.menu-active .text-cat').html($(this).data('name'));

                    link.closest('.filter-entry').find('.active:not(.all)').each(function () {
                        term_id += $(this).data('termid')+',';
                    });
                }

                // Multiple Taxonomy
                else if( listActiveItems.length > 0 && link.hasClass('multiple') ) {

                    let placeholderTax = link.closest('.dropdown-filter').find('.menu-active .text-cat');

                    let allTerms = link.closest('.filter-entry').find('.menu-link:not(.all)');

                    let allTermsCheked = link.closest('.filter-entry').find('.active:not(.all)');

                    let selTermsActive = link.closest('.menu-passive').find('.active');

                    let selTerms = '';

                    let selItemHTML = '';

                    // Add selected terms to HTML ---
                    allTermsCheked.each(function () {
                        selTerms += $(this).data('termid')+',';
                    });

                    selTerms = selTerms.replace(/,\s*$/, "");

                    selTerms.split(',').forEach(function (el) {
                        allTerms.each(function () {
                            if ($(this).data('termid') === parseInt(el)) {
                                selItemHTML += `<span data-trm="${el}" class="item">${$(this).data('name')} <small>x</small></span>`;
                            }
                        });
                    });

                    $(link.closest('.filter-entry')).find('.selected-items').html(selItemHTML);

                    // Add selected IDs terms --
                    link.closest('.filter-entry').find('.active:not(.all)').each(function () {
                        term_id += $(this).data('termid')+',';
                    });

                    // Rename Label Tax --
                    ( ! link.hasClass('all') && selTermsActive.length > 0 ) ?  placeholderTax.html('Selected') : placeholderTax.html(textAll);

                }

                else {

                    link.closest('.filter-entry').find('.menu-active .text-cat').html('All');

                    link.closest('.filter-entry').find('.selected-items').empty();
                }

                term_id = term_id.replace(/,\s*$/, "");

                if( filterContainer )
                {
                    // Update data params
                    let params = JSON.parse( filterContainer.dataset.params);
                    params.terms = term_id;
                    params.page = 1;
                    params.search = '';
                    params.posts_selected = posts_selected;
                    filterContainer.dataset.params = JSON.stringify(params);

                    getFilterPosts({
                        'paged'     : 1,
                        'toggle_pg' : 1,
                        'target'    : params.data_target,
                        'type_pg'   : params.type_pg
                    });
                }
            }
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout5 .filter-entry .selected-items small, .ymc-extra-filter .filter-layout5 .filter-entry .selected-items small', function (e) {
            e.preventDefault();

            let _self = $(this);

            let term_id = _self.closest('.item').data('trm');

            let textAll = _self.closest('.filter-entry').data('textAll');

            let filterContainer = this.closest('.ymc-smart-filter-container');

            if ( this.closest('.ymc-extra-filter') ) {
                let extraFilterId   = _self.closest('.ymc-extra-filter').data('extraFilterId');
                filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
            }

            if( filterContainer )
            {
                let params = JSON.parse( filterContainer.dataset.params);
                let arrTerms = params.terms.split(',');
                let newTerms = arrTerms.filter(function(f) { return parseInt(f) !== term_id });
                if( newTerms.length > 0 ) {
                    newTerms = newTerms.join(',');
                }
                else {
                    newTerms = '';
                }

                params.terms = newTerms;
                params.page = 1;
                params.search = '';

                filterContainer.dataset.params = JSON.stringify(params);

                _self.closest('.filter-entry').find('.active').each(function () {

                    if(parseInt($(this).data('termid')) === term_id) {

                        $(this).removeClass('active');

                        if( $(this).closest('.dropdown-filter').find('.menu-passive .active').length === 0) {
                            $(this).closest('.dropdown-filter').find('.menu-active .text-cat').html(textAll);
                            $(this).closest('.dropdown-filter').find('.menu-passive .all').addClass('active');
                        }
                    }
                });

                _self.closest('.item').remove();

                getFilterPosts({
                    'paged'     : 1,
                    'toggle_pg' : 1,
                    'target'    : params.data_target,
                    'type_pg'   : params.type_pg
                });
            }
        });

        // Filter Date
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-date .date-ranges .date-ranges__selected, .ymc-extra-filter .filter-date .date-ranges .date-ranges__selected', function (e) {
            $(this).closest('.date-ranges').toggleClass('open');
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-date .date-ranges .date-ranges__dropdown [data-date], .ymc-extra-filter .filter-date .date-ranges .date-ranges__dropdown [data-date]', function (e) {

            let self = $(this);
            let filterContainer = this.closest('.ymc-smart-filter-container');
            let dateAction = self.data('date');
            let dateSelected = self.closest('.date-ranges').find('.date-ranges__selected');
            let dateRangesCustom = self.closest('.date-ranges').siblings('.date-ranges-custom');

            self.closest('.list-item').addClass('isActive').siblings().removeClass('isActive');

            dateSelected.text(self.text());

            if( dateAction === 'other' ) {
                dateRangesCustom.show();

                $('.datepicker').datepicker({
                    dateFormat: 'M dd, yy',
                    showAnim: 'slideDown',
                    monthNamesShort: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
                    onSelect: function(dateText, inst) {
                        let timestamp = new Date(dateText).getTime() / 1000;
                        let input = inst.input[0];
                        input.dataset.timestamp = timestamp;
                    }
                });
            }
            else {
                dateRangesCustom.hide();
            }

            if ( this.closest('.ymc-extra-filter') ) {
                let extraFilterId   = self.closest('.ymc-extra-filter').data('extraFilterId');
                filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
            }

            if( filterContainer && dateAction !== 'other' )
            {
                // Update data params
                let params = JSON.parse( filterContainer.dataset.params);
                params.filter_date = dateAction;
                params.page = 1;
                params.search = '';
                filterContainer.dataset.params = JSON.stringify(params);

                getFilterPosts({
                    'paged'     : 1,
                    'toggle_pg' : 1,
                    'target'    : params.data_target,
                    'type_pg'   : params.type_pg
                });
            }

        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-date .date-ranges-custom .btn-apply, .ymc-extra-filter .filter-date .date-ranges-custom .btn-apply', function (e) {

            let self = $(this);
            let filterContainer = this.closest('.ymc-smart-filter-container');
            let dateFrom = parseInt( self.closest('.date-ranges-custom__container').find('[name="date_from"]')[0].dataset.timestamp )
            let dateTo   = parseInt( self.closest('.date-ranges-custom__container').find('[name="date_to"]')[0].dataset.timestamp );

            if ( this.closest('.ymc-extra-filter') ) {
                let extraFilterId   = self.closest('.ymc-extra-filter').data('extraFilterId');
                filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
            }

            if ( dateTo >= dateFrom )
            {
                self.closest('.date-ranges-custom').find('.message').empty().hide();
                if( filterContainer )
                {
                    // Update data params
                    let params = JSON.parse( filterContainer.dataset.params);
                    params.filter_date = 'other,'+ dateFrom +','+ dateTo;
                    params.page = 1;
                    params.search = '';
                    filterContainer.dataset.params = JSON.stringify(params);

                    getFilterPosts({
                        'paged'     : 1,
                        'toggle_pg' : 1,
                        'target'    : params.data_target,
                        'type_pg'   : params.type_pg
                    });
                }
            }
            else {
                self.closest('.date-ranges-custom').find('.message').html('The date range is incorrect.').show();
            }
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-date .date-ranges-custom .btn-cancel, .ymc-extra-filter .filter-date .date-ranges-custom .btn-cancel', function (e) {

            let self = $(this);
            let filterContainer = this.closest('.ymc-smart-filter-container');

            if ( this.closest('.ymc-extra-filter') ) {
                let extraFilterId   = self.closest('.ymc-extra-filter').data('extraFilterId');
                filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
            }

            self.closest('.date-ranges-custom').
            find('.message').empty().hide().end().
            hide().
            siblings('.date-ranges').
            removeClass('open').
            find('.date-ranges__dropdown [data-date="all"]').
            trigger('click');
        });

        // Filter Range
        if(document.querySelectorAll('.ymc-smart-filter-container .filter-range, .ymc-extra-filter .filter-range').length > 0) {

            document.querySelectorAll('.ymc-smart-filter-container .filter-range .range-wrapper, .ymc-extra-filter .filter-range .range-wrapper').forEach((range) => {

                let params = range.querySelector('[data-tags]').dataset.tags;
                if( params !== '' )
                {
                    params = JSON.parse(params);

                    let selectedTags = range.querySelector('[data-selected-tags]');
                    let sliderOne = range.querySelector(".slider-1");
                    let sliderTwo = range.querySelector(".slider-2");
                    let displayValOne = range.querySelector(".range1");
                    let displayValTwo = range.querySelector(".range2");
                    let termsArray = [];
                    let sliderTrack = range.querySelector(".slider-track");
                    let length = Object.keys(params).length;
                    let entries = Object.entries(params);
                    let minGap = 0;

                    // Sorting
                    entries.sort((a, b) => {
                        if (!isNaN(Number(a[1])) && !isNaN(Number(b[1]))) {
                            return a[1] - b[1];
                        }
                        else {
                            return a[1].localeCompare(b[1]);
                        }
                    });
                    // Add array
                    for (const [ key, value ] of entries) {
                        termsArray.push([key, value]);
                    }

                    sliderOne.setAttribute('max', length-1);
                    sliderTwo.setAttribute('max', length-1);
                    sliderTwo.setAttribute('value', length-1);
                    displayValOne.textContent = termsArray[0][1];
                    displayValTwo.textContent = termsArray[length-1][1];

                    let sliderMaxValue = sliderOne.max;

                    sliderOne.addEventListener("input", function (e) {

                        if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
                            sliderOne.value = parseInt(sliderTwo.value) - minGap;
                        }

                        sliderOne.style.zIndex = 10;
                        sliderTwo.style.zIndex = 0;

                        displayValOne.textContent = termsArray[sliderOne.value][1];

                        let start = Number(sliderOne.value);
                        let end = Number(sliderTwo.value);

                        selectedTags.dataset.selectedTags = getRangeTerms(start,end,termsArray);

                        fillRangeColor(sliderOne,sliderTwo,sliderMaxValue,sliderTrack);
                    });

                    sliderTwo.addEventListener("input", function (e) {

                        if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
                            sliderTwo.value = parseInt(sliderOne.value) + minGap;
                        }

                        sliderOne.style.zIndex = 0;
                        sliderTwo.style.zIndex = 10;

                        displayValTwo.textContent = termsArray[sliderTwo.value][1];

                        let start = Number(sliderOne.value);
                        let end = Number(sliderTwo.value);

                        selectedTags.dataset.selectedTags = getRangeTerms(start,end,termsArray);

                        fillRangeColor(sliderOne,sliderTwo,sliderMaxValue,sliderTrack);
                    });

                    fillRangeColor(sliderOne,sliderTwo,sliderMaxValue,sliderTrack);
                }

                range.querySelector('.apply-button button').addEventListener('click', function (e) {

                    let tagsSelected = '';
                    let filterContainer = this.closest('.ymc-smart-filter-container');

                    if ( this.closest('.ymc-extra-filter') ) {
                        let extraFilterId = this.closest('.ymc-extra-filter').dataset.extraFilterId;
                        filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
                    }

                    this.closest('.filter-range').querySelectorAll('.range-wrapper .tag-values').forEach((el) => {
                        tagsSelected += el.dataset.selectedTags+',';
                    });

                    tagsSelected = tagsSelected.replace(/,\s*$/,"");

                    if( filterContainer )
                    {
                        let params = JSON.parse( filterContainer.dataset.params);
                        params.terms = tagsSelected;
                        params.page = 1;
                        params.search = '';
                        params.posts_selected = tagsSelected;
                        filterContainer.dataset.params = JSON.stringify(params);

                        getFilterPosts({
                            'paged'      : 1,
                            'toggle_pg'  : 1,
                            'target'     : params.data_target,
                            'type_pg'    : params.type_pg
                        });
                    }


                });
            });
        }

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-range .clear-button, .ymc-extra-filter .filter-range .clear-button', function (e) {

            let filterContainer = this.closest('.ymc-smart-filter-container');
            let tagsArray = [];

            if ( this.closest('.ymc-extra-filter') ) {
                let extraFilterId = this.closest('.ymc-extra-filter').dataset.extraFilterId;
                filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
            }

            document.querySelectorAll('.ymc-smart-filter-container .filter-range .range-wrapper, .ymc-extra-filter .filter-range .range-wrapper').forEach((range) => {

                let params = range.querySelector('[data-tags]').dataset.tags;
                let sliderOne = range.querySelector(".slider-1");
                let sliderTwo = range.querySelector(".slider-2");
                let sliderTrack = range.querySelector(".slider-track");

                if( params !== '' )
                {
                    params = JSON.parse(params);
                    let length = Object.keys(params).length;
                    let entries = Object.entries(params);
                    entries.forEach(([key, value]) => {
                        tagsArray.push(key);
                    });

                    sliderOne.value = 0;
                    sliderTwo.value = length-1;

                    fillRangeColor(sliderOne,sliderTwo,sliderOne.max,sliderTrack);
                }
            });

            if( filterContainer )
            {
                let params = JSON.parse( filterContainer.dataset.params);
                params.terms = tagsArray.join(',');
                params.page = 1;
                params.search = '';
                params.posts_selected = 'all';
                filterContainer.dataset.params = JSON.stringify(params);

                getFilterPosts({
                    'paged'      : 1,
                    'toggle_pg'  : 1,
                    'target'     : params.data_target,
                    'type_pg'    : params.type_pg
                });
            }

        });

        // Filter: Alphabetical Navigation
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .alphabetical-layout .filter-link, .ymc-extra-filter .alphabetical-layout .filter-link', function (e) {
            e.preventDefault();

            let link = $(this);
            let letter = link.data('letter');
            let filterContainer = this.closest('.ymc-smart-filter-container');

            if ( this.closest('.ymc-extra-filter') ) {
                let extraFilterId   = link.closest('.ymc-extra-filter').data('extraFilterId');
                filterContainer = document.querySelector(`.ymc-filter-${extraFilterId}`);
            }

            link.addClass('active').closest('.filter-item').siblings().find('.filter-link').removeClass('active');

            if( filterContainer )
            {
                let params = JSON.parse( filterContainer.dataset.params);

                let dataTarget = params.data_target;
                let typePg = params.type_pg;

                params.page = 1;
                params.search = '';
                params.letter = letter;
                params.posts_selected = letter;
                filterContainer.dataset.params = JSON.stringify(params);

                getFilterPosts({
                    'paged'      : 1,
                    'toggle_pg'  : 1,
                    'target'     : dataTarget,
                    'type_pg'    : typePg
                });
            }

        });

        /*** PAGINATION TYPES ***/

        // Pagination / Type: Default (Numeric)
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .pagination-numeric li a',function (e) {
            e.preventDefault();

            this.closest('.ymc-smart-filter-container').classList.remove('ymc-loaded-filter');
            let paged = parseInt($(this).attr("href").replace(/\D/g, ""));
            paged =  (!isNaN(paged)) ? paged : 1;

            let data_target = JSON.parse(this.closest('.ymc-smart-filter-container').dataset.params).data_target;
            let type_pg = JSON.parse(this.closest('.ymc-smart-filter-container').dataset.params).type_pg;

            getFilterPosts({
                'paged'     : paged,
                'toggle_pg' : 1,
                'target'    : data_target,
                'type_pg'   : type_pg
            });

        });

        // Pagination / Type: Load More
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .pagination-load-more .btn-load',function (e) {
            e.preventDefault();

            let params = JSON.parse(this.closest('.ymc-smart-filter-container').dataset.params);
            params.page++;
            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            let data_target = params.data_target;
            let type_pg     = params.type_pg;
            let paged       = params.page;

            getFilterPosts({
                'paged'      : paged,
                'toggle_pg'  : 0,
                'target'     : data_target,
                'type_pg'    : type_pg
            });

        });


        /*** SEARCH POSTS ***/
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .search-form .btn-submit, .ymc-extra-search .search-form .btn-submit', function (e) {
            e.preventDefault();

            let filterContainer = this.closest('.ymc-smart-filter-container');

            if ( this.closest('.ymc-extra-search') ) {
                let extraSearchId   = $(this).closest('.ymc-extra-search').data('extraSearchId');
                filterContainer = document.querySelector(`.ymc-filter-${extraSearchId}`);
            }

            let phrase = $(this).siblings('.component-input').find('.field-search').val();

            if( phrase.trim() !== '' && filterContainer )
            {
                let filterLayout = $(filterContainer).find('.filter-layout');
                let allTerms = '';

                // Filter Layout 3
                if( filterLayout.hasClass('filter-layout3') ) {
                    allTerms = $(filterContainer).
                    find('.filter-layout .filter-entry').
                    data('terms');
                }
                // Filter Layouts 1, 2, 4
                else {
                    allTerms = $(filterContainer).
                    find('.filter-layout .filter-link.all').
                    data('termid');
                }

                let params = JSON.parse( filterContainer.dataset.params);
                params.search = phrase;

                if( params.search_filtered_posts === '0') {
                    params.terms = allTerms;
                }
                params.letter = '';
                filterContainer.dataset.params = JSON.stringify(params);

                let container =  $('.'+params.data_target+'');

                if( params.search_filtered_posts === '0') {
                    container.find('.filter-layout .filter-link').removeClass('active');
                    container.find('.filter-layout3').find('.selected-items').empty();
                    container.find('.filter-entry .active').each(function () {
                        $(this).removeClass('active');
                    });
                    container.find('.search-form .autocomplete-results').hide();
                }

                getFilterPosts({
                    'paged'      : 1,
                    'toggle_pg'  : 1,
                    'target'     : params.data_target,
                    'type_pg'    : params.type_pg
                });
            }

        });

        /*** Autocomplete Search ***/
        $(document).on('input.ymc_smart_filter keydown.ymc_smart_filter','.ymc-smart-filter-container .search-form .field-search, .ymc-extra-search .search-form .field-search', function (e) {

            let filterContainer = this.closest('.ymc-smart-filter-container');

            if ( this.closest('.ymc-extra-search') ) {
                let extraSearchId   = $(this).closest('.ymc-extra-search').data('extraSearchId');
                filterContainer = document.querySelector(`.ymc-filter-${extraSearchId}`);
            }

            if( filterContainer )
            {
                let _self = $(this);

                let resultsHTML = _self.siblings(".results");

                let userInput = _self.val().trim();

                let params = JSON.parse(filterContainer.dataset.params);

                let termIDs = "";

                resultsHTML.innerHTML = "";

                resultsHTML.next('.clear').show();

                if( params.search_filtered_posts === '1') {

                    let listActiveItems = [];

                    let container = $(filterContainer);

                    let filterLayout = container.find('.filter-layout');

                    if( filterLayout.hasClass('filter-layout1') || filterLayout.hasClass('filter-layout2') ) {
                        listActiveItems = filterLayout.find('.filter-entry .active:not(.all)');
                    }
                    if( filterLayout.hasClass('filter-layout3') ) {
                        listActiveItems = filterLayout.find('.filter-entry .active');
                    }

                    if( listActiveItems.length > 0 ) {

                        listActiveItems.each(function () {
                            termIDs += $(this).data('termid')+',';
                        });

                        termIDs = termIDs.replace(/,\s*$/, "");
                    }
                }

                if ( userInput.length > 2 )
                {
                    if( e.type === 'keydown' && e.key !== undefined && (e.key === "ArrowDown" || e.key === "ArrowUp"))
                    {
                        let isChildElems = [ ...this.nextElementSibling.childNodes ];

                        let isClassSelected = false;

                        let position = 0;

                        isChildElems.forEach((el) => {

                            if(el.classList.contains('selected'))
                            {
                                isClassSelected = true;
                            }
                        });

                        if( !isClassSelected )
                        {
                            isChildElems.forEach((el, n) => {
                                if( n === 0 ) {
                                    el.classList.add('selected');
                                    //_self.val(el.children[0].innerText);
                                }
                            });
                        }

                        if( isClassSelected )
                        {
                            if( e.key === "ArrowDown" )
                            {
                                isChildElems.forEach((el, n) => {

                                    if(el.classList.contains('selected'))
                                    {
                                        position = n;
                                    }
                                });

                                if( position < isChildElems.length )
                                {
                                    if( isChildElems[position+1] !== undefined )
                                    {
                                        isChildElems[position].classList.remove('selected');
                                        isChildElems[position+1].classList.add('selected');
                                        isChildElems[position+1].scrollIntoView({ block: "end" });
                                        //_self.val(isChildElems[position+1].children[0].innerText);
                                    }
                                }
                            }

                            if( e.key === "ArrowUp" )
                            {
                                isChildElems.forEach((el, n) => {

                                    if(el.classList.contains('selected'))
                                    {
                                        position = n;
                                    }
                                });

                                if( position < isChildElems.length )
                                {
                                    if( isChildElems[position-1] !== undefined ) {
                                        isChildElems[position-1].classList.add('selected');
                                        isChildElems[position].classList.remove('selected');
                                        isChildElems[position].scrollIntoView({ block: "end" });
                                        //_self.val(isChildElems[position-1].children[0].innerText);
                                    }
                                }
                            }
                        }
                    }

                    if( e.type === 'input')
                    {
                        const data = {
                            'action'     : 'ymc_autocomplete_search',
                            'nonce_code' : _smart_filter_object.nonce,
                            'phrase'     : userInput,
                            'choices_posts' : params.choices_posts,
                            'exclude_posts' : params.exclude_posts,
                            'post_id' : params.filter_id,
                            'terms_ids' : termIDs
                        };

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: _smart_filter_object.ajax_url,
                            data: data,
                            beforeSend: function () {},
                            success: function (res) {

                                if( res.disableAutocomplete === 0 ) {

                                    resultsHTML.show();

                                    if( res.total > 0 ) {
                                        resultsHTML.html(res.data);
                                    }
                                    else {
                                        resultsHTML.html(`<li class="result no-result">No results for phrase: <b>${userInput}</b></li>`);
                                    }
                                }
                            },
                            error: function (obj, err) {
                                console.log( obj, err );
                            }
                        });
                    }
                }
            }
        });

        /*** Clear Field Search ***/
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .search-form .component-input .clear, .ymc-extra-search .search-form .component-input .clear', function (e) {

            let filterContainer = this.closest('.ymc-smart-filter-container');

            if ( this.closest('.ymc-extra-search') ) {
                let extraSearchId   = $(this).closest('.ymc-extra-search').data('extraSearchId');
                filterContainer = document.querySelector(`.ymc-filter-${extraSearchId}`);
            }

            if( filterContainer )
            {
                let _self = $(e.target).closest('.clear');
                let filterLayout = $(filterContainer).find('.filter-layout');
                let allTerms = "";

                // Filter Layout 3
                if( filterLayout.hasClass('filter-layout3') ) {
                    allTerms = $(filterContainer).
                    find('.filter-layout .filter-entry').
                    data('terms');
                }
                // Filter Layouts 1, 2, 4
                else {
                    allTerms = $(filterContainer).
                    find('.filter-layout .filter-link.all').
                    data('termid');
                }

                _self.siblings('input[name="search"]').val('');
                _self.siblings('.results').empty().hide();
                _self.hide();

                let params = JSON.parse(filterContainer.dataset.params);
                params.search = "";
                params.page = 1;

                if( params.search_filtered_posts === '0') {
                    params.terms = allTerms;
                }

                params.posts_selected = 'all';
                filterContainer.dataset.params = JSON.stringify(params);

                getFilterPosts({
                    'paged'     : 1,
                    'toggle_pg' : 1,
                    'target'    : params.data_target,
                    'type_pg'   : params.type_pg
                });
            }

        });

        /*** Close dropdown filters & autocomplete results outside area ***/
        $('body').on('click.ymc_smart_filter', function (e) {

            if( !e.target.closest('.dropdown-filter') ) {
                $('.dropdown-filter').find('.down').removeClass('open').end().find('.menu-passive').hide();
            }
            if( !e.target.closest('.autocomplete-results') ) {
                $('.ymc-smart-filter-container .search-form .component-input .autocomplete-results').empty().hide();
                $('.ymc-extra-search .search-form .component-input .autocomplete-results').empty().hide();
            }
            if( !e.target.closest('.date-ranges') ) {
                $('.date-ranges').removeClass('open');
            }

        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .search-form .autocomplete-results a[data-clue], .ymc-extra-search .search-form .autocomplete-results a[data-clue]', function (e) {
            e.preventDefault();

            let clue = e.target.closest('a[data-clue]').dataset.clue;
            let inputSearch = e.target.closest('.autocomplete-results').previousElementSibling;
            let btnSearch = inputSearch.closest('.component-input').nextElementSibling;

            inputSearch.value = clue;
            inputSearch.focus();
            e.target.closest('.autocomplete-results').style.display = "none";
            btnSearch.click();

        });


        /*** Sort Posts ***/
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .sort-container .dropdown-filter .menu-active, .ymc-extra-sort .sort-container .dropdown-filter .menu-active', function (e) {
            e.preventDefault();
            let $el = $(this);
            $el.find('.arrow').toggleClass('open').end().next().toggle();
            $el.closest('.dropdown-filter').siblings().find('.menu-passive').hide().end().find('.arrow').removeClass('open');
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .sort-container .dropdown-filter .menu-passive .btn-close, .ymc-extra-sort .sort-container .dropdown-filter .menu-passive .btn-close', function (e) {
            e.preventDefault();
            $(this).closest('.dropdown-filter').find('.down').removeClass('open').end().find('.menu-passive').hide();
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .sort-container .dropdown-filter .menu-passive .menu-link, .ymc-extra-sort .sort-container .dropdown-filter .menu-passive .menu-link', function (e) {
            e.preventDefault();

            let link = $(this);
            let sort_order = this.getAttribute('data-order');
            let sort_orderby = this.getAttribute('data-orderby');

            let filterContainer = this.closest('.ymc-smart-filter-container');

            if ( this.closest('.ymc-extra-sort') ) {
                let extraSortId   = link.closest('.ymc-extra-sort').data('extraSortId');
                filterContainer = document.querySelector(`.ymc-filter-${extraSortId}`);
            }

            link.closest('.dropdown-filter').find('.menu-active .name-sort').html($(this).text());

            if( sort_order === 'desc' ) {
                sort_order = 'asc';
                this.classList.add("asc");
                this.classList.remove("desc");
                link.closest('.dropdown-filter').find('.menu-active .arrow-orderby').addClass('asc').removeClass('desc');
            }
            else {
                sort_order = 'desc';
                this.classList.add("desc");
                this.classList.remove("asc");
                link.closest('.dropdown-filter').find('.menu-active .arrow-orderby').addClass('desc').removeClass('asc');
            }

            link.closest('.menu-passive__item').
            siblings().find('.menu-link').
            removeClass('asc desc');

            this.setAttribute('data-order',sort_order);

            if( filterContainer )
            {
                // Update data params
                let params = JSON.parse( filterContainer.dataset.params);
                //params.terms = term_id;
                params.page = 1;
                params.search = '';
                params.sort_order = sort_order;
                params.sort_orderby = sort_orderby;
                filterContainer.dataset.params = JSON.stringify(params);

                getFilterPosts({
                    'paged'     : 1,
                    'toggle_pg' : 1,
                    'target'    : params.data_target,
                    'type_pg'   : params.type_pg
                });
            }

        });


        /*** Popup ***/
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .post-item .ymc-popup', popupPost);

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .ymc-popup-wrp .btn-close', popupClose);

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .ymc-popup-overlay', function (e) {
            if( !e.target.closest('.ymc-popup-wrp') ) {

                let target = e.target.closest('.ymc-smart-filter-container');
                let params = JSON.parse(target.dataset.params);
                let classAnimation = params.popup_animation;

               $(e.target).css({'display':'none','opacity':'0'});
               $(e.target).find('.ymc-popup-wrp').removeClass(classAnimation);
               $('body, html').css({'overflow' : 'auto'});
            }
        });

    });

}( jQuery ));


