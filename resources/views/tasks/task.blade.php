@extends('layouts.app')

@section('content')


    <div class="container-card">
            <p><a href="{{ route('overviews.index') }}">< go back to my boards</a></p>



            <h1>{{$board->title}}</h1>
            <a href="{{ route('tasks.index', $board->id) }}"><button>Add new task</button></a>



            <div class="guess">
                <form action="{{route('guesses.store', $board->id)}}" method="POST">
                    @csrf
                    <label for="guess">share your board with someone</label><br>
                    <input type="email" name="guess" id="guess">

                    <input type="hidden" name="table_id" value="{{$board->id}}">
                    <input type="hidden" name="user_id" value="{{$user_id}}">

                    <button>share</button>
                </form>
            </div>

            @if(session()->has('success'))
            <div class="alert">
                <p class="alert-task">{{session()->get('success')}}</p>
            </div>
            @endif

            <div class="cards">

            @foreach ($cards as $card)
            {{-- @dd($comment->comment) --}}
            <div class="card">
                <div class="btn-edit">
                    @if ($user_id == $card->user_id)

                        <form action="{{ route('tasks.update', $card->id)}}" method="POST" >
                            @method('PUT')
                            @csrf
                            <div class="container-title-content">
                                <div class="card-title">
                                    <label for="edit_card_title">title</label><br>
                                    <input type="text" name="edit_card_title" id="edit_card_title" value="{{$card->card_title}}"><br><br>
                                </div>
                                <div class="card-content">
                                    <label for="edit-content">description</label><br>
                                    <textarea name="edit_content" id="edit">{{$card->content}}</textarea>
                                </div>
                            </div>
                            <button type="submit"></button>
                        </form>


                        @else
                        <p class="div-nonedit-header">you cannot edit this card</p>
                        <div class="btn-nonedit">
                            <div class="card-title-nonedit">
                                title<br>
                                <p class="nonedit-card-content">{{$card->card_title}}</p>
                            </div>
                            <div class="card-content-nonedit">
                                description<br>
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


                <div class="comments">

                    <form action="{{ route('comments.store', $card->id) }}" method="POST">
                        @csrf
                        <label for="comment">write a comment</label><br>
                        <input type="hidden" name="id_card" id="id_card" value="{{$card->id}}" >
                        <input type="text" name="comment" id="comment">
                        <button>send</button>
                    </form>


                    <details>
                        <summary>show comments<br>↓</summary>
                        <div class="comment">

                                @foreach ( $card->comment as $comment)
                                    <p class="comment-name">name : <br>
                                    <span class="comment-content">{{$comment->content}}</span></p>
                                @endforeach


                        </div>
                    </details>
                </div>
            </div>

            @endforeach
        </div>
    </div>

@endsection
