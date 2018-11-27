makeSlider('product-price-slider');


function makeSlider(selector) {

    if (!$('#'+selector).length) return false;

    var $el = $('#'+selector),
        $parent = $el.parent(),
        startVal = $el.data('start'),
        endVal = $el.data('end'),
        min = $el.data('min'),
        max = $el.data('max'),
        $from = $parent.find('input[name="from"]'),
        $to = $parent.find('input[name="to"]'),
        html5Slider = document.getElementById(selector);

    var anum = /^\-?\d+(\.?\d+)?$/;

    if(!anum.test(startVal) || !anum.test(endVal) || !anum.test(min) || !anum.test(max)) return false;


    noUiSlider.create(html5Slider, {
        range:
            {
                'min': min,
                'max': max
            },
        start: [startVal, endVal],
        connect: true, // Display a colored bar between the handles
        behaviour: 'tap-drag',
        step: 1,
        pips: false
    }).on('update', function( values, handle ) {

        $from.val(parseInt(values[0]));
        $to.val(parseInt(values[1]));
    });

    html5Slider.noUiSlider.on('set', function () {
        formSend();
    });

    $from.change(function () {
        html5Slider.noUiSlider.set([$(this).val(), null]);
        formSend()
    });

    $to.change(function () {
        html5Slider.noUiSlider.set([null, $(this).val()]);
        formSend()
    });

    function formSend() {
        $parent.submit();
    }

}