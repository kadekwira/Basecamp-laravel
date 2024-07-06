<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiSewa extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_customer',
        'id_product',
        'jumlah',
        'harga_product',
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

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
