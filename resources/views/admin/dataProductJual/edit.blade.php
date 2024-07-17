@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Product Jual</h1>
    </div>
    <div class="row">
      <div class="col-12 ">
        <div class="card">
          <form method="post" action="{{route('product-jual.update',$data->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header">
              <h4>Edit Data Product Jual</h4>
            </div>
            <div class="card-body row">
              <div class="col-12">
                <div class="form-group">
                  <input type="hidden" class="form-control" name="image_old" value="{{ $data->image }}">
                  <div id="photo-preview-container" style="display: {{ $data->image ? 'block' : 'none' }}">
                    <img id="photo-preview" src="{{ $data->image ? asset('storage/' . $data->image) : '' }}" alt="your image" style="display: {{ $data->image ? 'block' : 'none' }}"/>
                    <button type="button" id="remove-photo" class="btn btn-sm btn-danger" style="display: {{ $data->image ? 'inline-block' : 'none' }}"><i class="fas fa-times"></i></button>
                  </div>
                  <label>Image</label>
                  <input type="file" class="form-control" name="image" id="image" accept="image/*">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label> Nama Product</label>
                  <input type="text" class="form-control" required=""
                  name="nama_product"  value="{{$data->nama_product}}"
                  >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Product</label>
                  <input type="text" class="form-control" name="harga_product" id="harga_product" required value="@rupiah($data->harga_product)">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Deskripsi Product</label>
                  <input type="text" class="form-control" name="deskripsi"  required value="{{$data->deskripsi}}">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Stock</label>
                  <input type="number" class="form-control" name="stock" required value="{{$data->stock}}">
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
      var oldPhoto = "{{ $data->image ? asset('storage/' . $data->image) : '' }}";

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

<script>
  var input = document.getElementById('harga_product');
  input.addEventListener('keyup', function(e) {
      var bilangan = e.target.value.replace(/[^,\d]/g, '').toString(),
          split = bilangan.split(','),
          sisa = split[0].length % 3,
          rupiah = split[0].substr(0, sisa),
          ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
  
      if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }
  
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      var formattedValue = 'Rp. ' + rupiah; // Menambahkan prefix "Rp." secara default
      input.value = formattedValue;
  });
  </script>

@endsection