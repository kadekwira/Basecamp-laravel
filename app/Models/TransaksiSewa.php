<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiSewa extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_customer',
        'id_order',
        'total_sewa_awal',
        'harga_hilang',
        'harga_telat',
        'harga_rusak',
        'tgl_pesanan',
        'tgl_kembali',
        'total',
        'status',
        'status_payment',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_customer');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
