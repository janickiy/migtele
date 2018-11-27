@for($i=0; $i<=5; $i++)
    @break(!isset($items[$i]))
    @include('mobile.components.item')
@endfor

@if(count($items) > 6)
    @include('mobile.components.spoiler')
    <div class="spoiler">
        @for($i=6; $i<=count($items)-1; $i++)
            @break(!isset($items[$i]))
            @include('mobile.components.item')
        @endfor
    </div>
@endif