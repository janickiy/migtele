
<div class="tabs feedback-tabs">
    @foreach($items as $key=>$item)
        <a href="{{ url('/feedback/'.$key) }}" class="{{ $key == $slug ? 'active' : '' }}">{{ $item }}</a>
    @endforeach
</div>

<div class="form-wrapper">

    <form action="{{ url('/feedback/send') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="type" value="{{ $slug }}">
        {{ csrf_field() }}
        @include('components.feedback.forms.'.$slug)

        <div class="row">
            <div class="form-column__left">
            </div>
            <div class="form-column__right ">
                @include('form.recaptcha', ['errors' => $errors->feedback])
            </div>
        </div>

        <div class="row row-btn">
            <div class="form-column__left">
            </div>
            <div class="form-column__right ">
                <button type="submit" class="btn">Отправить</button>
            </div>
        </div>

        <div class="text-agreement text-agreement__feedback">
            Отправляя данные, Вы соглашаетесь с <a href='{{url('/zaschita_personalnih_dannih.htm')}}'>положением о защите персональных данных</a>.
        </div>



    </form>

</div>