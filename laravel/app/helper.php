<?php

function _setting($key)
{
    $setting = \App\Model\Setting::whereId($key)->first();
    return $setting ? $setting->value : $key;
}

function _price($value)
{
    return number_format(round($value),0,","," ");
}


function isPopularAsc()
{
    return checkSortNameInSession('popular_asc');
}

function isPopularDesc()
{
    return checkSortNameInSession('popular_desc');
}

function isPriceAsc()
{
    return checkSortNameInSession('price_asc');
}

function isPriceDesc()
{
    return checkSortNameInSession('price_desc');
}

function checkSortNameInSession($sort_name)
{
    return getSortName() == $sort_name;
}

function getSortName()
{
    return session('sort', 'popular_asc');
}

function getPageSize()
{
    $agent = new Jenssegers\Agent\Agent;
    return $agent->isRobot() || $agent->isDesktop() ? session('page_size', 40) : 10;
}
