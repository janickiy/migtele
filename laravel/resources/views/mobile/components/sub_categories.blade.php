
@if(count($category->sub_categories))

    <div class="heading-3 category-list__title">{{ $category->name }}</div>

    <div class="category-list">
        @foreach($category->sub_categories->unique() as $sub_category)
            @if(isset($selected_sub_category) && $selected_sub_category->id == $sub_category->id)
                <div class="category-list__item">{{ $sub_category->name }}<a href="{{ url($category->url) }}" class="delete"></a></div>
            @else
                <a href="{{ !$selected_vendor ? url($category->getUrlWithSubcategory($sub_category)) : url($category->getUrlWithVendorAndSubcategory($selected_vendor, $sub_category))  }}">{{ $sub_category->name }}</a>
            @endif
        @endforeach
    </div>

@endif
