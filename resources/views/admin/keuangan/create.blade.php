@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Pengeluaran</h1>
    </div>
    <div class="row">
      <div class="col-12 ">
        <div class="card">
          <form method="post" action="{{route('pengeluaran.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
              <h4>Form Tambah Data Pengeluaran</h4>
            </div>
            <div class="card-body row">
              <div class="col-12">
                <div class="form-group">
                  <label> Nama Product</label>
                  <input type="text" class="form-control" required=""
                  name="nama_product"
                  >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Tanggal Pembelian</label>
                  <input type="date" class="form-control" name="tgl_pembelian" required>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Jumlah</label>
                  <input type="number" class="form-control" name="jumlah" required >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Total</label>
                  <input type="text" class="form-control" name="total" required id="total">
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <a href="{{route('pengeluaran.index')}}" class="btn btn-danger">Batal</a>
              <button class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
      </div>
    </div>
  </section>
</div>
@endsection




@section('addCss')

@endsection
@section('addJavascript')
<script>
  var input = document.getElementById('total');
  input.addEventListener('keyup', function(e) {
      var bilangan = e.target.value.replace(/[^,\d]/g, '').toString(),
          split = bilangan.split(','),
          sisa = split[0].length % 3,
          rupiah = split[0].substr(0, sisa),
          ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
  
      if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }
  
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      var formattedValue = 'Rp. ' + rupiah; // Menambahkan prefix "Rp." secara default
      input.value = formattedValue;
  });
  </script>
@endsection