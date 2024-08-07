<?php

namespace App\Http\Controllers\Transaksi;

use App\DataTables\AsetDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Transaksi\Aset;
use App\Models\Transaksi\AsetMutation;
use App\Models\Transaksi\Journal;
use App\Models\Transaksi\LoanMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AsetDataTable $dataTable)
    {
        abort_if(Gate::denies('aset_read'), 403);
        log_custom("Buka menu transaksi pembelian aset");
        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#aset').addClass('active');
        $('#transaksi').addClass('open active');
        ";
        return $dataTable->render("transaksi/aset", $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('aset_write'), 403);
        log_custom("Buka menu tambah pembelian aset");
        return view('transaksi.aset_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('aset_write'), 403);

        $request->merge(['price' => convertRupiahToNumber($request->price), 'residual_value' => convertRupiahToNumber($request->residual_value)]);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'depreciation_period' => 'required|numeric|min:0.01'
        ]);

        $invoice = invoice("PAS", true);
        $data = $request->all();
        $max_id = Aset::max('id');
        $data['invoice'] = $invoice;
        $data['purchase_date'] =  getTgl();
        $data['username'] = Auth::user()->name;
        $data['code'] = str_pad($max_id ? $max_id + 1 : 1, 6, '0', STR_PAD_LEFT);
        log_custom("Insert data pembelian aset", $data);
        Aset::create($data);

        $vaMutasi = array(
            "invoice" => $invoice,
            "asset_id" => $data['code'],
            "date" => $data['purchase_date'],
            "username" => $data['username'],
            "description" => "Pembelian aset " . $data['name'],
            "debit_price" => $data['price'],
            "debit_book_value" => $data['price']
        );
        AsetMutation::create($vaMutasi);
        UpdAset($invoice);
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
    public function edit(Aset $aset)
    {
        abort_if(Gate::denies('aset_update'), 403);
        log_custom("Buka menu edit aset " . $aset->id);
        $data['data'] = $aset;
        return view('transaksi.aset_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aset $aset)
    {
        abort_if(Gate::denies('loan_update'), 403);
        if ($aset->purchase_date != getTgl()) {
            return response()->json([
                'info' => 'The code field is required.',
                'errors' => [
                    'error' => ['Data sudah tidak bisa diedit.' . $aset->purchase_date]
                ]
            ], 422);
        }
        $request->merge(['price' => convertRupiahToNumber($request->price), 'residual_value' => convertRupiahToNumber($request->residual_value)]);


        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'depreciation_period' => 'required|numeric|min:0.01'
        ]);
        $data = $request->all();
        $data['username'] = Auth::user()->name;
        $vaMutasi = array(
            "invoice" => $aset->invoice,
            "asset_id" => $aset->code,
            "date" => $aset->purchase_date,
            "username" => $data['username'],
            "description" => "Pembelian aset " . $data['name'],
            "debit_price" => $data['price'],
            "debit_book_value" => $data['price']
        );

        $aset->update($data);
        AsetMutation::where("invoice", $aset->invoice)->update($vaMutasi);
        UpdAset($aset->invoice);
        log_custom("Update data  aset " . $aset->id, $aset->toArray());


        return response()->json($aset, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aset $aset)
    {
        abort_if(Gate::denies('aset_delete'), 403);
        if ($aset->purchase_date != getTgl()) {
            return response()->json([
                'info' => 'The code field is required.',
                'errors' => [
                    'error' => ['Data sudah tidak bisa diedit.']
                ]
            ], 422);
        }
        Journal::where("invoice", $aset->invoice)->delete();
        AsetMutation::where("invoice", $aset->invoice)->delete();
        $aset->delete();
        log_custom("Hapus data aset" . $aset->id, $aset->toArray());
        return response()->json("ok");
    }
}