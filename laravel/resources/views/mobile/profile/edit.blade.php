@extends('mobile.layouts.template')

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Главная',
            'url' => '/'
    ])

    <div class="container">

        <div class="product-list__block">

            @include('mobile.profile.tabs', ['selected' => 'edit'])

            <div class="heading-1">Профиль</div>

            <form action="{{ url('/profile/edit/save') }}" method="POST" class="form-wrapper">

                {{ csrf_field() }}

                @include('mobile.form.type', ['label' => 'Тип аккаунта'])




                <div class="form-group">
                    <label for="profile-name" class="label">ФИО<span>*</span></label>
                    @include('form.input', [
                        'field_name' => 'name',
                        'field_value' =>  Auth::user() ? Auth::user()->name : '',
                        'field_id' => 'profile-name',
                        'tabindex' => 2,
                        'errors' => $errors
                    ])
                </div>

                <div class="form-group">
                    <label for="profile-phone" class="label">Телефон<span>*</span></label>
                    @include('form.input', [
                        'field_name' => 'phones[0]',
                        'field_value' =>  old('phones')[0] ? old('phones')[0] : Auth::user()->phones[0],
                        'field_id' => 'profile-phone',
                        'error_name' => 'phones.0',
                        'tabindex' => 3,
                        'errors' => $errors
                    ])
                </div>

                <div class="form-group">
                    <label for="profile-email" class="label">E-mail<span>*</span></label>
                    @include('form.input', [
                        'field_name' => 'email',
                        'field_value' =>  Auth::user() ? Auth::user()->email : '',
                        'field_id' => 'profile-email',
                        'tabindex' => 4,
                        'errors' => $errors
                    ])
                </div>


                <div class="form-group">
                    <label for="profile-email" class="label">Адрес доставки<span>*</span></label>
                    @include('form.input', [
                        'field_name' => 'delivery_addresses[0]',
                        'field_value' =>  old('delivery_addresses')[0] ? old('delivery_addresses')[0] : Auth::user()->delivery_addresses[0],
                        'field_id' => 'profile-delivery_addresses',
                        'error_name' => 'delivery_addresses.0',
                        'tabindex' => 5,
                        'errors' => $errors
                    ])
                </div>

                <div class="form-group for-individual">
                    <label for="profile-passport" class="label">Паспорт серия, номер</label>
                    @include('form.input', [
                        'field_name' => 'passport',
                        'field_value' =>  Auth::user() ? Auth::user()->passport : '',
                        'field_id' => 'profile-passport',
                        'tabindex' => 6,
                        'errors' => $errors
                    ])
                </div>

                <div class="form-group for-juridical">
                    <label class="label">Название компании<span>*</span></label>
                    @include('form.input', [
                        'field_name' => 'company_name',
                        'field_value' =>  Auth::user() ? Auth::user()->company_name : '',
                        'field_id' => 'profile-company_name',
                        'tabindex' => 7,
                        'errors' => $errors
                    ])
                </div>

                <div class="form-group for-juridical">
                    <label class="label">ИНН/КПП<span>*</span></label>
                    @include('form.input', [
                        'field_name' => 'tin',
                        'field_value' =>  Auth::user() ? Auth::user()->tin : '',
                        'field_id' => 'profile-tin',
                        'tabindex' => 8,
                        'errors' => $errors
                    ])
                </div>

                <div class="form-group for-juridical">
                    <label for="profile-passport" class="label">Юридический адрес</label>
                    @include('form.input', [
                        'field_name' => 'juridical_address',
                        'field_value' =>  Auth::user() ? Auth::user()->juridical_address : '',
                        'field_id' => 'profile-juridical_address',
                        'tabindex' => 9,
                        'errors' => $errors
                    ])
                </div>

                <div class="form-group for-juridical">
                    <label for="profile-passport" class="label">Фактический адрес</label>
                    @include('form.input', [
                        'field_name' => 'actual_address',
                        'field_value' =>  Auth::user() ? Auth::user()->actual_address : '',
                        'field_id' => 'profile-actual_address',
                        'tabindex' => 10,
                        'errors' => $errors
                    ])
                </div>

                <div class="form-group">
                    <label for="profile-comment" class="label">Комментарий</label>
                    @include('form.textarea', [
                        'field_name' => 'comment',
                        'field_value' =>  Auth::user() ? Auth::user()->comment : '',
                        'field_id' => 'profile-comment',
                        'tabindex' => 10,
                        'errors' => $errors
                    ])
                </div>


                <div class="profile-button">
                    <button type="submit" class="btn">Сохранить</button>
                </div>
            </form>


        </div>

    </div>




@endsection