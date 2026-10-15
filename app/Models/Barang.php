<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = ['kode_barang', 'nama_barang', 'kategori_id', 'kode_kategori', 'harga', 'harga_modal', 'stok', 'satuan', 'deskripsi'];

    protected $casts = [
        'harga' => 'decimal:2',
        'harga_modal' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_barang)) {
                $latest = static::max('id') ?? 0;
                $model->kode_barang = 'BRG' . str_pad($latest + 1, 5, '0', STR_PAD_LEFT);
            }
            if (empty($model->kode_kategori) && $model->kategori_id) {
                $kategori = Kategori::find($model->kategori_id);
                $model->kode_kategori = $kategori->kode_kategori ?? null;
            }
        });
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Kategori::class);
    }

    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(\App\Models\DetailTransaksi::class);
    }
}