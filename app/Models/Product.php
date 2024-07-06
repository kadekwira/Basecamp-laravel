<?php

namespace App\Models;

use App\Models\Order;
use App\Models\TransaksiSewa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_product',
        'harga_product',
        'harga_hilang',
        'harga_telat',
        'harga_rusak',
        'status',
        'image',
        'stock',
        'type'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_product');
    }
    public function transaksi()
    {
        return $this->hasMany(TransaksiSewa::class, 'id_product');
    }
}
