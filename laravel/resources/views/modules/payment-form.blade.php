<form action="{{ url('/payment-in-process') }}" method="POST" class="form-wrapper">

    {{ csrf_field() }}


    @include('form.row', [
        'label' => 'ФИО',
        'required' => true,
        'field_name' => 'name',
        'field_id' => 'payment-name',
        'field_value' =>  Auth::user() ? Auth::user()->name : '',
        'tabindex' => 1,
        'errors' => $errors->payment
    ])

    @include('form.row', [
        'label' => 'Телефон',
        'required' => true,
        'field_name' => 'phone',
        'field_id' => 'payment-phone',
        'field_value' =>  Auth::user() ? Auth::user()->phone : '',
        'tabindex' => 2,
        'errors' => $errors->payment
    ])

    @include('form.row', [
        'label' => 'E-mail',
        'required' => true,
        'field_name' => 'email',
        'field_id' => 'payment-email',
        'field_value' =>  Auth::user() ? Auth::user()->email : '',
        'tabindex' => 3,
        'errors' => $errors->payment
    ])

    @include('form.row', [
        'label' => 'Номер счёта',
        'required' => true,
        'field_name' => 'number',
        'field_id' => 'payment-number',
        'tabindex' => 4,
        'errors' => $errors->payment
    ])

    @include('form.row', [
        'label' => 'Сумма к оплате',
        'required' => true,
        'field_name' => 'amount',
        'field_id' => 'payment-amount',
        'tabindex' => 5,
        'errors' => $errors->payment
    ])

    @include('form.row', [
        'label' => 'Комментарий к заказу',
        'required' => false,
        'field_name' => 'comment',
        'field_id' => 'payment-comment',
        'field_type' => 'textarea',
        'tabindex' => 6,
        'errors' => $errors->payment
    ])

    <div class="row row-recaptcha">
        <div class="form-column__left"></div>
        <div class="form-column__right">
            @include('form.recaptcha')
        </div>
    </div>

    <div class="row row-btn">
        <div class="form-column__left"></div>
        <div class="form-column__right">
            <button tabindex="15" type="submit" class="btn">Оплатить</button>
        </div>
    </div>

</form>