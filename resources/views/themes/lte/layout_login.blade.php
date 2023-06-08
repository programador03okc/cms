<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>.::. CMS OKC - LOGIN .::.</title>
        <link rel="icon" type="image/ico" href="{{asset('images/logo.ico')}}">
        <link rel="stylesheet" href="{{ asset('assets/lte/dist/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/dist/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/plugins/iCheck/square/blue.css') }}">
        <link rel="stylesheet" href="{{ asset('css/basic.css')}}">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            @yield("content")
        </div>
        <script src="{{ asset('assets/lte/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/lte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/lte/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('assets/lte/plugins/iCheck/icheck.min.js') }}"></script>
        @yield("scripts")
    </body>
</html>