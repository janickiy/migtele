
$('.quick-order').click(function () {

    var product_id = $(this).data('id'),
        $modal = $('#quick-order');

    if(product_id)
        $modal.find('input[name="product_id"]').val(product_id);

    $modal.modal({
        fadeDuration: 120
    });

    return false;

});