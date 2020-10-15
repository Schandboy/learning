@extends('layouts.app')

@section('header')
    <header class="header header-inverse h-fullscreen pb-80" data-parallax="{{$series->image_path}}" data-overlay="8">
        <div class="container text-center">

            <div class="row h-full">
                <div class="col-12 col-lg-8 offset-lg-2 align-self-center">

                    <h1 class="display-4 hidden-sm-down">{{$series->title}}</h1>
                    <h1 class="hidden-md-up">{{$series->description}}</h1>
                    <br>
                    <p class="lead text-white fs-20 hidden-sm-down"><span class="fw-400">{{$series->description}}</p>

                    <br><br><br>
                    @auth
{{--                        {{auth()->user()->completeLesson(4)}}--}}
                        @hasStartedSeries($series)

                            <a href="{{route('series.learning',[$series->slug])}}" class="btn btn-lg btn-round  btn-primary">Continue Learning</a>
                        @else

                            <a class="btn btn-lg btn-round w-200 btn-primary mr-16" href="{{route('series.learning',[$series->slug])}}">Start Learning</a>
                        @endhasStartedSeries($series)
                    @else
                        <a class="btn btn-lg btn-round w-200 btn-primary mr-16" href="{{route('series.learning',[$series->slug])}}">Start Learning</a>
                    @endauth
                </div>

                <div class="col-12 align-self-end text-center">
                    <a class="scroll-down-1 scroll-down-inverse" href="#"
                       data-scrollto="section-intro"><span></span></a>
                </div>

            </div>

        </div>
    </header>
@stop

@section('content')
    <vue-login></vue-login>
    <section class="section bg-gray">
        <div class="container">
            <header class="section-header">
                <small>lessons</small>
                <h2>Featured Screencasts</h2>
                <hr>
                <p class="lead"></p>
            </header>


        </div>
    </section>

@stop