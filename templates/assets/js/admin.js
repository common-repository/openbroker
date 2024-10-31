jQuery(document).ready(function($) {
    $('.select').selectstyle();
    $('.multiple-select').select2();
    $('.lightzoom').lightzoom({
        isOverlayClickClosing: true
    });

    $('body').on('click', '.add-item', function() {
        var element = $(this).closest('.items-list');
        var count = element.find('.item-content').length;

        if(count === 1 && element.find('.item-content').is(':hidden')) {
            element.find('.item-content').show();
            element.closest('.section_data').find('.head_items').show();
        } else {
            $(this).before($(element).find('.item-content:last').clone());
            $(element).find('.item-content:last').find('input').val('');
            var counter = parseInt($(element).find('.item-content:last').find('.number_element').text());

            counter++;
            $(element).find('.item-content:last').find('.number_element').text(counter);
        }
    });

    $("body").on("click",".delete_item",function(){
        var element = $(this).closest('.items-list');
        var count = element.find('.item-content').length;

        if(count === 1) {
            element.closest('.section_data').find('.head_items').hide();
            element.find('.item-content').hide();
            element.find('.item-content').find('input').val('');
            element.find('select option').removeAttr('selected').filter('[value=0]').attr('selected', true);
            element.find('.ss_dib.ss_text').text('No Product');
        } else {
            $(this).closest('.item-content').remove();
        }
    });

    $("body").on("click","a.change-table",function(){
        var table = $(this).data('table');

        $('.change-table').removeClass('active');
        $(this).addClass('active');

        $('.select-table').hide();
        $('#'+table).show();
    });

    (function() {
        $(function() {
            $.tips({
                action: 'focus',
                element: '.error',
                tooltipClass: 'error'
            });
            $.tips({
                action: 'click',
                element: '.clicktips',
                preventDefault: true
            });
            return $.tips({
                action: 'hover',
                element: '.hover',
                preventDefault: true,
                html5: false
            });
        });
    }).call(this);

    // setup before functions
    var typingTimer;
    var doneTypingInterval = 100;
    var $input = $('#search_city');

    create_shortcode();

    // on keyup, start the countdown
    $input.on('keyup', function () {
        clearTimeout(typingTimer);
        if($(this).val().length >= 3) {
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        } else if($(this).val().length === 0) {
            $('#search_area_id').val('');
            create_shortcode();
        }
    });

    // on keydown, clear the countdown
    $input.on('keydown', function () {
        clearTimeout(typingTimer);
    });

    // user is "finished typing," do something
    function doneTyping () {
        var data = {
            'action': 'load_cities',
            'search': $('#search_city').val(),
            '_wpnonce': admin.openbroker_nonce
        };

        $.ajax({
            url: admin.ajaxurl,
            data:data,
            type:'POST',
            dataType: 'json',
            success:function(data){
                if(data.length > 0) {
                    var elements_html = ''
                    $(data).each(function(i, obj) {
                        elements_html += '<div class="city-list" data-city-id="'+obj.id+'">'+obj.name+'</div>'
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

    $('body').on('click', '.city-list', function() {
        var city_id = $(this).attr('data-city-id');
        var city_name = $(this).text();
        $('#search_city').val(city_name);
        $('#search_area_id').val(city_id);
        $('#auto-city').html('');
        $('.pxp-results-filter-form').submit();
        create_shortcode();
    });

    $(document).on("click", function(event){
        var $trigger = jQuery("#auto-city.active");
        if($trigger !== event.target && !$trigger.has(event.target).length){
            $("#auto-city.active").removeClass('active');
        }
    });

    function create_shortcode() {
        var shortcode = [];
        var id;
        var value;

        $(".collections-options").find('.col-option').each(function(index) {
            if($(this).find('input').length && $(this).find('input').val().length > 0) {
                id = $(this).find('input').attr('id');
                value = $(this).find('input').val();

                shortcode.push({
                    'name': id,
                    'value': value
                });

            } else if($(this).find('select').length  && $(this).find('select').val().length > 0) {
                id = $(this).find('select').attr('id');
                value = $(this).find('select').val();

                shortcode.push({
                    'name': id,
                    'value': value
                });
            }
        });

        $(".ks-cboxtags li").each(function(index) {
            if($(this).find('input').length && $(this).find('input').val().length > 0 && $(this).find('input').is(':checked')) {
                id = $(this).find('input').val();
                value = 'true';

                shortcode.push({
                    'name': id,
                    'value': value
                });
            }
        });

        var code_shortcode = "[openbroker";
        var filters = [];
        $(shortcode).each(function(index, item) {
            filters.push(item.name+"="+item.value);
            code_shortcode = code_shortcode+" "+item.name+"='"+item.value+"'";
        });
        code_shortcode = code_shortcode + "]";

        $('.properties-list-items').css('opacity', '0.6');

        $.ajax({
            url: admin.ajaxurl,
            data: {
                'action': 'get_ajax_properties',
                'template': 'admin_properties',
                'filters': filters,
                'shortcode': code_shortcode,
                '_wpnonce': admin.openbroker_nonce
            },
            type:'POST',
            dataType: 'json',
            success:function(response) {
                if(response.status === 'true') {
                    $('.properties-list-items').html(response.content);
                    /*$('html,body').animate({
                        scrollTop: $('.properties-list-items').offset().top - 50
                    }, 1000);*/
                    $('.properties-list-items').css('opacity', '1.0');
                }
            }
        });
    }

    $('body').on('input, change', '.col-option input, .col-option select, .ks-cboxtags input', function() {
        if($(this).attr('id') !== 'search_city') {
            create_shortcode();
        }
    });

    $('body').on('click', 'button', function() {
        if($(this).hasClass('left-page-properties')) {
            var page = $('#page').val();

            if (page > 1) {
                page--;
                $('#page').val(page);
                create_shortcode();
            }
        }
    });

    $('body').on('click', 'button', function() {
        if($(this).hasClass('right-page-properties')) {
            var page = $('#page').val();
            var total_page = $(this).data('total');

            if(page < total_page) {
                page++;
                $('#page').val(page);
                create_shortcode();
            }
        }
    });
});