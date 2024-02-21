<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title ?? "Dahsboard" }} - Your System</title>

  <link rel="stylesheet" href="{{ asset('vendor/datatables-bs5/datatables.min.css?v=') . random_string(7) }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css?v=' . random_string(7)) }}">

  <link rel="stylesheet" href="{{ asset('assets/css/main/app.css?v=') . random_string(7) }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css?v=') . random_string(7) }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main/custom-admin.css?v=') . random_string(7) }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg?v=') . random_string(7) }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png?v=') . random_string(7) }}" type="image/png">
  @stack("style")

</head>

<body>
    <div class="lds-ring parent-loader d-none">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div id="app">

        @include('layouts.admin.sidebar')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row mb-2 dropdown-user">
                        <div class="col-md-6"></div>
                        <div class="col-md-6" style="text-align: right;">
                            <div class="dropdown">
                                <i style="font-size: 25px; cursor: pointer;" class="bi bi-person-fill dropdown-toggle" data-bs-toggle="dropdown"></i>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="/logout">Logout</a></li>
                                </ul>
                              </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                          <h3>{{ $title ?? 'Dashboard' }}</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                {!! $breadcrumb !!}
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">

                  @yield('content')

                </section>
            </div>

            @include('layouts.admin.footer')
        </div>
  </div>

  <script src="{{ asset('assets/js/jquery.js?v=') . random_string(7) }}"></script>
  <script src="{{ asset('assets/js/bootstrap.js?v=') . random_string(7) }}"></script>
  <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js?v=' . random_string(7)) }}"></script>
  <script src="{{ asset('vendor/datatables-bs5/datatables.min.js?v=') . random_string(7) }}"></script>
  <script src="{{ asset('assets/js/app.js?v=') . random_string(7) }}"></script>
  <script src="{{ asset('assets/js/core.js?v=') . random_string(7) }}"></script>
  @livewireScripts
  @stack('script')

</body>

</html>
