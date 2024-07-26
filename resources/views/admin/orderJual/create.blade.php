@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Pesanan</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <form method="post" action="{{ route('order-jual.post') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
              <h4>Form Tambah Data Pesanan</h4>
            </div>
            <div class="card-body row">
              <div class="col-4">
                <div class="form-group">
                  <label>Nama Pelanggan</label>
                  <select class="form-control" id="id_customer" name="id_customer" required>
                    @forelse ($customers as $customer)
                      <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @empty
                      <option value="">Data Tidak Tersedia</option>
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Tanggal Pesanan</label>
                  <input type="date" class="form-control" id="tgl_pesanan" name="tgl_pesanan" required>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label>Produck</label>
                  <input type="text" id="search-product" class="form-control" placeholder="Search for products...">
                  <div id="search-results" class="list-group"></div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="">List Item</label>
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-md"id="products-table">
                      <thead>
                        <tr>
                          <th>Produk</th>
                          <th>Jumlah</th>
                          <th>Harga Product</th>
                          <th>Harga Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="products-container"></tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label>Note</label>
                  <input type="text" class="form-control" id="note" name="note">
                </div>
              </div>
              <div class="col-4"></div>
              <div class="col-4 p-2">
                <div class="form-group">
                  <div class="d-flex flex-column">
                    <div class="d-flex justify-content-between">
                      <p>Total</p>
                      <h6 id="total-price">Rp. 0</h6>
                      <input id="total-price1" type="hidden" name="total" ></input>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <a href="{{route('order-jual.index')}}" class="btn btn-danger">Batal</a>
              <button class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('addJavascript')
<script>
$(document).ready(function() {
  function formatRupiah(angka, prefix) {
    var numberString = angka.replace(/[^,\d]/g, '').toString(),
      split = numberString.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }

  function calculateTotalPrice() {
    var total = 0;
    $('#products-container .product-row').each(function() {
      var totalProduct = $(this).find('.total').val().replace(/[^,\d]/g, '');
      total += parseFloat(totalProduct);
    });
    $('#total-price').text(formatRupiah(total.toString(), 'Rp. '));
    $('#total-price1').val(formatRupiah(total.toString(), 'Rp. '));
  }

  function updatePrices(container) {
    var price = container.find('.harga_product').data('price');
    var jumlah = container.find('.jumlah').val();
    var total = parseFloat(price) * parseInt(jumlah);
    container.find('.total').val(formatRupiah(total.toString(), 'Rp. '));
    calculateTotalPrice();
  }


  $('#search-product').on('input', function() {
    var query = $(this).val();
    if (query.length > 2) {
      $.ajax({
        url: '{{ route("search-products-jual") }}',
        type: 'GET',
        data: { query: query },
        success: function(data) {
          var searchResults = $('#search-results');
          searchResults.empty();
          data.forEach(function(product) {
            searchResults.append(`
              <a href="#" class="list-group-item list-group-item-action product-item" 
                 data-id="${product.id}" 
                 data-name="${product.nama_product}"
                 data-price="${product.harga_product}"
                 data-stock="${product.stock}">
                ${product.nama_product} - ${product.stock} Pcs - ${formatRupiah(product.harga_product.toString(), 'Rp. ')}
              </a>
            `);
          });
        }
      });
    } else {
      $('#search-results').empty();
    }
  });

  $(document).on('click', '.product-item', function(e) {
    e.preventDefault();
    var index = $('#products-container .product-row').length; // Get the current number of rows
    var productRow = `
      <tr class="product-row">
        <td>
          ${$(this).data('name')}
          <input type="hidden" name="products[${index}][id_product]" value="${$(this).data('id')}">
        </td>
        <td>
          <input type="number" class="form-control jumlah" name="products[${index}][jumlah]" required >
        </td>
        <td class="harga_product" data-price="${$(this).data('price')}">
          ${formatRupiah($(this).data('price').toString(), 'Rp. ')}
        </td>atRupiah($(this).data('rusak').toString(), 'Rp. ')}
        </td>
        <td>
          <input type="text" class="form-control total" name="products[${index}][total]" readonly>
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm remove-product"><i class="fa-solid fa-trash"></i></button>
        </td>
      </tr>
    `;
    $('#products-container').append(productRow);
    $('#search-results').empty();
    $('#search-product').val('');
  });

  $(document).on('input', '.jumlah', function() {
    var container = $(this).closest('.product-row');
    updatePrices(container);
  });

  $(document).on('click', '.remove-product', function() {
    $(this).closest('.product-row').remove();
    calculateTotalPrice();
  });
});
</script>
@endsection

