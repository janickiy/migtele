$('.horizontal-scroll').mCustomScrollbar({
    axis: "x",
    scrollButtons: {enable:true},
    callbacks:{
        onTotalScroll:function(){

            loadAfterScrollEnd($(this).attr('id'));

        }
    }
});

function loadAfterScrollEnd(id) {

    var $el = $('#'+id),
        $container = $el.find('.mCSB_container'),
        $preloader = makePreloader(),
        url =  $el.attr('data-next');


    if($container.hasClass('initial') || !url){
        return false;
    }else{
        $container.addClass('initial');
    }


    $container.append($preloader.show());

    $el.mCustomScrollbar("update");
    $el.mCustomScrollbar("scrollTo", "right", {
        scrollEasing: "easeOut"
    });


    setTimeout(function () {
        $.ajax({
            method: 'GET',
            url: url,
            dataType: 'html',
            success: function (response) {

                $preloader.fadeOut('slow').remove();

                var $content = $($.parseHTML(response)),
                    nextUrl = $content.filter('#next-url').text(),
                    $items = $content.filter('.item');

                $container.append($items.hide().fadeIn('slow', function () {
                    $container.removeClass('initial');
                    $el.mCustomScrollbar("scrollTo", "-=819", {
                        scrollEasing: "easeOut"
                    });
                }));

                url = nextUrl ? nextUrl : '';

                $el.attr('data-next', url);
            }

        });

    }, 300);


    function makePreloader() {

        return $('<div class="product-list__item product-list__item_preloader"><div class="preload"></div></div>');

    }

}