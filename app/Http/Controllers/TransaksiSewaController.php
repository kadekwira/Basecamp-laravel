<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\TransaksiSewa;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;

class TransaksiSewaController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = TransaksiSewa::with('customer')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('id_customer', function($row) {
                    return $row->customer ? $row->customer->name : 'N/A';
                })
                ->editColumn('id_order', function($row) {
                    return $row->id_order;
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
        $orderDetail = OrderDetail::where('order_id',$data->id_order)->with('product')->get();
        return view('admin.TransaksiSewa.edit',compact('data','orderDetail'));
    }

    public function kembali(Request $request, string $id){

        $transaksi = TransaksiSewa::find($id);
        $harga_hilang = 0;
        $harga_telat = 0;
        $harga_rusak = 0;
        foreach($request->product as $data){

            $product = Product::where('type', 'sewa')->find($data['id']);
            $sisa = $data['jumlah'] + $product->stock;
            $product->update([
                "stock"=>$sisa
            ]);
            $harga_hilang+=convertToDouble($data['harga_hilang']);
            $harga_telat+=convertToDouble($data['harga_telat']);
            $harga_rusak+=convertToDouble($data['harga_rusak']);
        }
        $transaksi->harga_hilang = $harga_hilang;
        $transaksi->harga_telat = $harga_telat;
        $transaksi->harga_rusak = $harga_rusak;
        $transaksi->total = convertToDouble($request->input('total_sewa')) + convertToDouble($request->input('sisa_bayar'));;
        $transaksi->status = 'selesai';
        $transaksi->status_payment = 'sudah bayar';
        $transaksi->update();
        return redirect()->route('transaksi-sewa.index')->with('success', 'Transaksi Sewa berhasil di Update!.');
    }

    public function cetak($id)
    {
        $transaksi = TransaksiSewa::findOrFail($id);
        $order = Order::where('id', $transaksi->id_order)->with('customer')->get();
        $orderDetail = OrderDetail::where('order_id',$transaksi->id_order)->with('product')->get();
        $dateString = $transaksi->created_at;
        $newDate = date("F d, Y", strtotime($dateString));

        $pdf = Pdf::loadView('admin.TransaksiSewa.invoice', compact('transaksi','orderDetail','order','newDate'));
        return $pdf->download('invoice_' . $transaksi->id . '.pdf');
    }


    public function reportSewa(){
        return view('admin.keuangan.reportSewa');
    }

    public function reportSewaShow(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $transaksi = TransaksiSewa::with('customer', 'order', 'order.details.product')
            ->whereMonth('tgl_pesanan', $month)
            ->whereYear('tgl_pesanan', $year)
            ->where('status','selesai')
            ->get();

         if ($transaksi->isEmpty()) {
                return redirect()->route('transaksi-sewa.reportSewa')->with('error', 'Tidak ada transaksi untuk bulan dan tahun yang dipilih.');
           }
        else{
            return view('admin.keuangan.reportShow', compact('transaksi', 'month', 'year'));
        }   


    }

    public function reportSewaCetak(Request $request){


        $month = $request->input('month');
        $year = $request->input('year');


        $transaksi = TransaksiSewa::with('customer', 'order', 'order.details.product')
            ->whereMonth('tgl_pesanan', $month)
            ->whereYear('tgl_pesanan', $year)
            ->get();

        // Preparing the data for the report
        $orderDetail = $transaksi->flatMap(function ($transaksi) {
            return $transaksi->order->details;
        });

        // Calculate the totals
        $totalSewa = $orderDetail->sum(function ($detail) {
            return $detail->product->harga_product * $detail->quantity;
        });
        $totalTambahan = $transaksi->sum(function ($transaksi) {
            return $transaksi->harga_hilang + $transaksi->harga_telat + $transaksi->harga_rusak;
        });
        $grandTotal = $totalSewa + $totalTambahan;


            $pdf = Pdf::loadView('admin.keuangan.PDFSewa',  [
                'month' => $month,
                'year' => $year,
                'orderDetail' => $orderDetail,
                'transaksi' => $transaksi,
                'totalSewa' => $totalSewa,
                'totalTambahan' => $totalTambahan,
                'grandTotal' => $grandTotal,
            ]);
            return $pdf->download('report_transaksi_sewa_' . $month . '_' . $year . '.pdf');  
    }
}
