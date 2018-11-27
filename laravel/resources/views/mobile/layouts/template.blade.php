<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">

    <title>@yield('title', _setting('title'))</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="keywords" content="@yield('keywords', _setting('keywords'))">
    <meta name="description" content="@yield('description', _setting('descriptions'))">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    @foreach(\App\Model\Counter::getTop() as $counter)
        {!! $counter->html  !!}
    @endforeach

    <link rel="shortcut icon" href="{{ asset('static/img/favicon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('static/mobile/css/main.css?v.1.1') }}">

    {{ app('captcha')->multiple() }}

</head>
<body itemscope itemtype="http://schema.org/WebPage">
@empty($itempropTitle)
    <meta itemprop="name" content="{{ _setting('title') }}">
@endempty

@yield('before-header')

@include('mobile.layouts.nav')

<main id="panel">

    @include('mobile.layouts.header')

    @yield('content')


    @include('mobile.layouts.footer')

    @widget('share_promocode')

    @if(session('success_message') || session('status'))
        <div id="alert-success">
            <div class="alert-success-message">
                {{ session('status') }}
                {{ session('success_message') }}
            </div>
        </div>
    @endif

</main>

<script src="{{ asset('static/mobile/js/libs.js?v.1.0') }}"></script>
<script src="{{ asset('static/mobile/js/common.js?v.1.2') }}"></script>
</body>
</html>