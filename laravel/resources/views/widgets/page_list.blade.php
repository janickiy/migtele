<div class="pages-list">
    @foreach($pages as $page)
        <a href="{{ $page->link }}" class="{{ $page->id == $config['active_page_id'] ? 'active' : '' }}">
            <span class="img" style="background-image: url({{ $page->preview }})"></span>
            <span class="title">{{ $page->name }}</span>
        </a>
    @endforeach
</div>