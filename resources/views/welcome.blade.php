@extends('layouts.page')
@section('content')
<a href="https://api.whatsapp.com/send?phone=966503619413" class="whats-btn" target="_blank">
<i class="fab fa-whatsapp fa-2x"></i>
</a>
<div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white display-1">iScreenOS</h1>
              <div class="typewriter"><h2>Realtime Screen Signs for a <b id="pCustomer"></b></h2></div>
              <p class="text-lead text-white">Save money while offering your guests a premium experience</p>
                <div class="row justify-content-center">
                    <div class="col-md-5"><a href="{{ route('register') }}" class="btn btn-secondary btn-block">Register Now</a></div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
      <div class="card">
          <div class="card-body">
          <div id="features-block">
                    <h3 class="text-center">All of the important features</h3>
                    <div class="container">
                        <div class="row my-4 d-flex justify-content-center">
                            <div class="col-md-4">
                                <ul class="list-group">
                                    <li class="list-group-item">Unlimited Screens</li>
                                    <li class="list-group-item">Multiple file formats: image, video, twitter, and youtube</li>
                                    <li class="list-group-item">Realtime broadcast and synchronization among screens</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="list-group">
                                    <li class="list-group-item">Only $20 dollars a month</li>
                                    <li class="list-group-item">Multiple presentation modes</li>
                                    <li class="list-group-item">Customization available on demand</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
      </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
<script>
    $().ready(function(){
            const pCustomers = ["hotels","hospitals","restaurants", "office spaces"];
            var cCustomer;
            var i = 0;
            setInterval(function(){
                cCustomer = pCustomers[Math.floor(Math.random() * pCustomers.length-1)];
                typewriter();
                i = 0;
                $("#pCustomer").html("");
            }, 1000);

            function typewriter()
            {
                if(i < cCustomer.length -1)
                {
                    $("#pCustomer").append(cCustomer.charAt(i));
                    i++;
                    setTimeout(typewriter, 70);
                }
            }
		});
</script>
@endsection
