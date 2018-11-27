<!doctype html>
<html lang="ru">
<head>

</head>
<body>

<table>

    @foreach($data as $key => $item)
        <tr>
            <th>{{ __('feedback.'.$key)  }}:</th>
            @if(is_array($item))
                <td> @foreach($item as $value) {{ $value }} <br> @endforeach </td>
            @else
                <td>{{ $item }}</td>
            @endif
        </tr>
    @endforeach
</table>

</body>
</html>