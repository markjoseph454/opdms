<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title or 'OPD'  }}</title>

        <!-- Styles -->
        <link href="{{ asset('public/plugins/css/font-awesome.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('public/plugins/css/bootstrap.css') }}">
        <link href="{{ asset('public/plugins/css/toastr.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/css/master.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/css/partials/navigation.css') }}" rel="stylesheet" />
        <!-- Load page style -->
        @yield('pagestyle')

    </head>

    <body>

        @yield('header')


        @yield('content')


        @yield('footer')

        <!-- Scripts -->
        <script src="{{ asset('public/plugins/js/jquery.js') }}"></script>
        <script src="{{ asset('public/plugins/js/bootstrap.js') }}"></script>
        <script src="{{ asset('public/plugins/js/toastr.min.js') }}"></script>
        <script src="{{ asset('public/js/master.js') }}"></script>

        @yield('pagescript')



        <script src="{{ asset('public/js/patients/watcher.js') }}"></script>



            
    </body>
</html>
