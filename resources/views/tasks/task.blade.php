@extends('layouts.app')

@section('content')

{{-- div qui contient toute la page --}}
    <div class="container-card">

        <p><a href="{{ route('overviews.index') }}">< go back to my boards</a></p>
            <h1>{{$board->title}}</h1>
            {{-- affiche le nom du créateur du tableau --}}
            @foreach ($boardUser as $user)
                <p class="create_user">board created by <b>{{$user->user->name}}</b></p><br><br>
            @endforeach
            <a href="{{ route('tasks.index', $board->id) }}"><button>Add new task</button></a>
                {{-- condition pour afficher l'input guess seulement si propriétaire du tableau --}}
                @if ($user_id == $board->user_id)
                    {{-- div qui contient le form guess --}}
                    <div class="guess">
                        {{-- formulaire pour inviter une personne au tableau --}}
                        <form action="{{route('guesses.store', $board->id)}}" method="POST">
                            @csrf
                            <label for="guess">share your board with someone</label><br>
                            {{-- affichage d'erreur --}}
                                @if($errors->has('guess'))
                                    <div id="validation" class="invalid-feedback">
                                        {{ $errors->first('guess') }}
                                    </div>
                                @endif
                            <input type="email" name="guess" id="guess">
                            <input type="hidden" name="table_id" value="{{$board->id}}">
                            <input type="hidden" name="user_id" value="{{$user_id}}">

                            <button>share</button>
                        </form>
                    </div>
                @endif
            {{-- affichage alerte success --}}
            @if(session()->has('success'))
                <div>
                    <p class="alert-task">{{session()->get('success')}}</p>
                </div>
            @endif

            <div class="cards">
                {{-- boucle qui affiche les cartes du tableau --}}
                @foreach ($cards as $card)
                    {{-- div qui contient tout les éléments de la carte --}}
                    <div class="card">
                        {{-- div des conditions contenant le titre et description de la carte --}}
                        <div class="btn-edit">
                            <p class="posted-by">card posted by <span class="user_name"><b>{{$card->user->name}}</b></span></p>

                            {{-- condition si propriétaire du tableau --}}
                            @if ($user_id == $card->user_id)
                                {{-- formulaire d'édition de la carte --}}
                                <form action="{{ route('tasks.update', $card->id)}}" method="POST" >
                                    @method('PUT')
                                    @csrf
                                    <div class="container-title-content">
                                        <div class="card-title">
                                            <label for="edit_card_title"><u>title</u></label><br>
                                                <span id="hide"></span><input id="txt" type="text" name="edit_card_title" value="{{$card->card_title}}">
                                        </div>
                                        <div class="card-content">
                                            <label for="edit-content"><u>description</u></label><br>
                                            <textarea name="edit_content" id="autoresizing">{{$card->content}}</textarea>
                                        </div>
                                    </div>
                                    <button type="submit"></button>
                                </form>

                                @else
                                <p class="div-nonedit-header">you cannot edit this card</p>
                                {{-- div non propriétaire --}}
                                <div class="btn-nonedit">
                                    <div class="card-title-nonedit">
                                        <u>title</u><br>
                                        <p class="nonedit-card-content">{{$card->card_title}}</p>
                                    </div>
                                    <div class="card-content-nonedit">
                                        <u>description</u><br>
                                        <p class="nonedit-card-content">{{$card->content}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($user_id == $card->user_id)
                            <div class="btn-delete">
                                <form action="{{ route('tasks.destroy', $card->id) }}" method="POST">
                                    @method("DELETE")
                                    @csrf
                                    <button>delete card</button>
                                </form>
                            </div>
                        @endif

                        {{-- div qui contient les commentaires + input d'envoi --}}
                        <div class="comments">
                            {{-- formulaire de redaction de commentaire --}}
                            <form action="{{ route('comments.store', $card->id) }}" method="POST">
                                @csrf
                                <label for="comment">write a comment</label><br>
                                    @if($errors->has('comment'))
                                        <div id="validation" class="invalid-feedback">
                                            {{ $errors->first('comment') }}
                                        </div>
                                    @endif
                                <input type="hidden" name="id_card" id="id_card" value="{{$card->id}}" >
                                <input type="text" name="comment" id="comment">
                                <button>send</button>
                            </form>

                            {{-- affichage des commentaires --}}
                            <details>
                                <summary>show comments<br>↓</summary>
                                <div class="comment">
                                    @foreach ($card->comment as $comment)
                                        <p class="comment-name">{{$comment->user->name}} said : <br>
                                        <span class="comment-content">{{$comment->content}}</span>
                                    </p>
                                    @endforeach
                                </div>
                            </details>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    <script>
        //fonction autosize input dans 'task'
        $(function() {
        $('#hide').text($('#txt').val());
        $('#txt').width($('#hide').width());
        }).on('input', function() {
        $('#hide').text($('#txt').val());
        $('#txt').width($('#hide').width());
        });
    </script>





@endsection
