<input
   tabindex="{{ $tabindex }}"
   class="form-control"
   name="{{ $field_name }}"
   type="{{ isset($field_type) ? $field_type : 'text' }}"
   id="{{ $field_id }}"
   value="{{ old($field_name) ? old($field_name) : (isset($field_value) ? $field_value : '') }}"
   placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
   autocomplete="{{ isset($autocomplete) ? $autocomplete : 'on' }}"
>

@if ($errors->has(isset($error_name) ? $error_name : $field_name))
    <span class="help-block">
        <strong>{{ $errors->first(isset($error_name) ? $error_name : $field_name) }}</strong>
    </span>
@endif