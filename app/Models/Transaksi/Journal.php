<?php

namespace App\Models\Transaksi;

use App\Models\Master\Coa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function coa()
    {
        return $this->belongsTo(Coa::class, 'rekening', 'code');
    }
}
