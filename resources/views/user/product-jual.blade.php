@extends('layouts.layoutUser')

@section('content')
<div class="container-fluid" id="background-product-jual">
  <div class="d-flex flex-column justify-content-center align-items-center h-100 w-100">
    <h1 class="text-white fw-bold backdrop-title text-center"> <span class="text-primary">OUR</span> PRODUCTS</h1>
  </div>
</div>

<div class="container position-relative" style="margin-top:100px;">
  <h1 class="text-center">Buy Outdoor Equipment</h1>
  <div class="d-flex justify-content-end align-items-center" style="cursor: pointer;">
    <a href="{{ route('cart.viewJual') }}" class="px-3 py-3 rounded-circle text-center position-relative" style="background-color:#F0861A;" id="cart-icon">
      <i class="fa-solid fa-cart-shopping text-white fs-6"></i>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
        0
      </span>
    </a>
  </div>
  <div class="d-flex flex-wrap gap-3 justify-content-center align-items-center mt-5">
    @foreach ($products as $item)
    <a href="{{ route('user-product-jual.detail',$item->id)}}"class="card" style="width: 18rem; cursor: pointer;">
      <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top w-100" style="height:200px;" alt="Product Image">
      <div class="card-body">
        <h5 class="card-title" style="l">{{$item->nama_product}}</h5>
        <p class="card-text">@rupiah($item->harga_product)</p>
      </div>
    </a>
    @endforeach
  </div>
</div>

@endsection

@section('addCss')
<style>
  .btn-primary {
    background-color: #F0861A !important;
    border: none;
  }
</style>
@endsection

@section('addJavascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $(document).ready(function () {
    function updateCartCount() {
      let cart = JSON.parse(sessionStorage.getItem('cart_jual')) || [];

      $('#cart-count').text(cart.length);
    }

    // Initial cart count update
    updateCartCount();
  });
</script>
@endsection
