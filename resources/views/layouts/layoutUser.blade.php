<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <script src="https://kit.fontawesome.com/2f708729c7.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('addCss')
    <style>
        .text-primary {
            color: #F0861A !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg ">
        <div class="container">
            <img src="{{ asset('image/logo.png') }}" style="width:100px;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-primary" aria-current="page" href="{{ route('user.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="{{ route('syarat-ketentuan') }}">Syarat & Ketentuan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="{{ route('user-product-sewa.index') }}">Product Sewa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="{{ route('user-product-jual.index') }}">Product Beli</a>
                    </li>
                    @auth
                        <li class="nav-item " style="margin-left:40px;">
                            <div class="dropdown">
                                <a class="dropdown-toggle text-primary" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img alt="image" src="/newAdmin/dist/assets/img/avatar/avatar-4.png"
                                        class="rounded-circle mr-1" style="width:40px;">
                                    <div class="d-sm-none d-lg-inline-block text-primary">Hi, {{ auth()->user()->name }}
                                    </div>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('order.sewa') }}">Order Sewa</a></li>
                                    <li><a class="dropdown-item" href="{{ route('order.jual') }}">Order Beli</a></li>
                                    <li><a class="dropdown-item" href="{{ route('transaksi.sewa') }}">Transaksi Sewa</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('transaksi.jual') }}">Transaksi Beli</a>
                                    </li>
                                    <li><a class="dropdown-item">
                                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST"
                                                style="display: flex; align-items: center;">
                                                @csrf
                                                <button type="submit" class="dropdown-item has-icon text-danger"
                                                    style="border: none; background: none; padding: 0; display: flex; align-items: center; cursor: pointer;">
                                                    <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout
                                                </button>
                                            </form>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="{{ route('user.loginView') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>


    @yield('content')
    @include('sweetalert::alert')
    <!-- Remove the container if you want to extend the Footer to full width. -->
    <div class="container-fluid gx-0 " style="margin-top:300px;">
        <!-- Footer -->
        <footer class="text-center text-lg-start text-white" style="background-color: #F0861A">
            <!-- Grid container -->
            <div class="container  p-4 pb-0">
                <!-- Section: Links -->
                <section class="">
                    <!--Grid row-->
                    <div class="row">
                        <!-- Grid column -->
                        <div class="col-md-6 col-lg-6 col-xl-6 mx-auto mt-3">
                            <h6 class="text-uppercase mb-4 font-weight-bold">
                                Basecamp369
                            </h6>
                            <p>
                                Here you can use rows and columns to organize your footer
                                content. Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit.
                            </p>

                            <h6 class="text-uppercase mb-4 font-weight-bold">
                                Jam Operational
                            </h6>
                            <p>
                                Senin - Jumat : 09.00 WITA - 22.00 WITA
                            </p>
                            <p>
                                Sabtu - Minggu : 09.00 WITA - 18.00 WITA
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
                            <a class="d-flex gap-1 align-items-center  text-white link-offset-2 link-underline link-underline-opacity-0" href="mailto:hendracb369@gmail.com" >
                              <i class="fas fa-envelope mb-3"></i>
                                <p class="text-white">
                                  hendracb369@gmail.com</p>
                            </a>
                            <a class="d-flex gap-1 align-items-center  text-white link-offset-2 link-underline link-underline-opacity-0" href="https://wa.me/6281246008685" >
                              <i class="fas fa-phone mb-3"></i>
                                <p class="text-white">
                                  081246008685</p>
                            </a>

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
                                <a class="text-white" href="https://mdbootstrap.com/">basecamp369</a>
                            </div>
                            <!-- Copyright -->
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
                            <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"
                                href="https://www.instagram.com/basecamp369_bali?igsh=cXRpODJrcjh3cW0="><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"
                                href="https://youtube.com/@campingdibali?si=R8G-5YcQJ15mQ33f"><i
                                    class="fab fa-youtube"></i></a>
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
    @yield('addJavascript')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</body>

</html>
