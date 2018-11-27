@if(count($advantages))
    <div id="our-advantages">
        <div class="heading-1">Наши преимущества</div>
        <div class="block-list">

            @foreach($advantages as $advantage)
                @continue(!$advantage->link)
                <a href="{{ url($advantage->link) }}" class="block-item">
                    <div class="title">{{ $advantage->advantage_title }}</div>
                    <div class="text">{!! $advantage->advantage_description  !!} </div>
                    @if($advantage->advantage_image)
                        <div class="img" style="background-image: url({{ url($advantage->advantage_image) }})"></div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
@endif