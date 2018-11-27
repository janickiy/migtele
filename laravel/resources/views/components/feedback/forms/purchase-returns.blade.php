@include('form.row', [
    'label' => 'Номер заказа',
    'required' => true,
    'field_name' => 'number',
    'field_id' => 'feedback-number',
    'field_value' =>  '',
    'tabindex' => 1,
    'errors' => $errors->feedback
    ])

@include('form.row_multiple', [
    'label' => 'Товары',
    'required' => true,
    'field_name' => 'products',
    'field_id' => 'feedback-products',
    'field_value' =>  '',
    'fields' => [''],
    'tabindex' => 2,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'Тип проблемы',
    'required' => false,
    'field_type' => 'select',
    'field_name' => 'type_problem',
    'field_id' => 'feedback-type_problem',
    'field_value' =>  '',
    'options' => [
        'Брак/не хватает детали/деталь повреждена' => 'Брак/не хватает детали/деталь повреждена',
        'Привезли не тот товар' => 'Привезли не тот товар',
        'Не привезли товар, он есть в накладной, оплачен' => 'Не привезли товар, он есть в накладной, оплачен',
        'Не соответствует описанию/картинке на сайте' => 'Не соответствует описанию/картинке на сайте',
        'Товар не понравился (возврат по желанию клиента)' => 'Товар не понравился (возврат по желанию клиента)',
        'Другое' => 'Другое'
    ],
    'tabindex' => 3,
    'errors' => $errors->feedback
    ])

<div class="row {{ $errors->feedback->has('photo') ? ' has-error' : '' }}">
    <div class="form-column__left">
        <label for="feedback-photo">Прикрепить фото<span class="required">*</span></label>
        <div class="form-description-inline form-description-inline__label">Формат: gif, jpeg, jpg, png</div>
    </div>
    <div class="form-column__right form-column__file_input">
        <input tabindex="4" type="file" name="photo" accept="image/jpeg,image/png,image/gif" value="{{ old('photo') }}">
        @if ($errors->feedback->has('photo'))
            <span class="help-block"><strong>{{ $errors->feedback->first('photo') }}</strong></span>
        @endif
    </div>
</div>

@include('form.row', [
    'label' => 'Описание проблемы',
    'required' => true,
    'field_id' => 'feedback-description_problem',
    'field_name' => 'description_problem',
    'field_value' =>  '',
    'field_type' => 'textarea',
    'tabindex' => 5,
    'errors' => $errors->feedback
    ])


@include('form.row', [
    'label' => 'Делали раньше заказы у нас?',
    'required' => false,
    'field_type' => 'select',
    'field_name' => 'feed_earlier',
    'field_id' => 'feedback-feed_earlier',
    'field_value' =>  '',
    'options' => [
        'Первый заказ' => 'Первый заказ',
        'Заказывали давно' => 'Заказывали давно',
        'Постоянный покупатель' => 'Постоянный покупатель'
    ],
    'tabindex' => 6,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'Комментарий',
    'required' => false,
    'field_id' => 'feedback-comment',
    'field_name' => 'comment',
    'field_value' =>  '',
    'field_type' => 'textarea',
    'tabindex' => 7,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'Телефон',
    'required' => true,
    'field_id' => 'feedback-phone',
    'field_name' => 'phone',
    'field_value' =>  Auth::user() ? Auth::user()->phone : '',
    'tabindex' => 8,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'E-mail',
    'required' => true,
    'field_id' => 'feedback-email',
    'field_name' => 'mail',
    'field_value' =>  Auth::user() ? Auth::user()->email : '',
    'tabindex' => 9,
    'errors' => $errors->feedback
    ])