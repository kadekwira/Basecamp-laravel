<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\TransaksiSewa;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;

class TransaksiSewaController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = TransaksiSewa::with('customer','product')->get();
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
                        'selesai' => 'badge-success',
                        'sewa' => 'badge-warning',
                    ];
                    $badgeClass = $badgeClasses[$row->status] ?? 'badge-default';
                    return '<span class="badge ' . $badgeClass . '">' . $row->status . '</span>';
                })
                ->editColumn('status_payment', function($row) {
                    $badgeClasses = [
                        'sudah bayar' => 'badge-success',
                        'pending' => 'badge-warning',
                        'belum bayar' => 'badge-danger',
                    ];
                    $badgeClass = $badgeClasses[$row->status_payment] ?? 'badge-default';
                    return '<span class="badge ' . $badgeClass . '">' . $row->status_payment . '</span>';
                })
                ->addColumn('action', function($row) {
                    $edit = '<a href="' . route('transaksi-sewa.edit', $row->id) . '" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>';
                    $cetak = '<a href="' . route('transaksi-sewa.cetak', $row->id) . '" class="btn btn-icon btn-info"><i class="fas fa-print"></i></a>';

                    if ($row->status == 'sewa') {
                        return '<div class="d-flex justify-content-center">' . $edit . ' ' . $cetak . '</div>';
                    } else {
                        return '<div class="d-flex justify-content-center">' . $cetak . '</div>';
                    }
                })
                ->rawColumns(['status', 'status_payment', 'action', 'id_customer', 'id_product'])
                ->make(true);
        }

        return view('admin.TransaksiSewa.index');
    }


    public function edit(string $id){
        $data = TransaksiSewa::find($id);
        return view('admin.TransaksiSewa.edit',compact('data'));
    }

    public function kembali(Request $request, string $id){
        $transaksi = TransaksiSewa::find($id);
        $transaksi->harga_hilang = convertToDouble($request->input('harga_hilang'));
        $transaksi->harga_telat = convertToDouble($request->input('harga_telat'));
        $transaksi->harga_rusak = convertToDouble($request->input('harga_rusak'));
        $transaksi->total = convertToDouble($request->input('total'));
        $transaksi->status = 'selesai';
        $transaksi->status_payment = 'sudah bayar';

        $product = Product::find($transaksi->id_product);
        $product->stock += $request->jumlah;

        $product->update();
        $transaksi->update();
        return redirect()->route('transaksi-sewa.index')->with('success', 'Transaksi Sewa berhasil di Update!.');
    }

    public function cetak($id)
    {
        $transaksi = TransaksiSewa::with('customer', 'product')->findOrFail($id);
        $pdf = Pdf::loadView('admin.TransaksiSewa.invoice', compact('transaksi'));
        return $pdf->download('invoice_' . $transaksi->id . '.pdf');
    }


    public function reportSewa(){
        return view('admin.keuangan.reportSewa');
    }

    public function reportSewaCetak(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');

        
        $transaksi = TransaksiSewa::with('customer', 'product')
            ->whereMonth('tgl_pesanan', $month)
            ->whereYear('tgl_pesanan', $year)
            ->get();

        if ($transaksi->isEmpty()) {
                return redirect()->route('transaksi-sewa.reportSewa')->with('error', 'Tidak ada transaksi untuk bulan dan tahun yang dipilih.');
           }
        else{
            $pdf = Pdf::loadView('admin.keuangan.PDFSewa', compact('transaksi','month','year'));
            return $pdf->download('report_transaksi_sewa_' . $month . '_' . $year . '.pdf');   
        }
    }
}
