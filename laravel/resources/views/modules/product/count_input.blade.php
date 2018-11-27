<div class="count-input">
    <form action="{{ url('/cart/change-quantity') }}" method="POST" class="@if(isset($is_modal)) {{ 'count-modal-cart' }} @endif">
        {{ csrf_field() }}
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <a href="#" class="count-minus"></a>
        <input type="text" name="quantity" value="{{ $product->quantity }}">
        <a href="#" class="count-plus"></a>
        @if(isset($is_modal))
            <input type="hidden" name="is_modal" value="1">
        @endif
    </form>
</div>