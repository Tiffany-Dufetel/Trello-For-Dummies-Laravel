@extends('layouts.app')

@section('content')
    <div class="container-welcome">
        <div class="row justify-content-center">
            {{-- creation de la variable pour checker l'id --}}
            @php
                $checkId = Auth::id();
            @endphp

            {{-- condition: si il y a un id connecté afficher: --}}
            @isset($checkId)
                <div class="btn-home">
                    <a href="{{ route('overviews.index')}}">
                        <button type="button">
                            View my boards
                        </button>
                    </a>
                    <a href="{{ route('profile-edit.index') }}">
                        <button type="button">
                            Edit my profile
                        </button>
                    </a>
                </div>
            @endisset
            {{-- sinon: --}}
            @empty($checkId)
                <div class="welcome">
                    <h1>The All-In-One Toolkit <br>for Working Remotely.</h1>
                        <p>
                            <b>Before TFD</b>: Projects feel scattered, things slip, it’s tough to
                            <br> see where things stand,and people are stressed.<br>
                            <b>After TFD</b>: Everything’s organized in one place, you’re on top of
                            <br>things, progress is clear, and a sense of calm sets in.
                        </p>
                        <a href="{{ route('register') }}"><button>give TFD a try</button></a>
                </div>
            @endempty
        </div>
    </div>
@endsection
