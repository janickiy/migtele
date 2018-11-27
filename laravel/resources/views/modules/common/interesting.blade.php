@if(count($products))
    <div id="interesting">

        <div class="heading-2">Возможно Вас заинтересует</div>

        <div class="interesting-list">
            @foreach($products as $product)
                <a href="{{ url($product->url) }}">{{ $product->name }}</a>
            @endforeach
        </div>

    </div>
@endif