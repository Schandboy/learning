@extends('layouts.app')

@section('header')


    <!-- Header -->
    <header class="header header-inverse" style="background-color: #c2b2cd;">
        <div class="container text-center">

            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h1>Subscribe To Schandboy</h1>

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

                    <div class="col-12 text-center">

                        <vue-stripe email="{{auth()->user()->email}}"></vue-stripe>

                    </div>
                </div>

        </section>


    </main>
    <!-- END Main container -->








@endsection
@section('script')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection