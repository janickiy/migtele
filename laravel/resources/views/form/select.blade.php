<select tabindex="{{ $tabindex }}"
        class="form-control"
        name="{{ $field_name }}"
        id="{{ $field_id }}"
>
    @foreach($options as $key=>$option)
        <option {{ old($field_name) ?
        (old($field_name) == $key ? 'selected' : '') :
        (isset($field_value) ? ($field_value == $key ? 'selected' : '') : '') }} value="{{$key}}">{{$option}}</option>
    @endforeach
</select>
@if ($errors->has($field_name))
    <span class="help-block">
        <strong>{{ $errors->first($field_name) }}</strong>
    </span>
@endif