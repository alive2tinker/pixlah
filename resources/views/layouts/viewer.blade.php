<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
    <title>{{ config('app.name') }} | @yield('title')</title>
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- <script src="vue-youtube/dist/vue-youtube.js"></script> -->
</head>

<body>
  <!-- Main content -->
  <div id="app">
  @yield('content')
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
</body>

</html>
