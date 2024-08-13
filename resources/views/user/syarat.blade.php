@extends('layouts.layoutUser')

@section('content')
<div class="container my-5">
  <h2 class="text-center">Please read the <span class="text-primary">terms and</span>  <span class="text-primary">conditions</span></h2>

  <div class="d-flex  flex-wrap justify-content-center gap-3 mt-5">
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Digunakan <strong>sebaik</strong> mungkin sesuai dengan fungsinya.</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Barang dapat diambil <strong>sehari</strong> atau <strong>dua hari</strong> sebelumnya.</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center"><strong>Keterlambatan</strong> dikenakan denda <strong>Rp 10.000</strong> /day.</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center"><strong>Kerusakan</strong> barang akan dikenakan denda 
          <strong>Rp 5.000 - 700.000</strong>  sesuai keadaan barang.</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center"><strong>Kehilangan</strong>  barang akan dikenakan denda
         <strong>Rp 5.000 - 700.000</strong>  sesuai keadaan barang</p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Konfirmasi pesanan <strong>diterima/ditolak</strong>  dikirim melalui <strong>chat personal</strong> </p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Saat melakukan Penyewaan pelanggan minimal memiliki umur <strong>17 tahun</strong> karena memerlukan tanda pengenal <strong>KTP/KTM</strong></p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Mohon untuk menunggu <strong>15-30 menit</strong>  jika pesanan ditolak oleh admin </p>
      </div>
    </div>
    <div class="card w-25">
      <div class="card-body">
        <h5 class="card-title text-center fs-3"><i class="fa-solid fa-toolbox text-primary"></i></h5>
        <p class="card-text text-center">Admin akan melakukan chat personal terkait <strong>pengembalian dana</strong>  / hubungi <strong>kontak</strong>  yang tertera dibawah </p>
      </div>
    </div>
  </div>
</div>
@endsection