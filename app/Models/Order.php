<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'id_product',
        'jumlah',
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
}
