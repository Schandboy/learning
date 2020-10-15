@extends('layouts.app')

@section('header')

    @php
        $subscribe=auth()->user()->subscriptions->first();
    @endphp
    @if(auth()->user()->id==$user->id)
        <!-- Header -->
        <header class="header header-inverse" style="background-color: #c2b2cd;">
            <div class="container text-center">

                <div class="row">
                    <div class="col-12 col-lg-8 offset-lg-2">

                        <h1>{{$user->name}}</h1>
                        <p class="fs-20">{{$user->username}}</p>

                        <h3>Lessons Completed</h3>
                        <p class="fs-20">{{$user->getTotalNoOfCompletedLessons()}}</p>

                    </div>
                </div>

            </div>
        </header>
        <!-- END Header -->




        <!-- Main container -->
        <main class="main-content">


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Description
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->
            <section class="section bg-gray">
                <div class="container">

                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2">
                            <h1 class="text-center">Series Being Watched</h1>
                            @forelse($series as $s)
                                <div class="card mb-30">
                                    <div class="row">
                                        <div class="col-12 col-md-4 align-self-center">
                                            <a href=""><img src="{{$s->image_path}}" alt="..."></a>
                                        </div>

                                        <div class="col-12 col-md-8">
                                            <div class="card-block">
                                                <h4 class="card-title">{{ $s->title }}</h4>

                                                <p class="card-text">{{ $s->description }}</p>
                                                <a class="fw-600 fs-12" href="{{ route('series', $s->slug) }}">Read more
                                                    <i
                                                            class="fa fa-chevron-right fs-9 pl-8"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center">No Data Found</p>
                            @endforelse


                        </div>
                    </div>


                </div>
            </section>


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Apply form
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->
            <section class="section" id="section-apply">
                <div class="container">


                    <div class="col-12 col-md-12 offset-md-2">

                        <form action="{{route('subscription.change')}}" method="POST">
                            {{csrf_field()}}
                            <h3 class="text-center">Your Current Plan: @if($subscribe) <span
                                        class="badge badge-success">{{$subscribe->stripe_plan}}</span>
                                @else
                                    <span class="badge badge-danger">No Plan</span>
                                @endif
                            </h3>
                            <br>
                            <div class="form-group col-12 col-md-6">
                                <h3>Plans and Subscriptions</h3>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <select class="form-control" name="plan">
                                    <option disabled selected>Select Plan</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>


                            <button class="btn btn-primary btn-block" type="submit">Change Plan</button>
                        </form>

                    </div>
                    @if(auth()->user()->card_brand)
                    <div class="col-12 col-md-12 offset-md-2">


                        <h3 class="text-center">Your Current Card: <span
                                    class="badge badge-success">{{auth()->user()->card_brand??null}}</span>
                        </h3>
                        <br>
                        <vue-update-card email="{{auth()->user()->email}}"></vue-update-card>


                    </div>
                        @endif
                </div>


            </section>


        </main>
        <!-- END Main container -->
    @endif
@endsection
@section('script')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection
{{--<script>--}}
{{--    import UpdateCard from "../assets/js/components/UpdateCard";--}}
{{--    export default {--}}
{{--        components: {UpdateCard}--}}
{{--    }--}}
{{--</script>--}}