@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Admin</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{route('data-admin.create')}}" class="btn btn-icon btn-success ml-auto button-header-add"><i class="fas fa-plus"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="tableDataAdmin">
                <thead>                                 
                  <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>No Telp</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>KTP</th>
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
        url: '{{ route('data-admin.index') }}',
        type: 'GET'
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false ,className: 'text-center'},
        { data: 'name', name: 'name' ,className: 'text-center'},
        { data: 'phone', name: 'phone' ,className: 'text-center'},
        { data: 'address', name: 'address' ,className: 'text-center'},
        { data: 'email', name: 'email',className: 'text-center' },
        { data: 'ktp', name: 'ktp', orderable: false, searchable: false ,className: 'text-center' },
        { data: 'status', name: 'status',className: 'text-center'},
        { data: 'action', name: 'action', orderable: false, searchable: false ,className: 'text-center'},
      ]
    });
  });
</script>
@endsection
