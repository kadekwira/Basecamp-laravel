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
          <form method="post" action="{{ route('data-admin-jual.update', $data->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header">
              <h4>Edit Data Admin</h4>
            </div>
            <div class="card-body row">
              <div class="col-12">
                <div class="form-group">
                  <input type="hidden" class="form-control" name="image_old" value="{{ $data->ktp }}">
                  <div id="photo-preview-container" style="display: {{ $data->ktp ? 'block' : 'none' }}">
                    <img id="photo-preview" src="{{ $data->ktp ? asset('storage/' . $data->ktp) : '' }}" alt="your image" style="display: {{ $data->ktp ? 'block' : 'none' }}"/>
                    <button type="button" id="remove-photo" class="btn btn-sm btn-danger" style="display: {{ $data->ktp ? 'inline-block' : 'none' }}"><i class="fas fa-times"></i></button>
                  </div>
                  <label>Foto</label>
                  <input type="file" class="form-control" name="ktp" id="image" accept="image/*">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label> Name</label>
                  <input type="text" class="form-control" required=""
                  name="name" value="{{$data->name}}"
                  >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" required value="{{$data->email}}">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Phone</label>
                  <input type="number" class="form-control" name="phone" required value="{{$data->phone}}">
                </div>
              </div>
              <div class="col-8">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" name="address" required value="{{$data->address}}">
                </div> 
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Role </label>
                  <select class="form-control" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" {{ $data->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $data->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
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

@section('addCss')
<style>
  #photo-preview-container {
      position: relative;
      width: 200px; 
      height: 200px; 
      overflow: hidden;
      margin-bottom: 10px;
  }
  #photo-preview {
      display: block;
      width: 100%;
      height: 100%;
      border-radius: 50%;
  }
  #remove-photo {
      position: absolute;
      top: 2px;
      right: 2px;
      display: none;
  }
</style>
@endsection

@section('addJavascript')
<script>
  document.addEventListener('DOMContentLoaded', function() {
      var input = document.getElementById('image');
      var previewContainer = document.getElementById('photo-preview-container');
      var preview = document.getElementById('photo-preview');
      var removeButton = document.getElementById('remove-photo');
      var oldPhoto = "{{ $data->ktp ? asset('storage/' . $data->ktp) : '' }}";

      // Tampilkan foto lama saat halaman dimuat
      if (oldPhoto) {
          preview.src = oldPhoto;
          previewContainer.style.display = 'block';
          preview.style.display = 'block';
          removeButton.style.display = 'inline-block';
      }

      input.addEventListener('change', function(event) {
          var reader = new FileReader();
          reader.onload = function() {
              preview.src = reader.result;
              previewContainer.style.display = 'block';
              preview.style.display = 'block';
              removeButton.style.display = 'inline-block';
          };
          reader.readAsDataURL(event.target.files[0]);
      });

      removeButton.addEventListener('click', function() {
          preview.src = '';
          previewContainer.style.display = 'none';
          preview.style.display = 'none';
          removeButton.style.display = 'none';
          input.value = '';
      });
  });
</script>
@endsection
