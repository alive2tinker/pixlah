@extends('layouts.page')
@section('content')
<a href="https://api.whatsapp.com/send?phone=966503619413" class="whats-btn" target="_blank">
    <i class="fab fa-whatsapp fa-2x"></i>
</a>
</div>
<div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary pt-lg-9">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white display-1">{{ __('Pixlah') }}</h1>
                        <div class="typewriter">
                            <h2>{{ __('Realtime Screen Signs for a ') }}<b id="pCustomer"></b></h2>
                        </div>
                        <p class="text-lead text-white">{{ __('Save money while offering your guests a premium experience') }}</p>
                        <div class="row justify-content-center">
                            <div class="col-md-5"><a href="{{ route('register') }}" class="btn btn-secondary btn-block">{{ __('Register Now') }}</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white h-50">
            <div class="container py-5">
                <h1 class="text-center mt-4">{{ __('important features') }}</h1>
                <div class="row mt-5">
                    <div class="col-md-6 text-right">
                        <h2 class="text-default">{{ __('For all screens') }}</h2>
                        <p>{{ __('allscreens.description') }}</p>
                        <h2 class="text-default">{{ __('Realtime broadcast and synchronization among screens') }}</h2>
                        <p>{{ __('realtimesync.description') }}</p>
                        <h2 class="text-default">{{ __('Embeded Queue System') }}</h2>
                        <p>{{ __('queuesys.description') }}</p>
                    </div>
                    <div class="col-md-6">
                        <img style="height:50vh" src="https://www.lamasatech.com/wp-content/uploads/2018/08/The-5-Best-Free-Digital-Signage-Software-Tools-1.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row my-5">
                <div class="col-md-4">
                    <div class="d-flex">
                        <img src="{{ asset('images/Amazon_Web_Services-Logo.wine.svg') }}" style="width: 64px;" alt="">
                        <h3>{{ __('Utilizing AWS S3 storage') }}</h3>
                    </div>
                    <p class="text-white mt-3 text-center">{{ __('aws.description') }}</p>
                </div>
                <div class="col-md-4">
                    <div class="d-flex">
                        <i class="fa fa-tv fa-2x mx-2 text-white"></i>
                        <h3>{{ __('Unlimited Screens') }}</h3>
                    </div>
                    <p class="text-white mt-3 text-center">{{ __('unlimitedscreens.description') }}</p>
                </div>
                <div class="col-md-4">
                    <div class="d-flex">
                        <i class="fa fa-edit fa-2x mx-2 text-white"></i>
                        <h3>{{ __('Customization available on demand') }}</h3>
                    </div>
                    <p class="text-white mt-3 text-center">{{ __('ondemand.description') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-default py-5 bottom-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="display-1 text-center text-white py-3">{{ __('Contact Us') }}</h1>
                        <img class="img-fluid" src="https://appexert.com/images/contact_us.svg" alt="">
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('contacts.store') }}" method="post">
                            @csrf
                            <div class="form-group"><label class="text-white {{config('app.locale') === 'ar' ? 'float-right':'float-left' }}" for="customer-name">{{ __('name') }}</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group"><label class="text-white {{config('app.locale')==='ar' ? 'float-right':'float-left' }}" for="customer-email">{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group"><label class="text-white {{config('app.locale')==='ar' ? 'float-right':'float-left' }}" for="customer-message">{{ __('Message') }}</label>
                                <textarea name="message" id="customer-message" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-5">
                                    <button class="btn btn-primary btn-block" type="submit">{{ __('Send') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $().ready(function() {
        var appLocale = '{{ config("app.locale")}}';
        const pCustomers = [{
            "ar": "الفنادق",
            "en": "hotels"
        }, {
            "ar": "المستشفيات",
            "en": "hospitals"
        }, {
            "ar": "المطاعم",
            "en": "restaurants"
        }, {
            "ar": "المكاتب",
            "en": "office spaces"
        }];
        var cCustomer;
        var i = 0;
        setInterval(function() {
            cCustomer = pCustomers[Math.floor(Math.random() * This is a success alert— check it out!pCustomers.length - 1)];
            typewriter();
            i = 0;
            $("#pCustomer").html("");
        }, 1000);

        function typewriter() {
            if (i < cCustomer.ar.length || i < cCustomer.en.length) {
                if (appLocale === "ar") {
                    $("#pCustomer").append(cCustomer.ar.charAt(i));
                } else {
                    $("#pCustomer").append(cCustomer.en.charAt(i));
                }
                i++;
                setTimeout(typewriter, 70);
            }
        }
    });
</script>
@endsection