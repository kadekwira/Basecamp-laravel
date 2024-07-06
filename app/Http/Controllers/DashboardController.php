<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\TransaksiSewa;

class DashboardController extends Controller
{
    public function index(){
        $admin =  User::where('role', 'admin')->count();
        $customer =  User::where('role','customer')->count();
        $product =  Product::count();
        $order =  Order::where('status','pending')->count();

        $transactions = TransaksiSewa::selectRaw('MONTH(tgl_pesanan) as month, SUM(total) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

        $transactionData = array_fill(0, 12, 0); // Start index from 1 for months
        foreach ($transactions as $month => $total) {
            $transactionData[$month - 1] = $total;
        }
        return view('admin.dashboard.index',compact('admin', 'customer', 'product', 'order', 'transactionData'));
    }
}
