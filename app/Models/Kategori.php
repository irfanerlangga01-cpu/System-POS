<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['kode_kategori', 'nama_kategori', 'deskripsi'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_kategori)) {
                $latest = static::max('id') ?? 0;
                $model->kode_kategori = 'KTG' . str_pad($latest + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function barang(): HasMany
    {
        return $this->hasMany(\App\Models\Barang::class);
    }
}