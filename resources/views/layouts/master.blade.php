<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{config('app.name')}}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="{{config('app.name')}}">
    <meta name="author" content="Andika Dayu">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="{{asset('assets/plugins/fontawesome/js/all.min.js')}}"></script>

    <!-- App CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link id="theme-style" rel="stylesheet" href="{{asset('assets/css/portal.css')}}">

    <!-- Styles -->

</head>

<body class="app">
    <header class="app-header fixed-top">
        <div class="app-header-inner">
            <div class="container-fluid py-2">
                @include('layouts.navbar')
                <!--//app-header-content-->
            </div>
            <!--//container-fluid-->
        </div>
        <!--//app-header-inner-->
        <div id="app-sidepanel" class="app-sidepanel">
            <div id="sidepanel-drop" class="sidepanel-drop"></div>
            <div class="sidepanel-inner d-flex flex-column">
                <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
                <div class="app-branding">
                    <a class="app-logo" href="#"><img class="logo-icon me-2"
                            src="{{asset('assets/images/app-logo.svg')}}" alt="logo"><span
                            class="logo-text">{{config('app.name')}}</span></a>

                </div>
                <!--//app-branding-->

                @include('layouts.sidebar')
                <!--//app-nav-->

                <!--//app-sidepanel-footer-->

            </div>
            <!--//sidepanel-inner-->
        </div>
        <!--//app-sidepanel-->
    </header>
    <!--//app-header-->

    <div class="app-wrapper">

        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">

                <h1 class="app-page-title">@yield('header')</h1>

                @yield('content')


            </div>
            <!--//container-fluid-->
        </div>
        <!--//app-content-->

        <footer class="app-footer">
            <div class="container text-center py-3">
                <small class="copyright">Copyright 2022 {{config('app.name')}}</small>

            </div>
        </footer>
        <!--//app-footer-->

    </div>
    <!--//app-wrapper-->


    <!-- Javascript -->
    <script src="{{asset('assets/jquery.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>

    <!-- Charts JS -->
    <script src="{{asset('assets/plugins/chart.js/chart.min.js')}}"></script>
    <script src="{{asset('assets/sweetalert/sweetalert.min.js')}}"></script>
    <script>
        function swalError() {
            return swal("Error", "Have an error! Please contact administrator!", "error");
        }

        function swalMessageFailed(message) {
            return swal("Gagal", message, "error");
        }

        function swalMessageSuccess(message, isok) {
            return swal("Sukses", message, "success").then(isok);
        }
    </script>

    @yield('js')

</body>

</html>