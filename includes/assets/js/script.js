;
(function( $ ) {
    "use strict"

    $(document).on('ready', function () {

        /*** API FILTER ***/
        const _FN = (function () {

            const _info = {
                version: '2.7.2',
                author: 'YMC'
            }

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

            function YMCTools(settings = _defaults) {

                let properties = Object.assign({}, _defaults, settings);

                for (let key in properties) {
                    this[key] = properties[key];
                }
                this.length = Object.keys(properties).length;
            }

            YMCTools.prototype.getInfo = function () {
                return `Author: ${_info.author}. Version: ${_info.version}`;
            }

            // Use fo custom filter layout
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

            // Run filter get posts
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

            //  === API Methods ===

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

            YMCTools.prototype.apiSearchPosts = function ( option = true, terms = [] ) {

                let container = document.querySelector(''+ this.target +'');
                if( ! container )  throw new Error("ApiSearchPosts: Filter not found");
                if( this.search === null || typeof this.terms === 'number')  throw new Error("Search is not defined");

                let dataParams = JSON.parse(container.dataset.params);

                dataParams.page = 1;
                dataParams.search = this.search;
                dataParams.terms = ( Array.isArray(terms) && terms.length > 0 ) ? terms.join(',') : "";
                dataParams.meta_query = "";
                dataParams.date_query = "";

                container.dataset.params = JSON.stringify(dataParams);

                if( typeof option === 'boolean' ) {
                    this.getFilterPosts();
                }
            }

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

            YMCTools.prototype.apiGetPosts = function () {
                this.getFilterPosts();
            }

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

            return function (settings) {
                return  new YMCTools(settings);
            }

        }());

        ( typeof window.YMCTools === 'undefined' ) ? window.YMCTools = _FN : console.error('YMCTools is existed');

        // Path preloader image
        const pathPreloader = _smart_filter_object.path+"/includes/assets/images/preloader.svg";

        // Options IntersectionObserver
        const optionsInfinityScroll = {
            root: null,
            rootMargin: '0px',
            threshold: 0.8
        }

        // Object Observer
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

        // Set Preloader
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

        // Masonry Layouts
        function masonryGrid( el, f, c ) {

            if( el.classList.contains("ymc-post-masonry") || el.classList.contains("ymc-post-custom-masonry") ) {

                wp.hooks.addAction('ymc_after_loaded_data_'+f+'_'+c, 'smartfilter', function(class_name, response){

                    let magicGrid = new MagicGrid({
                        container: `.${class_name} .post-entry`,
                        items: response.post_count,
                        gutter: 15
                    });
                    magicGrid.listen();
                    magicGrid.positionItems();
                });
            }
        }

        // Popup
        function popupPost(e) {
            e.preventDefault();
            let _self = $(e.target);
            let postId = _self.data('postid');
            let popupOverlay = _self.closest('.ymc-smart-filter-container').find('.ymc-popup-overlay');
            let popupContainer = _self.closest('.ymc-smart-filter-container').find('.popup-entry');
            let bodyHtml = $('body, html');
            let postContainer = _self.closest('.post-item');
            let target = e.target.closest('.ymc-smart-filter-container');
            let params = JSON.parse(target.dataset.params);
            let stylePreloader = _smart_filter_object.path+"/includes/assets/images/"+ params.preloader_icon +".svg";
            let preloaderFilter = filterPreloader( params );
            let classAnimation = params.popup_animation;

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
                    wp.hooks.doAction('ymc_after_popup_open_'+params.filter_id+'_'+params.target_id, res.data);
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        }

        // Close popup
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

        // Popup API
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


        // Main Request
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

            const data = {
                'action'     : 'ymc_get_posts',
                'nonce_code' : _smart_filter_object.nonce,
                'params'     : JSON.stringify(params),
                'paged'      : paged
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {

                    // Load-more && Scroll-infinity
                    if(toggle_pg === 0) {
                        container.find('.container-posts').addClass('loading').find('.post-entry').
                        append(`<img class="preloader preloader--load" src="${stylePreloader}" style="${preloaderFilter}">`);
                    }
                    else {
                        container.find('.container-posts').addClass('loading').
                        prepend(`<img class="preloader preloader--numeric" src="${stylePreloader}" style="${preloaderFilter}">`);
                    }

                    // Add Hook: before loaded posts
                    wp.hooks.doAction('ymc_before_loaded_data_'+filterID+'_'+targetID, target);
                },
                success: function (res) {

                    if( params.posts_selected !== 'all' || params.search !== '' ) {
                        container.find('.filter-layout .posts-found').html(`<span>${res.posts_selected}</span>`);
                    }
                    else {
                        container.find('.filter-layout .posts-found').empty();
                    }

                    switch ( type_pg ) {

                        case 'numeric' :

                            // Filter is act scroll top
                            if( !container.hasClass('ymc-loaded-filter') ) {
                                if( toggle_pg === 1 && parseInt(pageScroll) === 1 ) {
                                    $('html, body').animate({scrollTop: container.offset().top - 100}, 500);
                                }
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
                                // Filter is act scroll top
                                //$('html, body').animate({scrollTop: container.offset().top}, 300);

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

                            if(res.get_current_posts > 0) {
                                postsObserver.observe(document.querySelector('.'+target+' .post-entry .post-item:last-child'));
                            }

                            break;
                    }

                    // Updated attr data-loading
                    document.querySelector('.'+target).dataset.loading = 'true';

                    // Add Hook: after loaded posts
                    wp.hooks.doAction('ymc_after_loaded_data_'+filterID+'_'+targetID, target, res);

                },
                complete: function (XHR, status) {
                    // Add Hook: called regardless of if the request was successful, or not
                    wp.hooks.doAction('ymc_complete_loaded_data_'+filterID+'_'+targetID, target, status);
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        }

        // Init Loading Posts
        document.querySelectorAll('.ymc-smart-filter-container').forEach(function (el) {

            // Add Hook: stop loading posts on page load
            wp.hooks.doAction('ymc_stop_loading_data', el);

            let loadingPosts   = el.dataset.loading;
            let params      = JSON.parse(el.dataset.params);
            let data_target = params.data_target;
            let type_pg     = params.type_pg;
            let filter_id = params.filter_id;
            let target_id = params.target_id;

            if( loadingPosts === 'true' ) {
                // Init Load Posts
                getFilterPosts({
                    'paged'     : 1,
                    'toggle_pg' : 1,
                    'target'    : data_target,
                    'type_pg'   : type_pg
                });
                // Run Masonry Grid
                masonryGrid(el, filter_id, target_id);
            }
        });


        /*** FILTERS LAYOUTS ***/

        // Filter Posts / Layout1 / Simple Posts Filter
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout1 .filter-link',function (e) {
            e.preventDefault();

            let link = $(this);
            let term_id = link.data('termid');
            let posts_selected = link.data('selected');

            if(link.hasClass('multiple')) {
                link.toggleClass('active').closest('.filter-item').siblings().find('.all').removeClass('active');
            }
            else {
                link.addClass('active').
                closest('.filter-item').
                siblings().
                find('.filter-link').
                removeClass('active').
                closest('.filter-entry').
                find('.all').
                removeClass('active');
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

            let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
            params.terms = term_id;
            params.page = 1;
            params.search = '';
            params.posts_selected = posts_selected;

            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'      : 1,
                'toggle_pg'  : 1,
                'target'     : params.data_target,
                'type_pg'    : params.type_pg
            });
        });

        // Filter Posts / Layout2 / Taxonomy Filter
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout2 .filter-link',function (e) {
            e.preventDefault();

            let link = $(this);
            let term_id = link.data('termid');
            let posts_selected = link.data('selected');

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

            let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
            params.terms = term_id;
            params.page = 1;
            params.search = '';
            params.posts_selected = posts_selected;

            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'     : 1,
                'toggle_pg' : 1,
                'target'    : params.data_target,
                'type_pg'   : params.type_pg
            });
        });

        // Filter Post / Layout3 (Dropdown) / Dropdown Filter
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .dropdown-filter .menu-active',function (e) {
            e.preventDefault();
            let $el = $(this);
            $el.find('.arrow').toggleClass('open').end().next().toggle();
            $el.closest('.dropdown-filter').siblings().find('.menu-passive').hide().end().find('.arrow').removeClass('open');
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .dropdown-filter .menu-passive .btn-close',function (e) {
            e.preventDefault();
            $(this).closest('.dropdown-filter').find('.down').removeClass('open').end().find('.menu-passive').hide();
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .dropdown-filter .menu-passive .menu-link',function (e) {
            e.preventDefault();
            let link = $(this);
            let term_id = '';
            let posts_selected = link.data('selected');

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

            // Update data params
            let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
            params.terms = term_id;
            params.page = 1;
            params.search = '';
            params.posts_selected = posts_selected;

            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'     : 1,
                'toggle_pg' : 1,
                'target'    : params.data_target,
                'type_pg'   : params.type_pg
            });
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .filter-entry .selected-items small',function (e) {
            e.preventDefault();

            let _self = $(this);

            let term_id = _self.closest('.item').data('trm');

            let isItems = _self.closest('.selected-items').find('.item').length - 1;

            //let term_sel = (isItems > 0 ) ? isItems : 'all';

            let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
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

            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

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

        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout3 .filter-entry .btn-all',function (e) {
            e.preventDefault();

            let _self = $(this);
            let terms = _self.data('terms');
            let posts_selected = _self.data('selected');

            let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
            params.terms = terms;
            params.page = 1;
            params.search = '';
            params.posts_selected = posts_selected;

            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            _self.siblings('.selected-items').empty();
            _self.siblings('.dropdown-filter').find('.active').removeClass('active');
            _self.siblings('.dropdown-filter').find('.menu-passive').hide();

            getFilterPosts({
                'paged'     : 1,
                'toggle_pg' : 1,
                'target'    : params.data_target,
                'type_pg'   : params.type_pg
            });
        });

        // Filter Posts / Layout4 / Sidebar Filter
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout4 .name-tax',function (e) {
            let _self = $(this);
            _self.toggleClass('open').next().slideToggle(300);
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .filter-layout4 .filter-link',function (e) {
            e.preventDefault();

            let link = $(this);
            let term_id = link.data('termid');
            let posts_selected = link.data('selected');

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

            let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
            params.terms = term_id;
            params.page = 1;
            params.search = '';
            params.posts_selected = posts_selected;

            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'     : 1,
                'toggle_pg' : 1,
                'target'    : params.data_target,
                'type_pg'   : params.type_pg
            });
        });


        // Filter: Alphabetical Navigation
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .alphabetical-layout .filter-link',function (e) {
            e.preventDefault();

            let link = $(this);
            let letter = link.data('letter');

            link.addClass('active').closest('.filter-item').siblings().find('.filter-link').removeClass('active');

            let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);

            let dataTarget = params.data_target;
            let typePg = params.type_pg;

            params.page = 1;
            params.search = '';
            params.letter = letter;
            params.posts_selected = letter;

            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'      : 1,
                'toggle_pg'  : 1,
                'target'     : dataTarget,
                'type_pg'    : typePg
            });
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
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .search-form .btn-submit',function (e) {
            e.preventDefault();

            let phrase = $(this).siblings('.component-input').find('.field-search').val();

            if( phrase.trim() !== '' ) {

                let filterLayout = $(this).closest('.ymc-smart-filter-container').find('.filter-layout');
                let allTerms = '';

                // Filter Layout 3
                if( filterLayout.hasClass('filter-layout3') ) {
                    allTerms = $(this).
                    closest('.ymc-smart-filter-container').
                    find('.filter-layout .filter-entry').
                    data('terms');
                }
                // Filter Layouts 1, 2
                else {
                    allTerms = $(this).
                    closest('.ymc-smart-filter-container').
                    find('.filter-layout .filter-link.all').
                    data('termid');
                }

                let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
                params.search = phrase;

                if( params.search_filtered_posts === '0') {
                    params.terms = allTerms;
                }
                params.letter = '';
                this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

                let container =  $('.'+params.data_target+'');
                container.find('.filter-layout .filter-link').removeClass('active');

                container.find('.filter-layout3').find('.selected-items').empty();
                container.find('.filter-entry .active').each(function () {
                    $(this).removeClass('active');
                });
                container.find('.search-form .autocomplete-results').hide();

                getFilterPosts({
                    'paged'      : 1,
                    'toggle_pg'  : 1,
                    'target'     : params.data_target,
                    'type_pg'    : params.type_pg
                });
            }
        });

        /*** Autocomplete Search ***/
        $(document).on('input.ymc_smart_filter keydown.ymc_smart_filter','.ymc-smart-filter-container .search-form .field-search',function (e) {

            let _self = $(this);

            let resultsHTML = _self.siblings(".results");

            let userInput = _self.val().trim();

            let params = JSON.parse(this.closest('.ymc-smart-filter-container').dataset.params);

            let termIDs = "";

            resultsHTML.innerHTML = "";

            resultsHTML.next('.clear').show();

            if( params.search_filtered_posts === '1') {

                let listActiveItems = [];

                let container = $(e.target).closest('.ymc-smart-filter-container');

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
                                _self.val(el.children[0].innerText);
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
                                    _self.val(isChildElems[position+1].children[0].innerText);
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
                                    _self.val(isChildElems[position-1].children[0].innerText);
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
        });

        /*** Clear Field Search ***/
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .search-form .component-input .clear',function (e) {

            let _self = $(e.target).closest('.clear');
            let filterLayout = $(this).closest('.ymc-smart-filter-container').find('.filter-layout');
            let allTerms = "";

            // Filter Layout 3
            if( filterLayout.hasClass('filter-layout3') ) {
                allTerms = $(this).
                closest('.ymc-smart-filter-container').
                find('.filter-layout .filter-entry').
                data('terms');
            }
            // Filter Layouts 1, 2
            else {
                allTerms = $(this).
                closest('.ymc-smart-filter-container').
                find('.filter-layout .filter-link.all').
                data('termid');
            }

            _self.siblings('input[name="search"]').val('');
            _self.siblings('.results').empty().hide();
           _self.hide();

            let params = JSON.parse(e.target.closest('.ymc-smart-filter-container').dataset.params);
            params.search = "";
            params.page = 1;
            params.terms = allTerms;
            params.posts_selected = 'all';
            e.target.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'     : 1,
                'toggle_pg' : 1,
                'target'    : params.data_target,
                'type_pg'   : params.type_pg
            });
        });

        /*** Close dropdown filters & autocomplete results outside area ***/
        $('body').on('click.ymc_smart_filter', function (e) {
            if( !e.target.closest('.dropdown-filter') ) {
                $('.dropdown-filter').find('.down').removeClass('open').end().find('.menu-passive').hide();
            }
            if( !e.target.closest('.autocomplete-results') ) {
                $('.ymc-smart-filter-container .search-form .component-input .autocomplete-results').
                empty().hide();
            }
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .search-form .autocomplete-results a[data-clue]', function (e) {
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
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .sort-container .dropdown-filter .menu-active',function (e) {
            e.preventDefault();
            let $el = $(this);
            $el.find('.arrow').toggleClass('open').end().next().toggle();
            $el.closest('.dropdown-filter').siblings().find('.menu-passive').hide().end().find('.arrow').removeClass('open');
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .sort-container .dropdown-filter .menu-passive .btn-close',function (e) {
            e.preventDefault();
            $(this).closest('.dropdown-filter').find('.down').removeClass('open').end().find('.menu-passive').hide();
        });

        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .sort-container .dropdown-filter .menu-passive .menu-link',function (e) {
            e.preventDefault();

            let link = $(this);
            let sort_order = this.getAttribute('data-order');
            let sort_orderby = this.getAttribute('data-orderby');

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

            // Update data params
            let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
            //params.terms = term_id;
            params.page = 1;
            params.search = '';
            params.sort_order = sort_order;
            params.sort_orderby = sort_orderby;
            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'     : 1,
                'toggle_pg' : 1,
                'target'    : params.data_target,
                'type_pg'   : params.type_pg
            });

        });


        /*** Popup ***/
        $(document).on('click.ymc_smart_filter','.ymc-smart-filter-container .container-posts .post-entry .post-item .ymc-popup', popupPost);

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


