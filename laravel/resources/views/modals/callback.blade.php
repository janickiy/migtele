@component('components.modal', [
    'id' => 'callback-form',
    'title' => 'Заказать звонок оператора',
    'description' => 'Укажите свой контактный телефон, и мы перезвоним вам в течении нескольких минут:'
])
<form action="{{ url('/callback') }}" method="POST">

    {{ csrf_field() }}

    @include('form.input', [
        'field_id' => 'callback-name',
        'field_name' => 'name',
        'placeholder' => 'ФИО',
        'field_value' =>  Auth::user() ? Auth::user()->name : '',
        'tabindex' => 1,
        'errors' => $errors->callback
    ])

    @include('form.input', [
        'field_id' => 'callback-phone',
        'field_name' => 'phone',
        'placeholder' => 'Телефон',
        'field_value' =>  Auth::user() ? Auth::user()->phone : '',
        'tabindex' => 2,
        'errors' => $errors->callback
    ])

    @include('form.textarea', [
        'field_id' => 'callback-notes',
        'field_name' => 'notes',
        'field_type' => 'textarea',
        'placeholder' => 'Вопрос',
        'tabindex' => 4,
        'errors' => $errors->callback
    ])


    @include('form.recaptcha', ['errors' => $errors->callback])


    <div class="form-before__submit-text center">Режим работы офиса<br>с 10:00 до 18:00 МСК по будним дням</div>

    <div class="center">
        <button type="submit" class="btn">Отправить</button>
    </div>

</form>
@endcomponent