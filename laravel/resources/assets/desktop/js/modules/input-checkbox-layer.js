

$('#registration-delivery_is_actual').change(function () {
    setActive($('#registration-juridical_delivery_address'), $(this))
});

$('#order-company_name_is_actual').change(function () {
    setActive($('#order-juridical_delivery_company_name'), $(this));
});

setActive($('#order-juridical_delivery_company_name'), $('#order-company_name_is_actual'));
setActive($('#registration-juridical_delivery_address'), $('#registration-delivery_is_actual'));

function setActive($el, $checkbox) {
    if($checkbox.is(':checked')){
        $el.removeClass('active');
    }else{
        $el.addClass('active');
    }

}
