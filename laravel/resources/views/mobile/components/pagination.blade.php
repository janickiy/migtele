
@if($paginator->nextPageUrl())
    <button class="spoiler-open load-more" data-url="{{ $paginator->nextPageUrl() }}">Показать еще 10</button>
@endif