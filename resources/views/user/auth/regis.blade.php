<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar User</title>
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
        <h1 class="text-white fs-1">Create Your Account</h1>
        <form action="{{route('user.daftar')}}" method="post" class=" p-3 w-50 row" enctype="multipart/form-data">
          @csrf
          <div class="col-md-6">
            <label for="nama" class="form-label text-white">Nama <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nama" name="name" required>
          </div>
          <div class="col-md-6">
            <label for="address" class="form-label text-white">Alamat <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label text-white">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="col-md-6">
            <label for="phone" class="form-label text-white">Phone <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="phone" name="phone" required placeholder="contoh : 628129432">
          </div>
          <div class="col-md-12">
            <label for="password" class="form-label text-white">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="col-md-12">
            <label for="password" class="form-label text-white"> Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password2" required>
          </div>
          <div class="col-md-12">
            <label for="ktp" class="form-label text-white"> KTP <span class="text-danger">*</span></label>
            <input type="file" class="form-control" id="ktp" name="ktp" required>
          </div>
          <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary w-25">Daftar</button>
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