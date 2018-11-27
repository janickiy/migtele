@extends('layouts.template')

@section('content')


    @widget('breadcrumbs', ['type' => 'wishlist'])

    <h1 class="main-title">Закладки</h1>

    @include('components.wishlist')

    <div id="our-advantages__bookmarks">
        @widget('advantages')
    </div>



@endsection