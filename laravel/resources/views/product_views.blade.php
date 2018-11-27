@extends('layouts.template')

@section('content')


    @widget('breadcrumbs', ['type' => 'product_views'])

    @include('components.product_views')

    <div id="our-advantages__bookmarks">
        @widget('advantages')
    </div>



@endsection