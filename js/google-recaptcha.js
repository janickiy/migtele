var verifyCallback = function(response) {
    alert(response);
};
var your_site_key = '6Ld2zhQUAAAAAO-xXQV-AI6KJXPRbJosPUTw_ngn';
var onloadCallback = function() {
    // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
    // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
    if(document.getElementById('google-captcha-1')){
       grecaptcha.render(document.getElementById('google-captcha-1'), {
            'sitekey' : your_site_key
        });
    }
    // console.log(document.getElementById('google-captcha-2'));
    if(document.getElementById('google-captcha-2')){
        grecaptcha.render(document.getElementById('google-captcha-2'), {
            'sitekey' : your_site_key
        });
    }
    if(document.getElementById('google-captcha-3')){
        grecaptcha.render(document.getElementById('google-captcha-3'), {
            'sitekey' : your_site_key
        });
    }
};