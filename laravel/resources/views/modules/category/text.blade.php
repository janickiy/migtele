@if($text && request('page', 1) <= 1 )
    <div class="main-description text-content">

        <div itemprop="text" @if(mb_strlen(strip_tags($text)) > 1000 ) class="text-close" @endif >
            {!! $text !!}
        </div>

        @if(mb_strlen(strip_tags($text)) > 1000 )
            <a href="#" class="main-description__spoiler_open">Показать полностью</a>
        @endif

    </div>

@endif