<?php

namespace App\Http\Controllers\user;

use App\Models\Order;
use App\Models\OrderJual;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\TransaksiJual;
use App\Models\TransaksiSewa;
use App\Models\OrderJualDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerTransaksiController extends Controller
{
    public function sewa(){
        $id = Auth::user()->id;
        $transaksi = TransaksiSewa::where('id_customer',$id)->get();
        return view('user.transaksi-sewa',compact('transaksi'));
    }

    public function cetakSewa($id)
    {
        $transaksi = TransaksiSewa::findOrFail($id);
        $order = Order::where('id', $transaksi->id_order)->with('customer')->get();
        $orderDetail = OrderDetail::where('order_id',$transaksi->id_order)->with('product')->get();
        $dateString = $transaksi->created_at;
        $newDate = date("F d, Y", strtotime($dateString));

        $pdf = Pdf::loadView('admin.TransaksiSewa.invoice', compact('transaksi','orderDetail','order','newDate'));
        return $pdf->download('invoice_' . $transaksi->id . '.pdf');
    }


    public function jual(){
        $id = Auth::user()->id;
        $transaksi = TransaksiJual::where('id_customer',$id)->get();
        return view('user.transaksi-jual',compact('transaksi'));
    }

    public function cetakJual($id)
    {
        $transaksi = TransaksiJual::findOrFail($id);
        $order = OrderJual::where('id', $transaksi->id_order)->with('customer')->get();
        $orderDetail = OrderJualDetail::where('order_id',$transaksi->id_order)->with('product')->get();
        $dateString = $transaksi->created_at;
        $newDate = date("F d, Y", strtotime($dateString));

        $pdf = Pdf::loadView('admin.TransaksiJual.invoice', compact('transaksi','orderDetail','order','newDate'));
        return $pdf->download('invoice_' . $transaksi->id . '.pdf');
    }

}
