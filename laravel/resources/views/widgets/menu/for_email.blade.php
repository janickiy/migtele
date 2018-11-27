<div class="menu" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; padding: 0; padding-left: 15px; vertical-align: baseline; width: 700px;">
    @foreach($pages as $page)
        <a href="{{ url($page->link) }}" style="border: 0; color: #fff; display: inline-block; font: inherit; font-size: 14px; margin: 0; padding: 0; padding-right: 23px; text-align: center; text-decoration: none; vertical-align: baseline;">{{ $page->name }}</a>
    @endforeach
</div>