@foreach($sub_categories as $sub_category => $products)
    <div class="products">
        <div class="category-name">{{ $sub_category }}</div>
        @include('modules.category.product_list', ['products' => $products])
    </div>
@endforeach