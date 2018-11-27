<div class="form-group profile-type">
    <div class="label">{{ $label }}:</div>

    <?php
     $type = old('type') ? old('type') : (Auth::user() ? Auth::user()->type : '1');
     $field_name = isset($field_name) ? $field_name : 'type';

    ?>

    <div class="form-group__radio_inline">
        <div class="form-radio">
            <input {{  $type == \App\Model\User::INDIVIDUAL_TYPE ? 'checked' : '' }} type="radio" id="type-individual" class="radio" name="{{$field_name}}" value="{{ \App\Model\User::INDIVIDUAL_TYPE }}">
            <label for="type-individual">Физическое лицо</label>
        </div>
        <div class="form-radio">
            <input {{ $type == \App\Model\User::JURIDICAL_TYPE ? 'checked' : '' }} type="radio" id="type-juridical" class="radio" name="{{$field_name}}" value="{{\App\Model\User::JURIDICAL_TYPE}}">
            <label for="type-juridical">Юридическое лицо</label>
        </div>
    </div>

</div>