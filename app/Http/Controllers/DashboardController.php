<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\TransaksiSewa;

class DashboardController extends Controller
{
    public function index(){
        $admin =  User::where('role', 'admin')->count();
        $customer =  User::where('role','customer')->count();
        $product =  Product::count();
        $order =  Order::where('status','pending')->count();

        $barangSewa = TransaksiSewa::where('status','sewa')->with('order','order.details')->get();
        $totalSewa = 0;
        foreach($barangSewa as $data){
            foreach($data->order->details as $details){
                $totalSewa+=$details->quantity;
            }
        }

        $transactions = TransaksiSewa::selectRaw('MONTH(tgl_pesanan) as month, SUM(total) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

        $transactionData = array_fill(0, 12, 0); 
        foreach ($transactions as $month => $total) {
            $transactionData[$month - 1] = $total;
        }

        $pengeluaran = Pengeluaran::selectRaw('MONTH(tgl_pembelian) as month, SUM(total) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

        $pengeluaranData = array_fill(0, 12, 0); 
        foreach ($pengeluaran as $month => $total) {
            $pengeluaranData[$month - 1] = $total;
        }




        return view('admin.dashboard.index',compact('totalSewa', 'customer', 'product', 'order', 'transactionData','pengeluaranData'));
    }
}
