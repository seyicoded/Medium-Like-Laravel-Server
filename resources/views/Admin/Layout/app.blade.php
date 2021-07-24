<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blesify Dashboard | Dashboard</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{url('template/img/svg/logo.svg')}}" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="{{url('template/css/style.min.css')}}">
</head>

<body>
  <div class="layer"></div>
<!-- ! Body -->
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">

    {{-- sidenav --}}
    @include('Admin.Layout.sidenav')

  <div class="main-wrapper">
    {{-- topnav --}}
    @include('Admin.Layout.topnav')

    <!-- ! Main -->
    <main class="main users chart-page" id="skip-target">
      <div class="container">
          @yield('content')
      </div>
    </main>
    <!-- ! Footer -->
    <footer class="footer">
  <div class="container footer--flex">
    <div class="footer-start">
      <p>2021 © Blesify Dashboard - <a href="Blesify-dashboard.com" target="_blank"
          rel="noopener noreferrer">Blesify-dashboard.com</a></p>
    </div>
    <ul class="footer-end">
      <li><a href="##">Developed & Powered by <a href="http://seyicoded.ml" target="_blank">Seyicoded</a></a></li>
    </ul>
  </div>
</footer>
  </div>
</div>
<!-- Chart library -->
<script src="{{url('template/plugins/chart.min.js')}}"></script>
<!-- Icons library -->
<script src="{{url('template/plugins/feather.min.js')}}"></script>
<!-- Custom scripts -->
<script src="{{url('template/js/script.js')}}"></script>
</body>

</html>
