<!doctype html>
<html lang="ru">
<head>

</head>
<body>

<table>
    <tr>
        <th>ФИО</th>
        <td>{{ $data['name'] }}</td>
    </tr>
    <tr>
        <th>Телефон</th>
        <td>{{ $data['phone'] }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $data['mail'] }}</td>
    </tr>
    @if($data['product'])
        <tr>
            <th>Товар</th>
            <th><a href="{{ url($data['product']->url) }}">{{ $data['product']->name }}</a></th>
        </tr>
    @endif
    <tr>
        <th>Количество товара</th>
        <td>{{ $data['products_count'] }}</td>
    </tr>
    <tr>
        <th>Сообщение</th>
        <td>{{ $data['notes'] }}</td>
    </tr>
</table>

</body>
</html>