<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Sign In</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{url('template/img/svg/logo.svg')}}" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="{{url('template/css/style.min.css')}}">
</head>

<body>
  <div class="layer"></div>
<main class="page-center">
  <article class="sign-up">
    <h1 class="sign-up__title">Welcome back!</h1>
    <p class="sign-up__subtitle">Sign in to your account to continue</p>
    <form class="sign-up-form form" action="" method="POST">
        @csrf
      <label class="form-label-wrapper">
        <p class="form-label">Email</p>
        <input class="form-input" type="email" name="email" placeholder="Enter your email" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Password</p>
        <input class="form-input" type="password" name="password" placeholder="Enter your password" required>
      </label>
      {{-- <a class="link-info forget-link" href="##">Forgot your password?</a> --}}
      {{-- <label class="form-checkbox-wrapper">
        <input class="form-checkbox" type="checkbox" required>
        <span class="form-checkbox-label">Remember me next time</span>
      </label> --}}
      <button class="form-btn primary-default-btn transparent-btn" type="submit">Sign in</button>
    </form>
  </article>
</main>
<!-- Chart library -->
<script src="{{url('template/plugins/chart.min.js')}}"></script>
<!-- Icons library -->
<script src="{{url('template/plugins/feather.min.js')}}"></script>
<!-- Custom scripts -->
<script src="{{url('template/js/script.js')}}"></script>
</body>

</html>
