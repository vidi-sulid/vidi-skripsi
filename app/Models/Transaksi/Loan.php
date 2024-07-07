<?php

namespace App\Models\Transaksi;

use App\Models\Master\Member;
use App\Models\Master\ProductLoan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function member()
    {
        return $this->belongsTo(Member::class, "member_code", "code");
    }

    public function mutations()
    {
        return $this->hasMany(LoanMutation::class, "rekening", "rekening");
    }
    public function getTotalMutationAmountAttribute()
    {
        return $this->mutations()->sum('debit');
    }
}