@extends('layouts.app')

@section('content')
    <h1>add a new task</h2><br>
        {{-- div contenant toute la page d'edition de profile --}}
        <div class="container-profile-edit">
            <p><a href="{{ url()->previous() }}">< go back</a></p>
                {{-- affichage d'alerte --}}
                @if(session()->has('success'))
                    <div class="alert">
                        <p class="alert">{{session()->get('success')}}</p>
                    </div>
                @endif
            {{-- div class contenant le formulaire d'ajout de carte --}}
            <div class="container-form">
                <form action="{{ route('tasks.store', $id) }}" method="POST">
                    @csrf
                    <label for="title">Title</label><br>
                    <input type="text" name="title" id="title"><br>
                        {{-- affichage d'errer --}}
                        @if($errors->has('title'))
                            <div id="validation" class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif

                    <label for="content">Description</label><br>
                    <textarea name="content" id="content"></textarea><br>
                        {{-- affichage d'errer --}}
                        @if($errors->has('content'))
                            <div id="validation" class="invalid-feedback">
                                {{ $errors->first('content') }}
                            </div>
                        @endif
                    <button type="submit">Add Task</button>
                </form>
            </div>
        </div>
@endsection
