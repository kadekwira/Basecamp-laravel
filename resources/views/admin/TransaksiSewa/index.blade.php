@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Transaksi Sewa</h1>
    </div>
    
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="tableDataAdmin">
                <thead>                                 
                  <tr class="text-center">
                    <th>No</th>
                    <th>Customer</th>
                    <th>ID Order</th>
                    <th>Total Sementara</th>

                    <th>Harga Hilang</th>
                    <th>Harga Telat</th>
                    <th>Harga Rusak</th>
                    <th>Tanggal Pesanan</th>
                    <th>Tanggal Kembali</th>
                    <th>Total</th>
                    <th>Status Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody> 
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
<link rel="stylesheet" href="{{ asset('newAdmin/dist/assets/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('newAdmin/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('newAdmin/dist/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('addJavascript')
<script src="{{ asset('newAdmin/dist/assets/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('newAdmin/dist/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('newAdmin/dist/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('newAdmin/dist/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>

<script>
  $(document).ready(function() {
    $('#tableDataAdmin').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route('transaksi-sewa.index') }}',
        type: 'GET'
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
        { data: 'id_customer', name: 'id_customer', className: 'text-center' },
        { data: 'id_order', name: 'id_order', className: 'text-center' },
        { data: 'total_sewa_awal', name: 'total_sewa_awal', className: 'text-center' , render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')},
        { data: 'harga_hilang', name: 'harga_hilang', className: 'text-center' , render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')},
        { data: 'harga_telat', name: 'harga_telat', className: 'text-center' , render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')},
        { data: 'harga_rusak', name: 'harga_rusak', className: 'text-center' , render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')},
        { data: 'tgl_pesanan', name: 'tgl_pesanan', className: 'text-center' },
        { data: 'tgl_kembali', name: 'tgl_kembali', className: 'text-center' },
        { data: 'total', name: 'total', className: 'text-center' , render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')},
        { data: 'status_payment', name: 'status_payment', className: 'text-center' },
        { data: 'status', name: 'status', className: 'text-center' },
        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
      ]
    });
  });
</script>
@endsection
