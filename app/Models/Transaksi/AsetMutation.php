<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetMutation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function asets()
    {
        return $this->belongsTo(Aset::class, 'asset_id', 'code');
    }
}
