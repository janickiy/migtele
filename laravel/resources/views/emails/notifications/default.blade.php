@extends('emails.layouts.template')


@section('content')

    @if($title)
        <div class="body-title" style="border: 0; font: inherit; font-size: 20px; line-height: 20px; margin: 0; margin-top: 30px; padding: 0; text-align: center; vertical-align: baseline;">{{ $title }}</div>
    @endif

    <div class="discount-description">
        {!! $body !!}
    </div>

    <div class="sub-title__discount">Купленный товар</div>

    <div class="products" style="background-color: #f6f6f6; border: 0; font: inherit; font-size: 100%; margin: 0; margin-top: 38px; padding: 0; vertical-align: baseline;">

        @foreach($order->products as $product)
            @include('emails.component.product_row')
        @endforeach

        @include('emails.order.delivery')

    </div>

    @include('emails.order.amount')

    @include('emails.component.buttons')

@endsection
