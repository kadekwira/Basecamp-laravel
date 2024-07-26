@extends('layouts.layoutUser')

@section('content')

<div class="container position-relative" style="margin-top:100px;">
  <div class="d-flex justify-content-end align-items-center" style="cursor: pointer;">
    <a href="{{ route('cart.view') }}" class="px-3 py-3 rounded-circle text-center position-relative" style="background-color:#F0861A;" id="cart-icon">
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
          <label for="nama_product" class="form-label">Nama Produk</label>
          <input type="text" class="form-control" name="nama_product" value="{{$product->nama_product}}" readonly>
        </div>
        <div class="col-md-12">
          <label for="harga_product" class="form-label">Harga/hari</label>
          <input type="text" class="form-control" name="harga_product" value="@rupiah($product->harga_product)" readonly>
        </div>
        <div class="col-md-12">
          <label for="jumlah_product" class="form-label">Jumlah </label>
          <input type="number" class="form-control" name="jumlah_product" required>
        </div>
        <div class="col-md-12">
          <label for="note" class="form-label">Catatan </label>
          <input type="text" class="form-control" name="note">
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Tambah Keranjang</button>
        </div>
      </form>
    </div>
  </div>
  <div class="d-flex flex-column mt-5">
    <p><strong>Note :</strong></p>
    <p>Untuk pengembalian terdapat 3 hal yang harus diperhatikan</p>
    <ol>
      <li class="px-2 mb-2">Keterlambatan  : Jika penyewa mengembalikan barang tidak sesuai dengan ketentuan               
        diawal maka akan dikenakan denda sebesar Rp 10.000</li>
      <li class="px-2 mb-2">Barang Hilang    : Pada saat pengembalian ternyata barang yang disewa hilang maka 
        akan dikenakan denda sesuai dengan harga barang tersebut, dengan 
        catatan barang yang hilang merupakan barang utama bukan printilan 
        dari barang tersebut (contoh : barang yang hilang tenda maka denda 
        sesuai dengan harga beli tenda, contoh 2 : barang yang hilang pasak 
        yang merupakan printilan dari tenda maka memiliki harga yang 
        berbeda)  
        (RANGE HARGA Rp. 10.000 - Rp.400.000)</li>
      <li class="px-2 mb-2">Barang Rusak    : Jika barang yang disewa mengalami kerusakan maka akan dikenakan 
        denda sesuai dengan kondisi barang tersebut, tetapi jika barang
        tersebut dengan keadaan yaang tidak memungkinkan atau 
        membutuhkan barang baru maka harga denda yang harus dibayarkan 
        sesuai dengan harga beli barang tersebut   
        (RANGE HARGA Rp. 10.000 - Rp. 400.000)   </li>
    </ol>
    <p><strong>(PERHITUNGAN KERUSAKAN,KEHILANGAN DAN KETERLAMBATAN BARANG AKAN DILAKUKAN SAAT PENYEWA MELAKUKAN PENGEMBALIAN BARANG)</strong>  
    </p>
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

    let cart = sessionStorage.getItem('cart_sewa') ? JSON.parse(sessionStorage.getItem('cart_sewa')) : [];

    const existingProductIndex = cart.findIndex(item => item.id === productId);
    if (existingProductIndex >= 0) {
      cart[existingProductIndex].quantity += product.quantity;
    } else {
      cart.push(product);
    }

    sessionStorage.setItem('cart_sewa', JSON.stringify(cart));

    cartCount.text(cart.length);
    Swal.fire({
      title: "Berhasil",
      text: "Produk berhasil di masukan ke keranjang",
      icon: "success"
    });
  });

  // Update cart count on page load
  let cart = sessionStorage.getItem('cart_sewa') ? JSON.parse(sessionStorage.getItem('cart_sewa')) : [];
  cartCount.text(cart.length);
});
</script>
@endsection
