$('.wishlist-form').submit(function () {

    var $button = $(this).find('button'),
        $form = $(this);


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $(this).attr('action'),
        method: 'post',
        data: $(this).serialize(),
        dataType: 'json'
    }).done(function (data) {

        $('.toolbar-link-bookmarks .counter').text(data);

        if($button.hasClass('in-bookmark')){
            $button.text('').attr('class', 'delete');
            $form.attr('action', '/wishlist/delete');
        }else{
            $button.text('В закладки').attr('class', 'in-bookmark');
            $form.attr('action', '/wishlist/add');
        }


    });


    return false;

});