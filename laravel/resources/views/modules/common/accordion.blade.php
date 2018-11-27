@if($warranty_text || $delivery_text)
    <div class="accordion">

        @if($warranty_text)
            <div class="title"><h2>ГАРАНТИЯ - {{ $title }}</h2></div>
            <div class="text text-content">{!! $warranty_text !!}</div>
        @endif

        @if($delivery_text)
            <div class="title"><h2>ДОСТАВКА - {{ $title }}</h2></div>
            <div class="text text-content">{!! $delivery_text !!}</div>
        @endif

    </div>
@endif