<div class="modal {{ isset($class) ? $class : '' }}" id="{{ $id }}">

    <div class="modal-header">
        <div class="modal-title">{{ $title }}</div>
        <div class="modal-description">{{ $description }}</div>
    </div>
    <div class="modal-content">

        {{ $slot }}

    </div>
</div>