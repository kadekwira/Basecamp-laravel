@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Product Sewa</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{route('product-sewa.create')}}" class="btn btn-icon btn-success ml-auto button-header-add"><i class="fas fa-plus"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="tableDataAdmin">
                <thead>                                 
                  <tr class="text-center">
                    <th>No</th>
                    <th>Nama Product</th>
                    <th>Gambar Product</th>
                    <th>Stock</th>
                    <th>Harga Product</th>
                    <th>Deskripsi</th>
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
    $('#tableDataAdmin').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route('product-sewa.index') }}',
        type: 'GET'
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false,className: 'text-center' },
        { data: 'nama_product', name: 'nama_product',className: 'text-center' },
        { data: 'image', name: 'image',className: 'text-center' },
        { data: 'stock', name: 'stock' ,className: 'text-center'},
      
        { data: 'harga_product', name: 'harga_product', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') ,className: 'text-center'},
        { data: 'deskripsi', name: 'deskripsi' ,className: 'text-center'},
        { data: 'status', name: 'status',className: 'text-center'},
        { data: 'action', name: 'action', orderable: false, searchable: false,className: 'text-center' },
      ]
    });
  });
</script>
</script>
@endsection
