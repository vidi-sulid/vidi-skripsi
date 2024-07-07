<?php

use App\Models\Transaksi\AsetMutation;
use App\Models\Transaksi\Journal;
use App\Models\Transaksi\Loan;
use App\Models\Transaksi\LoanMutation;
use App\Models\Transaksi\SavingMutation;
use Illuminate\Support\Facades\Auth;


if (!function_exists('UpdateJournalSaving')) {

    function UpdateJournalSaving($invoice)
    {
        $mutations   = SavingMutation::where("invoice", $invoice)->get();
        $CashAccount = Auth::user()->rekening_kas;
        foreach ($mutations as $value) {
            $mutation = [
                "invoice"     => $value->invoice,
                "date"        => $value->date,
                "rekening"    => getName($value->savings->product_saving_id, "product_savings", "account_saving"),
                "description" => $value->description,
                "debit"       => $value->debit,
                "credit"      => $value->credit,
                "username"  => $value->username
            ];
            Journal::create($mutation);

            if ($value->cash == "K") {
                $mutation['rekening'] = $CashAccount;
                if ($value->debit > 0) {
                    $mutation['credit'] = $mutation['debit'];
                    unset($mutation['debit']);
                    Journal::create($mutation);
                } else {
                    $mutation['debit'] = $mutation['credit'];
                    unset($mutation['credit']);
                    Journal::create($mutation);
                }
            }
        }
    }
}

if (!function_exists('UpdateJournalLoan')) {
    function UpdateJournalLoan($invoice, $lcair = false)
    {
        $mutations   = LoanMutation::where("invoice", $invoice)->get();
        $CashAccount = Auth::user()->rekening_kas;
        foreach ($mutations as $value) {
            $mutation = [
                "invoice"     => $value->invoice,
                "date"        => $value->date,
                "rekening"    => getName($value->loans->product_loan_id, "product_loans", "account_loan"),
                "description" => $value->description,
                "debit"       => $value->debit,
                "credit"      => $value->credit,
                "username"  => $value->username
            ];
            Journal::create($mutation);

            if ($value->cash == "K") {
                $mutation['rekening'] = $CashAccount;
                if ($value->debit > 0) {
                    $mutation['credit'] = $mutation['debit'];
                    unset($mutation['debit']);
                    Journal::create($mutation);
                } else {
                    $mutation['debit'] = $mutation['credit'];
                    unset($mutation['credit']);
                    Journal::create($mutation);
                }
            }
        }
        if ($lcair) {
            $loan = Loan::where("invoice", $invoice)->first();
            if ($loan) {
                $mutation = array();
                $totalKas = $loan->stamp_duty + $loan->provision_fee + $loan->administration_fee;
                if ($loan->stamp_duty > 0) {
                    $mutation[] =
                        [
                            "invoice"     => $loan->invoice,
                            "date"        => $loan->date_open,
                            "rekening"    => getName($loan->product_loan_id, "product_loans", "account_dutystamp"),
                            "description" => "Materai " . $loan->description,
                            "debit"       => 0,
                            "credit"      => $loan->stamp_duty,
                            "username"  => $loan->username
                        ];
                }
                if ($loan->administration_fee > 0) {
                    $mutation[] =  [
                        "invoice"     => $loan->invoice,
                        "date"        => $loan->date_open,
                        "rekening"    => getName($loan->product_loan_id, "product_loans", "account_income_interest"),
                        "description" => "Administrasi " . $loan->description,
                        "debit"       => 0,
                        "credit"      => $loan->administration_fee,
                        "username"  => $loan->username
                    ];
                }
                if ($loan->provision_fee > 0) {
                    $mutation[] =   [
                        "invoice"     => $loan->invoice,
                        "date"        => $loan->date_open,
                        "rekening"    => getName($loan->product_loan_id, "product_loans", "account_income_interest"),
                        "description" => "Provisi " . $loan->description,
                        "debit"       => 0,
                        "credit"      => $loan->provision_fee,
                        "username"  => $loan->username
                    ];
                }

                if ($totalKas > 0) {
                    $mutation[] =   [
                        "invoice"     => $loan->invoice,
                        "date"        => $loan->date_open,
                        "rekening"    => $CashAccount,
                        "description" => "Provisi " . $loan->description,
                        "debit"       => $totalKas,
                        "credit"      => 0,
                        "username"  => $loan->username
                    ];
                    Journal::insert($mutation);
                }
            }
        }
    }
}

if (!function_exists('UpdAset')) {
    function UpdAset($invoice)
    {
        $vaMutasi = AsetMutation::with(['asets'])->where("invoice", $invoice)->get();
        foreach ($vaMutasi as $key => $value) {
            $mutation = [
                "invoice"     => $value->invoice,
                "date"        => $value->date,
                "rekening"    => getName($value->asets->product_asset_id, "product_asets", "account_aset", "id"),
                "description" => $value->description,
                "debit"       => $value->debit_price,
                "credit"      => $value->credit_price,
                "username"  => $value->username
            ];
            Journal::create($mutation);
            if ($mutation['debit'] > 0) {
                $mutation['credit'] = $mutation['debit'];
                unset($mutation['debit']);
            } else {
                $mutation['debit'] = $mutation['credit'];
                unset($mutation['credit']);
            }
            $mutation['rekening'] = Auth::user()->rekening_kas;
            Journal::create($mutation);
        }
    }
}
