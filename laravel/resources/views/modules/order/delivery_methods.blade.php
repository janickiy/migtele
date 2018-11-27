@if(count($deliveries))
    <div class="order-step">
        <div class="row">
            <div class="order-step__left">
                <div class="order-step__title">Способ доставки:</div>
            </div>
            <div class="order-step__right">
                <div class="form-group__radio form-group__radio_inline form-group__radio_inline__delivery-type delivery-type">

                    @foreach($deliveries as $i=>$delivery)
                        <div class="form-radio">
                            <input {{ old('delivery_method_id') ? (old('delivery_method_id') == $delivery->id ? 'checked' : '') : ($i == 0 ? 'checked' : '') }} data-id="{{ $delivery->id }}" tabindex="11" class="radio" id="order-delivery-{{ $delivery->id }}" type="radio" name="delivery_method_id" value="{{ $delivery->id }}" data-price="{{ $delivery->price }}" data-type="{{ $delivery->type }}">
                            <label class="form-radio quest-wr" for="order-delivery-{{ $delivery->id }}">{{ $delivery->name }}@include('modules.common.quest_block', ['text' => $delivery->description])
                                @if($delivery->price)
                                    <span class="price">
                                        @if($delivery->type == 'in_russia')
                                            От
                                        @endif
                                        {{ _price($delivery->price) }} Р</span>
                                @else
                                    <span class="price price__success">Бесплатно</span>
                                @endif
                            </label>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <div class="order-delivery__info">

            @foreach($deliveries as $delivery)
                <div class="delivery-info" data-id="{{ $delivery->id }}">

                    @if($delivery->type == 'pickup')
                        <div id="map-{{ $delivery->id }}" class="map" data-lat="{{ $delivery->coordinate[0] }}" data-lng="{{ $delivery->coordinate[1] }}"></div>
                        <div class="info">
                            @if($delivery->file)
                                <a href="{{ url($delivery->file) }}" class="download-map" target="_blank">Скачать карту в PDF</a>
                            @endif
                            <div class="address">
                                Пункт выдачи товара:
                                <div>{{ $delivery->address }}</div>
                            </div>
                            <div class="phone">{{ $delivery->phone }}</div>
                            <div class="schedules">
                                <span class="icon icon-time"></span><span class="days">{{ $delivery->days }}:</span><span class="times">{{ $delivery->hours }}</span>
                            </div>
                        </div>

                    @elseif($delivery->type == 'in_russia')

                        <div
                                id="map-{{ $delivery->id }}"
                                class="map"
                                data-lat="{{ $delivery->coordinate[0] }}"
                                data-lng="{{ $delivery->coordinate[1] }}"
                                data-input="#coordinate-{{ $delivery->id }}"
                                data-textarea="#order-delivery-{{ $delivery->id }}-address"
                        ></div>
                        <input type="hidden" id="coordinate-{{ $delivery->id }}" name="coordinate">
                        <div class="info">


                            @include('form.row', [
                               'label' => 'Точный адрес с городом',
                               'required' => true,
                               'field_name' => 'delivery-'.$delivery->id.'-address',
                               'field_id' => 'order-delivery-'.$delivery->id.'-address',
                               'field_type' => 'textarea',
                               'tabindex' => 10,
                               'class_left' => 'info-column__left',
                               'class_right' => 'info-column__right',
                               'errors' => $errors->order
                           ])


                            <div class="form-group__radio form-group__radio_inline">
                                <div class="form-radio">
                                    <input {{ old('delivery-'.$delivery->id.'-to') ? (old('delivery-'.$delivery->id.'-to') == 'до склада' ? 'checked' : '') : 'checked' }}
                                           class="radio" id="order-delivery-3-to-1" name="delivery-{{ $delivery->id }}-to" type="radio" value="до склада">
                                    <label class="form-radio quest-wr" for="order-delivery-3-to-1">До склада ТК @include('modules.common.quest_block', ['text' => $delivery->text_to_store])
                                    </label>
                                </div>
                                <div class="form-radio">
                                    <input {{ old('delivery-'.$delivery->id.'-to') == 'до двери' ? 'checked' : '' }}
                                           class="radio" id="order-delivery-3-to-2" name="delivery-{{ $delivery->id }}-to" type="radio" value="до двери">
                                    <label class="form-radio quest-wr" for="order-delivery-3-to-2">До двери @include('modules.common.quest_block', ['text' => $delivery->text_to_door])
                                    </label>
                                </div>
                            </div>



                            <div class="form-group__radio form-group__radio_list delivery-select-company">
                                <div class="title">Выберете транспортную компанию: </div>
                                <div class="radio-col-2">

                                    @foreach($delivery->items as $k=>$item)
                                        <div class="form-radio">
                                            <input {{ old('delivery-'.$delivery->id.'-company') ? (old('delivery-'.$delivery->id.'-company') == $item->id ? 'checked' : '') : ( $k == 0 ? 'checked' : '') }}
                                                   class="radio" id="order-delivery-{{ $delivery->id }}-company-{{ $item->id }}" name="delivery-{{ $delivery->id }}-company" type="radio" value="{{ $item->id }}">
                                            <label class="quest-wr" for="order-delivery-{{ $delivery->id }}-company-{{ $item->id }}">{{ $item->name }}@include('modules.common.quest_block', ['text' => $item->description])
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-radio">
                                    <input {{ old('delivery-'.$delivery->id.'-company') == "custom" ? 'checked' : '' }}
                                           class="radio" id="order-delivery-{{ $delivery->id }}-company-custom" name="delivery-{{ $delivery->id }}-company" type="radio" value="custom">
                                    <label class="quest-wr" for="order-delivery-{{ $delivery->id }}-company-custom">
                                        Нет в списке
                                    </label>
                                </div>
                            </div>

                            <div class="delivery-custom_company">
                                @include('form.input', [
                               'placeholder' => 'Транспортная компания',
                               'required' => true,
                               'field_name' => 'delivery-'.$delivery->id.'-custom_company',
                               'field_id' => 'order-delivery-'.$delivery->id.'-custom_company',
                               'tabindex' => 11,
                               'errors' => $errors->order
                           ])
                            </div>




                        </div>

                    @else
                        <input type="hidden" name="custom_coordinate" id="custom_coordinate">
                        <div class="map-info">Куда доставить товар (щелкните по адресу)</div>
                        <div id="map-2" class="map" data-lat="{{ $delivery->coordinate[0] }}" data-lng="{{ $delivery->coordinate[1] }}" data-input="#custom_coordinate" data-textarea="#order-delivery-{{ $delivery->id }}-address"></div>
                        <div class="info">


                            @include('form.row', [
                               'label' => 'Точный адрес с городом',
                               'required' => true,
                               'field_name' => 'delivery-'.$delivery->id.'-address',
                               'field_id' => 'order-delivery-'.$delivery->id.'-address',
                               'field_type' => 'textarea',
                               'tabindex' => 10,
                               'class_left' => 'info-column__left',
                               'class_right' => 'info-column__right',
                               'errors' => $errors->order
                           ])

                            @include('form.row', [
                               'label' => 'Время доставки',
                               'required' => true,
                               'field_name' => 'delivery-'.$delivery->id.'-time',
                               'field_id' => 'order-delivery-'.$delivery->id.'-time',
                               'tabindex' => 11,
                               'class_left' => 'info-column__left',
                               'class_right' => 'info-column__right',
                               'errors' => $errors->order
                           ])

                        </div>
                    @endif

                    <div class="comment">
                        <textarea class="form-control" name="comment" placeholder="Примечание" >{{ old('comment')  }}</textarea>
                    </div>

                </div>
            @endforeach



        </div>

    </div>
@endif