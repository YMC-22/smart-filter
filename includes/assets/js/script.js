;
(function( $ ) {
    "use strict"

    $(document).on('ready', function () {

        // Path preloader image
        const pathPreloader = _smart_filter_object.path+"/includes/assets/images/preloader.svg";

        // Options IntersectionObserver
        const optionsInfinityScroll = {
            root: null,
            rootMargin: '0px',
            threshold: 0.7
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


        // Main Request
        function getFilterPosts( options ) {

            let paged     = options.paged;
            let toggle_pg = options.toggle_pg; // if 1 use func: html() or 0 append(): use load-more && scroll-infinity
            let target    = options.target;
            let type_pg   = options.type_pg;  // pagination type

            let container = $("."+target+"");
            let params = JSON.parse(document.querySelector('.'+target+'').dataset.params);

            let filterID = params.filter_id;
            let targetID = params.target_id;

            const data = {
                'action'     : 'ymc_get_posts',
                'nonce_code' : _smart_filter_object.nonce,
                'params'     : JSON.stringify(params),
                'paged'      : paged,
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    container.find('.container-posts').addClass('loading').
                    prepend(`<img class="preloader" src="${pathPreloader}">`);

                    // Add Hook: before loaded posts
                    wp.hooks.doAction('ymc_before_loaded_data_'+filterID+'_'+targetID, target);
                },
                success: function (res) {

                    if(params.post_sel !== 'all') {
                        container.find('.filter-layout .posts-found').html(`<span>${res.posts_selected}</span>`);
                    }
                    else {
                        container.find('.filter-layout .posts-found').empty();
                    }

                    switch ( type_pg ) {

                        case 'numeric' :

                            // Filter is act scroll top
                            if(!container.hasClass('ymc-loaded-filter') ) {
                                if(toggle_pg === 1) {
                                    $('html, body').animate({scrollTop: container.offset().top - 100}, 500);
                                }
                            }


                            container.find('.container-posts').
                            removeClass('loading').
                            find('.preloader').remove().end().
                            find('.post-entry').html(res.data).end().
                            find('.ymc-pagination').remove().end().
                            append(res.pagin);

                            break;

                        case 'load-more' :

                            if(toggle_pg === 0) {
                                container.find('.container-posts').
                                removeClass('loading').
                                find('.preloader').remove().end().
                                find('.post-entry').append(res.data).end().
                                find('.ymc-pagination').remove().end().
                                append(res.pagin);
                            }
                            else  {
                                container.find('.container-posts').
                                removeClass('loading').
                                find('.preloader').remove().end().
                                find('.post-entry').html(res.data).end().
                                find('.ymc-pagination').remove().end().
                                append(res.pagin);
                            }

                            if(res.get_current_posts <= 0) {
                                container. find('.pagination-load-more').remove();
                            }

                            break;

                        case 'scroll-infinity' :

                            if(toggle_pg === 0) {
                                container.find('.container-posts').
                                removeClass('loading').
                                find('.preloader').remove().end().
                                find('.post-entry').append(res.data).end().
                                append(res.pagin);
                            }
                            else  {
                                // Filter is act scroll top
                                //$('html, body').animate({scrollTop: container.offset().top}, 300);

                                container.find('.container-posts').
                                removeClass('loading').
                                find('.preloader').remove().end().
                                find('.post-entry').html(res.data).end().
                                append(res.pagin);
                            }

                            if(res.get_current_posts > 0) {
                                postsObserver.observe(document.querySelector('.'+target+' .post-entry .post-item:last-child'));
                            }

                            break;
                    }

                    // updated attr data-loading
                    document.querySelector('.'+target).dataset.loading = 'true';

                    // Add Hook: after loaded posts
                    wp.hooks.doAction('ymc_after_loaded_data_'+filterID+'_'+targetID, target);

                },
                complete: function (XHR, status){
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

            if( loadingPosts === 'true' ) {
                // Init Load Posts
                getFilterPosts({
                    'paged'     : 1,
                    'toggle_pg' : 1,
                    'target'    : data_target,
                    'type_pg'   : type_pg
                });
            }
        });


        /*** FILTERS LAYOUTS ***/

        // Filter Posts / Layout1 / Simple Posts Filter
        $(document).on('click','.ymc-smart-filter-container .filter-layout1 .filter-link',function (e) {
            e.preventDefault();

            let link = $(this);
            let term_id = link.data('termid');
            let term_sel = link.data('selected');

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
            params.post_sel = term_sel;
            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'      : 1,
                'toggle_pg'  : 1,
                'target'     : params.data_target,
                'type_pg'    : params.type_pg
            });
        });

        // Filter Posts / Layout2 / Taxonomy Filter
        $(document).on('click','.ymc-smart-filter-container .filter-layout2 .filter-link',function (e) {
            e.preventDefault();

            let link = $(this);
            let term_id = link.data('termid');
            let term_sel = link.data('selected');

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
            params.post_sel = term_sel;
            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'     : 1,
                'toggle_pg' : 1,
                'target'    : params.data_target,
                'type_pg'   : params.type_pg
            });
        });

        // Filter Post / Layout3 (Dropdown) / Dropdown Filter
        $(document).on('click','.ymc-smart-filter-container .filter-layout3 .dropdown-filter .menu-active',function (e) {
            e.preventDefault();
            let $el = $(this);
            $el.find('.arrow').toggleClass('open').end().next().toggle();
            $el.closest('.dropdown-filter').siblings().find('.menu-passive').hide().end().find('.arrow').removeClass('open');
        });

        $(document).on('click','.ymc-smart-filter-container .filter-layout3 .dropdown-filter .menu-passive .btn-close',function (e) {
            e.preventDefault();
            $(this).closest('.dropdown-filter').find('.down').removeClass('open').end().find('.menu-passive').hide();
        });

        $(document).on('click','.ymc-smart-filter-container .filter-layout3 .dropdown-filter .menu-passive .menu-link',function (e) {
            e.preventDefault();
            let link = $(this);
            let term_id = '';
            let term_sel = link.data('selected');

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
            params.post_sel = term_sel;
            this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

            getFilterPosts({
                'paged'     : 1,
                'toggle_pg' : 1,
                'target'    : params.data_target,
                'type_pg'   : params.type_pg
            });
        });

        $(document).on('click','.ymc-smart-filter-container .filter-layout3 .filter-entry .selected-items small',function (e) {
            e.preventDefault();

            let _self = $(this);

            let term_id = _self.closest('.item').data('trm');

            let isItems = _self.closest('.selected-items').find('.item').length - 1;

            let term_sel = (isItems > 0 ) ? isItems : 'all';

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
            params.post_sel = term_sel;
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

        $(document).on('click','.ymc-smart-filter-container .filter-layout3 .filter-entry .btn-all',function (e) {
            e.preventDefault();

            let _self = $(this);
            let terms = _self.data('terms');
            let term_sel = _self.data('selected');

            let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
            params.terms = terms;
            params.page = 1;
            params.search = '';
            params.post_sel = term_sel;
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

        /*** PAGINATION TYPES ***/

        // Pagination / Type: Default (Numeric)
        $(document).on('click','.ymc-smart-filter-container .pagination-numeric li a',function (e) {
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
        $(document).on('click','.ymc-smart-filter-container .pagination-load-more .btn-load',function (e) {
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
        $(document).on('click','.ymc-smart-filter-container .search-form .btn-submit',function (e) {
            e.preventDefault();

            let phrase = $(this).siblings('.component-input').find('.field-search').val();

            if( phrase.trim() !== '' ) {

                let allTerms = $(this).
                    closest('.ymc-smart-filter-container').
                    find('.filter-layout .filter-link.all').
                    data('termid');


                let params = JSON.parse( this.closest('.ymc-smart-filter-container').dataset.params);
                params.search = phrase;
                params.terms = allTerms;
                params.post_sel = 'all';
                this.closest('.ymc-smart-filter-container').dataset.params = JSON.stringify(params);

                let container =  $('.'+params.data_target+'');
                container.find('.filter-layout .filter-link').removeClass('active');

                container.find('.filter-layout3').find('.selected-items').empty();
                container.find('.filter-entry .active').each(function () {
                    $(this).removeClass('active');
                });

                getFilterPosts({
                    'paged'      : 1,
                    'toggle_pg'  : 1,
                    'target'     : params.data_target,
                    'type_pg'    : params.type_pg
                });
            }
        });

        /*** Autocomplete Search ***/
        $(document).on('input','.ymc-smart-filter-container .search-form .field-search',function (e) {

            let _self = $(this);

            let resultsHTML = _self.siblings("#results");

            let userInput = _self.val().trim();

            resultsHTML.innerHTML = "";

            resultsHTML.next('.clear').show();

            resultsHTML.next('.clear').on('click', function (e) {
                _self.val('');
                $(this).hide().prev('#results').empty().hide();
            });

            if (userInput.length > 2) {

                let params = JSON.parse(this.closest('.ymc-smart-filter-container').dataset.params);

                const data = {
                    'action'     : 'ymc_autocomplete_search',
                    'nonce_code' : _smart_filter_object.nonce,
                    'cpt'        : params.cpt,
                    'phrase'     : userInput
                };

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: _smart_filter_object.ajax_url,
                    data: data,
                    beforeSend: function () {},
                    success: function (res) {
                         resultsHTML.show();

                         if(res.total > 0) {
                             resultsHTML.html(res.data);
                         }
                         else {
                             resultsHTML.html(`<li class="no-result">No results for phrase: <b>${userInput}</b></li>`);
                         }

                    },
                    error: function (obj, err) {
                        console.log( obj, err );
                    }
                });
            }
        });

        // Sort Posts on Frontend
        $(document).on('click','.ymc-smart-filter-container .sort-container .dropdown-filter .menu-active',function (e) {
            e.preventDefault();
            let $el = $(this);
            $el.find('.arrow').toggleClass('open').end().next().toggle();
            $el.closest('.dropdown-filter').siblings().find('.menu-passive').hide().end().find('.arrow').removeClass('open');
        });

        $(document).on('click','.ymc-smart-filter-container .sort-container .dropdown-filter .menu-passive .btn-close',function (e) {
            e.preventDefault();
            $(this).closest('.dropdown-filter').find('.down').removeClass('open').end().find('.menu-passive').hide();
        });

        $(document).on('click','.ymc-smart-filter-container .sort-container .dropdown-filter .menu-passive .menu-link',function (e) {
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


        /*** API FILTER ***/
        const _FN = (function () {

            const _info = {
                version: '2.1.0',
                author: 'YMC'
            }

            const _defaults = {
                target : '.data-target-ymc1',
                self   : null,
                terms  : null,
                taxRel : null,
                meta   : null,
                date   : null
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
                let termSelected = link.data('selected');

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
                dataParams.post_sel = termSelected;

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

            //  === API ===
            YMCTools.prototype.apiTermUpdate = function () {

                let container = document.querySelector(''+ this.target +'');
                if( ! container )  throw new Error("API Term: Filter not found");
                if( this.terms === null || typeof this.terms === 'number')  throw new Error("Terms is not defined");

                let dataParams = JSON.parse(container.dataset.params);

                dataParams.page = 1;
                dataParams.search = '';
                dataParams.terms = this.terms.replace(/<[^>]+>/g, '');
                dataParams.post_sel = this.taxRel;

                container.dataset.params = JSON.stringify(dataParams);
                this.getFilterPosts();
            }

            YMCTools.prototype.apiMetaUpdate = function () {

                let container = document.querySelector(''+ this.target +'');
                if( ! container )  throw new Error("API Meta: Filter not found");

                let dataParams = JSON.parse(container.dataset.params);

                dataParams.page = 1;
                dataParams.search = '';
                dataParams.meta_query = ( this.meta !== null ) ? this.meta : '';

                container.dataset.params = JSON.stringify(dataParams);
                this.getFilterPosts();
            }

            YMCTools.prototype.apiDateUpdate = function () {

                let container = document.querySelector(''+ this.target +'');
                if( ! container )  throw new Error("API Date: Filter not found");

                let dataParams = JSON.parse(container.dataset.params);

                dataParams.page = 1;
                dataParams.search = '';
                dataParams.date_query = ( this.date !== null ) ? this.date : '';

                container.dataset.params = JSON.stringify(dataParams);
                this.getFilterPosts();
            }

            YMCTools.prototype.apiTermClear = function () {

                let container = document.querySelector(''+ this.target +'');
                if( ! container )  throw new Error("API TermReset: Filter not found");

                let dataParams = JSON.parse(container.dataset.params);
                dataParams.terms = "";
                container.dataset.params = JSON.stringify(dataParams);

                this.getFilterPosts();
            }

            YMCTools.prototype.apiMetaClear = function () {

                let container = document.querySelector(''+ this.target +'');
                if( ! container )  throw new Error("API MetaReset: Filter not found");

                let dataParams = JSON.parse(container.dataset.params);
                dataParams.meta_query = "";
                container.dataset.params = JSON.stringify(dataParams);

                this.getFilterPosts();
            }

            YMCTools.prototype.apiDateClear = function () {

                let container = document.querySelector(''+ this.target +'');
                if( ! container )  throw new Error("API Date: Filter not found");

                let dataParams = JSON.parse(container.dataset.params);
                dataParams.date_query = "";
                container.dataset.params = JSON.stringify(dataParams);

                this.getFilterPosts();
            }


            return function (settings) {
                return  new YMCTools(settings);
            }

        }());

        ( typeof window.YMCTools === 'undefined' ) ? window.YMCTools = _FN : console.error('YMCTools is existed');

    });

}( jQuery ));