

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
