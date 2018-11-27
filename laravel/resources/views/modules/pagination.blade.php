<div class="pagination">

    @if($paginator->perPage() < 120 && $paginator->currentPage() != $paginator->lastPage())
        <form action="{{ url('/set-page-size') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="page_size" value="{{ $paginator->perPage() + 20 }}">
            {{--<button  class="pagination-load_more">Показать еще 20</button>--}}
        </form>
    @endif
    <div class="pagination-list">

        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="separator">...</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

    </div>

    <div class="pagination-page_size">
        <form action="{{ url('/set-page-size') }}" method="POST">
            {{ csrf_field() }}
            <label for="pagination-page-size">Выводить по</label>

            <select name="page_size" id="pagination-page-size">
                @for($i = 40; $i<=120; $i+=20)
                    <option {{ $paginator->perPage() == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </form>
    </div>

</div>