
var allPanels = $('.accordion > .text').hide();

$('.accordion > .title > h2').click(function() {
    $('.accordion > .title').removeClass('open');
    $(this).parent().addClass('open');
    allPanels.slideUp();
    $(this).parent().next().slideDown();
    return false;
});
