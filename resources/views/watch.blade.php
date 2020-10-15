@extends('layouts.app')

@section('header')
    <header class="header header-inverse h-fullscreen pb-80" data-parallax="{{$series->image_path}}" data-overlay="8">
        <div class="container text-center">

            <div class="row h-full">
                <div class="col-12 col-lg-8 offset-lg-2 align-self-center">

                    <h1 class="display-4 hidden-sm-down">{{$lesson->title}}</h1>
                    <h1 class="hidden-md-up">{{$series->title}}</h1>
                    <br>
                    <p class="lead text-white fs-20 hidden-sm-down"><span class="fw-400">{{$series->description}}</p>

                    <br><br><br>

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
    @php
        $nextLesson=$lesson->getNextLesson();
        $prevLesson=$lesson->getPreviousLesson();
    @endphp
    <div class="section bg-gray">
        <div class="container">
            <div class="row gap-y text-center">
                <div class="col-12">
                    <vue-player default_lesson="{{$lesson}}"
                                @if($nextLesson->id!=$lesson->id)
                                next_lesson="{{route('series.watch',[$series->slug,$nextLesson->id])}}"
                            @endif></vue-player>
                    @if($prevLesson->id!=$lesson->id)
                        <a href="{{route('series.watch',[$series->slug,$prevLesson->id])}}"
                           class="btn btn-info">Previous Lesson</a>
                    @endif
                    @if($nextLesson->id!=$lesson->id)
                        <a href="{{route('series.watch',[$series->slug,$nextLesson->id])}}"
                           class="btn btn-info">Next
                            Lesson</a>
                    @endif
                </div>
            </div>
            <div class="col-12">
                <ul class="list-group">
                    @foreach($series->getOrderedLessonsfromSeries() as $l)
                        <li class="list-group-item
                            @if($l->id==$lesson->id) active @endif">
                            @if(auth()->user()->hasCompletedLesson($l))
                                <b><small>COMPLETED</small></b>
                            @endif
                            <a href="{{route('series.watch',[$series->slug,$l->id])}}">{{$l->title}}</a>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>

@stop