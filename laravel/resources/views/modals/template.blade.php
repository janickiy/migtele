<div class="modal" id="{{ $id }}">

    <div class="modal-header">
        <div class="modal-title">{{ $title }}</div>
        <div class="modal-description">{{ $description }}</div>
    </div>
    <div class="modal-content">

        @yield('modal-content')

    </div>

</div>