@include('form.row', [
    'label' => 'Тип предложения',
    'required' => true,
    'field_type' => 'select',
    'field_name' => 'feed_comm_type',
    'field_id' => 'feedback-feed_comm_type',
    'field_value' =>  '',
    'options' => [
        'Коммерческое предложение' => 'Коммерческое предложение',
        'Маркетинг и реклама' => 'Маркетинг и реклама',
        'Интернет, связь, телефония' => 'Интернет, связь, телефония',
        'Логистика' => 'Логистика',
        'Производство товаров' => 'Производство товаров',
        'Другое' => 'Другое',
    ],
    'tabindex' => 1,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'ФИО',
    'required' => true,
    'field_name' => 'name',
    'field_id' => 'feedback-name_',
    'field_value' =>  Auth::user() ? Auth::user()->name : '',
    'tabindex' => 1,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'Телефон',
    'required' => true,
    'field_id' => 'feedback-phone_',
    'field_name' => 'phone',
    'field_value' =>  Auth::user() ? Auth::user()->phone : '',
    'tabindex' => 2,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'E-mail',
    'required' => true,
    'field_id' => 'feedback-email',
    'field_name' => 'mail',
    'field_value' =>  Auth::user() ? Auth::user()->email : '',
    'tabindex' => 3,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'Суть обращение',
    'required' => true,
    'field_id' => 'feedback-message',
    'field_name' => 'message',
    'field_value' =>  '',
    'field_type' => 'textarea',
    'tabindex' => 4,
    'errors' => $errors->feedback
    ])