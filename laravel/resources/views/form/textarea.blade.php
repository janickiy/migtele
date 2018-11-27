<textarea
    tabindex="{{ $tabindex }}"
    class="form-control"
    name="{{ $field_name }}"
    id="{{ $field_id }}"
    placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
>{{ old($field_name) ? old($field_name) : (isset($field_value) ? $field_value : '') }}</textarea>
@if(isset($description_warning) && $description_warning)
    <div class="form-description-inline">{!! $description_warning !!}</div>
@endif
@if ($errors->has($field_name))
    <span class="help-block">
        <strong>{{ $errors->first($field_name) }}</strong>
    </span>
@endif