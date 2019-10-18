<div class="content" style="margin-bottom: 15px">
    <div class="title m-b-md">
        Eve
    </div>

    <div class="links">
        <a href="{{route('home')}}">Home</a>
        <a href="{{route('availability')}}">Availability Search</a>
        <a href="{{route('codereadr')}}">CodeReadr Integration</a>
        @foreach(\App\AirtableView::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get() as $view)
            <a href="{{route('view', ['airtable_view' => $view])}}">{{$view->title}}</a>
        @endforeach
    </div>
</div>
