<div class="form-checkbox">
    <input type="hidden" name="{{ $field_name }}" value="0">
    <input {{ $checked ? 'checked' : '' }} tabindex="{{ $tabindex }}" class="checkbox" id="{{ $field_id }}" type="checkbox" name="{{ $field_name }}" value="1">
    <label class="form-checkbox" for="{{ $field_id }}">{{ $label }}</label>
</div>