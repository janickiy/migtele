<div class="order-info" style="border: 0; font: inherit; font-size: 14px; line-height: 14px; margin: 0; margin-top: 18px; padding: 0; padding-left: 21px; vertical-align: baseline;">
    <div style="border: 0; font: inherit; font-size: 100%; margin: 0; margin-bottom: 16px; padding: 0; vertical-align: baseline;"><b style="border: 0; font: inherit; font-size: 100%; font-weight: 500; margin: 0; padding: 0; vertical-align: baseline;">{{ $order->contractor->type ? 'Физическое лицо' : 'Юридическое лицо' }}:</b></div>
    @include('emails.order.user_field', [
        'key' => 'ФИО',
        'value' => $order->contractor->name
    ])

    @include('emails.order.user_field', [
        'key' => 'Телефон',
        'value' => $order->contractor->phone
    ])

    @include('emails.order.user_field', [
        'key' => 'E-mail',
        'value' => $order->contractor->email
    ])


    @include('emails.order.user_field', [
        'key' => 'Компания покупатель',
        'value' => $order->contractor->organization
    ])

    @include('emails.order.user_field', [
        'key' => 'Компания грузополучатель',
        'value' => $order->contractor->company_receiver
    ])

    @include('emails.order.user_field', [
        'key' => 'ИНН/КПП',
        'value' => $order->contractor->inn
    ])

    @include('emails.order.user_field', [
        'key' => 'Юридический адрес',
        'value' => $order->contractor->address
    ])

    @include('emails.order.user_field', [
        'key' => 'Способ оплаты',
        'value' => $order->payment_name
    ])

    @include('emails.order.user_field', [
        'key' => 'Способ доставки',
        'value' => $order->delivery_name
    ])

    @include('emails.order.user_field', [
        'key' => 'Компания доставки',
        'value' => $order->delivery_company_name
    ])

    @include('emails.order.user_field', [
        'key' => 'Адрес доставки',
        'value' => $order->delivery_address
    ])

    @include('emails.order.user_field', [
        'key' => 'Время доставки',
        'value' => $order->delivery_time
    ])

    @include('emails.order.user_field', [
        'key' => 'Примечание по доставке',
        'value' => $order->delivery_note
    ])
</div>