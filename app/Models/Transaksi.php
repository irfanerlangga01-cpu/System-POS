<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = ['kode_transaksi', 'tanggal', 'total', 'user_id'];

    protected $casts = [
        'tanggal' => 'date',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_transaksi)) {
                $latest = static::max('id') ?? 0;
                $model->kode_transaksi = 'TRX' . str_pad($latest + 1, 6, '0', STR_PAD_LEFT);
            }
            if (empty($model->tanggal)) {
                $model->tanggal = now();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(\App\Models\DetailTransaksi::class);
    }

    public function piutangs(): HasMany
    {
        return $this->hasMany(\App\Models\Piutang::class);
    }
}