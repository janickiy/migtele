@extends('layouts.template')

@section('title', 'Мой профиль')


@section('content')

    @widget('breadcrumbs', ['type' => 'profile', 'element' => 'Мой профиль'])


    <div class="heading-2 heading-2__modify">Мой профиль</div>

    @include('modules.profile.tabs', ['selected' => 2])


    <div class="profile">

        @include('profile.edit.tabs', ['selected' => 1])

        <div class="profile-form">
            <form action="{{ url('/profile/edit/save') }}" method="POST" class="form-wrapper">

                {{ csrf_field() }}

                <input type="hidden" name="type" value="{{ \App\Model\User::INDIVIDUAL_TYPE }}">

                @include('form.row', [
                    'label' => 'ФИО',
                    'required' => true,
                    'field_name' => 'name',
                    'field_id' => 'profile-name',
                    'field_value' => $user->name,
                    'tabindex' => 1
                ])


                @include('form.row_multiple', [
                    'label' => 'Телефон',
                    'required' => true,
                    'field_name' => 'phones',
                    'field_id' => 'profile-phones',
                    'fields' => $user->phones,
                    'tabindex' => 3
                ])

                @include('form.row', [
                    'label' => 'E-mail',
                    'required' => true,
                    'field_name' => 'email',
                    'field_id' => 'profile-email',
                    'field_value' => $user->email,
                    'tabindex' => 4
                ])


                @include('form.row_multiple', [
                    'label' => 'Адрес доставки',
                    'required' => true,
                    'field_name' => 'delivery_addresses',
                    'field_id' => 'profile-delivery_addresses',
                    'fields' => $user->delivery_addresses,
                    'tabindex' => 5
                ])

                @include('form.row', [
                    'label' => 'Паспорт серия, номер',
                    'required' => false,
                    'field_name' => 'passport',
                    'field_id' => 'profile-passport',
                    'field_value' => $user->passport,
                    'description' => _setting('passport_field_description'),
                    'tabindex' => 6
                ])

                @include('form.row', [
                    'label' => 'Комментарий',
                    'required' => false,
                    'field_name' => 'comment',
                    'field_type' => 'textarea',
                    'field_id' => 'profile-comment',
                    'field_value' => $user->comment,
                    'tabindex' => 7
                ])


                <div class="row row-btn">
                    <div class="form-column__left"></div>
                    <div class="form-column__right">
                        <button tabindex="8" type="submit" class="btn">Сохранить</button>
                    </div>
                </div>



            </form>
        </div>

    </div>

    @include('profile.settings')

@endsection