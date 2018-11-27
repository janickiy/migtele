@extends('emails.layouts.template')


@section('content')

    <div class="body-title" style="border: 0; font: inherit; font-size: 20px; line-height: 20px; margin: 0; margin-top: 30px; padding: 0; text-align: center; vertical-align: baseline;">{{ $mailTemplate->title }}</div>
    <div class="body-description" style="border: 0; font: inherit; font-size: 18px; line-height: 18px; margin: 0; margin-top: 16px; padding: 0; text-align: center; vertical-align: baseline;">{{ $mailTemplate->description }}</div>

    <div class="products" style="background-color: #f6f6f6; border: 0; font: inherit; font-size: 100%; margin: 0; margin-top: 38px; padding: 0; vertical-align: baseline;">

        @foreach($order->products as $product)
            @include('emails.component.product_row')
        @endforeach

        @include('emails.order.delivery')

    </div>

    @include('emails.order.amount')

    @include('emails.order.info')

    @include('emails.component.buttons')

    <div class="order-description" style="border: 0; font: inherit; font-family: Roboto,sans-serif; font-size: 13px; line-height: 18px; margin: 0; margin-top: 35px; padding: 0; padding-left: 3px; vertical-align: baseline;">

        {!! $mailTemplate->body !!}

    </div>
@endsection

