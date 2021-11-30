<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>|| Trello for dummies ||</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('style.css')}}">

</head>
<body>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <p class="text-logo"><b>Trello</b> for dummies</p>
                    </a>
                </div>

                <div class="logged">
                    <ul>
                        @guest
                            @if (Route::has('login'))
                                <li class="btn-login">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="btn-register">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <div class="login">
                                <p>Hello, <span class="user_name">{{ Auth::user()->name }}</span>!
                                    <a href="{{ route('profile-edit.index') }}">
                                        <img src="{{asset('pen.png')}}" width="15px">
                                    </a>
                                </p>

                                <p class="btn-logout">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </p>
                            </div>
                        @endguest
                    </ul>
                    </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer>&copy; 2021, Trello for dummies</footer>

</body>
</html>
