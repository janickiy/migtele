<!DOCTYPE html>
<html lang="ru" style="border: 0; font: inherit; font-size: 100%; height: 100%; margin: 0; padding: 0; vertical-align: baseline;">

<head>

    <meta charset="utf-8">

</head>

<body style="border: 0; font: inherit; font-family: Rubik,sans-serif; font-size: 16px; height: 100%; line-height: 1.75; margin: 0; min-width: 320px; opacity: 1; overflow-x: hidden; padding: 0; position: relative; vertical-align: baseline;">

<!--[if !mso]><!-->

<!--<![endif]-->

<div class="body" style="-webkit-box-shadow: 0 5px 5px rgba(2,3,4,.24); border: 1px solid #e3e3e3; box-shadow: 0 5px 5px rgba(2,3,4,.24); font: inherit; font-size: 100%; margin: 40px auto; padding: 0; vertical-align: baseline; width: 898px;">

    @include('emails.layouts.header')

    <div class="container" style="border: 0; font: inherit; font-size: 100%; margin: 0; padding: 0 18px 0 20px; vertical-align: baseline;">

        @yield('content')

        <div class="footer" style="border: 0; font: inherit; font-size: 100%; margin: 0; margin-top: 28px; padding: 0; text-align: center; vertical-align: baseline;">
            <div class="title" style="border: 0; font: inherit; font-size: 18px; line-height: 18px; margin: 0; padding: 0; vertical-align: baseline;">Интернет магазин Мигтеле</div>
            <div class="description" style="border: 0; font: inherit; font-size: 14px; line-height: 20px; margin: 0; margin-top: 13px; padding: 0; vertical-align: baseline;">Вы получили это писмо, потому что оформили заказ на сайте и дали разрешение на полчение писем от migtele.ru</div>
            @include('emails.component.unsubscribe')
        </div>

    </div>


</div>






</body>
</html>
