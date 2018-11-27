<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="utf-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{!! Meta::get('title') !!}</title>
    <meta property="og:type" content="website" />

    {!! Meta::tag('robots') !!}

    {!! Meta::tag('url', Request::url()) !!}
    {!! Meta::tag('locale', 'ru_RU') !!}

    {!! Meta::tag('title') !!}
    {!! Meta::tag('description') !!}
    {!! Meta::tag('keywords') !!}

    {!! Meta::tag('image', asset('static/desktop/img/logo.png')) !!}

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="user-scalable=no" />

    @foreach(\App\Model\Counter::getTop() as $counter)
        {!! $counter->html  !!}
    @endforeach

    <link rel="shortcut icon" href="{{ asset('static/img/favicon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('static/desktop/css/app.css?v1.2.9.6') }}">

    {{ app('captcha')->multiple() }}

</head>

<body{!! $bodyAttr or '' !!}>

@yield('before-header')

@include('layouts.header')


<section class="main">
    <div class="container">
        <div class="row">
            <div class="left-side">

                @include('layouts.sidebar')

            </div>
            <div class="right-side">

                @yield('content')

            </div>
        </div>
    </div>
</section>


@include('layouts.footer')

@include('layouts.modals')

@if(session('success_message') || session('status'))
    <div id="alert-success">
        <div class="alert-success-message">
            {{ session('status') }}
            {{ session('success_message') }}
        </div>
    </div>
@endif

@widget('share_promocode')

@yield('before-script')

<script src="{{ asset('/static/desktop/js/libs.js') }}"></script>
<script src="{{ asset('/static/desktop/js/app.js?1.2.6') }}"></script>

{!! app('captcha')->displayJs() !!}
{!! app('captcha')->displayMultiple() !!}

</body>
</html>