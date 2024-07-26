<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Library\Member;
use App\Library\Template;
use App\Models\Transaksi\LoanMutation;
use App\Models\Transaksi\SavingMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('productloan_read'), 403);
        log_custom("Buka menu kasir");
        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#cashier').addClass('active');
        ";
        return view("transaksi.cashier", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('cashier_write'), 403);

        $data = $request->all();
        if ($data['rekening'] == "") {
            return response()->json([
                'info' => 'The code field is required.',
                'errors' => [
                    'error' => ['Rekening tidak boleh kosong']
                ]
            ], 422);
        }
        $data['credit']  = filter_var($data['credit'], FILTER_SANITIZE_NUMBER_INT);

        if ($data['description'] == "") {
            return response()->json([
                'info' => 'The code field is required.',
                'errors' => [
                    'error' => ['Keterangan tidak boleh kosong']
                ]
            ], 422);
        }

        if ($data['type'] == "loan") {
            $bakidebet = Member::bakidebet($data['rekening'], getTgl());
            if ($data['credit'] > $bakidebet) {
                return response()->json([
                    'info' => 'The code field is required.',
                    'errors' => [
                        'error' => ['Pembayaran pokok tidak boleh melebihi sisa pinjaman']
                    ]
                ], 422);
            }
            if ($data['credit'] <= 0 && $data['credit_interest'] <= 0) {
                return response()->json([
                    'info' => 'The code field is required.',
                    'errors' => [
                        'error' => ['Pokok dan Bunga tidak boleh 0']
                    ]
                ], 422);
            }
        } else if ($data['type'] == "saving") {
            if ($data['credit'] > 0  && $data['debit'] > 0) {
                return response()->json([
                    'info' => 'The code field is required.',
                    'errors' => [
                        'error' => ['Setoran dan Penarikan tidak boleh berisi lebih dari 0']
                    ]
                ], 422);
            }

            $saldo = Member::saldoSimpanan($data['rekening'], getTgl());
            if ($data['debit'] > $saldo && $data['debit'] > 0) {
                return response()->json([
                    'info' => 'The code field is required.',
                    'errors' => [
                        'error' => ['Penarikan tidak boleh melebihi saldo simpanan']
                    ]
                ], 422);
            }
        }
        if ($data['type'] == "loan") {
            $data['invoice'] = invoice("AGP", true);
            $mutation = [
                "status"          => 0,
                "invoice"         => $data['invoice'],
                "date"            => getTgl(),
                "rekening"        => $data['rekening'],
                "description"     => $data['description'],
                "credit"          => $data['credit'],
                "credit_interest" => $data['credit_interest'],
                "username"        => Auth::user()->name,
                "cash"            => 'K'
            ];
            LoanMutation::create($mutation);
            UpdateJournalLoan($data['invoice']);
        } else if ($data['type'] == "saving") {
            $data['invoice'] = invoice("STA", true);
            $mutation = [
                "invoice"         => $data['invoice'],
                "date"            => getTgl(),
                "rekening"        => $data['rekening'],
                "codetransaction" => 0,
                "description"     => $data['description'],
                "credit"          => $data['credit'],
                "debit"           => $data['debit'],
                "username"        => Auth::user()->name,
                "cash"            => 'K'
            ];
            SavingMutation::create($mutation);
            UpdateJournalSaving($data['invoice']);
        }
        log_custom("Simpan menu kasir", $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
