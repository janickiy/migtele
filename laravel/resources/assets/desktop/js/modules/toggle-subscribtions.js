function toggleSubscriptions() {

    if($('#order-register:checked').length){
        $('.register-subscriptions').slideDown('slow');
    }else{
        $('.register-subscriptions').slideUp('slow');
    }
}

$('#order-register').change(function () {
    toggleSubscriptions();
});


toggleSubscriptions();