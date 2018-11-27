@if(count($payments))
    <div class="order-step">
        <div class="row">
            <div class="order-step__left">
                <div class="order-step__title">Способ оплаты:</div>
            </div>
            <div class="order-step__right">
                <div class="form-group__radio form-group__radio_inline payment-type">
                    @foreach($payments as $i => $payment)
                        @include('form.radio', [
                            'label' => $payment->name,
                            'field_id' => 'order-payment-'.$payment->id,
                            'field_name' => 'payment_method_id',
                            'field_value' => $payment->id,
                            'checked' => old('payment_method_id') ? old('payment_method_id') == $payment->id  : $i == 0,
                            'dataid' => $payment->id,
                            'tabindex' => 10
                        ])
                    @endforeach
                </div>

                <div class="order-payment_description payment-description">
                    @foreach($payments as $payment)

                        @if($payment->type == 'pictures')
                            <div class="description description__images" data-id="{{ $payment->id }}" data-in_margin="1">
                                @foreach($payment->items as $item)
                                    @continue(!$item->img)
                                    <img src="{{ url($item->img) }}" alt="">
                                @endforeach
                            </div>
                        @elseif($payment->type == 'electronic')
                            <div class="description payment-method__list" data-id="{{ $payment->id }}" data-in_margin="1">
                                @foreach($payment->items as $item)
                                    <div class="form-radio">
                                        <input class="radio" id="order-payment-{{ $payment->id }}-{{ $item->id }}" type="radio" name="payment-{{ $payment->id }}" value="{{ $item->id }}">
                                        <label class="form-radio" for="order-payment-{{ $payment->id }}-{{ $item->id }}"> @if($item->img) <div class="img"><img src="{{ url($item->img) }}" alt=""></div>  @endif {{ $item->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="description" data-id="{{ $payment->id }}">{{ $payment->description }}</div>
                        @endif
                    @endforeach


                </div>
            </div>
        </div>

    </div>
@endif