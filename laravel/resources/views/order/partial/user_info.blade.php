@include('order.partial.row', [
    'key' => 'Тип клиента',
    'value' => $order->contractor->type ? 'Физическое лицо' : 'Юридическое лицо'
])

@include('order.partial.row', [
    'key' => 'ФИО',
    'value' => $order->contractor->name
])

@include('order.partial.row', [
    'key' => 'Телефон',
    'value' => $order->contractor->phone
])

@include('order.partial.row', [
    'key' => 'Телефон',
    'value' => $order->contractor->mobile_phone
])

@include('order.partial.row', [
    'key' => 'E-mail',
    'value' => $order->contractor->email
])

@include('order.partial.row', [
    'key' => 'Компания покупатель',
    'value' => $order->contractor->organization
])

@include('order.partial.row', [
    'key' => 'Компания грузополучатель',
    'value' => $order->contractor->company_receiver
])

@include('order.partial.row', [
    'key' => 'ИНН/КПП',
    'value' => $order->contractor->inn
])

@include('order.partial.row', [
    'key' => 'Юридический адрес',
    'value' => $order->contractor->address
])

@include('order.partial.row', [
    'key' => 'Способ оплаты',
    'value' => $order->payment_name
])

@include('order.partial.row', [
    'key' => 'Способ доставки',
    'value' => $order->delivery_name
])

@include('order.partial.row', [
    'key' => 'Компания доставки',
    'value' => $order->delivery_company_name
])

@include('order.partial.row', [
    'key' => 'Адрес доставки',
    'value' => $order->delivery_address
])

@include('order.partial.row', [
    'key' => 'Время доставки',
    'value' => $order->delivery_time
])

@include('order.partial.row', [
    'key' => 'Примечание',
    'value' => $order->comment
])