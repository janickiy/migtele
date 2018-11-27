@if(count($vendors))
    <div id="vendor-relative-product">

        <div class="heading-2">Похожие производители</div>

        <div class="product-vendor__list horizontal-scroll">
            @foreach($vendors as $vendor)
                <a href="{{ url($vendor->url) }}" class="product-vendor__item">
                    <div class="img"><img src="{{ url($vendor->img) }}" alt=""></div>
                    <div class="title">{{ $vendor->name }}</div>
                </a>
            @endforeach
        </div>
    </div>
@endif