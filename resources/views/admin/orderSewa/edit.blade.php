@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Edit Data Pesanan</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <form method="post" action="{{ route('order-sewa.update', $order->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            <div class="card-header">
              <h4>Edit Data Pesanan</h4>
            </div>
            <div class="card-body row">
              <div class="col-12">
                <div class="form-group">
                  <label>Nama Pelanggan</label>
                  <select class="form-control" id="id_customer" name="id_customer" required>
                    @forelse ($customers as $customer)
                      <option value="{{ $customer->id }}" {{ $customer->id == $order->id_customer ? 'selected' : '' }}>
                        {{ $customer->name }}
                      </option>
                    @empty
                      <option value="">Data Tidak Tersedia</option>
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Product</label>
                  <select class="form-control" id="id_product" name="id_product" required>
                    @forelse ($products as $product)
                      <option value="{{ $product->id }}" 
                              data-price="{{ $product->harga_product }}"
                              data-hilang="{{ $product->harga_hilang }}"
                              data-telat="{{ $product->harga_telat }}"
                              data-rusak="{{ $product->harga_rusak }}"
                              {{ $product->id == $order->id_product ? 'selected' : '' }}>
                        {{ $product->nama_product }}
                      </option>
                    @empty
                      <option value="">Data Tidak Tersedia</option>
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Jumlah Product</label>
                  <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $order->jumlah }}" required >
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Tanggal Pesanan</label>
                  <input type="date" class="form-control" id="tgl_pesanan" name="tgl_pesanan" value="{{ $order->tgl_pesanan }}" required >
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Tanggal Kembali</label>
                  <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" value="{{ $order->tgl_kembali }}" required >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Product</label>
                  <input type="text" class="form-control" id="harga_product" name="harga_product" value="{{ $order->harga_product }}" required readonly>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Hilang</label>
                  <input type="text" class="form-control" id="harga_hilang" name="harga_hilang" value="{{ $order->harga_hilang }}" required readonly>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Telat</label>
                  <input type="text" class="form-control" id="harga_telat" name="harga_telat" value="{{ $order->harga_telat }}" required readonly>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Rusak</label>
                  <input type="text" class="form-control" id="harga_rusak" name="harga_rusak" value="{{ $order->harga_rusak }}" required readonly>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Total</label>
                  <input type="text" class="form-control" id="total" name="total" value="{{ $order->total }}" required readonly>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Note</label>
                  <input type="text" class="form-control" id="note" name="note" value="{{ $order->note }}">
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
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

  $(document).ready(function() {
    function updatePrices() {
      var selectedProduct = $('#id_product').find('option:selected');
      var price = selectedProduct.data('price').toString();
      var hilang = selectedProduct.data('hilang').toString();
      var telat = selectedProduct.data('telat').toString();
      var rusak = selectedProduct.data('rusak').toString();
      var jumlah = $('#jumlah').val();
      var total = (parseFloat(price.replace(/[^,\d]/g, '')) * parseInt(jumlah)).toString();

      $('#harga_product').val(formatRupiah(price, 'Rp. '));
      $('#harga_hilang').val(formatRupiah(hilang, 'Rp. '));
      $('#harga_telat').val(formatRupiah(telat, 'Rp. '));
      $('#harga_rusak').val(formatRupiah(rusak, 'Rp. '));
      $('#total').val(formatRupiah(total, 'Rp. '));
    }

    $('#id_product').change(updatePrices);
    $('#jumlah').on('input', updatePrices);

    // Trigger change event on page load to set initial prices if needed
    $('#id_product').trigger('change');
  });
</script>
@endsection
