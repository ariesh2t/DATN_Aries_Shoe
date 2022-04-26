<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

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
                <a class="col-2 navbar-brand" href="{{ url('/') }}">
                    <img height="50" src="{{ asset('images/logo/logo-shop.png') }}" alt="">
                    <div class="d-none d-md-inline">Aries Shoes</div>
                </a>
                <div class="row col-md-5 col-10">
                    @guest
                        <div class="btn-group col-8">
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
                        <div class="btn-group col-8 float-right">
                            <button type="button" class="btn py-1 dropdown-toggle d-flex align-items-center justify-content-end" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-inline-block avatar">
                                    <img src="{{ asset('images/users/' . Auth::user()->image->name) }}" alt="{{ Auth::user()->fullname }}">
                                </div>
                                <div class="d-none d-lg-inline">{{ Auth::user()->fullname }}</div>
                            </button>
                            <div class="d-flex align-items-center justify-content-end">
                                <i class="fa-regular fa-bell"></i>
                                <sup class="badge bg-warning" style="font-size: 8px">1</sup>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-start">
                                <li class="dropdown-item d-lg-none d-sm-block">
                                    {{ Auth::user()->fullname }}
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="{{ route('profile', Auth::user()) }}">
                                        <i class="fa-solid fa-address-card"></i>
                                        {{ __('profile') }}
                                    </a>
                                </li>
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

                    <div class="btn-group col-4">
                        @include('partials/language_switcher')
                    </div>
                </div>
            </div>
        </nav>
        @guest
        @else
            <div class="d-none d-md-block">
                <div class="container-fluid navbar justify-content-between shadow-sm" style="background: #fff">
                    <div></div>
                    <div class="js-navbar">
                        <ul class="list-unstyled d-flex m-0">
                            <li class="px-3 py-2"><a class="text-uppercase nav-a" href="{{ url('/') }}">{{ __('home') }}</a></li>
                            <li class="px-3 hover-subnav-brand py-2">
                                <a class="text-uppercase nav-a" href="">
                                    {{ __('brands') }}
                                    <i class="fa-solid fa-chevron-down"></i>
                                </a>
                                <div class="sub subnav-brand position-absolute p-3" style="width: 75vw">
                                    <ul class="row list-unstyled">
                                        @foreach ($brands as $brand)
                                            <div class="col-3">
                                                <li class="ps-2 py-1"><a class="nav-a" href="{{ route('brand', $brand->id) }}">{{ $brand->name }}</a></li>
                                            </div>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li class="px-3 hover-subnav-category py-2">
                                <a class="text-uppercase nav-a" href="">
                                    {{ __('categories') }}
                                    <i class="fa-solid fa-chevron-down"></i>
                                </a>
                                <div class="sub subnav-category position-absolute p-3" style="width: 75vw">
                                    <ul class="row list-unstyled">
                                        @foreach ($categories as $category)
                                            <div class="col-3">
                                                <li class="ps-2 py-1"><a class="nav-a" href="{{ route('category', $category->id) }}">{{ $category->name }}</a></li>
                                            </div>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li class="px-3 py-2"><a class="text-uppercase nav-a" href="{{ route('products') }}">{{ __('products') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <form action="{{ route('products') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="name_value" value="{{ request()->name_value ?? '' }}" class="form-control" placeholder="{{ __('enter') . __("product name")}}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="nav-scroll-top d-none d-md-block">
                <div class="navbar justify-content-between align-items-center shadow-sm px-5" style="background: #fff">
                    <div class="">
                        <img height="40" src="{{ asset('images/logo/logo-shop.png') }}" alt="">
                    </div>
                    <div class="js-navbar">
                        <ul class="list-unstyled d-flex m-0">
                            <li class="px-3 py-2"><a class="text-uppercase nav-a" href="{{ url('/') }}">{{ __('home') }}</a></li>
                            <li class="px-3 hover-subnav-brand py-2">
                                <a class="text-uppercase nav-a" href="">
                                    {{ __('brands') }}
                                    <i class="fa-solid fa-chevron-down"></i>
                                </a>
                                <div class="sub subnav-brand position-absolute p-3" style="width: 75vw">
                                    <ul class="row list-unstyled">
                                        @foreach ($brands as $brand)
                                            <div class="col-3">
                                                <li class="ps-2 py-1"><a class="nav-a" href="{{ route('brand', $brand->id) }}">{{ $brand->name }}</a></li>
                                            </div>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li class="px-3 hover-subnav-category py-2">
                                <a class="text-uppercase nav-a" href="">
                                    {{ __('categories') }}
                                    <i class="fa-solid fa-chevron-down"></i>
                                </a>
                                <div class="sub subnav-category position-absolute p-3" style="width: 75vw">
                                    <ul class="row list-unstyled">
                                        @foreach ($categories as $category)
                                            <div class="col-3">
                                                <li class="ps-2 py-1"><a class="nav-a" href="">{{ $category->name }}</a></li>
                                            </div>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li class="px-3 py-2"><a class="text-uppercase nav-a" href="{{ route('products') }}">{{ __('products') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <form action="{{ route('products') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ __('enter') . __("product name")}}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endguest
        <div class="d-sm-block d-md-none float-right">
            <button class="btn p-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header justify-content-end">
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body justify-content-end">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item text-end">
                            <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item text-end">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item text-end">
                            <a class="text-uppercase d-block nav-a d-flex justify-content-between" href="">
                                <i class="fa-solid fa-chevron-down"></i>
                                <span>{{ __('brands') }}</span>
                            </a>
                            <ul>
                                @foreach ($brands as $brand)
                                    <li>
                                        <a href="">{{ $brand->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Disabled</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        

        <main class="py-4 px-2">
            @if ($message = Session::get('success'))
                <div class="custom-alert-success btn btn-success pb-2 custom-alert mx-2" id="flash">
                    <p class="text-white mb-0 btn custom-btn-success py-1">{{ $message }}</p>
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
            <div class="container">
                @yield('content')
            </div>
        </main>
        <footer class="footer-container bg-dark">
			<div class="container main-footer">
		        <aside class="footer-sidebar widget-area p-5" role="complementary">
					<div class="row justify-content-center align-items-center">
                        <div class="col-1">
                            <a href="">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </div>
                        <div class="col-1">
                            <a href="">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </div>
                        <div class="col-1">
                            <a href="">
                                <i class="fa-brands fa-github"></i>
                            </a>
                        </div>
                    </div>
					<div class="row text-white">
                        <div class="col-4">
                            <h3 class="text-uppercase fw-bold">{{ __('contact') }}</h3>
                            <div>
                                <i class="fa-solid fa-location-dot"></i>
                                No. 8, alley 112/29 Minh Khai ward, Bac Tu Liem district, Hanoi
                            </div>
                            <div class="phone">
                                <i class="fa-solid fa-phone"></i>
                                0394546187
                            </div>
                        </div>
                        <div class="col-4">
                            <h3 class="text-uppercase fw-bold">{{ __('about') }}</h3>
                            <div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-2" style="background: none"><a class="text-white nav-a" href="">{{ __('about') }}</a></li>
                                    <li class="list-group-item px-2" style="background: none"><a class="text-white nav-a" href="">{{ __('contact') }}</a></li>
                                    <li class="list-group-item px-2" style="background: none"><a class="text-white nav-a" href="">{{ __('news') }}</a></li>
                                  </ul>
                            </div>
                        </div>
                        <div class="col-4">
                            <h3 class="text-uppercase fw-bold">{{ __('utilities') }}</h3>
                            <div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-2" style="background: none"><a class="text-white nav-a" href="">{{ __('guide choose size') }}</a></li>
                                    <li class="list-group-item px-2" style="background: none"><a class="text-white nav-a" href="">{{ __('best sale') }}</a></li>
                                    <li class="list-group-item px-2" style="background: none"><a class="text-white nav-a" href="">{{ __('new product') }}</a></li>
                                  </ul>
                            </div>
                        </div>
                    </div>
				</aside><!-- .footer-sidebar -->
	        </div>
			<div class="copyrights-wrapper copyrights-centered">
				<div class="container border-top p-2">
					<div class="min-footer text-white">
						<div class="col-left">
							<p>© 2022 <a href="https://www.facebook.com/aries.842">Aries Hoang</a>. All rights reserved</p>
						</div>
					</div>
				</div>
			</div>
	    </footer>
    </div>
    <script src="{{ asset('js/adminLTE/jquery.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script>
        $('.js-navbar ul li').hover(
            function() {
                $('div.sub', this).stop(true, false, true).slideDown(500)
            },
            function() {
                $('div.sub', this).stop(true, false, true).slideUp(200)
            }
        )
    </script>
    @yield('script')
</body>
</html>
