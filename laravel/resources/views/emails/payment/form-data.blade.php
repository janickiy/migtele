@include('order.partial.row', [
    'key' => 'ФИО',
    'value' => $pay_order->name
])

@include('order.partial.row', [
    'key' => 'Телефон',
    'value' => $pay_order->phone
])

@include('order.partial.row', [
    'key' => 'E-mail',
    'value' => $pay_order->email
])

@include('order.partial.row', [
    'key' => 'Номер счета',
    'value' => $pay_order->number
])

@include('order.partial.row', [
    'key' => 'Сумма',
    'value' => $pay_order->amount
])

@include('order.partial.row', [
    'key' => 'Комментарий',
    'value' => $pay_order->comment
])