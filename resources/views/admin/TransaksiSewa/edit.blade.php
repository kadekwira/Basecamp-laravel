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
          <form method="post" action="{{ route('transaksi-sewa.kembali', $data->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-header">
              <h4>Edit Data Pesanan</h4>
            </div>
            <div class="card-body row">
              <div class="col-12">
                <div class="form-group">
                  <label>Barang yang dikembalikan</label>
                  <input type="number" class="form-control" id="jumlah" name="jumlah" required >
                </div>
                <div class="form-group">
                  <label>Total Penyewaan</label>
                  <input type="text" class="form-control" id="total_sewa" name="total_sewa" value="@rupiah($data->total)" required readonly>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Hilang</label>
                  <input type="text" class="form-control" id="harga_hilang" name="harga_hilang" value="@rupiah($data->harga_hilang)" >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Telat</label>
                  <input type="text" class="form-control" id="harga_telat" name="harga_telat" value="@rupiah($data->harga_telat)" >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Rusak</label>
                  <input type="text" class="form-control" id="harga_rusak" name="harga_rusak" value="@rupiah($data->harga_rusak)" >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Total</label>
                  <input type="text" class="form-control" id="total" name="total" value="@rupiah($data->total)" required readonly>
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
  document.addEventListener('DOMContentLoaded', function() {
    function formatRupiah(value) {
      let number_string = value.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return 'Rp ' + rupiah;
    }

    function calculateTotal() {
      let totalSewa = parseInt(document.getElementById('total_sewa').value.replace(/[^,\d]/g, '')) || 0;
      let hargaHilang = parseInt(document.getElementById('harga_hilang').value.replace(/[^,\d]/g, '')) || 0;
      let hargaTelat = parseInt(document.getElementById('harga_telat').value.replace(/[^,\d]/g, '')) || 0;
      let hargaRusak = parseInt(document.getElementById('harga_rusak').value.replace(/[^,\d]/g, '')) || 0;
      let total = totalSewa + hargaHilang + hargaTelat + hargaRusak;
      document.getElementById('total').value = formatRupiah(total.toString());
    }

    document.querySelectorAll('#harga_hilang, #harga_telat, #harga_rusak').forEach(input => {
      input.addEventListener('input', function(e) {
        this.value = formatRupiah(this.value);
        calculateTotal();
      });
    });

    // Initialize the total calculation on page load
    calculateTotal();
  });
</script>
@endsection
