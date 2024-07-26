@extends('layouts.layoutUser')

@section('content')
<div class="container position-relative" style="margin-top:100px;">
  <h1 class="text-center">Keranjang Anda</h1>
  <div id="cart-details" class="d-flex flex-wrap gap-3 justify-content-center align-items-center mt-5">
  </div>
  <div class="mt-5">
    <input type="hidden" id="id_customer" class="form-control" value="{{auth()->user()->id}}">
    <div class="form-group">
      <label for="start-date">Tanggal Peminjaman:</label>
      <input type="date" id="start-date" class="form-control" required>
    </div>
    <div class="form-group mt-3">
      <label for="return-date">Tanggal Pengembalian:</label>
      <input type="date" id="return-date" class="form-control" required>
    </div>
    <div class="mt-3">
      <h5>Total Harga: <span id="total-price">0</span></h5>
    </div>
    <div class="mt-3 text-center">
      <button id="pay-button" class="btn btn-primary">Sewa</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script>
$(document).ready(function () {
  function fetchCartDetails() {
    let cart = JSON.parse(sessionStorage.getItem('cart_sewa')) || [];
    let productIds = cart.map(item => item.id);
    
    if (productIds.length > 0) {
      $.ajax({
        url: '{{ route("cart-sewa.showSewa") }}',
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          productIds: productIds
        },
        success: function (response) {
          displayCartDetails(response, cart);
          calculateTotalPrice();
        }
      });
    } else {
      $('#cart-details').html('<p>Your cart is empty.</p>');
    }
  }

  function formatRupiah(value) {
    value = typeof value === 'string' ? parseFloat(value) : value;


      let formattedValue = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
      }).format(value);

      formattedValue = formattedValue.replace(/\,00$/g, '');

      return formattedValue.trim(); 
  }


  function displayCartDetails(products, cart) {
    let cartDetails = $('#cart-details');
    cartDetails.empty();

    products.forEach(product => {
      let cartItem = cart.find(item => item.id === product.id.toString());
      let productHtml = `
        <div class="card mb-3" style="width: 540px;">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="{{ asset('storage/') }}/${product.image}" class="img-fluid rounded-start" alt="..." style="height:200px;">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">${product.nama_product}</h5>
                <p class="card-text">${formatRupiah(product.harga_product)}</p>
                <p class="card-text">Jumlah : <input type="number" value="${cartItem.quantity}" class="form-control quantity-input" data-id="${product.id}"></p>
                <p class="card-text">Catatan: <input type="text" value="${cartItem.note}" class="form-control note-input" data-id="${product.id}"></p>
                <button class="btn btn-danger delete-btn" data-id="${product.id}">Delete</button>
              </div>
            </div>
          </div>
        </div>
      `;
      cartDetails.append(productHtml);
    });

    // Attach event handlers
    $('.delete-btn').on('click', function () {
      let productId = $(this).data('id');
      deleteCartItem(productId);
    });

    $('.quantity-input').on('change', function () {
      let productId = $(this).data('id');
      let newQuantity = $(this).val();
      updateCartItem(productId, newQuantity, null);
    });

    $('.note-input').on('change', function () {
      let productId = $(this).data('id');
      let newNote = $(this).val();
      updateCartItem(productId, null, newNote);
    });
  }

  function deleteCartItem(productId) {
    let cart = JSON.parse(sessionStorage.getItem('cart_sewa')) || [];
    cart = cart.filter(item => item.id !== productId.toString());
    sessionStorage.setItem('cart_sewa', JSON.stringify(cart));
    fetchCartDetails();
  }

  function updateCartItem(productId, newQuantity, newNote) {
    let cart = JSON.parse(sessionStorage.getItem('cart_sewa')) || [];
    let cartItem = cart.find(item => item.id === productId.toString());
    if (cartItem) {
      if (newQuantity !== null) {
        cartItem.quantity = newQuantity;
      }
      if (newNote !== null) {
        cartItem.note = newNote;
      }
      sessionStorage.setItem('cart_sewa', JSON.stringify(cart));
      fetchCartDetails();
    }
  }

  function calculateTotalPrice() {
    let cart = JSON.parse(sessionStorage.getItem('cart_sewa')) || [];
    let totalPrice = 0;

    cart.forEach(item => {
      totalPrice += item.quantity * parseInt(item.price);
    });

    let startDate = new Date($('#start-date').val());
    let returnDate = new Date($('#return-date').val());

    if (startDate && returnDate && returnDate > startDate) {
      let diffTime = Math.abs(returnDate - startDate);
      let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      totalPrice *= diffDays;
    }

    $('#total-price').text(formatRupiah(totalPrice));
  }

  // Handle pay button click
  $('#pay-button').on('click', function () {
    let cart = JSON.parse(sessionStorage.getItem('cart_sewa')) || [];
    let productDetails = cart.map(item => {
      return {
        id: item.id,
        quantity: item.quantity,
        note: item.note
      };
    });

    let customer = $('#id_customer').val();
    let startDate = $('#start-date').val();
    let returnDate = $('#return-date').val();
    let totalPrice = $('#total-price').text().replace('Rp', '').replace(/\./g, '').trim(); // Adjust based on your formatting

    $.ajax({
      url: '{{ route("cart-sewa.pay") }}',
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        products: productDetails,
        start_date: startDate,
        return_date: returnDate,
        total_price: totalPrice,
        customer: customer,
      },
      success: function (response) {
        if(response.status==400){
          Swal.fire({
            title: "Gagal",
            text: "Jumlah Sewa Melebihi Stock Yang Ada untuk product",
            icon: "error"
          });
        }
        else{
          snap.pay(response.snapToken, {
          onSuccess: function (result) {
            Swal.fire({
            title: "Berhasil",
            text: "Pembayaran Telah Berhasil",
            icon: "success"
            });
            sessionStorage.removeItem('cart_sewa'); 
          },
          onPending: function (result) {
            console.log(result);
          },
          onError: function (result) {
            console.log(result);
          }
        });
        }
      },
      error: function (xhr, status, error) {
        // Handle error
        console.error(xhr.responseText);
      }
    });
  });

  // Calculate total price on date change
  $('#start-date, #return-date').on('change', function () {
    calculateTotalPrice();
  });

  // Initial cart details fetch
  fetchCartDetails();
});
</script>
@endsection

