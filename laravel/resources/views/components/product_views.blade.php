<h1 class="main-title">Просмотренный товар</h1>

@if(count($sub_categories))

    @include('modules.category.products_with_sub_categories')

@else

    <p style="margin: 20px">Вы еще не посещали страниц с товаром</p>

@endif