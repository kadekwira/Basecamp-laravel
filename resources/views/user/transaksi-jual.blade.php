@extends('layouts.layoutUser')

@section('content')

<div class="container" style="margin-top:100px;">
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr class="text-center">
          <th scope="col">#</th>
          <th scope="col">Order ID</th>
          <th scope="col">Tanggal Pesanan</th>
          <th scope="col">Tanggal Pembayaran</th>
          <th scope="col">Status Payment</th>
          <th scope="col">Status</th>
          <th scope="col">Total</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($transaksi as $index=>$item)
        <tr class="text-center">
          <th class="py-3">{{$index+1}}</th>
          <td class="py-3">{{$item->id_order}}</td>
          <td class="py-3">{{$item->tgl_pesanan}}</td>
          <td class="py-3">{{$item->tgl_payment}}</td>
          <td class="py-3">
            @if ($item->status_payment=='sudah bayar')
            <span class="badge bg-success">{{$item->status_payment}}</span>
            @else
            <span class="badge bg-warning">{{$item->status_payment}}</span> 
            @endif
          </td>
          <td class="py-3">
            @if ($item->status=='selesai')
            <span class="badge bg-success">{{$item->status}}</span>
            @else
            <span class="badge bg-warning">{{$item->status}}</span> 
            @endif
          </td>
          <td class="py-3">@rupiah($item->total)</td>
          <td class="py-3">
            <a href="{{route('transaksi.jual.cetak',$item->id)}}" class="bg-primary p-2 rounded">
              <i class="fa-solid fa-print text-white"></i>
            </a>
          </td>
        </tr>
        @empty
            <tr>
              <td colspan="8" class="text-center">Data Not Available</td>
            </tr>
        @endforelse
  
      </tbody>
    </table>
  </div>
</div>

@endsection

@section('addCss')
<style>
  .table-primary {
    background-color: #F0861A !important;
    border: none;
  }

</style>
@endsection