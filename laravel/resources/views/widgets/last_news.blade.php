@if(count($news))
    <div class="sidebar-news">
        <div class="title">Новости</div>
        <ul>
            @foreach($news as $item)
                <li>
                    <div class="title">{{ $item->name }}</div>
                    <div class="text">{{ $item->description }}</div>
                    <a href="{{ url($item->url) }}" class="more">Подробнее</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif