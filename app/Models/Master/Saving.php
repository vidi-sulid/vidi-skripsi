<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function member()
    {
        return $this->belongsTo(Member::class, "member_code", "code");
    }
    public function product()
    {
        return $this->belongsTo(ProductSaving::class, "product_saving_id", "code");
    }
}
