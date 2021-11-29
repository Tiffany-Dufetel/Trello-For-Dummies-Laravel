@extends('layouts.app')

@section('content')

    <div class="input-new-board">
        <form action="{{route('overviews.store')}}" method="POST">
            @csrf
            <label for="title">Create a new board</label><br>
            <input type="text" name="title" id="title" class="form-control
            @if($errors->has('title')) is-invalid @endif">

            <button type="submit">Add Board</button>
            @if($errors->has('title'))
                <div id="validation">
                    {{ $errors->first('title') }}
                </div>
            @endif
        </form>
        @if(session()->has('success'))
            <div class="alert">
                {{ session()->get('success')}}
            </div>
        @endif
    </div>


{{-- affichage board en tant qu'invité --}}

<div class="boards-title">
    <p><span class="board-title">Boards you've been invited to participe to</span><br>
        (you can only add task)</p>
</div>

<div class="container-boards">
    @foreach ($boardsGuess as $boardGuess)
    {{-- @dd($boardGuess); --}}


        {{-- @foreach ($boardGuess->board as $board) --}}
            <div class="board">
                <p class="title-nonedit">{{$boardGuess->board->title}}</p>
                    @php
                        $cardsGuess = DB::table('cards')
                            ->where('table_id',$boardGuess->board->id)
                            ->get();
                    @endphp
                <div class="task">
                        <a href="{{route('overviews.show', $boardGuess->board->id)}}">
                            @foreach ($cardsGuess as $card)
                            <div class="card-border">
                                <p>
                                    {{ $card->card_title }}<br>
                                </p>
                            </div>
                        @endforeach
                        </a>
                </div>
                        <div class="buttons">
                            <a href="{{ route('tasks.index', $boardGuess->board->id) }}"><button>Add task</button></a>
                        </div>
            </div>
        {{-- @endforeach --}}
    @endforeach

    </div>

</div>




{{-- affichage des propres boards --}}

<div class="boards-title">
    <p><span class="board-title">your own boards</span><br>
        (you can only add task)</p>
</div>

    <div class="container-boards">
        @foreach ($boards as $board)
            <div class="board">

                {{-- <p class="created_by">board created by <i>{{$board->user->name}}</i></p> --}}
                @if ($user_id == $board->user_id)
                    <form action="{{ route('overviews.update', $board->id)}}" method="POST" >
                        @method('PUT')
                        @csrf
                        <input type="text" name="custom_title" id="custom_title" value="{{ $board->title }}">
                    </form>
                    @else
                    <p class="title-nonedit">{{ $board->title }}</p>
                @endif

                <div class="task">
                    @php
                        $cards = DB::table('titles')
                        ->join('cards','titles.id',"=",'cards.table_id')
                        ->where('cards.table_id', $board->id)
                        ->get();
                    @endphp
                        <a href="{{route('overviews.show', $board->id)}}">
                            @foreach ($cards as $card)
                                <div class="card-border">
                                    <p>
                                        {{ $card->card_title }}<br>
                                    </p>
                                </div>
                            @endforeach
                        </a>
                </div>
                        <div class="buttons">
                            <a href="{{ route('tasks.index', $board->id) }}"><button>Add task</button></a>

                            <form action="{{ route('overviews.destroy', $board->id) }}" method="POST">
                                @method("DELETE")
                                @csrf
                                <button>delete board</button>
                            </form>
                        </div>
            </div>
        @endforeach

        </div>

    </div>
@endsection
