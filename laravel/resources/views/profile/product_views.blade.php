@extends('layouts.template')


@section('content')

    @widget('breadcrumbs', ['type' => 'profile', 'element' => 'Просмотрено'])

    <div class="heading-2 heading-2__modify">Просмотрено</div>

    @include('modules.profile.tabs', ['selected' => '4'])

    @include('components.product_views')



@endsection