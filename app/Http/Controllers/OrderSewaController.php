<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\TransaksiSewa;
use Yajra\DataTables\DataTables;

class OrderSewaController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {
            $data = Order::with('customer','product')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('id_customer', function($row) {
                    return $row->customer ? $row->customer->name : 'N/A';
                })
                ->editColumn('status', function($row) {
                    $badgeClasses = [
                        'terima' => 'badge-success',
                        'tolak' => 'badge-danger',
                        'pending' => 'badge-warning',
                    ];
                    $badgeClass = $badgeClasses[$row->status] ?? 'badge-default';
                    return '<span class="badge ' . $badgeClass . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function($row) {
                    if ($row->status === 'pending') {
                        $detail = '<a href="' . route('order-sewa.detail', $row->id) . '" class="btn btn-icon btn-info"><i class="fa-solid fa-info"></i></a>';            
                        return $detail;
                    } else if($row->status === 'tolak'){
                        $wa = '<a target="_blank" href="https://wa.me/'.$row->customer->phone.'?text=Hai" class="btn btn-icon btn-success"><i class="fa-brands fa-whatsapp" ></i></a>';            
                        return $wa;
                    }else{
                        $wa = '<a target="_blank" href="https://wa.me/'.$row->customer->phone.'?text=Hai" class="btn btn-icon btn-success"><i class="fa-brands fa-whatsapp" ></i></a>';            
                        return $wa; 
                    }
                })
                ->rawColumns(['status', 'action','id_customer','id_product'])
                ->make(true);
        }

        return view('admin.orderSewa.index');
    }

    public function create(){
        $customers =  User::where('role','customer')->select('id','name')->get();
        $products =  Product::where('status','active')->where('type','sewa')->get();
        return view('admin.orderSewa.create',compact('customers','products')); 
    }

    public function post(Request $request)
    {
        
        $validatedData = $request->validate([
            'id_customer' => 'required|integer|exists:users,id',
            'tgl_pesanan' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pesanan',
            'note' => 'nullable|string',
            'products' => 'required|array',
            'products.*.id_product' => 'required|integer|exists:products,id',
            'products.*.jumlah' => 'required|integer|min:1',
            'total'=>'required'
        ]);
        
        $validatedData['total'] =   convertToDouble($request->input('total'));

        // Create the main order
        $order = Order::create([
            'id_customer' => $request->id_customer,
            'tgl_pesanan' => $request->tgl_pesanan,
            'tgl_kembali' => $request->tgl_kembali,
            'note' => $request->note,
            'status' => 'pending',
            'total' => $validatedData['total'],
        ]);
    
        foreach ($request->products as $productData) {
            $product = Product::find($productData['id_product']);
            if ($product->stock >= $productData['jumlah']) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['id_product'],
                    'quantity' => $productData['jumlah'],
                    'price' =>convertToDouble($productData['total'])
                ]);
    
                $product->update([
                    'stock' => $product->stock - $productData['jumlah'],
                ]);
            } else {
                // Rollback
                $order->delete();
                return redirect()->route('order-sewa.index')->with('error', 'Jumlah Sewa Melebihi Stock Yang Ada untuk product ' . $product->nama_product);
            }
        }
  
        return redirect()->route('order-sewa.index')->with('success', 'Order Sewa berhasil dibuat.');
    }
    


    public function edit(string $id)
    {   
        $customers =  User::where('role','customer')->select('id','name')->get();
        $products =  Product::where('status','active')->where('type','sewa')->get();
        $order =  Order::find($id);
        return view('admin.orderSewa.edit',compact('customers','products','order'));
    }
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        $validatedData = $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tgl_pesanan' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pesanan',
            'note' => 'nullable|string',
        ]);

        $validatedData['total'] =   convertToDouble($request->input('total'));
                
        $order->update($validatedData);
        return redirect()->route('order-sewa.index')->with('success', 'Order Sewa berhasil di update.');
    }


    public function terima(Request $request,string $id){
        $order = Order::find($id);
        TransaksiSewa::create([
            'id_customer' => $order->id_customer,
            'id_order'=> $order->id,
            'jumlah' => $order->jumlah,
            'total_sewa_awal' => $order->total,
            'harga_hilang'=>0,
            'harga_telat'=>0,
            'harga_rusak'=>0,
            'tgl_pesanan'=>$order->tgl_pesanan,
            'tgl_kembali'=>$order->tgl_kembali,
            'total'=>$order->total,
            'status'=>"sewa",
            'status_payment'=>"sudah bayar",
        ]);
        $order->update([
            "status"=>"terima",
        ]);
        return redirect()->route('order-sewa.index')->with('success', 'Order Sewa berhasil di terima.');
    }
    public function tolak(Request $request,string $id ){
        $order = Order::find($id);
        $orderDetail = OrderDetail::where('order_id',$id)->get();
        foreach($orderDetail as $data){
            $product = Product::where('type', 'sewa')->find($data->product_id);
            $sisa = $data->quantity + $product->stock;
            $product->update([
                "stock"=>$sisa
            ]);

        }
        $order->update([
            "status"=>"tolak",
        ]);
        return redirect()->route('order-sewa.index')->with('success', 'Order Sewa berhasil ditolak.');
    }

    public function detail(Request $request,string $id){
        $orderDetail = OrderDetail::where('order_id',$id)->get();
        $dataOrderAndCustomer = Order::with('customer')->find($id);
        $dateString = $dataOrderAndCustomer->created_at;
        $newDate = date("F d, Y", strtotime($dateString));
       return view('admin.orderSewa.detail',compact('orderDetail','id','dataOrderAndCustomer','newDate'));
    }
}
