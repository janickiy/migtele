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



$('.toolbar-buttons__vk_save_wall').click(function () {

    var url  = 'http://vk.com/share.php?';
    url += 'url='          + encodeURIComponent($(this).data('url'));
    url += '&noparse=true';

    window.open(url,'','toolbar=0,status=0,width=626,height=436');
});


// Set the date we're counting down to

var countDownDate = new Date($('.toolbar-expired__countdown').data('date')).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    countDownTick(days, $('#expired-days-1'), $('#expired-days-2'));
    countDownTick(hours, $('#expired-hours-1'), $('#expired-hours-2'));
    countDownTick(minutes, $('#expired-minutes-1'), $('#expired-minutes-2'));
    countDownTick(seconds, $('#expired-seconds-1'), $('#expired-seconds-2'));

    // If the count down is finished, write some text
    if (distance < 0) {
        clearInterval(x);
        $('.toolbar-expired__countdown').text('Время акции истекло');
    }

}, 1000);


function countDownTick(value, $first, $second) {

    value = value.toString();

    var first = value.charAt(1) ? value.charAt(0) : '0',
        second = value.charAt(1) ? value.charAt(1) : value.charAt(0);


    $first.text(first);
    $second.text(second);
}


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