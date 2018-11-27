<div class="row{{ $errors->has($field_name) ? ' has-error' : '' }}">
    <div class="{{ isset($class_left) ? $class_left : 'form-column__left' }}">
        <label class="{{ isset($description) ? 'quest-wr' : '' }}" for="{{ $field_id }}">{{ $label }} @if($required)<span class="required">*</span>@endif
            @if(isset($description))
                <span class="quest-block"></span><span class="quest-block__text">{{ $description }}</span>
            @endif
        </label>
    </div>
    <div class="{{ isset($class_right) ? $class_right : 'form-column__right' }}">
        @if(isset($field_type) && $field_type == 'textarea')
            @include('form.textarea')
        @elseif(isset($field_type) && $field_type == 'select')
            @include('form.select')
        @else
            @include('form.input', [
                'field_name' => $field_name,
                'field_value' => isset($field_value) ? $field_value : '',
                'field_id' => $field_id,
                'tabindex' => $tabindex,
                'errors' => isset($errors) ? $errors : '',
                'autocomplete' => isset($autocomplete) ? $autocomplete : ''
            ])
        @endif
    </div>
</div>