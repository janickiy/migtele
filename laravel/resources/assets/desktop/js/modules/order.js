$(function () {



    var $allDeliveryInfo = $('.delivery-info').hide();

    function showDeliveryInfo(id) {

        var $info = $('.delivery-info[data-id="'+id+'"]');

        $allDeliveryInfo.slideUp();

        $info.slideDown(function () {
            initMap();
        });

    }

    $('.delivery-type input').change(function () {
        showDeliveryInfo($(this).data('id'));
        orderPriceCalculate();
    });

    showDeliveryInfo($('.delivery-type input:checked').data('id'));





    var $deliveryCompanyList = $('.delivery-select-company');


    function deliveryCustomCompanyFieldShow() {
        var val = $deliveryCompanyList.find('input:checked').val(),
            $field = $('.delivery-custom_company');

        if(val == 'custom'){
            $field.slideDown('slow');
        }else{
            $field.slideUp('slow');
        }

    }

    if($deliveryCompanyList.length)
        deliveryCustomCompanyFieldShow();

    $deliveryCompanyList.change(function () {
        deliveryCustomCompanyFieldShow();
    });


    var $all_description = $('.payment-description .description').hide();

    function showPaymentDescription(id) {
        var $radio = $('.payment-type input[data-id="'+id+'"]'),
            $description = $('.payment-description .description[data-id="'+id+'"]');

        if($description.data('in_margin')){
            $description.css({
                marginLeft: $radio.position().left
            })
        }

        $all_description.slideUp();

        $description.slideDown();

    }

    $('.payment-type input').change(function () {
        showPaymentDescription($(this).data('id'));
    });

    showPaymentDescription($('.payment-type input:checked').data('id'));



    if($('#order-delivery-price').length)
        orderPriceCalculate();

    function orderPriceCalculate () {

        var re = new RegExp(' ', 'g');

        var delivery = $('.delivery-type input:checked').data('price'),
            $orderDelivery = $('#order-delivery-price'),
            discount = parseInt(($('#order-discount').text().replace(re, ''))),
            withoutDiscount = parseInt(($('#order-amount-without-discount').text().replace(re, ''))),
            $amount = $('#order-amount');


        if($('.delivery-type input:checked').data('type') == 'in_russia'){
            $('#order-delivery-price-prefix').show();
        }else{
            $('#order-delivery-price-prefix').hide();
        }


        delivery = delivery ? delivery : 0;

        $orderDelivery.text($.number(delivery, 0, '.', ' ' ));

        var amount = withoutDiscount - discount + delivery;

        $amount.text($.number(amount, 0, '.', ' ' ));

    }

});


function initMap() {

    $('.map').each(function () {
        var uluru = {lat: $(this).data('lat'), lng: $(this).data('lng')};
        var map = new google.maps.Map(document.getElementById($(this).attr('id')), {
            zoom: 16,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });

        var input = $(this).data('input'),
            textarea = $(this).data('textarea');

        if (input){
            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);

                var coordinate = event.latLng.lat()+','+event.latLng.lng();

                $(input).val(coordinate);

                if(textarea){
                    $.ajax({
                        url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+coordinate+'&key=AIzaSyCVnGHkA62mpRGnw6l8Sry23_0Mh_mV4eM&language=ru',
                        method: 'GET',
                        dataType: 'json'
                    }).done(function (response) {
                        if(response.status){
                            if(response.results.length){
                                $(textarea).val(response.results[0].formatted_address);
                            }else{
                                $(textarea).val('Адрес не определен');
                            }
                        }
                    })
                }

            });
        }

        if (textarea){

            var timeout;

            $(textarea).on("keyup", function(e){
                var val = $(this).val();

                clearTimeout(timeout);

                timeout = setTimeout(function () {

                    $.ajax({
                        url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+val+'&key=AIzaSyCVnGHkA62mpRGnw6l8Sry23_0Mh_mV4eM&language=ru',
                        method: 'GET',
                        dataType: 'json'
                    }).done(function (response) {
                        if(response.status){
                            if(response.results.length){
                                map.setCenter(response.results[0].geometry.location);
                                marker.setPosition(response.results[0].geometry.location);
                            }
                        }
                    })

                }, 1000);


            });
        }

    });


}

