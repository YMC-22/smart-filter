;
(function( $ ) {
    "use strict"

    $(document).on('ready', function () {

        /**
         * The path to the preloader image
         * @type {string}
         */
        const pathPreloader = _smart_filter_object.path+"/includes/assets/images/preloader.svg";

        /**
         * The tab container
         * @type {*|jQuery|HTMLElement}
         */
        const container = $('.ymc__container-settings .tab-panel');

        /**
         * Set a cookie with the given name, value, and expiration days.
         * @param {string} cname - The name of the cookie
         * @param {string} cvalue - The value of the cookie
         * @param {number} exdays - The number of days until the cookie expires
         */
        function setCookie(cname, cvalue, exdays) {
            let d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        /**
         * Function to get the value of a specific cookie by name
         * @param {string} cname - The name of the cookie to retrieve
         * @returns {string} The value of the cookie if found, otherwise an empty string
         */
        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) === 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        /**
         * Updates the sorting of terms.
         */
        function updateSortTerms() {
            let arrTerms = [];
            document.querySelectorAll('#ymc-terms .item-inner:not(.all-categories)').forEach((el) => {
                arrTerms.push( $(el).find('input[type="checkbox"]').val() );
            });

            let data = {
                'action': 'ymc_term_sort',
                'nonce_code' : _smart_filter_object.nonce,
                'term_sort' : JSON.stringify(arrTerms),
                'post_id' : document.querySelector('#ymc-terms').dataset.postid
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                success: function (res) {},
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        }

        /**
         * Sorts the taxonomy elements by allowing drag and drop functionality.
         */
        function sortTaxonomy() {
            let taxListElement = document.querySelector('#ymc-tax-checkboxes');
            $("#ymc-tax-checkboxes").sortable({
                axis: 'X',
                cursor: "move",
                handle: '.handle',
                opacity: 0.8,
                //revert: 150,
                scroll: false,
                containment: "parent",
                start: function( event, ui ) {
                    taxListElement.classList.add('dragging');
                },
                stop: function( event, ui ) {
                    taxListElement.classList.remove('dragging');
                    let arrTax = [];
                    taxListElement.querySelectorAll('.group-elements').forEach((el) => {
                        arrTax.push(el.id);
                    });
                    let data = {
                        'action': 'ymc_tax_sort',
                        'nonce_code' : _smart_filter_object.nonce,
                        'tax_sort' : JSON.stringify(arrTax),
                        'post_id' : taxListElement.dataset.postid
                    };
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: _smart_filter_object.ajax_url,
                        data: data,
                        success: function (res) {},
                        error: function (obj, err) {
                            console.log( obj, err );
                        }
                    });
                }
            });
        }

        /**
         * Makes the terms sortable using drag and drop functionality.
         */
        function sortTerms() {
            $("#ymc-terms .entry-terms").sortable({
                axis: 'y',
                cursor: "move",
                opacity: 0.8,
                //revert: 150,
                handle: '.handle',
                containment: "parent",
                start: function( event, ui ) {
                    ui.item[0].closest('.entry-terms').classList.add('dragging');
                },
                stop: function( event, ui ) {
                    ui.item[0].closest('.entry-terms').classList.remove('dragging');
                    updateSortTerms();
                }
            });
        }

        /**
         * Sorts the nested terms within the entry-terms using drag and drop functionality.
         */
        function sortNestedTerms() {

            $("#ymc-terms .entry-terms .sub_item").sortable({
                axis: 'y',
                cursor: "move",
                opacity: 0.8,
                //revert: true,
                handle: '.handle_nested',
                containment: "parent",
                start: function( event, ui ) {
                    ui.item[0].closest('.sub_item').classList.add('dragging');
                },
                stop: function( event, ui ) {
                    ui.item[0].closest('.sub_item').classList.remove('dragging');
                    updateSortTerms();
                }
            });
        }

        /**
         * Makes the selected posts sortable via drag and drop.
         */
        function sortSelectedPosts() {
            $("#selection-posts .include-posts").sortable({
                axis: 'y',
                cursor: "move",
                revert: 150,
                containment: "parent",
                start: function( event, ui ) {
                    console.log(ui.item[0]);
                    ui.item[0].closest('.include-posts').classList.add('dragging');
                },
                stop: function( event, ui ) {
                    ui.item[0].closest('.include-posts').classList.remove('dragging');
                }
            });
        }

        /**
         * Updates options icons based on user interaction.
         * @param {Event} e - The event triggering the icon update.
         */
        function updatedOptionsIcons(e) {

            let arrOptionsIcons = [];

            // If click on button Align (popup)
            if( e ) {
                let termAlign = $(e.target).closest('.toggle-align-icon').data('align');
                $(e.target).closest('.toggle-align-icon').addClass('selected').siblings().removeClass('selected');
                document.querySelector('#ymc-terms .entry-terms .open-popup').dataset.alignterm = termAlign;
            }

            document.querySelectorAll('#ymc-terms .entry-terms .item-inner').forEach((el) => {
                let termId = el.dataset.termid;
                let termAlign = el.dataset.alignterm;
                let colorIcon =  el.dataset.colorIcon;
                let classIcon = el.dataset.classIcon;
                arrOptionsIcons.push({
                    "termid" : termId,
                    "alignterm" : termAlign,
                    "coloricon" : colorIcon,
                    "classicon" : classIcon
                });
            });

            const data = {
                'action' : 'ymc_options_icons',
                'nonce_code' : _smart_filter_object.nonce,
                'post_id' : $('#ymc-cpt-select').data('postid'),
                'params'  : JSON.stringify(arrOptionsIcons)
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    container.addClass('loading').
                    prepend(`<img class="preloader" src="${pathPreloader}">`);
                },
                success: function (res) {

                    container.removeClass('loading').find('.preloader').remove();

                    // If click on button Align (popup)
                    if( e ) {
                        $(e.target).closest('.toggle-align-icon').find('.note').css({'opacity':'1'});
                        setTimeout(() => {
                            $(e.target).closest('.toggle-align-icon').find('.note').css({'opacity':'0'});
                        },1000);
                    }
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        }

        /**
         * Update options for terms
         */
        function updatedOptionsTerms() {

            let optionsTerms = [];

            document.querySelectorAll('#ymc-terms .entry-terms .item-inner').forEach((el) => {
                optionsTerms.push({
                    "termid"  : el.dataset.termid,
                    "bg"      : el.dataset.bgTerm,
                    "color"   : el.dataset.colorTerm,
                    "class"   : el.dataset.customClass,
                    "status"  : el.dataset.statusTerm,
                    "default" : el.dataset.defaultTerm,
                    "name"    : el.dataset.nameTerm,
                    "hide"    : el.dataset.hideTerm
                });
            });

            const data = {
                'action' : 'ymc_options_terms',
                'nonce_code' : _smart_filter_object.nonce,
                'post_id' : $('#ymc-cpt-select').data('postid'),
                'params'  : JSON.stringify(optionsTerms)
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    $('#TB_window').addClass('loading').
                    prepend(`<img class="preloader" src="${pathPreloader}">`);
                },
                success: function (res) {
                    $('#TB_window').removeClass('loading').find('.preloader').remove();

                    $('#ymc-terms .entry-terms .open-popup').removeClass('open-popup');

                    tb_remove();
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });

        }

        /**
         * Update options taxonomies based on the elements with class 'all-categories' under the '#ymc-terms' element
         */
        function updatedOptionsTaxonomies() {

            let optionsTaxonomies = [];

            document.querySelectorAll('#ymc-terms .all-categories').forEach((el) => {
                optionsTaxonomies.push({
                    'slug' : el.dataset.taxSlug,
                    'name' : el.dataset.taxName,
                    'color' : el.dataset.taxColor,
                    'bg' : el.dataset.taxBg
                });
            });

            const data = {
                'action' : 'ymc_taxonomy_options',
                'nonce_code' : _smart_filter_object.nonce,
                'post_id' : $('#ymc-cpt-select').data('postid'),
                'params'  : JSON.stringify(optionsTaxonomies)
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    $('#TB_window').addClass('loading').
                    prepend(`<img class="preloader" src="${pathPreloader}">`);
                },
                success: function (res) {
                    $('#TB_window').removeClass('loading').find('.preloader').remove();
                    tb_remove();
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        }

        /**
         * Check or uncheck a term element and update its status attribute.
         * @param {Event} e - The event object triggered by the action.
         */
        function checkedSelectedTerm(e) {

            let elem = $(e.target);

            if( elem.is(':checked') ) {
                elem.attr('checked','checked').closest('.item-inner').attr('data-status-term','checked');
            }
            else {
                elem.removeAttr('checked').closest('.item-inner').attr('data-status-term','');
            }

            updatedOptionsTerms();
        }

        /**
         * Export Settings data via AJAX call.
         */
        function exportSettings() {

            const data = {
                'action': 'ymc_export_settings',
                'nonce_code' : _smart_filter_object.nonce,
                'post_id' : $('#ymc-cpt-select').data('postid')
            };

            $.ajax({
                type: 'POST',
                dataType: 'binary',
                xhrFields: {
                    'responseType': 'blob'
                },
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    container.addClass('loading').
                    prepend(`<img class="preloader" src="${pathPreloader}">`);
                },
                success: function (res) {

                    container.removeClass('loading').find('.preloader').remove();

                    let fullYear = new Date().getFullYear();
                    let day = new Date().getDate();
                    let month = new Date().getMonth();
                    let hour = new Date().getHours();
                    let minutes = new Date().getMinutes();
                    let seconds = new Date().getSeconds();

                    let link = document.createElement('a');
                    let filename = 'ymc-export-'+day+'-'+month+'-'+fullYear+'-'+hour+':'+minutes+':'+seconds+'.json';

                    let url = window.URL.createObjectURL(res);
                    link.href = url;
                    link.download = filename;
                    link.click();
                    link.remove();
                    window.URL.revokeObjectURL(url);

                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        }

        /**
         * Import Settings data from a file via AJAX call.
         */
        function importSettings() {

            let input = document.querySelector('.ymc__container-settings #tools input[type="file"]');
            let infoUploaded =  document.querySelector('.ymc__container-settings #tools .info-uploaded');
            let file = input.files[0];

            $(infoUploaded).empty();

            if( input.files.length > 0 ) {

                if( file.type === "application/json" && file.name.indexOf('ymc-export-') === 0 ) {

                    let reader = new FileReader();

                    reader.readAsText(file);

                    reader.onload = function() {

                        let data = {
                            'action': 'ymc_import_settings',
                            'nonce_code' : _smart_filter_object.nonce,
                            'post_id' : $('#ymc-cpt-select').data('postid'),
                            'params' : reader.result
                        };

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: _smart_filter_object.ajax_url,
                            data: data,
                            beforeSend: function () {
                                container.addClass('loading').
                                prepend(`<img class="preloader" src="${pathPreloader}">`);
                            },
                            success: function (res) {
                                container.removeClass('loading').find('.preloader').remove();

                                if( res.status === 1 ) {
                                    $(infoUploaded).addClass('info-uploaded--seccess').removeClass('info-uploaded--error');
                                    input.value = '';
                                    $(infoUploaded).html(res.mesg + `, wait... <img class="import-img" src="${_smart_filter_object.path+"/includes/assets/images/preloader_3.svg"}">`);
                                    location.reload();
                                    // document.querySelector('#major-publishing-actions input[type="submit"]').click();
                                }
                                else {
                                    $(infoUploaded).removeClass('info-uploaded--seccess').addClass('info-uploaded--error');
                                    $(infoUploaded).html(res.mesg);
                                }
                            },
                            error: function (obj, err) {
                                console.log( obj, err );
                            }
                        })
                    };

                    reader.onerror = function() {
                        console.error(reader.error);
                    };
                }
                else {
                    $(infoUploaded).html('Incorrect type file');
                    $(infoUploaded).removeClass('info-uploaded--seccess').addClass('info-uploaded--error');
                    throw new Error("Incorrect type file");
                }
            }
        }

        /**
         * Initializes a CodeMirror editor for custom CSS.
         */
        function codeMirrorCSS() {

            let editorSource = document.querySelector("#advanced #ymc-custom-css");

            let editor = CodeMirror.fromTextArea( editorSource, {
                //value: "",
                lineNumbers: true,
                mode:  "css",
                theme: "eclipse",
                styleActiveLine: true,
                autoCloseTags:true,
                lineWrapping: true,
                tabSize: 2,
                autofocus: true,
                smartIndent: false,
                autoRefresh: true,
                placeholder: "/*** Here your code CSS... ***/",
                extraKeys: {"Ctrl-Space": "autocomplete"}
            });

            editor.setSize(null, "400");

            editor.on('change', (args) => {
                editorSource.innerHTML = args.getValue().replace(/(\r\n|\n|\r)/gm, "");
            });

            // editor.toTextArea();
            // editor.refresh();
        }

        /**
         * Initializes CodeMirror editor for custom JavaScript.
         */
        function codeMirrorAfterJS() {

            let editorSource = document.querySelector("#advanced #ymc-custom-after-js");

            let editor = CodeMirror.fromTextArea( editorSource, {
                //value: "",
                lineNumbers: true,
                mode:  "javascript",
                theme: "eclipse",
                styleActiveLine: true,
                autoCloseTags:true,
                lineWrapping: true,
                tabSize: 2,
                autofocus: true,
                smartIndent: false,
                autoRefresh: true,
                placeholder: "/*** Enter your custom action here… ***/",
                extraKeys: {"Ctrl-Space": "autocomplete"}
            });

            editor.setSize(null, "400");

            editor.on('change', (args) => {
                editorSource.innerHTML = args.getValue().replace(/(\r\n|\n|\r)/gm, "");
            });

        }

        /**
         * Function to handle displaying popup hints and info based on user interaction
         * @param {Event} e - The event triggering the function
         */
        function popupHints(e) {
            e.preventDefault();
            
            let popupHints = document.querySelector('#advanced .custom-js .popup-hints');
            let btnCloseMethods = popupHints.querySelector('.popup-hints--btn-close');
            let btnCloseInfo = popupHints.querySelector('.popup-hints--description .btn-close');
            let methodsSections = $(popupHints).find('.popup-hints--description .info-hint .method-section');

            // Open Popup
            popupHints.style.display = 'block';

            // Close Popup
            btnCloseMethods.addEventListener('click', (e) => {
                e.preventDefault();
                popupHints.style.display = 'none';
                $(popupHints).find('.popup-hints--wrp .line-hint').removeClass('active');
            });

            // Open Info
            popupHints.querySelectorAll('.popup-hints--wrp .line-hint').forEach((el) => {

               el.addEventListener('click', (e) => {

                    let methodName = e.target.dataset.method;

                    $(e.target).addClass('active').closest('li').siblings().find('.line-hint').removeClass('active');

                    methodsSections.hide();

                    popupHints.querySelectorAll('.popup-hints--description .info-hint .method-section').forEach((el) => {

                        if( el.classList.contains(methodName) ) {

                            el.style.display = 'block';

                            el.closest('.popup-hints--description').style.display = 'block';

                            btnCloseInfo.addEventListener('click', (e) => {
                                e.target.closest('.popup-hints--description').style.display = 'none';
                                methodsSections.hide();
                                $(popupHints).find('.popup-hints--wrp .line-hint').removeClass('active');
                            });
                        }
                   });
               });
            });
        }

        /**
         * Function to handle clipboard copying hints and actions based on user interaction
         * @param {Event} e - The event triggering the function
         */
        function clipboardCopyHints(e) {

            let className = e.target.closest('svg').getAttribute('class');
            let clipboard = new ClipboardJS( `.${className}` );

            clipboard.on('success', function(e) {
                e.trigger.style.display= "none";
                e.trigger.nextElementSibling.style.display = "block";
                $(e.trigger).siblings('.js-clipboard-tip').show();

                e.clearSelection();

                setTimeout( () => {
                    e.trigger.style.display= "block";
                    e.trigger.nextElementSibling.style.display = "none";
                    $(e.trigger).siblings('.js-clipboard-tip').hide();
                },1000 );

            });

            clipboard.on('error', function(e) {
                console.error('Action:', e.action);
                console.error('Trigger:', e.trigger);
            });
        }

        /**
         * Controls the tabs functionality.
         */
        function tabsControl() {

            // Show / Hide Form Sections
            $('.tab-content .tab-panel .content .sub-header').on('click', function (e) {
                let className = $(this).data('className');
                $(this).siblings(`.${className}`).slideToggle();
                $(this).find('.fa-chevron-down').toggleClass('fa-chevron-up');
                setCookie("formClassName", className,30);
            });

            // Set Cookie for Tab
            $(".ymc__container-settings #ymcTab a").click(function(e) {
                let hashUrl = $(this).attr('href');
                setCookie("hashymc", hashUrl,30);
            });

            document.querySelectorAll('.ymc__container-settings .nav-tabs .link').forEach((el) => {

                el.addEventListener('click',function (e) {
                    e.preventDefault();

                    let hash = this.hash;

                    //let text = $(this).find('.text').text();
                    //$('.ymc__header .manage-dash .title').text(text);

                    $(el).addClass('active').closest('.nav-item').siblings().find('.link').removeClass('active');

                    document.querySelectorAll('.tab-content .tab-panel').forEach((el) => {

                        if(hash === '#'+el.getAttribute('id')) {
                            $(el).addClass('active').siblings().removeClass('active');
                        }

                    });

                });

            });

            if(getCookie("formClassName") !== '') {
                let className = getCookie("formClassName");
                $(`.tab-content .tab-panel .content .${className}`).show();
                $(`.tab-content .tab-panel .content .sub-header[data-class-name="${className}"]`).find('.form-arrow').addClass('fa-chevron-up');
            }

            // Display selected tab
            if(getCookie("hashymc") !== '') {

                let hash = getCookie("hashymc");

                $('.ymc__container-settings .nav-tabs a[href="' + hash + '"]').
                addClass('active').
                closest('.nav-item').
                siblings().
                find('.link').
                removeClass('active');

                document.querySelectorAll('.tab-content .tab-panel').forEach((el) => {
                    if(hash === '#'+el.getAttribute('id')) {
                        $(el).addClass('active').siblings().removeClass('active');
                    }
                });
            }
        }

        /**
         * Initializes the color picker for elements with the 'ymc-custom-color' class.
         */
        function colorPicker() {
            // Initialize the color picker
            $('.ymc-custom-color').wpColorPicker();
        }

        /**
         * Checks if all tags are marked and updates the parent checkbox accordingly.
         */
        function allTagsMarked() {

            // Loop through each group of checkboxes
            $('#general #ymc-terms .group-term').each(function () {

                // Count the total number of checkboxes in the group
                let total = $(this).find('input[type="checkbox"]').length - 1;

                // Count the number of checked checkboxes in the group
                let totalChecked = $(this).find('input[checked]').length;

                // If all checkboxes are marked, mark the parent checkbox
                if( total === totalChecked ) {
                    $(this).find('.all-categories input[type="checkbox"]').attr('checked','checked');
                }
            });
        }

        /**
         * Posts loaded on scroll
         */
        function loadSelectedPosts() {

            const optionsInfinityScroll = {
                root: document.querySelector("#selection-posts .choices-list"),
                rootMargin: '0px',
                threshold: 0.8
            }

            // IntersectionObserver for Posts loaded on scroll
            const postsObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {

                    if (entry.isIntersecting && !entry.target.classList.contains('isActive')) {

                        entry.target.classList.add('isActive');

                        let choicesList = $('#selection-posts .choices-list');
                        let valuesCptArray = Array.from(document.querySelectorAll('#general #ymc-cpt-select option:checked')).map(el => el.value);
                        let valuesCptString = valuesCptArray.join(',');
                        let wrapper = this;
                        let container = $('#selection-posts .choices');

                        const data = {
                            'action': 'ymc_selected_posts',
                            'nonce_code' : _smart_filter_object.nonce,
                            'cpt' : valuesCptString,
                            'paged' : _smart_filter_object.current_page
                        };

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: _smart_filter_object.ajax_url,
                            data: data,
                            beforeSend: function () {
                                container.addClass('loading').
                                prepend(`<img class="preloader" src="${pathPreloader}">`);
                            },
                            success: function (res) {
                                container.removeClass('loading').find('.preloader').remove();
                                _smart_filter_object.current_page++;

                                // Get posts
                                let dataPosts = (JSON.parse(res.lists_posts));

                                if(Object.keys(dataPosts).length > 0) {
                                    for (let key in dataPosts) {
                                        choicesList.append(dataPosts[key]);
                                    }
                                }
                                else {
                                    wrapper.dataset.loading = 'false';
                                }
                            },
                            error: function (obj, err) {
                                console.log( obj, err );
                            }
                        });

                        observer.unobserve(entry.target);
                    }
                });
            }, optionsInfinityScroll);
            
            postsObserver.observe(document.querySelector('#selection-posts .choices-list li:last-child'));
        }

        function resetSelectedPosts() {
            let choicesList = $('#selection-posts .choices-list');
            document.querySelector('#selection-posts .choices-list').dataset.loading = 'true';
            choicesList.scrollTop(0);
            _smart_filter_object.current_page = 1;
        }

        /**
         * Search posts
         */
        function searchPosts() {
            let keyword = document.querySelector('#general .search-posts .input-field').value.toLowerCase();
            let valuesCptArray = Array.from(document.querySelectorAll('#general #ymc-cpt-select option:checked')).map(el => el.value);
            let valuesCptString = valuesCptArray.join(',');
            let choicesList = $('#selection-posts .choices-list');
            let container = $('#selection-posts .choices');

            document.querySelector('#selection-posts .choices-list').dataset.loading = 'false';

            const data = {
                'action'     : 'ymc_search_posts',
                'nonce_code' : _smart_filter_object.nonce,
                'phrase'     : keyword,
                'cpt'        : valuesCptString
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    container.addClass('loading').
                    prepend(`<img class="preloader" src="${pathPreloader}">`);
                },
                success: function (res) {
                    container.removeClass('loading').find('.preloader').remove();

                    // Get posts
                    let dataPosts = (JSON.parse(res.lists_posts));
                    container.find('.number-posts').html(res.found_posts);
                    choicesList.empty();

                    if(Object.keys(dataPosts).length > 0) {
                        for (let key in dataPosts) {
                            choicesList.append(dataPosts[key]);
                        }
                    }
                    else {
                        choicesList.append('<li class="no-result">No results found</li>');
                    }
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        }


        /*** EVENTS ***/

        // CPT Event
        $(document).on('change','.ymc__container-settings #general #ymc-cpt-select',function (e, param) {

            let isCPT = ( undefined === param ) ? confirm(`Are you sure change Post Type? IMPORTANT! Post Type Changes remove all taxonomies and terms settings.`) : true;

            if( isCPT ) {

                let taxonomyWrp = $('#ymc-tax-checkboxes');
                let termWrp     = $('#ymc-terms');
                let choicesList = $('#selection-posts .choices-list');
                let valuesList  = $('#selection-posts .values-list');
                let foundPosts = $('#selection-posts .choices .number-posts');
                let valuesCptArray = Array.from(document.querySelectorAll('#general #ymc-cpt-select option:checked')).map(el => el.value);
                let valuesCptString = valuesCptArray.join(',');

                this.dataset.previousValue =  valuesCptString;

                const data = {
                    'action': 'ymc_get_taxonomy',
                    'nonce_code' : _smart_filter_object.nonce,
                    'cpt' : valuesCptString,
                    'post_id' : $(this).data('postid')
                };

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: _smart_filter_object.ajax_url,
                    data: data,
                    beforeSend: function () {
                        container.addClass('loading').
                        prepend(`<img class="preloader" src="${pathPreloader}">`);
                    },
                    success: function (res) {

                        container.removeClass('loading').find('.preloader').remove();
                        resetSelectedPosts();

                        let dataTax = (JSON.parse(res.data));

                        // Get Taxonomies
                        if(Object.keys(dataTax).length > 0) {

                            taxonomyWrp.html('');
                            termWrp.html('').closest('.wrapper-terms').addClass('hidden');

                            for (let key in dataTax) {

                            taxonomyWrp.append(`<div id="${key}" class="group-elements" draggable="true">
                            <i class="fas fa-grip-vertical handle"></i>
                            <input id="id-${key}" type="checkbox" name="ymc-taxonomy[]" value="${key}">
                            <label for="id-${key}">${dataTax[key]}</label>
                            </div>`);
                            }
                        }
                        else  {

                            taxonomyWrp.html('').append(`<span class="notice">No data for Post Type / Taxonomy</span>`);
                            termWrp.html('').closest('.wrapper-terms').addClass('hidden');
                        }

                        // Get posts
                        let dataPosts = (JSON.parse(res.lists_posts));

                        valuesList.empty();
                        choicesList.empty();
                        foundPosts.html(res.found_posts);

                        if(Object.keys(dataPosts).length > 0) {
                            for (let key in dataPosts) {
                                choicesList.append(dataPosts[key]);
                            }
                        }
                        else {
                            choicesList.html(`<li class="notice">No posts</li>`);
                        }
                    },
                    error: function (obj, err) {
                        console.log( obj, err );
                    }
                });

            }
            else {
                let previousValues = this.dataset.previousValue.split(',');
                document.querySelectorAll('#general #ymc-cpt-select option').forEach((el) => {
                    el.selected = previousValues.includes(el.value);
                });
            }
        });

        // Taxonomy Event
        $(document).on('click','.ymc__container-settings #general #ymc-tax-checkboxes input[type="checkbox"]',function (e) {

            let termsSection = $('.wrapper-terms');
            let termWrp = $('#ymc-terms');
            let val = '';

            if($(e.target).is(':checked')) {

                val = $(e.target).val();

                const data = {
                    'action': 'ymc_get_terms',
                    'nonce_code' : _smart_filter_object.nonce,
                    'taxonomy' : val,
                    'post_id' : $(this).closest('#ymc-tax-checkboxes').data('postid')
                };

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: _smart_filter_object.ajax_url,
                    data: data,
                    beforeSend: function () {
                        container.addClass('loading').
                        prepend(`<img class="preloader" src="${pathPreloader}">`);
                    },
                    success: function (res) {

                        container.removeClass('loading').find('.preloader').remove();

                        if($(e.target).closest('.ymc-tax-checkboxes').find('input[type="checkbox"]:checked').length > 0) {
                            $('.ymc__container-settings #general .wrapper-terms').removeClass('hidden');
                        } else {
                            $('.ymc__container-settings #general .wrapper-terms').addClass('hidden');
                        }

                        // Get Terms
                        if( res.data.terms.length )
                        {
                            let output = '';
                            let taxName = $(e.target).siblings('label').text();

                            output += `<article class="group-term item-${val}">
                                       <div class="item-inner all-categories" data-tax-slug="${val}" data-tax-color data-tax-bg data-tax-name="${taxName}" data-tax-original-name="${taxName}">
                                       <input name='all-select' class='category-all' id='category-all-${val}' type='checkbox'>
                                       <label for='category-all-${val}' class='category-all-label'>
                                       All [ ${taxName} ]</label>
                                       <i class="far fa-ellipsis-v choice-icon" title="Taxonomy settings"></i></div>
                                       <div class="entry-terms">`;

                            res.data.terms.forEach((el,i) => {
                                output += `<div class="item"><div class='item-inner' 
                                data-termid='${el.term_id}' 
                                data-alignterm 
                                data-bg-term 
                                data-color-term 
                                data-custom-class 
                                data-color-icon 
                                data-class-icon 
                                data-status-term 
                                data-hide-term 
                                data-default-term 
                                data-name-term="${el.name}" >
                                <i class="fas fa-grip-vertical handle"></i>
                                <input name="ymc-terms[]" class="category-list" id="category-id-${el.term_id}" type="checkbox" value="${el.term_id}">
                                <label for='category-id-${el.term_id}' class='category-list-label'><span class="name-term">${el.name}</span> [${el.count}]</label>
                                <i class="far fa-ellipsis-v choice-icon" title="Term settings"></i>
                                <span class="indicator-icon"></span>                                
                                </div>`;

                                // Add Nestsed Tree Terms
                                if( res.data.hierarchy.length && res.data.hierarchy[i] !== '' ) {
                                    output += res.data.hierarchy[i];
                                }

                                output += `</div>`;
                            });

                            output += `</div></article>`;

                            termWrp.append(output);

                            output = '';

                            sortTerms();

                            updateSortTerms();
                        }
                        else  {
                            termWrp.append(`<article class="group-term item-${val}">
                            <div class='item-inner notice-error'>No terms for taxonomy <b>${$(e.target).siblings('label').text()}</b></div></article>`);
                        }
                    },
                    error: function (obj, err) {
                        console.log( obj, err );
                    }
                });
            }
            else {

               let act = confirm("Are you sure you want to disable this taxonomy?");
               if( act ) {

                   termWrp.find('.item-'+$(e.target).val()).remove();
                   let checkboxes = $(e.target).closest('.group-elements').siblings().find('input[type="checkbox"]');
                   let flag = true;

                   checkboxes.each(function () {
                       if( $(this).is(':checked') ) {
                           flag = false;
                       }
                   });

                   ( flag ) ? termsSection.addClass('hidden') : '';
               }
               else {
                   $(e.target).prop('checked', true);
               }
            }
        });

        // Delete Taxonomies
        $(document).on('click','.ymc__container-settings #general .tax-delete',function (e) {

            let isDelete = confirm("Are you sure you want to delete all taxonomies?");

            if( isDelete ) {
                $('.ymc__container-settings #general #ymc-cpt-select').trigger('change', [ "delTerms" ]);
            }
        });

        // Update Taxonomies
        $(document).on('click','.ymc__container-settings #general .tax-reload',function (e) {

            let postId = document.querySelector('#ymc-cpt-select').dataset.postid;
            let cpts = '';
            let taxonomyWrp = $('#ymc-tax-checkboxes');
            let termWrp     = $('#ymc-terms');
            let taxExist = []; // Current Taxonomies

            $("#ymc-cpt-select :selected").map(function(i, el) {
                cpts +=$(el).val()+',';
            });

            cpts = cpts.replace(/,\s*$/, "");

            taxonomyWrp.find('input[type="checkbox"]').each(function () {
                taxExist.push($(this).val());
            });

            const data = {
                'action': 'ymc_updated_taxonomy',
                'nonce_code' : _smart_filter_object.nonce,
                'cpt' : cpts,
                'post_id' :postId
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    container.addClass('loading').
                    prepend(`<img class="preloader" src="${pathPreloader}">`);
                },
                success: function (res) {
                    container.removeClass('loading').find('.preloader').remove();
                    let dataTax = res.data; // Updated Taxonomies

                    // Get Taxonomies
                    if(Object.keys(dataTax).length > 0) {
                        // Add new taxonomy
                        if( Object.keys(dataTax).length > taxExist.length ) {

                            for (let key in dataTax) {

                                if( ! taxExist.includes(key) ) {

                                    taxonomyWrp.append(`<div id="${key}" class="group-elements" draggable="true">
                                    <i class="fas fa-grip-vertical handle"></i>
                                    <input id="id-${key}" type="checkbox" name="ymc-taxonomy[]" value="${key}">
                                    <label for="id-${key}">${dataTax[key]}</label>
                                    </div>`);
                                }
                            }
                        }

                        // Delete taxonomy
                        if( Object.keys(dataTax).length < taxExist.length ) {

                            for (let key in taxExist) {

                                if( ! Object.keys(dataTax).includes(taxExist[key]) ) {
                                    taxonomyWrp.find(`#${taxExist[key]}`).remove();
                                    termWrp.find(`.item-${taxExist[key]}`).remove();
                                }
                            }
                        }
                    }
                    else  {
                        taxonomyWrp.html('').append(`<span class="notice">No data for Post Type / Taxonomy</span>`);
                        termWrp.html('').closest('.wrapper-terms').addClass('hidden');
                    }
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });

        });

        // Choices Posts
        $('.wrapper-selection .ymc-exclude-posts').on('click', function (e) {

            let listItems = $('.selection-posts .values .values-list');

            if($(e.target).prop('checked')) {
                listItems.removeClass('include-posts').addClass('exclude-posts');
            }
            else {
                listItems.removeClass('exclude-posts').addClass('include-posts');
            }
        });

        $(document).on('click','#selection-posts .choices-list .ymc-rel-item-add', function (e) {

            let postID = $(e.target).closest('.ymc-rel-item-add').data('id');
            let titlePosts = $(e.target).closest('.ymc-rel-item-add').find('.postTitle').text();
            e.target.closest('.ymc-rel-item-add').classList.add('disabled');

            let valuesList = $('#selection-posts .values-list');
            let numberPosts = $('#selection-posts .number-selected-posts');
            valuesList.addClass('include-posts');

            valuesList.append(`<li class="item"><input type="hidden" name="ymc-choices-posts[]" value="${postID}">
					<span  class="ymc-rel-item" data-id="${postID}">${titlePosts}
                    <a href="#" class="ymc-icon-minus remove_item"></a>
                    </span></li>`);

            numberPosts.html(valuesList.find('li').length);

            sortSelectedPosts();
        });

        $(document).on('click','#selection-posts .values-list .remove_item', function (e) {
            e.preventDefault();

            let postID = $(e.target).closest('.ymc-rel-item').data('id');
            let numberPosts = $('#selection-posts .number-selected-posts');
            let valuesList = $('#selection-posts .values-list');

            $('#selection-posts .choices-list .ymc-rel-item-add').each(function (){
                if( postID === $(this).data('id')) {
                    $(this).removeClass('disabled');
                }
            });

            if( $(e.target).closest('.values-list').find('li').length - 1 === 0 ) {

                const data = {
                    'action': 'ymc_delete_choices_posts',
                    'nonce_code' : _smart_filter_object.nonce,
                    'post_id' : $('#ymc-cpt-select').data('postid')
                };

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: _smart_filter_object.ajax_url,
                    data: data,
                    beforeSend: function () {
                        container.addClass('loading').
                        prepend(`<img class="preloader" src="${pathPreloader}">`);
                    },
                    success: function (res) {
                        container.removeClass('loading').find('.preloader').remove();
                    },
                    error: function (obj, err) {
                        console.log( obj, err );
                    }
                });

            }

            $(e.target).closest('li').remove();

            numberPosts.html(valuesList.find('li').length);

        });

        // Search Posts in Choices Box
        $(document).on('click','#general .search-posts .btn-submit', function (e) {
            e.preventDefault();
            let keyword = document.querySelector('#general .search-posts .input-field').value;
            if( keyword.length > 0 ) {
                searchPosts();
            }
        });

        $(document).on('input','#general .search-posts .input-field', function (e) {
            let keyword = document.querySelector('#general .search-posts .input-field').value.toLowerCase();
            let btnClear = $('.search-posts .clear-button');
            btnClear.addClass('active');
            if( keyword.length === 0 ) {
                $('#general .search-posts .clear-button').trigger('click');
            }
        });

        $(document).on('click','#general .search-posts .clear-button', function (e) {

            let choicesList = $('#selection-posts .choices-list');
            let container = $('#selection-posts .choices');
            let valuesCptArray = Array.from(document.querySelectorAll('#general #ymc-cpt-select option:checked')).map(el => el.value);
            let valuesCptString = valuesCptArray.join(',');

            document.querySelector('#selection-posts .choices-list').dataset.loading = 'true';
            e.target.closest('.search-posts').querySelector('.input-field').value = '';
            e.target.closest('.search-posts').querySelector('.input-field').focus();
            e.target.closest('.search-posts').querySelector('.input-field').removeAttribute('disabled');
            e.target.closest('.search-posts').querySelector('.clear-button').classList.remove('active');

            const data = {
                'action': 'ymc_selected_posts',
                'nonce_code' : _smart_filter_object.nonce,
                'cpt' : valuesCptString,
                'clear_search' : true
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    container.addClass('loading').
                    prepend(`<img class="preloader" src="${pathPreloader}">`);
                },
                success: function (res) {
                    container.removeClass('loading').find('.preloader').remove();
                    _smart_filter_object.current_page = 1;

                    // Get posts
                    let dataPosts = (JSON.parse(res.lists_posts));
                    container.find('.number-posts').html(res.found_posts);
                    choicesList.empty();

                    if(Object.keys(dataPosts).length > 0) {
                        for (let key in dataPosts) {
                            choicesList.append(dataPosts[key]);
                        }
                    }
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
        });

        // Open Popup for Settings Term & Icons
        $(document).on('click','#general #ymc-terms .entry-terms .choice-icon', function (e) {

            $('#ymc-terms .entry-terms .item-inner').removeClass('open-popup');

            $(e.target).closest('.item-inner').addClass('open-popup');

            // Get values data attributes terms
            let nameTerm = $(e.target).siblings('.category-list-label').find('.name-term').text();
            let alignterm = e.target.closest('.item-inner').dataset.alignterm;
            let bgTerm = e.target.closest('.item-inner').dataset.bgTerm;
            let colorTerm = e.target.closest('.item-inner').dataset.colorTerm;
            let customClass = e.target.closest('.item-inner').dataset.customClass || '';
            let defaultTerm = e.target.closest('.item-inner').dataset.defaultTerm || '';
            let hideTerm = e.target.closest('.item-inner').dataset.hideTerm || '';
            let customNameTerm = e.target.closest('.item-inner').dataset.nameTerm || '';
            let colorIcon = e.target.closest('.item-inner').dataset.colorIcon || '#3c434a';
            let newIcon = $(e.target).siblings('.indicator-icon').find('i').clone(true).css('color',colorIcon);

            // Run popup
            tb_show( '&#9998; Term: &#91; '+nameTerm+' &#93;', '/?TB_inline&inlineId=ymc-icons-modal&width=740&height=768' );

            // Get elements in popup
            let iconCurrentColor   = $('#TB_ajaxContent .ymc-icons-content .ymc-icon-color');
            let iconCurrentClass   = $('#TB_ajaxContent .ymc-terms-content .terms-entry .ymc-term-class');
            let termCurrentBg      = $('#TB_ajaxContent .ymc-terms-content .terms-entry .ymc-term-bg');
            let termCurrentColor   = $('#TB_ajaxContent .ymc-terms-content .terms-entry .ymc-term-color');
            let termCurrentDefault = $('#TB_ajaxContent .ymc-terms-content .terms-entry .ymc-term-default');
            let termCurrentHide    = $('#TB_ajaxContent .ymc-terms-content .terms-entry .ymc-term-hide');
            let termCustomName     = $('#TB_ajaxContent .ymc-terms-content .terms-entry .ymc-term-custom-name');

            if( newIcon.length > 0 ) {
                $( '#TB_ajaxContent .ymc-icons-content .panel-setting .remove-link' ).show();
                $( '#TB_ajaxContent .ymc-icons-content .panel-setting .preview-icon' ).html(newIcon);
            }
            else {
                $( '#TB_ajaxContent .ymc-icons-content .panel-setting .remove-link' ).hide();
                $( '#TB_ajaxContent .ymc-icons-content .panel-setting .preview-icon' ).empty();
            }

            $('#TB_ajaxContent .ymc-icons-content .panel-setting .toggle-align-icon[data-align="'+alignterm+'"]').
                addClass('selected').siblings().removeClass('selected');

            // Set current settings
            termCurrentBg.wpColorPicker('color', bgTerm);
            termCurrentColor.wpColorPicker('color', colorTerm);
            ( defaultTerm !== '' ) ? termCurrentDefault.attr('checked', defaultTerm).prop('checked', true) :
                                     termCurrentDefault.removeAttr('checked');

            ( hideTerm !== '' ) ? termCurrentHide.attr('checked','checked').prop('checked', true) :
                termCurrentHide.removeAttr('checked');

            iconCurrentColor.wpColorPicker('color', colorIcon);
            iconCurrentClass.val(customClass);
            termCustomName.val(customNameTerm);

            // Change color icon
            let options = {
                change: function(event, ui){
                    // automattic.github.io/Iris
                    let previewIcon = $('#TB_ajaxContent .ymc-icons-content .panel-setting .preview-icon i');
                    previewIcon.css({'color':`${ui.color.toString()}`});
                },
            }
            iconCurrentColor.wpColorPicker(options);
        });

        // Add Icon
        $(document).on('click','#TB_ajaxContent .ymc-icons-content .icons-entry i', function (e) {

            let classIcon = $(e.target).attr('class');
            let selectedTerm = $('#ymc-terms .entry-terms .open-popup');
            let colorIcon = $('#TB_ajaxContent .ymc-icons-content .panel-setting .ymc-icon-color').val() || '#3c434a';
            let previewIcon = $('#TB_ajaxContent .ymc-icons-content .panel-setting .preview-icon');
            let removeBtn = $('#TB_ajaxContent .ymc-icons-content .panel-setting .remove-link');
            let termId = selectedTerm.data('termid');
            let iconHtml = `<i class="${classIcon}" style="color: ${colorIcon};"></i>
                                  <input name="ymc-terms-icons[${termId}]" type="hidden" value="${classIcon}">`;


            selectedTerm.attr('data-class-icon', classIcon)
            selectedTerm.find('.indicator-icon').html(iconHtml);

            previewIcon.html(`<i class="${classIcon}" style="color: ${colorIcon};"></i>`);

            removeBtn.show();

            $('#TB_ajaxContent .ymc-icons-content .icons-entry i').removeClass('result').show();
            $('#TB_ajaxContent .ymc-icons-content .panel-setting input[type="search"]').val('');

            //tb_remove();
        });

        // Remove icon
        $(document).on('click','#TB_ajaxContent .ymc-icons-content .remove-link', function (e) {

            $('#ymc-terms .entry-terms .open-popup .indicator-icon').
               empty().closest('.item-inner').attr('data-color-icon','').attr('data-class-icon','').removeClass('open-popup');

            updatedOptionsIcons();

            // If no icons for terms
            if ( $('#ymc-terms .entry-terms .indicator-icon').find('input').length === 0 ) {

                const data = {
                    'action': 'ymc_delete_choices_icons',
                    'nonce_code' : _smart_filter_object.nonce,
                    'post_id' : $('#ymc-cpt-select').data('postid')
                };

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: _smart_filter_object.ajax_url,
                    data: data,
                    beforeSend: function () {
                        container.addClass('loading').
                        prepend(`<img class="preloader" src="${pathPreloader}">`);
                    },
                    success: function (res) {
                        container.removeClass('loading').find('.preloader').remove();
                    },
                    error: function (obj, err) {
                        console.log( obj, err );
                    }
                });
            }

            tb_remove();
        });

        // Search Icon
        $(document).on('input','#TB_ajaxContent .ymc-icons-content input[type="search"]', function (e) {

            let keyword = e.target.value.toLowerCase();
            let arrIcons = [];

            if( keyword.length >= 3 ) {

                document.querySelectorAll('#TB_ajaxContent .ymc-icons-content .icons-entry i').forEach((el) => {

                    let nameClass = $(el).attr('class').replace(/[\s.-]/g, ' ');

                    if(nameClass.includes(keyword)) {
                        arrIcons.push(el);
                    }
                });

                if( arrIcons.length > 0 ) {
                    arrIcons.forEach((elem) => {
                        elem.classList.add('result');
                    });
                    $('#TB_ajaxContent .ymc-icons-content .icons-entry i:not(.result)').hide();
                    $('#TB_ajaxContent .ymc-icons-content .icons-entry i.result').show();
                }
                else {
                    $('#TB_ajaxContent .ymc-icons-content .icons-entry i').hide();
                }
            }
            else {
                $('#TB_ajaxContent .ymc-icons-content .icons-entry i').removeClass('result').show();
            }

        });

        // Set align icon for Terms
        $(document).on('click','#TB_ajaxContent .ymc-icons-content .panel-setting .align-icon .toggle-align-icon', function (e) {
            e.preventDefault();
            updatedOptionsIcons(e);
        });

        // Tabs popup settings Terms
        $(document).on('click','#TB_ajaxContent .tabs .tab .tab-inner', function (e) {

            let _self = $(e.target);
            let content = e.target.dataset.content;
            let iconContent = $('#TB_ajaxContent .ymc-icons-content');
            let termContent = $('#TB_ajaxContent .ymc-terms-content');

            _self.closest('.tab').addClass('active').siblings().removeClass('active');

            if( content === 'icon' ) {
                iconContent.addClass('ymc-visible').removeClass('ymc-hidden');
                termContent.addClass('ymc-hidden').removeClass('ymc-visible');
            }
            else {
                iconContent.addClass('ymc-hidden').removeClass('ymc-visible');
                termContent.addClass('ymc-visible').removeClass('ymc-hidden');
            }

        });

        // Save Settings Terms & Icons
        $(document).on('click','#TB_ajaxContent .btn-apply', function (e) {
            e.preventDefault();

            let postId = $('#ymc-cpt-select').data('postid');
            let bgTerm = $('#TB_ajaxContent .ymc-terms-content .ymc-term-bg').val();
            let colorTerm = $('#TB_ajaxContent .ymc-terms-content .ymc-term-color').val();
            let customClass = $('#TB_ajaxContent .ymc-terms-content .ymc-term-class').val();
            let defaultTerm = $('#TB_ajaxContent .ymc-terms-content .ymc-term-default:checked').val();
            let hideTerm = $('#TB_ajaxContent .ymc-terms-content .ymc-term-hide:checked').val();
            let nameTerm = $('#TB_ajaxContent .ymc-terms-content .ymc-term-custom-name').val();
            let colorIcon = $('#TB_ajaxContent .ymc-icons-content .panel-setting .ymc-icon-color').val();
            let selectedTerm = document.querySelector('#ymc-terms .entry-terms .open-popup');

            selectedTerm.dataset.bgTerm = bgTerm;
            selectedTerm.dataset.colorTerm = colorTerm;
            selectedTerm.dataset.customClass = customClass;
            selectedTerm.dataset.defaultTerm = (undefined !== defaultTerm) ? defaultTerm : '';
            selectedTerm.dataset.hideTerm = (undefined !== hideTerm) ? hideTerm : '';
            selectedTerm.dataset.colorIcon = colorIcon;
            selectedTerm.dataset.nameTerm = nameTerm;

            ( bgTerm || colorTerm ) ?
                selectedTerm.setAttribute('style',`background-color: ${bgTerm}; color: ${colorTerm}`) :
                selectedTerm.removeAttribute('style');

            selectedTerm.querySelector('.name-term').innerText = nameTerm;
            selectedTerm.dataset.colorIcon = colorIcon;
            $(selectedTerm).find('.indicator-icon i').attr('style',`color: ${colorIcon}`);

            updatedOptionsIcons();
            updatedOptionsTerms();

        });

        // Selected All Terms
        $(document).on('click','.ymc__container-settings #general #ymc-terms .all-categories input[type="checkbox"]',function (e) {

            let input = $(e.target);

            let checkbox = input.closest('.all-categories').siblings().find('input[type="checkbox"]');

            if( input.is(':checked') ) {

                if( ! checkbox.is(':checked') ) {
                    checkbox.prop( "checked", true );
                }
            }
            else  {
                checkbox.prop( "checked", false );
            }
        });

        // Updated list posts in choices box
        $(document).on('click','.ymc__container-settings #general #ymc-terms input[type="checkbox"]',function (e) {

            // Run updated terms options
            checkedSelectedTerm(e);

            /*
            let valuesCptArray = Array.from(document.querySelectorAll('#general #ymc-cpt-select option:checked')).map(el => el.value);
            let cpts = valuesCptArray.join(',');
            let arrTax = [];
            let arrTerms = [];
            let numberPosts = document.querySelector('#selection-posts .number-posts');
            let choicesPosts = document.querySelector('#selection-posts .list');

            // Terms
            document.querySelectorAll('#ymc-terms .item-inner:not(.all-categories)').forEach((el) => {
                let chbox = $(el).find('input[type="checkbox"]');
                if( chbox.is(':checked') ) {
                    arrTerms.push(chbox.val());
                }
            });

            // Tax
            document.querySelectorAll('.wrapper-taxonomy .ymc-tax-checkboxes .group-elements').forEach((el) => {
                let chbox = $(el).find('input[type="checkbox"]');
                if( chbox.is(':checked')) {
                    arrTax.push(chbox.val());
                }
            });

            const data = {
                'action': 'ymc_updated_posts',
                'nonce_code' : _smart_filter_object.nonce,
                'cpt' : cpts,
                'tax' : JSON.stringify(arrTax),
                'terms' : JSON.stringify(arrTerms),
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: _smart_filter_object.ajax_url,
                data: data,
                beforeSend: function () {
                    container.addClass('loading').
                    prepend(`<img class="preloader" src="${pathPreloader}">`);
                },
                success: function (res) {

                    container.removeClass('loading').find('.preloader').remove();
                    resetSelectedPosts();

                    if( res.output ) {
                        choicesPosts.innerHTML = res.output;
                        numberPosts.innerHTML = res.found;
                    }
                    else {
                        choicesPosts.innerHTML = '';
                    }
                },
                error: function (obj, err) {
                    console.log( obj, err );
                }
            });
            */
        });

        // Toggle Filter Status
        $(document).on('click', '.ymc__container-settings .ymc-toggle-group .slider', function (e) {

            let input = $(e.target).siblings('input');

           // ( input.is(':checked') ) ? input.siblings('input[type="hidden"]').val('on') : input.siblings('input[type="hidden"]').val('off');

            if(input.is(':checked')) {
                input.siblings('input[type="hidden"]').val('on').closest('.form-group').find('.manage-filters').show();
            }
            else  {
                input.siblings('input[type="hidden"]').val('off').closest('.form-group').find('.manage-filters').hide();
            }

        });

        // Sort by Fields
        $('.appearance-section #ymc-order-post-by').change(function(e) {
            let metaSort = $(e.target).closest('.from-element').siblings('.from-element--meta-sort');
            let multipleSort = $(e.target).closest('.from-element').siblings('.from-element--multiple-sort');
            let orderSort = $(e.target).closest('.from-element').siblings('.from-element--order-sort');

            metaSort.hide();
            multipleSort.hide();
            orderSort.show();

            switch ( this.value ) {

                case 'meta_key' : metaSort.show();  break;

                case 'multiple_fields' : multipleSort.show(); orderSort.hide(); break;

            }
        });

        // Event handler Add Multiple Fields
        $('.appearance-section .from-element--multiple-sort .btnAddMultipleSort').click(function (e) {
            let length = $(e.target).closest('.from-element').find('.rows-options').length;
            let rowCloneHtml = $($(e.target).closest('.from-element').find('.rows-options')[length - 1]).clone(true);
            $(e.target).closest('.from-element').find('.ymc-btn').before(rowCloneHtml);

           let newItem = $($(e.target).closest('.from-element').find('.rows-options')[length]);
           newItem.find('.ymc-multiple-orderby').attr('name','ymc-multiple-sort['+length+'][orderby]');
           newItem.find('.ymc-multiple-order').attr('name','ymc-multiple-sort['+length+'][order]');

            $(this).siblings('.btnRemoveMultipleSort').show();
        });

        // Event handler Remove Multiple Fields
        $('.appearance-section .from-element--multiple-sort .btnRemoveMultipleSort').click(function (e) {
            let length = $(e.target).closest('.from-element').find('.rows-options').length;

            if( length > 1 ) {
                $($(e.target).closest('.from-element').find('.rows-options')[length - 1]).remove();
            }
            if( length - 1 === 1 ) {
                $(this).hide();
            }
        });

        // Set Style Preloader
        $(document).on('change', '#advanced #ymc-preloader-icon', function (e) {
            let preloaderURL = _smart_filter_object.path + "/includes/assets/images/" + $(this).val() + '.svg';
            $(this).closest('#ymc-preloader-icon').next('.preview-preloader').find('img').attr('src', preloaderURL);
        });

        // Apply Filters for Preloader Icon
        $(document).on('change', '#advanced #ymc-filter-preloader', function (e) {

            let filter = e.target.value;
            let filterRate = document.querySelector('#advanced .filter-rate');
            let filterCustom = document.querySelector('#advanced .filters-custom');
            let preview = document.querySelector('#advanced .preview-preloader img');
            let rate = document.querySelector('#advanced .range-wrapper input[type="range"]');

            if( filter !== 'custom_filters' && filter !== 'none' ) {
                preview.setAttribute('style', `filter: ${filter}(${rate.value})`);
                filterRate.classList.remove('ymc_hidden');
                filterCustom.classList.add('ymc_hidden');
            }
            else if( filter === 'none' ) {
                filterRate.classList.add('ymc_hidden');
                filterCustom.classList.add('ymc_hidden');
            }
            else {
                filterRate.classList.add('ymc_hidden');
                filterCustom.classList.remove('ymc_hidden');
            }
        });

        // Change Coefficient for Preloader Icon
        $(document).on('input', '#advanced #ymc-filter-rate', function (e) {
            let rate = e.target.value;
            let filter = document.querySelector('#advanced #ymc-filter-preloader');
            let preview = document.querySelector('#advanced .preview-preloader img');
            preview.setAttribute('style', `filter: ${filter.value}(${rate})`);
        });

        // Add custom filters for Preloader Icon
        $(document).on('input', '#advanced #ymc-filters-custom', function (e) {
            let filters = e.target.value;
            let preview = document.querySelector('#advanced .preview-preloader img');
            preview.setAttribute('style', filters);
        });

        // Export As JSON
        $(document).on('click', '.ymc__container-settings #tools .button-export', exportSettings);

        // Import JSON
        $(document).on('click', '.ymc__container-settings #tools .button-import', importSettings);

        // Custom Type Query
        $(document).on('change', '.ymc__container-settings #advanced .type-query .ymc-query-type', function (e) {

            let className = e.target.value;

            document.querySelectorAll('.ymc__container-settings #advanced .type-query-content').forEach((el) => {

                let _elem = $(el);
                ( _elem.hasClass(className) ) ? _elem.show() : _elem.hide();
            });
        });

        // Select Post Layout
        $(document).on('change', '.ymc__container-settings #layouts #ymc-post-layout', function (e) {

            let postLayout = e.target.value;
            let columnLayoutSection = $('.ymc__container-settings #layouts .column-layout__section');
            let carouselLayoutSection = $('.ymc__container-settings #layouts .carousel-settings');

            // Array Post Layouts for Breakpoints
            let arr_layouts_posts = [
                'post-layout1',
                'post-layout2',
                'post-custom-layout'
            ];

            // Show / Hide Column Settings
            ( arr_layouts_posts.includes(postLayout) ) ? columnLayoutSection.show() : columnLayoutSection.hide();

            // Show / Hide Carousel Settings
            ( postLayout === 'post-carousel-layout' ) ? carouselLayoutSection.show() : carouselLayoutSection.hide();

        });

        // Hints Custom JS
        $(document).on('click', '.ymc__container-settings #advanced .custom-js .button-hints', popupHints);

        // Clipboard Copy Hints
        document.querySelectorAll('.ymc__container-settings #advanced .custom-js .popup-hints .js-clipboard-copy').forEach((el) => {
            el.addEventListener( 'click', clipboardCopyHints );
        });

        // Open popup Taxonomy Settings
        $(document).on('click','#general #ymc-terms .all-categories .choice-icon', function (e) {

            let _self = $(e.target);

            $('#ymc-terms .all-categories').removeClass('open-popup');
            _self.closest('.all-categories').addClass('open-popup');

            // Get values data attributes taxonomy
            let taxName = e.target.closest('.all-categories').dataset.taxName;
            let taxBg = e.target.closest('.all-categories').dataset.taxBg;
            let taxColor = e.target.closest('.all-categories').dataset.taxColor;

            // Run popup
            tb_show('&#9998; Taxonomy: &#91; '+ taxName +' &#93;', '/?TB_inline&width=740&height=768&inlineId=config-taxonomy');

            // Get elements in popup
            let taxCurrentBg = $('#TB_ajaxContent .ymc-tax-content #ymc-tax-bg');
            let taxCurrentColor = $('#TB_ajaxContent .ymc-tax-content #ymc-tax-color');
            let taxCustomName = $('#TB_ajaxContent .ymc-tax-content #ymc-tax-custom-name');

            // Set current settings
            taxCurrentBg.wpColorPicker('color', taxBg);
            taxCurrentColor.wpColorPicker('color', taxColor);
            taxCustomName.val(taxName);
        });

        // Save Settings Taxonomy
        $(document).on('click','#TB_ajaxContent .btn-tax-apply', function (e) {
            e.preventDefault();

            let taxBg = $('#TB_ajaxContent .ymc-tax-content .ymc-tax-bg').val();
            let taxColor = $('#TB_ajaxContent .ymc-tax-content .ymc-tax-color').val();
            let taxName = $('#TB_ajaxContent .ymc-tax-content .ymc-tax-custom-name').val();
            let selectedTax = document.querySelector('#ymc-terms .all-categories.open-popup');
            let taxOriginalName = selectedTax.dataset.taxOriginalName;

            selectedTax.dataset.taxBg = taxBg;
            selectedTax.dataset.taxColor = taxColor;
            selectedTax.dataset.taxName = ( taxName ) ? taxName : taxOriginalName;

            let styleTaxBg = ( taxBg ) ? `background-color: ${taxBg};` : '';
            let styleTaxColor = ( taxColor ) ? `color: ${taxColor};` : '';

            ( taxBg || taxColor ) ?
                selectedTax.setAttribute('style',`${styleTaxBg}${styleTaxColor}`) :
                selectedTax.removeAttribute('style');

            ( taxName ) ?
                selectedTax.querySelector('.category-all-label').innerHTML = 'All [ '+taxName+' ]' :
                selectedTax.querySelector('.category-all-label').innerHTML = 'All [ '+taxOriginalName+' ]';

            $('#ymc-terms .all-categories').removeClass('open-popup');

            updatedOptionsTaxonomies();

        });

        // Load selected posts
        $('#general .selection-posts .choices .choices-list').on('scroll', loadSelectedPosts);
        
        // Expand Selected Posts
        $('#general .wrapper-selection .button-expand a').on('click', function (e) {
            e.preventDefault();

            if( !$(this).hasClass('collapse') ) {
                $(this).text('collapse').addClass('collapse');
            } else {
                $(this).text('expand').removeClass('collapse');
            }
            $('.choices-list,.values-list').toggleClass('expand');
        });


        /*** RUN FUNCTIONS ***/

        // Tabs Control
        tabsControl();

        // Color Picker
        colorPicker();

        // All Tags Marked
        allTagsMarked();

        // CodeMirror
        codeMirrorCSS();

        // CodeMirror
        codeMirrorAfterJS();

        // Sort Taxonomy
        sortTaxonomy();

        // Sort Terms
        sortTerms();

        // Sort Nested Terms
        sortNestedTerms();

        // Sort Selected Posts
        sortSelectedPosts();
    });

}( jQuery ));