<div class="row{{ $errors->has($field_name.'.0') ? ' has-error' : '' }}">
    <div class="form-column__left">
        <label for="{{ $field_id }}">{{ $label }} @if($required)<span class="required">*</span>@endif</label>
    </div>
    <div class="form-column__right">
        <div class="form-multiple">
            <div class="form-multiple__input">
                @foreach($fields as $k=>$field)
                    <div class="form-multiple__item">
                        <input tabindex="{{ $tabindex }}" class="form-control" name="{{$field_name}}[]" value="{{ old($field_name)[$k] ? old($field_name)[$k] : $field }}" type="text" id="{{ $field_id }}">
                        <div class="form-multiple__delete"><a href="#"></a></div>
                    </div>
                @endforeach
            </div>
            <div class="form-multiple__add"><a href="#"></a></div>
        </div>
        @if ($errors->has($field_name.'.0'))
            <div class="help-block">
                <strong>{{ $errors->first($field_name.'.0') }}</strong>
            </div>
        @endif
    </div>
</div>