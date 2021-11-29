@extends('layouts.app')

@section('content')
<div class="container-welcome">
    <div class="row justify-content-center">

        @php
            $checkId = Auth::id();
        @endphp

        @isset($checkId)
            <button type="button" class="btn btn-dark">
                <a href="{{ route('overviews.index')}}">View my boards</a>
            </button>
            <button type="button" class="btn btn-dark">Show my profile</button>
        @endisset

        @empty($checkId)
            <div class="welcome">
                <h1>The All-In-One Toolkit <br>for Working Remotely.</h1>
                <p><b>Before TFD</b>: Projects feel scattered, things slip, it’s tough to <br> see where things stand,and people are stressed.<br>
                    <b>After TFD</b>: Everything’s organized in one place, you’re on top of <br>things, progress is clear, and a sense of calm sets in.</p>

                    <a href="{{ route('login') }}"><button>give TFD a try</button></a>
            </div>
        @endempty
    </div>
</div>
@endsection
