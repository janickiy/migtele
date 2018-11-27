
$('.profile-type input').change(function () {

    profileShow();

});

profileShow();

function profileShow() {

    var value = $('.profile-type input:checked').val(),
        $juridical = $('.for-juridical'),
        $individual = $('.for-individual');

    if(value === '0'){

        $juridical.slideDown('slow');
        $individual.slideUp('slow');


    }else{

        $juridical.slideUp('slow');
        $individual.slideDown('slow');

    }

}