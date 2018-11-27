@extends('admin.layout')

@section('title', 'Подробности')

@section('css')

    {!! Html::style('/admin/js/plugin/tablesaw/tablesaw.css') !!}

@endsection

@section('content')

    <h2>{{ $title }}</h2>
    <div class="row-fluid">

        <div class="col">

            <p><a href="{{ URL::route('admin.ordersrailway.list') }}">назад</a></p>
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">

                <div>
                    <p>

                    <h3>Пользователь: {{ isset($order->user->login) && $order->user->login ?  $order->user->login : 'незарегистрированный' }}</h3>
                    <h3>Идентификатор заказа: {{ isset($orderDetails['OrderId']) ? $orderDetails['OrderId'] : '-' }}</h3>
                    <h3>Сумма за бронирование: {{ isset($orderDetails['Amount']) ? $orderDetails['Amount'] : '-' }}</h3>

                    <h3>Пассажиры</h3>
                    <table class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th data-hide="phone">Идентификатор пользователя</th>
                            <th data-class="expand">ФИО</th>
                            <th data-hide="phone">Пол</th>
                            <th data-hide="phone,tablet">Дата рождения</th>
                            <th data-hide="phone,tablet">Место рождения</th>
                            <th data-hide="phone,tablet">Граждансво</th>
                            <th data-hide="phone,tablet">Тип документа</th>
                            <th data-hide="phone,tablet">№ документа</th>
                            <th data-hide="phone,tablet">Срок действия документа</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($passengers as $passenger)
                            <tr>
                                <td>{{ isset($passenger['Index']) ? $passenger['Index']:'' }}</td>
                                <td data-hide="phone">{{ isset($passenger['OrderCustomerId']) ? $passenger['OrderCustomerId'] : '' }}</td>
                                <td data-class="expand">{{ isset($passenger['LastName']) ? $passenger['LastName'] : '' }}  {{ isset($passenger['FirstName']) ? $passenger['FirstName'] : '' }} {{ isset($passenger['MiddleName']) ? $passenger['MiddleName'] : '' }}</td>
                                <td data-hide="phone">{{ isset($passenger['Sex']) ? $references['sex'][$passenger['Sex']] :'-' }}</td>
                                <td data-hide="phone,tablet">{{ isset($passenger['BirthDate']) ? App\Helpers\DateTimeHelpers::convertDate($passenger['BirthDate']) :'' }}</td>
                                <td data-hide="phone,tablet">{{ isset($passenger['BirthPlace']) ? $passenger['BirthPlace']:'' }}</td>
                                <td data-hide="phone,tablet">{{ isset($passenger['CitizenshipCode']) ? $passenger['CitizenshipCode']:'' }}</td>
                                <td data-hide="phone,tablet">{{ isset($passenger['DocumentType']) ?  $references['documentType'][$passenger['DocumentType']]:'' }}</td>
                                <td data-hide="phone,tablet">{{ isset($passenger['DocumentNumber']) ? $passenger['DocumentNumber']:''}}</td>
                                <td data-hide="phone,tablet">{{ isset($passenger['DocumentValidTill']) ? App\Helpers\DateTimeHelpers::convertDate($passenger['DocumentValidTill']):'' }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                   @if($order['orderStatus'] == 1) <a href="{{ URL::route('admin.ordersrailway.editpassenger',['id'=> $id]) }}"  class="btn btn-success btn-flat pull-left">Редактировать</a> @endif

                    <br><br>

                    <h3>Список документов</h3>
                    <table class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th>Идентификатор бланка</th>
                            <th>Сумма за бронирование</th>
                            <th>Номер билета</th>
                            <th>Тариф</th>
                            <th>Возможность выбора<br>предоплаченного питания</th>
                            <th>Суммы и ставки НДС по электронному билету</th>
                            <th>Базовый тариф</th>
                            <th>Стоимость билетной части<br>по электронному билету</th>
                            <th>Информация о тарифе</th>
                            <th>Информация о предоплаченном питании</th>
                            <th>Стоимость за предоставляемый сервис</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($documents[0] as $document)
                            <tr>
                                <td>{{ isset($document['OrderItemBlankId']) ? $document['OrderItemBlankId']:'' }}</td>
                                <td>{{ isset($document['Amount']) ? $document['Amount']:'' }}</td>
                                <td>{{ isset($document['Number']) ? $references['Number']:'' }}</td>
                                <td>{{ isset($document['TariffType']) ? $references['TariffType'][$document['TariffType']]:'' }}</td>
                                <td>{{ isset($document['IsMealOptionPossible']) && $document['IsMealOptionPossible'] ? 'да':'нет' }}</td>
                                <td>
                                    {!! isset($document['VatRateValues'][0]['Rate']) && isset($document['VatRateValues'][0]['Value']) ? 'Ставка и сумма НДС со стоимости перевозки: ' .$document['VatRateValues'][0]['Rate']. ', ' .$document['VatRateValues'][0]['Value']. ' <br>':'' !!}
                                    {!! isset($document['VatRateValues'][1]['Rate']) && isset($document['VatRateValues'][1]['Value']) ? 'Ставка и сумма НДС со стоимости сервиса: ' .$document['VatRateValues'][1]['Rate']. ', ' .$document['VatRateValues'][1]['Value']. '<br>':'' !!}
                                    {!! isset($document['VatRateValues'][2]['Rate']) && isset($document['VatRateValues'][2]['Value']) ? 'Ставка и сумма со стоимости комиссионного сбора: ' .$document['VatRateValues'][2]['Rate']. ', ' .$document['VatRateValues'][2]['Value']. '':'' !!}
                                </td>
                                <td>{{ isset($document['BaseFare']) ? $document['BaseFare']:'' }}</td>
                                <td>{{ isset($document['AdditionalPrice']) ? $document['AdditionalPrice']:'' }}</td>
                                <td>
                                    {!! isset($document['TariffInfo']['TariffType']) ?  $references['TariffType'][$document['TariffInfo']['TariffType']]:''!!}
                                </td>
                                <td>
                                    код: {!! isset($document['PrepaidMealInfo']['MealOptionCode']) ? $document['PrepaidMealInfo']['MealOptionCode']:'' !!}
                                    <br>
                                    {{ isset($document['PrepaidMealInfo']['MealName']) ? $document['PrepaidMealInfo']['MealName']:'' }}
                                    <br>
                                    {{ isset($document['PrepaidMealInfo']['Description']) ? $document['PrepaidMealInfo']['Description']:'' }}
                                    <br>
                                </td>
                                <td>{{ isset($document['ServicePrice']) ? $document['ServicePrice']:'' }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <br><br>

                    <h3>Ответ на запрос на бронирование ЖД-билетов</h3>

                    <table class="table table-striped table-bordered table-hover tablesaw-swipe" data-tablesaw-mode="swipe" width="100%">
                        <thead>
                        <tr >
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">#</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">{!! $references['RailwayReservationResponse']['OrderItemId'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['Amount'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['Fare'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['Tax'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['ReservationNumber'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['ConfirmTill'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['ClientFeeCalculation'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['OriginStation'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['DestinationStation'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['OriginStationCode'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['DestinationStationCode'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['OriginTimeZoneDifference'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['DestinationTimeZoneDifference'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['DepartureDateTime'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['ArrivalDateTime'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['LocalDepartureDateTime'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['LocalArrivalDateTime'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['TrainNumber'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['BookingTrainNumber'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['TrainNumberToGetRoute'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['CarType'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['CarNumber'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['ServiceClass'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['InternationalServiceClass'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['TimeDescription'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['Carrier'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['CarrierCode'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['CarrierTin'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['CountryCode'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['IsMealOptionPossible'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['IsAdditionalMealOptionPossible'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['MealGroup'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['BookingSystem'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['IsThreeHoursReservationAvailable'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['TripDuration'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['TrainDescription'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['CarDescription'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['IsSuburban'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['CabinGenderDescription'] !!}</th>
                            <th >{!! $references['RailwayReservationResponse']['IsExchange'] !!}</th>
                            <th width="180px">{!! $references['RailwayReservationResponse']['DepartureDateFromFormingStation'] !!}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orderDetails['ReservationResults'] as $orderDetail)

                        <tr>
                            <td>{!! isset($orderDetail['Index']) ?  $orderDetail['Index']:''!!}</td>
                            <td>{!! isset($orderDetail['OrderItemId']) ?  $orderDetail['OrderItemId']:''!!}</th>
                            <td>{!! isset($orderDetail['Amount']) ?  $orderDetail['Amount']:''!!}</td>
                            <td>{!! isset($orderDetail['Fare']) ?  $orderDetail['Fare']:''!!} </td>
                            <td>{!! isset($orderDetail['Tax']) ?  $orderDetail['Tax']:''!!} </td>
                            <td>{!! isset($orderDetail['ReservationNumber']) ?  $orderDetail['ReservationNumber']:''!!}</td>
                            <td>{!! isset($orderDetail['ConfirmTill']) ?  App\Helpers\DateTimeHelpers::convertDate($orderDetail['ConfirmTill']):''!!}</td>
                            <td>{!! isset($orderDetail['ClientFeeCalculation']) ?  $orderDetail['ClientFeeCalculation']:''!!}</td>
                            <td>{!! isset($orderDetail['OriginStation']) ?  $orderDetail['OriginStation']:''!!}</td>
                            <td>{!! isset($orderDetail['DestinationStation']) ?  $orderDetail['DestinationStation']:''!!}</td>
                            <td>{!! isset($orderDetail['OriginStationCode']) ?  $orderDetail['OriginStationCode']:''!!}</td>
                            <td>{!! isset($orderDetail['DestinationStationCode']) ?  $orderDetail['DestinationStationCode']:''!!}</td>
                            <td>{!! isset($orderDetail['OriginTimeZoneDifference']) ?  $orderDetail['OriginTimeZoneDifference']:''!!}</td>
                            <td>{!! isset($orderDetail['DestinationTimeZoneDifference']) ?  $orderDetail['DestinationTimeZoneDifference']:''!!}</td>
                            <td>{!! isset($orderDetail['DepartureDateTime']) ?  App\Helpers\DateTimeHelpers::convertDate($orderDetail['DepartureDateTime']):''!!}</td>
                            <td>{!! isset($orderDetail['ArrivalDateTime']) ?  App\Helpers\DateTimeHelpers::convertDate($orderDetail['ArrivalDateTime']):''!!}</td>
                            <td>{!! isset($orderDetail['LocalDepartureDateTime']) ?  App\Helpers\DateTimeHelpers::convertDate($orderDetail['LocalDepartureDateTime']) :''!!}</td>
                            <td>{!! isset($orderDetail['LocalArrivalDateTime']) ?  App\Helpers\DateTimeHelpers::convertDate($orderDetail['LocalArrivalDateTime']) :''!!}</td>
                            <td>{!! isset($orderDetail['TrainNumber']) ?  $orderDetail['TrainNumber']:''!!}</td>
                            <td>{!! isset($orderDetail['BookingTrainNumber']) ?  $orderDetail['BookingTrainNumber']:''!!}</td>
                            <td>{!! isset($orderDetail['TrainNumberToGetRoute']) ?  $orderDetail['TrainNumberToGetRoute']:''!!}</td>
                            <td>{!! isset($orderDetail['CarType']) ?  $orderDetail['CarType']:''!!}</td>
                            <td>{!! isset($orderDetail['CarNumber']) ?  $orderDetail['CarNumber']:''!!}</td>
                            <td>{!! isset($orderDetail['ServiceClass']) ? $orderDetail['ServiceClass']:''!!}</td>
                            <td>{!! isset($orderDetail['InternationalServiceClass']) ?  $orderDetail['InternationalServiceClass']:''!!}</td>
                            <td>{!! isset($orderDetail['TimeDescription']) ?  $orderDetail['TimeDescription']:''!!}</td>
                            <td>{!! isset($orderDetail['Carrier']) ?  $orderDetail['Carrier']:''!!}</td>
                            <td>{!! isset($orderDetail['CarrierCode']) ?  $orderDetail['CarrierCode']:''!!}</td>
                            <td>{!! isset($orderDetail['CarrierTin']) ?  $orderDetail['CarrierTin']:''!!}</td>
                            <td>{!! isset($orderDetail['CountryCode']) ?  $orderDetail['CountryCode']:''!!}</td>
                            <td>{!! isset($orderDetail['IsMealOptionPossible']) ?  $orderDetail['IsMealOptionPossible']:''!!}</td>
                            <td>{!! isset($orderDetail['IsAdditionalMealOptionPossible']) ?  $orderDetail['IsAdditionalMealOptionPossible']:''!!}</td>
                            <td>{!! isset($orderDetail['MealGroup']) ?  $orderDetail['MealGroup']:''!!}</td>
                            <td>{!! isset($orderDetail['BookingSystem']) ?  $orderDetail['BookingSystem']:''!!}</td>
                            <td>{!! isset($orderDetail['IsThreeHoursReservationAvailable']) ?  $orderDetail['IsThreeHoursReservationAvailable']:''!!}</td>
                            <td>{!! isset($orderDetail['TripDuration']) ?  $orderDetail['TripDuration']:''!!}</td>
                            <td>{!! isset($orderDetail['TrainDescription']) ?  $orderDetail['TrainDescription']:''!!}</td>
                            <td>{!! isset($orderDetail['CarDescription']) ?  $orderDetail['CarDescription']:''!!}</td>
                            <td>{!! isset($orderDetail['IsSuburban']) ?  $orderDetail['IsSuburban']:''!!}</td>
                            <td>{!! isset($orderDetail['CabinGenderDescription']) ?  $orderDetail['CabinGenderDescription']:''!!}</td>
                            <td>{!! isset($orderDetail['IsExchange']) ?  $orderDetail['IsExchange']:''!!}</td>
                            <td>{!! isset($orderDetail['DepartureDateFromFormingStation']) ?  App\Helpers\DateTimeHelpers::convertDate($orderDetail['DepartureDateFromFormingStation']):''!!}</td>
                        </tr>

                        @endforeach

                        </tbody>
                    </table>
                    <h3>Данные платежа</h3>

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </div>

    <script>

        TablesawConfig = {
            swipeHorizontalThreshold: 20, // default is 15
            swipeVerticalThreshold: 40 // default is 30
        };

    </script>

    {!! Html::script('/admin/js/plugin/tablesaw/tablesaw.js') !!}
    {!! Html::script('/admin/js/plugin/tablesaw/tablesaw-init.js') !!}

@endsection

@section('js')

    <script>

        $(document).ready(function () {

            $('.tree-checkbox').treeview({
                collapsed: true,
                animated: 'medium',
                unique: false
            });
        });

    </script>

@endsection