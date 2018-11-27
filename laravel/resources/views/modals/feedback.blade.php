@component('components.modal', [
    'id' => 'feedback-form',
    'title' => 'Обратная связь',
    'description' => 'Задайте свой вопрос:'
])
    <form action="{{ url('/feedback') }}" method="POST">

        {{ csrf_field() }}

        @include('form.input', [
            'field_id' => 'feedback-name',
            'field_name' => 'name',
            'placeholder' => 'ФИО',
            'field_value' =>  Auth::user() ? Auth::user()->name : '',
            'tabindex' => 1,
            'errors' => $errors->feedback_form
        ])

        @include('form.input', [
            'field_id' => 'feedback-phone',
            'field_name' => 'phone',
            'placeholder' => 'Телефон',
            'field_value' =>  Auth::user() ? Auth::user()->phone : '',
            'tabindex' => 2,
            'errors' => $errors->feedback_form
        ])

        @include('form.input', [
            'field_id' => 'feedback-mail',
            'field_name' => 'mail',
            'placeholder' => 'E-mail',
            'field_value' =>  Auth::user() ? Auth::user()->email : '',
            'tabindex' => 3,
            'errors' => $errors->feedback_form
        ])

        @include('form.textarea', [
            'field_id' => 'feedback-notes',
            'field_name' => 'notes',
            'field_type' => 'textarea',
            'placeholder' => 'Вопрос',
            'tabindex' => 4,
            'errors' => $errors->feedback_form
        ])

        @include('form.recaptcha', ['errors' => $errors->feedback_form])

        <div class="form-before__submit-text center">Режим работы офиса<br>с 10:00 до 18:00 МСК по будним дням</div>

        <div class="center">
            <button type="submit" class="btn">Отправить</button>
        </div>

    </form>
@endcomponent