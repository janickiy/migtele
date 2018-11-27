@include('form.row', [
    'label' => 'ФИО',
    'required' => true,
    'field_name' => 'name',
    'field_id' => 'feedback-name__',
    'field_value' =>  Auth::user() ? Auth::user()->name : '',
    'tabindex' => 1,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'Телефон',
    'required' => false,
    'field_id' => 'feedback-phone__',
    'field_name' => 'phone',
    'field_value' =>  Auth::user() ? Auth::user()->phone : '',
    'tabindex' => 2,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'E-mail',
    'required' => true,
    'field_id' => 'feedback-email__',
    'field_name' => 'mail',
    'field_value' =>  Auth::user() ? Auth::user()->email : '',
    'tabindex' => 3,
    'errors' => $errors->feedback
    ])

@include('form.row', [
    'label' => 'Суть обращение',
    'description_warning' => 'Пожалуйста, указывайте <b>номер заказа</b> (при необходимости)',
    'required' => true,
    'field_id' => 'feedback-message',
    'field_name' => 'message',
    'field_value' =>  '',
    'field_type' => 'textarea',
    'tabindex' => 4,
    'errors' => $errors->feedback
    ])