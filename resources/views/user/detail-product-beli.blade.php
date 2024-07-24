@extends('layouts.layoutUser')

@section('content')

<div class="container position-relative" style="margin-top:100px;">
  <div class="d-flex justify-content-end align-items-center" style="cursor: pointer;">
    <a href="{{ route('cart.viewJual') }}" class="px-3 py-3 rounded-circle text-center position-relative" style="background-color:#F0861A;" id="cart-icon">
      <i class="fa-solid fa-cart-shopping text-white fs-6"></i>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
        
      </span>
    </a>
  </div>
  <div class="d-flex justify-content-between  gap-5">
    <div class="d-flex flex-column gap-5 w-25">
      <div style="width: 18rem;">
        <img src="{{ asset('storage/'.$product->image) }}" alt="" class="border w-100" style="height:200px;" alt="Product Image">
      </div>
      <div class="border p-2">
        <p class="fs-5">Detail Produk</p>
        <p class="fs-5">{{$product->deskripsi}}</p>
      </div>
      <p class="text-danger">!! Sebelum melakukan penyewaan pastikan untuk membaca syarat ketentuan yang berlaku !!</p>
    </div>
    <div class="d-flex flex-column gap-5">
      <form id="add-to-cart-form" class="row g-3">
        <input type="hidden" name="id_product" value="{{$product->id}}">
        <div class="col-md-12">
          <label for="nama_product" class="form-label">Product Name</label>
          <input type="text" class="form-control" name="nama_product" value="{{$product->nama_product}}" readonly>
        </div>
        <div class="col-md-12">
          <label for="harga_product" class="form-label">Price</label>
          <input type="text" class="form-control" name="harga_product" value="@rupiah($product->harga_product)" readonly>
        </div>
        <div class="col-md-12">
          <label for="jumlah_product" class="form-label">Quantity </label>
          <input type="number" class="form-control" name="jumlah_product" required>
        </div>
        <div class="col-md-12">
          <label for="note" class="form-label">Note </label>
          <input type="text" class="form-control" name="note">
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Add to Card</button>
        </div>
      </form>
    </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  const cartCount = $('#cart-count');

  $('#add-to-cart-form').on('submit', function(e) {
    e.preventDefault();

    const productId = $('input[name="id_product"]').val();
    const productName = $('input[name="nama_product"]').val();
    const productPrice = '{{ $product->harga_product }}';
    const productQuantity = $('input[name="jumlah_product"]').val();
    const productNote = $('input[name="note"]').val();

    const product = {
      id: productId,
      name: productName,
      price: productPrice,
      quantity: parseInt(productQuantity),
      note: productNote
    };

    let cart = sessionStorage.getItem('cart_jual') ? JSON.parse(sessionStorage.getItem('cart_jual')) : [];

    const existingProductIndex = cart.findIndex(item => item.id === productId);
    if (existingProductIndex >= 0) {
      cart[existingProductIndex].quantity += product.quantity;
    } else {
      cart.push(product);
    }

    sessionStorage.setItem('cart_jual', JSON.stringify(cart));

    cartCount.text(cart.length);
    Swal.fire({
      title: "Berhasil",
      text: "Produk berhasil di masukan ke keranjang",
      icon: "success"
    });
  });

  // Update cart count on page load
  let cart = sessionStorage.getItem('cart_jual') ? JSON.parse(sessionStorage.getItem('cart_jual')) : [];
  cartCount.text(cart.length);
});
</script>
@endsection
