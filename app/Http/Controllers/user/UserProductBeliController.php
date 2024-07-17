<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProductBeliController extends Controller
{
    public function index(){
        $products = Product::where('type', 'jual')->get();
        return view('user.product-jual',compact('products'));
    }

    public function detailJual(string $id){
       $product = Product::findOrFail($id);
       return view('user.detail-product-beli',compact('product'));
    }
}
