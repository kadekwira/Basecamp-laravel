<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function showSewa(Request $request)
    {
        $productIds = $request->input('productIds', []);
        $products = Product::whereIn('id', $productIds)->get();
        
        return response()->json($products);
    }
    public function showJual(Request $request)
    {
        $productIds = $request->input('productIds', []);
        $products = Product::whereIn('id', $productIds)->get();
        
        return response()->json($products);
    }

    public function viewCart()
    {
        return view('user.order-sewa');
    }

    public function viewCartJual(){
        return view('user.order-jual');
    }
}
