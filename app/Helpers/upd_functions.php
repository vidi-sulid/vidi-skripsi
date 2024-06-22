<?php

use App\Models\Transaksi\AsetMutation;
use App\Models\Transaksi\Journal;

if (!function_exists('UpdAseSt')) {
    function UpdAseSt($invoice)
    {
        $vaMutasi = AsetMutation::with(['asets'])->where("invoice", $invoice)->get();
        foreach ($vaMutasi as $key => $value) {
            $mutation = [
                "invoice"     => $value->invoice,
                "date"        => $value->date,
                "rekening"    => getName($value->asets->product_asset_id, "product_asets", "account_aset"),
                "description" => $value->description,
                "debit"       => $value->debit_price,
                "credit"      => $value->credit_price,
                "created_by"  => $value->username
            ];
            Journal::create($mutation);
        }
    }
}
