<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $fillable = [
        'aktifitas',
        'jenis',
        'nominal',
        'saldo',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'saldo' => 'decimal:2',
    ];
}