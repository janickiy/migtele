<form method="GET" action="{{ url('/search') }}" class="{{ isset($class) ? $class : '' }} search-form">
    <input type="text" name="search_text" placeholder="Поиск" value="{{ Request::route('search_text') }}">
    <button type="submit">{{ isset($button_text) ? $button_text : '' }}</button>
</form>