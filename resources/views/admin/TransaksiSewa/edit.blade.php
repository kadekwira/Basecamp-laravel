@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Form Pengembalian</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <form method="post" action="{{ route('transaksi-sewa.kembali', $data->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header">
              <h4>Form Pengembalian</h4>
            </div>
            <div class="card-body row">
              <div class="col-md-12">
                <div class="section-title">List Order</div>
                <input type="hidden" id="tgl_pesanan" value="{{ $data->tgl_pesanan}}">
                <input type="hidden" id="tgl_kembali" value="{{ $data->tgl_kembali}}">
                <div class="table-responsive">
                  <table class="table table-striped table-hover">
                    <tr>
                      <th data-width="40">#</th>
                      <th>Item</th>
                      <th class="text-center">Jumlah</th>
                      <th class="text-center">Jumlah Kembali</th>
                      <th class="text-center">Harga Hilang</th>
                      <th class="text-center">Harga Telat</th>
                      <th class="text-center">Harga Rusak</th>
                      <th class="text-right" data-width="150">Total</th>
                    </tr>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($orderDetail as $item)
                      <tr class="row-form">
                        <td>{{$no}}</td>
                        <td>{{$item->product->nama_product}}</td>
                        <td class="text-center">{{$item->quantity}}</td>
                        <td class="text-center">
                          

                          <input type="hidden" class="form-control" id="product_id" name="product[{{$no-1}}][id]" value="{{ $item->product->id }}">
                          <input type="number" class="form-control" id="jumlah" name="product[{{$no-1}}][jumlah]" required >
                        </td>
                        <td class="text-center">
                          <input type="text" class="form-control harga_hilang" name="product[{{$no-1}}][harga_hilang]" value="@rupiah($data->harga_hilang)">
                        </td>
                        <td class="text-center">
                          <input type="text" class="form-control harga_telat" name="product[{{$no-1}}][harga_telat]" value="@rupiah($data->harga_telat)" readonly>
                        </td>
                        <td class="text-center">
                          <input type="text" class="form-control harga_rusak" name="product[{{$no-1}}][harga_rusak]" value="@rupiah($data->harga_rusak)" >
                        </td>
                        <td class="text-right">
                          <p class="total-price">Rp. 0</p>
                          <input class="total-price1" type="hidden" name="product[{{$no-1}}][total]" ></input>
                        </td>
                      </tr>
                      @php
                        $no++;
                      @endphp
                    @endforeach
                  </table>
                </div>
                <div class="row mt-4">
                    <hr class="mt-2 mb-2">
                    <div class="form-group">
                      <label>Total yang sudah di bayar</label>
                      <input type="text" class="form-control" id="total_sewa" name="total_sewa" value="@rupiah($data->total)" required readonly>
                    </div>
                    <div class="form-group ml-2">
                      <label>Sisa Bayar</label>
                      <input type="text" class="form-control" id="sisa_bayar" name="sisa_bayar" required readonly value="@rupiah(0)">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <a href="{{route('transaksi-sewa.index')}}" class="btn btn-danger">Batal</a>
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

  function formatInputRupiah(input) {
    var value = input.val().replace(/\D/g, '');
    input.val(formatRupiah(value, 'Rp. '));
  }

  function calculateTotalPrice() {
    var totalSisaBayar = 0;

    $('.row-form').each(function() {
      var hargaHilang = parseInt($(this).find('.harga_hilang').val().replace(/\D/g, '') || 0);
      var hargaTelat = parseInt($(this).find('.harga_telat').val().replace(/\D/g, '') || 0);
      var hargaRusak = parseInt($(this).find('.harga_rusak').val().replace(/\D/g, '') || 0);

      var totalKembali = hargaHilang + hargaTelat + hargaRusak;

      $(this).find('.total-price').text(formatRupiah(totalKembali.toString(), 'Rp. '));
      $(this).find('.total-price1').val(totalKembali);

      totalSisaBayar += totalKembali;
    });

    $('#sisa_bayar').val(formatRupiah(totalSisaBayar.toString(), 'Rp. '));
  }
  function calculateLateFee() {
    var tglKembali = new Date($('#tgl_kembali').val());
    var today = new Date();
    var lateDays = Math.floor((today - tglKembali) / (1000 * 60 * 60 * 24)); 

    if (lateDays > 0) {
      var lateFee = lateDays * 10000; 

      $('.harga_telat').each(function() {
        $(this).val(formatRupiah(lateFee.toString(), 'Rp. '));
      });

      
      $('.total-price').text(formatRupiah(lateFee.toString(), 'Rp. '));
      $('.total-price1').val(lateFee);
      totalSisaBayar = 0;
      totalSisaBayar += lateFee;
      $('#sisa_bayar').val(formatRupiah(totalSisaBayar.toString(), 'Rp. '));
    }
  }
  $(document).on('input', '.harga_hilang, .harga_telat, .harga_rusak', function() {
    formatInputRupiah($(this));
    calculateTotalPrice();
    
  });

  calculateTotalPrice();
  calculateLateFee()
});
</script>
@endsection
