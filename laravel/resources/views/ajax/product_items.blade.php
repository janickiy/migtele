<div id="next-url">{{ $products->nextPageUrl() }}</div>
@foreach($products as $product)
    @include('modules.product.item')
@endforeach