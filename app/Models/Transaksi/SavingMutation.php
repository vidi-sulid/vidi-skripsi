<?php

namespace App\Models\Transaksi;

use App\Models\Master\Saving;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingMutation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function savings()
    {
        return $this->belongsTo(Saving::class, 'rekening', 'rekening');
    }
}
