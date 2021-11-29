@extends('layouts.app')

@section('content')
<h1>Edit your profile</h2><br>
    <div class="container-profile-edit">
        <p><a href="{{ route ('overviews.index') }}">< back to my boards</a></p>

        @if(session()->has('success'))
            <div class="alert">
                <p class="alert">{{session()->get('success')}}</p>
            </div>
        @endif

        <div class="container-form">
            <form action="{{route('profile-edit.update')}}" method="POST">
                @method('PUT')
                @csrf
                <label for="name">NAME</label><br>
                <input type="text" name="name" id="name" value="{{$user->name}}"><br>
                    @if($errors->has('name'))
                        <div id="validation" class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif

                <label for="email">EMAIL</label><br>
                <input type="text" name="email" id="email" value="{{$user->email}}"><br>
                    @if($errors->has('email'))
                        <div id="validation" class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                <label for="password">PASSWORD</label><br>
                <input type="password" name="password" id="password"><br>
                    @if($errors->has('password'))
                        <div id="validation" class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif


                <button type="submit">submit</button>
            </form>
        </div>

        <div class="edit-guess">
            <h1>Edit your guesses</h2><br>

                <table>
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Board title</th>
                            <th>Delete</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($boardsGuess as $boardGuess)

                        <tr>
                            <td>
                                {{$boardGuess->guess}}
                            </td>
                            <td>
                                {{$boardGuess->board->title}}
                            </td>
                            <td>
                                <form action="{{route('guesses.destroy', $boardGuess->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button>x</button>
                                </form>

                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
        </div>
    </div>
@endsection
