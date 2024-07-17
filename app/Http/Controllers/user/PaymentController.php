<?php

namespace App\Http\Controllers\user;

use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderJual;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\OrderJualDetail;
use App\Http\Controllers\Controller;


class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized =config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function cartSewaPay(Request $request)
    {
        $order = Order::create([
            'id_customer' => $request->customer,
            'tgl_pesanan' => $request->start_date,
            'tgl_kembali' => $request->return_date,
            'note' => $request->note,
            'status' => 'pending',
            'total' => $request->total_price,
        ]);

        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);
            if ($product->stock >= $productData['quantity']) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['id'],
                    'quantity' => $productData['quantity'],
                    'price' =>$product->harga_product *$productData['quantity']
                ]);
    
                $product->update([
                    'stock' => $product->stock - $productData['quantity'],
                ]);
            } else {
                // Rollback
                $order->delete();
                return response()->json(array('status' => 400 , 'message' =>"Jumlah Sewa Melebihi Stock Yang Ada untuk product"));
            }
        }
        $customer = User::find($order->id_customer);
    
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $order->total,
            ],
            'credit_card' => [
                'secure' => true
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'last_name' => $customer->role,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return response()->json(array("snapToken"=>$snapToken));
    }


    public function cartBeliPay(Request $request){
        $order = OrderJual::create([
            'id_customer' => $request->customer,
            'tgl_pesanan' => $request->start_date,
            'tgl_pembayaran' => now(),
            'note' => $request->note,
            'status' => 'pending',
            'status_payment' => 'sudah bayar',
            'total' =>  $request->total_price,
        ]);
    
        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);
            if ($product->stock >= $productData['quantity']) {
                OrderJualDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['id'],
                    'quantity' => $productData['quantity'],
                    'price' =>$product->harga_product *$productData['quantity']
                ]);
    
                $product->update([
                    'stock' => $product->stock - $productData['quantity'],
                ]);
            } else {
                // Rollback
                $order->delete();
                return response()->json(array('status' => 400 , 'message' =>"Jumlah Beli Melebihi Stock Yang Ada untuk product"));
            }
        }

        $customer = User::find($order->id_customer);
    
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $order->total,
            ],
            'credit_card' => [
                'secure' => true
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'last_name' => $customer->role,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return response()->json(array("snapToken"=>$snapToken));
    }
}
