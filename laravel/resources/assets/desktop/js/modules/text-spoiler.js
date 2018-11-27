
$('.main-description__spoiler_open').click(function () {

    var $parent = $(this).closest('.main-description'),
        $short = $parent.find('.text-close');


    $(this).hide();
    $short.removeClass('text-close');


    return false;

});