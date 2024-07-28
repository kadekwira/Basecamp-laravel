@extends('layouts.layoutUser')

@section('content')
    <div class="container-fluid" id="background">
        <div class="d-flex flex-column justify-content-center align-items-center h-100 w-100">
            <h1 class="text-white fw-bold backdrop-title1 text-center">HIKE & CAMP EXPERIANCE</h1>
            <h3 class="text-white backdrop-title2">WITH <span class="text-dark fw-bold">BASECAMP369</span></h3>
        </div>
    </div>


    <div class="container-fluid" style="background-color:rgb(244, 244, 244); padding-top:100px; padding-bottom:50px;">
        <section class="container" style=" ">
            <div class="d-flex flex-sm-row flex-column justify-content-beetwen align-items-center h-100 gap-5">
                <div class="d-flex flex-column gap-5">
                    <div class="title">
                        <h2>Selamat Datang di</h2>
                        <h2 class="text-primary fw-bold">Basecamp369</h2>
                    </div>
                    <div class="description w-75">
                        <p>Kami adalah pusat penyewaan perlengkapan camping dan hiking yang tak hanya menyediakan alat-alat
                            berkualitas tinggi untuk menjadikan setiap momen di alam terbuka tak terlupakan, tetapi juga
                            menjadi destinasi utama untuk menemukan dan memiliki peralatan camping pilihan Anda.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-12">
                                <img src="{{ asset('image/user/foto2.jpg') }}" class="img-fluid custom-img rounded-kiri">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <img src="{{ asset('image/user/foto3.jpg') }}" class="img-fluid custom-img rounded-kanan">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="img3">
                        <img src="{{ asset('image/user/foto1.jpg') }}" class="img-fluid custom-img rounded-kanan"
                            style="height:80%;">
                    </div>
                </div>
        </section>
    </div>


    <section class="container" style="margin-top:50px;">
      <h1 class="text-center text-primary">GALLERY</h1>
      <div class="position-relative" id="galery-slider">
        <button id="prev" class="btn position-absolute text-white"
            style="left: 0; top: 50%; transform: translateY(-50%); z-index: 10; background-color:#F0861A !important;">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button id="next" class="btn text-white position-absolute"
            style="right: 0; top: 50%; transform: translateY(-50%); z-index: 10; background-color:#F0861A !important;">
          <i class="fas fa-chevron-right"></i>
        </button>
        <div class="slider-container overflow-hidden">
          <div class="d-flex" id="slider-wrapper">
            <img src="{{ asset('image/user/galery3.jpeg') }}" class="img-fluid slider-img"
                style="height: 300px !important;">
            <img src="{{ asset('image/user/galery4.jpeg') }}" class="img-fluid slider-img"
                style="height: 300px !important;">
            <img src="{{ asset('image/user/galery5.jpg') }}" class="img-fluid slider-img"
                style="height: 300px !important;">
            <img src="{{ asset('image/user/galery4.jpeg') }}" class="img-fluid slider-img"
                style="height: 300px !important;">
            <img src="{{ asset('image/user/galery4.jpeg') }}" class="img-fluid slider-img"
                style="height: 300px !important;">
            <img src="{{ asset('image/user/galery4.jpeg') }}" class="img-fluid slider-img"
                style="height: 300px !important;">
            <img src="{{ asset('image/user/galery4.jpeg') }}" class="img-fluid slider-img"
                style="height: 300px !important;">
          </div>
        </div>
      </div>
    </section>
    
  



    @if ($kontenList == null)
    @else
        <div class="container-fluid"
            style="padding-top:50px; padding-bottom:100px; margin-top:100px; background-color:rgb(244, 244, 244);">
            <section class="container">
                <h1 class="text-center text-primary">{{ $kontenList->nama_konten }}</h1>
                <div class="d-flex justify-content-center mt-5">
                    <iframe width="800" height="400" src="{{ $kontenList->url }}" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </section>
        </div>
    @endif

    <div class="container" style="margin-top:100px;">
        <h1 class="text-center text-primary">LOCATION</h1>
        <div class="d-flex  justify-content-center mt-5">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.3076959865384!2d115.18329999999997!3d-8.6622588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd247a3fb860b19%3A0x6805463ed3116210!2sBasecamp369%20-%20Sewa%20Tenda%20Camping%20di%20Bali!5e0!3m2!1sid!2sid!4v1721311089456!5m2!1sid!2sid"
                width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endsection

@section('addJavascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
$(document).ready(function() {
  const imagesToShow = 4;
  const totalImages = $('.slider-img').length;
  const imageWidth = $('.slider-img').outerWidth(true);
  let currentIndex = 0;

  function updateSlider() {
    const newTransformValue = -imageWidth * currentIndex;
    $('#slider-wrapper').css('transform', `translateX(${newTransformValue}px)`);
  }

  $('#next').on('click', function() {
    if (currentIndex < totalImages - imagesToShow) {
      currentIndex++;
      updateSlider();
    } else {
 
      currentIndex = 0;
      updateSlider();
    }
  });

  $('#prev').on('click', function() {
    if (currentIndex > 0) {
      currentIndex--;
      updateSlider();
    } else {
      currentIndex = totalImages - imagesToShow;
      updateSlider();
    }
  });
});

    </script>
@endsection

@section('addCss')
    <style>
.slider-container {
  position: relative;
  width: 100%;
  overflow: hidden;
}

#slider-wrapper {
  display: flex;
  transition: transform 0.5s ease-in-out;
}

.slider-img {
  flex: 0 0 auto;
  width: 25%; 
  margin-right: 10px; 
}

    </style>
@endsection
