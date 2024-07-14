<?php

namespace App\Http\Controllers\Transaksi;

use App\DataTables\LoanDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Master\Member;
use App\Models\Transaksi\Journal;
use App\Models\Transaksi\Loan;
use App\Models\Transaksi\LoanMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LoanDataTable $dataTable)
    {
        abort_if(Gate::denies('productloan_read'), 403);
        log_custom("Buka menu master pinjaman");
        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#loan').addClass('active');
        ";
        return $dataTable->render("transaksi.loan", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('loann_write'), 403);
        log_custom("Buka menu tambah pinjaman");
        return view('transaksi.loan_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('aset_write'), 403);

        $request->merge([
            'loan_amount' => convertRupiahToNumber($request->loan_amount), 'administration_fee' => convertRupiahToNumber($request->administration_fee),
            'provision_fee' => convertRupiahToNumber($request->provision_fee), 'stamp_duty' => convertRupiahToNumber($request->stamp_duty)
        ]);

        $request->validate([
            'product_loan_id' => 'required',
            'member_code' => 'required',
            'provision_fee' => 'required|numeric',
            'stamp_duty' => 'required|numeric',
            'administration_fee' => 'required|numeric',
            'loan_amount' => 'required|numeric|min:0.01',
            'loan_term' => 'required|numeric|min:0.01'
        ]);

        $data = $request->all();
        $data['member_code'] = str_pad($data['member_code'], "7", "0", STR_PAD_LEFT);
        $data['invoice'] = invoice("PJA", true);
        $data['username']  =  Auth::user()->name;
        $data['rekening'] = getRekeningLoan($data['member_code'], $data['product_loan_id']);
        Loan::create($data);

        $member = Member::where("code", $data['member_code'])->first();


        $mutation = [
            "status"  => 0,
            "invoice"         => $data['invoice'],
            "date"            => date("Y-m-d"),
            "rekening"        => $data['rekening'],
            "description"     => "Pencairan Pinjaman Anggota an. " . $member->name,
            "credit"           => 0,
            "debit"          => $data['loan_amount'],
            "username"        => Auth::user()->name,
            "cash"            => 'K'
        ];
        LoanMutation::create($mutation);

        UpdateJournalLoan($mutation['invoice'], true);
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
    public function edit(Loan $loan)
    {
        abort_if(Gate::denies('loan_update'), 403);
        log_custom("Buka menu edit master pinjaman " . $loan->id);
        $data['loan'] = $loan;
        return view('transaksi.loan_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        abort_if(Gate::denies('loan_update'), 403);

        if ($loan->date_open != getTgl()) {
            return response()->json([
                'info' => 'The code field is required.',
                'errors' => [
                    'error' => ['Data sudah tidak bisa diedit.']
                ]
            ], 422);
        }
        $request->merge([
            'loan_amount' => convertRupiahToNumber($request->loan_amount), 'administration_fee' => convertRupiahToNumber($request->administration_fee),
            'provision_fee' => convertRupiahToNumber($request->provision_fee), 'stamp_duty' => convertRupiahToNumber($request->stamp_duty)
        ]);

        $request->validate([
            'provision_fee' => 'required|numeric',
            'stamp_duty' => 'required|numeric',
            'administration_fee' => 'required|numeric',
            'loan_amount' => 'required|numeric|min:0.01',
            'loan_term' => 'required|numeric|min:0.01'
        ]);

        log_custom("Update data  pinjaman " . $loan->id, $loan->toArray());
        $loan->update($request->all());


        UpdateJournalLoan($loan->invoice, true);
        return response()->json($loan, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        abort_if(Gate::denies('loan_delete'), 403);
        if ($loan->date_open != getTgl()) {
            return response()->json([
                'info' => 'The code field is required.',
                'errors' => [
                    'error' => ['Data sudah tidak bisa diedit.']
                ]
            ], 422);
        }
        Journal::where("invoice", $loan->invoice)->delete();
        LoanMutation::where("invoice", $loan->invoice)->delete();
        $loan->delete();
        log_custom("Hapus data " . $loan->id, $loan->toArray());
        return response()->json("ok");
    }
}
