<!--
=========================================================
* Argon Dashboard - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard

* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
    <title>{{ config('app.name') }} | @yield('title')</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('theme/assets/img/brand/favicon.png') }}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('theme/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('theme/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('theme/assets/css/argon.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-default">
  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">

            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <ul class="navbar-nav mr-auto">
		<li class="nav-item">
			<a href="/login" class="nav-link d-none d-xs-block">Login</a>
		</li>
        </ul>
        <hr class="d-lg-none" />
        <ul class="navbar-nav w-auto {{ config('app.locale') === 'ar' ? 'mr-lg-auto' : 'ml-lg-auto' }}">
        <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ config('app.locale')}}
                </a>
                <div class="dropdown-menu  dropdown-menu-right  py-0">
                  <ul class="list-unstyled mx-4 py-4">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li class="locale-link">
                      <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $properties['native'] }}
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </li>
          
          <li class="nav-item d-none d-lg-block ml-lg-4">
            <a href="/login" class="btn btn-neutral btn-icon">
              <span class="btn-inner--icon">
                <i class="fas fa-user mr-2"></i>
              </span>
              <span class="nav-link-inner--text">Login</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  @yield('content')
  <!-- Footer -->
  <footer class="py-5" id="footer-main">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            &copy; {{ date('Y')}} <a href="/" class="font-weight-bold ml-1" target="_blank">iScreenOS</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('theme/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('theme/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('theme/assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('theme/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('theme/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset('theme/assets/js/argon.js') }}"></script>
  @yield('js')
</body>

</html>
