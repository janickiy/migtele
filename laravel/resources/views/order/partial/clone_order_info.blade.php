@php($amount = 0)
@foreach (session('clone_products') as $i=>$clone_product)
    @php($product = \App\Model\Product::find($clone_product['id']))
    {{ $i+1 }}. <a href='{{ $product->url }}'>{{ $product->code }} - {{ $product->name }}</a>
    (<i>кол-во: {{ $clone_product['quantity'] }}, ст-ть: {{ $product->cart_price }}</i>)<br>
    @php($amount += $product->cart_price * $clone_product['quantity'])
@endforeach

<br /><b>Итого:</b> {{_price($amount)}} Р<br>
