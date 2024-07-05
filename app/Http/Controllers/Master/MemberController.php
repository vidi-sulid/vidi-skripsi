<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Master\Member;
use App\Models\Master\Saving;
use App\Models\Transaksi\SavingMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('productloan_write'), 403);
        log_custom("Buka menu tambah master pinjaman");
        $data = Template::get("datatable");


        array_push($data['pilihCss'],  "stepper", "form-validation");
        array_push($data['pilihJs'],   "stepper", "form-validation", "form-validation1", "form-validation2");

        $data['jsTambahan'] = "
        ";
        return view('master.member_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('create_anggota'), 403);
        $request->validate([
            'Name'     => 'required',
            'BornDate' => 'required',
            'IdentityCardNumber' => 'required|unique:members,IdentityCardNumber',
        ]);
        $data                     = $request->all();
        $golonganWajib            = $data['saving_mandatory'];
        $golonganPokok            = $data['saving_principal'];
        $data['Code']             = getLastMemberCode();
        $data['created_by']       = Auth::user()->name;
        $data['PrincipalAmount']  = filter_var($data['PrincipalAmount'], FILTER_SANITIZE_NUMBER_INT);
        $data['MandatoryAmount']  = filter_var($data['MandatoryAmount'], FILTER_SANITIZE_NUMBER_INT);
        $data['PrincipalAccount'] = implode('.', [01, $golonganPokok, $data['Code']]);
        $data['MandatoryAccount'] = implode('.', [01, $golonganWajib, $data['Code']]);
        unset($data['saving_mandatory']);
        unset($data['saving_principal']);
        Member::create($data);

        $vaRekening = [
            "rekening" => $data['MandatoryAccount'],
            "date_open" => date("Y-m-d"),
            "product_saving_id" => $golonganWajib,
            "member_code" => $data['Code'],
            "username" => Auth::user()->name
        ];
        Saving::create($vaRekening);
        $vaRekening['product_saving_id'] = $golonganPokok;
        $vaRekening['rekening'] = $data['PrincipalAccount'];

        Saving::create($vaRekening);
        //Update Transaction Principal Account
        $mutation = [
            "invoice"         => invoice("SPA", true),
            "date"            => $data['Date'],
            "rekening"        => $data['PrincipalAccount'],
            "codetransaction" => '01',
            "description"     => "Setoran Awal Anggota an. " . $data['Name'],
            "debit"           => 0,
            "credit"          => $data['PrincipalAmount'],
            "username"        => Auth::user()->name,
            "cash"            => 'K'
        ];
        SavingMutation::create($mutation);

        // //Update Transaction Mandatory Account
        $mutation['rekening'] = $data['MandatoryAccount'];
        $mutation['credit']   = $data['MandatoryAmount'];
        SavingMutation::create($mutation);

        UpdateJournalSaving($mutation['invoice']);
        // logUser("Register Data Anggota", $data);
        return response()->json("ok");
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
