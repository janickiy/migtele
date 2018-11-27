@if(isset($return_back) && $return_back)
    <div class="container">
        <a href="{{ redirect()->back()->getTargetUrl() }}" class="back-link">Вернуться назад</a>
    </div>
@else
    <div class="container">
        <a href="{{ url($url) }}" class="back-link">{{ $name }}</a>
    </div>
@endif

