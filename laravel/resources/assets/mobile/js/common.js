$(function() {


    $('.load-more').click(function () {

        var url = $(this).attr('data-url'),
            $el = $(this),
            $preload = $('<li class="preload"></li>');

        $el.fadeOut();

        $('.product-list__block ul').append($preload);

        $.ajax({
            url: url,
            dataType: 'HTML'
        }).done(function (html) {

            var $products = $(html).find('.product-list__block ul li'),
                $btn = $(html).find('.load-more'),
                nextUrl = $btn.attr('data-url');

            $preload.remove();

            $('.product-list__block ul').append($products);

            if(nextUrl)
                $el.attr('data-url', nextUrl).fadeIn();

        });


        return false;
    });

    var padding = $(window).width() * 85 / 100;

    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': padding,
        'tolerance': 70,
        'touch': true

    });

    $('.toggle-button').click(function () {
        slideout.toggle();
    });


    $('.owl-carousel:not(.product-images)').owlCarousel({
        margin: 19,
        responsive: {
            0: {
                items: 3
            }
        }
    });

    $('.product-images').owlCarousel({
        margin: 19,
        responsive: {
            0: {
                items: 2
            }
        }
    });

    $('.spoiler-open').click(function () {

        if($(this).hasClass('load-more'))
            return false;

        $(this).parent().find('.spoiler').slideDown();
        $(this).parent().find('.short-text').slideUp();
        $(this).slideUp();
    });


    $('.profile-type input').change(function () {

        showFieldByProfileType();

    });

    function showFieldByProfileType() {

        var value = $('.profile-type input:checked').val(),
            $juridical = $('.for-juridical'),
            $individual = $('.for-individual');

        if(value == '0'){

            $juridical.slideDown('slow');
            $individual.slideUp('slow');


        }else{

            $juridical.slideUp('slow');
            $individual.slideDown('slow');

        }
    }

    if($('.profile-type input').length)
        showFieldByProfileType();



    var $allDeliveryInfo = $('.delivery-description').hide();

    function showDeliveryInfo(id) {

        var $info = $('.delivery-description[data-id="'+id+'"]');

        $allDeliveryInfo.slideUp();

        $info.slideDown();

    }

    $('.delivery-type input').change(function () {
        showDeliveryInfo($(this).data('id'));
        orderPriceCalculate();
    });

    showDeliveryInfo($('.delivery-type input:checked').data('id'));

    orderPriceCalculate();

    function orderPriceCalculate () {

        var delivery = $('.delivery-type input:checked').data('price'),
            $orderDelivery = $('#order-delivery-price'),
            $amount = $('#order-amount');

        delivery = delivery ? delivery : 0;

        $orderDelivery.text($.number(delivery, 0, '.', ' ' ));

        var amount = 0;

        $('.amount-value:not(#order-amount, #order-discount)').each(function () {

            var value = parseInt($(this).text().replace(' ', ''));

            amount += value;
        });

        $amount.text($.number(amount, 0, '.', ' ' ));

    }


    $('.count-minus').click(function () {
        setCount($(this), -1);
    });

    $('.count-plus').click(function () {
        setCount($(this), 1);
    });


    function setCount($el, value) {

        var $parent = $el.closest('.count'),
            $input = $parent.find('input[name="quantity"]'),
            oldValue = $input.val() ? parseInt($input.val()) : 0,
            $minus = $parent.find('.count-minus'),
            setValue = oldValue + value;


        if (setValue <= 0) {

            $minus.addClass('disabled');

        }else{
            $minus.removeClass('disabled');
        }

        if ($el.hasClass('disabled')) return false;

        $input.val(setValue);

        setTimeout(function () {

            if($input.closest('.submit-form').length){
                $input.closest('form').submit();
            }

        }, 300)

    }


    $('.search-form').submit(function () {

        var searchText = $(this).find('input[name="search_text"]').val();

        location.href = '/search/'+searchText;

        return false;
    });



    $('.open-modal').click(function(event) {

        var modal_id = $(this).attr("href");
        window.location.hash = modal_id;

        if($(this).data('product_id')){

            var $modal = $(modal_id);

            $modal.find('input[name="product_id"]').val($(this).data('product_id'));

        }


        $(this).modal({
            fadeDuration: 120
        });

        return false;

    });

    if(window.location.hash){
        $(window.location.hash).modal({
            fadeDuration: 120
        });

        if(window.location.hash == '#cart-modal'){
            display_modal_cart();
        }
    }

    if($("#alert-success").length){
        $("#alert-success").iziModal({
            icon: 'icon-check',
            title: ' ',
            headerColor: '#00af66',
            width: 600,
            timeout: 5000,
            timeoutProgressbar: true,
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOutUp',
            autoOpen: 1,
            pauseOnHover: true
        });
    }


    $(".payment-titles span").click(function () {

        var id = $(this).data('id'),
            $parent = $(this).closest('.payment-block-wrapper'),
            titles = $parent.find(".payment-titles"),
            payments = $parent.find(".payment-texts");

        payments.find('>div').hide();
        titles.find('span').removeClass('active');

        titles.find('span[data-id="'+id+'"]').addClass('active');
        payments.find('div[data-id="'+id+'"]').fadeIn('slow');

    });

    if(location.hash == '#pay'){
        $(".payment-titles span[data-id='1']").click();
    }


    /**
     * Promocodes
     */

    if($('#share-promocode').length){

        $('#share-promocode').modal({
            fadeDuration: 120
        });

    }


    $('.toolbar-cell__link__toggle').click(function () {

        var $cell = $(this).closest('.toolbar-cell');

        $cell.toggleClass('toolbar-cell__is_back');

    });


    var clipboard = new Clipboard('.toolbar-buttons__coupon_copy');

    clipboard.on('success', function(e) {
        $('.toolbar-buttons__coupon_copy .txt').text('скопировано');
    });


    $('.promocode-friend-email form').submit(function () {
        var $form = $(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize()
        }).done(function (response) {

            $form.find('.message').html('<span class="help-block success"><strong>Отправлено</strong></span>');


        }).fail(function (response) {
            $form.find('.message').html('<span class="help-block"><strong>'+response.responseJSON.email[0]+'</strong></span>');
        });

        return false;
    });


    $('.promocode-tab-link').click(function () {
        var id = $(this).data('id');

        $('.promocode-tab-content').slideUp();


        $('.promocode-tab-content[data-id="'+id+'"]').slideDown();

        return false;

    });



});
