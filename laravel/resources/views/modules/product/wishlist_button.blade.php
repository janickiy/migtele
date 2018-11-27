<form method="POST" class="wishlist-form" action="{{ $product->in_wish_list ? url('/wishlist/delete') : url('/wishlist/add') }}">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $product->id }}">
    @if($product->in_wish_list)
        <button type="submit" class="delete"></button>
    @else
        <button type="submit" class="in-bookmark">В закладки</button>
    @endif
</form>