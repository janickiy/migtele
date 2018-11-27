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
        <th>Сообщение</th>
        <td>{{ $data['notes'] }}</td>
    </tr>
</table>

</body>
</html>