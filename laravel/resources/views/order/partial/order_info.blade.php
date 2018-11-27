
@foreach($products as  $i=>$product)
    {{ $i+1 }}. <a href='{{ $product->url }}'>{{ $product->code }} - {{ $product->name }}</a>
    (<i>кол-во: {{ $product->quantity }}, ст-ть: {{ $product->cart_price }}</i>)<br>
@endforeach

<br /><b>Итого:</b> {{_price(\CartProducts::getTotal())}} Р<br>


