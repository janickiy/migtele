<div class="form-group__radio form-group__radio_2_columns profile-type">
    <div class="form-radio">
        @include('form.radio', [
            'label' => 'Физическое лицо',
            'field_name' => isset($field_name) ? $field_name : 'type',
            'field_id' => 'registration-radio-individual',
            'field_value' => \App\Model\User::INDIVIDUAL_TYPE,
            'tabindex' => 1,
            'checked' => old('type') ? (old('type') == \App\Model\User::INDIVIDUAL_TYPE) : (Auth::user() ? Auth::user()->type == \App\Model\User::INDIVIDUAL_TYPE : true)
        ])
    </div>
    <div class="form-radio">
        @include('form.radio', [
            'label' => 'Юридическое лицо',
            'field_name' => isset($field_name) ? $field_name : 'type',
            'field_id' => 'registration-radio-juridical',
            'field_value' => \App\Model\User::JURIDICAL_TYPE,
            'tabindex' => 1,
            'checked' => !is_null(old('type')) ? (old('type') == \App\Model\User::JURIDICAL_TYPE) : (Auth::user() ? Auth::user()->type == \App\Model\User::JURIDICAL_TYPE : false)
        ])


    </div>
</div>