$('.count-input a').click(function () {

    if($(this).hasClass('disabled')) return false;

    click_change_count_product_cart($(this));

    return false;

});

$('#cart-modal').delegate('.count-input a', 'click', function () {

    if($(this).hasClass('disabled')) return false;

    click_change_count_product_cart($(this));

    return false;
});

function click_change_count_product_cart($el) {
    var value = $el.hasClass('count-minus') ? -1 : 1,
        $parent = $el.closest('.count-input'),
        $input = $parent.find('input[name="quantity"]'),
        count = parseInt($input.val()),
        $form = $parent.find('form');


    if(value < 0 && count == 1){
        return false;
    }

    $input.val(count + value);

    send_change_count($form);

    return false;
}

function send_change_count($form) {

    if(!$form.hasClass('count-modal-cart')){
        $form.submit();
        return false;
    }

    var $input = $form.find('input[name="quantity"]'),
        $links = $('.count-input a'),
        product_id = $form.find('input[name="product_id"]').val(),
        quantity = $input.val();

    $links.addClass('disabled');

    $input.prop('disabled', true);

    update_modal_cart(product_id, quantity);

}

function inputs_change_qunatity_product_cart($el) {
    var count = $el.val(),
        $parent = $el.closest('.count-input'),
        $form = $parent.find('form');

    if(!$.isNumeric(count) || count <1){

        $el.val(1);

        return false;
    }

    send_change_count($form);

}

$('#cart-modal').delegate('.count-input input[name="quantity"]', 'change', function () {
    inputs_change_qunatity_product_cart($(this));
});

$('.count-input input[name="quantity"]').change(function () {

    inputs_change_qunatity_product_cart($(this));

});



$('.add-cart').click(function () {

    var product_id = $(this).data('id');

    if(!product_id) return false;

    display_modal_cart(product_id);

});

function display_modal_cart(product_id) {

    var $modal = $('#cart-modal');



    window.location.hash = 'cart-modal';

    $modal.modal({
        fadeDuration: 120
    });


    update_modal_cart(product_id);


}

function update_modal_cart(product_id, quantity){

    var $modal = $('#cart-modal'),
        $description = $modal.find('.modal-description'),
        $title = $modal.find('.modal-title'),
        $container = $modal.find('.modal-content'),
        $preloader = $('<div class="preload"></div>');

    quantity = quantity ? quantity : 0;
    product_id = product_id ? product_id : 0;


    $container.empty();

    $container.append($preloader.hide().fadeIn());

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/cart/add',
        method: 'POST',
        data: {product_id: product_id, quantity: quantity}
    }).done(function (response) {

        $description.html($(response).find('.modal-description').html());
        $title.html($(response).find('.modal-title').html());

        $preloader.fadeOut(function () {

            $container.append($(response).find('.modal-cart'));

        });

        update_cart();

    }).fail(function () {
        alert('Возникла ошибка на сервере. Повторите позднее.')
    });

}

function update_cart() {

    $.ajax({
        method: 'GET',
        url: '/cart/info',
        dataType: 'JSON',
        success: function (response) {

            $('.header-line__menu_cart .description .total').text(response.total);
            $('.header-line__menu_cart .badge-count').text(response.count);

            $('.toolbar-link-cart .counter').text(response.count);
            $('.toolbar-link-cart .price').html(response.total + ' <i class="rub">у</i>');

        }

    });

}
