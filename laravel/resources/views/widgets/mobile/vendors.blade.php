<div id="vendor">

    <div class="container">
        <div class="heading-1">Товар по производителям</div>

        <div class="vendor-list">


            @for($i=0; $i<=5; $i++)
                @break(!isset($vendors[$i]))
                @include('widgets.mobile.components.vendor', ['vendor' => $vendors[$i]])
            @endfor

            @if(count($vendors) > 6)
                <button class="spoiler-open">Показать все</button>
                <div class="spoiler">
                    @for($i=5; $i<=count($vendors)-1; $i++)
                        @break(!isset($vendors[$i]))
                        @include('widgets.mobile.components.vendor', ['vendor' => $vendors[$i]])
                    @endfor
                </div>
            @endif
        </div>
    </div>

</div>

</div>