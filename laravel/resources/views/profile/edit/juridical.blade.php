@extends('layouts.template')

@section('title', 'Мой профиль')


@section('content')

    @widget('breadcrumbs', ['type' => 'profile', 'element' => 'Мой профиль'])


    <div class="heading-2 heading-2__modify">Мой профиль</div>

    @include('modules.profile.tabs', ['selected' => 2])


    <div class="profile">

        @include('profile.edit.tabs', ['selected' => 2])

        <div class="profile-form">
            <form action="{{ url('/profile/edit/save') }}" method="POST" class="form-wrapper">

                {{ csrf_field() }}

                <input type="hidden" name="type" value="{{ \App\Model\User::JURIDICAL_TYPE }}">

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
                    'label' => 'Название организации',
                    'required' => true,
                    'field_name' => 'company_name',
                    'field_id' => 'profile-company_name',
                    'field_value' => $user->company_name,
                    'tabindex' => 6
                ])

                @include('form.row', [
                    'label' => 'ИНН/КПП',
                    'required' => true,
                    'field_name' => 'tin',
                    'field_id' => 'profile-tin',
                    'field_value' => $user->tin,
                    'tabindex' => 7
                ])

                @include('form.row', [
                    'label' => 'Юридический адрес',
                    'required' => true,
                    'field_name' => 'juridical_address',
                    'field_id' => 'profile-juridical_address',
                    'field_value' => $user->juridical_address,
                    'tabindex' => 8
                ])

                @include('form.row', [
                    'label' => 'Фактический адрес',
                    'required' => true,
                    'field_name' => 'actual_address',
                    'field_id' => 'profile-actual_address',
                    'field_value' => $user->actual_address,
                    'tabindex' => 9
                ])

                @include('form.row', [
                    'label' => 'Комментарий',
                    'required' => false,
                    'field_name' => 'comment',
                    'field_type' => 'textarea',
                    'field_id' => 'profile-comment',
                    'field_value' => $user->comment,
                    'tabindex' => 10
                ])


                <div class="row row-btn">
                    <div class="form-column__left"></div>
                    <div class="form-column__right">
                        <button tabindex="11" type="submit" class="btn">Сохранить</button>
                    </div>
                </div>



            </form>
        </div>

    </div>

    @include('profile.settings')


@endsection