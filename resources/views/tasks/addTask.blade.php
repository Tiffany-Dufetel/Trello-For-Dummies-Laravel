@extends('layouts.app')

@section('content')
<h1>add a new task</h2><br>
    <div class="container-profile-edit">
        <p><a href="{{ url()->previous() }}">< go back</a></p>

        @if(session()->has('success'))
            <div class="alert">
                <p class="alert">{{session()->get('success')}}</p>
            </div>
        @endif

        <div class="container-form">
                <form action="{{ route('tasks.store', $id) }}" method="POST">
                @csrf
                <label for="title">Title</label><br>
                <input type="text" name="title" id="title"><br>

                @if($errors->has('title'))
                    <div id="validation" class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif

                <label for="content">Description</label><br>
                <textarea name="content" id="content"></textarea><br>

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
