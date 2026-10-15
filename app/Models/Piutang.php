<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    protected $fillable = [
        'transaksi_id',
        'no_member',
        'nama_pelanggan',
        'no_hp',
        'jumlah',
        'status',
        'tanggal',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal' => 'date',
    ];
}