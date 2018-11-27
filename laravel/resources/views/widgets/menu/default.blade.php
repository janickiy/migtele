<ul>
    @foreach($pages as $page)
        <li><a href="{{ url($page->link) }}">{{ $page->name }}</a></li>
    @endforeach
</ul>