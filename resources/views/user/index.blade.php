@extends('layouts.layoutUser')

@section('content')

    <div class="container-fluid" id="background">
      <div class="d-flex flex-column justify-content-center align-items-center h-100 w-100">
        <h1 class="text-white fw-bold backdrop-title text-center">HIKE & CAMP EXPERIANCE</h1>
        <h3 class="text-white backdrop-title2">WITH <span class="text-dark fw-bold">BASECAMP369</span></h3>
      </div>
    </div>


    <section class="container" style="margin-top:100px;">
      <div class="d-flex flex-sm-row flex-column justify-content-beetwen align-items-center h-100 gap-5">
        <div class="d-flex flex-column gap-5">
          <div class="title">
            <h2>Selamat Datang di</h2>
            <h2 class="text-primary fw-bold">Basecamp369</h2>
          </div>
          <div class="description w-75">
            <p>Kami adalah pusat penyewaan perlengkapan camping dan hiking yang tak hanya menyediakan alat-alat berkualitas tinggi untuk menjadikan setiap momen di alam terbuka tak terlupakan, tetapi juga menjadi destinasi utama untuk menemukan dan memiliki peralatan camping pilihan Anda.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
              <div class="row mb-3">
                  <div class="col-12">
                      <img src="{{ asset('image/user/foto2.jpg') }}" class="img-fluid custom-img rounded-kiri" >
                  </div>
              </div>
              <div class="row">
                  <div class="col-12">
                    <img src="{{ asset('image/user/foto3.jpg') }}" class="img-fluid custom-img rounded-kanan">
                  </div>
              </div>
          </div>
          <div class="col-md-6" id="img3">
            <img src="{{ asset('image/user/foto1.jpg') }}" class="img-fluid custom-img rounded-kanan" style="height:80%;">
          </div>
      </div>
    </section>


    <section class="container" style="margin-top:100px;">
      <h1 class="text-center text-primary">GALERY</h1>
      <div class="d-flex flex-wrap justify-content-center gap-2 mt-5" id="galery">
        <img src="{{ asset('image/user/galery3.jpeg') }}" class="img-fluid w-25">
        <img src="{{ asset('image/user/galery4.jpeg') }}" class="img-fluid w-25">
        <img src="{{ asset('image/user/galery3.jpeg') }}" class="img-fluid w-25 ">
        <img src="{{ asset('image/user/galery4.jpeg') }}" class="img-fluid w-25">
      </div>
    </section>


@endsection