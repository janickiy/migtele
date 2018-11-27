$(function () {

    var $userSelect = $('#select-user-type');



    function showFieldByType() {

        var type = parseInt($userSelect.val()),
            $individual = $('.field-individual'),
            $juridical = $('.field-juridical');

        if(type == 1){
            $individual.slideDown('slow');
            $juridical.slideUp('slow');
        }else{
            $individual.slideUp('slow');
            $juridical.slideDown('slow');
        }

    }


    $userSelect.change(function () {
        showFieldByType()
    });

    showFieldByType()


});