@extends('layouts.layoutUser')

@section('content')

<div class="container" style="margin-top:100px;">
  
  <div class="container" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="content">
                <div class="body p-4">
                    <div class="px-4 py-5">
                        <h5 class="text-uppercase">{{$dataOrderAndCustomer->customer->name}}</h5>
                        <div class="d-flex justify-content-between">
                            <span class="text-dark">Date Of Order</span>
                            <span class="text-dark">{{$newDate}}</span>
                        </div>
                        <h4 class="mt-5 theme-color mb-5">Thank You</h4>
                        <div class="d-flex justify-content-between">
                            <span class="theme-color">Date Of Buy</span>
                            <span class="theme-color">{{$dataOrderAndCustomer->tgl_pesanan}}</span>
                        </div>
                        <div class="mb-3">
                            <hr class="new1">
                        </div>
                        <div class="d-flex flex-column gap-3">
                            @foreach ($orderDetail as $index => $item)
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold ">{{$item->product->nama_product}} (Qty:{{$item->quantity}}) </span>
                                <span class="text-muted">@rupiah($item->product->harga_product)</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <hr class="new1">
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <span class="fw-bold fs-5">Total</span>
                            <span class="fw-bold theme-color">@rupiah($dataOrderAndCustomer->total)</span>
                        </div>                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>




@endsection

@section('addCss')
<style>
  .table-primary {
    background-color: #F0861A !important;
    border: none;
  }
  .theme-color{

color: #F0861A;
}
hr.new1 {
border-top: 2px dashed #000000;
margin: 0.4rem 0;
}



</style>
@endsection
