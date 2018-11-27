@extends('layouts.app')

@section('content')
<div class="col-sm-4 col-sm-offset-4">
    <form method="POST" action="{{url('auth/two-factor')}}">
        {{csrf_field()}}
        <h3>Enable Two-Factor Authentication</h3>
        <div class="row">
            <div class="col-xs-3">Country:</div>
            <div class="col-xs-9">
                <select id="authy-countries" name="country-code"></select>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">Cellphone:</div>
            <div class="col-xs-9">
                <input id="authy-cellphone" type="text" value="" name="authy-cellphone" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-xs-offset-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="send_sms" />
                        Send two-factor token via SMS
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-xs-offset-3">
                <button type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection

