@if(count($tags))
    <div id="interesting">

        <div class="heading-2">Возможно Вас заинтересует</div>

        <div class="interesting-list">
            @foreach($tags as $tag)
                <a href="{{ url($tag->url) }}">{{ $tag->name }}</a>
            @endforeach
        </div>

    </div>
@endif