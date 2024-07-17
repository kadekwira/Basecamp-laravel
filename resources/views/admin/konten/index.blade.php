@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Konten</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('konten.create') }}" class="btn btn-icon btn-success ml-auto button-header-add"><i class="fas fa-plus"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="tableDataAdmin">
                <thead>                                 
                  <tr class="text-center">
                    <th>No</th>
                    <th>Nama Konten</th>
                    <th>Jadwal Unggah</th>
                    <th>Jadwal Berakhir</th>
                    <th>Video/Foto</th>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#tableDataAdmin').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('konten.index') }}',
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'nama_konten', name: 'nama_konten', className: 'text-center' },
                { data: 'jadwal_post', name: 'jadwal_post', className: 'text-center' },
                { data: 'jadwal_end', name: 'jadwal_end', className: 'text-center' },
                { data: 'url', name: 'url', className: 'text-center' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                            <a href="${row.edit_url}" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                            <button class="btn btn-icon btn-danger" onclick="deleteKonten(${row.id})"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-${row.id}" action="${row.action.delete_url}" method="POST" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        `;
                    }
                }
            ]
        });
    });

    function deleteKonten(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
