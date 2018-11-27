@if($product->nalich)
    <div class="stock-info stock-info__success">В наличии</div>
@else
    <div class="stock-info">Нет в наличии</div>
@endif