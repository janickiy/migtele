$('.link-disable').click(function (e) {
    e.preventDefault();
    return false;
});


$('.main-slider').owlCarousel({
    items: 1,
    autoplay: true,
    autoplayHoverPause: true,
    dots: true
});


setTimeout(function() {
    $('select').styler();
}, 100);


$('.pagination-page_size select').change(function () {
    var $form = $(this).closest('form');
    $form.submit();
});


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







