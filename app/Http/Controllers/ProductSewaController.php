<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductSewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::where('type', 'sewa');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function($row) {
                    if ($row->image) {
                        $url = asset('storage/' . $row->image);
                        return '<a class="" href="' . $url . '" target="_blank">link</a>';
                    } else {
                        return 'tidak ada';
                    }
    
                })
                ->editColumn('status', function($row) {
                    $badgeClasses = [
                        'active' => 'badge-success',
                        'inactive' => 'badge-danger',
                    ];
                    $badgeClass = $badgeClasses[$row->status] ?? 'badge-default';
                    return '<span class="badge ' . $badgeClass . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function($row) {
                    return '<a href="' . route('product-sewa.edit', $row->id) . '" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>';
                })
                ->rawColumns(['status', 'action','image'])
                ->make(true);
        }

        return view('admin.dataProductSewa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dataProductSewa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_product' => 'required|string|max:255',
            'harga_product' => 'required',
            'deskripsi' => 'required',
            'status' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer',
        ]);

        $validatedData['type'] = "sewa";
        $validatedData['harga_product'] =   convertToDouble($request->input('harga_product'));
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product-sewa', 'public');
            $validatedData['image'] = $imagePath;
        }
    
        $product = Product::create($validatedData);
    
        return redirect()->route('product-sewa.index')->with('success', 'Product Sewa berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        $data =  Product::find($id);
        return view('admin.dataProductSewa.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::where('type', 'sewa')->find($id);
    
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    $validatedData = $request->validate([
        'nama_product' => 'sometimes|required|string|max:255',
        'harga_product' => 'required',
        'deskripsi' => 'required',
        'status' => 'sometimes|required|string|max:255',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'stock' => 'sometimes|required|integer',
    ]);

    $validatedData['type'] = "sewa";
    $validatedData['harga_product'] =   convertToDouble($request->input('harga_product'));
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        // Simpan gambar baru
        $imagePath = $request->file('image')->store('product-sewa', 'public');
        $validatedData['image'] = $imagePath;
    }

    $product->update($validatedData);

    return redirect()->route('product-sewa.index')->with('success', 'Product Sewa berhasil di Update!.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {

        $query = $request->input('query');
        $products = Product::where('nama_product', 'LIKE', "%{$query}%")->where('type','sewa')->get();

        return response()->json($products);
    }

}
