VirtualSelect.init({
    ele: 'select',
    hideClearButton: true,
    showDropboxAsPopup: false,
    autofocus: false
});

jQuery(document).ready(function ($) {

    // setup before functions
    var typingTimer;
    var doneTypingInterval = 100;

    // on keyup, start the countdown
    $('body').on('keyup', 'input', function () {
        if ($(this).attr('id') === 'search_city') {
            clearTimeout(typingTimer);
            if ($(this).val().length >= 3) {
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            } else if ($(this).val().length === 0) {
                $('#search_area_id').val('');
                //get_ajax_properties_filter();
            }
        }
    });

    // on keydown, clear the countdown
    $('body').on('keydown', 'input', function () {
        if ($(this).attr('id') === 'search_city') {
            clearTimeout(typingTimer);
        }
    });

    // user is "finished typing," do something
    function doneTyping() {
        var data = {
            'action': 'load_cities',
            'search': $('#search_city').val(),
            '_wpnonce': admin.openbroker_nonce
        };

        $.ajax({
            url: admin.ajaxurl,
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    var elements_html = ''
                    $(data).each(function (i, obj) {
                        elements_html += '<div class="city-list" data-city-id="' + obj.id + '">' + obj.name + '</div>'
                    });
                    $('#auto-city').html(elements_html);
                    $('#auto-city').addClass('active');
                } else {
                    $('#auto-city').addClass('active');
                    $('#auto-city').html('No city found by this name');
                }
            }
        });
    }

    $('body').on('click', '.city-list', function () {
        var city_id = $(this).attr('data-city-id');
        var city_name = $(this).text();
        $('#search_city').val(city_name);
        $('#search_area_id').val(city_id);
        $('#auto-city').html('');
        //get_ajax_properties_filter();
    });

    $(document).on("click", function (event) {
        var $trigger = jQuery("#auto-city.active");
        if ($trigger !== event.target && !$trigger.has(event.target).length) {
            $("#auto-city.active").removeClass('active');
        }
    });

    if ($('.rslides').length > 0) {
        $(".rslides").responsiveSlides({
            /*
             auto: false,
             pager: true,
             manualControls: '#slider-pager',
             */
            auto: false,
            // pager: true,
            nav: true,
            namespace: "large-btns"

        });

        setTimeout(function () {
            var divHeight = $('.rslides').height();
            $('#slider-pager').css('height', divHeight + 'px');
        }, 500);
    }

    if ($("#pagination-settings").length > 0) {
        // get_ajax_properties();
    }

    function get_ajax_properties() {
        var shortcode = [];
        var id;
        var value;

        $("#pagination-settings input").each(function (index) {
            if ($(this).val().length > 0) {
                id = $(this).data('id');
                value = $(this).val();

                shortcode.push({
                    'name': id,
                    'value': value
                });
            }
        });

        send_request(shortcode);
    }

    function get_ajax_properties_filter() {
        var shortcode = [];
        var id;
        var value;

        $(".collections-options").find('.col-option').each(function (index) {
            if ($(this).find('input').length && $(this).find('input').val().length > 0) {
                id = $(this).find('input').attr('id');
                if (id === undefined) {
                    id = $(this).find('input').attr('name');
                }
                value = $(this).find('input').val();

                shortcode.push({
                    'name': id,
                    'value': value
                });

            } else if ($(this).find('select').length && $(this).find('select').val().length > 0) {
                id = $(this).find('select').attr('id');
                if (id === undefined) {
                    id = $(this).find('input').attr('name');
                }
                value = $(this).find('select').val();

                shortcode.push({
                    'name': id,
                    'value': value
                });
            }
        });

        $(".ks-cboxtags li").each(function (index) {
            if ($(this).find('input').length && $(this).find('input').val().length > 0 && $(this).find('input').is(':checked')) {
                id = $(this).find('input').val();
                value = 'true';

                shortcode.push({
                    'name': id,
                    'value': value
                });
            }
        });

        send_request(shortcode);
    }
    // New Code - 06-07-23
    // Search should be when User click on button
    $(".btnSearch").on("click", function () {
        get_ajax_properties_filter();
    });

    /*
    * Working code, if User change anything in search, it will fetch results
    $('body').on('input, change', '.col-option input, .col-option select, .ks-cboxtags input', function() {
        if($(this).attr('id') !== 'search_city') {
            get_ajax_properties_filter();
        }
    });
    */

    function send_request(shortcode) {
        var filters = [];
        $(shortcode).each(function (index, item) {
            filters.push(item.name + "=" + item.value);
        });

        $('.properties-list-items').css('opacity', '0.6');
        $('.collections-filters').css('opacity', '0.3');

        $.ajax({
            url: admin.ajaxurl,
            data: {
                'action': 'get_ajax_properties',
                'template': 'only_properties',
                'filters': filters,
                '_wpnonce': admin.openbroker_nonce
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {

                if (response.status === 'true') {
                    $('.properties-list-items').html(response.content);
                    // $('.collections-table').html(response.search);
                    /*$('html,body').animate({
                        scrollTop: $('.properties-list-items').offset().top - 50
                    }, 1000);*/
                    $('.properties-list-items').css('opacity', '1.0');
                    $('.collections-filters').css('opacity', '1.0');
                }
            }
        });
    }


    $('body').on('click', 'button', function () {
        if ($(this).hasClass('left-page-properties')) {
            var page = $(this).data('current');

            if (page > 1) {
                page--;

                $("#pagination-settings input").each(function (index) {
                    if ($(this).data('id') === 'page') {
                        $(this).val(page);
                    }
                });

                get_ajax_properties();
            }
        }
    });

    $('body').on('click', '#send-to-agency', function () {
        $('.send-agency-modal').addClass('active');
    });

    $('body').on('click', '#close-agency-modal', function () {
        $('.send-agency-modal').removeClass('active');
    });

    $('body').on('click', '#send-modal-agency', function () {
        var btn = $(this);
        var btnTxt = btn.html();


        $('.modal-form input').removeClass('invalid-input');
        $('.modal-form textarea').removeClass('invalid-input');

        var firstname_agency = $('#firstname-agency').val();
        var lastname_agency = $('#lastname-agency').val();
        var email_agency = $("#email-agency").val();
        var phone_agency = $('#phone-agency').val();
        var message_agency = $('#message-agency').val();
        var houseid_agency = $('#houseid_agency').val();

        if (firstname_agency.length === 0) {
            $('#firstname-agency').addClass('invalid-input');
            return false
        }
        if (lastname_agency.length === 0) {
            $('#lastname-agency').addClass('invalid-input');
            return false
        }

        var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        if (!pattern.test(email_agency)) {
            $('#email-agency').addClass('invalid-input');
            return false
        }
        if (phone_agency.length === 0) {
            $('#phone-agency').addClass('invalid-input');
            return false
        }
        if (message_agency.length === 0) {
            $('#message-agency').addClass('invalid-input');
            return false
        }
        btn.html("Processing...");
        $.ajax({
            url: admin.ajaxurl,
            data: {
                'action': 'send_form_agency',
                'firstname_agency': firstname_agency,
                'lastname_agency': lastname_agency,
                'email_agency': email_agency,
                'phone_agency': phone_agency,
                'message_agency': message_agency,
                'houseid_agency': houseid_agency,
                '_wpnonce': admin.openbroker_nonce
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'true') {
                    $('.message-sended').show();
                    setTimeout(function () {
                        $('#send-agency-form input').val('');
                        $('#send-agency-form input').removeClass('invalid-input');
                        $('#send-agency-form textarea').removeClass('invalid-input');
                        $('.send-agency-modal').removeClass('active');
                        $('.message-sended').hide();
                    }, 5000);
                }
                btn.html(btnTxt);
            }
        });
    });

    $('body').on('click', 'button', function () {
        if ($(this).hasClass('right-page-properties')) {

            var page = $(this).data('current');
            var total_page = $(this).data('total');

            if (page < total_page) {
                page++;
                $("#pagination-settings input").each(function (index) {

                    if ($(this).data('id') === 'page') {
                        $(this).val(page);
                    }

                });

                get_ajax_properties();
            }
        }
    });
});














