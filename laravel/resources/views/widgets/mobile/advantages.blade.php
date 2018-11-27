@if(count($advantages))
    <div id="advantages">

        <div class="container">
            <div class="heading-1">Наши преимущества </div>
        </div>

        <div class="block-list owl-carousel advantages" data-slideout-ignore>

            @foreach($advantages as $advantage)
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