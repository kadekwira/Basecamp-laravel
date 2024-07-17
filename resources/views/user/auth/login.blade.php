<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <script src="https://kit.fontawesome.com/2f708729c7.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('addCss')
    <style>
      .text-primary {
        color: #F0861A !important;
      }
      .btn-primary {
        background-color: #F0861A !important;
        border: none;
      }
    </style>
  </head>
  <body id="login">
    <nav class="navbar navbar-expand-lg ">
      <div class="container">
        <img src="{{ asset('image/logo.png') }}" style="width:100px;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-primary" aria-current="page" href="{{route('user.index')}}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-primary" href="{{route('syarat-ketentuan')}}">Syarat & Ketentuan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-primary" href="{{route('user-product-sewa.index')}}">Product Sewa</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-primary" href="{{route('user-product-jual.index')}}">Product Beli</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-primary" href="{{route('user.loginView')}}">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container h-100 w-100">
      <div class="d-flex flex-column justify-content-center align-items-center h-100 w-100">
        <h1 class="text-white fs-1">Login To Your Account</h1>
        <form action="{{route('user.login')}}" method="post" class=" p-3" style="width:35%;">
          @csrf
          <div class="mb-3">
            <input type="email" class="form-control p-2" id="exampleInputEmail1" placeholder="email" name="email">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control p-2"  placeholder="password" name="password">
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary w-25">Login</button>
          </div>
          <div class="d-flex justify-content-center mt-3">
            <span class="text-white">Belum punya akun ? <a href="{{route('user.viewRegis')}}" class="text-white">Registrasi</a> </span>
          </div>
        </form>
      </div>
    </div>

@include('sweetalert::alert')
@yield('addJavascript')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>