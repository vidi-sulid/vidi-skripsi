<?php

namespace App\Models\System;

use App\Models\System\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $with = ['currency'];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'default_currency_id', 'id');
    }
}
