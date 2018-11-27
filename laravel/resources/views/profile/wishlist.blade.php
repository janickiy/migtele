@extends('layouts.template')

@section('content')

    @widget('breadcrumbs', ['type' => 'profile', 'element' => 'Мои закладки'])

    <div class="heading-2 heading-2__modify">Закладки</div>

    @include('modules.profile.tabs', ['selected' => '3'])

    @include('components.wishlist')



@endsection