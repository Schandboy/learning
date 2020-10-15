<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        {!! SEO::generate() !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/thesaas.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>--}}
@yield('script')
</head>

<body>
<div id="app">


    <!-- Topbar -->

    <nav class="topbar topbar-inverse topbar-expand-md topbar-sticky">
        <div class="container">

            <div class="topbar-left">
                <button class="topbar-toggler">&#9776;</button>
                <a class="topbar-brand" href="/" style="color: white;">
                    LMS
                </a>
            </div>


            <div class="topbar-right">
                <ul class="topbar-nav nav">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    @auth
                    @admin
                    <li class="nav-item"><a class="nav-link" href="{{route('series.create')}}">Create Series</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('series.index')}}">All Series</a></li>
                    @else
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user.profile',[auth()->user()->username])}}"
                            >Hey {{ auth()->user()->name  }}</a>
                        </li>

                        {{--                        @admin--}}
                        {{--                        <li class="nav-item"><a href="{{ route('series.index') }}" class="nav-link">All series</a></li>--}}
                        {{--                        <li class="nav-item"><a href="{{ route('series.create') }}" class="nav-link">Create series</a></li>--}}
                    @else
                        <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                        </li>
                        {{--                        @endadmin--}}


                    @endauth
                    {{--                    <li class="nav-item"><a href="{{ route('all-series') }}" class="nav-link">All series</a></li>--}}

                    @guest
                        {{--                        <li class="nav-item"><a href="{{ route('all-series') }}" class="nav-link">All series</a></li>--}}

                    @endguest
                </ul>
            </div>

        </div>
    </nav>
    <!-- END Topbar -->


    <!-- Header -->
@yield('header')
<!-- END Header -->
    <!-- Main container -->
    <main class="main-content">


        @yield('content')


    </main>
    <!-- END Main container -->


    @guest

    @endguest
    @if(!auth()->check())

        <vue-login></vue-login>
@endif
    <vue-noty></vue-noty>
<!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row gap-y justify-content-center">
                <div class="col-12 col-lg-6">
                    <ul class="nav nav-primary nav-hero">
                        <li class="nav-item hidden-sm-down">
                            <a class="nav-link" href="/">LMS</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- END Footer -->
</div>
@if(config('app.env') == 'local')
    <script src="http://localhost:35729/livereload.js?snipver=1" async="" defer=""></script>
@endif
<!-- Scripts -->

<script src="{{ asset('assets/js/core.min.js') }}"></script>
<script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

</body>
</html>
