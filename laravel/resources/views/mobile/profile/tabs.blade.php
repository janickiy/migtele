<div class="tabs">
    <a class="{{ $selected == 'orders' ? 'selected' : '' }}" href="{{ url('/profile/orders') }}">Заказы</a>
    <a class="{{ $selected == 'edit' ? 'selected' : '' }}" href="{{ url('/profile') }}">Профиль</a>
    <a class="{{ $selected == 'settings' ? 'selected' : '' }}" href="{{ url('/profile/settings') }}">Настройки</a>
    <form action="{{ url(route('logout')) }}" method="POST">
        {{ csrf_field() }}
        <button type="submit" class="profile-submit">Выход</button>
    </form>
</div>