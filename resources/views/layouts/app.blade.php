<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar py-0 navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img height="50" src="{{ asset('images/logo/logo-shop.png') }}" alt="">
                    Aries Shoes
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    @guest
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-circle-user me-2 fs-5"></i>{{ __('account') }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">
                                            <i class="fa-solid fa-right-to-bracket me-1"></i>
                                            {{ __('login') }}
                                        </a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">
                                            <i class="fa-solid fa-user-plus me-1"></i>
                                            {{ __('register') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @else
                        <div class="btn-group">
                            <button type="button" class="btn py-1 dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-inline-block avatar">
                                    @if (Auth::user()->image)
                                        <img src="{{ asset('images/users/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                    @else
                                        <img src="{{ asset('images/users/img.png') }}" alt="{{ Auth::user()->name }}">
                                    @endif
                                </div>
                                {{ Auth::user()->fullname }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="nav-item">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-from-bracket me-1"></i>
                                        {{ __('logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest

                    @include('partials/language_switcher')
                </div>
            </div>
        </nav>

        <main class="py-4 px-2">
            @if ($message = Session::get('success'))
                <div class="custom-alert-success custom-alert mx-2" id="flash">
                    <p class="btn custom-btn-success py-1">{{ $message }}</p>
                </div>
                @php
                    session()->forget('success');
                @endphp
            @elseif ($message = Session::get('error'))
                <div class="alert alert-danger custom-alert py-2 ps-2 pe-5" id="flash">
                    {{ $message }}
                    <a href="#" class="close float-end text-decoration-none" data-dismiss="alert" aria-label="close">X</a>
                </div>
                @php
                    session()->forget('error');
                @endphp
            @endif
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/script.js') }}" defer></script>
</body>
</html>
