<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PengeluaranJualController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Pengeluaran::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.keuangan2.pengeluaran');
    }

    public function create(){
        return view('admin.keuangan2.create');    
    }

    public function store(Request $request){
        Pengeluaran::create([
            "nama product"=>$request->nama_product,
            "tgl_pembelian" =>$request->tgl_pembelian,
            "jumlah"=>$request->jumlah,
            "total"=> convertToDouble($request->input('total'))
        ]);

        return redirect()->route('pengeluaran-jual.index')->with('success', 'Pengeluaran berhasil dibuat.');
    }
}
