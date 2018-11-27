$('.product-images__preview').click(function (e) {

    var $parent = $(this).closest('.product-images'),
        $view = $parent.find('.product-images__single'),
        $single = $view.find('img'),
        imgSrc = $(this).data('img'),
        id = $(this).data('id');

    $view.attr('data-iziModal-open', '#gallery-modal-'+id);

    if (imgSrc)
        $single.attr('src', imgSrc);

    e.preventDefault();

});


if($(".gallery-modal").length){
    $(".gallery-modal").iziModal({
        width: 700,
        group: 'media',
        loop: true
    });
}