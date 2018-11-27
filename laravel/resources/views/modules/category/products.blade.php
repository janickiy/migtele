@if(count($products))

    @include('modules.category.toolbar')

    @include('modules.category.product_list')

    {{ $products->links('modules.pagination') }}
@else

    <p style="margin-top: 20px">Нет товаров для отображения</p>

@endif