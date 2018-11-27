@extends('layouts.template')


@section('content')

    @widget('breadcrumbs', ['type' => 'profile', 'element' => 'Мои обращения'])

    <div class="heading-2 heading-2__modify">Мои обращения</div>

    @include('modules.profile.tabs', ['selected' => '5'])

    @include('components.feedback.index')


@endsection