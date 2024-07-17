<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\TransaksiSewa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'id_product',
        'tgl_pesanan',
        'tgl_kembali',
        'total',
        'status',
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
        return $this->hasMany(OrderDetail::class);
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiSewa::class);
    }
}
