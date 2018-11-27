@php

    $url = '';

    if(isset($category)){

        if(isset($vendor)){
            $url = $category->getUrlWithVendorAndSubcategory($vendor, $items[$i]);
        }
        elseif(isset($is_vendor)){
            $url = $category->getUrlWithVendor($items[$i]);
        }else{
            $url = $category->getUrlWithSubcategory($items[$i]);
        }

    }
    else{
        $url = $items[$i]->url;
    }

@endphp

<a href="{{  url($url) }}">{{ $items[$i]->name }}</a>