@component('components.modal', [
    'id' => 'quick-order',
    'title' => 'Купить в 1 клик',
    'description' => 'Оформление заказа:'
])
@php($min_order = (int)_setting('order_minimum_amount') > \CartProducts::getTotal() )
<form action="{{ url('/quick-order') }}" method="POST">

    {{ csrf_field() }}

    <input type="hidden" name="product_id" value="{{ old('product_id') }}">
    
    @include('form.input', [
        'field_id' => 'quick-order-name',
        'field_name' => 'name',
        'field_value' =>  Auth::user() ? Auth::user()->name : '',
        'placeholder' => 'ФИО',
        'tabindex' => 1,
        'errors' => $errors->quick_order
    ])

    @include('form.input', [
        'field_id' => 'quick-order-phone',
        'field_name' => 'phone',
        'field_value' =>  Auth::user() ? Auth::user()->phone : '',
        'placeholder' => 'Телефон',
        'tabindex' => 2,
        'errors' => $errors->quick_order
    ])

    @include('form.input', [
        'field_id' => 'quick-order-mail',
        'field_name' => 'email',
        'field_value' =>  Auth::user() ? Auth::user()->email : '',
        'placeholder' => 'E-mail',
        'tabindex' => 3,
        'errors' => $errors->quick_order
    ])


    @include('form.recaptcha', ['errors' => $errors->quick_order])

    <div class="form-before__submit-text center">Режим работы офиса<br>с 10:00 до 18:00 МСК по будним дням</div>

    <div class="center">
        <button type="submit" class="btn" @if($min_order) disabled @endif>Отправить</button>
    </div>

    @if($min_order)
        @include('modules.minimum_order_text')
    @endif

    <div class="text-agreement">
        {!!  str_replace('[link]', "<a href='".url('/zaschita_personalnih_dannih.htm')."'>здесь</a>", _setting('quick-order-agreement-text'))  !!}
    </div>

</form>
@endcomponent