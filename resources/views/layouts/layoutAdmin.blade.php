<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Aries Shoe | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/adminLTE/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('css/adminLTE/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('css/adminLTE/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('css/adminLTE/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminLTE/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('css/adminLTE/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('css/adminLTE/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('css/adminLTE/summernote-bs4.min.css') }}">
    {{-- datatable --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <link rel="stylesheet" href="{{ asset('css/styleAdmin.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed accent-teal">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('images/logo/logo-shop.png') }}" alt="Aries Shoe" height="200">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light bg-warning">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    @include('partials/language_switcher')
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Auth Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{ Auth::user()->fullname }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="{{ route('admin.profile') }}" class="dropdown-item">
                            <i class="fa-solid fa-address-card mr-1"></i>
                            {{ __('profile') }}
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket mr-1"></i>
                            {{ __('logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-danger navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                      <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-dark-maroon">
        <!-- Brand Logo -->
        <a href="{{ route('admin') }}" class="brand-link">
            <img src="{{ asset('images/logo/logo-shop.png') }}" alt="Aries Shoe" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Aries Shoe</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image" style="margin: auto 0">
                    <img src="{{ asset('images/users/' . Auth()->user()->image->name) }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->fullname }}</a>
                    <p class="mb-0 text-success" style="font-size: 10px"><i class="fa-solid fa-circle"></i> Online</p>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="{{ __('search') }}" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="{{ route('admin') }}" class="nav-link active">
                            <i class="nav-icon fa-solid fa-chart-line"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa-solid fa-ellipsis"></i>
                            <p>
                                {{ __('categories') }}
                                <i class="right fas fa-angle-left"></i>
                                <span class="badge badge-info right">{{ $totalCategories }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link">
                                    <i class="fa-solid fa-clipboard-list mr-1"></i>
                                    <p>{{ __('list') . __('categories') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories.create') }}" class="nav-link">
                                    <i class="fa-solid fa-circle-plus mr-1"></i>
                                    <p>{{ __('create new') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa-brands fa-buffer"></i>
                            <p>
                                {{ __('brands') }}
                                <i class="right fas fa-angle-left"></i>
                                <span class="badge badge-info right">{{ $totalBrands }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('brands.index') }}" class="nav-link">
                                    <i class="fa-solid fa-clipboard-list mr-1"></i>
                                    <p>{{ __('list') . __('brands') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('brands.create') }}" class="nav-link">
                                    <i class="fa-solid fa-circle-plus mr-1"></i>
                                    <p>{{ __('create new') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa-solid fa-boxes-stacked"></i>
                            <p>
                                {{ __('products') }}
                                <i class="right fas fa-angle-left"></i>
                                <span class="badge badge-info right">{{ $totalProducts }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('color-size.show') }}" class="nav-link">
                                    <i class="fa-solid fa-clipboard-list mr-1"></i>
                                    <p>{{ __('colors') . '/' . __('sizes') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link">
                                    <i class="fa-solid fa-clipboard-list mr-1"></i>
                                    <p>{{ __('list') . __('products') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products.create') }}" class="nav-link">
                                    <i class="fa-solid fa-circle-plus mr-1"></i>
                                    <p>{{ __('create new') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-users nav-icon"></i>
                            <p>
                                {{ __('users') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class="fa-solid fa-clipboard-list mr-1"></i>
                                    <p>{{ __('list') . __('users') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}" class="nav-link">
                                    <i class="fa-solid fa-circle-plus mr-1"></i>
                                    <p>{{ __('create staff account') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('orders.index') }}" class="nav-link">
                            <i class="nav-icon fa-solid fa-cart-flatbed-suitcase"></i>
                            <p>
                                {{ __('orders') }}
                                <span class="badge badge-info right">{{ $totalOrders }}</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
        </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="container-fluid pb-4 px-3">
            @if ($message = Session::get('success'))
                <div class="alert alert-success text-white m-0 px-3 py-2 small" id="flash">
                    {{ $message }}
                    @php
                        session()->forget('success');
                    @endphp
                </div>
            @elseif ($message = Session::get('error'))
                <div class="alert alert-danger text-white m-0 px-3 py-2 small" id="flash">
                    {{ $message }}
                    @php
                        session()->forget('error');
                    @endphp
                </div>
            @endif

            @yield('content')
        </div>
        <!-- /.content -->
    </div>
    <div id="backtop" class="position-fixed" style="display: none">
        <i class="nav-icon fa fa-plane"></i>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2021-2022 <a href="https://www.facebook.com/aries.842">Aries Hoang</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
<!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('js/adminLTE/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('js/adminLTE/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('js/adminLTE/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('js/adminLTE/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('js/adminLTE/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('js/adminLTE/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('js/adminLTE/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('js/adminLTE/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('js/adminLTE/moment.min.js') }}"></script>
    <script src="{{ asset('js/adminLTE/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('js/adminLTE/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('js/adminLTE/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('js/adminLTE/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminLTE/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('js/adminLTE/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('js/adminLTE/dashboard.js') }}"></script>
    {{-- Datatable --}}
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="{{ asset('js/scriptAdmin.js') }}"></script>
    @yield('script')
</body>
</html>
