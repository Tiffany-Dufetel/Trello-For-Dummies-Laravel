@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p><a href="{{ route('overviews.index') }}">< go back</a></p>

            @if(session()->has('success'))
                <p class="alert">{{session()->get('success')}}</p>
            @endif

            <h1>{{$board->title}}</h1>

            @foreach ($cards as $card)
                <form action="{{ route('tasks.update', $card->id)}}" method="POST" >
                    @method('PUT')
                    @csrf
                    <input type="text" name="edit_card_title" id="edit_card_title" value="{{$card->card_title}}"><br>
                    <input type="text" name="edit_content" id="edit_content" value="{{$card->content}}">
                    <button type="submit"></button>
                </form>

                <form action="{{ route('tasks.destroy', $card->id) }}" method="POST">
                    @method("DELETE")
                    @csrf
                    <button>delete card</button>
                </form>



                <hr>
            @endforeach
        </div>
    </div>

</div>
@endsection
