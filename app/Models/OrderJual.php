<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderJual extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_customer',
        'id_product',
        'tgl_pesanan',
        'tgl_pembayaran',
        'total',
        'status',
        'status_payment',
        'note',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_customer');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function details()
    {
        return $this->hasMany(OrderJualDetail::class, 'order_id');
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiJual::class, 'id_order');
    }
}

