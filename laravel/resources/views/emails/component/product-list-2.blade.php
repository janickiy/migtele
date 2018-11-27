@if(count($products))
    <div class="body-title" style="border: 0; font: inherit; font-size: 20px; line-height: 20px; margin: 0; margin-top: 30px; padding: 0; text-align: center; vertical-align: baseline;">Вот что еще может Вас заинтересовать</div>
    <div class="body-description__second" style="border: 0; color: #232323; font: inherit; font-size: 18px; line-height: 18px; margin: 0; margin-top: 33px; padding: 0; vertical-align: baseline;">Наши специалисты так же подобрали несколько товаров, которые могут Вас заинтересовать!</div>

    <div class="product-list2" style="border: 0; font: inherit; font-size: 100%; margin: 43px 0 45px; padding: 0; vertical-align: baseline;">
        @foreach($products as $product)

            <div class="product-list2__item" style="border: 0; font: inherit; font-size: 0; margin: 0; margin-bottom: 20px; padding: 0; vertical-align: baseline;">
                @if($product->preview)
                    <div class="image" style="background-image: url({{ url('/images/email-product/uploads/goods_img/'.$product->preview.'.jpg') }}); border: 0; display: inline-block; font: inherit; font-size: 100%; height: 200px; margin: 0; margin-right: 45px; padding: 0; vertical-align: top; width: 200px;"></div>
                @endif
                <div class="info" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; padding: 0; vertical-align: top; width: 615px;">
                    <div class="title" style="border: 0; color: #2072b5; font: inherit; font-size: 18px; margin: 0; margin-top: -8px; padding: 0; vertical-align: baseline;">{{ $product->name }}</div>
                    <div class="description" style="border: 0; color: #232323; font: inherit; font-size: 12px; height: 110px; line-height: 18px; margin: 0; margin-top: 10px; padding: 0; vertical-align: baseline;">{{ $product->short_description }}</div>
                    <div class="price" style="border: 0; color: #232323; font: inherit; font-size: 16px; margin: 0; margin-top: 10px; padding: 0; vertical-align: baseline;">Цена: {{ $product->price }} руб.</div>
                    <a href="{{ url($product->url) }}" class="more" style="border: 0; color: #2072b5; display: block; font: inherit; font-size: 14px; line-height: 14px; margin: 0; margin-top: 6px; padding: 0; text-decoration: none; vertical-align: baseline;">Посмотреть на сайте</a>
                </div>
            </div>

        @endforeach

    </div>
@endif