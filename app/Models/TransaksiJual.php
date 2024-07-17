<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiJual extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_customer',
        'id_order',
        'tgl_pesanan',
        'tgl_payment',
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
        return $this->belongsTo(OrderJual::class, 'id_order');
    }
}
