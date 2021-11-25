@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p><a href="{{ route('overviews.index') }}">< go back</a></p>
            @if(session()->has('success'))
                <p>{{ session()->get('success')}}</p>
            @endif
            <form action="{{ route('tasks.store', $id) }}" method="POST">
                @csrf
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control
                @if($errors->has('title')) is-invalid @endif">

                @if($errors->has('title'))
                    <div id="validation" class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif

                <label for="content">Description</label>
                <input type="text" name="content" id="content" class="form-control
                @if($errors->has('title')) is-invalid @endif">

                @if($errors->has('content'))
                    <div id="validation" class="invalid-feedback">
                        {{ $errors->first('content') }}
                    </div>
                @endif


                <button type="submit">Add Task</button>
            </form>
        </div>
    </div>


</div>
@endsection
