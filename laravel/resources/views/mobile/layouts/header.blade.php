<header class="header nav-bar">
    @include('mobile.components.nav_bar')
</header>

<div class="container">

    <div class="search">
        <form method="GET" action="{{ url('/search') }}" class="search-form">
            <span class="icon-search"></span>
            <input type="text" name="search_text" placeholder="Поиск">
            <button type="submit">Найти</button>
        </form>
    </div>

</div>