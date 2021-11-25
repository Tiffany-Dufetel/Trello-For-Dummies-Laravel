@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <form action="{{route('overviews.store')}}" method="POST">
                    @csrf
                    <label for="title">Create a new board</label>
                    <input type="text" name="title" id="title" class="form-control
                    @if($errors->has('title')) is-invalid @endif">

                    @if($errors->has('title'))
                        <div id="validation" class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <button type="submit">Add Board</button>
                </form>
                @if(session()->has('success'))
                <div class="m-2 alert alert-success">
                    {{ session()->get('success')}}
                </div>
                @endif
            </div>


        </div>
        <div class="container">
            <div class="row justify-content-center">


                @foreach ($boards as $board)
                {{-- <a href = " {{ route('overviews.show',$board->id) }} "> --}}
                    <div class="border border-dark col-md-4 mr-2 mb-2 mt-2">

                        <h4 class="m-2 p-2 text-center">
                            <form action="{{ route('overviews.update', $board->id)}}" method="POST" >
                                @method('PUT')
                                @csrf
                                <input type="text" name="custom_title" id="custom_title" value="{{ $board->title }}">
                            </form>
                        </h4>

                        @php
                            $test= "coucou";
                            $cards = DB::table('titles')
                            ->join('cards','titles.id',"=",'cards.table_id')
                            ->where('cards.table_id', $board->id)
                            ->get();
                        @endphp
                        <a href="{{route('overviews.show', $board->id)}}">
                            @foreach ($cards as $card)
                                <p>
                                    {{ $card->card_title }}<br>
                                    {{-- {{ $card->content }}<br> --}}
                                    <hr>
                                </p>
                            @endforeach
                        </a>

                        <a href="{{ route('tasks.index', $board->id) }}"><button>Add task</button></a>

                        <form action="{{ route('overviews.destroy', $board->id) }}" method="POST">
                            @method("DELETE")
                            @csrf
                            <button>delete board</button>
                        </form>

                    </div>
                {{-- </a> --}}
                @endforeach

            </div>
        </div>

    </div>
@endsection
