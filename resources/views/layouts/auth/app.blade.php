<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Login' }} - Your System</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css?v=' . random_string(7)) }}">

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css?v=') . random_string(7) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css?v=') . random_string(7) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/custom-admin.css?v=') . random_string(7) }}">
    <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
</head>

<body>
    <div class="lds-ring parent-loader d-none">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div id="auth">
        @yield('content')
    </div>

    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js?v=' . random_string(7)) }}"></script>
    @include('sweetalert::alert')
    <script src="{{ asset('assets/js/core.js?v=' . random_string(7)) }}"></script>
    {!! session("message") !!}
</body>

</html>
