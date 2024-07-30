@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Produk Jual</h1>
    </div>
    <div class="row">
      <div class="col-12 ">
        <div class="card">
          <form method="post" action="{{route('product-jual.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
              <h4>Form Tambah Data Produk Jual</h4>
            </div>
            <div class="card-body row">
              <div class="col-12">
                <div class="form-group">
                  <div id="photo-preview-container" style="display: none;">
                    <img id="photo-preview" src="#" alt="your image" style="display: none;" />
                    <button type="button" id="remove-photo" class="btn btn-sm btn-danger" style="display: none;"><i class="fas fa-xmark"></i></button>
                </div>
                  <label>Gambar Produk</label>
                  <input type="file" class="form-control" name="image" accept="image/*">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label> Nama Produk</label>
                  <input type="text" class="form-control" required=""
                  name="nama_product"
                  >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Harga Produk</label>
                  <input type="text" class="form-control" name="harga_product" id="harga_product" required>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Deskripsi Produk</label>
                  <input type="text" class="form-control" name="deskripsi"  required>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Stock</label>
                  <input type="number" class="form-control" name="stock" required>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" id="status" name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">inactive</option>
                </select>
                
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <a href="{{route('product-jual.index')}}" class="btn btn-danger">Batal</a>
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
      var input = document.querySelector('input[name="image"]');
      var previewContainer = document.getElementById('photo-preview-container');
      var preview = document.getElementById('photo-preview');
      var removeButton = document.getElementById('remove-photo');

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
          preview.src = '#';
          preview.style.display = 'none';
          removeButton.style.display = 'none';
          previewContainer.style.display = 'none';
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