<div class="counters">
    @foreach(\App\Model\Counter::getBottom() as $counter)
        <div class="counters-item">
            {!! $counter->html  !!}
        </div>
    @endforeach
</div>