<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
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
                ->editColumn('id_product', function($row) {
                    return $row->product ? $row->product->nama_product : 'N/A';
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
                        $edit = '<a href="' . route('order-sewa.edit', $row->id) . '" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>';
                        $accButton = '<form action="' . route('order-sewa.acc', $row->id) . '" method="POST" style="display: inline;">
                                        ' . csrf_field() . '
                                        <input type="hidden" name="_method" value="PUT">
                                        <button type="submit" class="btn btn-icon btn-success"><i class="far fa-check-circle"></i></button>
                                    </form>';
                
                        $rejectButton = '<form action="' . route('order-sewa.tolak', $row->id) . '" method="POST" style="display: inline;">
                                            ' . csrf_field() . '
                                            <input type="hidden" name="_method" value="PUT">
                                            <button type="submit" class="btn btn-icon btn-danger"><i class="far fa-times-circle"></i></button>
                                        </form>';
                
                        return $edit . ' ' . $accButton . ' ' . $rejectButton;
                    } else {
    
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

    public function post(Request $request){
        $validatedData = $request->validate([
            'id_customer' => 'required|integer|exists:users,id',
            'id_product' => 'required|integer|exists:products,id',
            'jumlah' => 'required|integer|min:1',
            'tgl_pesanan' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pesanan',
            
            'note' => 'nullable|string',
        ]);
        $product = Product::where('type', 'sewa')->find($request->id_product);
        if($product){
            if($product->stock > $request->jumlah){
                $sisa = $product->stock - $request->jumlah;
                $validatedData['status'] = 'pending';
                $validatedData['total'] =   convertToDouble($request->input('total'));
                
                $order = Order::create($validatedData);
                $product->update([
                    'stock' =>$sisa,
                ]);
                return redirect()->route('order-sewa.index')->with('success', 'Order Sewa berhasil dibuat.');
            }else{
                return redirect()->route('order-sewa.index')->with('error', 'Jumlah Sewa Melebihi Stock Yang Ada');
            }
        }


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
            'id_product'=> $order->id_product,
            'jumlah' => $order->jumlah,
            'harga_product' => $order->product->harga_product,
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
        $product = Product::where('type', 'sewa')->find($order->id_product);
        $sisa = $order->jumlah + $product->stock;
        $product->update([
            "stock"=>$sisa
        ]);
        $order->update([
            "status"=>"tolak",
        ]);
        return redirect()->route('order-sewa.index')->with('success', 'Order Sewa berhasil ditolak.');
    }
}
