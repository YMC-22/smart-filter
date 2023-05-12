;
(function( $ ) {
    "use strict"

    $(document).on('ready', function () {

        // Path preloader image
        const pathPreloader = _smart_filter_object.path+"/includes/assets/images/preloader.svg";

        // Wrapper tab
        const container   = $('.ymc__container-settings .tab-panel');

        document.querySelectorAll('.ymc__container-settings .nav-tabs .link').forEach((el) => {

            el.addEventListener('click',function (e) {
                e.preventDefault();

                let hash = this.hash;

                let text = $(this).find('.text').text();

                $('.ymc__header .manage-dash .title').text(text);

                $(el).addClass('active').closest('.nav-item').siblings().find('.link').removeClass('active');

                document.querySelectorAll('.tab-content .tab-panel').forEach((el) => {

                    if(hash === '#'+el.getAttribute('id')) {
                        $(el).addClass('active').siblings().removeClass('active');
                    }

                });

            });

        });

        // CPT Event
        $(document).on('change','.ymc__container-settings #general #ymc-cpt-select',function (e) {

            let taxonomyWrp = $('#ymc-tax-checkboxes');
            let termWrp     = $('#ymc-terms');
            let choicesList = $('#selection-posts .choices-list');
            let valuesList  = $('#selection-posts .values-list');

            const data = {
                'action': 'ymc_get_taxonomy',
                'nonce_code' : _smart_filter_object.nonce,
                'cpt' : $(this).val(),
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

                    let dataTax = (JSON.parse(res.data));

                    // Get Taxonomies
                    if(Object.keys(dataTax).length > 0) {

                        taxonomyWrp.html('');
                        termWrp.html('').closest('.wrapper-terms').addClass('hidden');

                        for (let key in dataTax) {

                            taxonomyWrp.append(`<div id="${key}" class="group-elements" draggable="true">
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
        });

        // Taxonomy Event
        $(document).on('click','.ymc__container-settings #general #ymc-tax-checkboxes input[type="checkbox"]',function (e) {

            let termWrp = $('#ymc-terms');

            let val = '';

            if($(e.target).is(':checked')) {

                val = $(e.target).val();

                const data = {
                    'action': 'ymc_get_terms',
                    'nonce_code' : _smart_filter_object.nonce,
                    'taxonomy' : val
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
                        if( res.data.terms.length ) {

                            let output = '';

                            output += `<article class="group-term item-${val}">
                                       <div class="item-inner all-categories">
                                       <input name='all-select' class='category-all' id='category-all-${val}' type='checkbox'>
                                       <label for='category-all-${val}' class='category-all-label'>All [ ${$(e.target).siblings('label').text()} ]</label></div>
                                       <div class="entry-terms">`;

                            res.data.terms.forEach((el) => {
                                output += `<div class='item-inner'><input name="ymc-terms[]" class="category-list" id="category-id-${el.term_id}" type="checkbox" value="${el.term_id}">
                                <label for='category-id-${el.term_id}' class='category-list-label'>${el.name}</label></div>`;
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
                termWrp.find('.item-'+$(e.target).val()).remove();
            }

        });

        // Drag & Drop Sort Taxonomy
        function sortTaxonomy() {

            let taxListElement = document.querySelector('#ymc-tax-checkboxes');

            if( taxListElement ) {

                let taxElements = taxListElement.querySelectorAll('.group-elements');

                for (let tax of taxElements) {
                    tax.draggable = true;
                }

                taxListElement.addEventListener('dragstart', (evt) => {
                    evt.target.classList.add('selected');
                });

                taxListElement.addEventListener('dragend', (evt) => {
                    evt.target.classList.remove('selected');

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
                });

                let getNextElement = (cursorPosition, currentElement) => {
                    let currentElementCoord = currentElement.getBoundingClientRect();
                    let currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;
                    return (cursorPosition < currentElementCenter) ?
                        currentElement :
                        currentElement.nextElementSibling;
                };

                taxListElement.addEventListener('dragover', (evt) => {
                    evt.preventDefault();

                    const activeElement = taxListElement.querySelector(`.selected`);

                    const currentElement = evt.target;

                    const isMoveable = activeElement !== currentElement &&
                        currentElement.classList.contains('group-elements');

                    if (!isMoveable) {
                        return;
                    }

                    const nextElement = getNextElement(evt.clientY, currentElement);

                    if (
                        nextElement &&
                        activeElement === nextElement.previousElementSibling ||
                        activeElement === nextElement
                    ) {
                        return;
                    }

                    taxListElement.insertBefore(activeElement, nextElement);
                });

            }

        }
        sortTaxonomy();


        // Drag & Drop Sort Terms
        function updateSortTerms() {

            let arrTerms = [];

            document.querySelectorAll('#ymc-terms .item-inner:not(.all-categories)').forEach((el) => {
                arrTerms.push(el.children[0].value);
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


        function sortTerms() {

            let termListElement = document.querySelector('#ymc-terms');

            if( termListElement ) {

                let termElements = termListElement.querySelectorAll('.item-inner:not(.all-categories)');

                for (let term of termElements) {
                    term.draggable = true;
                }

                termListElement.querySelectorAll('.entry-terms').forEach((el) => {

                    el.addEventListener('dragstart', (evt) => {
                        evt.target.classList.add('selected');
                    });

                    el.addEventListener('dragend', (evt) => {
                        evt.target.classList.remove('selected');
                        updateSortTerms();
                    });
                });

                let getNextElement = (cursorPosition, currentElement) => {
                    let currentElementCoord = currentElement.getBoundingClientRect();
                    let currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;
                    return (cursorPosition < currentElementCenter) ?
                        currentElement :
                        currentElement.nextElementSibling;
                };

                termListElement.querySelectorAll('.entry-terms').forEach((el) => {
                    el.addEventListener('dragover', (evt) => {
                        evt.preventDefault();

                        const activeElement = termListElement.querySelector(`.selected`);

                        const currentElement = evt.target;

                        const isMoveable = activeElement !== currentElement &&
                            currentElement.classList.contains('item-inner');

                        if (!isMoveable) {
                            return;
                        }

                        const nextElement = getNextElement(evt.clientY, currentElement);

                        if (
                            nextElement &&
                            activeElement === nextElement.previousElementSibling ||
                            activeElement === nextElement
                        ) {
                            return;
                        }

                        evt.target.parentNode.insertBefore(activeElement, nextElement);
                    });
                });
            }
        }
        sortTerms();


        // Choices Posts
        $(document).on('click','#selection-posts .choices-list .ymc-rel-item-add', function (e) {

            let postID = e.target.dataset.id;
            let titlePosts = e.target.innerText;
            e.target.classList.add('disabled');

            let valuesList = $('#selection-posts .values-list');

            valuesList.append(`<li><input type="hidden" name="ymc-choices-posts[]" value="${postID}">
					<span  class="ymc-rel-item" data-id="${postID}">${titlePosts}
                    <a href="#" class="ymc-icon-minus remove_item"></a>
                    </span></li>`);
        });

        $(document).on('click','#selection-posts .values-list .remove_item', function (e) {
            e.preventDefault();

            let postID = $(e.target).closest('.ymc-rel-item').data('id');

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

        // Set checkbox All marked
        $('#general #ymc-terms .group-term').each(function () {
            let total = $(this).find('input[type="checkbox"]').length - 1;
            let totalChecked = $(this).find('input[checked]').length;
            if(total === totalChecked) {
                $(this).find('.all-categories input[type="checkbox"]').attr('checked','checked');
            }
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

        // Set Cookie
        function setCookie(cname, cvalue, exdays) {
            let d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        // Get Cookie
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

        // Set Cookie for Tab
        $(".ymc__container-settings #ymcTab a").click(function(e) {
            let hashUrl = $(this).attr('href');
            setCookie("hashymc", hashUrl,30);
        });

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

        // Add Color Picker for all inputs
        $('.ymc-custom-color').wpColorPicker();

    });

}( jQuery ));