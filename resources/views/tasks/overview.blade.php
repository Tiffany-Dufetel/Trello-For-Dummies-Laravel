@extends('layouts.app')

@section('content')
    {{-- div contenant input creation de tableau --}}
    <div class="input-new-board">
        {{-- form pour créer un tableau --}}
        <form action="{{route('overviews.store')}}" method="POST">
            @csrf
            <label for="title">Create a new board</label><br>
            <input type="text" name="title" id="title">
            <button type="submit">Add Board</button>
                @if($errors->has('title'))
                    <div id="validation">
                        {{ $errors->first('title') }}
                    </div>
                @endif
        </form>
            {{-- affichage alerte --}}
            @if(session()->has('success'))
                <div class="alert">
                    {{ session()->get('success')}}
                </div>
            @endif
    </div>

{{-------- affichage board en tant qu'invité --------}}
@if(count($boardsGuess)>0)
    {{-- affichage du titre de la section --}}
    <div class="boards-title">
        <p>
            <span class="board-title">
                Boards you've been invited to participe to
            </span><br>
                (you can only add task)
        </p>
    </div>
    {{-- div qui contient les tableaux en tant qu'invité --}}
    <div class="container-boards">
        {{-- condition: si il y a des tableaux --}}
            {{-- boucle pour afficher les tableaux en tant qu'invité --}}
            @foreach ($boardsGuess as $boardGuess)
            {{-- @dd($boardGuess) --}}
                {{-- div contenant un tableau invité --}}
                <div class="board">
                    <p class="created_by">board created by <span class="user_name">{{$boardGuess->board->user->name}}</span></p>
                    <p class="title-nonedit">{{$boardGuess->board->title}}</p>
                        {{-- requete pour récupérer les bonnes cartes --}}
                        @php
                            $cardsGuess = DB::table('cards')
                                ->where('table_id',$boardGuess->board->id)
                                ->get();
                        @endphp
                    {{-- div contenant les cartes --}}
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
            @endforeach
    </div>
@endif
    {{-- si il n'ya pas de tableaux, affiche un message --}}

{{-------- affichage des propres boards ---------}}
    {{-- affichage du titre de la section --}}
    <div class="boards-title">
        <p>
            <span class="board-title">
                your own boards
            </span>
        </p>
    </div>

    {{-- div qui contient les tableaux propriétaire --}}
    <div class="container-boards">

        @if (count($boards)>0)
            {{-- boucle pour afficher les tableaux propriétaire --}}
            @foreach ($boards as $board)
                {{-- div contenant un tableau propriétaire --}}
                <div class="board">
                    <p class="created_by">board created by <span class="user_name">{{$board->user->name}}</span></p>
                    @if ($user_id == $board->user_id)
                        <form action="{{ route('overviews.update', $board->id)}}" method="POST" >
                            @method('PUT')
                            @csrf
                            <input type="text" name="custom_title" id="custom_title" value="{{ $board->title }}">
                        </form>
                        @else
                        <p class="title-nonedit">{{ $board->title }}</p>
                    @endif
                    {{-- div contenant les cartes --}}
                    <div class="task">
                            {{-- requete pour recupérer les bonnes cartes --}}
                            @php
                                $cards = DB::table('titles')
                                    ->join('cards','titles.id',"=",'cards.table_id')
                                    ->where('cards.table_id', $board->id)
                                    ->get();
                            @endphp
                        <a href="{{route('overviews.show', $board->id)}}">
                            {{-- boucle pour afficher les cartes --}}
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
                        {{-- bouton pour rajouter une carte au tableau --}}
                        <a href="{{ route('tasks.index', $board->id) }}">
                            <button>Add task</button>
                        </a>
                        {{-- bouton pour supprimer le tableau --}}
                        <form action="{{ route('overviews.destroy', $board->id) }}" method="POST">
                            @method("DELETE")
                            @csrf
                            <button>delete board</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p class="no-board-message">Let's create your first board.</p>
        @endif
    </div>
@endsection
