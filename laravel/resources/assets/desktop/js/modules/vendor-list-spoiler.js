
vendorListSpoiler();

function vendorListSpoiler() {

    var $vendorWrapper = $('.product-vendor__list'),
        $showMore = $('#vendor-list-show-more');


    if ($vendorWrapper.find('a').length > 16) {
        $showMore.show();
    }

    $showMore.click(function () {
        $vendorWrapper.css({
            maxHeight: Math.ceil(($vendorWrapper.find('a').length / 8)) * 86
        });
        $(this).hide();

        return false;
    });

}
