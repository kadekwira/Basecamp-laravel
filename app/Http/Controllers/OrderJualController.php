<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderJual;
use Illuminate\Http\Request;
use App\Models\TransaksiJual;
use App\Models\OrderJualDetail;
use Yajra\DataTables\DataTables;

class OrderJualController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {
            $data = OrderJual::with('customer','product')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('id_customer', function($row) {
                    return $row->customer ? $row->customer->name : 'N/A';
                })
                ->editColumn('status_payment', function($row) {
                    $badgeClasses = [
                        'sudah bayar' => 'badge-success',
                        'belum bayar' => 'badge-danger',
                    ];
                    $badgeClass = $badgeClasses[$row->status_payment] ?? 'badge-default';
                    return '<span class="badge ' . $badgeClass . '">' . $row->status_payment . '</span>';
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
                        $detail = '<a href="' . route('order-jual.detail', $row->id) . '" class="btn btn-icon btn-info"><i class="fa-solid fa-info"></i></a>';            
                        return $detail;
                    } else if($row->status === 'tolak'){
                        $wa = '<a target="_blank" href="https://wa.me/'.$row->customer->phone.'?text=Hai" class="btn btn-icon btn-success"><i class="fa-brands fa-whatsapp" ></i></a>';            
                        return $wa;
                    }
                })
                ->rawColumns(['status', 'action','id_customer','id_product','status_payment'])
                ->make(true);
        }

        return view('admin.orderJual.index');
    }

    public function create(){
        $customers =  User::where('role','customer')->select('id','name')->get();
        $products =  Product::where('status','active')->where('type','jual')->get();
        return view('admin.orderJual.create',compact('customers','products')); 
    }

    public function post(Request $request)
    {

        $validatedData = $request->validate([
            'id_customer' => 'required|integer|exists:users,id',
            'tgl_pesanan' => 'required|date',
            'note' => 'nullable|string',
            'products' => 'required|array',
            'products.*.id_product' => 'required|integer|exists:products,id',
            'products.*.jumlah' => 'required|integer|min:1',
            'total'=>'required'
        ]);
        
        $validatedData['total'] =   convertToDouble($request->input('total'));

        $order = OrderJual::create([
            'id_customer' => $request->id_customer,
            'tgl_pesanan' => $request->tgl_pesanan,
            'tgl_pembayaran' => now(),
            'note' => $request->note,
            'status' => 'pending',
            'status_payment' => 'sudah bayar',
            'total' => $validatedData['total'],
        ]);
    
        foreach ($request->products as $productData) {
            $product = Product::find($productData['id_product']);
            if ($product->stock >= $productData['jumlah']) {
                OrderJualDetail::create([
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
                return redirect()->route('order-jual.index')->with('error', 'Jumlah Beli Melebihi Stock Yang Ada untuk product ' . $product->nama_product);
            }
        }
  
        return redirect()->route('order-jual.index')->with('success', 'Order Beli berhasil dibuat.');
    }

    public function detail(Request $request,string $id){
        $orderDetail = OrderJualDetail::where('order_id',$id)->get();
        $dataOrderAndCustomer = OrderJual::with('customer')->find($id);
        $dateString = $dataOrderAndCustomer->created_at;
        $newDate = date("F d, Y", strtotime($dateString));
       return view('admin.orderJual.detail',compact('orderDetail','id','dataOrderAndCustomer','newDate'));
    }

    public function terima(Request $request,string $id){
        $order = OrderJual::find($id);
        TransaksiJual::create([
            'id_customer' => $order->id_customer,
            'id_order'=> $order->id,
            'tgl_pesanan'=>$order->tgl_pesanan,
            'tgl_payment'=>$order->tgl_pembayaran, 
            'total'=>$order->total,
            'status'=>"selesai",
            'status_payment'=>"sudah bayar",
        ]);
        $order->update([
            "status"=>"terima",
        ]);
        return redirect()->route('order-jual.index')->with('success', 'Order Jual berhasil di terima.');
    }
    public function tolak(Request $request,string $id ){
        $order = OrderJual::find($id);
        $orderDetail = OrderJualDetail::where('order_id',$id)->get();
        foreach($orderDetail as $data){
            $product = Product::where('type', 'jual')->find($data->product_id);
            $sisa = $data->quantity + $product->stock;
            $product->update([
                "stock"=>$sisa
            ]);

        }
        $order->update([
            "status"=>"tolak",
        ]);
        return redirect()->route('order-jual.index')->with('success', 'Order Jual berhasil ditolak.');
    }
}
