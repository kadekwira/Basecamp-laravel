@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Keuangan</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <form method="post" action="{{ route('transaksi-sewa.reportSewaCetak') }}" >
            @csrf
            <div class="card-header">
              <h4>Laporan Penyewaan</h4>
            </div>
            <div class="card-body row">
              <div class="col-12">
                <div class="form-group">
                    <label for="month">Bulan</label>
                    <select class="form-control" id="month" name="month">
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="year">Tahun</label>
                    <select class="form-control" id="year" name="year">
                        @php
                            $startYear = date('Y');
                            $endYear = date('Y') + 10;
                        @endphp
                        @for ($i = $startYear; $i <= $endYear; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
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


