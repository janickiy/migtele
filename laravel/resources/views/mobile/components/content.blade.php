
<div class="container">
    <div class="content">
        @if($text)
            <div class="title">{{ $title }}</div>
            <div class="text">
                <div class="short-text">{{ str_limit(strip_tags($text), 100) }}</div>
                <button class="spoiler-open">Показать все</button>
                <div class="spoiler">
                    {!! $text !!}
                </div>
            </div>
        @endif
    </div>
</div>
