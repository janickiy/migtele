@if(count($sub_categories))
    <div class="heading-2 second-title">Выбранный товар</div>


    <div class="trash-all">
        <form action="{{ url('/wishlist/clear') }}" method="POST">
            {{ csrf_field() }}
            <button type="submit"><span class="icon icon-trash"></span>Удалить все товары</button>
        </form>
    </div>

    @include('modules.category.products_with_sub_categories')

@else

    <p style="margin: 20px">Товар еще не добавлен в закладки</p>

@endif