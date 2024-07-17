<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProductSewaController extends Controller
{
    public function index(){
        $products = Product::where('type', 'sewa')->get();
        return view('user.product-sewa',compact('products'));
    }

    public function detailSewa(string $id){
       $product = Product::findOrFail($id);
       return view('user.detail-product-sewa',compact('product'));
    }
}
