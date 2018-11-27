@extends('emails.layouts.template')

@section('content')

    <div class="body-title" style="border: 0; font: inherit; font-size: 20px; line-height: 20px; margin: 0; margin-top: 30px; padding: 0; text-align: center; vertical-align: baseline;">{{ $mailTemplate->title }}</div>

    <div class="body-description-short" style="border: 0; font: inherit; font-size: 14px; line-height: 24px; margin: 0; margin-top: 16px; padding: 0; text-align: left; vertical-align: baseline;">{!! $mailTemplate->body !!}</div>

    <div class="sub-title" style="border: 0; font: inherit; font-size: 18px; font-weight: 500; margin: 0; margin-top: 15px; padding: 0; vertical-align: baseline;">Ваши закладки</div>

    @include('emails.component.product-list', ['products' => $wishlist_products])

    @include('emails.component.product-list-2', ['products' => $recommended_products])


@endsection
