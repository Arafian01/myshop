<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'jumlah',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stock',
        'description',
        'image'
    ];

    protected $table = 'produk';

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'category_id', 'id');
    }
}
