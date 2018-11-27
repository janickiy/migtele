<div class="breadcrumbs">
    @foreach($config['links'] as $k=>$link)
        @if(isset($link['url']) && $link['url'])
            <a href="{{ url($link['url']) }}">{{ $link['title'] }}</a>
        @else
            <span>{{ $link['title'] }}</span>
        @endif
        @if(count($config['links']) != $k+1)
         <span class="separator">></span>
        @endif
    @endforeach
</div>