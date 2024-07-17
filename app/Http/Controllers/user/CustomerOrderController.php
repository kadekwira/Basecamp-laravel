<?php

namespace App\Http\Controllers\user;

use App\Models\Order;
use App\Models\OrderJual;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\OrderJualDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{

    public function sewa(){
        $id = Auth::user()->id;
        $order = Order::where('id_customer',$id)->get();
        return view('user.list-order',compact('order'));
    }

    public function detail(string $id){
        $orderDetail = OrderDetail::where('order_id',$id)->get();
        $dataOrderAndCustomer = Order::with('customer')->find($id);
        $dateString = $dataOrderAndCustomer->created_at;
        $newDate = date("F d, Y", strtotime($dateString));

        return view('user.list-order-detail',compact('newDate','dataOrderAndCustomer','orderDetail'));
    }

    public function jual(){
        $id = Auth::user()->id;
        $order = OrderJual::where('id_customer',$id)->get();
        return view('user.list-order-jual',compact('order'));
    }


    public function detailJual(string $id){
        $orderDetail = OrderJualDetail::where('order_id',$id)->get();
        $dataOrderAndCustomer = OrderJual::with('customer')->find($id);
        $dateString = $dataOrderAndCustomer->created_at;
        $newDate = date("F d, Y", strtotime($dateString));
        
        return view('user.list-order-jual-detail',compact('newDate','dataOrderAndCustomer','orderDetail'));

    }


}
