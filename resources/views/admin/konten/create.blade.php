@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Konten</h1>
    </div>
    <div class="row">
      <div class="col-12 ">
        <div class="card">
          <form method="post" action="{{route('konten.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
              <h4>Add Data Konten</h4>
            </div>
            <div class="card-body row">
              <div class="col-12">
                <div class="form-group">
                  <label> Nama Konten</label>
                  <input type="text" class="form-control" required=""
                  name="nama_konten"
                  >
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Jadwal Unggah</label>
                  <input type="datetime-local" class="form-control" name="jadwal_post" required>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Jadwal Berakhir</label>
                  <input type="datetime-local" class="form-control" name="jadwal_end" required>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>URL Foto/Video</label>
                  <input type="text" class="form-control" name="url" required>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Tipe</label>
                  <select class="form-control" id="type" name="type" required>
                    <option value="img">Gambar</option>
                    <option value="video">Video</option>
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





@section('addJavascript')

@endsection