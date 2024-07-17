<?php

namespace App\Http\Controllers;

use App\Models\OrderJual;
use Illuminate\Http\Request;
use App\Models\TransaksiJual;
use App\Models\OrderJualDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;

class TransaksiJualController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = TransaksiJual::with('customer')->get();
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
                    $cetak = '<a href="' . route('transaksi-jual.cetak', $row->id) . '" class="btn btn-icon btn-info"><i class="fas fa-print"></i></a>';

                    return '<div class="d-flex justify-content-center">' . $cetak . '</div>';
                })
                ->rawColumns(['status', 'status_payment', 'action', 'id_customer', 'id_product'])
                ->make(true);
        }

        return view('admin.TransaksiJual.index');
    }

    public function cetak($id)
    {
        $transaksi = TransaksiJual::findOrFail($id);
        $order = OrderJual::where('id', $transaksi->id_order)->with('customer')->get();
        $orderDetail = OrderJualDetail::where('order_id',$transaksi->id_order)->with('product')->get();
        $dateString = $transaksi->created_at;
        $newDate = date("F d, Y", strtotime($dateString));

        $pdf = Pdf::loadView('admin.TransaksiJual.invoice', compact('transaksi','orderDetail','order','newDate'));
        return $pdf->download('invoice_' . $transaksi->id . '.pdf');
    }

    public function reportJual(){
        return view('admin.keuangan2.reportJual');
    }

    public function reportJualShow(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $transaksi = TransaksiJual::with('customer', 'order')
            ->whereMonth('tgl_pesanan', $month)
            ->whereYear('tgl_pesanan', $year)
            ->where('status','selesai')
            ->get();

         if ($transaksi->isEmpty()) {
                return redirect()->route('transaksi-jual.reportJual')->with('error', 'Tidak ada transaksi untuk bulan dan tahun yang dipilih.');
           }
        else{
            return view('admin.keuangan2.reportShow', compact('transaksi', 'month', 'year'));
        }   

    }

    public function reportJualCetak(Request $request) {
        $month = $request->input('month');
        $year = $request->input('year');
    
        $transaksi = TransaksiJual::with('customer', 'order.details.product')
            ->whereMonth('tgl_pesanan', $month)
            ->whereYear('tgl_pesanan', $year)
            ->get();
    
  
        $orderDetails = $transaksi->flatMap(function ($transaksi) {
            return $transaksi->order->details->map(function ($detail) use ($transaksi) {
                return [
                    'customer_name' => $transaksi->customer->name,
                    'product_name' => $detail->product->nama_product,
                    'quantity' => $detail->quantity,
                    'price' => $detail->product->harga_product,
                    'total' => $detail->product->harga_product * $detail->quantity,
                ];
            });
        });
    

        $grandTotal = $orderDetails->sum('total');
    
        $pdf = Pdf::loadView('admin.keuangan2.PDFJual', [
            'month' => $month,
            'year' => $year,
            'orderDetails' => $orderDetails,
            'grandTotal' => $grandTotal,
        ]);
    

        return $pdf->download('report_transaksi_jual_' . $month . '_' . $year . '.pdf');  
    }
    
}
