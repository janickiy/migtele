@if(count($category->sub_categories))
    <div class="categories">
        <div class="heading-2">Категории</div>

        <div class="categories-list {{ isset($selected_sub_category) ? 'categories-list__selected' : '' }}">
            @foreach($category->sub_categories->unique() as $sub_category)
                @if(isset($selected_sub_category) && $selected_sub_category->id == $sub_category->id)
                    <div class="categories-list__item">{{ $sub_category->name }}<a href="{{ url($category->url) }}" class="delete"></a></div>
                    @else
                <a href="{{ !$selected_vendor ? url($category->getUrlWithSubcategory($sub_category)) : url($category->getUrlWithVendorAndSubcategory($selected_vendor, $sub_category))  }}">{{ $sub_category->name }}</a>
                @endif
            @endforeach
        </div>

    </div>
@endif