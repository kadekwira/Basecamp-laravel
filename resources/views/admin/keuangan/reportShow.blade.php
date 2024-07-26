@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Laporan Penyewaan</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <form action="{{route('transaksi-sewa.reportSewaCetak')}}" class="ml-auto" method="post">
              @csrf
              <input type="hidden" value="{{$month}}" name="month">
              <input type="hidden" value="{{$year}}" name="year">
              <button type="submit" class="btn btn-icon btn-info ml-auto button-header-add"><i class="fa-solid fa-print"></i></button>
            </form>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="tableDataAdmin">
                <thead>                                 
                  <tr class="text-center">
                    <th>#</th>
                    <th>Transaksi ID</th>
                    <th>Order ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Total</th>
                    <th>Status Payment</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody> 
                  @foreach ($transaksi as $index => $item)
                  <tr class="text-center"> 
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->order->id }}</td>
                    <td>{{ $item->customer->name }}</td>
                    <td>@rupiah($item->total)</td>
                    <td> <span class="badge badge-success">{{ $item->status_payment }}</span></td>
                    <td> <span class="badge badge-success">{{ $item->status }}</span></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('addCss')
<link rel="stylesheet" href="{{asset('newAdmin/dist/assets/modules/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('newAdmin/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('newAdmin/dist/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
@endsection

@section('addJavascript')
<script src="{{asset('newAdmin/dist/assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('newAdmin/dist/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('newAdmin/dist/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('newAdmin/dist/assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>

<script>
  $(document).ready(function() {
    $('#tableDataAdmin').DataTable();
  });
</script>
@endsection
