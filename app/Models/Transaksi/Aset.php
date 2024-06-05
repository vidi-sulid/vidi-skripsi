<?php

namespace App\Models\Transaksi;

use App\Models\Master\ProductAset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(ProductAset::class, 'product_asset_id', 'id');
    }
}
