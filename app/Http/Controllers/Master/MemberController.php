<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Library\Member as LibraryMember;
use App\Library\Template;
use App\Models\Master\Member;
use App\Models\Master\Saving;
use App\Models\Transaksi\SavingMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

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
        log_custom("Buka menu tambah master anggota");
        $data = Template::get();

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
            'saving_mandatory' => 'required',
            'saving_principal' => 'required',
        ]);
        $data                     = $request->all();
        $golonganWajib            = $data['saving_mandatory'];
        $golonganPokok            = $data['saving_principal'];
        $data['Code']             = getLastMemberCode();
        $data['username']         = Auth::user()->name;

        $data['PrincipalAmount']  = getName($golonganPokok, "product_savings", "principal_deposit"); //filter_var($data['PrincipalAmount'], FILTER_SANITIZE_NUMBER_INT);
        $data['MandatoryAmount']  = getName($golonganWajib, "product_savings", "mandatory_deposit"); //filter_var($data['MandatoryAmount'], FILTER_SANITIZE_NUMBER_INT);
        $data['PrincipalAccount'] = implode('.', ["01", $golonganPokok, $data['Code']]);
        $data['MandatoryAccount'] = implode('.', ["01", $golonganWajib, $data['Code']]);
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
        log_custom("Simpan data anggota", $data);
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
    public function edit(Member $member)
    {
        abort_if(Gate::denies('member_update'), 403);

        log_custom("Buka menu edit master anggota " . $member->id);
        $data = Template::get();

        array_push($data['pilihCss'],  "stepper", "form-validation");
        array_push($data['pilihJs'],   "stepper", "form-validation", "form-validation1", "form-validation2");


        $data['member'] = $member;
        return view('master.member_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        abort_if(Gate::denies('member_update'), 403);

        $request->validate([
            'Name'     => 'required',
            'BornDate' => 'required',
            'IdentityCardNumber' => ['required',  Rule::unique('members', 'IdentityCardNumber')->ignore($member->id)],
        ]);

        log_custom("Update data member" . $member->id, $member->toArray());
        $member->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        abort_if(Gate::denies('member_delete'), 403);

        $tgl = getTgl();
        $saving = Saving::where("member_code", $member->code)->get();
        $faktur = invoice("TTA", true);
        $vaUpdate = array("date_close" => $tgl);
        foreach ($saving as $value) {
            $saldo = LibraryMember::saldoSimpanan($value->rekening, $tgl);

            if ($saldo > 0) {
                $mutation = [
                    "invoice"         => $faktur,
                    "date"            => $tgl,
                    "rekening"        => $value->rekening,
                    "codetransaction" => '01',
                    "description"     => "Penutupan anggota " . $member->name,
                    "debit"           => $saldo,
                    "credit"          => 0,
                    "username"        => Auth::user()->name,
                    "cash"            => 'K'
                ];
                SavingMutation::create($mutation);
                Saving::where("rekening", $value->rekening)->update($vaUpdate);
            }
        }
        UpdateJournalSaving($faktur);
        log_custom("Penutupan Anggota", $member->toArray());
        // $member->date_close = $tgl;
        $member->update($vaUpdate);
        return response()->json("ok");
        // $productLoan->delete();
        //
    }
}
