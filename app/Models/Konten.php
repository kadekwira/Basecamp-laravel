<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;
    protected $fillable=[
        'nama_konten',
        'jadwal_post',
        'jadwal_end',
        'url',
        'type',
    ];
}
