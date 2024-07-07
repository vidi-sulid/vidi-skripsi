<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanMutation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function loans()
    {
        return $this->belongsTo(Loan::class, 'rekening', 'rekening');
    }
}