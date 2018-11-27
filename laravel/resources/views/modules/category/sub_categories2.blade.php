@if(count($sub_categories2))

    <div class="sub-categories__list">

        @foreach($sub_categories2->unique() as $sub_category2)
            @if(isset($selected_sub_category2) && $selected_sub_category2 && $selected_sub_category2->id == $sub_category2->id)
                <div class="sub-categries__list_item">
                    <div class="img">
                        <img src="{{ url('/images/sub_category'.$sub_category2->img) }}" alt="{{ $sub_category2->name }}" >
                    </div>
                    <div class="title">{{ $sub_category2->name }}<a href="{{ !$selected_vendor ? url($category->getUrlWithSubcategory($sub_category)) : url($category->getUrlWithVendorAndSubcategory($selected_vendor, $sub_category))  }}" class="delete"></a></div>
                </div>
            @else
                <a href="{{ url($category->getUrlSubcategory2($sub_category, $sub_category2, $selected_vendor)) }}" class="sub-categries__list_item">
                    <div class="img">
                        <img src="{{ url('/images/sub_category'.$sub_category2->img) }}" alt="{{ $sub_category2->name }}">
                    </div>
                    <div class="title">{{ $sub_category2->name }}</div>
                </a>
            @endif
        @endforeach





    </div>

@endif