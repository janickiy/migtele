
$('.form-multiple__add').click(function () {

    var $parent = $(this).closest('.form-multiple'),
        $inputs = $parent.find('.form-multiple__input'),
        $input = $inputs.find('.form-multiple__item').first(),
        $clone = $input.clone();

    $clone.find('input').val('');

    $inputs.append($clone);


    return false;

});

$('form').delegate('.form-multiple__delete', 'click', function () {

    $(this).closest('.form-multiple__item').remove();

    return false;

});