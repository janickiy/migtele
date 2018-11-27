$('.open-modal').click(function(event) {

    var modal_id = $(this).attr("href");
    window.location.hash = modal_id;

    if($(this).data('product_id')){

        var $modal = $(modal_id);

        $modal.find('input[name="product_id"]').val($(this).data('product_id'));

    }else{

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

    if(window.location.hash === '#cart-modal'){
        display_modal_cart();
    }
}