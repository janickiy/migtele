<a href="{{ Auth::check() ? url('/profile') : '#login-form' }}" rel="{{ Auth::check() ? : 'modal:open' }}" class="header-line__menu_profile {{ Auth::check() ? 'header-line__menu_profile_auth' : 'open-modal' }}">
    <div class="icon icon-user"></div>
    <div class="info">
        <div class="title">{{ Auth::check() ? Auth::user()->name : 'Кабинет' }}</div>
        <div class="description">{{ Auth::check() ? 'Личный кабинет' : 'Войти на сайт' }}</div>
    </div>
    @if(Auth::check())
        <form action="{{ url(route('logout')) }}" method="POST">
            {{ csrf_field() }}
            <button type="submit" class="profile-submit">Выход</button>
        </form>
    @endif
</a>