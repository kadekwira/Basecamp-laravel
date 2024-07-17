@extends('layouts.layoutUser')

@section('content')

<div class="container" style="margin-top:100px;">
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Tanggal Pesanan</th>
          <th scope="col">Tanggal Pembayaran</th>
          <th scope="col">Status Sewa</th>
          <th scope="col">Total</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($order as $index=>$item)
        <tr class="text-center ">
          <th class="py-3">{{$index+1}}</th>
          <td class="py-3">{{$item->tgl_pesanan}}</td>
          <td class="py-3">{{$item->tgl_payment}}</td>
          <td class="py-3">
            @if ($item->status=='terima')
            <span class="badge bg-success">{{$item->status}}</span>
            @elseif ($item->status=='tolak')
            <span class="badge bg-danger">{{$item->status}}</span>
            @else
            <span class="badge bg-warning">{{$item->status}}</span> 
            @endif
          </td>
          <td class="py-3">@rupiah($item->total)</td>
          <td class="py-3">
            <a href="{{route('order.jual.detail',$item->id)}}" class="bg-primary p-2 rounded text-white">
              Detail
            </a>
          </td>
        </tr>
        @empty
            <tr>
              <td colspan="6" class="text-center">Data Not Available</td>
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
