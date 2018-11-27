@component('components.modal', [
    'id' => 'dealer-form',
    'title' => 'Запросить цену дилера',
    'description' => 'Чтобы получить дилерскую цену заполните форму ниже:'
])
<form action="{{ url('/dealer') }}" method="POST">

    {{ csrf_field() }}

    <input type="hidden" value="{{ old('product_id') }}" name="product_id">

    @include('form.input', [
        'field_id' => 'dealer-name',
        'field_name' => 'name',
        'placeholder' => 'ФИО',
        'field_value' =>  Auth::user() ? Auth::user()->name : '',
        'tabindex' => 1,
        'errors' => $errors->dealer
    ])

    @include('form.input', [
        'field_id' => 'dealer-phone',
        'field_name' => 'phone',
        'placeholder' => 'Телефон',
        'field_value' =>  Auth::user() ? Auth::user()->phone : '',
        'tabindex' => 2,
        'errors' => $errors->dealer
    ])

    @include('form.input', [
        'field_id' => 'dealer-mail',
        'field_name' => 'mail',
        'placeholder' => 'E-mail',
        'field_value' =>  Auth::user() ? Auth::user()->email : '',
        'tabindex' => 3,
        'errors' => $errors->dealer
    ])

    @include('form.input', [
        'field_id' => 'dealer-products_count',
        'field_name' => 'products_count',
        'placeholder' => 'Количество товара',
        'tabindex' => 4,
        'errors' => $errors->dealer
    ])

    @include('form.textarea', [
        'field_id' => 'dealer-notes',
        'field_name' => 'notes',
        'field_type' => 'textarea',
        'placeholder' => 'Вопрос',
        'tabindex' => 5,
        'errors' => $errors->dealer
    ])

    <div style="margin: 20px 0">
        @include('form.recaptcha', ['errors' => $errors->dealer])
    </div>


    <div class="form-before__submit-text center">Режим работы офиса<br>с 10:00 до 18:00 МСК по будним дням</div>

    <div class="center">
        <button type="submit" class="btn">Отправить</button>
    </div>

</form>
@endcomponent