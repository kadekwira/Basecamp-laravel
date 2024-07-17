@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Order Detail</h1>
    </div>

    <div class="section-body">
      <div class="invoice">
        <div class="invoice-print">
          <div class="row">
            <div class="col-lg-12">
              <div class="invoice-title">
                <h2>Order Detail</h2>
                <div class="invoice-number">Order #{{$id}}</div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <address>
                    <strong>Customer:</strong><br>
                      {{$dataOrderAndCustomer->customer->name}}<br>
                      {{$dataOrderAndCustomer->customer->phone}}<br>
                      {{$dataOrderAndCustomer->tgl_pesanan}}<br>
                      {{$dataOrderAndCustomer->customer->address}}
                  </address>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <address>
                    <strong>Tanggal Order:</strong><br>
                    {{$newDate}}<br><br>
                  </address>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="section-title">List Order</div>
              <p class="section-lead">Semua barang disini tidak bisa di hapus</p>
              <div class="table-responsive">
                <table class="table table-striped table-hover table-md">
                  <tr>
                    <th data-width="40">#</th>
                    <th>Item</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-right">Total</th>
                  </tr>
                  @php
                      $no=1;
                  @endphp
                  @foreach ($orderDetail as $item)
                  <tr>
                    <td>{{$no}}</td>
                    <td>{{$item->product->nama_product}}</td>
                    <td class="text-center">@rupiah($item->product->harga_product)</td>
                    <td class="text-center">{{$item->quantity}}</td>
                    <td class="text-right">@rupiah($item->price)</td>
                  </tr>
                  @php
                      $no++;
                  @endphp
                  @endforeach
                </table>
              </div>
              <div class="row mt-4">
                  <hr class="mt-2 mb-2">
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Total</div>
                    <div class="invoice-detail-value invoice-detail-value-lg">@rupiah($dataOrderAndCustomer->total)</div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="text-md-right">
              <div class="float-lg-right mb-lg-0 mb-3">
                <form action="{{route('order-jual.acc',$id)}}" method="POST" style="display: inline;">
                  @csrf
                  <input type="hidden" name="_method" value="PUT">
                  <button type="submit" class="btn btn-icon btn-success"><i class="far fa-check-circle"></i> Terima</button>
              </form>
              <form action="{{route('order-jual.tolak', $id)}} " method="POST" style="display: inline;">'
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <button type="submit" class="btn btn-icon btn-danger"><i class="far fa-times-circle"></i>Tolak</button>
            </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


@endsection

@section('addCss')

@endsection

@section('addJavascript')

@endsection
