@if(count($sliders))
    <div class="owl-carousel main-slider">
        @foreach($sliders as $slider)
            @continue(!$slider->img)
            <div><img src="{{ url($slider->img) }}" alt=""> </div>
        @endforeach
    </div>
@endif