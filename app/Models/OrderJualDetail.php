<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderJualDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price'
    ];

    public function order()
    {
        return $this->belongsTo(OrderJual::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
