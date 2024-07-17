<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <script src="https://kit.fontawesome.com/2f708729c7.js" crossorigin="anonymous"></script>
    <style>
      .text-primary {
        color: #F0861A !important;
      }
    </style>
  </head>
  <body >
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
              <a class="nav-link text-primary" href="#">Product Beli</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-primary" href="#">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


<div class="container my-5">
  <h2 class="text-center">Please read the <span class="text-primary">terms and</span>  <span class="text-primary">conditions</span></h2>

  <div class="d-flex  flex-wrap justify-content-center gap-3 mt-5">
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Digunakan <strong>sebaik</strong> mungkin sesuai dengan fungsinya.</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Barang dapat diambil <strong>sehari</strong> atau <strong>dua hari</strong> sebelumnya.</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center"><strong>Keterlambatan</strong> dikenakan denda <strong>Rp 10.000</strong> /day.</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center"><strong>Kerusakan</strong> barang akan dikenakan denda 
          <strong>Rp 5.000 - 400.000</strong>  sesuai keadaan barang.</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center"><strong>Kehilangan</strong>  barang akan dikenakan denda
         <strong>Rp 5.000 - 400.000</strong>  sesuai keadaan barang</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Konfirmasi pesanan <strong>diterima/ditolak</strong>  dikirim melalui <strong>chat personal</strong> </p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Mohon untuk menggu <strong>15-30 menit</strong>  jika pesanan ditolak oleh admin </p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Admin akan melakukan chat personal terkait <strong>pengembalian dana</strong>  / hubungi <strong>kontak</strong>  yang tertera dibawah </p>
      </div>
    </div>
  </div>
</div>

<!-- Remove the container if you want to extend the Footer to full width. -->
<div class="container-fluid" style="margin-top:300px;">
  <!-- Footer -->
  <footer
          class="text-center text-lg-start text-white"
          style="background-color: #F0861A"
          >
    <!-- Grid container -->
    <div class="container p-4 pb-0">
      <!-- Section: Links -->
      <section class="">
        <!--Grid row-->
        <div class="row">
          <!-- Grid column -->
          <div class="col-md-6 col-lg-6 col-xl-6 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">
              Company name
            </h6>
            <p>
              Here you can use rows and columns to organize your footer
              content. Lorem ipsum dolor sit amet, consectetur adipisicing
              elit.
            </p>
          </div>
          <!-- Grid column -->

          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
            <p><i class="fas fa-home mr-3"></i> Jalan Gunung Seraya Perumahan Tegal 
              Buah A/3, Kota Denpasar, Pulau Bali, 80117</p>
            <p><i class="fas fa-envelope mr-3"></i> hendracb369@gmail.com</p>
            <p><i class="fas fa-phone mr-3"></i> 081246008685</p>
          </div>
          <!-- Grid column -->
        </div>
        <!--Grid row-->
      </section>
      <!-- Section: Links -->

      <hr class="my-3">

      <!-- Section: Copyright -->
      <section class="p-3 pt-0">
        <div class="row d-flex align-items-center">
          <!-- Grid column -->
          <div class="col-md-7 col-lg-8 text-center text-md-start">
            <!-- Copyright -->
            <div class="p-3">
              © 2024 Copyright:
              <a class="text-white" href="https://mdbootstrap.com/"
                 >basecamp369</a
                >
            </div>
            <!-- Copyright -->
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
            <a
               class="btn btn-outline-light btn-floating m-1"
               class="text-white"
               role="button"
               ><i class="fab fa-instagram"></i
              ></a>
            <a
               class="btn btn-outline-light btn-floating m-1"
               class="text-white"
               role="button"
               ><i class="fab fa-youtube"></i
              ></a>
          </div>
          <!-- Grid column -->
        </div>
      </section>
      <!-- Section: Copyright -->
    </div>
    <!-- Grid container -->
  </footer>
  <!-- Footer -->
</div>
<!-- End of .container -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>